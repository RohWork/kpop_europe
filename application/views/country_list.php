    <style>
        .onpointer{
            cursor: pointer;
        }
    </style>
    <div class="container">
        <div class="row">
            <table class="table table-striped" style="width:30vw">
                <thead>
                <tr>
                    <th>번호</th>
                    <th>제목</th>
                    <th>등록자</th>
                    <th>등록일</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                        $i =1;
                        foreach($list as $con){
                            echo "<tr onclick='view_info(".$con['idx']."_".$con['name'].")' class='onpointer'>";
                            echo "<td>".$i."</td>";
                            echo "<td>".$con['name']."</td>";
                            echo "<td>".$con['writer']."</td>";
                            echo "<td>".substr($con['regi_date'],0,10)."</td>";
                            echo "</tr>";
                            $i++;
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-5 col-offset-7 text-end">
                <button type="button" class="btn btn-primary" id="insert_button">INSERT</button>
            </div>
        </div>
        
        
        <div id="insert_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
        
            <div class="modal-dialog modal-lg"  role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">detail</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <form id="calendar_insert">
                                <div class="row mt-1">
                                    <div class="col-2">
                                        <label class="form-label bold"><strong>Event</strong></label>
                                    </div>
                                    <div class="col-10">
                                        <input type="text" class="form-control" id="input_name" name="input_name"/>
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col-2">
                                        <label class="form-label"><strong>Organizer</strong></label>
                                    </div>
                                    <div class="col-10">
                                        <input type="text" class="form-control" id="input_company" name="input_company"/>
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col-2">
                                        <label class="form-label"><strong>Country</strong></label>
                                    </div>
                                    <div class="col-10">
                                        <select class="form-select" multiple aria-label="multiple select example" id="input_country" name="input_country"/>
                                            <option value="Germany">Germany</option>
                                            <option value="France">France</option>
                                            <option value="UK">UK</option>
                                            <option value="Poland">Poland</option>
                                            <option value="Czech">Czech</option>
                                        <select>
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col-2">
                                        <label class="form-label"><strong>Hompage</strong></label>
                                    </div>
                                    <div class="col-10">
                                        <input type="text" class="form-control" id="input_homepage" name="input_homepage"/>
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col-2">
                                        <label class="form-label"><strong>Address</strong></label>
                                    </div>
                                    <div class="col-10">
                                        <input type="text" class="form-control" id="input_addr" name="input_addr"/>
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col-2">
                                        <label class="form-label"><strong>Facebook</strong></label>
                                    </div>
                                    <div class="col-10">
                                        <input type="text" class="form-control" id="input_face" name="input_face"/>
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col-2">
                                        <label class="form-label"><strong>Instagram</strong></label>
                                    </div>
                                    <div class="col-10">
                                        <input type="text" class="form-control" id="input_insta" name="input_insta"/>
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col-2">
                                        <label class="form-label"><strong>Youtube</strong></label>
                                    </div>
                                    <div class="col-10">
                                        <input type="text" class="form-control" id="input_yout" name="input_yout"/>
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col-2">
                                        <label class="form-label"><strong>Date</strong></label>
                                    </div>
                                    <div class="col-4">
                                        <input type="date" class="form-control" id="input_start_date" name="input_start_date" value="<?=date('Y-m-d')?>"/>
                                    </div>
                                    <div class="col-2" style="text-align: center">
                                        <label class="form-label"><strong> ~ </strong></label>
                                    </div>
                                    <div class="col-4">
                                        <input type="date" class="form-control" id="input_end_date" name="input_end_date" value="<?=date('Y-m-d')?>"/>
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col-2">
                                        <label class="form-label"><strong>Etc</strong></label>
                                    </div>
                                    <div class="col-10">

                                        <textarea id="input_remark" class="form-control" name="input_remark"> </textarea>
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col-2">
                                        <label class="form-label"><strong>Image</strong></label>

                                    </div>

                                    <div class="col-10" id="image_group" style="overflow-y: auto;height: 100px">
                                        <div class="input-group mb-2 mt-1">
                                            <input type="text" id="input_image[]" class="form-control i_img" name="input_image[]"/>
                                            <button type="button" class="btn btn-primary" id="input_url">+</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="insert_submit">Submit</button>
                        <button type="button" class="btn btn-secondary close" data-dismiss="modal" aria-label="Close">Close</button>
                    </div>
                </div>
            </div>
        </div>
               
    </div>
    <script>
        $("#insert_button").on("click",function(){
            alert('test');
        })
        
        function view_info(){
            alert('test');
        }
    </script>
</main>