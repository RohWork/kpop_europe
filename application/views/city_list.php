<?php
    $lang = $this->session->userdata('lang');
    $this->lang->load('view', $lang);

?>

    <style>
        .onpointer{
            cursor: pointer;
        }
    </style>
    <div class="container" style="overflow: auto">
        <div class="row">
            <div class="col-md-2">
                
                <form action="/city" method="post">
                    <div class="form-floating">
                        <select name="country" id="country_list" onchange="this.form.submit();" class="form-select">
                            <option value="all"><?=$this->lang->line('viewall')?></option>
                            <?php
                                foreach($country as $cnt){
                                    $selected = "";
                                    if($cnt['idx'] == $country_idx){
                                        $selected = "selected";
                                    }
                            ?>        
                            <option value="<?=$cnt['idx']?>" <?=$selected?>><?=$cnt['name']?></option>
                            <?php
                                }
                            ?>
                        </select>
                        <label class="form-label col-1">
                                <?=$this->lang->line('country')?>
                        </label>
                    </div>
                </form>
                
            </div>
        </div>
        <div class="row">
            <div class="col">
                <table class="table table-striped" style="width:30vw">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th><?=$this->lang->line('order')?></th>
                        <th><?=$this->lang->line('countryname')?></th>
                        <th><?=$this->lang->line('name')?></th>
                        <th><?=$this->lang->line('writer')?></th>
                        <th><?=$this->lang->line('registdate')?></th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                            $i =1;
                            foreach($list as $con){
                                echo "<tr onclick=view_info('".$con['idx']."_".$con['name']."') class='onpointer'>";
                                echo "<td>".$i."</td>";
                                echo "<td>".$con['ord']."</td>";
                                echo "<td>".$con['country_name']."</td>";
                                echo "<td>".$con['name']."</td>";
                                echo "<td>".$con['writer']."</td>";
                                echo "<td>".substr($con['regi_date'],0,10)."</td>";
                                echo "</tr>";
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
        
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?=$this->lang->line('detail')?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe src="" id="detail_frame" style="width:100%; height:100%"><?=$this->lang->line('etc')?></iframe>  
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
            var country_idx = $("#country_list option:selected").val(); 
            
            location.href= "/city/insert?country_idx="+country_idx;
        })
        
        function view_info(idx_name){
            var idxurl = idx_name.split("_");


            var url = "/city/detail/"+idxurl[0];

            $('#detail_frame').attr('src', url);

            $(".modal-title").text(idxurl[1]);
            // 모달창 띄우기
            $('#detail_modal').modal("show");
        }
        
        function modal_submit(){
            const frame =  document.getElementById("detail_frame").contentWindow;
            
            frame.modify_city();
        }
        
        function modal_delete(){
            const frame =  document.getElementById("detail_frame").contentWindow;
            
            frame.delete_city();
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