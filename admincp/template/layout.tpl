<!-- BEGIN: main -->
<!DOCTYPE HTML>
<html lang="vi">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8">
    <title>VNP Admin Area</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Admin Panel Template">
    <meta name="author" content="Westilian: Kamrujaman Shohel">
    <!-- styles -->
    <link href="{MY_DIR}{ADMIN_DIR}/template/css/bootstrap.css" rel="stylesheet">
    <link href="{MY_DIR}{ADMIN_DIR}/template/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="{MY_DIR}{ADMIN_DIR}/template/css/styles.css" rel="stylesheet">
    <link href="{MY_DIR}{ADMIN_DIR}/template/css/themes.css" rel="stylesheet">
    <link href="{MY_DIR}{ADMIN_DIR}/template/css/icons-sprite.css" rel="stylesheet">
    <link href="{MY_DIR}sources/static/css/custom.css" rel="stylesheet">
    <!--[if IE 7]>
    <link rel="stylesheet" type="text/css" href="{MY_DIR}{ADMIN_DIR}/template/css/ie/ie7.css" />
    <![endif]-->
    <!--[if IE 8]>
    <link rel="stylesheet" type="text/css" href="{MY_DIR}{ADMIN_DIR}/template/css/ie/ie8.css" />
    <![endif]-->
    <!--[if IE 9]>
    <link rel="stylesheet" type="text/css" href="{MY_DIR}{ADMIN_DIR}/template/css/ie/ie9.css" />
    <![endif]-->
    <!--fav and touch icons -->
    <link rel="shortcut icon" href="ico/favicon.ico">
    
    <script src="{MY_DIR}sources/static/js/jquery.js"></script>
    <script src="{MY_DIR}sources/static/js/jquery.address-1.5.min.js"></script>
    <script src="{MY_DIR}sources/static/js/vnp-ajax.js"></script>
</head>
<body>
 
<!--BODY HERE-->

<div class="navbar navbar-fixed-top">
    <!--Top fixed nav here-->
    {TOP_MENU}
</div>
 
<div id="sidebar">
    {SIDE_BAR}
</div>
 
<div id="main-content">
    <div class="container-fluid">
        <ul class="breadcrumb">
            <li><a href="#">Home</a><span class="divider">»</span></li>
            <li><a href="#">Library</a><span class="divider">»</span></li>
            <li class="active">Data</li>
        </ul>
        <!--Page content here-->
        <div class="row-fluid">
            {CONTENT}
        </div>
    </div>
</div>


<!-- javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="{MY_DIR}sources/static/js/bootstrap.js"></script>
<script src="{MY_DIR}sources/static/js/inputmask.jquery.js"></script>
<script src="{MY_DIR}sources/static/js/jquery-ui-1.8.16.custom.min.js"></script>
<script src="{MY_DIR}sources/static/js/uniform.jquery.js"></script>
<script src="{MY_DIR}sources/static/js/smart-wizard.jquery.js"></script>
<script src="{MY_DIR}sources/static/js/data-table.jquery.js"></script>
<script src="{MY_DIR}sources/static/js/TableTools.min.js"></script>
<script src="{MY_DIR}sources/static/js/ColVis.min.js"></script>
<!--
<script src="{MY_DIR}sources/static/js/jquery.animate-colors-min.js"></script>
-->
<script type="text/javascript">
$(function () {
$("#date").mask("99/99/9999");
	$("#phone").mask("(999) 999-9999");
	$("#mobile").mask("(999) 999-9999");
	$("#tin").mask("99-9999999");
	$("#ssn").mask("999-99-9999");	

/*==Tooltip==*/
    $('.text-tip').tooltip({
        placement: 'top'
    });
	 $('.tip-top').tooltip({
        placement: 'top'
    });
	 $('.tip-bot').tooltip({
        placement: 'bottom'
    });
	 $('.tip-left').tooltip({
        placement: 'left'
    });
	 $('.tip-right').tooltip({
        placement: 'right'
    });
	/*==Date Picker==*/
    $('#datepicker').datepicker();
	/*==JQUERY UNIFORM==*/
	$(".checkbox-b,.rem_me,.radio-b,input[type='file']").uniform();
})
</script>

<script type="text/javascript">
	var init = true, 
		state = window.history.pushState !== undefined;
	
	// Handles response
	var handler = function(data)
	{
		$('title').html( data.title );
		$('#main-content .container-fluid .row-fluid').html( data.content );
		//$('.page').show();
		//$.address.title(/>([^<]*)<\/title/.exec(data)[1]);
	};
	
	$.address.state('{MY_DIR}{ADMIN_DIR}').init(function() {

		// Initializes the plugin
		$('.navbar .nav .vnp-dropdown a').address();
		
	}).change(function(event) {

		// Selects the proper navigation link
		$('.navbar .nav .vnp-dropdown a').each(function()
		{
			if ($(this).attr('href') == ($.address.state() + event.path))
			{
				//$(this).addClass('selected').focus();
			}
			else
			{
				//$(this).removeClass('selected');
			}
		});
		
		//if (state && init)
		if(0)
		{
			init = false;
		}
		else
		{
			//alert('ajax.php?ajax=1&' + $.address.queryString());
			$.ajax({
				type: "POST",
				url: 'ajax.php?ajax=1&' + $.address.queryString(),
				dataType: "json",					
				beforeSend: function() {			
					showLoading("#main-content .container-fluid .row-fluid");
				},
				error: function( XMLHttpRequest, textStatus, errorThrown )
				{
					handler(XMLHttpRequest.responseText);
				},
				success: function(data, textStatus, XMLHttpRequest) {
					handler( data );
					hideLoading("#main-content .container-fluid .row-fluid");
				}
			});
		}

	});

	if(!state)
	{
		// Hides the page during initialization
		showLoading("#main-content .container-fluid .row-fluid");
	}
</script>

<!-- html5.js for IE less than 9 -->
<!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!-- css3-mediaqueries.js for IE less than 9 -->
<!--[if lt IE 9]>
    <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->
</body>
</html>
<!-- END: main -->