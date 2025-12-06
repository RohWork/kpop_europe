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
        <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.1.0/mapbox-gl-geocoder.min.js"></script>
        <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.1.0/mapbox-gl-geocoder.css" type="text/css" />

        <style>
          body { margin:0; font-family: system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial, "Apple SD Gothic Neo", "Noto Sans KR", "Malgun Gothic", sans-serif; }
          #map { width:100%; height: 70vh; }
          .panel { padding: 12px 16px; display:flex; gap:12px; align-items:center; flex-wrap:wrap; }
          .field { display:flex; gap:8px; align-items:center; 
          button { padding:8px 12px; border:0; border-radius:8px; background:#111827; color:white; cursor:pointer; }
          button:hover { opacity:.9; }
          .hint { color:#6b7280; font-size:12px; }
          .geocoder-wrap{z-index:2; width:min(520px, 92%); }
    
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
                        <input type="text" id="space_name" name="space_name"  class="form-control" value="<?=!empty($space_name) ? $space_name :  ""?>"/>
                    </div>
                </div>
                <div class="row" style="padding-top: 5px">
                    <div class="col-4">
                        <label class="form-label bold"><strong><?=$this->lang->line('address')?></strong></label>
                    </div>
                    <div class="col-8">
                        <div class="d-flex">
                            <div class="geocoder-wrap" id="geocoder"></div>
                            <input type="hidden" id="address" name="address" placeholder="검색 또는 핀 이동 시 자동 입력" readonly>
                        </div>
                    </div>
                </div>
                <div class="row" style="padding-top: 5px">
                    <div id="map" style="position: relative; overflow: hidden;height:45vh">
                        
                    </div>
                    <input type="hidden" id="space_x" name="space_x" value="<?=$space_x?>"/>
                    <input type="hidden" id="space_y" name="space_y" value="<?=$space_y?>"/>
                    <input type="hidden" id="space_location" name="space_location"/>
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
  
  var token = 'pk.eyJ1Ijoic2h4b2R3ayIsImEiOiJjbWRheXdjOWQwbnZhMmpwa3EyenB6Z2RsIn0.jYcv95SmixAIKIdT4Te6uw';
  
  mapboxgl.accessToken = token;

  const map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/streets-v12',
    center: [<?=$space_y?>, <?=$space_x?>],
    zoom: 11
  });
  map.addControl(new mapboxgl.NavigationControl(), 'top-right');

  // 3) Geocoder(주소 검색) 컨트롤
  const geocoder = new MapboxGeocoder({
    accessToken: token,
    mapboxgl: mapboxgl,
    marker: false,                 // 검색 시 자동 마커 생성 안 함(우리가 직접 관리)
    language: 'ko',                // 한국어 우선
    placeholder: '주소/장소를 입력하세요'
  });
  document.getElementById('geocoder').appendChild(geocoder.onAdd(map));

  // 좌표 표시/전송 필드

  const latHidden = document.getElementById('space_x');
  const lngHidden = document.getElementById('space_y');
  const addressEl = document.getElementById('address');
  const addrHidden = document.getElementById('space_location');
  
  let marker = null;
  
  // 좌표 & 주소 UI 반영
  function setCoordsAndAddress({ lng, lat }, placeText) {

    latHidden.value = lat.toFixed(6);
    lngHidden.value = lng.toFixed(6);
    
    console.log(placeText);

    if (placeText) {
      addressEl.value = placeText;
      addrHidden.value = placeText;
    }
  }

  // 역지오코딩 (lng,lat -> 주소 문자열)
  async function reverseGeocode({ lng, lat }) {
    try {
      const url = new URL('https://api.mapbox.com/geocoding/v5/mapbox.places/' + lng + ',' + lat + '.json');
      url.searchParams.set('access_token', token);
      url.searchParams.set('language', 'ko');
      url.searchParams.set('limit', '1');
      const res = await fetch(url);
      const data = await res.json();
      
      const place = data?.features?.[0]?.place_name || ''
      return place;
    } catch (e) {
      console.error(e);
      return '';
    }
  }

  // 마커 생성/이동 공통 함수
  function upsertMarker(lngLat) {
    if (!marker) {
      marker = new mapboxgl.Marker({ draggable: true })
        .setLngLat(lngLat)
        .addTo(map);

      marker.on('dragend', async () => {
        const ll = marker.getLngLat();
        const addr = await reverseGeocode(ll);
        setCoordsAndAddress(ll, addr);
      });
    } else {
      marker.setLngLat(lngLat);
    }
  }

  // 4-A) 지도를 클릭하면 해당 위치로 마커 & 좌표/주소 세팅
  map.on('click', async (e) => {
    const lngLat = e.lngLat;
    upsertMarker(lngLat);
    // 클릭도 역지오코딩해서 주소 표시
    const addr = await reverseGeocode(lngLat);
    setCoordsAndAddress(lngLat, addr);
  });

  // 4-B) Geocoder 결과 선택 시: 지도 이동, 마커 갱신, 좌표/주소 세팅
  geocoder.on('result', (e) => {
    const center = e.result.center; // [lng, lat]
    const placeText = e.result.place_name; // 주소/장소명 전체 텍스트
    const lngLat = { lng: center[0], lat: center[1] };

    map.flyTo({ center, zoom: 16 });
    upsertMarker(lngLat);
    setCoordsAndAddress(lngLat, placeText);
  });

    //(옵션) 초기 위치에 마커 하나 미리 놓고 싶다면 주석 해제:
    map.addControl(new mapboxgl.GeolocateControl({
        positionOptions: { enableHighAccuracy: true },
          trackUserLocation: false
        }), 'top-right');
        map.once('load', () => {
          // 필요 시 현재 위치 버튼을 눌러 사용자가 이동
    });
    </script>
</main>