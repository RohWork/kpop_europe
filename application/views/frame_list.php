<html>
    <head>
        <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <div class="container" style="font-size: 12px;max-width:100%">
            <div class="row">
                <div class="col-12">
                    <table class="table table-striped">
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>START_DATE</th>
                            <th>END_DATE</th>
                        </tr>
                        <?php 
                            $i=1;
                            foreach($list as $li){
                        ?>        
                        <tr onclick="go_detail(<?=$li['idx']?>,'<?=$li['name']?>')" style="cursor: pointer">
                            <td><?=$i?></td>
                            <td><?=$li['name']?></td>
                            <td><?=date('d-m-Y',strtotime($li['start_date']))?></td>
                            <td><?=date('d-m-Y',strtotime($li['end_date']))?></td>
                        </tr>   
                        <?php 
                            $i++;
                            }
                        ?>
                    </table>
                </div>
            </div>
        </div>
        
        
        
        <div id="detail_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">

            <div class="modal-dialog modal-lg" style="max-height:85%;" role="document">
                <div class="modal-content" style="height:600px">
                    <div class="modal-header">
                        <h5 class="modal-title">detail</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <iframe src="" id="detail_frame" style="width:100%; height:100%">etc</iframe>  
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary close" data-dismiss="modal" aria-label="Close">Close</button>
                        <button type="button" class="btn btn-secondary list" aria-label="List">List</button>
                    </div>
                </div>
            </div>
        </div>
        
    </body>
    <script>
    
    function go_detail(idx, name){

        parent.go_detail(idx, name);
        
    }
    
    $(".close").on('click', function(){    
        $('#detail_modal').modal('hide');
    });

    $('#detail_modal').on('show.bs.modal', function () {
           $(this).find('.modal-body').css({
                  width:'auto', //probably not needed
                  height:'auto', //probably not needed 
                  'max-height':'100%'
           });
    });
    
    </script>
</html>