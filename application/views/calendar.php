<style>
    .a_border{
        text-decoration: none;
        color:#000;
    }
</style>

    <div class="container">
        <table class="table table-bordered table-responsive" style="width:700px">
          <tr align="center" >
            <td>
                <a class="a_border" href=<?php echo '/main/calendar?year='.$preyear.'&month='.$month . '&day=1'; ?>>◀◀</a>
            </td>
            <td>
                <a class="a_border" href=<?php echo '/main/calendar?year='.$prev_year.'&month='.$prev_month . '&day=1'; ?>>◀</a>
            </td>
            <td height="50" bgcolor="#FFFFFF" colspan="3">
                <a class="a_border" href=<?php echo '/main/calendar?year=' . $thisyear . '&month=' . $thismonth . '&day=1'; ?>>
                <?php echo "&nbsp;&nbsp;" . $month . ' - ' . $year  . "&nbsp;&nbsp;"; ?></a>
            </td>
            <td>
                <a class="a_border" href=<?php echo '/main/calendar?year='.$next_year.'&month='.$next_month.'&day=1'; ?>>▶</a>
            </td>
            <td>
                <a class="a_border" href=<?php echo '/main/calendar?year='.$nextyear.'&month='.$month.'&day=1'; ?>>▶▶</a>
            </td>
          </tr>
          <tr class="info">
            <th hight="30" width="100">SUN</td>
            <th width="100">MON</th>
            <th width="100">TUE</th>
            <th width="100">WED</th>
            <th width="100">THU</th>
            <th width="100">FRI</th>
            <th width="100">SAT</th>
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
                        ?>
                       <font style='font-size:10px;cursor:pointer' onclick="go_detail('<?=$cal_data['idx']."_".$cal_data['name']?>')"><?=$cal_data['name']?></font>
              <?php
                        
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
        <div class="row">
            <div class="col-4">
                <button type="button" id="insert_cal" name="insert_cal" class="btn btn-primary">INSERT</button>
            </div>
        </div>
    </div>
    
    <div id="detail_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
        
        <div class="modal-dialog modal-lg" style="max-height:85%;" role="document">
            <div class="modal-content" style="height:800px">
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

<div id="insert_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
        
        <div class="modal-dialog modal-lg" style="max-height:85%;" role="document">
            <div class="modal-content" style="height:800px">
                <div class="modal-header">
                    <h5 class="modal-title">insert</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-2">
                                <label class="form-label bold"><strong>Event</strong></label>
                            </div>
                            <div class="col-10">
                                <input type="text" id="input_name" name="input_name"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <label class="form-label"><strong>Organizer</strong></label>
                            </div>
                            <div class="col-10">
                                <input type="text" id="input_company" name="input_company"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <label class="form-label"><strong>Hompage</strong></label>
                            </div>
                            <div class="col-10">
                                <a href="<?=$detail_info['homepage']?>?>"><?=$detail_info['homepage']?></a>
                                <input type="text" id="input_homepage" name="input_homepage"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <label class="form-label"><strong>Address</strong></label>
                            </div>
                            <div class="col-10">
                                <input type="text" id="input_addr" name="input_addr"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <label class="form-label"><strong>Facebook</strong></label>
                            </div>
                            <div class="col-10">
                                <input type="text" id="input_face" name="input_face"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <label class="form-label"><strong>Instagram</strong></label>
                            </div>
                            <div class="col-10">
                                <input type="text" id="input_insta" name="input_insta"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <label class="form-label"><strong>Youtube</strong></label>
                            </div>
                            <div class="col-10">
                                <input type="text" id="input_yout" name="input_yout"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <label class="form-label"><strong>Date</strong></label>
                            </div>
                            <div class="col-10">
                                <input type="date" id="input_start_date" name="input_start_date"/>
                                ~
                                <input type="date" id="input_end_date" name="input_end_date"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <label class="form-label"><strong>Etc</strong></label>
                            </div>
                            <div class="col-10">
                                
                                <textarea id="input_remark" name="input_remark"> </textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <label class="form-label"><strong>Etc</strong></label>
                            </div>
                            <div class="col-10">
                                <input type="text" id="input_image[]" name="input_image[]"/>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="insert_submit" aria-label="Close">Submit</button>
                    <button type="button" class="btn btn-secondary close" data-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </div>
        </div>
    </div>

</main>

<script>

    function go_detail(idx_name){
        
        var idxurl = idx_name.split("_");
        
        
        var url = "/main/detail/"+idxurl[0];
        
        $('#detail_frame').attr('src', url);

        $(".modal-title").text(idxurl[1]);
        // 모달창 띄우기
        $('#detail_modal').modal("show");
        
    }
    
    $(".close").on('click', function(){    
        $('#detail_modal').modal('hide');	
        console.log("click close"); 
    });

    $('#detail_modal').on('show.bs.modal', function () {
           $(this).find('.modal-body').css({
                  width:'auto', //probably not needed
                  height:'auto', //probably not needed 
                  'max-height':'100%'
           });
    });
</script>
