    <div class="container">
        <div class="row">
            <table class="table table-striped">
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
                        foreach($country as $con){
                            echo "<tr>";
                            echo "<td>".$i."</td>";
                            echo "<td>".$con['name']."<td>";
                            echo "<td>".substr($con['writer'],10)."<td>";
                            echo "<td>".substr($con['regi_date'],10)."<td>";
                            echo "</tr>";
                            
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</main>