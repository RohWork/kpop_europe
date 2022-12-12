
    <div class="container">
        <form id="calendar_insert">
            <div class="row">
                <label class="form-label"><h3>Schedule Insert</h3></label>
            </div>
            <div class="row mt-1">
                <label class="form-label col-2"><strong>Event</strong></label>
                <div class="col-4 col-offset-6">
                    <input type="text" class="form-control" id="input_name" name="input_name"/>
                </div>
            </div>
            <div class="row mt-1">
                <label class="form-label col-2"><strong>Country</strong></label>

                <div class="col-4 col-offset-6">
                        <select id="check_country" name="check_country" class="form-select">
                            <?php foreach($country as $cnt){ ?>
                                <option value="<?=$cnt['idx']?>"><?=$cnt['name']?></option>

                            <?php } ?>
                        </select>
                </div>
            </div>
            <div class="row mt-1">
                <label class="form-label col-2"><strong>City</strong></label>

                <div class="col-4 col-offset-6">
                    <select class="form-select" id="input_country" name="input_country">
                        <option value=""></option>
                    </select>
                </div>
            </div>    
            <div class="row mt-1">

                <label class="form-label col-2"><strong>Organizer</strong></label>

                <div class="col-4 col-offset-6">
                    <input type="text" class="form-control" id="input_company" name="input_company"/>
                </div>
            </div>     
        </form>
    </div>

</main>