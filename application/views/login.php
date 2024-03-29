<?php
    $lang = $this->session->userdata('lang');
    $this->lang->load('view', $lang);

?>


<html>
  <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 2 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Refobi</title>
        <!-- 합쳐지고 최소화된 최신 CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

        <!-- 부가적인 테마 -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <!-- 합쳐지고 최소화된 최신 자바스크립트 -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
        <!-- Custom styles for this template -->
  </head>
  <body>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <div class="container text-center">
        
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-5">
                
                    <table align="center" style="width:100%;margin-top:50px;">
                        <tr>
                            <td colspan="3" align="center"><h1>LOGIN</h1></td>
                        </tr>
                        <tr>
                            <td height="15"></td>
                        </tr>
                        <form id="login_form" onsubmit="return false" method="post" >
                        <tr>
                            <td>
                                 <label class="form-label" for="login_email">Email</label>
                            </td>
                            <td>
                                <input type="email" class="form-control" id="login_email" name="login_email" placeholder="id@kpopineurope.com"/>
                            </td>
                            <td rowspan="2">
                                <button class="form-control" onclick="login_set()" type="button" style="height:68px;" >LOGIN</button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class="form-label" for="login_pass"><?=$this->lang->line('password')?></label>
                            </td>

                            <td>
                                <input type="password"  class="form-control" id="login_pass" name="login_pass" />
                            </td>
                            
                        </tr>
                        </form>
                        <tr>
                            <td height="15"></td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <center>
                                    <div id="g_id_onload"
                                        data-client_id="238139026847-mudgpdqus93r42v9cpa8bmcsb4igto5e.apps.googleusercontent.com"
                                        data-callback="handleCredentialResponse">
                                   </div>
                                    <div class="g_id_signin" data-width="100%" data-type="standard"></div>

                                </center>
                            </td>
                        </tr>
                        <tr>
                            <td height="15"></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <button id="find_pasword" class="form-control"><?=$this->lang->line('findpw')?></button>
                            </td>
                            <td>
                                <button id="join_member" class="form-control"><?=$this->lang->line('joinus')?></button>
                            </td>
                        </tr>
                    </table>
                
            </div>
        </div>

    </div>
  </body>
  <script>
      
     $( "#login_pass" ).keypress(function( event ) {

        if ( event.which == 13 ) {

         login_set();

     }
    });
      
      
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
                        alert('<?=$this->lang->line('hi')?>, '+responsePayload.name);
                        location.href = "/";
                    }else{
                        alert('<?=$this->lang->line('loginfail')?>');
                    }
                },
                error: function(xhr,status,error) {
                    console.log(xhr,status,error);
                    alert("<?=$this->lang->line('neterror')?>");
                    return false;
                }	 
            });
  }
  
    function login_set(){
        
        event.preventDefault(); 
        var formData = new FormData();


        formData.append('login_email', $("#login_email").val());
        formData.append('login_pass', $("#login_pass").val());

        $.ajax({
            url:'/member/login_process',
            type:'post',
            processData : false,
            contentType : false,
            data:formData,
            success:function(data){
                
                alert(data.message);
                
                if(data.result == 200){
                    location.href = "/";
                }else{
                    return false;
                }
            },
            error: function(xhr,status,error) {
                console.log(xhr,status,error);
                alert("<?=$this->lang->line('neterror')?>");
                return false;
            }	 
        });
  }
  
    $("#join_member").click(function(){
       location.href="/member/join"; 
    });
  </script>
</html>