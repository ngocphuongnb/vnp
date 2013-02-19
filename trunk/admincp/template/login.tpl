<!-- BEGIN: main -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Install VNP CMS</title>
<link rel="stylesheet" href="{MY_DOMAIN}{MY_DIR}sources/static/css/global.css" type="text/css" media="screen" />
<link rel="stylesheet" href="{MY_DOMAIN}{MY_DIR}{ADMIN_DIR}/template/css/admin.css" type="text/css" media="screen" />
</head>

<body>
<div class="admin-login">
	<form action="" method="post">
    <table>
        <caption>Đăng nhập Admin</caption>
        <tbody>
          <tr>
            <td colspan="2">
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
            <th>Tên đăng nhập</th>
            <td><input type="text" name="username" /></td>
          </tr>
          <tr>
            <th>Mật khẩu</th>
            <td><input type="text" name="password" /></td>
          </tr>
          <tr>
            <td colspan="2"><center><input type="submit" name="admin-login" value="Đăng nhập" /></center></td>
          </tr>
        </tbody>
      </table>
	</form>
</div>
</body>
</html>
<!-- END: main -->