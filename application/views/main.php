<?php
    $lang = $this->session->userdata('lang');
    $this->lang->load('view', $lang);

?>

<div class="container">
    <div class="row">
        <div class="col-4">
            <h4><?=$this->lang->line('fast_schedule')?></h4>
            <table class="table">
                <tr>
                    <th><?=$this->lang->line('location')?></th>
                    <th><?=$this->lang->line('date')?></th>
                    
                </tr>
                <?php 
                    if(!empty($schedule_list)){
                        foreach($schedule_list as $schedule){
                ?>
                    <tr onclick="go_schedule(<?=$schedule['idx']?>)">
                        <td><?=$schedule['start_date']?></td><td><?=$schedule['space']?></td>
                    </tr>
                <?php
                            
                        }
                    }else{
                        echo "<tr><td colspan='2' align='center'>".$this->lang->line('empty')."</td></tr>";
                        
                    }
                ?>          
            </table>
        </div>
        <div class="col-4">
            <h4><?=$this->lang->line('fast_community')?></h4>
            <table class="table">
                <tr>
                    <th><?=$this->lang->line('title')?></th>
                    <th><?=$this->lang->line('date')?></th>
                    <th><?=$this->lang->line('likecnt')?></th>
                    
                </tr>
                <?php 
                    if(!empty($community_idx)){
                        foreach($community_idx as $community){
                ?>
                    <tr onclick="go_community(<?=$community['idx']?>)">
                        <td><?=$community['title']?></td>
                        <td><?=$community['reg_date']?></td>
                        <td><?=$community['great']?></td>
                    </tr>
                <?php
                            
                        }
                    }else{
                        echo "<tr><td colspan='3' align='center'>".$this->lang->line('empty')."</td></tr>";
                        
                    }
                ?>          
            </table>
        </div>
        <div class="col-4">
            <h4><?=$this->lang->line('great_community')?></h4>
            <table class="table">
                <tr>
                    <th><?=$this->lang->line('title')?></th>
                    <th><?=$this->lang->line('likecnt')?></th>
                    <th><?=$this->lang->line('date')?></th>
                    
                </tr>
                <?php 
                    if(!empty($community_great)){
                        foreach($community_great as $community){
                ?>
                    <tr onclick="go_community(<?=$community['idx']?>)">
                        <td><?=$community['title']?></td>
                        <td><?=$community['great']?></td>
                        <td><?=$community['reg_date']?></td>
                    </tr>
                <?php
                            
                        }
                    }else{
                        echo "<tr><td colspan='3' align='center'>".$this->lang->line('empty')."</td></tr>";
                        
                    }
                ?>          
            </table>
        </div>
    </div>
</div>
<script>
    function go_community(idx){
        var url="/community/detail/"+idx;
        location.href= url;
    }
    
    function go_schedule(idx){
        var url="/schedule/list?detail="+idx;
        location.href=url;
    }
</script>
</main>