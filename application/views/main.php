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
                    <tr>
                        <td><?=$schedule['start_date']?></td><td><?=$schedule['space']?></td>
                    </tr>
                <?php
                            
                        }
                    }else{
                        echo "<tr><td colspan='2'>".$this->lang->line('empty')."</td></tr>";
                        
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
                    
                </tr>
                <?php 
                    if(!empty($community_idx)){
                        foreach($community_idx as $community){
                ?>
                    <tr>
                        <td><?=$community['title']?></td><td><?=$schedule['reg_date']?></td>
                    </tr>
                <?php
                            
                        }
                    }else{
                        echo "<tr><td colspan='2'>".$this->lang->line('empty')."</td></tr>";
                        
                    }
                ?>          
            </table>
        </div>
        <div class="col-4">
            <h4><?=$this->lang->line('great_community')?></h4>
            <table class="table">
                <tr>
                    <th><?=$this->lang->line('title')?></th>
                    <th><?=$this->lang->line('date')?></th>
                    
                </tr>
                <?php 
                    if(!empty($community_great)){
                        foreach($community_great as $community){
                ?>
                    <tr>
                        <td><?=$community['title']?></td><td><?=$schedule['reg_date']?></td>
                    </tr>
                <?php
                            
                        }
                    }else{
                        echo "<tr><td colspan='2'>".$this->lang->line('empty')."</td></tr>";
                        
                    }
                ?>          
            </table>
        </div>
    </div>
</div>
</main>