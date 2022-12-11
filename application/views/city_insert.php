    <div class="container form-group">
        <form id="city_insert">
            <div class="row">
                <label class="form-label"><h3>City Insert</h3></label>
            </div>
            <div class="row mt-1">
                <label class="form-label col-2"><strong>Country</strong></label>

                <div class="col-4 col-offset-6">
                    <select id="check_country" class="form-select">
                        <?php foreach($country as $cnt){ ?>
                            <option value="<?=$cnt['idx']?>"><?=$cnt['name']?></option>
                        
                        <?php } ?>
                    </select>
                </div>
            </div>
            
            <div class="row mt-1">
                <label class="form-label col-2"><strong>City name</strong></label>

                <div class="col-4 col-offset-6">
                    <input type="text" class="form-control" id="input_city" name="input_city"/>
                </div>
            </div>
            <div class="row mt-1">
                
                <div class="col-2"></div>
                <div class="col-4 col-offset-6">
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
                url:'/main/city_insert_ajax',
                type:'post',
                data:$("#city_insert").serialize(),
                success:function(data){
                    if(data.result == 200){
                        alert('complete to insert');
                        location.href = "/";
                    }else{
                        alert('input fail. check to data.');
                    }
                },
                error: function(xhr,status,error) {
                    console.log(xhr,status,error);
                    alert("네트워크 오류!! 관리자에게 문의 주세요!!");
                    return false;
                }	 
            });
            
        }
    });
    
</script>