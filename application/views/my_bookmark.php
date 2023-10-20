<?php
    $lang = $this->session->userdata('lang');
    $this->lang->load('view', $lang);
?>


<div class="container">
   
    <div class="row">
        <label class="form-label"><h3><?=$this->lang->line('mybookmark')?></h3></label>
        <form method="get" id="search_form">
            <input type="hidden" id="year" name="year" value="<?=$thisyear?>"/>
            <input type="hidden" id="month" name="month" value="<?=$thismonth?>"/>
            <input type="hidden" id="day" name="day" value="1" />
        </form>
    </div>
    
     <div class="row">
            <div class="col-12">
            <table class="table table-bordered table-responsive" style="width:700px;font-size: 0.8rem">
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
                <th hight="30" width="100"><?=$this->lang->line('sun')?></td>
                <th width="100"><?=$this->lang->line('mon')?></th>
                <th width="100"><?=$this->lang->line('tue')?></th>
                <th width="100"><?=$this->lang->line('wed')?></th>
                <th width="100"><?=$this->lang->line('thu')?></th>
                <th width="100"><?=$this->lang->line('fri')?></th>
                <th width="100"><?=$this->lang->line('sat')?></th>
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
                        
                        <br/>
                        <div style="text-align: right"><font style='font-size:0.8rem;font-weight: 600;cursor:pointer' onclick="go_list('<?=$date?>')"><?=$this->lang->line('count')?> : <?=$cnt?></font></div>
                        
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
    
    
    <div class="row" style="padding-top: 20px">
        <div class="col-12">
            <table class="table table-striped" style="font-size:0.8rem">
                <tr>
                    <th>Type</th>
                    <th><?=$this->lang->line('startdate')?></th>
                    <th><?=$this->lang->line('country')?></th>
                    <th><?=$this->lang->line('city')?></th>
                    <th>Location</th>
                    <th></th>
                </tr>
                <?php 
                    foreach($bookmark_list as $li){
                ?>        
                <tr style="cursor: pointer">
                    <td onclick="go_detail(<?=$li['idx']?>)"><?=$li['type']?></td>
                    <td onclick="go_detail(<?=$li['idx']?>)"><?=$li['start_date']?></td>
                    <td onclick="go_detail(<?=$li['idx']?>)"><?=$li['country_name']?></td>
                    <td  onclick="go_detail(<?=$li['idx']?>)"><?=$li['city_name']?></td>
                    <td  onclick="go_detail(<?=$li['idx']?>)"><?=$li['space']?></td>
                    <td><button type="button" class="btn btn-danger delete" onclick="mark_delete(<?=$li['mark_idx']?>)" aria-label="Delete"> <?=$this->lang->line('delete')?> </button></td>
                </tr>   
                <?php 
                    }
                ?>
            </table>
        </div>
    </div>
    <div class="row" style="margin-top: 15px;">

    </div>

</div>
</main>
<script>
    
    
    function go_detail(idx){

        var url="/schedule/detail/"+idx+"?mode=book_mark";
        
        window.open(url, 'detail', "width=500, height=700" );
        
    }
    
    function mark_delete(mark_idx){
        var data = { idx : mark_idx};
                        
        $.ajax({
            url:'/member/delete_bookmark',
            type:'post',
            data:data,
            success:function(data){
                if(data.result == 200){
                    alert('<?=$this->lang->line('completedelete')?>');
                    window.parent.location.reload();
                }else{
                    alert('<?=$this->lang->line('checktodata')?>');
                    console.log(data);
                }
            },
            error: function(xhr,status,error) {
                console.log(xhr,status,error);
                alert("<?=$this->lang->line('neterror')?>");
                return false;
            }	 
        });
    }
    
    function date_move(year,month){
        $("#year").val(year);
        $("#month").val(month);
        
        $("#search_form").submit();
    }
    
    function go_list(date){
        
        select_date = date;
        
        var url = "/member/schedule_list?date="+date;
        
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
        $(".bookmark").show();
        <?php if($this->session->userdata('level') > 2){ ?>
                $(".delete").show();
                $(".modify").show();
        <?php }?>
        
        // 모달창 띄우기
        $('#list_modal').modal("show");
        
    }
    
</script>