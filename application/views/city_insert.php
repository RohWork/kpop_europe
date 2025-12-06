<?php
    $lang = $this->session->userdata('lang');
    $this->lang->load('view', $lang);
    if(!empty($city_name)){
?>
        <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" media="screen" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>
        <script src="https://kit.fontawesome.com/89b002c3b7.js" crossorigin="anonymous"></script>
        <script src="/asset/js/jquery.cookie-1.4.1.min.js" crossorigin="anonymous"></script>
<?php
    }
?>

    <div class="container">
        <form id="city_insert">
            <div class="form-group">
                <div class="row">
                    <label class="form-label"><h3><?=$this->lang->line('cityinsert')?></h3></label>
                </div>
                <div class="row mt-1">
                    <label class="form-label col-md-2 col-xs-4"><strong><?=$this->lang->line('country')?></strong></label>

                    <div class="col-md-4 col-xs-4 col-offset-6 col-xs-offset-4">
                        <select id="check_country" name="check_country" class="form-select">
                            <?php 
                                foreach($country as $cnt){ 
                                    $selected = "";
                                    if($cnt['idx'] == $select_country){
                                        $selected = "selected";
                                    }
                                    ?>
                                
                                <option value="<?=$cnt['idx']?>" <?=$selected?>><?=$cnt['name']?></option>

                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="row mt-1">
                    <label class="form-label col-md-2 col-xs-4"><strong><?=$this->lang->line('cityname')?></strong></label>

                    <div class="col-md-4 col-xs-4 col-md-offset-6 col-xs-offset-4">
                        <input type="text" class="form-control" id="input_city" name="input_city" value="<?=!empty($city_name) ? $city_name : ""?>"/>
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

</main>
<script>
    $("#btn_insert").on('click', function(){
        var city = $("#input_city").val();
        if(city == ""){
            alert("<?=$this->lang->line('errorinsertcity')?>");
            return;
        }else{
            
            $.ajax({
                url:'/city/insert_ajax',
                type:'post',
                data:$("#city_insert").serialize(),
                success:function(data){
                    if(data.result == 200){
                        alert('<?=$this->lang->line('completeinsert')?>');
                        location.href = "/city?country=<?=$select_country?>";
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
    });
    
</script>