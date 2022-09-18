

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
    
    <div id="detail_modal" style="display: none">
        <iframe src="URL" id="detail_frame">대체 내용</iframe>  
        <div class="modal_close"><a href="#">close</a></div>
    </div>


</main>

<script>
    
    function modal(id) {
        var zIndex = 9999;
        var modal = document.getElementById(id);

        // 모달 div 뒤에 희끄무레한 레이어
        var bg = document.createElement('div');
        bg.setStyle({
            position: 'fixed',
            zIndex: zIndex,
            left: '0px',
            top: '0px',
            width: '100%',
            height: '100%',
            overflow: 'auto',
            // 레이어 색갈은 여기서 바꾸면 됨
            backgroundColor: 'rgba(0,0,0,0.4)'
        });
        document.body.append(bg);

        // 닫기 버튼 처리, 시꺼먼 레이어와 모달 div 지우기
        modal.querySelector('.modal_close_btn').addEventListener('click', function() {
            bg.remove();
            modal.style.display = 'none';
        });

        modal.setStyle({
            position: 'fixed',
            display: 'block',
            boxShadow: '0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)',

            // 시꺼먼 레이어 보다 한칸 위에 보이기
            zIndex: zIndex + 1,

            // div center 정렬
            top: '50%',
            left: '50%',
            transform: 'translate(-50%, -50%)',
            msTransform: 'translate(-50%, -50%)',
            webkitTransform: 'translate(-50%, -50%)'
        });
    }

    // Element 에 style 한번에 오브젝트로 설정하는 함수 추가
    Element.prototype.setStyle = function(styles) {
        for (var k in styles) this.style[k] = styles[k];
        return this;
    };
    
    function go_detail(idx){
        
        var url = "/main/detail/"+idx;
        
        $('#detail_frame').attr('src', url);
        
        // 모달창 띄우기
        modal('detail_modal');
        
    }
</script>
