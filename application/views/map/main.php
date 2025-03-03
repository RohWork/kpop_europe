<?php
    $lang = $this->session->userdata('lang');
    if(empty($lang)){
        $lang = 'en';
    }
    $this->lang->load('view', $lang);

?>

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
       
        var PositionArray = new Array(
                <?php
                    foreach ($space_info as $space){
                        $name = $space['space_name']."<br/>".$space['start_date']."<br/><button onclick='go_window(".$space['idx'].")'>info go</button>";
                ?>
                {label: "<?=substr($space['space_name'],0,1)?>", name:"<?=$name?>", lat: <?=$space['space_x']?>, lng: <?=$space['space_y']?> },
                <?php
                    }
                ?>
            );
        
        var InfoWindowArray = [];
        
        
        
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
            
            //map.setCenter(move_position);
            
            
            marker = new google.maps.Marker({
                position: move_position,
                map,
                title: "Hello World!",
              });
        }
        
        function setPosition(lat, lng, name){
            var move_position = {lat:lat, lng:lng};
            var info_position = {lat:lat+0.00010, lng:lng};
            
            setInfoWindowClose();
            
            const infoWindow = new google.maps.InfoWindow();
            infoWindow.setContent(name);
            //infoWindow.setPosition(info_position);
            infoWindow.open({
                    map
            });
            
            InfoWindowArray.push(infoWindow);
            
            map.setCenter(move_position);
            map.setZoom(4);
            
           
        }
        
        function initMap() {
            

  
            const myLatLng = { lat: <?=$mapdata['space_x']?>, lng: <?=$mapdata['space_y']?> };
            const myLatLngArray = PositionArray;

            
            
             map = new google.maps.Map(document.getElementById("map"), {
              zoom: 4,
              center: myLatLng,
              disableDefaultUI: true,
            });
            
            const bounds = new google.maps.LatLngBounds();
            const infoWindow = new google.maps.InfoWindow();
            
            if(PositionArray.length > 0){
                PositionArray.forEach(({ label, name, lat, lng }) => {
                    const marker = new google.maps.Marker({
                            position: {lat, lng},
                            label,
                            map,
                        });
                    bounds.extend(marker.position);    

                    marker.addListener("click", () => {
                        setInfoWindowClose();

                        map.panTo(marker.position);
                        infoWindow.setContent(name);
                        infoWindow.open({
                            anchor: marker,
                            map
                        });
                        InfoWindowArray.push(infoWindow);
                    });
                });
                map.fitBounds(bounds);
            }
      }
      
      window.initMap = initMap;
      
      
      function setInfoWindowClose(){
          for(var i=0;i<InfoWindowArray.length;i++){
                        InfoWindowArray[i].close();
        }
      }
      
      function go_window(idx){
          window.open("/main/detail/"+idx);
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
        <div style="float:left;width:50%">
            Kpop In Europe
        </div>
        <div style="float:left;width:25%">
            <select id="country" name="country" onchange="go_country(this)">
                <option><?=$this->lang->line('country')?></option>
                <?php foreach($country_list as $coun){
                  if($coun['idx'] == $search['country']){
                      $selected = "selected";
                  }else{
                      $selected = "";
                  }
                  echo "<option value='".$coun['idx']."' ".$selected.">".$coun['name']."</option>";  
                }
                ?>
            </select>
        </div>
        <div style="float:left;width:25%" >
            <select id="city" name="city" onchange="go_city(this)">
                <option><?=$this->lang->line('city')?></option>
                <?php foreach($city_list as $city){
                  if($city['idx'] == $search['city']){
                      $selected = "selected";
                  }else{
                      $selected = "";
                  }
                  echo "<option value='".$city['idx']."' ".$selected.">".$city['name']."</option>";  
                }
                ?>
            </select>
        </div>
    </div>
    <div id="map" style="height:90%"></div>
    
    
    <div id="position_list" style="height:5%;overflow-x: auto;width:100%;white-space:nowrap;">
        
        <?php
                    foreach ($space_info as $space){
                         $name = $space['space_name']."<br/>".$space['start_date']."<br/><button onclick=go_window(".$space['idx'].")>info go</button>";
                ?>
                 <span style="padding:0 4vh;cursor:pointer" onclick="setPosition(<?=$space['space_x']?>, <?=$space['space_y']?>,'<?=$name?>')">
                <?=$space['space_name']?>
                </span>
                <?php
                    }
        ?>
       
    </div>
      
    <!--<gmp-map center="50.11061096191406,8.682072639465332" zoom="14" map-id="DEMO_MAP_ID" style="height:95%">
      <gmp-advanced-marker position="50.11061096191406, 8.682072639465332" title="My location"></gmp-advanced-marker>
      
      <gmp-advanced-marker position="50.11026112441478, 8.682188131938588" title="My location2"></gmp-advanced-marker>
    </gmp-map>-->
    
           
       <!-- The callback parameter is required, so we use console.debug as a noop -->
    <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBu5yucZu09lR2UwMGYPFGu3V9FIQL2hYo&callback=initMap&v=weekly">
    </script>
    
    <script>
        
        var country = "<?=$search['country']?>";
        var city = "<?=$search['city']?>";
        
        function go_country(selected){
          country =  $(selected).val();
          city = "";
          go_url();
        }
        function go_city(selected){
          city =  $(selected).val(); 
          go_url();
        }
        
        function go_url(){
            location.href= "/?country="+country+"&city="+city;
        }
    </script>

  </body>

</html>