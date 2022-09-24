<html>
  <head>
  </head>
  <body>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <meta name="google-signin-client_id" content="238139026847-mudgpdqus93r42v9cpa8bmcsb4igto5e.apps.googleusercontent.com">
    <div class="g-signin2" data-onsuccess="handleCredentialResponse"></div>
    <script>
      function handleCredentialResponse(googleUser) {
        ...
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/member/login_process');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
          console.log('Signed in as: ' + xhr.responseText);
        };
        xhr.send('idtoken=' + id_token);
      }
    </script>
  </body>
</html>