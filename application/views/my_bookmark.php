<?php
    $lang = $this->session->userdata('lang');
    $this->lang->load('view', $lang);
?>


<div class="container">
   
    <div class="row">
        <label class="form-label"><h3><?=$this->lang->line('mybookmark')?></h3></label>
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
    
</script>