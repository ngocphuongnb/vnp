<!-- BEGIN: main -->

<div class="control-group">
    <label class="control-label" for="input01">{LABEL}</label>
    <div class="controls">
    	<!-- BEGIN: textbox -->
        <input type="text" class="input-xlarge text-tip" id="input01" data-original-title="{TOOL_TIP}" >
        <!-- END: textbox -->
        
        <!-- BEGIN: checkbox -->
        <!-- BEGIN: options -->
        <label class="checkbox">
        	<input type="checkbox" value="option1">
			{OPTION_NAME}
        </label>
        <!-- END: options -->
        <!-- END: textbox -->
        
        <!-- BEGIN: radio -->
        <!-- BEGIN: options -->
        <label class="radio">
        	<input type="radio" value="option1">
			{OPTION_NAME}
        </label>
        <!-- END: options -->
        <!-- END: radio -->
        
        <!-- BEGIN: selectbox -->
        <select>
        	<!-- BEGIN: options -->
            <option>something</option>
            <!-- END: options -->
        </select>
        <!-- END: selectbox -->
        
        <!-- BEGIN: multiselectbox -->
        <select multiple="multiple">
        	<!-- BEGIN: options -->
            <option>something</option>
            <!-- END: options -->
        </select>
        <!-- END: multiselectbox -->
        
        <!-- BEGIN: filesupload -->
        <div class="uni-uploader" id="uniform-undefined">
        	<input class="input-file" type="file" size="19" style="opacity: 0;">
            <span class="filename">No file selected</span><span class="action">Choose File</span>
        </div>
        <!-- END: filesupload -->
        
        
        <p class="help-block">{HELP_TEXT}</p>
    </div>
</div>
    
<!-- END: main -->