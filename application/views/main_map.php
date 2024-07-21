<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no,maximum-scale=1.0,minimum-scale=1.0,target-densitydpi=medium-dpi" />  
    <title>kpopineu</title>
    
       
       <!-- The callback parameter is required, so we use console.debug as a noop -->
    <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBu5yucZu09lR2UwMGYPFGu3V9FIQL2hYo&callback=initMap&v=weekly">
    </script>

    
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        var lat, lng;
        
        const map = new google.maps.Map(document.getElementById("map"), {
              zoom: 4,
              center: { lat: lat_map, lng: lng_map },
              disableDefaultUI: true,
        });
        
        if(navigator.geolocation){
                navigator.geolocation.getCurrentPosition(showPosition);
            }else{
                console.log("지원안함");
        }
        setTimeout(function() {   
            window.initMap = initMap;
        },2000);
        
        
        function showPosition(position){
            console.log("내 위치 위도 = " + position.coords.latitude
			+" 내 위치 경도 = " + position.coords.longitude);
            lat = position.coords.latitude;
            lng = position.coords.longitude;
            
            
            map.setCenter({lat:lat, lng:lng});
        }
        
        function initMap() {
            
            var lat_map =  $("#i_lat").val();
            var lng_map =  $("#i_lng").val();
            
            if(lat_map == ""){
                lat_map = 33;
                lng_map = 151;
            }
            
            
      }
      
      
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
    

  </body>

</html>