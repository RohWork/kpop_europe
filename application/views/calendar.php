<style>
    .a_border{
        text-decoration: none;
        color:#000;
    }
</style>

    <div class="container">
        
        <div class="row">
            <div class="col-2">
                <select id="country" name="country" class="form-select">
                    <?php
                        foreach($country as $cont){
                            if($cont['idx'] == $get_country){
                                $selected = "selected";
                            }else{
                                $selected = "";
                            }
                    ?>
                    <option value="<?=$cont['idx']?>" <?=$selected?>><?=$cont['name']?></option>
                    <?php
                        }
                    ?>
                </select>
                
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
            <table class="table table-bordered table-responsive" style="width:700px">
              <tr align="center" >
                <td>
                    <a class="a_border" href=<?='/schedule/calendar?year='.$preyear.'&month='.$month . '&day=1&country='.$get_country; ?>>◀◀</a>
                </td>
                <td>
                    <a class="a_border" href=<?='/schedule/calendar?year='.$prev_year.'&month='.$prev_month . '&day=1&country='.$get_country; ?>>◀</a>
                </td>
                <td height="50" bgcolor="#FFFFFF" colspan="3">
                    <a class="a_border" href=<?='/schedule/calendar?year=' . $thisyear . '&month=' . $thismonth . '&day=1&country='.$get_country; ?>>
                    <?php echo "&nbsp;&nbsp;" . $month . ' - ' . $year  . "&nbsp;&nbsp;"; ?></a>
                </td>
                <td>
                    <a class="a_border" href=<?='/schedule/calendar?year='.$next_year.'&month='.$next_month.'&day=1&country='.$get_country; ?>>▶</a>
                </td>
                <td>
                    <a class="a_border" href=<?='/schedule/calendar?year='.$nextyear.'&month='.$month.'&day=1&country='.$get_country; ?>>▶▶</a>
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
                        
                        $cnt = 0;
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
                        for($s =0; $s<count($calendar); $s++){
                            $date = $year."-".sprintf('%02d',$month)."-".sprintf('%02d',$day);
                            if( $calendar[$s]['start_date'] <= $date && $calendar[$s]['end_date'] >= $date){   
                                $cnt += $calendar[$s]['cnt'];
                            }
                        }
                        if($cnt > 0){ ?>
                        
                        <br/>
                        <div style="text-align: right"><font style='font-size:15px;font-weight: 600;cursor:pointer' onclick="go_list('<?=$date?>')">COUNT : <?=$cnt?></font></div>
                        
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
        </div>
    </div>
    
    <div id="list_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
        
        <div class="modal-dialog modal-lg" style="max-height:85%;" role="document">
            <div class="modal-content" style="height:800px">
                <div class="modal-header">
                    <h5 class="modal-title">detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe src="" id="list_frame" style="width:100%; height:100%">etc</iframe>  
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary list" onclick="return_list()" aria-label="List" style="display: none"> List </button>
                    <?php if($this->session->userdata('level') > 2){ ?>
                    <button type="button" class="btn btn-warning modify" onclick="calendar_modify()" aria-label="Modify" style="display: none"> Modify </button>
                    <button type="button" class="btn btn-danger delete" onclick="calendar_delete()" aria-label="Delete" style="display: none"> Delete </button>
                    <?php } ?>
                    <button type="button" class="btn btn-secondary close" data-dismiss="modal" aria-label="Close">Close</button>
                    
                </div>
            </div>
        </div>
    </div>


</main>

<script>

    var select_date;
    var detail_idx;
    
    function go_list(date){
        
        select_date = date;
        
        var url = "/schedule/list?date="+date+"&country=<?=$get_country?>";
        
        $('#list_frame').attr('src', url);

        $(".modal-title").text(date);
        // 모달창 띄우기
        $('#list_modal').modal("show");
    }
    
    function go_detail(idx, name){
        
        detail_idx = idx;
        
        var url = "/schedule/detail/"+idx;
       
        
        $('#list_frame').attr('src', url);
        
        $(".modal-title").text(name);
        $(".list").show();
        <?php if($this->session->userdata('level') > 2){ ?>
                $(".delete").show();
                $(".modify").show();
        <?php }?>
        
        // 모달창 띄우기
        $('#list_modal').modal("show");
        
    }
    
    function calendar_modify(){
        
        var url = "/schedule/detail/"+detail_idx;
        $('#list_frame').attr('src', url);
        
        // 모달창 띄우기
        $('#list_modal').modal("show");
    }
    
    function calendar_delete(){
        
        const frame = $('#list_frame').get(0).contentWindow;
        
        frame.set_delete();
        
    }
    
    function return_list(){
        
        var date = select_date;
        
        var url = "/schedule/list?date="+date+"&country=<?=$get_country?>";
        
        $('#list_frame').attr('src', url);
        $(".list").hide();
        $(".modify").hide();
        $(".delete").hide();
        
        $(".modal-title").text(date);
        
    }
    
    
    $(".close").on('click', function(){    
        $('#list_modal').modal('hide');
    });
    
    
    
    $('#list_modal').on('show.bs.modal', function () {
           $(this).find('.modal-body').css({
                  width:'auto', //probably not needed
                  height:'auto', //probably not needed 
                  'max-height':'100%'
           });
    });
    
    $("#country").on('change', function(){
       var cnt_idx = $("#country option:selected").val();
       
       location.href="/schedule/calendar?country="+cnt_idx+"&year=<?=$year?>&month=<?=$month?>"; 
    });
</script>
