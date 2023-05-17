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

        <div class="container" style="font-size: 15px">
            <form id="form_modify">
                
                
                
                <div class="row">
                    <div class="col-3">
                        <label class="form-label bold"><strong><?=$this->lang->line('countryname')?></strong></label>
                        &nbsp;
                        <?=$detail['country_name']?>
                    </div>

                    <div class="col-3">
                        <label class="form-label bold"><strong><?=$this->lang->line('cityname')?></strong></label>
                        &nbsp;
                        <?=$detail['city_name']?>
                    </div>

                    <div class="col-3">
                        <label class="form-label bold"><strong><?=$this->lang->line('language')?></strong></label>
                        &nbsp;
                        <?=$search_lang?>
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
                
                <div class="row" style="padding-top: 5px;margin-top: 5px">
                    <div class="col-8">
                        <form id="comment_write">
                            <textarea id="comment" name="comment" class="form-control"></textarea>
                            <input type="hidden" id="community_idx" name="community_idx" value="<?=$idx?>"/>
                        </form>
                    </div>
                    <div class="col-1">
                        <button type="button" id="comment_write" name="comment_write" class="btn btn-primary">
                            <?=$this->lang->line('save')?>
                        </button>
                    </div>
                </div>
                
                <div class="row" style="paddng-top: 5px">
                    <div class="col-10">
                        <table class="table">
                            <?php 
                            foreach($comment as $cmt){
                            ?>
                                <div><?=$cmt->content?></div>
                            <?php
                            }
                            ?>
                        </table>
                    </div>
                    
                </div>
                
            </form>
        </div>
    </main>
    <script>
        function modify_community(){
            
            location.href="/community/modify/"+<?=$idx?>
            
        }
        
        function comment_write(){
            
        $.ajax({
            url:'/community/comment_ajax',
            type:'post',
            data:$("#comment_write").serialize(),
            success:function(data){
                if(data.result == 200){
                    alert('<?=$this->lang->line('completeinsert')?>');
                    location.reload();
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
                            window.parent.location.reload();
                            window.parent.modal_close();
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