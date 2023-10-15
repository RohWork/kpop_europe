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
                                    alert("'<?=$this->lang->line('neterror')?>'");
                                    return false;
                                }	 
                            });
            
                    }
            <?php }else{ ?>
                
                alert("this not permmited");
                
            <?php } ?>
        }
        
        
        function set_mark(){
            
            var data = { idx : <?=$detail_info['idx']?>};
                        
            $.ajax({
                url:'/schedule/delete_ajax',
                type:'post',
                data:data,
                success:function(data){
                    if(data.result == 200){
                        alert('complete to delete');
                        window.parent.location.reload();
                    }else{
                        alert('input fail. check to data.');
                        console.log(data);
                    }
                },
                error: function(xhr,status,error) {
                    console.log(xhr,status,error);
                    alert("Network error!! Confirm to Manager!!");
                    return false;
                }	 
            });
        
        }
    </script>
</html>