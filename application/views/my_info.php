<?php
    $lang = $this->session->userdata('lang');
    $this->lang->load('view', $lang);
?>


<div class="container">
    <form method="post" id="info_form">
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
                            if($user_info['country'] == $cnt['idx']){
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
                            if($user_info['city'] == $cty['idx']){
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
                <input type="submit" class="btn btn-primary" />
            </div>
        </div>
    </form>
</div>