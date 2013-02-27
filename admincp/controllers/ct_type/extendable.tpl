<!-- BEGIN: main -->
<div id="ext-form">
	<input type="hidden" value="0" name="field-count" id="field-count" />
    <fieldset>
        <h3 style="padding-bottom:5px; margin-bottom: 10px; border-bottom: 1px dashed #CCC">Thêm trường dữ liệu</h3>
        <fieldset id="ct_type_field">
            <!-- All extendable elements here-->
            <div id="sample-field">
                <div style="border-bottom: 1px dashed #CCC; margin-bottom: 10px">
                    <div class="control-group" style="margin-left: -160px">
                        <div class="controls">
                            <input type="text" name="field-name" placeholder="Tên trường" class="input-small text-tip" data-original-title="Dùng phân biệt các trường dữ liệu, chỉ dùng chữ số, chữ cái và kí tự _">
                            <input type="text" name="field-label" placeholder="Tiêu đề" class="input-medium text-tip" data-original-title="Tiêu đề hiển thị cho trường">
                            <select name="data-type" class="span2 text-tip" data-original-title="Loại dữ liệu">
                                <option>Loại dữ liệu</option>
                                <option value="number-int">Số nguyên</option>
                                <option value="number-float">Số thực</option>
                                <option value="varchar">Ký tự ( ngắn )</option>
                                <option value="text">Ký tự ( dài )</option>
                                <option value="date">Ngày tháng</option>
                                <option value="image">Hình ảnh</option>
                                <option value="file">Upload file</option>
                                <option value="radio">Radio</option>
                                <option value="checkbox">Checkbox</option>
                                <option value="select">Select</option>
                                <option value="referer">Dữ liệu liên kết</option>
                            </select>
                            <input type="text" name="field-length" placeholder="Độ dài" class="span1 text-tip" data-original-title="Độ dài tối đa của dữ liệu nhập vào">
                            <input type="text" name="default-value" placeholder="Giá trị mặc định" class="input-small text-tip" data-original-title="Giá trị mặc định">
							<select name="require" class="span2 text-tip" data-original-title="Trường dữ liệu bắt buộc">
                                <option value="0">Không bắt buộc</option>
                                <option value="1">Bắt buộc</option>
                            </select>
                            <span class="vnp-ext"></span>
                        </div>
                    </div>
                </div>
           	</div>
        </fieldset>
    </fieldset>
    <!-- Extendable Add Remove here-->
    <span class="extend-bar">
        <a id="add-btn" href="#" class="add-element text-tip" title="Thêm trường" data-original-title="Thêm trường">Thêm</a>
    </span>
</div>
<!-- END: main -->