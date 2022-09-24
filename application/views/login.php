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
     const responsePayload = atob(response.credential.split('.')[1]);

     console.log("ID: " + responsePayload.sub);
     console.log('Full Name: ' + responsePayload.name);
     console.log('Given Name: ' + responsePayload.given_name);
     console.log('Family Name: ' + responsePayload.family_name);
     console.log("Image URL: " + responsePayload.picture);
     console.log("Email: " + responsePayload.email);
  }
  </script>
</html>