<?php
    $lang = $this->session->userdata('lang');
    if(empty($lang)){
        $lang = 'en';
    }
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
        <div class="container" style="font-size: 12px;padding-top: 15px;padding-left: 15px">
            <div class="row row_border">
                <div class="col-3">
                    <label class="form-label"><strong><?=$this->lang->line('event')?></strong></label>
                </div>
                <div class="col-9">
                    <p><?=$detail_info['name']?></p>
                </div>
            </div>
            <div class="row row_border">
                <div class="col-3">
                    <label class="form-label"><strong><?=$this->lang->line('country')?></strong></label>
                </div>
                <div class="col-9">
                    <p><?=$detail_info['country_name']?></p>
                </div>
            </div>
            <div class="row row_border">
                <div class="col-3">
                    <label class="form-label"><strong><?=$this->lang->line('city')?></strong></label>
                </div>
                <div class="col-9">
                    <p><?=$detail_info['city_name']?></p>
                </div>
            </div>
            <div class="row row_border">
                <div class="col-3">
                    <label class="form-label"><strong><?=$this->lang->line('orgernizer')?></strong></label>
                </div>
                <div class="col-9">
                    <p><?=$detail_info['orgernizer']?></p>
                </div>
            </div>
            <div class="row row_border">
                <div class="col-3">
                    <label class="form-label"><strong><?=$this->lang->line('homepage')?></strong></label>
                </div>
                <div class="col-9">
                    <p><a href="<?=$detail_info['homepage']?>?>"><?=$detail_info['homepage']?></a></p>
                </div>
            </div>
            <div class="row row_border">
                <div class="col-3">
                    <label class="form-label"><strong><?=$this->lang->line('location')?></strong></label>
                </div>
                <div class="col-9">
                    <p><?=$detail_info['space']?></p>
                </div>
            </div>
            <div class="row row_border">
                <div class="col-3">
                    <label class="form-label"><strong><?=$this->lang->line('address')?></strong></label>
                </div>
                <div class="col-9">
                    <p><?=$detail_info['addr']?></p>
                </div>
            </div>
            <div class="row row_border">
                <div class="col-3">
                    <label class="form-label"><strong>Facebook</strong></label>
                </div>
                <div class="col-9">
                    <p><a href="<?=$detail_info['face']?>" target="_blankt"><?=$detail_info['face']?></a></p>
                </div>
            </div>
            <div class="row row_border">
                <div class="col-3">
                    <label class="form-label"><strong>Instagram</strong></label>
                </div>
                <div class="col-9">
                    <p><a href="<?=$detail_info['insta']?>"  target="_blank"><?=$detail_info['insta']?></a></p>
                </div>
            </div>
            <div class="row row_border">
                <div class="col-3">
                    <label class="form-label"><strong>Youtube</strong></label>
                </div>
                <div class="col-9">
                    <p><a href="<?=$detail_info['yout']?>" target="_blankt"><?=$detail_info['yout']?></a></p>
                </div>
            </div>
            <div class="row row_border">
                <div class="col-3">
                    <label class="form-label"><strong><?=$this->lang->line('date')?></strong></label>
                </div>
                <div class="col-9">
                    <p><?=date('d-m-Y H:00:00',strtotime($detail_info['start_date']))?> ~ <?=date('d-m-Y H:00:00',strtotime($detail_info['end_date']))?></p>
                </div>
            </div>
            <div class="row row_border">
                <div class="col-3">
                    <label class="form-label"><strong><?=$this->lang->line('etc')?></strong></label>
                </div>
                <div class="col-9">
                    <p><?=str_replace("\r\n", "<br>",$detail_info['remark'])?></p>
                </div>
            </div>
            <div class="row row_border">
                <div class="col-3">
                    <label class="form-label"><strong>Image</strong></label>
                </div>
                <div class="col-9" >
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
            <div class="row">
                
                <div class="col-9 text-center">
            <?php if(!empty($this->session->userdata('name') )){ ?>
               
                    <button type="button" class="btn btn-outline-success bookmark" onclick="calendar_mark()" aria-label="Bookmark"> <?=$this->lang->line('bookmark')?> </button>
                    <button type="button" class="btn btn-outline-success bookmark" onclick="google_set()" aria-label="Google" > <?=$this->lang->line('google')?> </button>
                    <button type="button" class="btn btn-outline-success bookmark" onclick="link_set()" aria-label="Link" > <?=$this->lang->line('link')?> </button>
                    
                    <button type="button" class="btn <?=$like>0 ? "btn-success":"btn-outline-success"?> bookmark" onclick="like_set()" aria-label="Like" > <?=$this->lang->line('like')?> </button>

            <?php } if(($this->session->userdata('level') > 2 || $this->session->userdata('org_idx') == $detail_info['organization_idx']) && empty($mode)){ ?>

                    <button type="button" class="btn btn-warning"  onclick="set_modify()"><?=$this->lang->line('modify')?></button>
                    <button type="button" class="btn btn-danger"  onclick="set_delete()"><?=$this->lang->line('delete')?></button>

            <?php } ?>

                    <button type="button" class="btn btn-info"  onclick="self.close();parentClose();"><?=$this->lang->line('close')?></button>
                </div>
            </div>
        </div>
    </body>
    
    <script>
        function set_delete(){
            
            <?php if($this->session->userdata('level') > 2 || $this->session->userdata('org_idx') == $detail_info['organization_idx']){ ?>
                    if(confirm("do you want to delete to the schedule?")){
                        
                            var data = { idx : <?=$detail_info['idx']?>};
                        
                            $.ajax({
                                url:'/schedule/delete_ajax',
                                type:'post',
                                data:data,
                                success:function(data){
                                    if(data.result == 200){
                                        alert('<?=$this->lang->line('completedelete')?>');
                                        window.opener.location.reload();
                                        self.close();
                                    }else{
                                        alert(data.message);
                                        //console.log(data);
                                        return false;
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
        
        function set_modify(){
            
            location.href="/schedule/modify/<?=$detail_info['idx']?>";
            
            
        }
        function calendar_mark(){
            
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
        
        function like_set(){
            
            var mode = 1;
            var data = { idx : <?=$detail_info['idx']?>, mode: mode};
            
            
            $.ajax({
                url:'/schedule/like_ajax',
                type:'post',
                data:data,
                success:function(data){
                    if(data.result == 200){
                        
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
        
        function copyToClipboard(val) {
            const t = document.createElement("textarea");
            document.body.appendChild(t);
            t.value = val;
            t.select();
            document.execCommand('copy');
            document.body.removeChild(t);
        }
        
        function parentClose(){
            window.parent.frameClose();
        }
    </script>
</html>