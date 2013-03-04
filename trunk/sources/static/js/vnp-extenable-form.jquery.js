/**
 * @Project VNP Extendable jquery plugin
 * @Author Nguyen Ngoc Phuong
 * @Copyright (C) 2013 Nguyen Ngoc Phuong. All rights reserved
 * @Createdate  27/02/2013, 18:31
 */

(function($){  
	$.fn.extForm = function(options) {  
      
  	var defaults = {
		addcolor:		"blue",
		removecolor:	"red"
	},
	fieldType	= "input, checkbox, select, textarea",
	fieldNo		= 0,
	cloneData	= "",
	sltor	= this.selector;
    
	var options = $.extend( defaults, options );  
	
	init = function(objData){
		
		//alert(sltor);
		
		objData.find(fieldType).each(function(){
			var field = $(this), 
			nameAttr = field.attr("name"),
			origNameAttr = field.attr("origname");

			/* Normalize field name attributes */
			if(!nameAttr) {
				//TODO: that.attr("name", formPrefix+"form"+index + "["+index+"]");
			}
			
			if(origNameAttr && origNameAttr != 'is_primary' )
			{
				//This is a subform (thus prefix is not the same as below)
				field.attr("name", "ct_type_field0[" + origNameAttr + "]");
			}
			else
			{
				if( nameAttr != 'is_primary' )
				{
					//This is the main form
					field.attr("origname", nameAttr);
					
					//This is the main normalization
					field.attr("name", "ct_type_field0[" + nameAttr + "]");
				}
			}
		});
	}
	
	rmvField = function(obj){
		alert(obj.attr("id"));
	}
	
	cloneField = function(myObj, fieldData){
		fieldNo++;
		
		$("#field-count", myObj).val(fieldNo);
		
		fieldData = "<div>" + fieldData + "</div>";
		
		$(fieldData).find('.controls').each(function(){
			
			var crData = $(this);
			
			//sltor = sltor.replace(/ /g, "");
			
			$('.vnp-ext', crData).html('<a id="'+ fieldNo + '" href="javascript:void(0)" class="remove-element text-tip" title="Xóa dòng" onclick="rmvfield(' + fieldNo + ', \'' + sltor + '\');">Xóa dòng</a>');
			
			var add = crData.html();
			add = add.replace(/ct_type_field0/g, 'ct_type_field' + fieldNo);
			add = add.replace(/ct_field0/g, 'ct_field' + fieldNo);
			add = 	"<div id=\"field-" + fieldNo + "\" style=\"border-bottom: 1px dashed #CCC;\">" + 
                	"<div class=\"control-group vnp-field\" id=\"ct_type_field" + fieldNo +"\">" +
                    "<div class=\"controls\">" + add + "</div></div></div>";
					
			$('#ct_type_field', myObj ).append(add);
		
		});
	}
    
	return this.each( function() {
		obj = $(this);
		var body = obj.html();
		var fieldArea = $('.controls', obj);
		init(fieldArea);
		cloneData = $('#ct_type_field', obj).html();
		
		$('#remove-btn', obj).click(function(){
			event.preventDefault();
			alert('remove');
		});
		
		$('#add-btn', obj).click(function(){
			event.preventDefault();
			//var fieldData = $('#ct_type_field', obj).html();
			cloneField(obj, cloneData);
			$('.text-tip').tooltip({
				placement: 'top'
			});
		});
	});  
 };  
})(jQuery);

function rmvfield(id, sltor)
{
	if( confirm( "Bạn có chắc chắn xóa trường dữ liệu này?'" ) )
	{
		$(sltor + ' #field-' + id).remove();
		$('.tooltip').remove();
	}
}
	