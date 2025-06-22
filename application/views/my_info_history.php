<?php
    $lang = $this->session->userdata('lang');
    $this->lang->load('view', $lang);
?>


<div class="container">
    <form method="post" id="info_form" action="/member/my_info_set">
        <div class="row">
                    <label class="form-label"><h3><?=$this->lang->line('myinfomodify')?></h3></label>
                </div>
        <div class="row">
            <div class="col-2">
                <label class="form-label">
                    <strong><?=$this->lang->line('country')?></strong>
                </label>
            </div>
            <div class="col-2">

                    <select id="check_country" name="country" class="form-select" onchange="get_country_data()">
                        <option value=""></option>
                        <?php foreach($country_list as $cnt){ 
                            $search_cnt = "";
                            if($user_info['country_idx'] == $cnt['idx']){
                                $search_cnt = "selected";
                            }
                        ?>
                            <option value="<?=$cnt['idx']?>" <?=$search_cnt?>><?=$cnt['name']?></option>

                        <?php } ?>
                    </select>

            </div>
        </div>
        <div class="row">
            <div class="col-2">
                <label class="form-label">
                    <strong><?=$this->lang->line('city')?></strong>
                </label>
            </div>
            <div class="col-2">

                    <select id="check_city" name="city" class="form-select">
                        <option value=""></option>
                        <?php foreach($city_list as $cty){ 

                            $search_cty = "";
                            if($user_info['city_idx'] == $cty['idx']){
                                $search_cty = "selected";
                            }

                        ?>
                            <option value="<?=$cty['idx']?>" <?=$search_cty?>><?=$cty['name']?></option>

                        <?php } ?>
                    </select>
            </div>
        </div>
        <div class="row">
            <div class="col-2">
                <label class="form-label">
                    <strong><?=$this->lang->line('language')?></strong>
                </label>
            </div>
            <div class="col-2">
                <select id="check_langueage" name="language" class="form-select">
                    <?php 
                        $lang_array = get_langueage_list();

                        for($i=0;$i<count($lang_array);$i++){

                            $search_lang = "";
                            if($user_info['language'] == $lang_array[$i]['id']){
                                $search_lang = "selected";
                            }
                         ?>

                            <option value="<?=$lang_array[$i]['id']?>" <?=$search_lang?>><?=$lang_array[$i]['val']?></option>
                    <?php
                        }
                    ?>

                </select>

            </div>
        </div>
        <div class="row" style="margin-top: 15px;">
            
            <div class="col-4" style="text-align: right">
                <input type="submit" class="btn btn-primary" value="<?=$this->lang->line('confirm')?>"/>
            </div>
        </div>
    </form>

   
    <div class="row">
        <label class="form-label"><h3><?=$this->lang->line('mybookmark')?></h3></label>
        <form method="get" id="search_form">
            <input type="hidden" id="day" name="day" value="1" />
        </form>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn <?=$mode=="after"? "btn-primary" :"btn-outline-primary" ?>" onclick="location.href='/member/my_bookmark?mode=after'"><?=$this->lang->line('after')?></button>
                <button type="button" class="btn <?=$mode=="before"? "btn-primary" :"btn-outline-primary" ?>" onclick="location.href='/member/my_bookmark?mode=before'"><?=$this->lang->line('before')?></button>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: 20px;">
        <div class="col-4">
            
        </div>
        <div class="col-4">
            <button class="btn btn-secondary" type="button" onclick="location.href='/member/my_bookmark?mode=before&year=<?=$year-1?>'"> 
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-left-fill" viewBox="0 0 16 16">
                    <path d="m3.86 8.753 5.482 4.796c.646.566 1.658.106 1.658-.753V3.204a1 1 0 0 0-1.659-.753l-5.48 4.796a1 1 0 0 0 0 1.506z"/>
                  </svg>          
            </button>
             <?=$year?> 
            <button class="btn btn-secondary" type="button" onclick="location.href='/member/my_bookmark?mode=before&year=<?=$year+1?>'"> 
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-right-fill" viewBox="0 0 16 16">
                    <path d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z"/>
                </svg>       
            </button>
        </div>
        <div class="col-4">
            
        </div>
    </div>

 
            
                <?php 
                    for($i=12;$i>0;$i--){
                ?>
    <div class="row" style="padding-top: 35px;">
        <div class="col-12">        
             <label class="form-label" style="font-weight: bold"><?=date("F",strtotime($year."-".$i))?></label>
                
             <table class="table table-striped" style="font-size:0.8rem">
                <tr>
                    <th width="10%">Type</th>
                    <th width="15%"><?=$this->lang->line('startdate')?></th>
                    <th width="20%"><?=$this->lang->line('country')?></th>
                    <th width="20%"><?=$this->lang->line('city')?></th>
                    <th width="20%"><?=$this->lang->line('orgernizer')?></th>
                    <th width="30%">Location</th>
                </tr>   
                    <?php 
                        foreach($bookmark_list as $li){
                            if($year."-".sprintf("%02d",$i) == substr($li['start_date'],0,7)){
                    ?>        
                    <tr style="cursor: pointer">
                        <td onclick="go_detail(<?=$li['idx']?>,'<?=$li['start_date']?>',1)"><?=$li['type']?></td>
                        <td onclick="go_detail(<?=$li['idx']?>,'<?=$li['start_date']?>',1)"><?=$li['start_date']?></td>
                        <td onclick="go_detail(<?=$li['idx']?>,'<?=$li['start_date']?>',1)"><?=$li['country_name']?></td>
                        <td  onclick="go_detail(<?=$li['idx']?>,'<?=$li['start_date']?>',1)"><?=$li['city_name']?></td>
                        <td  onclick="go_detail(<?=$li['idx']?>,'<?=$li['start_date']?>',1)"><?=$li['organization_name']?></td>
                        <td  onclick="go_detail(<?=$li['idx']?>,'<?=$li['start_date']?>',1)"><?=$li['space']?></td>
                        
                    </tr>   
                    <?php
                            }
                            ?>
                
                 <?php
                        }
                    ?>
                </table>
             
            </div>
    </div>
                <?php
                    }
                ?>
            

    <div class="row" style="margin-top: 15px;">

    </div>
    <div id="list_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
        
        <div class="modal-dialog modal-lg" style="max-height:85%;" role="document">
            <div class="modal-content" style="height:800px">
                <div class="modal-header">
                    <h5 class="modal-title"><?=$this->lang->line('detail')?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <iframe src="" id="list_frame" style="width:100%; height:100%">etc</iframe>  
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary list" onclick="return_list()" aria-label="List" style="display: none"> <?=$this->lang->line('list')?> </button>
                    <button type="button" class="btn btn-secondary close" data-dismiss="modal" aria-label="Close">Close</button>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    
    $(document).ready(function(){
       get_country_data(); 
    });
    
    
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
                        
                        if(j == <?=$user_info['country_idx']?>){
                            if(data.result[i]['idx'] == <?=$user_info['city_idx']?>){
                                var selected = "selected";
                            }else{
                                var selected = "";
                            }
                        }
                        
                        var option = $("<option value="+data.result[i]['idx']+" "+selected+">"+data.result[i]['name']+"</option>");
                        $('#check_city').append(option)
                        
                    }
                    
                    
                    
                }else{

                    //alert(data.message);
                    return false;
                }
            },
            error: function(xhr,status,error) {
                console.log(xhr,status,error);
                alert("<?=$this->lang->line('neterror')?>");
                return false;
            }	 
        });
        
    }
    
</script>


<script>
    
    var select_date;
    
    
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
        
        var url = "/member/bookmark_frame_list?date="+date;
        
        $('#list_frame').attr('src', url);

        $(".modal-title").text(date);
        // 모달창 띄우기
        $('#list_modal').modal("show");
    }
    
    function go_detail(idx, name, mode=0){
        
        detail_idx = idx;
        
        var url = "/schedule/frame_detail/"+idx;
       
        
        $('#list_frame').attr('src', url);
        
        $(".modal-title").text(name);
        if(mode == 0){
            $(".list").show();
        }
        // 모달창 띄우기
        $('#list_modal').modal("show");
        
    }
    
    function return_list(){
        
        var date = select_date;
        
        var url = "/member/bookmark_frame_list?date="+date;
        
        $('#list_frame').attr('src', url);
        $(".list").hide();
        
        $(".modal-title").text(date);
        
    }
    $(".close").on('click', function(){    
        $('#list_modal').modal('hide');
    });
</script>
</main>