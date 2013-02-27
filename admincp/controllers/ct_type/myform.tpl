<!-- BEGIN: main -->
<div class="">
    <div class="widget-block">
        <div class="widget-head">
            <h5><i class="black-icons users"></i> {FORM_DATA.header}</h5>
            <div class="widget-control pull-right">
                <!--Widget right dropdown here-->
            </div>
        </div>
        <div class="widget-selectbox">
            <!--search or filter bar here-->
        </div>
        <div class="widget-content">
            <div class="widget-box">
                <form  action="{FORM_DATA.action}" method="{FORM_DATA.method}"class="form-horizontal well">
                    <fieldset>
                        <!-- BEGIN: field -->
                        {FIELD_DATA}
                        <!-- END: field -->
                        {EXT}
                        <div class="form-actions">
                            <button type="submit" name="submit" value="1" class="btn btn-primary">Save changes</button>
                            <button class="btn">Cancel</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
        <div class="widget-bottom">
            <!--Widget bottom here-->
            <div class="pagination">
                <!--Pagination for widget if require-->
            </div>
        </div>
    </div>
</div>
<!-- END: main -->