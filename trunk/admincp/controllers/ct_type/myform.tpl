<!-- BEGIN: main -->
<script src="{MY_DIR}sources/static/js/jquery.form.js"></script>
<script type="text/javascript">
$(document).ready(function() { 
    var options = { 
        beforeSubmit:  showRequest,
        success:       showResponse
    }; 
    $('#vnp-form').ajaxForm(options);
}); 
 
// pre-submit callback 
function showRequest(formData, jqForm, options)
{
    showLoading("#main-content .container-fluid .row-fluid");
} 
 
// post-submit callback 
function showResponse(responseText, statusText, xhr, $form)
{
	var result = responseText.split('*');
	if( result[0] == 'OK' )
	{
		var noty_id = noty({
								layout : 'top',
								text: result[1],
								modal : true,
								type: 'success',
								timeout: 1200,
							});
	}
	else
	{
		var noty_id = noty({
								layout : 'top',
								text: 'Đã có lỗi sảy ra, xem lỗi bên dưới',
								modal : true,
								type: 'error',
								timeout: 800,
							});
		$('#myModal .modal-header h3').html('Đã có lỗi sảy ra');
		$('#myModal .modal-body p').html('<blockquote class="quote_orange">' + result[1] + '</blockquote>');
		$('#myModal').modal({
			keyboard: false
		})
	}
    hideLoading("#main-content .container-fluid .row-fluid");
} 
</script>
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
                <form action="{FORM_DATA.action}" id="vnp-form" method="{FORM_DATA.method}"class="form-horizontal well">
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