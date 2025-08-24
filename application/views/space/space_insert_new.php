<?php
    $lang = $this->session->userdata('lang');
    $this->lang->load('view', $lang);
    
    $space_x = "";
    $space_y = "";
    $zoom = "";
?>


        <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
          <link href="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css" rel="stylesheet" />
        <script src="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js"></script>
        <style>
          body { margin:0; font-family: system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple SD Gothic Neo", "Noto Sans KR", "Malgun Gothic", sans-serif; }
          #map { width:100%; height: 70vh; }
          .panel { padding: 12px 16px; display:flex; gap:12px; align-items:center; flex-wrap:wrap; }
          .field { display:flex; gap:8px; align-items:center; }
          input[type="text"] { width:160px; padding:6px 8px; }
          button { padding:8px 12px; border:0; border-radius:8px; background:#111827; color:white; cursor:pointer; }
          button:hover { opacity:.9; }
          .hint { color:#6b7280; font-size:12px; }
        </style>


        <div class="container" style="font-size: 15px">
            <form id="form_insert">
                <div class="row">
                    <div class="col-4">
                        <label class="form-label bold"><strong><?=$this->lang->line('countryname')?></strong></label>
                    </div>
                    <div class="col-8">
                        <select id="country_idx" name="country_idx"  class="form-select" onchange="go_country()">
                            <?php foreach($country_list as $cont){
                                    $selected = "";
                                    if($cont['idx'] == $search['country']){
                                        $selected = "selected";
                                        
                                        $space_x = $cont['space_x'];
                                        $space_y = $cont['space_y'];
                                        $zoom = "6";
                                    }
                            ?>
                                
                                <option value="<?=$cont['idx']?>" <?=$selected?>><?=$cont['name']?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row" style="padding-top: 5px">
                    <div class="col-4">
                        <label class="form-label bold"><strong><?=$this->lang->line('cityname')?></strong></label>
                    </div>
                    <div class="col-8">
                        <select id="city_idx" name="city_idx"  class="form-select" onchange="go_city()">
                            
                            <?php foreach($city_list as $city){
                                    $selected = "";
                                    if($city['idx'] == $search['city']){
                                        $selected = "selected";
                                        
                                        $space_x = $city['space_x'];
                                        $space_y = $city['space_y'];
                                        $zoom = "13";
                                    }
                            ?>
                                
                                <option value="<?=$city['idx']?>" <?=$selected?>><?=$city['name']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    
                    
                </div>
                <div class="row" style="padding-top: 5px">
                    <div class="col-4">
                        <label class="form-label bold"><strong><?=$this->lang->line('name')?></strong></label>
                    </div>
                    <div class="col-8">
                        <input type="text" id="space_name" name="space_name"  class="form-control"/>
                    </div>
                </div>
                <div class="row" style="padding-top: 5px">
                    <div class="col-4">
                        <label class="form-label bold"><strong><?=$this->lang->line('address')?></strong></label>
                    </div>
                    <div class="col-8">
                        <div class="d-flex">
                            <textarea id="space_location" name="space_location"  class="form-control"></textarea>
                            <input type="button" class="btn btn-secondary" id="search_map" name="search_map" onclick="go_search_map();" value="<?=$this->lang->line('search')?>">
                        </div>
                    </div>
                </div>
                <div class="row" style="padding-top: 5px">
                    <div id="map" style="position: relative; overflow: hidden;height:45vh">
                        
                    </div>
                    <input type="hidden" id="space_x" name="space_x" value="<?=$space_x?>"/>
                    <input type="hidden" id="space_y" name="space_y" value="<?=$space_y?>"/>
                </div>
                
                <div class="row mt-1" style="padding-top:10px">
                    <div class="col-md-4 col-xs-4 "></div>
                    <div class="col-md-4 col-xs-6 col-offset-6 col-xs-offset-4 text-center">
                        <button type="button" class="btn btn-success" id="btn_insert" onclick="insert_space()"><?=$this->lang->line('insert')?></button>
                        <button type="button" class="btn btn-danger" id="btn_reset" onclick="form.reset();"><?=$this->lang->line('reset')?></button>
                    </div>
                </div>
            </form>
        </div>
        
    <script>
        function insert_space(){
            
            $.ajax({
                url:'/space/insert_ajax',
                type:'post',
                data:$("#form_insert").serialize(),
                success:function(data){
                    if(data.result == 200){
                        alert('<?=$this->lang->line('completeinsert')?>');
                        window.location.href="/space/";
                    }else{
                        alert('<?=$this->lang->line('checktodata')?>');
                    }
                },
                error: function(xhr,status,error) {
                    console.log(xhr,status,error);
                    alert("<?=$this->lang->line('neterror')?>");
                    return false;
                }	 
            });
            
        }
        
        function go_country(){
        
            var country_idx  = $("#country_idx option:selected").val();

            location.href="?country_idx="+country_idx;
        }
        function go_city(){
        
            var country_idx  = $("#country_idx option:selected").val();
            var city_idx  = $("#city_idx option:selected").val();
            
            location.href="?country_idx="+country_idx+"&city_idx="+city_idx;
        }
    </script>

    
<script>
  // 1) 토큰 설정
  mapboxgl.accessToken = 'pk.eyJ1Ijoic2h4b2R3ayIsImEiOiJjbWRheXdjOWQwbnZhMmpwa3EyenB6Z2RsIn0.jYcv95SmixAIKIdT4Te6uw';

  // 2) 기본 지도 생성 (초기 중심: 서울 시청 근처)
  const map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/streets-v12',
    center: [<?=$space_y?>, <?=$space_x?>], // [lng, lat]
    zoom: 11
  });

  // 3) 컨트롤(확대/축소, 현재위치) 추가
  map.addControl(new mapboxgl.NavigationControl(), 'top-right');
  map.addControl(new mapboxgl.GeolocateControl({
    positionOptions: { enableHighAccuracy: true },
    trackUserLocation: false
  }), 'top-right');

  // 좌표 표시/전송 필드

  const latHidden = document.getElementById('space_x');
  const lngHidden = document.getElementById('space_y');

  // 4) 드래그 가능한 마커 준비 (처음엔 생성 안 함)
  let marker = null;

  // 좌표를 UI에 세팅하는 함수
  function setCoords(lngLat) {
    const { lng, lat } = lngLat;
    // 소수점 자릿수는 필요에 따라 조정
    latHidden.value = lat.toFixed(6);
    lngHidden.value = lng.toFixed(6);
  }

  // 5) 지도 클릭 시: 마커 없으면 만들고, 있으면 위치만 이동
  map.on('click', (e) => {
    const lngLat = e.lngLat;

    if (!marker) {
      marker = new mapboxgl.Marker({ draggable: true })
        .setLngLat(lngLat)
        .addTo(map);

      // 마커 드래그로 좌표 갱신
      marker.on('dragend', () => {
        setCoords(marker.getLngLat());
      });
    } else {
      marker.setLngLat(lngLat);
    }

    setCoords(lngLat);
  });

    //(옵션) 초기 위치에 마커 하나 미리 놓고 싶다면 주석 해제:
    map.on('load', () => {
        const initial = { lng: <?=$space_y?>, lat: <?=$space_x?> };
        marker = new mapboxgl.Marker({ draggable: true })
            .setLngLat(initial)
            .addTo(map);
        setCoords(initial);
        marker.on('dragend', () => setCoords(marker.getLngLat()));
     });
    </script>
</main>