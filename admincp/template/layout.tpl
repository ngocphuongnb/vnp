<!-- BEGIN: main -->
<!doctype html>
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="">
<!--<![endif]-->
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>VNP layout</title>
<link href="{MY_DIR}sources/static/css/global.css" rel="stylesheet" type="text/css">
<link href="{MY_ADMDIR}template/css/boilerplate.css" rel="stylesheet" type="text/css">
<link href="{MY_ADMDIR}template/css/button.css" rel="stylesheet" type="text/css">
<link href="{MY_ADMDIR}template/css/icons.css" rel="stylesheet" type="text/css">
<link href="{MY_ADMDIR}template/css/admin.css" rel="stylesheet" type="text/css">
<link href="{MY_ADMDIR}template/css/style.css" rel="stylesheet" type="text/css">
<!--[if lt IE 9]>
<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script src="{MY_ADMDIR}template/js/respond.min.js"></script>
<script src="{MY_DIR}sources/static/js/jquery.js"></script>
<script src="{MY_DIR}sources/static/js/jquery-ui.min.js"></script>
<script src="{MY_DIR}sources/static/js/jquery.address-1.5.min.js"></script>
<script src="{MY_DIR}sources/static/js/vnp-ajax.js"></script>
<script src="{MY_DIR}sources/static/js/jquery.noty.js"></script>
<script src="{MY_DIR}sources/static/js/jMenu.jquery.js"></script>
</head>
<body>
<div id="hook-header">
{HOOK.header}
</div>
<div class="vnpMainBody clearfix">
	<div id="vnpContainer">
    	<div class="topMenu" id="topMenu">
        	<div id="topMenu-ctner">
        		{TOP_MENU}
            </div>
            <div id="topMenu-hook">
            	{HOOK.topmenu}
            </div>
        </div>
        <div class="sideBar" id="sideBar">
        	<div id="sideBar-ctner">
        		{SIDE_BAR}
            </div>
            <div id="sideBar-hook">
            	{HOOK.sidebar}
            </div>
        </div>
        <div class="mainContent" id="mainContent">
        	<div id="content-ctner">
        		{CONTENT}
                <button onClick="get();">Click</button>
            </div>
            <div id="content-hook">
            	{HOOK.content}
            </div>
        </div>
    </div>
</div>
<div id="hook-footer">
	{HOOK.footer}
</div>
<script type="text/javascript">
	var docState = "{MY_DIR}{ADMIN_DIR}";
</script>
<script src="{MY_ADMDIR}template/js/admin.js"></script>
</body>
</html>
<!-- END: main -->