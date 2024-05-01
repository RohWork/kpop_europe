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
            <input type="hidden" name="community_type" id="community_type" value="<?=$search['community_type']?>"/>
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
                            <select id="check_city" name="city" class="form-select" onchange="get_city_data()">
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
                            <select id="check_schedule" name="kpop_idx" class="form-select">
                                <option value="all"><?=$this->lang->line('viewall')?></option>
                                <?php foreach($schedule_list as $sch){ 
                                    
                                    $search_kpop = "";
                                    if($search['kpop_idx'] == $sch['idx']){
                                        $search_kpop = "selected";
                                    }
                                    
                                ?>
                                    <option value="<?=$sch['idx']?>" <?=$search_kpop?>><?="[".$sch['start_date']."]".$sch['space']?></option>

                                <?php } ?>
                                
                            </select>
                            <label for="language" lass="form-labe" >
                                <?=$this->lang->line('list')?>
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
                    <div class="col-md-6 col-xs-6" style="height:auto">
                        <textarea id="editor" name="content">
                            
                        </textarea>
                    </div>
                </div>
            </div>
            
            <div class="row mt-1">
                <div  class="col-md-6 col-xs-6">
                    
                    <input name='postTag' placeholder="#write tags to add below" type="hidden">
                </div>
            </div>
            
            <div class="row mt-1" style="padding-top:50px">
                
                <div class="col-md-6 col-xs-6 col-offset-6 col-xs-offset-4 text-center">
                    <button type="button" class="btn btn-success" id="btn_insert"><?=$this->lang->line('insert')?></button>
                    <button type="button" class="btn btn-danger" id="btn_reset" onclick="form.reset();"><?=$this->lang->line('reset')?></button>
                    <button type="button" class="btn btn-secondary" onclick="location.href='/community/list?community_type=2'"><?=$this->lang->line('list')?></button>
                </div>
            </div>
        </form>
        
    </div>

</main>

<style>
    .ck-editor__editable { height: 100%; }
    .ck-editor__editable_inline {
        max-height: 400px;
        height:400px;
    }
    .tagify{
        width:100%;
    }
    .tagify--outside{
        border: 0;
        min-height: 90px;
    }

    .tagify--outside .tagify__input{
      order: -1;
      flex: 100%;
      border: 1px solid var(--tags-border-color);
      margin-bottom: 1em;
      transition: .1s;
    }

    .tagify--outside .tagify__input:hover{ border-color:var(--tags-hover-border-color); }
    .tagify--outside.tagify--focus .tagify__input{
      transition:0s;
      border-color: var(--tags-focus-border-color);
    }
</style>

<script src="/asset/script/ck_edit/build/ckeditor.js"></script>
<script src="/asset/script/ck_edit/build/translations/<?=$lang?>.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />


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
    
    
    var input = document.querySelector('input[name=postTag]');

    // 태그가 추가되면 이벤트 발생
    var tagify = new Tagify(input, {
      //whitelist: ["foo", "bar", "baz"],
      maxTags: 10,
      dropdown: {
        position: "input",
        enabled : 0 // always opens dropdown when input gets focus
      }
    })
</script>

<script>
    
    function get_country_data(){
        
        var j = $("#check_country option:selected").val();


        location.href="/community/write?country="+j+"&language=<?=$search['language']?>&community_type=2";
        
    }
    
    function get_city_data(){
        var j = $("#check_city option:selected").val();


        location.href="/community/write?country=<?=$search['country']?>&city="+j+"&language=<?=$search['language']?>&community_type=2";
    }
    
    
    $("#btn_insert").on('click', function(){
        
        var post_params = $("#community_write").serialize();
        var content = editor.getData();
        post_params += "&content="+content;
        
        var tag = tagify.value;
        var hash_tag_string = "";
        
        for(var i=0; i<tag.length; i++){
            
            if(i==0){
                hash_tag_string = tag[i].value;
            }else{
                hash_tag_string = hash_tag_string+"/"+tag[i].value;
            }
            console.log(hash_tag_string);
        }
       
        post_params += "&hashtag="+hash_tag_string;
        
        $.ajax({
            url:'/community/write_ajax',
            type:'post',
            data: post_params,
            success:function(data){
                if(data.result == 200){
                    alert('<?=$this->lang->line('completeinsert')?>');
                    location.href = "/community/detail/"+data.idx;
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