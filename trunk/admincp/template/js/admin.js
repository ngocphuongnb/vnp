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
			//state = true;
		}
		else
		{
			if( event.path === '/' || event.path == 'index.php/' )
			{
				state = false;
			}
			else
			{
				state = true;
			}
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
			/*
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
			*/
			
			var callbackFuncs = new Array();
			callbackFuncs[0] = 'handler( data )';
			callbackFuncs[1] = 'hideLoading("#vnpContainer #content-ctner")';
			opts = {
				type:			'POST',
				url:			'ajax.php?ajax=1&' + $.address.queryString(),
				dataType:		'json',
				resultCtner:	'',
				callback:		callbackFuncs,
				autoRetry:		false,
				beforeSend:		'showLoading("#vnpContainer #content-ctner")',
				hook:			{
									header: 1,
									content: 1,
									footer: 1
								}
			}
			vnpAjax( opts );
			$("#jMenu").jMenu({ulWidth : '150px'});
		}
		else
		{
			vnpNoty( 'Bad request...', 'error' );
		}
	}

});

if(!state)
{
	showLoading("#vnpContainer #content-ctner");
}

/*
	hook:
			0: keep current hook,
			1: replace current hook by new
			2: clear current hook
			3: append current hook with new
*/
var opts = {
	type:			'POST',
	url:			'ajax1.php',
	dataType:		'string',
	resultCtner:	'',
	callback:		'',
	autoRetry:		false,
	beforeSend:		null,
	hook:			{
						header: 0,
						content: 0,
						footer: 0
					}
}

function objToString (obj) {
    var str = '';
    for (var p in obj) {
        if (obj.hasOwnProperty(p)) {
            str += p + '::' + obj[p] + '\n';
        }
    }
    return str;
}

function delay(time)
{
	var d1 = new Date();
	var d2 = new Date();
	while (d2.valueOf() < d1.valueOf() + time)
	{
		d2 = new Date();
	}
}

function get()
{
	var opts = {
		type:			'POST',
		url:			'http://tetua.net/',
		dataType:		'text',
		resultCtner:	'',
		callback:		'',
		autoRetry:		true,
		beforeSend:		null,
		hook:			{
							header: 0,
							content: 0,
							footer: 0
						}
	}
	data = null;
	vnpAjax( opts, data );
}

function vnpAjax( opts, dataObj, i )
{
	if( i == null || i < 0 || typeof i === 'undefined' ) i = 0;
	if( typeof dataObj == 'undefined' ) dataObj = '';
	$.ajax({
		type: opts.type,
		url: opts.url,
		data: dataObj,
		dataType: opts.dataType,					
		beforeSend: function() {
			if( $.isArray(opts.beforeSend) )
			{
				for( i = 0; i < opts.beforeSend.length; i++ )
				{
					if( typeof opts.beforeSend[i] === 'string' && opts.beforeSend[i] !== '' )
					{
						eval(opts.beforeSend[i]);
					}
				}
			}
			else if( typeof opts.beforeSend === 'string' && opts.beforeSend !== '' )
			{
				eval(opts.beforeSend);
			}
		},
		error: function( XMLHttpRequest, textStatus, errorThrown )
		{
			vnpNoty( textStatus + ' ' + errorThrown, 'error' );
			if( opts.autoRetry == true && i <= 3 )
			{
				//vnpNoty( 'Retrying...', 'info' );
				if( i == 0 )
				{
					vnpAjax( opts, dataObj, 1 );
				}
				else
				{
					i++;
					vnpAjax( opts, dataObj, i );
				}
			}
			//handler(XMLHttpRequest.responseText);
		},
		success: function(data, textStatus, XMLHttpRequest) {
			vnpNoty( textStatus, 'success' );
			if( opts.callback )
			{
				if( $.isArray(opts.callback) )
				{
					for( i = 0; i < opts.callback.length; i++ )
					{
						if( typeof opts.callback[i] === 'string' && opts.callback[i] !== '' )
						{
							eval( opts.callback[i] );
						}
					}
				}
				else if( typeof opts.callback === 'string' && opts.callback !== '' )
				{
					eval( opts.callback );
				}
			}
		},
		statusCode: {
			404: function() {
      			alert("page not found");
    		}
		}
	});
}

function popups()
{
	s = vnpPopup('Bạn có chắc chắn không?', 'confirm');
}