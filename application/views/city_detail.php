<html>
    <head>
        <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <div class="container" style="font-size: 15px">
            <form id="form_modify">
                <div class="row">
                    <div class="col-4">
                        <label class="form-label bold"><strong>Country_name</strong></label>
                    </div>
                    <div class="col-8">
                        <select id="country_idx" name="country_idx"  class="form-select">
                            <?php foreach($country as $cont){
                                    $selected = "";
                                    if($cont['idx'] == $detail_info['country_idx']){
                                        $selected = "selected";
                                    }
                            ?>
                                
                                <option value="<?=$cont['idx']?>" <?=$selected?>><?=$cont['name']?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row" style="padding-top: 5px">
                    <div class="col-4">
                        <label class="form-label bold"><strong>City_name</strong></label>
                    </div>
                    <div class="col-8">
                        <input type="text" id="city" name="city" value="<?=$detail_info['name']?>" class="form-control"/>
                        <input type="hidden" id="city_idx" name="city_idx" value="<?=$detail_info['idx']?>"/>
                    </div>
                </div>
            </form>
        </div>
    </body>
    <script>
        function modify_city(){
            
            $.ajax({
                url:'/city/modify_ajax',
                type:'post',
                data:$("#form_modify").serialize(),
                success:function(data){
                    if(data.result == 200){
                        alert('complete to modify');
                        window.parent.location.reload();
                        window.parent.modal_close();
                    }else{
                        alert('input fail. check to data.');
                    }
                },
                error: function(xhr,status,error) {
                    console.log(xhr,status,error);
                    alert("Network error!! Confirm to Manager!!");
                    return false;
                }	 
            });
            
        }
        function delete_city(){
            
            
            if(confirm("do you want to delete city?")){
                var data = {idx : <?=$detail_info['idx']?>};

                $.ajax({
                    url:'/city/delete_ajax',
                    type:'post',
                    data:data,
                    success:function(data){
                        if(data.result == 200){
                            alert('complete to delete');
                            window.parent.location.reload();
                            window.parent.modal_close();
                        }else{
                            alert('input fail. check to data.');
                        }
                    },
                    error: function(xhr,status,error) {
                        console.log(xhr,status,error);
                        alert("Network error!! Confirm to Manager!!");
                        return false;
                    }	 
                });
            }
        }
    </script>
</html>