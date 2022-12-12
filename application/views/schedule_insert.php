
    <div class="container">
        <form id="calendar_insert">
            <div class="row">
                <label class="form-label"><h3>Schedule Insert</h3></label>
            </div>
            <div class="row mt-1">
                <label class="form-label col-md-2 col-xs-4"><strong>Event</strong></label>
                <div class="col-md-4 col-xs-4 col-offset-6 col-xs-offset-4">
                    <input type="text" class="form-control" id="input_name" name="input_name"/>
                </div>
            </div>
            <div class="row mt-1">
                <label class="form-label col-md-2 col-xs-4"><strong>Country</strong></label>

                <div class="col-md-4 col-xs-4 col-offset-6 col-xs-offset-4">
                    <select id="check_country" name="check_country" class="form-select">
                        <?php foreach($country as $cnt){ ?>
                            <option value="<?=$cnt['idx']?>"><?=$cnt['name']?></option>

                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="row mt-1">
                <label class="form-label col-md-2 col-xs-4"><strong>City</strong></label>

                <div class="col-md-4 col-xs-4 col-offset-6 col-xs-offset-4">
                    <select class="form-select" id="input_country" name="input_country">
                        <option value=""></option>
                    </select>
                </div>
            </div>    
            <div class="row mt-1">

                <label class="form-label col-md-2 col-xs-4"><strong>Organizer</strong></label>

                <div class="col-md-4 col-xs-4 col-offset-6 col-xs-offset-4">
                        <select id="check_organization" name="check_organization" class="form-select">
                            <?php foreach($organization as $org){ ?>
                                <option value="<?=$org['idx']?>"><?=$org['name']?></option>

                            <?php } ?>
                        </select>
                </div>
            </div>
            <div class="row mt-1">
                <label class="form-label col-md-2 col-xs-4"><strong>Hompage</strong></label>
                <div class="col-md-4 col-xs-4 col-offset-6 col-xs-offset-4">
                    <input type="text" class="form-control" id="input_homepage" name="input_homepage"/>
                </div>
            </div>
            <div class="row mt-1">

                <label class="form-label col-md-2 col-xs-4"><strong>Address</strong></label>

                <div class="col-md-4 col-xs-4 col-offset-6 col-xs-offset-4">
                    <input type="text" class="form-control" id="input_addr" name="input_addr"/>
                </div>
            </div>
            <div class="row mt-1">

                <label class="form-label col-md-2 col-xs-4"><strong>Facebook</strong></label>
                
                <div class="col-md-4 col-xs-4 col-offset-6 col-xs-offset-4">
                    <input type="text" class="form-control" id="input_face" name="input_face"/>
                </div>
            </div>
            <div class="row mt-1">

                <label class="form-label col-md-2 col-xs-4"><strong>Instagram</strong></label>
                
                <div class="col-md-4 col-xs-4 col-offset-6 col-xs-offset-4">
                    <input type="text" class="form-control" id="input_insta" name="input_insta"/>
                </div>
            </div>
            <div class="row mt-1">
 
                <label class="form-label col-md-2 col-xs-4"><strong>Youtube</strong></label>

                <div class="col-md-4 col-xs-4 col-offset-6 col-xs-offset-4">
                    <input type="text" class="form-control" id="input_yout" name="input_yout"/>
                </div>
            </div>
            <div class="row mt-1">

                <label class="form-label col-md-2 col-xs-4"><strong>Date</strong></label>

                <div class="col-md-1 col-xs-3">
                    <input type="date" class="form-control" id="input_start_date" name="input_start_date" value="<?=date('Y-m-d')?>"/>
                </div>
                <div class="col-md-2 col-xs-2" style="text-align: center">
                    <label class="form-label"><strong> ~ </strong></label>
                </div>
                <div class="col-md-1 col-md-offset-6 col-xs-3">
                    <input type="date" class="form-control" id="input_end_date" name="input_end_date" value="<?=date('Y-m-d')?>"/>
                </div>
            </div>
            <div class="row mt-1">
                
                <label class="form-label col-md-2 col-xs-4"><strong>Etc</strong></label>

                <div class="col-md-4 col-xs-4 col-offset-6 col-xs-offset-4">

                    <textarea id="input_remark" class="form-control" name="input_remark"> </textarea>
                </div>
            </div>
            <div class="row mt-1">

                <label class="form-label col-md-2 col-xs-4"><strong>Image</strong></label>
                
                <div class="col-md-4 col-xs-4 col-offset-6 col-xs-offset-4" id="image_group" style="overflow-y: auto;height: 100px">
                    <div class="input-group mb-2 mt-1">
                        <input type="text" id="input_image[]" class="form-control i_img" name="input_image[]"/>
                        <button type="button" class="btn btn-primary" id="input_url">+</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

</main>