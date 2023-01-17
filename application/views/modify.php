<html>
    <head>
        <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            .row_border{
                 height: 45px;
            }
        </style>
    </head>
    <body>
        <div class="container" style="font-size: 15px;padding-top: 15px;padding-left: 15px">
            <div class="row row_border">
                <div class="col-3">
                    <label class="form-label"><strong>Event</strong></label>
                </div>
                <div class="col-9">
                    <input type="text" id="name" name="name" class="form-control" value="<?=$detail_info['name']?>"/>
                </div>
            </div>
            <div class="row row_border">
                <div class="col-3">
                    <label class="form-label"><strong>Organizer</strong></label>
                </div>
                <div class="col-9">
                    <input type="text" id="company" name="company" class="form-control" value="<?=$detail_info['company']?>"/>
                </div>
            </div>
            <div class="row row_border">
                <div class="col-3">
                    <label class="form-label"><strong>Hompage</strong></label>
                </div>
                <div class="col-9">
                    <input type="text" id="homepage" name="homepage" class="form-control" value="<?=$detail_info['homepage']?>"/>
                </div>
            </div>
            <div class="row row_border">
                <div class="col-3">
                    <label class="form-label"><strong>Address</strong></label>
                </div>
                <div class="col-9">
                    <input type="text" id="addr" name="addr" class="form-control" value="<?=$detail_info['addr']?>"/>
                </div>
            </div>
            <div class="row row_border">
                <div class="col-3">
                    <label class="form-label"><strong>Facebook</strong></label>
                </div>
                <div class="col-9">
                    <input type="text" id="face" name="face" class="form-control" value="<?=$detail_info['face']?>"/>
                </div>
            </div>
            <div class="row row_border">
                <div class="col-3">
                    <label class="form-label"><strong>Instagram</strong></label>
                </div>
                <div class="col-9">
                    <input type="text" id="insta" name="insta" class="form-control" value="<?=$detail_info['insta']?>"/>
                </div>
            </div>
            <div class="row row_border">
                <div class="col-3">
                    <label class="form-label"><strong>Youtube</strong></label>
                </div>
                <div class="col-9">
                    <input type="text" id="yout" name="yout" class="form-control" value="<?=$detail_info['yout']?>"/>
                </div>
            </div>
            <div class="row row_border">
                <div class="col-3">
                    <label class="form-label"><strong>Start Date</strong></label>
                </div>
                <div class="col-9">
                    <input type="datetime" id="start_date" name="start_date" class="form-control" value="<?=$detail_info['start_date']?>"/>
                </div>
            </div>
            <div class="row row_border">
                <div class="col-3">
                    <label class="form-label"><strong>End Date</strong></label>
                </div>
                <div class="col-9">
                    <input type="datetime" id="end_date" name="end_date" class="form-control" value="<?=$detail_info['end_date']?>"/>
                </div>
            </div>
            <div class="row row_border">
                <div class="col-3">
                    <label class="form-label"><strong>Etc</strong></label>
                </div>
                <div class="col-9">
                    <textarea class="form-control" id="remark" name="remark">
                        <?=$detail_info['remark']?>
                    </textarea>
                </div>
            </div>
            <div class="row row_border" style="min-height: 100px">
                <div class="col-3">
                    <label class="form-label"><strong>Image</strong></label>
                </div>
                <div class="col-9" id="image_group" >
                    <div class="input-group mb-2 mt-1">
                        <input type="text" id="input_image[]" class="form-control i_img" name="input_image[]"/>
                        <button type="button" class="btn btn-primary" id="input_url">+</button>
                    </div>
                </div>
            </div>
            
            <?php if($this->session->userdata('level') > 2 || $this->session->userdata('org_idx') == $detail_info['organization_idx']){ ?>
            <div class="row">
                <div class="col-6 col-offset-6 text-end">
                <button type="button" class="btn btn-warning">SET MODIFY</button>
                </div>
            </div>
            <?php } ?>
        </div>
    </body>
    
    <script>
        $("#input_url").click(function() {
            $("#image_group").append(
                    "<div class='input-group mb-2 mt-1'><input type='text' id='input_image[]' class='form-control i_img' name='input_image[]'/><button type='button' class='btn btn-primary' id='input_url'>+</button></div>"
            );

            $("#insert_modal").dialogHeight = document.body.scrollHeight + 'px';
        });
        function set_delete(){
            
            <?php if($this->session->userdata('level') > 2 || $this->session->userdata('org_idx') == $detail_info['organization_idx']){ ?>
                    if(confirm("do you want to delete to the schedule?")){
                        
                            var data = { idx : <?=$detail_info['idx']?>};
                        
                            $.ajax({
                                url:'/schedule/delete_ajax',
                                type:'post',
                                data:data,
                                success:function(data){
                                    if(data.result == 200){
                                        alert('complete to delete');
                                        window.parent.location.reload();
                                    }else{
                                        alert('input fail. check to data.');
                                        console.log(data);
                                    }
                                },
                                error: function(xhr,status,error) {
                                    console.log(xhr,status,error);
                                    alert("Network error!! Confirm to Manager!!");
                                    return false;
                                }	 
                            });
            
                    }
            <?php }else{ ?>
                
                alert("this not permmited");
                
            <?php } ?>
        }
        
    </script>
</html>