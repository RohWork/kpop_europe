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
                <div class="col-1">

                    <input type="submit" value="<?=$this->lang->line('search')?>" class="btn btn-success"/>
                </div>

            </div>
        </form>
            
        <div class="row">
            <div class="col">
                <table class="table table-striped" style="width:60vw">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th><?=$this->lang->line('countryname')?></th>
                        <th><?=$this->lang->line('cityname')?></th>
                        <th><?=$this->lang->line('name')?></th>
                        <th><?=$this->lang->line('address')?></th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                            $i =1;
                            foreach($list as $con){
                                $idx_space = $con['idx']."_".str_replace(" ", "&nbsp;", $con['space_name']);
                        ?>
                                
                                
                                <tr onclick=view_info("<?=$idx_space?>") class="onpointer">
                                    <td><?=$i?></td>
                                    <td><?=$con['country_name']?></td>
                                    <td><?=$con['city_name']?></td>
                                    <td><?=$con['space_name']?></td>
                                    <td><?=$con['space_location']?></td>
                                </tr>
                        <?php
                                $i++;
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-5 col-offset-7 text-end">
                <button type="button" class="btn btn-primary" id="insert_button"><?=$this->lang->line('insert')?></button>
            </div>
        </div>         
    </div>

    <div class="modal fade" id="detail_modal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
        
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?=$this->lang->line('detail')?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe src="" id="detail_frame" style="width:100%; height:60vh"><?=$this->lang->line('etc')?></iframe>  
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="modal_delete();"><?=$this->lang->line('delete')?></button>
                    <button type="button" class="btn btn-primary" onclick="modal_submit();"><?=$this->lang->line('save')?></button>
                    <button type="button" class="btn btn-secondary close" data-dismiss="modal" aria-label="Close"><?=$this->lang->line('close')?></button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        $("#insert_button").on("click",function(){
            var country_idx = $("#check_country option:selected").val(); 
            var city_idx = $("#check_city option:selected").val(); 
            
            location.href= "/space/insert?country_idx="+country_idx+"&city_idx="+city_idx;
        })
        
        function view_info(idx_name){
            
            console.log(idx_name);
            var idxurl = idx_name.split("_");


            var url = "/space/detail/"+idxurl[0];

            $('#detail_frame').attr('src', url);

            $(".modal-title").text(idxurl[1]);
            // 모달창 띄우기
            $('#detail_modal').modal("show");
        }
        
        function modal_submit(){
            const frame =  document.getElementById("detail_frame").contentWindow;
            
            frame.modify_space();
        }
        
        function modal_delete(){
            const frame =  document.getElementById("detail_frame").contentWindow;
            
            frame.delete_space();
        }
        
        function modal_close(){
            $('#detail_modal').modal('hide');
        }
        
        $(".close").on('click', function(){    
            $('#detail_modal').modal('hide');
        });
        

        $('#detail_modal').on('show.bs.modal', function () {
               $(this).find('.modal-body').css({
                      width:'auto', //probably not needed
                      height:'auto', //probably not needed 
                      'max-height':'100%'
               });
        });
    </script>
</main>