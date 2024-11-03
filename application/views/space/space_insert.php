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
                        <textarea id="space_location" name="space_location"  class="form-control"></textarea>
                        <input type="button" class="btn btn-secondary" id="search_map" name="search_map" onclick="search_map();" value="<?=$this->lang->line('search')?>">
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
        (g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})({
          key: "AIzaSyBu5yucZu09lR2UwMGYPFGu3V9FIQL2hYo",
          v: "weekly",
          // Use the 'v' parameter to indicate the version to use (weekly, beta, alpha, etc.).
          // Add other bootstrap parameters as needed, using camel case.
        });
    </script>
    
    <script>
        let map;

        async function initMap() {
            
            const { Map, InfoWindow } = await google.maps.importLibrary("maps") ;
            const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

            map = new Map(document.getElementById("map"), {
              center: { lat: <?=$space_x?>, lng: <?=$space_y?> },
              zoom: <?=$zoom?>,
              mapId: '4504f8b37365c3d0',
            });
          
            const infoWindow = new InfoWindow();
          
            const draggableMarker = new AdvancedMarkerElement({
                map,
                position: {lat:<?=$space_x?>, lng: <?=$space_y?>},
                gmpDraggable: true,
                title: "This marker is draggable.",
            });
            
            draggableMarker.addListener('dragend', (event) => {
                const position = draggableMarker.position;
                infoWindow.close();
                infoWindow.setContent(`Pin dropped at: ${position.lat}, ${position.lng}`);
                infoWindow.open(draggableMarker.map, draggableMarker);
                
                $("#space_x").val(position.lat);
                $("#space_y").val(position.lng);
                
            });
        }

        initMap();  
    </script>
</main>