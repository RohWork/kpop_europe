    <div class="container">
        <form id="calendar_insert" target="/main/schedule_excle_process" method="post">
            <div class="row">
                <div class="col-12">
                    <h3 style="font-size: bold">only excel file ex) </h3>
                    <table class="table table-striped table-bordered">
                        <th>

                            <td>No</td>
                            <td>Subject</td>
                            <td>Company</td>
                            <td>Date</td>
                            <td>DOW</td>
                            <td>Country</td>
                            <td>City</td>
                            <td>Address</td>
                            <td>Open</td>
                            <td>Close</td>
                            <td>Homepage</td>
                            <td>Instagram</td>
                            <td>FaceBook</td>
                        </th>
                        <tr>
                            <td>1</td>
                            <td>Party</td>
                            <td>company name</td>
                            <td><?=date('Y-m-d')?></td>
                            <td>FR</td>
                            <td>Germany</td>
                            <td>Hannover</td>
                            <td>Infinity Club, Marktstraße ...</td>
                            <td><?=date('Y-m-d')?> 22:00</td>
                            <td><?=date('Y-m-d', strtotime("+1 days"))?> 05:00</td>
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