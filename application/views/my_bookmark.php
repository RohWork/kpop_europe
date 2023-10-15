<?php
    $lang = $this->session->userdata('lang');
    $this->lang->load('view', $lang);
?>


<div class="container">
   
    <div class="row">
        <label class="form-label"><h3><?=$this->lang->line('mybookmark')?></h3></label>
    </div>

    <div class="row" style="padding-top: 20px">
        <div class="col-12">
            <table class="table table-striped" style="font-size:0.8rem">
                <tr>
                    <th>Type</th>
                    <th><?=$this->lang->line('startdate')?></th>
                    <th><?=$this->lang->line('country')?></th>
                    <th><?=$this->lang->line('city')?></th>
                    <th>Location</th>
                </tr>
                <?php 
                    foreach($bookmark_list as $li){
                ?>        
                <tr onclick="go_detail(<?=$li['idx']?>)" style="cursor: pointer">
                    <td><?=$li['type']?></td>
                    <td><?=$li['start_date']?></td>
                    <td><?=$li['country_name']?></td>
                    <td><?=$li['city_name']?></td>
                    <td><?=$li['space']?></td>
                    <td><button type="button" class="btn btn-danger delete" onclick="mark_delete(<?=$li['mark_idx']?>)" aria-label="Delete"> <?=$this->lang->line('delete')?> </button></td>
                </tr>   
                <?php 
                    }
                ?>
            </table>
        </div>
    </div>
    <div class="row" style="margin-top: 15px;">

    </div>

</div>
</main>
<script>
    
    
    function go_detail(idx){

        var url="/schedule/detail/"+idx;
        
        window.open(url, 'detail', "width=500, height=700" );
        
    }
    
    function mark_delete(mark_idx){
        
    }
    
</script>