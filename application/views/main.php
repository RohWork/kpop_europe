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
                    <th><?=$this->lang->line('date')?></th>
                    <th><?=$this->lang->line('location')?></th>
                </tr>
                <?php 
                    if(!empty($schedule_list)){
                        foreach($schedule_list as $schedule){
                ?>
                    <tr>
                        <td><?=$schedule['start_date']?></td><td><?=$schedule['location']?></td>
                    </tr>
                <?php
                            
                        }
                    }
                ?>
                <tr>
                    
                </tr>
                
            </table>
        </div>
        <div class="col-4">
            <h4>2</h4>
        </div>
        <div class="col-4">
            <h4>3</h4>
        </div>
    </div>
</div>
</main>