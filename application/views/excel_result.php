<div class="container">
    <div class="row">
        <div class="col-12">
            <table class='table table-striped table-bordered' style='font-size:12px'>
                <tr>
                    <th>result</th>
                    <th>type</th>
                    <th>party_name</th>
                    <th>orgnizer</th>
                    <th>date</th>
                    <th>DOW</th>
                    <th>country</th>
                    <th>city</th>
                    <th>address</th>
                    <th>start_date</th>
                    <th>end_date</th>
                    <th>homepage</th>
                    <th>instagram</th>
                    <th>facebook</th>
                </tr>
		
                <?php
                    foreach($excel as $ex){
                ?>        
                <tr>
                    <td><?=$ex['result']?></td>
                    <td><?=$ex['type']?></td>
                    <td><?=$ex['party_name']?></td>
                    <td><?=$ex['orgnizer']?></td>
                    <td><?=$ex['date']?></td>
                    <td><?=$ex['DOW']?></td>
                    <td><?=$ex['country']?></td>
                    <td><?=$ex['city']?></td>
                    <td><?=$ex['address']?></td>
                    <td><?=$ex['start_date']?></td>
                    <td><?=$ex['end_date']?></td>
                    <td><?=$ex['homepage']?></td>
                    <td><?=$ex['instagram']?></td>
                    <td><?=$ex['facebook']?></td>
                </tr>
                        
                <?php        
                    }
                ?>
                
            </table>
            
            
        </div>
    </div>
    
    
</div>