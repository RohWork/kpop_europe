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

<html>
    <head>
        <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <div class="container" style="font-size: 15px">
            <form id="form_modify">
                
                <div class="row">
                    <div class="col-10"><?=$detail['title']?></div>
                </div>
                
                <div class="row">
                    <div class="col-2">
                        <label class="form-label bold"><strong><?=$this->lang->line('countryname')?></strong></label>
                    </div>
                    <div class="col-2">
                        <?=$detail['country_name']?>
                    </div>
                    <div class="col-2">
                        <label class="form-label bold"><strong><?=$this->lang->line('city_name')?></strong></label>
                    </div>
                    <div class="col-2">
                        <?=$detail['city_name']?>
                    </div>
                    <div class="col-2">
                        <label class="form-label bold"><strong><?=$this->lang->line('language')?></strong></label>
                    </div>
                    <div class="col-2">
                        <?=$search_lang?>
                    </div>
                </div>

                <div class="row" style="padding-top: 5px">
                    
                    <div class="col-10">
                        <?=$detail['content']?>
                    </div>
                </div>
                
                <div class="row" style="padding-top: 5px">
                    <div class="col-10">
                        <form id="comment_write">
                            <textarea id="comment" name="comment"></textarea>
                            <input type="hidden" id="community_idx" name="community_idx" value="<?=$idx?>"/>
                        </form>
                    </div>
                    <div class="col-2">
                        <button type="button" id="comment_write" name="comment_write">
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
    </body>
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