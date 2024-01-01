<?php
    $lang = $this->session->userdata('lang');
    $this->lang->load('view', $lang);

?>



    <div class="container">
        <form id="calendar_insert" action="/schedule/excel_process" enctype="multipart/form-data" method="post">
            <div class="row">
                <div class="col-12">
                    <h3 style="font-size: bold">only excel file. <br/> ex) </h3>
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th>No</th>
                            <th>Type</th>
                            <th>Company</th>
                            <th>Country<th>
                            <th>City<th>
                            <th>Club Name</th>
                            <th>Address</th>
                            <th>Open Date</th>
                            <th>Open Time</th>
                            <th>Close Date</th>
                            <th>Close Time</th>
                            <th>Homepage</th>
                            <th>Instagram</th>
                            <th>FaceBook</th>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Party</td>
                            <td>company name</td>
                            <td>Germany</td>
                            <td>Hannover</td>
                            <td>Infinity Club</td>
                            <td>Marktstraße ...</td>
                            <td><?=date('Y-m-d')?></td>
                            <td>22:00</td>
                            <td><?=date('Y-m-d', strtotime("+1 days"))?></td>
                            <td>05:00</td>
                            <td>http://google.com</td>
                            <td>https://www.instagram.com/test/</td>
                            <td>https://fb.me/e/fakePage</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <input type="file" name="upload_excel" class="form-control" required/>
                </div>
            </div>
            <div class="row" style="padding-top: 3vh">
                <div class="col-12">
                    <input type="submit" name="upload_excel" value="upload" class="btn btn-primary"/>
                </div>
            </div>
        </form>
        
    </div>
</main>