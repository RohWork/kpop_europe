    <div class="container form-group">
        <form id="country_insert">
            <div class="row">
                <label class="form-label"><h3>Country Insert</h3></label>
            </div>
            <div class="row mt-1">
                <label class="form-label col-2"><strong>Country name</strong></label>

                <div class="col-4 col-offset-6">
                    <input type="text" class="form-control" id="input_country" name="input_country"/>
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
        var country_val = $("#input_country").val();
        if(country_val == ""){
            alert("insert to country data");
            return;
        }else{
            
            $.ajax({
                url:'/country/insert_ajax',
                type:'post',
                data:$("#country_insert").serialize(),
                success:function(data){
                    if(data.result == 200){
                        alert('complete to insert');
                        location.href = "/country";
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