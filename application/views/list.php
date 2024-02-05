<?php
    $lang = $this->session->userdata('lang');
    $this->lang->load('view', $lang);

?>


        <div class="container" style="font-size: 12px;">
            <form method="get">
                <div class="row">
                    
                <div class="col-2">
                    <div class="form-floating">
                        <select id="check_type" name="type" class="form-select">
                            <option value=""></option>
                            <option value="party" <?=$search['type'] == 'party' ? "selected" : "" ?>>PARTY</option>
                            <option value="concert" <?=$search['type'] == 'concert' ? "selected" : "" ?>>CONCERT</option>
                        </select>
                        <label class="form-label col-1">
                            type
                        </label>
                    </div>
                </div>
                    
                    
                    <div class="col-2">
                        <div class="form-floating">
                            <select id="check_country" name="country" class="form-select" onchange="get_country_data()">
                                <option value="all"><?=$this->lang->line('viewall')?></option>
                                <?php foreach($country_list as $cnt){ 
                                    $search_cnt = "";
                                    if($search['country'] == $cnt['idx']){
                                        $search_cnt = "selected";
                                    }
                                ?>
                                    <option value="<?=$cnt['idx']?>" <?=$search_cnt?>><?=$cnt['name']?></option>

                                <?php } ?>
                            </select>
                            <label class="form-label">
                                <?=$this->lang->line('country')?>
                            </label>
                        </div>
                    </div>
                    
                    <div class="col-2">
                        <div class="form-floating">
                            <select id="check_city" name="city" class="form-select">
                                <option value="all"><?=$this->lang->line('viewall')?></option>
                                <?php foreach($city_list as $cty){ 
                                    
                                    $search_cty = "";
                                    if($search['city'] == $cty['idx']){
                                        $search_cty = "selected";
                                    }
                                    
                                ?>
                                    <option value="<?=$cty['idx']?>" <?=$search_cty?>><?=$cty['name']?></option>

                                <?php } ?>
                            </select>
                            <label class="form-label">
                                <?=$this->lang->line('city')?>
                            </label>
                        </div>
                    </div>
                    
                    <div class="col-2">
                        <div class="form-floating">
                            <select id="organization" name="organization" class="form-select">
                                <option value="all"><?=$this->lang->line('viewall')?></option>
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
                                <?=$this->lang->line('orgernizer')?>
                            </label>
                        </div>
                    </div>
                    
                    <div class="col-2">
                        <div class="form-floating">
                            <input type="text" id="date" name="date" class="form-control" value="<?=$search['date']?>"/>
                            <label for="date">
                                <?=$this->lang->line('searchdate')?>
                            </label>
                        </div>
                    </div>
                    
                    
                    <div class="col-1">
                        
                        <input type="submit" value="<?=$this->lang->line('search')?>" class="btn btn-success"/>
                    </div>
                
                </div>
            </form>
            <div class="row" id="info_div" style="margin-top:20px;display: none">
                <div class="col-12">
                    <iframe id="detail_info" style="width: 100%;height: 30vh">
                        
                    </iframe>
                </div>
            </div>
            
            <div class="row" style="padding-top: 20px">
                <div class="col-12">
                    <table class="table table-striped" style="font-size:0.8rem">
                        <tr>
                            <th>Type</th>
                            <th><?=$this->lang->line('startdate')?></th>
                            <th><?=$this->lang->line('country')?></th>
                            <th><?=$this->lang->line('city')?></th>
                            <th><?=$this->lang->line('orgernizer')?></th>
                            <th>Location</th>
                        </tr>
                        <?php 
                            foreach($list as $li){
                        ?>        
                        <tr onclick="go_detail(<?=$li['idx']?>)" style="cursor: pointer">
                            <td><?=$li['type']?></td>
                            <td><?=$li['start_date']?></td>
                            <td><?=$li['country_name']?></td>
                            <td><?=$li['city_name']?></td>
                            <td><?=$li['organization_name']?></td>
                            <td><?=$li['space']?></td>
                        </tr>   
                        <?php 
                            }
                        ?>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <nav aria-label="Page navigation example">
                            <?=$paging?>
                    </nav>
                </div>
            </div>
        </div>
        
    <script>
    $("#date").datepicker({
        dateFormat: "dd-mm-yy"
    });
    
    function go_detail(idx){
        
        $("#info_div").show();
        
        var url="/schedule/frame_detail/"+idx;
        
        $('#detail_info').attr('src', url);
        
    }
    
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

                    $('#check_city').append("<option value='all'><?=$this->lang->line('viewall')?></option>");
                    for(var i =0; i<data_array.length;i++){
                        
                        var option = $("<option value="+data.result[i]['idx']+">"+data.result[i]['name']+"</option>");
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