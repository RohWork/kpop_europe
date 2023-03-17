<style>
    .a_border{
        text-decoration: none;
        color:#000;
    }
</style>
    
    

    <div class="container">
        
        <form method="get" id="search_form" action="/schedule/calendar">
            <div class="row">
                 <div class="col-4">
                     <?php 
                        $select = array(
                            "party" => "",
                            "concert" => "",
                        );
                        if(!empty($search['type'])){
                            if($search['type'] == 'party'){
                                $select['party'] = "selected";
                            }else{
                                $select['concert'] = "selected";
                            }
                            
                            
                        }
                     ?>
                     
                    <div class="form-floating">
                        <select id="check_type" name="type" class="form-select"  onchange="this.form.submit()">
                            <option value=""></option>
                            <option value="party" <?=$select['party']?>>PARTY</option>
                            <option value="concert" <?=$select['concert']?>>CONCERT</option>
                        </select>
                        <label class="form-label col-1">
                            type
                        </label>
                    </div>
                </div>
                
                <div class="col-4">
                    <div class="form-floating">
                        <select id="check_country" name="country" class="form-select" onchange="this.form.submit()">
                            <option value=""></option>
                            <?php foreach($country_list as $cnt){ 
                                $search_cnt = "";
                                if($search['country'] == $cnt['idx']){
                                    $search_cnt = "selected";
                                }
                            ?>
                                <option value="<?=$cnt['idx']?>" <?=$search_cnt?>><?=$cnt['name']?></option>

                            <?php } ?>
                        </select>
                        <label class="form-label col-1">
                            COUNTRY
                        </label>
                    </div>
                </div>

                <div class="col-4">
                    <div class="form-floating">
                        <select id="check_city" name="city" class="form-select" onchange="this.form.submit()">
                            <option value=""></option>
                            <?php foreach($city_list as $cty){ 

                                $search_cty = "";
                                if($search['city'] == $cty['idx']){
                                    $search_cty = "selected";
                                }

                            ?>
                                <option value="<?=$cty['idx']?>" <?=$search_cty?>><?=$cty['name']?></option>

                            <?php } ?>
                        </select>
                        <label class="form-label col-1">
                            CITY
                        </label>
                    </div>
                </div>
                <!--<div class="col-4">
                    <div class="form-floating">
                        <select id="organization" name="organization" class="form-select" onchange="this.form.submit()">
                            <option value=""></option>
                            <?php foreach($organization_list as $org){ 

                                $search_org = "";
                                if($search['organizer'] == $org['idx']){
                                    $search_org = "selected";
                                }

                            ?>
                                <option value="<?=$org['idx']?>" <?=$search_org?>><?=$org['name']?></option>

                            <?php } ?>
                        </select>
                        <label for="organization">
                            ORGERNIZER
                        </label>
                    </div>
                </div>
                -->
                <input type="hidden" id="year" name="year" value="<?=$thisyear?>"/>
                <input type="hidden" id="month" name="month" value="<?=$thismonth?>"/>
                <input type="hidden" id="day" name="day" value="1" />
            </div>
        </form>
        
        <div class="row">
            <div class="col-12">
            <table class="table table-bordered table-responsive" style="width:100%">
              <tr align="center" >
                <td>
                    <a class="a_border" href="#" onclick="date_move('<?=$prev_year?>','<?=$month?>')">◀◀</a>
                </td>
                <td>
                    <a class="a_border" href="#" onclick="date_move('<?=$prev_year?>','<?=$prev_month?>')">◀</a>
                </td>
                <td height="50" bgcolor="#FFFFFF" colspan="3">
                    <a class="a_border" href="#" onclick="date_move('<?=$thisyear?>','<?=$thismonth?>')">
                    <?php echo "&nbsp;&nbsp;" . $month . ' - ' . $year  . "&nbsp;&nbsp;"; ?></a>
                </td>
                <td>
                    <a class="a_border" href="#" onclick="date_move('<?=$next_year?>','<?=$next_month?>')">▶</a>
                </td>
                <td>
                    <a class="a_border" href="#" onclick="date_move('<?=$next_year?>','<?=$month?>')">▶▶</a>
                </td>
              </tr>
              <tr class="info">
                <th hight="30" width="10%">SUN</td>
                <th width="10%">MON</th>
                <th width="10%">TUE</th>
                <th width="10%">WED</th>
                <th width="10%">THU</th>
                <th width="10%">FRI</th>
                <th width="10%">SAT</th>
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
                            if( $calendar[$s]['start_date'] == $date ){   
                                $cnt += $calendar[$s]['cnt'];
                            }
                        }
                        if($cnt > 0){ ?>
                        
                        <br/><br/>
                        <div class="text-end"><font style='font-size:15px;font-weight: 600;cursor:pointer;color:blue' onclick="go_list('<?=$date?>')"><?=$cnt?></font></div>
                        
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
        
        var url = "/schedule/frame_list?date="+date+"&country=<?=$search['country']?>&city=<?=$search['city']?>&organization=<?=$search['organizer']?>";
        
        $('#list_frame').attr('src', url);

        $(".modal-title").text(date);
        // 모달창 띄우기
        $('#list_modal').modal("show");
    }
    
    function go_detail(idx, name){
        
        detail_idx = idx;
        
        var url = "/schedule/frame_detail/"+idx;
       
        
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
    
    
    function calendar_delete(){
        
        const frame = $('#list_frame').get(0).contentWindow;
        
        frame.set_delete();
        
    }
    
    function return_list(){
        
        var date = select_date;
        
        var url = "/schedule/frame_list?date="+date+"&country=<?=$search['country']?>&city=<?=$search['city']?>&organization=<?=$search['organizer']?>";
        
        $('#list_frame').attr('src', url);
        $(".list").hide();
        $(".modify").hide();
        $(".delete").hide();
        
        $(".modal-title").text(date);
        
    }
    
    function date_move(year,month){
        $("#year").val(year);
        $("#month").val(month);
        
        $("#search_form").submit();
    }
    
    
    function get_country_data(){
        
        var j = $("#check_country option:selected").val();
        var data = { country_idx : j };

       $('#check_city').empty();
        
        $.ajax({
            url:'/city/get_ajax',
            type:'post',
            data: data,
            success:function(data){
                if(data.code == 200){
                    
                    var data_array = data.result;

                    $('#check_city').append("<option value=''></option>");
                    for(var i =0; i<data_array.length;i++){
                        
                        var option = $("<option value="+data.result[i]['idx']+">"+data.result[i]['name']+"</option>");
                        $('#check_city').append(option)
                        
                    }
                    
                    
                    
                }else{

                    //alert(data.message);
                    return false;
                }
            },
            error: function(xhr,status,error) {
                console.log(xhr,status,error);
                alert("Network Error!! take support to web manager!!");
                return false;
            }	 
        });
        
    }
    
    
    $(".close").on('click', function(){    
        $('#list_modal').modal('hide');
    });
    
    
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
    
</script>
