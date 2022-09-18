

    <div class="container">
        <table class="table table-bordered table-responsive" style="width:700px">
          <tr align="center" >
            <td>
                <a href=<?php echo '/main/calendar?year='.$preyear.'&month='.$month . '&day=1'; ?>>◀◀</a>
            </td>
            <td>
                <a href=<?php echo '/main/calendar?year='.$prev_year.'&month='.$prev_month . '&day=1'; ?>>◀</a>
            </td>
            <td height="50" bgcolor="#FFFFFF" colspan="3">
                <a href=<?php echo '/main/calendar?year=' . $thisyear . '&month=' . $thismonth . '&day=1'; ?>>
                <?php echo "&nbsp;&nbsp;" . $year . '년 ' . $month . '월 ' . "&nbsp;&nbsp;"; ?></a>
            </td>
            <td>
                <a href=<?php echo '/main/calendar?year='.$next_year.'&month='.$next_month.'&day=1'; ?>>▶</a>
            </td>
            <td>
                <a href=<?php echo '/main/calendar?year='.$nextyear.'&month='.$month.'&day=1'; ?>>▶▶</a>
            </td>
          </tr>
          <tr class="info">
            <th hight="30" width="100">일</td>
            <th width="100">월</th>
            <th width="100">화</th>
            <th width="100">수</th>
            <th width="100">목</th>
            <th width="100">금</th>
            <th width="100">토</th>
          </tr>

          <?php
            // 5. 화면에 표시할 화면의 초기값을 1로 설정
            $day=1;

            // 6. 총 주 수에 맞춰서 세로줄 만들기
            for($i=1; $i <= $total_week; $i++){?>
          <tr>
            <?php
            // 7. 총 가로칸 만들기
            for ($j = 0; $j < 7; $j++) {
                // 8. 첫번째 주이고 시작요일보다 $j가 작거나 마지막주이고 $j가 마지막 요일보다 크면 표시하지 않음
                echo '<td height="50" valign="top">';
                if (!(($i == 1 && $j < $start_week) || ($i == $total_week && $j > $last_week))) {

                    if ($j == 0) {
                        // 9. $j가 0이면 일요일이므로 빨간색
                        $style = "holy";
                    } else if ($j == 6) {
                        // 10. $j가 0이면 토요일이므로 파란색
                        $style = "blue";
                    } else {
                        // 11. 그외는 평일이므로 검정색
                        $style = "black";
                    }

                    // 12. 오늘 날짜면 굵은 글씨
                    if ($year == $thisyear && $month == $thismonth && $day == date("j")) {
                        // 13. 날짜 출력
                        echo '<font class='.$style.'>';
                        echo $day;
                        echo '</font>';
                    } else {
                        echo '<font class='.$style.'>';
                        echo $day;
                        echo '</font>';
                    }
                    if(!empty($calendar[$year."-".sprintf('%02d',$month)."-".sprintf('%02d',$day)])){
                        $cal_data = $calendar[$year."-".sprintf('%02d',$month)."-".sprintf('%02d',$day)];
                        
                        echo "<br/>";
                        echo "<font style='font-size:10px;cursor:pointer' onclick=go_detail('".$cal_data['idx']."')>".$cal_data['name']."</font>";
                    }
                    // 14. 날짜 증가
                    $day++;
                }
                echo '</td>';
            }
         ?>
          </tr>
          <?php } ?>
        </table>
    </div>
    
    <div id="detail_modal" class="modal fade">
        
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <iframe src="URL" id="detail_frame" style="width:100%; height:100%">대체 내용</iframe>  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
    </div>


</main>

<script>

    function go_detail(idx){
        
        var url = "/main/detail/"+idx;
        
        $('#detail_frame').attr('src', url);
        
        // 모달창 띄우기
        $('#detail_modal').modal("show");
        
    }
</script>
