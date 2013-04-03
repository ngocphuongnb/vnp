/**
 * @Project VNP Ajax
 * @Author Nguyen Ngoc Phuong
 * @Copyright (C) 2013 Nguyen Ngoc Phuong. All rights reserved
 * @Createdate  27/02/2013, 18:31
 */

//////////////// Ajax link ///////////////////////
var init = true, 
	state = window.history.pushState !== undefined;
	
var handler = function(data)
{
	if( data.title != '' || data.title != null )
	{
		$('title').html( data.title );
	}
	$('#vnpContainer #content-ctner').html( data.content );
	
	//if( data.hook != '' || data.hook != null )
	if(1);
	{
		var hook = new Object();
		hook = data.hook;
		document.getElementById('hook-header').innerHTML = hook.header;
		/*
		var script   = document.createElement("script");
		script.type  = "text/javascript";
		script.src   = hook.header;    // use this for linked script
		script.text  = ''               // use this for inline script
		document.head.appendChild(script);
		*/
		$('#hook-header').append( hook.header );
		$('#vnpContainer #content-hook').html( hook.content );
		//alert( hook.content + '------' + hook.header );
	}
};

$.address.state(docState).init(function() {
	$('a.vnp-ajax').address();		
}).change(function(event) {
	$('a.vnp-ajax').each(function()
	{
		if ($(this).attr('href') == ($.address.state() + event.path))
		{
		}
		else
		{
		}
	});
	if(!state)
	{
		init = false;
	}
	else
	{
		if( $.address.queryString() )
		{
			$.ajax({
				type: "POST",
				url: 'ajax.php?ajax=1&' + $.address.queryString(),
				dataType: "json",					
				beforeSend: function() {			
					showLoading("#vnpContainer #content-ctner");
				},
				error: function( XMLHttpRequest, textStatus, errorThrown )
				{
					handler(XMLHttpRequest.responseText);
				},
				success: function(data, textStatus, XMLHttpRequest) {
					handler( data );
					hideLoading("#vnpContainer #content-ctner");
				}
			});
		}
	}

});

if(!state)
{
	showLoading("#vnpContainer #content-ctner");
}