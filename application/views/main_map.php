<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no,maximum-scale=1.0,minimum-scale=1.0,target-densitydpi=medium-dpi" />  
    <title>kpopineu</title>
    

    
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        var lat, lng;
        let map;
        let marker;
        
        if(navigator.geolocation){
                navigator.geolocation.getCurrentPosition(showPosition);
            }else{
                console.log("지원안함");
        }

        
        
        function showPosition(position){
            console.log("내 위치 위도 = " + position.coords.latitude
			+" 내 위치 경도 = " + position.coords.longitude);
            lat = position.coords.latitude;
            lng = position.coords.longitude;
            
            var move_position = {lat:lat, lng:lng};
            
            map.setCenter(move_position);
            
            
            marker = new google.maps.Marker({
                position: move_position,
                map,
                title: "Hello World!",
              });
        }
        
        function initMap() {
            
            const myLatLng = { lat: 33, lng: 151 };
            
             map = new google.maps.Map(document.getElementById("map"), {
              zoom: 4,
              center: myLatLng,
              disableDefaultUI: true,
            });
            
            
            marker = new google.maps.Marker({
                position: myLatLng,
                map,
                title: "Hello World!",
              });
      }
      
      window.initMap = initMap;
      
    </script>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      gmp-map {
        height: 100%;
      }

      /* Optional: Makes the sample page fill the window. */
      html,
      body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
  
  
  <body>
    <div style="height:5%">
        Kpop In Europe
    </div>
      <div id="map" style="height:100%"></div>

      
    <!--<gmp-map center="50.11061096191406,8.682072639465332" zoom="14" map-id="DEMO_MAP_ID" style="height:95%">
      <gmp-advanced-marker position="50.11061096191406, 8.682072639465332" title="My location"></gmp-advanced-marker>
      
      <gmp-advanced-marker position="50.11026112441478, 8.682188131938588" title="My location2"></gmp-advanced-marker>
    </gmp-map>-->
    
           
       <!-- The callback parameter is required, so we use console.debug as a noop -->
    <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBu5yucZu09lR2UwMGYPFGu3V9FIQL2hYo&callback=initMap&v=weekly">
    </script>


  </body>

</html>