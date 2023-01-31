<html>
    <head>
        <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" media="screen" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>        
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            .row_border{
                 min-height: 45px;
            }
        </style>
    </head>
    <body>
        <form id="calendar_modify"  method="post">
            <div class="container" style="font-size: 15px;padding-top: 15px;padding-left: 15px">
                <input type="hidden" id="idx" name="idx" value="<?=$detail_info['idx']?>"/>
                <div class="row row_border">
                    <div class="col-3">
                        <label class="form-label"><strong>Event</strong></label>
                    </div>
                    <div class="col-9">
                        <input type="text" id="name" name="name" class="form-control" value="<?=$detail_info['name']?>"/>
                    </div>
                </div>
                <div class="row row_border">
                    <div class="col-3">
                        <label class="form-label"><strong>Country</strong></label>
                    </div>
                    <div class="col-9">
                        <select id="country" name="country" class="form-select" onchange="get_country_data()">
                            <?php foreach($country as $cnt){ 
                                $select_cnt = "";
                                
                                if($cnt['idx'] == $detail_info['country_idx']){
                                    $select_cnt = "selected";
                                }
                                
                                ?>
                                <option value="<?=$cnt['idx']?>" <?=$select_cnt?>><?=$cnt['name']?></option>

                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row row_border">
                    <div class="col-3">
                        <label class="form-label"><strong>City</strong></label>
                    </div>
                    <div class="col-9">
                        <select id="city" name="city" class="form-select">
                            
                        </select>
                    </div>
                </div>
                <div class="row row_border">
                    <div class="col-3">
                        <label class="form-label"><strong>Organizer</strong></label>
                    </div>
                    <div class="col-9">
                        <select id="company" name="company" class="form-select">
                            <?php foreach($organization as $org){ 
                                $select_org = "";
                                
                                if($org['idx'] == $detail_info['organization_idx']){
                                    $select_org = "selected";
                                }
                                
                                ?>
                            
                                <option value="<?=$org['idx']?>" <?=$select_org?>><?=$org['name']?></option>

                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row row_border">
                    <div class="col-3">
                        <label class="form-label"><strong>Hompage</strong></label>
                    </div>
                    <div class="col-9">
                        <input type="text" id="homepage" name="homepage" class="form-control" value="<?=$detail_info['homepage']?>"/>
                    </div>
                </div>
                <div class="row row_border">
                    <div class="col-3">
                        <label class="form-label"><strong>Address</strong></label>
                    </div>
                    <div class="col-9">
                        <input type="text" id="addr" name="addr" class="form-control" value="<?=$detail_info['addr']?>"/>
                    </div>
                </div>
                <div class="row row_border">
                    <div class="col-3">
                        <label class="form-label"><strong>Facebook</strong></label>
                    </div>
                    <div class="col-9">
                        <input type="text" id="face" name="face" class="form-control" value="<?=$detail_info['face']?>"/>
                    </div>
                </div>
                <div class="row row_border">
                    <div class="col-3">
                        <label class="form-label"><strong>Instagram</strong></label>
                    </div>
                    <div class="col-9">
                        <input type="text" id="insta" name="insta" class="form-control" value="<?=$detail_info['insta']?>"/>
                    </div>
                </div>
                <div class="row row_border">
                    <div class="col-3">
                        <label class="form-label"><strong>Youtube</strong></label>
                    </div>
                    <div class="col-9">
                        <input type="text" id="yout" name="yout" class="form-control" value="<?=$detail_info['yout']?>"/>
                    </div>
                </div>
                <div class="row row_border">
                    <div class="col-3">
                        <label class="form-label"><strong>Start Date</strong></label>
                    </div>
                    <div class="col-9">
                        <input type="text" id="start_date" name="start_date" class="form-control" value="<?=date('h:i:s d-m-Y',strtotime($detail_info['start_date']))?>"/>
                    </div>
                </div>
                <div class="row row_border">
                    <div class="col-3">
                        <label class="form-label"><strong>End Date</strong></label>
                    </div>
                    <div class="col-9">
                        <input type="text" id="end_date" name="end_date" class="form-control" value="<?=date('h:i:s d-m-Y',strtotime($detail_info['end_date']))?>"/>
                    </div>
                </div>
                <div class="row row_border">
                    <div class="col-3">
                        <label class="form-label"><strong>Etc</strong></label>
                    </div>
                    <div class="col-9">
                        <textarea class="form-control" id="remark" name="remark">
                            <?=$detail_info['remark']?>
                        </textarea>
                    </div>
                </div>
                <div class="row row_border mt-1" style="min-height: 100px;padding-top: 50px">
                    <div class="col-3">
                        <label class="form-label"><strong>Image</strong></label>
                    </div>
                    <div class="col-9" id="image_group" style="overflow-y: auto;height: 100px">
                        <?php
                            foreach($detail_img as $img){
                        ?>
                        <div class="input-group mb-2 mt-1">
                            <input type="text" id="input_image[]" class="form-control i_img" name="input_image[]" value="<?=$img['src']?>"/>
                            <button type="button" class="btn btn-primary" id="input_url">+</button>
                        </div>
                        <?php
                            }
                        ?>
                        
                        <div class="input-group mb-2 mt-1">
                            <input type="text" id="input_image[]" class="form-control i_img" name="input_image[]"/>
                            <button type="button" class="btn btn-primary" id="input_url">+</button>
                        </div>
                    </div>
                </div>

                <?php if($this->session->userdata('level') > 2 || $this->session->userdata('org_idx') == $detail_info['organization_idx']){ ?>
                <div class="row" style="padding-top:30px;">
                    <div class="col-2"></div>
                    <div class="col-3 text-center">
                        <button type="button" id="btn_modfiy" class="btn btn-success">SUBMIT</button>
                    </div>
                    <div class="col-3 text-center">
                        <button type="button" onclick="form_reset()" class="btn btn-warning">RESET</button>
                    </div>
                    <div class="col-2 text-center">
                        <button type="button" onclick="go_return()" class="btn btn-info">CANCEL</button>
                    </div>
                </div>
                <?php } ?>
            </div>
        </form>
    </body>
    
    <script>
        $( document ).ready(function() {
            get_country_data();
        });
        
        $('#start_date').datetimepicker({
            format: 'H:00:00 d-m-Y'
        });
        $('#end_date').datetimepicker({
            format: 'H:00:00 d-m-Y'
        });
        
        
        $("#input_url").click(function() {
            $("#image_group").append(
                    "<div class='input-group mb-2 mt-1'><input type='text' id='input_image[]' class='form-control i_img' name='input_image[]'/><button type='button' class='btn btn-primary' id='input_url'>+</button></div>"
            );

            $("#insert_modal").dialogHeight = document.body.scrollHeight + 'px';
        });
        function set_modify(){
            
            <?php if($this->session->userdata('level') > 2 || $this->session->userdata('org_idx') == $detail_info['organization_idx']){ ?>
            
                $("#schedule_form").submit();
            
            <?php }else{ ?>
                
                alert("this not permmited");
                
            <?php } ?>
        }
        
        function form_reset(){
            $("#schedule_form").reset();
        }
        
        function go_return(){
            location.href="/schedule/detail/<?=$detail_info['idx']?>";
        }
        
        
    function get_country_data(){
        
        var j = $("#country option:selected").val();
        var data = { country_idx : j };
        
        $.ajax({
            url:'/city/get_ajax',
            type:'post',
            data: data,
            success:function(data){
                if(data.code == 200){
                    
                    var data_array = data.result;
                    console.log(data_array);
                    
                    $('#city').empty();
                    
                    for(var i =0; i<data_array.length;i++){
                        
                        var selected = "";
                        
                        if(data.result[i]['idx'] == <?=$detail_info['city_idx']?>){
                            selected = "selected";
                        }
                        
                        
                        var option = $("<option value='"+data.result[i]['idx']+"'"+selected+">"+data.result[i]['name']+"</option>");
                        $('#city').append(option)
                        
                    }
                    
                    
                    
                }else{

                    //alert(data.message);
                    return false;
                }
            },
            error: function(xhr,status,error) {
                console.log(xhr,status,error);
                alert("Network Error!! take support to web manager!!");
                return false;
            }	 
        });
        
    }
    
    $("#btn_modfiy").on("click", function(){
        
        var data = $("#calendar_modify").serializeArray();

        $.ajax({
            url:'/schedule/modify_ajax',
            type:'post',
            data: data,
            success:function(data){
                if(data.result == 200){
                    alert('modify complete');
                    go_return();
                }else{

                    alert(data.message);
                    return false;
                }
            },
            error: function(xhr,status,error) {
                console.log(xhr,status,error);
                alert("Network Error!! take support to web manager!!");
                return false;
            }	 
        });
            
    });
    
    </script>
</html>