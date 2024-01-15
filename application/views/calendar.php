
<?php
    $lang = $this->session->userdata('lang');
    $this->lang->load('calendar', $lang);

?>



<style>
    .a_border{
        text-decoration: none;
        color:#000;
    }
</style>

    <div class="container" style="font-size: 12px;">
        
        <form method="get" id="search_form">
            <div class="row">
                <div class="col-12">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn <?=$mode=="calendar"? "btn-primary" :"btn-outline-primary" ?>" onclick="location.href='/schedule/calendar'"><?=$this->lang->line('calendar')?></button>
                        <button type="button" class="btn <?=$mode=="list"? "btn-primary" :"btn-outline-primary" ?>" onclick="location.href='/schedule/list'"><?=$this->lang->line('list')?></button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <div class="form-floating">
                        <select id="check_type" name="type" class="form-select">
                            <option value="all"><?=$this->lang->line('viewall')?></option>
                            <option value="party" <?=$search['type'] == 'party' ? "selected" : "" ?>>PARTY</option>
                            <option value="concert" <?=$search['type'] == 'concert' ? "selected" : "" ?>>CONCERT</option>
                        </select>
                        <label class="form-label">
                            <?=$this->lang->line('type')?>
                        </label>
                    </div>
                </div>
                
                <div class="col-2">
                    <div class="form-floating">
                        <select id="check_country" name="country" class="form-select" onchange="get_country_data()">
                            <option value="all"><?=$this->lang->line('viewall')?></option>
                            <?php foreach($country_list as $cnt){ 
                                $search_cnt = "";
                                if($search['country'] == $cnt['idx']){
                                    $search_cnt = "selected";
                                }
                            ?>
                                <option value="<?=$cnt['idx']?>" <?=$search_cnt?>><?=$cnt['name']?></option>

                            <?php } ?>
                        </select>
                        <label class="form-label">
                            <?=$this->lang->line('country')?>
                        </label>
                    </div>
                </div>

                <div class="col-2">
                    <div class="form-floating">
                        <select id="check_city" name="city" class="form-select">
                            <option value="all"><?=$this->lang->line('viewall')?></option>
                            <?php foreach($city_list as $cty){ 

                                $search_cty = "";
                                if($search['city'] == $cty['idx']){
                                    $search_cty = "selected";
                                }

                            ?>
                                <option value="<?=$cty['idx']?>" <?=$search_cty?>><?=$cty['name']?></option>

                            <?php } ?>
                        </select>
                        <label class="form-label">
                            <?=$this->lang->line('city')?>
                        </label>
                    </div>
                </div>

                <div class="col-2">
                    <div class="form-floating">
                        <select id="organization" name="organization" class="form-select">
                            <option value="all"><?=$this->lang->line('viewall')?></option>
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
                            <?=$this->lang->line('orgernizer')?>
                        </label>
                    </div>
                </div>
                <div class="col-1">

                    <input type="submit" value="<?=$this->lang->line('search')?>" class="btn btn-success"/>
                </div>
                <input type="hidden" id="year" name="year" value="<?=$year?>"/>

            </div>
        </form>
    </div>
    <div class="row" style="margin-top: 20px;">
                <div class="col-4">

                </div>
                <div class="col-4">
                    <button class="btn btn-secondary" type="button" onclick="location.href='/member/calendar?year=<?=$year-1?>'"> 
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-left-fill" viewBox="0 0 16 16">
                            <path d="m3.86 8.753 5.482 4.796c.646.566 1.658.106 1.658-.753V3.204a1 1 0 0 0-1.659-.753l-5.48 4.796a1 1 0 0 0 0 1.506z"/>
                          </svg>          
                    </button>
                     <?=$year?> 
                    <button class="btn btn-secondary" type="button" onclick="location.href='/member/calendar?year=<?=$year+1?>'"> 
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-right-fill" viewBox="0 0 16 16">
                            <path d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z"/>
                        </svg>       
                    </button>
                </div>
                <div class="col-4">

                </div>
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
                    <?php if(!empty($this->session->userdata('name') )){ ?>
                    <button type="button" class="btn btn-success bookmark" onclick="calendar_mark()" aria-label="Bookmark" style="display: none"> <?=$this->lang->line('bookmark')?> </button>
                    <?php } ?>
                    <button type="button" class="btn btn-primary list" onclick="return_list()" aria-label="List" style="display: none"> <?=$this->lang->line('list')?> </button>
                    <?php if($this->session->userdata('level') > 2){ ?>
                    <button type="button" class="btn btn-danger delete" onclick="calendar_delete()" aria-label="Delete" style="display: none"> <?=$this->lang->line('delete')?> </button>
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
        $(".bookmark").show();
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
    
    function calendar_mark(){
        
        const frame = $('#list_frame').get(0).contentWindow;
        
        frame.set_mark();
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

                    $('#check_city').append("<option value='all'><?=$this->lang->line('viewall')?></option>");
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
                alert("<?=$this->lang->line('neterror')?>");
                return false;
            }	 
        });
        
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
   
    
    
</script>
