/**
 * @Project VNP Ajax
 * @Author Nguyen Ngoc Phuong
 * @Copyright (C) 2013 Nguyen Ngoc Phuong. All rights reserved
 * @Createdate  27/02/2013, 18:31
 */

function check_ct_type()
{
	var title	= $('#step-2 input#content_type_title').val(),
		name	= $('#step-2 input#content_type_name').val(),
		note	= $('#step-2 textarea#content_type_note').val();
		
	var ctObject =new Object();
	ctObject.content_type_title		= title;
	ctObject.content_type_name		= name;
	ctObject.content_type_note		= note;
	
	/*
	ct_typeJson = '{' +
						'"content_type_title":"' + title + '",' +
						'"content_type_name":"' + name + '"' +
					'}';	
	*/				
	$.ajax({
		type: "POST",
		url: "ajax.php?ajax=1&ctl=ct_type&action=Ajax_check_ct_type",
		dataType: "json",
		//data: { ct_typeJson: ct_typeJson },
		data: { ct_typeJson: JSON.stringify( ctObject ) },
		
		beforeSend: function() {
			$("form#ct-form #check-ct_type-btn").addClass('buttonDisabled');
			$(".buttonNext").addClass('buttonDisabled');
            showLoading("form#ct-form");
        },
		
		success: function ( data ){
			if( data.status == 'ok' )
			{
				$("form#ct-form #check-ct_type-btn").removeClass('buttonDisabled');
				$(".buttonNext").removeClass('buttonDisabled');
			}
			else
			{
				$("form#ct-form #check-ct_type-btn").removeClass('buttonDisabled');
			}
			hideLoading("form#ct-form");
			$("#result").html( data.msg );
  		}
	});
}

function check_ct_fields( fieldIndex )
{
	var fieldnums = $('#step-3 input#field-count').val();
	
	if( fieldIndex <= fieldnums )
	{
		var selector = '#step-3 #ct_type_field' + fieldIndex;
		var fieldObject = new Object();
		
		fieldObject.field_name		= $(selector + ' input#ct_field' + fieldIndex + '_' + 'field_name').val();
		fieldObject.field_label		= $(selector + ' input#ct_field' + fieldIndex + '_' + 'field_label').val();
		fieldObject.field_type		= $(selector + ' select#ct_field' + fieldIndex + '_' + 'field_type option:selected').val();
		fieldObject.field_length	= $(selector + ' input#ct_field' + fieldIndex + '_' + 'field_length').val();
		fieldObject.default_value	= $(selector + ' input#ct_field' + fieldIndex + '_' + 'default_value').val();
		fieldObject.require			= $(selector + ' select#ct_field' + fieldIndex + '_' + 'require option:selected').val();
		fieldObject.is_unique		= $(selector + ' input#ct_field' + fieldIndex + '_' + 'is_unique').val();
		
		$.ajax({
			type: "POST",
			url: "ajax.php?ajax=1&ctl=ct_type&action=Ajax_check_ct_field",
			dataType: "json",
			data: { ct_fieldJson: JSON.stringify( fieldObject ) },
			
			beforeSend: function() {
				showLoading("#ct_type_field" + fieldIndex);
				$("#ct_type_field" + fieldIndex + " .controls").css('background','#FF9');
			},
			
			success: function ( data ){
				if( data.status == 'ok' )
				{
					$("#ct_type_field" + fieldIndex + " .controls").css('background','rgb(200,241,182)');
					$("#ct_type_field" + fieldIndex + " .vnp-check").html('<span class="label label-success">' + data.msg + '</span>');
				}
				else if( data.status == 'no' )
				{
					$("#ct_type_field" + fieldIndex + " .controls").css('background','rgb(250,211,208)');
					$("#ct_type_field" + fieldIndex + " .vnp-check").html('<span class="label label-important">' + data.msg + '</span>');
				}
				hideLoading("#ct_type_field" + fieldIndex);
				fieldIndex++;
				check_ct_fields( fieldIndex );
			}
		});
	}
}

function showLoading( selector )
{	
	var selectorWidth	= $(selector).width(),
		selectorHeight	= $(selector).height(),
		left			= parseInt( $(selector).width() / 2 - 40 ),
		top				= parseInt( $(selector).height() / 2 + 40 );
		
	var overlay = '<div class="loading-indicator-overlay" style="width: ' + selectorWidth + 'px; height: ' + selectorHeight + 'px; margin-top: -' + selectorHeight + 'px; position: absolute; z-index: 5000"></div>';
	
	var loading = '<div id="loading-indicator-activity_pane" class="loading-indicator" style="position: absolute; z-index: 5001; margin-left: ' + left + 'px; margin-top: -' + top + 'px;"></div>';
	
	$(selector).append(overlay);
	$(selector).append(loading);
}

function hideLoading( selector )
{
	$(selector + ' .loading-indicator-overlay').remove();
	$(selector + ' #loading-indicator-activity_pane').remove();
}