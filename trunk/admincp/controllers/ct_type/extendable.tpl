<!-- BEGIN: main -->
<script src="{MY_DIR}sources/static/js/vnp-extenable-form.jquery.js"></script>
<script src="{MY_DIR}sources/static/js/jquery.form.js"></script>

<div class="content-wizard">
    <form id="ct-form" action="{ACTION}" method="post">
        <fieldset>
        	<!-- Add content type main information step -->
            <div id="add-type">        
                <h3 class="StepTitle">Thêm content type</h3>
                <div class="form-row">
                    <label class="vnp-label" for="content_type_title">Tên content type</label>
                    <input type="text" name="content_type_title" id="content_type_title" value="">
                </div>
                <div class="form-row">
                    <label class="vnp-label" for="content_type_name">Unique Id</label>
                    <input type="text" name="content_type_name" id="content_type_name" value="">
                </div>
                <div class="form-row">
                    <label class="vnp-label" for="content_type_note">Miêu tả</label>
                    <textarea class="input-xlarge tip-right" id="content_type_note" name="content_type_note" rows="3" data-original-title="Miêu tả cho content type"></textarea>
                </div>
                <!-- Check content type button and result -->
                <a href="javascript:void(0);" id="check-ct_type-btn" class="btn btn-success" onclick="check_ct_type();">
                    <i class="icon-ok"></i>
                    Kiểm tra content type
                </a>
                <div id="result"></div>
                <div id="ct_type-check-result"></div>
                <!-- End check content type -->
            </div>
            <!-- End Add content type main information step -->
            <!-- Add content type field step -->
            <div id="add-field" class="content">
                <div id="ext-form">
                    <input type="hidden" value="0" name="field-count" id="field-count" />
                    <h3>Thêm trường dữ liệu</h3>
                    <fieldset id="ct_type_field">
                        <!-- All extendable elements here-->
                        <div id="field-0">
                            <div class="vnp-field" id="ct_type_field0">
                                <input type="text" name="field_name" id="ct_field0_field_name" placeholder="Tên trường" data-original-title="Dùng phân biệt các trường dữ liệu, chỉ dùng chữ số, chữ cái và kí tự _">
                                <input type="text" name="field_label" id="ct_field0_field_label" placeholder="Tiêu đề" data-original-title="Tiêu đề hiển thị cho trường">
                                <select name="field_type" id="ct_field0_field_type" onchange="ctType_change(this, 0);" data-original-title="Loại dữ liệu">
                                    <option>Loại dữ liệu</option>                             
                                    <option value="image">Hình ảnh</option>
                                    <option value="file">Upload file</option>
                                    <option value="radio">Radio</option>
                                    <option value="checkbox">Checkbox</option>
                                    <option value="select">Select</option>
                                    <option value="referer">Dữ liệu liên kết</option>              
                                    
                                    <option value="VARCHAR">VARCHAR</option>
                                    <option value="TINYINT">TINYINT</option>
                                    <option value="TEXT">TEXT</option>
                                    <option value="DATE">DATE</option>
                                    <option value="SMALLINT">SMALLINT</option>
                                    <option value="MEDIUMINT">MEDIUMINT</option>
                                    <option value="INT">INT</option>
                                    <option value="BIGINT">BIGINT</option>
                                    <option value="FLOAT">FLOAT</option>
                                    <option value="DOUBLE">DOUBLE</option>
                                    <option value="DECIMAL">DECIMAL</option>
                                    <option value="DATETIME">DATETIME</option>
                                    <option value="TIMESTAMP">TIMESTAMP</option>
                                    <option value="TIME">TIME</option>
                                    <option value="YEAR">YEAR</option>
                                    <option value="CHAR">CHAR</option>
                                    <option value="TINYBLOB">TINYBLOB</option>
                                    <option value="TINYTEXT">TINYTEXT</option>
                                    <option value="BLOB">BLOB</option>
                                    <option value="MEDIUMBLOB">MEDIUMBLOB</option>
                                    <option value="MEDIUMTEXT">MEDIUMTEXT</option>
                                    <option value="LONGBLOB">LONGBLOB</option>
                                    <option value="LONGTEXT">LONGTEXT</option>
                                    <option value="ENUM">ENUM</option>
                                    <option value="SET">SET</option>
                                    <option value="BOOL">BOOL</option>
                                    <option value="BINARY">BINARY</option>
                                    <option value="VARBINARY">VARBINARY</option>
                                </select>
                                <input type="text" name="field_length" id="ct_field0_field_length" placeholder="Độ dài" data-original-title="Độ dài tối đa của dữ liệu nhập vào">
                                <input type="text" name="default_value" id="ct_field0_default_value" placeholder="Giá trị mặc định" data-original-title="Giá trị mặc định">
                                <select name="require" id="ct_field0_require" data-original-title="Trường dữ liệu bắt buộc">
                                    <option value="0">Không bắt buộc</option>
                                    <option value="1">Bắt buộc</option>
                                </select>
                                <input type="checkbox" name="is_unique" value="1" id="ct_field0_is_unique" placeholder="Is unique key" data-original-title="Chọn làm khóa">
                                <span class="vnp-ext">
                                    <a id="0" href="javascript:void(0)" class="remove-element text-tip" onclick="rmvfield(0, '#ext-form');" data-original-title="Xóa dòng">Xóa dòng</a>
                                </span>
                                <span class="vnp-check"></span>
                                <div id="op-container"></div>
                            </div>
                        </div>
                    </fieldset>
                    <!-- Extendable Add Remove here-->
                    <span class="extend-bar">
                        <a id="add-btn" href="javascript:void(0);" class="info_t btn btn-info" title="Thêm trường"><i class="icon-plus icon-white"></i>Thêm</a>
                        <a href="javascript:void(0);" id="check-ct_type-btn" class="btn btn-success" onclick="check_ct_fields(0);">
                            <i class="icon-th"></i>
                            Kiểm tra content field
                        </a>
                    </span>
                </div>
            </div>
            <div id="step-4">
                <h2 class="StepTitle">Step 4 Content</h2>
                
                <div id="submit-result"></div>
                
                <div class="form-actions">
                    <button type="submit" name="submit" id="ct_type-submit" value="1" class="btn btn-primary">Save changes</button>
                    <button class="btn">Cancel</button>
                </div>
            </div>
        </fieldset>
    </form>
</div>
<script type="text/javascript">
$(document).ready(function() { 
    var options = { 
        //target:        '#submit-result',
        beforeSubmit:  showRequest,
        success:       showResponse
    }; 
    $('#ct-form').ajaxForm(options);
	$('#ext-form').extForm();
}); 
 
// pre-submit callback 
function showRequest(formData, jqForm, options)
{
    showLoading('#vnpContainer #content-ctner');
} 
 
// post-submit callback 
function showResponse(responseText, statusText, xhr, $form)
{
    hideLoading('#vnpContainer #content-ctner');
} 
</script>
<!-- END: main -->