<!-- BEGIN: main -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Install VNP CMS</title>
<link rel="stylesheet" href="{MY_DOMAIN}{MY_DIR}sources/static/css/global.css" type="text/css" media="screen" />
<link rel="stylesheet" href="{MY_DOMAIN}{MY_DIR}{INSTALL_DIR}/template/install.css" type="text/css" media="screen" />
</head>

<body>
<div class="vnp-main">
  <table>
    <caption>Cài đặt VNP CMS</caption>
    <tbody>
      <tr>
        <th class="menu">Row 1a</th>
        <td rowspan="6">
        	<!-- BEGIN: error -->
        	<div class="ins-error">
            	<u>Error: </u><br />
                <!-- BEGIN: loop -->
                <span>+ {ERR}</span>
                <!-- END: loop -->
            </div>
            <!-- END: error -->
        	{CONTENT}           	
        </td>
      </tr>
      <tr>
        <th>Row 1b</th>
      </tr>
      <tr>
        <th>Row 1c</th>
      </tr>
      <tr>
        <th>Row 1d</th>
      </tr>
      <tr>
        <th>Row 1e</th>
      </tr>
      <tr>
        <th>Row 1f</th>
      </tr>
    </tbody>
  </table>
</div>
</body>
</html>
<!-- END: main -->