importScripts('/src/js/idb.js');
importScripts('/src/js/utility.js');

var CACHE_STATIC_NAME = 'static-v1';
var CACHE_DYNAMIC_NAME = 'dynamic-v1';
var STATIC_FILES = [
    '/',
    '/index.html',
    '/offline.html',
];

// function trimCache(cacheName, maxItems) {
//   caches.open(cacheName)
//     .then(function (cache) {
//       return cache.keys()
//         .then(function (keys) {
//           if (keys.length > maxItems) {
//             cache.delete(keys[0])
//               .then(trimCache(cacheName, maxItems));
//           }
//         });
//     })
// }

self.addEventListener('install', function (event) {
    console.log('[Service Worker] Installing Service Worker ...', event);
    event.waitUntil(
        caches.open(CACHE_STATIC_NAME).then(function (cache) {
            console.log('[Service Worker] Precaching App Shell');
            cache.addAll(STATIC_FILES);
        })
    )
});

self.addEventListener('activate', function (event) {
    console.log('[Service Worker] Activating Service Worker ....', event);
    event.waitUntil(
        caches.keys().then(function (keyList) {
            return Promise.all(keyList.map(function (key) {
                if (key !== CACHE_STATIC_NAME && key !== CACHE_DYNAMIC_NAME) {
                    console.log('[Service Worker] Removing old cache.', key);
                    return caches.delete(key);
                }
            }));
        })
    );
    return self.clients.claim();
});

function isInArray(string, array) {
    var cachePath;
    if (string.indexOf(self.origin) === 0) { // request targets domain where we serve the page from (i.e. NOT a CDN)
        console.log('matched ', string);
        cachePath = string.substring(self.origin.length); // take the part of the URL AFTER the domain (e.g. after localhost:8080)
    } else {
        cachePath = string; // store the full request (for CDNs)
    }
    return array.indexOf(cachePath) > -1;
}

self.addEventListener('fetch', function (event) {
    var url = 'https://pwagram-99adf.firebaseio.com/posts';
    if (event.request.url.indexOf(url) > -1) {
        event.respondWith(
            fetch(event.request).then(function (res) {
                var clonedRes = res.clone();
                clearAllData('posts').then(function () {
                    return clonedRes.json();
                }).then(function (data) {
                    for (var key in data) {
                        writeData('posts', data[key])
                    }
                });
                return res;
            })
        );
    } else if (isInArray(event.request.url, STATIC_FILES)) {
        event.respondWith(
            caches.match(event.request)
        );
    } else {
        event.respondWith(
            caches.match(event.request).then(function (response) {
                if (response) {
                    return response;
                } else {
                    return fetch(event.request).then(function (res) {
                        return caches.open(CACHE_DYNAMIC_NAME).then(function (cache) {
                            // trimCache(CACHE_DYNAMIC_NAME, 3);
                            cache.put(event.request.url, res.clone());
                            return res;
                        })
                    }).catch(function (err) {
                        return caches.open(CACHE_STATIC_NAME).then(function (cache) {
                            if (event.request.headers.get('accept').includes('text/html')) {
                                return cache.match('/offline.html');
                            }
                        });
                    });
                }
            })
        );
    }
});

self.addEventListener('sync', function(event) {
    console.log('[Service Worker] Background syncing', event);
    if (event.tag === 'sync-new-posts') {
        console.log('[Service Worker] Syncing new Posts');
        event.waitUntil(
            readAllData('sync-posts').then(function(data) {
                for (var dt of data) {
                    fetch('https://us-central1-pwagram-99adf.cloudfunctions.net/storePostData', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            id: dt.id,
                            title: dt.title,
                            location: dt.location,
                            image: 'https://firebasestorage.googleapis.com/v0/b/pwagram-99adf.appspot.com/o/sf-boat.jpg?alt=media&token=19f4770c-fc8c-4882-92f1-62000ff06f16'
                        })
                    }).then(function(res) {
                        console.log('Sent data', res);
                        if (res.ok) {
                          res.json()
                            .then(function(resData) {
                              deleteItemFromData('sync-posts', resData.id);
                            });
                        }
                    }).catch(function(err) {
                        console.log('Error while sending data', err);
                    });
                }
            })
        );
    }
});

self.addEventListener('notificationclick', function(event) {
    var notification = event.notification;
    var action = event.action;

    console.log(notification);

    if (action === 'confirm') {
        console.log('Confirm was chosen');
        notification.close();
    } else {
        console.log(action);
        notification.close();
    }
});

self.addEventListener('notificationclose', function(event) {
    console.log('Notification was closed', event);
});

self.addEventListener('push', function(event) {
    console.log('Push Notification received', event);

    var data = {title: 'New!', content: 'Something new happened!'};

    if (event.data) {
        data = JSON.parse(event.data.text());
    }

    var options = {
        body: data.content,
        icon: '/src/images/icons/app-icon-96x96.png',
        badge: '/src/images/icons/app-icon-96x96.png'
    };

    event.waitUntil(
        self.registration.showNotification(data.title, options)
    );
});