
<?php
    $lang = $this->session->userdata('lang');
    $this->lang->load('calendar', $lang);

?>


<html>
      <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 2 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Refobi</title>
        <!-- 합쳐지고 최소화된 최신 CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

        <!-- 부가적인 테마 -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <!-- 합쳐지고 최소화된 최신 자바스크립트 -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
        <!-- Custom styles for this template -->
  </head>
  <body>
      <form id="join_form">
        <div class="container">
            <div class="row">
                <div class="col-sm-10" style="text-align: center"> <h1><?=$this->lang->line('joinus')?></h1></div>
                
            </div>
            <div class="row" style="padding:10px">
                <label class="col-sm-2 form-label" for="user_email">Email</label>
                <div class="col-sm-6">
                    <input type="email" id="user_email" name="user_email" class="form-control"/>
                    <input type="hidden" id="email_confirm" name="email_confirm" class="form-control" value="N"/>
                </div>
                <div class="col-sm-2"><button class="btn form-control btn-info" type="button" id="check_email" required><?=$this->lang->line('confirm')?></button></div>
            </div>

            <div class="row" style="padding:10px">
                <label class="col-sm-2 form-label" for="user_pass1"><?=$this->lang->line('password')?></label>
                <div class="col-sm-6"><input type="password" id="user_pass1" min="8" pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$" name="user_pass1" class="form-control" required></div>
            </div>
            <div class="row" style="padding:10px">
                <label class="col-sm-2 form-label" for="user_pass2"><?=$this->lang->line('password')?>2</label>
                <div class="col-sm-6"><input type="password" id="user_pass2" min="8" pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$" name="user_pass2" class="form-control" required></div>
            </div>
            <div class="row" style="padding:10px">
                <label class="col-sm-2 form-label" for="user_name1"><?=$this->lang->line('gname')?></label>
                <div class="col-sm-6"><input type="Text" id="user_name1" name="user_name1" class="form-control" required></div>
            </div>

            <div class="row" style="padding:10px">
                <label class="col-sm-2 form-label" for="user_name2"><?=$this->lang->line('fname')?></label>
                <div class="col-sm-6"><input type="Text" id="user_name2" name="user_name2" class="form-control" required></div>
            </div>

            <div class="row" style="padding:10px">
                <div class="col-sm-10"><button type="button" class="btn form-control btn-success" id="set_join"><?=$this->lang->line('gojoin')?></button></div>
            </div>
        </div>
      </form>
      
  </body>
  
  <script>
    $("#check_email").click(function(){
        
        
        var check_email = $("#user_email").val();
        

        $.ajax({
            url:'/member/mail_check',
            type:'post',
            data: { check_email : check_email },
            success:function(data){
                if(data.result == 200){
                    
                    $("#email_confirm").val("Y");
                    $("#user_email").css("background-color","#E8F5E9");
                }else{
                    $("#email_confirm").val("N");
                    $("#user_email").css("background-color","#FFEBEE");
                    alert('<?=$this->lang->line('mailerror')?>');
                }
            },
            error: function(xhr,status,error) {
                console.log(xhr,status,error);
                alert("<?=$this->lang->line('neterror')?>");
                return false;
            }	 
        });
        
        
    });
    
    
    $("#set_join").click(function(){
        
       var confirm = $("#email_confirm").val();
       var up1 = $("#user_pass1").val();
       var up2 = $("#user_pass2").val();
       
       if(!check_param){
           alert("<?=$this->lang->line('confirmdata')?>");
           return false;
       }else if(confirm != "Y"){
           alert("<?=$this->lang->line('confirmemail')?>");
           $("#user_email").focus();
           return false;
       }else if(up1 != up2){
           alert("<?=$this->lang->line('confirmpassword')?>");
           $("#user_pass1").focuse();
       }else{
        
        var email = $("#user_email").val();
           
        $.ajax({
            url:'/member/join_process',
            type:'post',
            data: $("#join_form").serialize(),
            success:function(data){
                if(data.result == 200){
                    location.href="/member/mail_process?email="+email;
                }else{
                    alert('<?=$this->lang->line('checktodata')?>');
                    alert(data.message);
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
       
       
    });
    
    function check_param(){
        
        var f  = $("#join_form");
        var $f = jQuery(f);
        var $t, t;
        var result = true;
        
        $f.find("input, select, textarea").each(function(i) {
            $t = jQuery(this);

            if($t.prop("required")) {
                if(!jQuery.trim($t.val())) {
                    result = false;
                    alert(t+" <?=$this->lang->line('require')?> ");
                    return false;
                }
            }
        });
        
        if(!result)
            return false;
    }
    
  </script>
</html>