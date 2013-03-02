<!-- BEGIN: main -->
<div class="widget-block">
	<div class="widget-head">
		<h5><i class="black-icons users"></i> Thêm content type</h5>
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
				<ul class="clearfix anchor">
                  	<li><a href="#step-1" class="selected" isdone="1" rel="1"> <span class="stepNumber">1</span> <span class="stepDesc"> Bước 1 <small>Hướng dẫn thêm content type</small></span></a></li>
                  	<li><a href="#step-2" class="disabled" isdone="0" rel="2"> <span class="stepNumber">2</span> <span class="stepDesc"> Bước 2 <small>Thêm content type</small></span></a></li>
                  	<li><a href="#step-3" class="disabled" isdone="0" rel="3"> <span class="stepNumber">3</span> <span class="stepDesc"> Bước 3 <small>Thêm content field</small></span></a></li>
                  	<li><a href="#step-4" class="disabled" isdone="0" rel="4"> <span class="stepNumber">4</span> <span class="stepDesc"> Bước 4 <small>Kết thúc</small></span></a></li>
                </ul>
                <form id="ct-form" action="{ACTION}" method="post" class="form-horizontal well" style="padding:0">
                    <fieldset style="padding:5px 19px">
                    	<div id="step-1">
                            <h3 class="StepTitle">Hướng dẫn thêm content type</h3>
                            
                            <p>Thêm content type</p>
                        </div>
                        <div id="step-2" class="content">        
                            <h3 class="StepTitle">Thêm content type</h3>
                            <p>
                            	<div class="ct_type-left">
                                    <div class="control-group">
                                        <label class="control-label" for="content_type_title">Tên content type</label>
                                        <div class="controls">
                                            <input type="text" class="input-xlarge tip-right" name="content_type_title" id="content_type_title" value="" data-original-title="Tên content type">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="content_type_name">Unique Id</label>
                                        <div class="controls">
                                            <input type="text" class="input-xlarge tip-right" name="content_type_name" id="content_type_name" value="" data-original-title="Duy nhất và là điều kiện phân biệt các content type">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="content_type_note">Miêu tả</label>
                                        <div class="controls">
                                            <textarea class="input-xlarge tip-right" id="content_type_note" name="content_type_note" rows="3" data-original-title="Miêu tả cho content type"></textarea>
                                        </div>
                                    </div>
                              	</div>
                                <div class="ct_type-right">
                                	<a href="javascript:void(0);" id="check-ct_type-btn" class="btn btn-success" onclick="check_ct_type();">
                                    	<i class="icon-ok"></i>
                                        Kiểm tra content type
                                   	</a>
                                    <div id="result"></div>
                                    <div id="ct_type-check-result"></div>
                                </div>
                            </p>
                        </div>
                        <div id="step-3" class="content">
                            <p>
                                <!-- extenable form field -->
                             	<div id="ext-form">
                                    <input type="hidden" value="0" name="field-count" id="field-count" />
                                    <fieldset>
                                        <h3 style="padding-bottom:5px; margin-bottom: 10px; border-bottom: 1px dashed #CCC">Thêm trường dữ liệu</h3>
                                        <fieldset id="ct_type_field">
                                            <!-- All extendable elements here-->
                                            <div id="sample-field">
                                                <div style="border-bottom: 1px dashed #CCC">
                                                    <div class="control-group vnp-field" id="ct_type_field0">
                                                        <div class="controls">
                                                            <input type="text" name="field_name" id="ct_field0_field_name" placeholder="Tên trường" class="input-small text-tip" data-original-title="Dùng phân biệt các trường dữ liệu, chỉ dùng chữ số, chữ cái và kí tự _">
                                                            <input type="text" name="field_label" id="ct_field0_field_label" placeholder="Tiêu đề" class="input-medium text-tip" data-original-title="Tiêu đề hiển thị cho trường">
                                                            <select name="field_type" id="ct_field0_field_type" class="span2 text-tip" data-original-title="Loại dữ liệu">
                                                                <option>Loại dữ liệu</option>
                                                                <option value="number-int">Số nguyên</option>
                                                                <option value="number-float">Số thực</option>
                                                                <option value="short-text">Ký tự ( ngắn )</option>
                                                                <option value="long-text">Ký tự ( dài )</option>
                                                                <option value="date">Ngày tháng</option>
                                                                <option value="image">Hình ảnh</option>
                                                                <option value="file">Upload file</option>
                                                                <option value="radio">Radio</option>
                                                                <option value="checkbox">Checkbox</option>
                                                                <option value="select">Select</option>
                                                                <option value="referer">Dữ liệu liên kết</option>
                                                            </select>
                                                            <input type="text" name="field_length" id="ct_field0_field_length" placeholder="Độ dài" class="span1 text-tip" data-original-title="Độ dài tối đa của dữ liệu nhập vào">
                                                            <input type="text" name="default_value" id="ct_field0_default_value" placeholder="Giá trị mặc định" class="input-small text-tip" data-original-title="Giá trị mặc định">
                                                            <select name="require" id="ct_field0_require" class="span2 text-tip" data-original-title="Trường dữ liệu bắt buộc">
                                                                <option value="0">Không bắt buộc</option>
                                                                <option value="1">Bắt buộc</option>
                                                            </select>
                                                            <span class="vnp-ext">
                                                            	<a id="0" href="javascript:void(0)" class="remove-element text-tip" onclick="rmvfield(0, '#ext-form');" data-original-title="Xóa dòng">Xóa dòng</a>
                                                            </span>
                                                            <span class="vnp-check"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </fieldset>
                                    <div style="clear:both; display: block"></div>
                                    <!-- Extendable Add Remove here-->
                                    <span class="extend-bar">
                                        <a id="add-btn" href="#" class="add-element text-tip" title="Thêm trường" data-original-title="Thêm trường">Thêm</a>
                                        <a href="javascript:void(0);" id="check-ct_type-btn" class="btn btn-success" onclick="check_ct_fields(0);">
                                            <i class="icon-th"></i>
                                            Kiểm tra content field
                                        </a>
                                    </span>
                                </div>    
                                <!-- end extenable form field -->
                            </p>
                        </div>
                        <div id="step-4">
                            <h2 class="StepTitle">Step 4 Content</h2>
                            
                            <div class="form-actions">
                                <button type="submit" name="submit" id="ct_type-submit" value="1" class="btn btn-primary">Save changes</button>
                                <button class="btn">Cancel</button>
                            </div>
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
#step-3 .controls {
	margin-left: 0 !important;
	padding-left: 10px;
}
.extend-bar {
	margin-top: 10px;
}
</style>
<script type="text/javascript">
$(function () {
	
});
</script>
<!-- END: main -->