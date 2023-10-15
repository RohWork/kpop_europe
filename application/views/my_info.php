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
                    foreach($list as $li){
                ?>        
                <tr onclick="go_detail(<?=$li['idx']?>)" style="cursor: pointer">
                    <td><?=$li['type']?></td>
                    <td><?=$li['start_date']?></td>
                    <td><?=$li['country_name']?></td>
                    <td><?=$li['city_name']?></td>
                    <td><?=$li['space']?></td>
                </tr>   
                <?php 
                    }
                ?>
            </table>
        </div>
    </div>
    <div class="row" style="margin-top: 15px;">

        <div class="col-4" style="text-align: right">
            <input type="submit" class="btn btn-primary" value="<?=$this->lang->line('confirm')?>"/>
        </div>
    </div>

</div>
</main>
<script>
    
    

    
</script>