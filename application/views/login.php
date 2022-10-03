<html>
  <head>
  </head>
  <body>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <div id="g_id_onload"
         data-client_id="238139026847-mudgpdqus93r42v9cpa8bmcsb4igto5e.apps.googleusercontent.com"
         data-callback="handleCredentialResponse">
    </div>
    <div class="g_id_signin" data-type="standard"></div>
  </body>
  <script>
    function handleCredentialResponse(response) {
     // decodeJwtResponse() is a custom function defined by you
     // to decode the credential response.
     
     //const responsePayload = decodeJwtResponse(response.credential);
     const responsePayload = parseJwt(response.credential);

     console.log("ID: " + responsePayload.sub);
     console.log('Full Name: ' + responsePayload.name);
     console.log('Given Name: ' + responsePayload.given_name);
     console.log('Family Name: ' + responsePayload.family_name);
     console.log("Image URL: " + responsePayload.picture);
     console.log("Email: " + responsePayload.email);
     
     google_set(responsePayload);
     
  }
  
  
  function parseJwt (token) {
    var base64Url = token.split('.')[1];
    var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
    var jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
    }).join(''));

    return JSON.parse(jsonPayload);
};
  
  function google_set(responsePayload){

            var formData = new FormData();
            

            
            formData.append('id', responsePayload.sub);
            formData.append('name', responsePayload.name);
            formData.append('image_url', responsePayload.picture);
            formData.append('email', responsePayload.email);
            formData.append('nick', responsePayload.given_name);
            
            $.ajax({
                url:'/member/set_member_google',
                type:'post',
                processData : false,
                contentType : false,
                data:formData,
                success:function(data){
                    if(data.result == 200){
                        alert('hello, '+responsePayload.name);
                        location.href("/main");
                    }else{
                        alert('login fail, retry to login');
                    }
                },
                error: function(xhr,status,error) {
                    console.log(xhr,status,error);
                    alert("네트워크 오류!! 관리자에게 문의 주세요!!");
                    return false;
                }	 
            });
  }
  
  </script>
</html>