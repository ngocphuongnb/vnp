<!-- BEGIN: main -->
<script src="{MY_DIR}sources/static/js/jquery.form.js"></script>
<script type="text/javascript">
$(document).ready(function() { 
    var options = { 
        //target:        '#submit-result',
        beforeSubmit:  showRequest,
        success:       showResponse
    }; 
    $('#ct-form').ajaxForm(options);
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
<div class="widget-block">
	<div class="widget-head">
		<h5><i class="black-icons users"></i> Sửa content type</h5>
		<div class="widget-control pull-right"> 
      		<!--Widget right dropdown here--> 
    	</div>
  	</div>
	<div class="widget-selectbox"> 
    	<!--search or filter bar here--> 
	</div>
	<div class="widget-content">
		<div class="widget-box">
        	<div id="add-ct_type-wizard" class="content-wizard">
                <form id="ct-form" action="{ACTION}" method="post" class="form-horizontal well" style="padding:0">
                    <fieldset style="padding:5px 19px">
                        <!-- extenable form field -->
                        <div id="ext-form">
                            <input type="hidden" value="0" name="field-count" id="field-count" />
                            <fieldset>
                                <h3 style="padding-bottom:5px; margin-bottom: 10px; border-bottom: 1px dashed #CCC">Quản lý trường dữ liệu</h3>
                                <fieldset id="ct_type_field">
                                    <!-- All extendable elements here-->
                                    <!-- BEGIN: field -->
                                    <div id="field-0">
                                        <div style="border-bottom: 1px dashed #CCC">
                                            <div class="control-group vnp-field" id="ct_type_field0">
                                                <div class="controls">
                                                    <input type="text" name="field_name" id="ct_field0_field_name" placeholder="Tên trường" value="{FIELD.field_name}" class="input-small text-tip" data-original-title="Dùng phân biệt các trường dữ liệu, chỉ dùng chữ số, chữ cái và kí tự _">
                                                    <input type="text" name="field_label" id="ct_field0_field_label" placeholder="Tiêu đề" value="{FIELD.field_label}" class="input-medium text-tip" data-original-title="Tiêu đề hiển thị cho trường">
                                                    <select name="field_type" id="ct_field0_field_type" onchange="ctType_change(this, 0);" class="span2 text-tip" data-original-title="Loại dữ liệu">
                                                        <option>Loại dữ liệu</option>                           
                                                        <!-- BEGIN: ct_field_type_otps -->
                                                        <option value="{OTPS.value}" {OTPS.slted}>{OTPS.text}</option> 
                                                        <!-- END: ct_field_type_otps -->
                                                    </select>
                                                    <input type="text" name="field_length" id="ct_field0_field_length" placeholder="Độ dài" value="{FIELD.field_length}" class="span1 text-tip" data-original-title="Độ dài tối đa của dữ liệu nhập vào">
                                                    <input type="text" name="default_value" id="ct_field0_default_value" placeholder="Giá trị mặc định" value="{FIELD.defaul_value}" class="input-small text-tip" data-original-title="Giá trị mặc định">
                                                    <select name="require" id="ct_field0_require" class="span2 text-tip" data-original-title="Trường dữ liệu bắt buộc">
                                                        <option value="0">Không bắt buộc</option>
                                                        <option value="1"{FIELD.require}>Bắt buộc</option>
                                                    </select>
                                                    <input type="checkbox" {FIELD.is_unique} name="is_unique" value="1" id="ct_field0_is_unique" placeholder="Is unique key" class="text-tip" data-original-title="Chọn làm khóa">
                                                    <span class="vnp-ext">
                                                        <a id="0" href="javascript:void(0)" class="remove-element text-tip" onclick="rmvfield(0, '#ext-form');" data-original-title="Xóa dòng">Xóa dòng</a>
                                                    </span>
                                                    <span class="vnp-check"></span>
                                                    <div id="op-container"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END: field -->
                                </fieldset>
                            </fieldset>
                            <div style="clear:both; display: block"></div>
                            <!-- Extendable Add Remove here-->
                            <span class="extend-bar">
                                <a id="add-btn" href="#" class="info_t btn btn-info" title="Thêm trường" data-original-title="Thêm trường"><i class="icon-plus icon-white"></i>Thêm</a>
                                <a href="javascript:void(0);" id="check-ct_type-btn" class="btn btn-success" onclick="check_ct_fields(0);">
                                    <i class="icon-th"></i>
                                    Kiểm tra content field
                                </a>
                            </span>
                        </div>    
                        <!-- end extenable form field -->
                            
                        <div id="submit-result"></div> 
                        <div class="form-actions">
                            <button type="submit" name="submit" id="ct_type-submit" value="1" class="btn btn-primary">Save changes</button>
                            <button class="btn">Cancel</button>
                        </div>
                    </fieldset>
                </form>
     		</div>				
		</div>
	</div>
    <div class="widget-bottom"> 
        <!--Widget bottom here-->
        <div class="pagination"> 
            <!--Pagination for widget if require--> 
        </div>
    </div>
</div>

<div class="modal hide" id="myModal">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h3>Modal header</h3>
	</div>
	<div class="modal-body">
		<p>One fine body…</p>
	</div>
	<div class="modal-footer"></div>
</div>

<style>
.stepContainer {
	padding: 0 !important;
	height: 0 !important;
}
.ct_type-left {
	width: 49%;
	float: left;
	padding-right: 10px;
	border-right: 1px dashed #CCC
}
.ct_type-right {
	width: 49%;
	float: right;
}
#result {
	margin-top: 10px;
}
.vnp-field {
	margin-bottom: 0 !important;
	min-height: 50px;
}
.vnp-field .controls {
	padding: 10px
}
.vnp-field .label {
	line-height: 25px
}
#ext-form .controls {
	margin-left: 0 !important;
	padding-left: 10px;
}
.extend-bar {
	margin-top: 10px;
}
</style>
<!-- END: main -->