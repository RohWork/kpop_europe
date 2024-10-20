
<?php
    $lang = $this->session->userdata('lang');
    $this->lang->load('view', $lang);

?>


    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <div class="container" style="overflow:auto">
        <form id="calendar_insert">
            <div class="row">
                <label class="form-label"><h3><?=$this->lang->line('scheduleinsert')?></h3></label>
            </div>
            <div class="row mt-1">
                <label class="form-label col-md-2 col-xs-4"><strong>Event</strong></label>
                <div class="col-md-4 col-xs-4 col-md-offset-6 col-xs-offset-4">
                    <input type="text" class="form-control" id="input_name" name="input_name" required/>
                </div>
            </div>
            <div class="row mt-1">
                <label class="form-label col-md-2 col-xs-4"><strong>Event Type</strong></label>
                <div class="col-md-4 col-xs-4 col-md-offset-6 col-xs-offset-4">
                    <select class="form-select" id="input_type" name="input_type">
                        <option value="party">party</option>
                        <option value="concert">concert</option>      
                    </select>
                </div>
            </div>
            
            <div class="row mt-1">
                <label class="form-label col-md-2 col-xs-4"><strong><?=$this->lang->line('country')?></strong></label>

                <div class="col-md-4 col-xs-4 col-md-offset-6 col-xs-offset-4">
                    <select id="check_country" name="check_country" class="form-select">
                        <?php foreach($country as $cnt){ ?>
                            <option value="<?=$cnt['idx']?>"><?=$cnt['name']?></option>

                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="row mt-1">
                <label class="form-label col-md-2 col-xs-4"><strong><?=$this->lang->line('city')?></strong></label>

                <div class="col-md-4 col-xs-4 col-md-offset-6 col-xs-offset-4">
                    <select class="form-select" id="check_city" name="check_city">
                        <option value=""></option>
                    </select>
                </div>
            </div>
            
            <div class="row mt-1">

                <label class="form-label col-md-2 col-xs-4"><strong><?=$this->lang->line('orgernization')?></strong></label>

                <div class="col-md-4 col-xs-4 col-md-offset-6 col-xs-offset-4">
                        <select id="check_organization" name="check_organization" class="form-select">
                            <?php foreach($organization as $org){ ?>
                                <option value="<?=$org['idx']?>"><?=$org['name']?></option>

                            <?php } ?>
                        </select>
                </div>
            </div>

            <div class="row mt-1">

                <label class="form-label col-md-2 col-xs-4"><strong><?=$this->lang->line('location')?></strong></label>

                <div class="col-md-4 col-xs-4 col-md-offset-6 col-xs-offset-4">
                    <select class="form-select" id="input_space" name="input_space">
                        <option value=""></option>
                    </select>
                </div>
            </div>
            <div class="row mt-1">

                <label class="form-label col-md-2 col-xs-4"><strong><?=$this->lang->line('address')?></strong></label>

                <div class="col-md-4 col-xs-4 col-md-offset-6 col-xs-offset-4">
                    <input type="text" class="form-control" id="input_addr" name="input_addr" required/>
                </div>
            </div>
            <div class="row mt-1">
                <label class="form-label col-md-2 col-xs-4"><strong>Hompage</strong></label>
                <div class="col-md-4 col-xs-4 col-md-offset-6 col-xs-offset-4">
                    <input type="text" class="form-control" id="input_homepage" name="input_homepage"/>
                </div>
            </div>
            <div class="row mt-1">

                <label class="form-label col-md-2 col-xs-4"><strong>Facebook</strong></label>
                
                <div class="col-md-4 col-xs-4 col-md-offset-6 col-xs-offset-4">
                    <input type="text" class="form-control" id="input_face" name="input_face"/>
                </div>
            </div>
            <div class="row mt-1">

                <label class="form-label col-md-2 col-xs-4"><strong>Instagram</strong></label>
                
                <div class="col-md-4 col-xs-4 col-md-offset-6 col-xs-offset-4">
                    <input type="text" class="form-control" id="input_insta" name="input_insta"/>
                </div>
            </div>
            <div class="row mt-1">
 
                <label class="form-label col-md-2 col-xs-4"><strong>Youtube</strong></label>

                <div class="col-md-4 col-xs-4 col-md-offset-6 col-xs-offset-4">
                    <input type="text" class="form-control" id="input_yout" name="input_yout"/>
                </div>
            </div>
            <div class="row mt-1">

                <label class="form-label col-md-2 col-xs-4"><strong><?=$this->lang->line('startdate')?></strong></label>

                <div class="col-md-4 col-xs-4 col-md-offset-6 col-xs-offset-4 ">
                    <input type="text" class="form-control" id="input_start_date"  name="input_start_date" required/>
                </div>
            </div>
            <div class="row mt-1">

                <label class="form-label col-md-2 col-xs-4"><strong><?=$this->lang->line('enddate')?></strong></label>

                <div class="col-md-4 col-xs-4 col-md-offset-6 col-xs-offset-4 ">
                    <input type="text" class="form-control" id="input_end_date"  name="input_end_date" required/>
                </div>
            </div>
            <div class="row mt-1">
                
                <label class="form-label col-md-2 col-xs-4"><strong><?=$this->lang->line('etc')?></strong></label>

                <div class="col-md-4 col-xs-4 col-md-offset-6 col-xs-offset-4">

                    <textarea id="input_remark" class="form-control" name="input_remark"> </textarea>
                </div>
            </div>
            <div class="row mt-1">

                <label class="form-label col-md-2 col-xs-4"><strong>Image</strong></label>
                
                <div class="col-md-4 col-xs-4 col-md-offset-6 col-xs-offset-4" id="image_group" style="overflow-y: auto;height: 100px">
                    <div class="input-group mb-2 mt-1">
                        <input type="text" id="input_image[]" class="form-control i_img" name="input_image[]"/>
                        <button type="button" class="btn btn-primary" id="input_url">+</button>
                    </div>
                </div>
            </div>
            <div class="row mt-1" style="padding-top:50px">
                
                <div class="col-md-2 col-xs-2 "></div>
                <div class="col-md-4 col-xs-6 col-offset-6 col-xs-offset-4 text-center">
                    <button type="button" class="btn btn-success" id="btn_insert"><?=$this->lang->line('insert')?></button>
                    <button type="button" class="btn btn-danger" id="btn_reset" onclick="form.reset();"><?=$this->lang->line('reset')?></button>
                </div>
            </div>
        </form>
    </div>

    <script>
    
    get_country_data();
    
    $("#input_url").click(function() {
        $("#image_group").append(
                "<div class='input-group mb-2 mt-1'><input type='text' id='input_image[]' class='form-control i_img' name='input_image[]'/><button type='button' class='btn btn-primary' id='input_url'>+</button></div>"
        );

        $("#insert_modal").dialogHeight = document.body.scrollHeight + 'px';
    });
        
    $("#btn_insert").on("click", function(){
        $("#calendar_insert").submit();   
    });
    
    $("#check_country").change(function(){
        get_country_data();
    });
    
    $(function(){
        $("#calendar_insert").validate({
            messages:{
                title: {
                    required : "<?=$this->lang->line('titleerror')?>"
                }
            },
            submitHandler: function (form){
   
                var data = $("#calendar_insert").serializeArray();

                $.ajax({
                    url:'/schedule/insert_ajax',
                    type:'post',
                    data: data,
                    success:function(data){
                        if(data.result == 200){
                            alert('<?=$this->lang->line('completeinsert')?>');
                            location.reload();
                        }else{

                            alert(data.message);
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
        });
        
    });
    
    function get_country_data(){
        
        var j = $("#check_country option:selected").val();
        var data = { country_idx : j };
        
        $.ajax({
            url:'/city/get_ajax',
            type:'post',
            data: data,
            success:function(data){
                if(data.code == 200){
                    
                    var data_array = data.result;
                    console.log(data_array);
                    
                    $('#check_city').empty();
                    for(var i =0; i<data_array.length;i++){
                        var option = $("<option value="+data.result[i]['idx']+">"+data.result[i]['name']+"</option>");
                        $('#check_city').append(option);
                        
                    }
                    
                    
                    
                }else{

                    //alert(data.message);
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
    function get_space_data(){
        
        var co = $("#check_country option:selected").val();
        var ci = $("#check_city option:selected").val();
        
        var data = { country_idx : co, country_idx : ci };
        
        $.ajax({
            url:'/city/get_ajax',
            type:'post',
            data: data,
            success:function(data){
                if(data.code == 200){
                    
                    var data_array = data.result;
                    console.log(data_array);
                    
                    $('#input_space').empty();
                    for(var i =0; i<data_array.length;i++){
                        var option = $("<option value="+data.result[i]['idx']+">"+data.result[i]['name']+"</option>");
                        $('#input_space').append(option);
                        
                    }
                    
                    
                    
                }else{

                    //alert(data.message);
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
    
        $('#input_start_date').datetimepicker({
            format: 'd/m/Y H:00:00'
        });
        $('#input_end_date').datetimepicker({
            format: 'd/m/Y H:00:00'
        });
    </script>
    <style>
        .error{ color:red; font-weight: bold; }
    </style>
</main>

