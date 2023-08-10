<?php
    $lang = $this->session->userdata('lang');
    $this->lang->load('view', $lang);
?>


<div class="container" style="font-size: 12px;">
            <form method="get">
                <div class="row">
                    
                    <label class="col-2 form-label">
                        <?=$this->lang->line('country')?>
                    </label>
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
                            <label class="form-label "><?=$this->lang->line('country')?></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        <div class="form-floating">
                            <select id="check_city" name="city" class="form-select">
                                <option value=""></option>
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
                </div>
                <div class="row">
                    
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
                </div>
            </form>
</div>