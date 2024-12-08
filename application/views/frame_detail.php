<?php
    $lang = $this->session->userdata('lang');
    $this->lang->load('view', $lang);

?>


<html>
    <head>
        <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <div class="container" style="font-size: 12px">
            <div class="row">
                <div class="col-2">
                    <label class="form-label bold"><strong><?=$this->lang->line('event')?></strong></label>
                </div>
                <div class="col-10">
                    <p><?=$detail_info['name']?></p>
                </div>
            </div>
            <div class="row row_border">
                <div class="col-2">
                    <label class="form-label"><strong><?=$this->lang->line('country')?></strong></label>
                </div>
                <div class="col-10">
                    <p><?=$detail_info['country_name']?></p>
                </div>
            </div>
            <div class="row row_border">
                <div class="col-2">
                    <label class="form-label"><strong><?=$this->lang->line('city')?></strong></label>
                </div>
                <div class="col-10">
                    <p><?=$detail_info['city_name']?></p>
                </div>
            </div>
            <div class="row row_border">
                <div class="col-2">
                    <label class="form-label"><strong><?=$this->lang->line('orgernizer')?></strong></label>
                </div>
                <div class="col-10">
                    <p><?=$detail_info['orgernizer']?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <label class="form-label"><strong><?=$this->lang->line('location')?></strong></label>
                </div>
                <div class="col-10">
                    <p><?=$detail_info['space']?></p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div id="map" style="position: relative; overflow: hidden;height:70vh"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <label class="form-label"><strong><?=$this->lang->line('address')?></strong></label>
                </div>
                <div class="col-10">
                    <p><?=$detail_info['addr']?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <label class="form-label"><strong>Hompage</strong></label>
                </div>
                <div class="col-10">
                    <a href="<?=$detail_info['homepage']?>?>"><?=$detail_info['homepage']?></a>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <label class="form-label"><strong>Facebook</strong></label>
                </div>
                <div class="col-10">
                    <a href="<?=$detail_info['face']?>" target="_blankt"><?=$detail_info['face']?></a>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <label class="form-label"><strong>Instagram</strong></label>
                </div>
                <div class="col-10">
                    <a href="<?=$detail_info['insta']?>"  target="_blank"><?=$detail_info['insta']?></a>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <label class="form-label"><strong>Youtube</strong></label>
                </div>
                <div class="col-10">
                    <a href="<?=$detail_info['yout']?>" target="_blankt"><?=$detail_info['yout']?></a>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <label class="form-label"><strong><?=$this->lang->line('date')?></strong></label>
                </div>
                <div class="col-10">
                    <p><?=date('d-m-Y H:00:00',strtotime($detail_info['start_date']))?> ~ <?=date('d-m-Y H:00:00',strtotime($detail_info['end_date']))?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <label class="form-label"><strong><?=$this->lang->line('etc')?></strong></label>
                </div>
                <div class="col-10">
                    <p><?=str_replace("\r\n", "<br>",$detail_info['remark'])?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <label class="form-label"><strong>Image</strong></label>
                </div>
                <div class="col-10">
                   <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                    <?php

                      for($i=0; $i<count($detail_img);$i++){
                          
                    ?>
                      <div class="carousel-item <?=$i==0? "active" : "" ?>">
                        <img src="<?=$detail_img[$i]['src']?>" class="d-block w-100" alt="<?=$detail_img[$i]['title']?>">
                      </div>
                    <?php
                    }
                    ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden"><?=$this->lang->line('previous')?></span>
                      </button>
                      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden"><?=$this->lang->line('next')?></span>
                      </button>
                  </div>

                </div>
            </div>
        </div>
    </body>
    
    <script>
        function set_delete(){
            
            <?php if($this->session->userdata('level') > 2 || $this->session->userdata('org_idx') == $detail_info['organization_idx']){ ?>
                    if(confirm("<?=$this->lang->line('deleteschedule')?>")){
                        
                            var data = { idx : <?=$detail_info['idx']?>};
                        
                            $.ajax({
                                url:'/schedule/delete_ajax',
                                type:'post',
                                data:data,
                                success:function(data){
                                    if(data.result == 200){
                                        alert('<?=$this->lang->line('completedelete')?>');
                                        window.parent.location.reload();
                                    }else{
                                        alert('<?=$this->lang->line('checktodata')?>');
                                        console.log(data);
                                    }
                                },
                                error: function(xhr,status,error) {
                                    console.log(xhr,status,error);
                                    alert("<?=$this->lang->line('neterror')?>");
                                    return false;
                                }	 
                            });
            
                    }
            <?php }else{ ?>
                
                alert("<?=$this->lang->line('permiterror')?>");
                
            <?php } ?>
        }
        
        
        function set_mark(){
            
            var data = { idx : <?=$detail_info['idx']?>};
                        
            $.ajax({
                url:'/schedule/mark_ajax',
                type:'post',
                data:data,
                success:function(data){
                    if(data.result == 200){
                        alert('<?=$this->lang->line('completebookmark')?>');
                        window.parent.location.reload();
                    }else{
                        alert(data.message);
                        console.log(data);
                    }
                },
                error: function(xhr,status,error) {
                    console.log(xhr,status,error);
                    alert("<?=$this->lang->line('neterror')?>");
                    return false;
                }	 
            });
        
        }
        
        function google_set(){
            var text = "kpop_<?=$detail_info['name']?>";
            var dates = "<?=date('Ymd H0000',strtotime($detail_info['start_date']))?>/<?=date('Ymd H0000',strtotime($detail_info['end_date']))?>";
            var location = "<?=$detail_info['addr']?>";
            var detail = "<div><?=$detail_info['space']?></div>"
                        +"<div>homepage : <?=$detail_info['homepage']?></div>"
                        +"<div>facebook : <?=$detail_info['face']?></div>"
                        +"<div>instagram : <?=$detail_info['insta']?></div>"
                        +"<div>youtube: <?=$detail_info['yout']?></div>";
            
            window.open('about:blank').location.href = "https://calendar.google.com/calendar/r/eventedit?text="+text+"&dates="+dates+"&location="+location+"&details="+detail;
        }
        
        function link_set(){
            
            
            copyToClipboard("kpopineu.com/schedule/list?detail=<?=$detail_info['idx']?>");
            alert("<?=$this->lang->line('completeinsert')?>");
            
        }
        
        
        function copyToClipboard(val) {
            const t = document.createElement("textarea");
            document.body.appendChild(t);
            t.value = val;
            t.select();
            document.execCommand('copy');
            document.body.removeChild(t);
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
        let marker;
        
        async function initMap() {
            
            const { Map, InfoWindow } = await google.maps.importLibrary("maps") ;
            const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

            map = new Map(document.getElementById("map"), {
              center: { lat: <?=$detail_info['space_x']?>, lng: <?=$detail_info['space_y']?> },
              zoom: 14,
              mapId: '4504f8b37365c3d0',
            });
          
            const infoWindow = new InfoWindow();
          
            /*marker = new AdvancedMarkerElement({
                map,
                position: {lat:<?=$detail_info['space_x']?>, lng: <?=$detail_info['space_y']?>},
                title: "<?=$detail_info['space']?>",
                gmpClickable: true
            });*/
            
            const label = new google.maps.Marker({
                                position: {lat:<?=$detail_info['space_x']?>, lng: <?=$detail_info['space_y']?>},
                                map: map,
                                icon: {
                                    url: "data:image/svg+xml;charset=UTF-8," + encodeURIComponent(`
                                      <svg xmlns="http://www.w3.org/2000/svg" width="100" height="60">
                                        <!-- 길쭉한 사각형 부분 -->
                                        <rect width="100" height="40" fill="red" rx="5"/>
                                        <!-- 아래 뾰족한 삼각형 부분 -->
                                        <polygon points="50,50 65,80 35,80" fill="red"/>
                                        <!-- 텍스트 -->
                                        <text x="50" y="25" font-size="11" text-anchor="middle" fill="white"><?=$detail_info['space']?></text>
                                      </svg>
                                    `),
                                    scaledSize: new google.maps.Size(100, 60),  // 아이콘 크기 조정
                                  }
                              });
            
        }
        
        initMap();  
        
    </script>
</html>