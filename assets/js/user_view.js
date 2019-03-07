function saveFP(){
    fetch(base_url+'DataUser/addFingerPrint',
    {
        method : 'post',
        headers: {
            "Content-Type": "application/json",
        }
    }).then(function(res){
        //console.log(res);
        return res.json(); 
    }).then(function(response){
        console.log(response);
    });  
}