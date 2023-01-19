<html>
    <head>
        <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            .row_border{
                 min-height: 45px;
            }
        </style>
    </head>
    <body>
        <div class="container" style="font-size: 12px;padding-top: 15px;padding-left: 15px">
            <div class="row row_border">
                <div class="col-3">
                    <label class="form-label"><strong>Event</strong></label>
                </div>
                <div class="col-9">
                    <p><?=$detail_info['name']?></p>
                </div>
            </div>
            <div class="row row_border">
                <div class="col-3">
                    <label class="form-label"><strong>Organizer</strong></label>
                </div>
                <div class="col-9">
                    <p><?=$detail_info['company']?></p>
                </div>
            </div>
            <div class="row row_border">
                <div class="col-3">
                    <label class="form-label"><strong>Hompage</strong></label>
                </div>
                <div class="col-9">
                    <p><a href="<?=$detail_info['homepage']?>?>"><?=$detail_info['homepage']?></a></p>
                </div>
            </div>
            <div class="row row_border">
                <div class="col-3">
                    <label class="form-label"><strong>Address</strong></label>
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
                    <label class="form-label"><strong>Date</strong></label>
                </div>
                <div class="col-9">
                    <p><?=$detail_info['start_date']?> ~ <?=$detail_info['end_date']?></p>
                </div>
            </div>
            <div class="row row_border">
                <div class="col-3">
                    <label class="form-label"><strong>Etc</strong></label>
                </div>
                <div class="col-9">
                    <p><?=str_replace("\r\n", "<br>",$detail_info['remark'])?></p>
                </div>
            </div>
            <div class="row row_border" style="min-height: 100px">
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
                        <span class="visually-hidden">Previous</span>
                      </button>
                      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                      </button>
                  </div>

                </div>
            </div>
            
            <?php if($this->session->userdata('level') > 2 || $this->session->userdata('org_idx') == $detail_info['organization_idx']){ ?>
            <div class="row" style="padding-top: 15px">
                <div class="col-4 text-end">
                    <button type="button" class="btn btn-warning" onclick="set_modify()">MODIFY</button>
                </div>
                <div class="col-4 text-end">
                    <button type="button" class="btn btn-danger" onclick="set_delete()">DELETE</button>
                </div>
                <div class="col-4">
                    <button type="button" class="btn btn-info" onclick="self.close();">CANCEL</button>
                </div>
            </div>
            <?php } ?>
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
            <?php }else{ ?>
                
                alert("this not permmited");
                
            <?php } ?>
        }
        
        function set_modify(){
            
            location.href="/schedule/modify/<?=$detail_info['idx']?>";
            
            
        }
        
    </script>
</html>