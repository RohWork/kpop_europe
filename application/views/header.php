<?php
    $lang = $this->session->userdata('lang');
    $this->lang->load('menu', $lang);

?>


<html>
    <head>
        <title>Kpop In Europe</title>
        <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" media="screen" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"></script>
        <script src="https://kit.fontawesome.com/89b002c3b7.js" crossorigin="anonymous"></script>
        <script src="/asset/js/jquery.cookie-1.4.1.min.js" crossorigin="anonymous"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <script>
            function go_href(val){
                                
                if(val == "ko"){
                    location.href='/?lang=ko&return_url=<?=$_SERVER[ "REQUEST_URI" ]?>';

                }else if(val == "en"){
                    location.href='/?lang=en&return_url=<?=$_SERVER[ "REQUEST_URI" ]?>';
                }else if(val == "de"){
                    location.href='/?lang=de&return_url=<?=$_SERVER[ "REQUEST_URI" ]?>';
                }
            }
            
        </script>
    </head>
    <?php
        $lang = $this->session->userdata('lang');
    ?>
    <body>
        <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom container-fluid">
            <div class="container">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
                      <svg class="bi me-4" width="40" height="32"><use xlink:href="#bootstrap"/></svg>
                      <span class="fs-4">Kpop In Europe</span>
                    </a>

                    <span class="text-end" style="font-size: 11px;">
                        <select class="form-select" style="width:100px;float: right;font-size: 8px;" onchange="go_href(this.value)">
                            
                            
                                <?php 
                                    $lang_array = get_langueage_list();
                                    
                                    for($i=0;$i<count($lang_array);$i++){
                                    
                                        $search_lang = "";
                                        if($lang == $lang_array[$i]['id']){
                                            $search_lang = "selected";
                                        }
                                     ?>
                                
                                        <option value="<?=$lang_array[$i]['id']?>" <?=$search_lang?>><?=$lang_array[$i]['val']?></option>
                                <?php
                                    }
                                ?>
                            
                        </select><br/><br/>
                        <?=$this->lang->line('toadd')?><br/>
                        <?=$this->lang->line('contact')?>
                    </span>
                </div>
            </div>
        </header>

