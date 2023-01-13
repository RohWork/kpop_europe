


        <div class="container" style="font-size: 12px;">
            <form method="get">
                <div class="row">
                    
                    
                    <div class="col-2">
                        <div class="form-floating">
                            <select id="check_country" name="country" class="form-select" onchange="get_country_data()">
                                <option value=""></option>
                                <?php foreach($country_list as $cnt){ 
                                    $search_cnt = "";
                                    if($search['country'] == $cnt['idx']){
                                        $search_cnt = "selected";
                                    }
                                ?>
                                    <option value="<?=$cnt['idx']?>" <?=$search_cnt?>><?=$cnt['name']?></option>

                                <?php } ?>
                            </select>
                            <label class="form-label col-1">
                                COUNTRY
                            </label>
                        </div>
                    </div>
                    
                    <div class="col-2">
                        <div class="form-floating">
                            <select id="check_city" name="city" class="form-select">

                            </select>
                            <label class="form-label col-1">
                                CITY
                            </label>
                        </div>
                    </div>
                    
                    <div class="col-2">
                        <div class="form-floating">
                            <select id="organization" name="organization" class="form-select">
                                <option value=""></option>
                                <?php foreach($organization_list as $org){ 
                                    
                                    $search_org = "";
                                    if($search['organizer'] == $org['idx']){
                                        $search_org = "selected";
                                    }
                                    
                                ?>
                                    <option value="<?=$org['idx']?>" <?=$search_org?>><?=$org['name']?></option>

                                <?php } ?>
                            </select>
                            <label for="organization">
                                ORGERNIZER
                            </label>
                        </div>
                    </div>
                    
                    <div class="col-2">
                        <div class="form-floating">
                            <input type="date" id="date" name="date" class="form-control" value="<?=$search['date']?>"/>
                            <label for="date">
                                SEARCH DATE
                            </label>
                        </div>
                    </div>
                    
                    
                    <div class="col-1">
                        
                        <input type="submit" value="SEARCH" class="btn btn-success"/>
                    </div>
                
                </div>
            </form>
            <div class="row" style="padding-top: 20px">
                <div class="col-12">
                    <table class="table table-striped">
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>START_DATE</th>
                            <th>END_DATE</th>
                        </tr>
                        <?php 
                            $i=1;
                            foreach($list as $li){
                        ?>        
                        <tr onclick="go_detail(<?=$li['idx']?>)" style="cursor: pointer">
                            <td><?=$i?></td>
                            <td><?=$li['name']?></td>
                            <td><?=$li['start_date']?></td>
                            <td><?=$li['end_date']?></td>
                        </tr>   
                        <?php 
                            $i++;
                            }
                        ?>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <?=$paging?>
                </div>
            </div>
        </div>
        
    <script>
    
    function go_detail(idx){

        var url="/schedule/detail/"+idx;
        
        window.open(url, 'detail', "width=500, height=700" );
        
    }
    
    function get_country_data(){
        
        var j = $("#check_country option:selected").val();
        var data = { country_idx : j };
        var city = <?=$search['city']?>;
        
        
        $.ajax({
            url:'/city/get_ajax',
            type:'post',
            data: data,
            success:function(data){
                if(data.code == 200){
                    
                    var data_array = data.result;
                    console.log(data_array);
                    
                    $('#check_city').empty();
                    $('#check_city').append("<option value=''></option>");
                    for(var i =0; i<data_array.length;i++){
                        
                        var selected = "";
                        
                        
                        if(data.result[i]['idx'] == city){
                            selected = "selected";
                        }
                        
                        var option = $("<option value="+data.result[i]['idx']+" "+selected">"+data.result[i]['name']+"</option>");
                        $('#check_city').append(option)
                        
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
    
    </script>
</main>