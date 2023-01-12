


        <div class="container" style="font-size: 12px;max-width:100%;">
            <form method="post">
                <div class="row">
                
                    <div class="col-1">
                        <select id="country" name="country" class="form-select">
                            
                        </select>
                    </div>
                    <div class="col-1">
                        <select id="city" name="city" class="form-select">
                            
                        </select>
                    </div>
                    <div class="col-1">
                        <select id="organization" name="organization" class="form-select">
                            
                        </select>
                    </div>
                    <div class="col-1">
                        <input type="date" id="date" name="date" class="form-control"/>
                    </div>
                    
                    <div class="col-1">
                        <input type="submit" value="SEARCH" class="form-control"/>
                    </div>
                
                </div>
            </form>
            <div class="row" style="padding-top: 20px">
                <div class="col-12">
                    <table class="table table-striped">
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>START_DATE</th>
                            <th>END_DATE</th>
                        </tr>
                        <?php 
                            $i=1;
                            foreach($list as $li){
                        ?>        
                        <tr onclick="go_detail(<?=$li['idx']?>)" style="cursor: pointer">
                            <td><?=$i?></td>
                            <td><?=$li['name']?></td>
                            <td><?=$li['start_date']?></td>
                            <td><?=$li['end_date']?></td>
                        </tr>   
                        <?php 
                            $i++;
                            }
                        ?>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <?=$paging?>
                </div>
            </div>
        </div>
        
    <script>
    
    function go_detail(idx){

        var url="/schedule/detail/"+idx;
        
        window.open(url, 'detail', "width=500, height=700" );
        
    }
    
    </script>
</main>