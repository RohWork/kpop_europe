    <style>
        .onpointer{
            cursor: pointer;
        }
    </style>
    <div class="container">
        <div class="row">
            <table class="table table-striped" style="width:30vw">
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
                            echo "<tr onclick=view_info('".$con['idx']."_".$con['name']."') class='onpointer'>";
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
            <div class="col-5 col-offset-7 text-end">
                <button type="button" class="btn btn-primary" id="insert_button">INSERT</button>
            </div>
        </div>
        
        
    <div id="detail_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
        
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe src="" id="detail_frame" style="width:100%; height:100%">etc</iframe>  
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close" data-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </div>
        </div>
    </div>
               
    </div>
    <script>
        $("#insert_button").on("click",function(){
            alert('test');
        })
        
        function view_info(idx_name){
            var idxurl = idx_name.split("_");


            var url = "/country/detail/"+idxurl[0];

            $('#detail_frame').attr('src', url);

            $(".modal-title").text(idxurl[1]);
            // 모달창 띄우기
            $('#detail_modal').modal("show");
        }
    </script>
</main>