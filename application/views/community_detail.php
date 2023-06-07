<?php
    $lang = $this->session->userdata('lang');
    $this->lang->load('view', $lang);

    $lang_array = get_langueage_list();
    $search_lang = "";
    for($i=0;$i<count($lang_array);$i++){
                                    
        if($detail['language'] == $lang_array[$i]['id']){
            $search_lang = $lang_array[$i]['val'];
        }
    }
?>

        <div class="container" style="font-size: 15px; overflow-y: auto"> 
                <div class="row">
                    <div class="col-3">
                        <label class="form-label bold"><strong><?=$this->lang->line('countryname')?></strong></label>
                        &nbsp;
                        <?=$detail['country_name']?>
                    </div>

                    <div class="col-2">
                        <label class="form-label bold"><strong><?=$this->lang->line('cityname')?></strong></label>
                        &nbsp;
                        <?=$detail['city_name']?>
                    </div>

                    <div class="col-2">
                        <label class="form-label bold"><strong><?=$this->lang->line('language')?></strong></label>
                        &nbsp;
                        <?=$search_lang?>
                    </div>
                    
                    <div class="col-2">
                        <label class="form-label bold"><strong><?=$this->lang->line('likecnt')?></strong></label>
                        &nbsp;
                        <?=$detail['great']?>
                    </div>
                </div>
                <div class="row" style="padding-top: 10px">
                    <div class="col-9">
                            <h4><?=$detail['title']?></h3>   
                    </div>
                </div>
                <div class="row" style="padding-top: 5px">
                    
                    <div class="col-9" >
                        <div style="height:50vh" class="border">
                            <?=html_entity_decode($detail['content'])?>
                        </div>
                    </div>
                </div>
                
                <div class="row" style="padding-top: 5px">
                    <div class="col-6">
                        <button type="button" class="btn btn-success" onclick="like_community(1, <?=$idx?>)"><?=$this->lang->line('like')?></button>
                        <button type="button" class="btn btn-secondary" onclick="like_community(2, <?=$idx?>)"><?=$this->lang->line('dislike')?></button>
                    </div>
                    <div class="col-3 text-end">
                        <?php if($this->session->userdata('id') == $detail['writer']){ ?>
                        <button type="button" class="btn btn-primary" onclick="modify_community()"><?=$this->lang->line('modify')?></button>
                        <button type="button" class="btn btn-danger" onclick="delete_community()"><?=$this->lang->line('delete')?></button>
                        <?php } ?>
                        <button type="button" class="btn btn-secondary" onclick="location.href='/community/list'"><?=$this->lang->line('list')?></button>
                    </div>
                    
                </div>
                
                
                <div class="row" style="padding-top: 5px;margin-top: 20px">
                    <div class="col-8">
                        <form id="comment_write">
                            <textarea id="comment" name="comment" class="form-control"></textarea>
                            <input type="hidden" id="community_idx" name="community_idx" value="<?=$idx?>"/>
                        </form>
                    </div>
                    <div class="col-1">
                        <button type="button" id="write_btn" name="write_btn" class="btn btn-primary" onclick="comment_write()">
                            <?=$this->lang->line('save')?>
                        </button>
                    </div>
                </div>
                
                <div class="row" style="paddng-top: 5px">
                    <div class="col-9">
                        <table class="table">
                            <tr>
                                <th width="90%"></th><th width="10%"></th>
                            </tr>
                            <?php 

                            foreach($comment as $cmt){
                            ?>
                            <tr>
                                <td><?=$cmt->content?></td>
                                <td>
                                    <?=$cmt->mnick?>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-success" onclick="like_comment(1, <?=$cmt->idx?>)"><?=$this->lang->line('like')?></button>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-secondary" onclick="like_comment(2, <?=$cmt->idx?>)"><?=$this->lang->line('dislike')?></button>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </table>
                    </div>
                    
                </div>
                
        </div>
    </main>
    <script>
        function modify_community(){
            
            location.href="/community/modify/"+<?=$idx?>
            
        }
        
        function like_community(mode, idx){
            var data = {mode: mode ,idx : idx};
            
            $.ajax({
                    url:'/community/like_community_ajax',
                    type:'post',
                    data:data,
                    success:function(data){
                        if(data.result == 200){
                            location.reload();
                        }else{
                            alert('<?=$this->lang->line('checktodata')?>');
                        }
                    },
                    error: function(xhr,status,error) {
                        console.log(xhr,status,error);
                        alert("<?=$this->lang->line('neterror')?>");
                        return false;
                    }	 
                });
        }
        
        function like_comment(mode, idx){
            var data = {mode: mode ,idx : idx};
            
            $.ajax({
                    url:'/community/like_comment_ajax',
                    type:'post',
                    data:data,
                    success:function(data){
                        if(data.result == 200){
                            location.reload();
                        }else{
                            alert('<?=$this->lang->line('checktodata')?>');
                        }
                    },
                    error: function(xhr,status,error) {
                        console.log(xhr,status,error);
                        alert("<?=$this->lang->line('neterror')?>");
                        return false;
                    }	 
                });
        }
        
        function comment_write(){
            
            $.ajax({
                url:'/community/comment_write_ajax',
                type:'post',
                data:$("#comment_write").serialize(),
                success:function(data){
                    if(data.result == 200){
                        alert('<?=$this->lang->line('completeinsert')?>');
                        location.reload();
                    }else{
                        alert(data.message);
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
        function delete_community(){
            
            
            if(confirm("<?=$this->lang->line('deletepost')?>")){
                var data = {idx : <?=$idx?>};

                $.ajax({
                    url:'/community/delete_ajax',
                    type:'post',
                    data:data,
                    success:function(data){
                        if(data.result == 200){
                            alert('<?=$this->lang->line('completedelete')?>');
                            location.href='/community/list';         
                        }else{
                            alert('<?=$this->lang->line('checktodata')?>');
                        }
                    },
                    error: function(xhr,status,error) {
                        console.log(xhr,status,error);
                        alert("<?=$this->lang->line('neterror')?>");
                        return false;
                    }	 
                });
            }
        }
    </script>
</html>