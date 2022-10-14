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
                <div class="col-sm-10" style="text-align: center"> <h1>Join Us</h1></div>
                
            </div>
            <div class="row" style="padding:10px">
                <label class="col-sm-2 form-label">Email</label>
                <div class="col-sm-6">
                    <input type="text" id="user_email" name="user_email" class="form-control"/>
                    <input type="hidden" id="email_confirm" name="email_confirm" class="form-control" value="N"/>
                </div>
                <div class="col-sm-2"><button class="btn form-control btn-info" type="button" id="check_email">confirm</button></div>
            </div>

            <div class="row" style="padding:10px">
                <label class="col-sm-2 form-label">Password</label>
                <div class="col-sm-6"><input type="password" id="user_pass" name="user_pass" class="form-control"></div>
            </div>

            <div class="row" style="padding:10px">
                <label class="col-sm-2 form-label">Given Name</label>
                <div class="col-sm-6"><input type="Text" id="user_name1" name="user_name1" class="form-control"></div>
            </div>

            <div class="row" style="padding:10px">
                <label class="col-sm-2 form-label">Family Name</label>
                <div class="col-sm-6"><input type="Text" id="user_name2" name="user_name2" class="form-control"></div>
            </div>

            <div class="row" style="padding:10px">
                <div class="col-sm-10"><button type="button" class="btn form-control btn-success">Go join</button></div>
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
                    alert('duplicated email. check to your email');
                }
            },
            error: function(xhr,status,error) {
                console.log(xhr,status,error);
                alert("네트워크 오류!! 관리자에게 문의 주세요!!");
                return false;
            }	 
        });
        
        
    });
      
  </script>
</html>