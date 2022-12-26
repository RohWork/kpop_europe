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
                        <th>open</th>
                        <th>close</th>
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
                        <td><?=$ex['dow']?></td>
                        <td><?=$ex['country']?></td>
                        <td><?=$ex['city']?></td>
                        <td><?=$ex['address']?></td>
                        <td><?=$ex['open']?></td>
                        <td><?=$ex['close']?></td>
                        <td><?=$ex['homepage']?></td>
                        <td><?=$ex['instagram']?></td>
                        <td><?=$ex['facebook']?></td>
                    </tr>

                    <?php        
                        }
                    ?>

                </table>
                <center>
                    <input type="button" value="HOME" onclick="go_home()"/>
                </center>
            </div>
        </div>

    </div>
    <script>
        function go_home(){
            location.href="/main";
        }
    </script>
</body>