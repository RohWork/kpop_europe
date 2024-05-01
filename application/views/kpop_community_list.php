<?php
    $lang = $this->session->userdata('lang');
    $this->lang->load('view', $lang);

?>


        <div class="container" style="font-size: 12px;overflow-y: auto">
            <form method="get">
                <div class="row">
                    
                    
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
                            <label class="form-label "><?=$this->lang->line('country')?></label>
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
                            <label class="form-label "><?=$this->lang->line('city')?></label>
                        </div>
                    </div>
                    
                    
                    <div class="col-2">
                        <div class="form-floating">
                            <select id="check_langueage" name="language" class="form-select">
                                <?php 
                                    $lang_array = get_langueage_list();
                                    
                                    for($i=0;$i<count($lang_array);$i++){
                                    
                                        $search_lang = "";
                                        if($search['language'] == $lang_array[$i]['id']){
                                            $search_lang = "selected";
                                        }
                                     ?>
                                
                                        <option value="<?=$lang_array[$i]['id']?>" <?=$search_lang?>><?=$lang_array[$i]['val']?></option>
                                <?php
                                    }
                                ?>
                                
                            </select>
                            <label for="language" lass="form-labe" >
                                <?=$this->lang->line('language')?>
                            </label>
                        </div>
                    </div>
                    

                    <div class="col-2">
                        <div class="form-floating">
                            <select id="check_schedule" name="kpop_idx" class="form-select">
                                <option value="all"><?=$this->lang->line('viewall')?></option>
                                <?php foreach($schedule_list as $sch){ 
                                    
                                    $search_kpop = "";
                                    if($search['kpop_idx'] == $sch['idx']){
                                        $search_kpop = "selected";
                                    }
                                    
                                ?>
                                    <option value="<?=$sch['idx']?>" <?=$search_kpop?>><?="[".$sch['start_date']."]".$sch['space']?></option>

                                <?php } ?>
                                
                            </select>
                            <label for="language" lass="form-labe" >
                                <?=$this->lang->line('list')?>
                            </label>
                        </div>
                    </div>

                    
                    <div class="col-1">
                        
                        <input type="submit" value="<?=$this->lang->line('search')?>" class="btn btn-success"/>
                    </div>
                
                </div>
            </form>
            <div class="row" style="padding-top: 20px">
                <div class="col-12">
                    <table class="table table-striped table-hover text-center" style="font-size:0.8rem">
                        <tr>
                       
                            <th><?=$this->lang->line('title')?></th>
                            <th><?=$this->lang->line('writer')?></th>
                            <th><?=$this->lang->line('writedate')?></th>
                            <th><?=$this->lang->line('likecnt')?></th>
                            <th><?=$this->lang->line('viewcnt')?></th>
                        
                        </tr>
                        <?php 
                            foreach($list as $li){
                        ?>        
                        <tr onclick="go_detail(<?=$li['idx']?>)" style="cursor: pointer">
                            <td><?=$li['title']?></td>
                            <td><?=$li['mnick']?></td>
                            <td><?=substr($li['reg_date'],0,10) == date('Y-m-d')? substr($li['reg_date'],10,9) : substr($li['reg_date'],0,10) ?></td>
                            <td><?=$li['great']?></td>
                            <td><?=$li['cnt']?></td>
                        </tr>   
                        <?php 
                            }
                            if(empty($list)){
                        ?>
                        <tr>
                            <td colspan="5" style="text-align: center"><?=$this->lang->line('empty')?></td>
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
            <div class="row">
                <div class="col-12 text-end">
                    <button type="button" onclick="go_write()" class="btn btn-primary"><?=$this->lang->line('write')?></button>
                </div>
                
            </div>
        </div>
        
    <script>
    $("#date").datepicker({
        dateFormat: "dd-mm-yy"
    });
    
    function go_detail(idx){

        var url="/community/detail/"+idx;
        
        location.href=url;
        
    }
    function go_write(){
        
        location.href="/community/write?country=<?=$search['country']?>&city=<?=$search['city']?>&language=<?=$search['language']?>&kpop_idx=<?=$search['kpop_idx']?>";
        
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