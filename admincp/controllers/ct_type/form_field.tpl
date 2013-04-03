<!-- BEGIN: main -->
<div class="control-group">
    <label class="control-label" for="{FIELD.field_name}">{FIELD.field_label}</label>
    <div class="controls">
    	<!-- BEGIN: textbox -->
        <input type="text" class="input-xlarge tip-right" {FIELD.evenmethod} name="{FIELD.field_name}" id="{FIELD.id}" value="{FIELD.value}" data-original-title="{FIELD.tooltip}">
        <!-- END: textbox -->
        
        <!-- BEGIN: date -->
        <div class="input-append date">
            <input type="text" {FIELD.evenmethod} name="{FIELD.field_name}" id="date" value="{FIELD.value}" data-original-title="{FIELD.tooltip}" >
            <span class="add-on  margin-fix"><i class="icon-th"></i></span>
        </div>
        <!-- END: date -->
        
        <!-- BEGIN: textarea -->
        <div>
        	<textarea class="input-xlarge tip-right" name="{FIELD.field_name}" id="{FIELD.field_name}" rows="3" data-original-title="{FIELD.tooltip}">{FIELD.value}</textarea>
       	</div>
        <!-- END: textarea -->
        
        <!-- BEGIN: checkbox -->
        <!-- BEGIN: options -->
        <label class="checkbox" id="{FIELD.id}" data-original-title="{FIELD.tooltip}">
        	<input class="checkbox-b" type="checkbox" {FIELD.evenmethod} name="{FIELD.field_name}" value="{OPTION.value}"{OPTION.checked}>
            {OPTION.text}
        </label>
        <!-- END: options -->
        <!-- END: checkbox -->
        
        <!-- BEGIN: radio -->
        <!-- BEGIN: options -->
        <label class="radio" data-original-title="{FIELD.tooltip}">
        	<input class="radio-b" type="radio" name="{FIELD.field_name}" value="{OPTION.value}"{OPTION.checked}>
			{OPTION.text}
        </label>
        <!-- END: options -->
        <!-- END: radio -->
        
        <!-- BEGIN: selectbox -->
        <select name="{FIELD.field_name}" {FIELD.evenmethod} data-original-title="{FIELD.tooltip}">
        	<!-- BEGIN: options -->
            <option value="{OPTION.value}"{OPTION.selected}>{OPTION.text}</option>
            <!-- END: options -->
        </select>
        <!-- END: selectbox -->
        
        <!-- BEGIN: multiselectbox -->
        <select name="{FIELD.field_name}" {FIELD.evenmethod} id="{FIELD.id}" data-original-title="{FIELD.tooltip}" multiple="multiple">
        	<!-- BEGIN: options -->
            <option value="{FIELD.value}"{FIELD.selected}>{FIELD.text}</option>
            <!-- END: options -->
        </select>
        <!-- END: multiselectbox -->
        
        <!-- BEGIN: filesupload -->
        <div class="uni-uploader" id="uniform-undefined">
        	<input class="input-file" type="file" size="19" style="opacity: 0;">
            <span class="filename">No file selected</span><span class="action">Choose File</span>
        </div>
        <!-- END: filesupload -->
        
        <!-- BEGIN: image -->
        <div class="uni-uploader" id="uniform-undefined">
        	<input class="input-file" name="{FIELD.field_name}" type="file" size="19" style="opacity: 0;">
            <span class="filename">No file selected</span><span class="action">Choose File</span>
        </div>
        <!-- END: image -->
        <!-- BEGIN: help -->
        <p class="help-block">{FIELD.help}</p>
        <!-- END: help -->
    </div>
</div>
    
<!-- END: main -->