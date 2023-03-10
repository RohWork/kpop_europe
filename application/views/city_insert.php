    <div class="container">
        <form id="city_insert">
            <div class="form-group">
                <div class="row">
                    <label class="form-label"><h3>City Insert</h3></label>
                </div>
                <div class="row mt-1">
                    <label class="form-label col-md-2 col-xs-4"><strong>Country</strong></label>

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
                    <label class="form-label col-md-2 col-xs-4"><strong>City name</strong></label>

                    <div class="col-md-4 col-xs-4 col-md-offset-6 col-xs-offset-4">
                        <input type="text" class="form-control" id="input_city" name="input_city"/>
                    </div>
                </div>
            </div>
            <div class="row mt-1" style="padding-top:50px">
                
                <div class="col-md-2 col-xs-2 "></div>
                <div class="col-md-4 col-xs-6 col-offset-6 col-xs-offset-4 text-center">
                    <button type="button" class="btn btn-success" id="btn_insert">INSERT</button>
                    <button type="button" class="btn btn-danger" id="btn_reset" onclick="form.reset();">RESET</button>
                </div>
            </div>
        </form>
        
    </div>

</main>
<script>
    $("#btn_insert").on('click', function(){
        var city = $("#input_city").val();
        if(city == ""){
            alert("insert to city data");
            return;
        }else{
            
            $.ajax({
                url:'/city/insert_ajax',
                type:'post',
                data:$("#city_insert").serialize(),
                success:function(data){
                    if(data.result == 200){
                        alert('complete to insert');
                        location.href = "/city";
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
    });
    
</script>