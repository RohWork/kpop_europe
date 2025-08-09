<?php
    $lang = $this->session->userdata('lang');
    if(empty($lang)){
        $lang = 'en';
    }
    $this->lang->load('view', $lang);

?>



  <script src="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js"></script>
  <link href="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css" rel="stylesheet" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    body { margin: 0; padding: 0; }
    #map { width: 100%; height: 75vh; }
    #position_list { height:10vh; overflow:auto; border-top:1px solid #e5e5e5; }
    .item { padding:10px 12px; border-bottom:1px solid #f0f0f0; cursor:pointer; }
    .item:hover { background:#fafafa; }
    .item.active { background:#eef6ff; }
    .title { font-weight:600; }
    .meta { font-size:12px; color:#666; margin-top:4px; }
  </style>

  <body>
    <div style="height:3%">
        <div style="float:left;width:40%">
            &nbsp;
        </div>
        <div style="float:left;width:30%;text-align:center">
            <select id="country" name="country" onchange="go_country(this)">
                <option value=""><?=$this->lang->line('country')?></option>
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
        <div style="float:left;width:30%;text-align:center" >
            <select id="city" name="city" onchange="go_city(this)">
                <option value=""><?=$this->lang->line('city')?></option>
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
<div id="map"></div>

<div id="position_list">

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

<script>
    
  var map;  
    
  mapboxgl.accessToken = 'pk.eyJ1Ijoic2h4b2R3ayIsImEiOiJjbWRheXdjOWQwbnZhMmpwa3EyenB6Z2RsIn0.jYcv95SmixAIKIdT4Te6uw'; // ← 여기에 본인의 Mapbox 토큰 입력
  
  
  
  function initMap(lng, lat, label = "위치") {
    map = new mapboxgl.Map({
      container: 'map',
      style: 'mapbox://styles/mapbox/streets-v11',
      center: [lng, lat],
      zoom: 13
    });

    map.on('load', function () {
      // 지도 로딩 완료 후 마커 추가
      console.log("지도 로드 완료. 마커 추가 중...");

      new mapboxgl.Marker({ color: 'red' })
        .setLngLat([lng, lat])
        .setPopup(new mapboxgl.Popup().setHTML(`<b>${label}</b>`))
        .addTo(map);

      <?php 
        foreach($space_info as $space) { 
          $name = $space['space_name']."<br/>".$space['start_date']."<br/><button onclick='go_window(".$space['idx'].")'>info go</button>";
        ?>
      // 예: 지도 로드 후 다른 위치에도 추가 마커
        new mapboxgl.Marker({ color: 'green' })
          .setLngLat([<?=$space['space_y']?>,<?=$space['space_x']?>])
          .setPopup(new mapboxgl.Popup().setHTML("<?=$name?>"))
          .addTo(map);
      <?php } ?>

    });
  }

  $(document).ready(function () {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        function (position) {
          var userLng = position.coords.longitude;
          var userLat = position.coords.latitude;
          
        <?php if(!empty($mapdata)){ ?>
             userLng = "<?=$mapdata['space_y']?>";
             userLat = "<?=$mapdata['space_x']?>";       
        <?php } ?>
          
          initMap(userLng, userLat, "내 위치");
        },
        function (error) {
          // 권한 거부나 오류 발생 시 프랑크푸르트로 fallback
          console.warn("위치 사용 불가, 프랑크푸르트로 이동: " + error.message);
          initMap(8.6821, 50.1109, "프랑크푸르트"); // Frankfurt
        },
        { timeout: 5000 } // 위치 가져오기 제한 시간 설정 (선택)
      );
    } else {
      // Geolocation 지원 안됨
      console.warn("Geolocation 미지원, 프랑크푸르트로 이동");
      initMap(8.6821, 50.1109, "프랑크푸르트");
    }
  });
  
    function go_window(idx){
          window.open("/main/detail/"+idx);
    }
  
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
        location.href= "/map?country="+country+"&city="+city;
    }
    
    function setPosition(x, y, name){
        map.flyTo({ center: [y,x], zoom: 12, essential: true });
    }
</script>

</body>

