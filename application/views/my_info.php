<?php
    $lang = $this->session->userdata('lang');
    $this->lang->load('view', $lang);
?>


<div class="container">
    <form method="post" id="info_form" action="/member/my_info_set">
        <div class="row">
                    <label class="form-label"><h3><?=$this->lang->line('myinfomodify')?></h3></label>
                </div>
        <div class="row">
            <div class="col-2">
                <label class="form-label">
                    <strong><?=$this->lang->line('country')?></strong>
                </label>
            </div>
            <div class="col-2">

                    <select id="check_country" name="country" class="form-select" onchange="get_country_data()">
                        <option value=""></option>
                        <?php foreach($country_list as $cnt){ 
                            $search_cnt = "";
                            if($user_info['country_idx'] == $cnt['idx']){
                                $search_cnt = "selected";
                            }
                        ?>
                            <option value="<?=$cnt['idx']?>" <?=$search_cnt?>><?=$cnt['name']?></option>

                        <?php } ?>
                    </select>

            </div>
        </div>
        <div class="row">
            <div class="col-2">
                <label class="form-label">
                    <strong><?=$this->lang->line('city')?></strong>
                </label>
            </div>
            <div class="col-2">

                    <select id="check_city" name="city" class="form-select">
                        <option value=""></option>
                        <?php foreach($city_list as $cty){ 

                            $search_cty = "";
                            if($user_info['city_idx'] == $cty['idx']){
                                $search_cty = "selected";
                            }

                        ?>
                            <option value="<?=$cty['idx']?>" <?=$search_cty?>><?=$cty['name']?></option>

                        <?php } ?>
                    </select>
            </div>
        </div>
        <div class="row">
            <div class="col-2">
                <label class="form-label">
                    <strong><?=$this->lang->line('language')?></strong>
                </label>
            </div>
            <div class="col-2">
                <select id="check_langueage" name="language" class="form-select">
                    <?php 
                        $lang_array = get_langueage_list();

                        for($i=0;$i<count($lang_array);$i++){

                            $search_lang = "";
                            if($user_info['language'] == $lang_array[$i]['id']){
                                $search_lang = "selected";
                            }
                         ?>

                            <option value="<?=$lang_array[$i]['id']?>" <?=$search_lang?>><?=$lang_array[$i]['val']?></option>
                    <?php
                        }
                    ?>

                </select>

            </div>
        </div>
        <div class="row" style="margin-top: 15px;">
            
            <div class="col-4" style="text-align: right">
                <input type="submit" class="btn btn-primary" value="<?=$this->lang->line('confirm')?>"/>
            </div>
        </div>
    </form>
</div>

<script>
    
    $(document).ready(function(){
       get_country_data(); 
    });
    
    
    function get_country_data(){
        
        var j = $("#check_country option:selected").val();
        var data = { country_idx : j };
        
       $('#check_city').empty();
        
        $.ajax({
            url:'/city/get_ajax',
            type:'post',
            data: data,
            success:function(data){
                if(data.code == 200){
                    
                    var data_array = data.result;

                    $('#check_city').append("<option value=''></option>");
                    for(var i =0; i<data_array.length;i++){
                        
                        if(j == <?=$user_info['country_idx']?>){
                            if(data.result[i]['idx'] == <?=$user_info['city_idx']?>){
                                var selected = "selected";
                            }else{
                                var selected = "";
                            }
                        }
                        
                        var option = $("<option value="+data.result[i]['idx']+" "+selected+">"+data.result[i]['name']+"</option>");
                        $('#check_city').append(option)
                        
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
    
</script>
</main>