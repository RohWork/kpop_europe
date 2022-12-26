<div style="overflow: auto">
    <table class='table table-striped table-bordered' style='font-size:12px;'>
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
            <th>open</th>
            <th>close</th>
            <th>homepage</th>
            <th>instagram</th>
            <th>facebook</th>
        </tr>

        <?php
            foreach($excel as $ex){
                if($ex['code'] ==1){
                    $color = "color:#004D40";
                }else{
                    $color = "color:#B71C1C";
                }
        ?>        
        <tr>
            <td style="<?=$color?>"><?=$ex['result']?></td>
            <td><?=$ex['type']?></td>
            <td><?=$ex['party_name']?></td>
            <td><?=$ex['orgnizer']?></td>
            <td><?=$ex['date']?></td>
            <td><?=$ex['dow']?></td>
            <td><?=$ex['country']?></td>
            <td><?=$ex['city']?></td>
            <td><?=$ex['address']?></td>
            <td><?=$ex['open']?></td>
            <td><?=$ex['close']?></td>
            <td><?=$ex['homepage']?></td>
            <td><?=$ex['insta']?></td>
            <td><?=$ex['facebook']?></td>
        </tr>

        <?php        
            }
        ?>

    </table>
    <center>
        <input type="button" value="HOME" onclick="go_home()" class="btn btn-primary"/>
    </center>
</div>
</main>

<script>
    function go_home(){
        location.href="/main";
    }
</script>