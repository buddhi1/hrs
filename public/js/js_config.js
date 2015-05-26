

    function sendRequestToServerPost(url,variables,callback){

        var header =  arrayToUrl(variables); 
             
        var xmlHttp = new XMLHttpRequest(); 
        xmlHttp.onreadystatechange = function(){
            if (xmlHttp.readyState==4 && xmlHttp.status==200){
                callback(xmlHttp.responseText);
            }
        };
        xmlHttp.open( "POST", http_url+url, true );
        xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xmlHttp.send(header);
    }

    var arrayToUrl = function(url){
        var variableArray = JSON.parse(url);
        var url = "";
       
        url = Object.getOwnPropertyNames(variableArray)[0]+'='+variableArray[Object.getOwnPropertyNames(variableArray)[0]];
        console.log(variableArray);
        for (var i = 1; Object.getOwnPropertyNames(variableArray).length - 1  >= i; i++) {
            url += '&'+Object.getOwnPropertyNames(variableArray)[i]+'='+variableArray[Object.getOwnPropertyNames(variableArray)[i]];
        };
        return url;
    }

