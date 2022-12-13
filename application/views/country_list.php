    <div class="container">
        <div class="row">
            <table class="table table-striped" style="width:150vx">
                <thead>
                <tr>
                    <th>번호</th>
                    <th>제목</th>
                    <th>등록자</th>
                    <th>등록일</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                        $i =1;
                        foreach($list as $con){
                            echo "<tr>";
                            echo "<td>".$i."</td>";
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
        <div class="row">
            <div class="col-md-2 col-xs-2">
                <button type="button" class="btn btn-primary" id="insert_button">INSERT</button>
            </div>
        </div>
    </div>
</main>