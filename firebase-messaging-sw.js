// Import and configure the Firebase SDK
// These scripts are made available when the app is served or deployed on Firebase Hosting
// If you do not serve/host your project using Firebase Hosting see https://firebase.google.com/docs/web/setup
//importScripts('/__/firebase/5.5.6/firebase-app.js');
//importScripts('/__/firebase/5.5.6/firebase-messaging.js');
//importScripts('/__/firebase/init.js');

//var messaging = firebase.messaging();

/**
 * Here is is the code snippet to initialize Firebase Messaging in the Service
 * Worker when your app is not hosted on Firebase Hosting.
**/
 // [START initialize_firebase_in_sw]
 // Give the service worker access to Firebase Messaging.
 // Note that you can only use Firebase Messaging here, other Firebase libraries
 // are not available in the service worker.
 importScripts('https://www.gstatic.com/firebasejs/5.7.1/firebase-app.js');
 importScripts('https://www.gstatic.com/firebasejs/5.7.1/firebase-messaging.js');

 // Initialize the Firebase app in the service worker by passing in the
 // messagingSenderId.
 firebase.initializeApp({
   'messagingSenderId': '741998138956'
 });

 // Retrieve an instance of Firebase Messaging so that it can handle background
 // messages.
 const messaging = firebase.messaging();
 // [END initialize_firebase_in_sw]


// If you would like to customize notifications that are received in the
// background (Web app is closed or not in browser focus) then you should
// implement this optional method.
// [START background_handler]
/*messaging.setBackgroundMessageHandler(function(payload) {
  console.log('[firebase-messaging-sw.js] Received background message ', payload);
  // Customize notification here
  var notificationTitle = 'Background Message Title';
  var notificationOptions = {
    body: 'Background Message body.',
    icon: '/firebase-logo.png'
  };

  return self.registration.showNotification(notificationTitle, notificationOptions);
});*/

// [END background_handler]
self.addEventListener('push', function(event) {
    console.log('Push Notification received', event.data.text());
  
    var data = {};
  
    //var data = event.data.text();
    if (event.data) {
      data = JSON.parse(event.data.text());
    }
    //console.log(data.notification);
    //console.log(data);
  
    var options = {
      body: data.notification.body,
      icon: data.notification.icon,
      badge: data.notification.icon
    };
    console.log("options data:",options);
  
    event.waitUntil(
      self.registration.showNotification(data.notification.title, options)
    );
});

var CACHE_STATIC_NAME = 'static-v7';
var CACHE_DYNAMIC_NAME = 'dynamic-v7';

var STATIC_FILES = [
    'https://simola.herokuapp.com/manifest.json',
    'https://simola.herokuapp.com/assets/logo/SIM_1.png'
];

var DYNAMIC_FILES_NOT_SAFE = [
  'https://ucarecdn.com',
  'https://upload.uploadcare.com',
  'https://simolasocket-nodejs.herokuapp.com',
  'https://www.dropbox.com',
];

var DYNAMIC_NOT_SAFE = [ // link save data
  'https://simola.herokuapp.com/index.php/User/getViewDashboard',
  'https://simola.herokuapp.com/index.php/User/dashboard',
  'https://simola.herokuapp.com/index.php/User/getViewDropbox',
  'https://simola.herokuapp.com/index.php/User/getViewEditProfil',
  'https://simola.herokuapp.com/index.php/User/logout',
  'https://simola.herokuapp.com/index.php/DataUser/saveEditProfil',
  'https://simola.herokuapp.com/index.php/DataUser/getDevice',
  'https://simola.herokuapp.com/index.php/DataUser/offDevice',
  'https://simola.herokuapp.com/index.php/DataUser/deleteUser',
  'https://simola.herokuapp.com/index.php/DataUser/getDataEditUser',
  'https://simola.herokuapp.com/index.php/DataUser/saveEditUser',
  'https://simola.herokuapp.com/index.php/DataUser/inputUser',
  'https://simola.herokuapp.com/index.php/DataUser/saveEditUser',
  'https://simola.herokuapp.com/index.php/DataUser/removeATDevice',
  'https://simola.herokuapp.com/index.php/DataUser/editFingerPrint',
  'https://simola.herokuapp.com/index.php/DataUser/addFingerPrint',
  'https://simola.herokuapp.com/index.php/DataUser/submitUserLogin',
  'https://simola.herokuapp.com/index.php/user/getViewDashboard',
  'https://simola.herokuapp.com/index.php/user/getViewUser',
  'https://simola.herokuapp.com/index.php/user/getViewEditProfil',
  'https://simola.herokuapp.com/index.php/user/getViewDropbox',
  'https://simola.herokuapp.com/index.php/user/logout',
  'https://simola.herokuapp.com/index.php/DataUser/removeFingerPrint'
];

self.addEventListener('install', function (event) {
  console.log('[Service Worker] Installing Service Worker ...', event);
  event.waitUntil(
    caches.open(CACHE_STATIC_NAME)
      .then(function (cache) {
        console.log('[Service Worker] Precaching App Shell');
        cache.addAll(STATIC_FILES);
      })
  )
});

self.addEventListener('activate', function (event) {
  console.log('[Service Worker] Activating Service Worker ....', event);
  event.waitUntil(
    caches.keys()
      .then(function (keyList) {
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

function isDynamicArraySave(string, array) {
  return array.indexOf(string) > -1;
}

function isDynamicArray(string,array){
  var pat = /^(https?:\/\/)?(?:www\.)?([^\/]+)/;
  if (pat.test(string)){
    var match = string.match(pat);
    console.log("isDynamicArray: ",match);
    return array.indexOf(match[0]) > -1;
  } else{
    console.log("validation failed");
    return false;
  }
}

self.addEventListener('fetch', function (event) {

  var url = 'https://pwagram-99adf.firebaseio.com/posts';
  if (event.request.url.indexOf(url) > -1) {
    event.respondWith(fetch(event.request)
      .then(function (res) {
        var clonedRes = res.clone();
        clearAllData('posts')
          .then(function () {
            return clonedRes.json();
          })
          .then(function (data) {
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
  } else if(isDynamicArray(event.request.url, DYNAMIC_FILES_NOT_SAFE) || isDynamicArraySave(event.request.url, DYNAMIC_NOT_SAFE)){

  } else {
    event.respondWith(
      caches.match(event.request)
        .then(function (response) {
          if (response) {
            return response;
          } else {
            return fetch(event.request)
              .then(function (res) {
                return caches.open(CACHE_DYNAMIC_NAME)
                  .then(function (cache) {
                    // trimCache(CACHE_DYNAMIC_NAME, 3);
                    cache.put(event.request.url, res.clone());
                    return res;
                  })
              })
              .catch(function (err) {
                return caches.open(CACHE_STATIC_NAME)
                  .then(function (cache) {
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