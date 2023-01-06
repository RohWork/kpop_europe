
        <div class="container" style="font-size: 12px">
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
                            <td><?=$li['start_date']?></td>
                            <td><?=$li['end_date']?></td>
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
    </main