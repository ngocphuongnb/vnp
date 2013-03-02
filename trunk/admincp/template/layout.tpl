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
<script src="{MY_DIR}sources/static/js/jquery.js"></script>
<script src="{MY_DIR}sources/static/js/bootstrap.js"></script>
<script src="{MY_DIR}sources/static/js/inputmask.jquery.js"></script>
<script src="{MY_DIR}sources/static/js/jquery-ui-1.8.16.custom.min.js"></script>
<script src="{MY_DIR}sources/static/js/uniform.jquery.js"></script>
<script src="{MY_DIR}sources/static/js/vnp-extenable-form.jquery.js"></script>
<script src="{MY_DIR}sources/static/js/smart-wizard.jquery.js"></script>
<script src="{MY_DIR}sources/static/js/vnp-ajax.js"></script>

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
	
	$('#ext-form').extForm();
	
	$(function () {
		// Smart Wizard 	
		$('#add-ct_type-wizard').smartWizard({
			enableFinishButton: false,
			onFinish: onFinishCallback
		});
	 
		function onFinishCallback() {
			$('#add-ct_type-wizard').smartWizard('showMessage', 'Finish Clicked');
			$('#ct_type-submit').click();
		}
		$('#vertical-wizard').smartWizard();
	});
})
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