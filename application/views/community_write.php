<?php
    $lang = $this->session->userdata('lang');
    $this->lang->load('view', $lang);

?>
<style>
      .ck-editor__editable { height: 400px; }
      .ck-content { font-size: 12px; }
</style>

<div class="container" style="overflow-y: auto">
        <form id="community_write">
            <div class="form-group">
                <div class="row mt-1">
                    <div class="col-2">
                        <div class="form-floating">
                            <select id="check_country" name="country" class="form-select" onchange="get_country_data()">
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
                            <label class="form-label "><?=$this->lang->line('country')?></label>
                        </div>
                    </div>
                    
                    <div class="col-2">
                        <div class="form-floating">
                            <select id="check_city" name="city" class="form-select">
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
                            <label class="form-label "><?=$this->lang->line('city')?></label>
                        </div>
                    </div>
                    
                    <div class="col-2">
                        <div class="form-floating">
                            <select id="check_langueage" name="language" class="form-select">
                                <?php 
                                    $lang_array = get_langueage_list();
                                    
                                    for($i=0;$i<count($lang_array);$i++){
                                    
                                        $search_lang = "";
                                        if($language == $lang_array[$i]['id']){
                                            $search_lang = "selected";
                                        }
                                     ?>
                                
                                        <option value="<?=$lang_array[$i]['id']?>" <?=$search_lang?>><?=$lang_array[$i]['val']?></option>
                                <?php
                                    }
                                ?>
                                
                            </select>
                            <label for="language" class="form-label" >
                                <?=$this->lang->line('language')?>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-md-6 col-xs-6">
                        <div class="form-floating">
                            <input type="text" id="title" name="title" class="form-control"/>
                        
                            <label for="title" class="form-label" >
                                    <?=$this->lang->line('title')?>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-md-6 col-xs-6">
                        <textarea id="editor" name="content">
                            
                        </textarea>
                    </div>
                </div>
            </div>
            <div class="row mt-1" style="padding-top:50px">
                
                <div class="col-md-6 col-xs-6 col-offset-6 col-xs-offset-4 text-center">
                    <button type="button" class="btn btn-success" id="btn_insert"><?=$this->lang->line('insert')?></button>
                    <button type="button" class="btn btn-danger" id="btn_reset" onclick="form.reset();"><?=$this->lang->line('reset')?></button>
                    <button type="button" class="btn btn-secondary" onclick="location.href='/community/list'"><?=$this->lang->line('list')?></button>
                </div>
            </div>
        </form>
        
    </div>

</main>

<script src="/asset/script/ck_edit/build/ckeditor.js"></script>
<script src="/asset/script/ck_edit/build/translations/<?=$lang?>.js"></script>

<script>

  ClassicEditor.create( document.querySelector( '#editor' ), {
      language : "<?=$lang?>",
      simpleUpload: {
            // The URL that the images are uploaded to.
            uploadUrl: 'https://www.kpopineu.com/community/image_upload',

            // Enable the XMLHttpRequest.withCredentials property.
            withCredentials: true,

            // Headers sent along with the XMLHttpRequest to the upload server.
            headers: {
                'X-CSRF-TOKEN': 'CSRF-Token',
                Authorization: 'Bearer <JSON Web Token>'
            }
        }
  })
  .then(newEditor => {
        editor = newEditor;
    })
    .catch(error => {
        console.error(error);
    });
</script>

<script>
    
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
                alert("<?=$this->lang->line('neterror')?>");
                return false;
            }	 
        });
        
    }
    
    
    $("#btn_insert").on('click', function(){
        
        var post_params = $("#community_write").serialize();
        var content = editor.getData();
        post_params += "&content="+content;

        
        $.ajax({
            url:'/community/write_ajax',
            type:'post',
            data: post_params,
            success:function(data){
                if(data.result == 200){
                    alert('<?=$this->lang->line('completeinsert')?>');
                    location.href = "/community/list";
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
            
        
    });
</script>