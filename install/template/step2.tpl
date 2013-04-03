<!-- BEGIN: main -->
<form method="post">
    <table>
    	<caption>Database Setting</caption>
        <tbody>
        	<tr>
            	<th>Database Type</th>
                <td>
                	<select name="dbtype">
                    	<option value="mysql">MYSQL</option>
                        <option value="mysqli">MYSQLI</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Host</th>
                <td><input class="label" type="text" name="host" value="localhost" /><span class="note">Nhập tên host ( thường là localhost )</span></td>
            </tr>
            <tr>
                <th>Database name</th>
                <td><input class="label" type="text" name="dbname" value="{DATA.dbname}" /><span class="note">Tên cơ sở dữ liệu</span></td>
            </tr>
            <tr>
                <th>Database Username</th>
                <td><input class="label" type="text" name="dbuname" value="root" autocomplete="off" /><span class="note">Tài khoản CSDL</span></td>
            </tr>
            <tr>
                <th>Database Password</th>
                <td><input class="label" type="password" name="dbpass" value="123" autocomplete="off" /><span class="note">Mật khẩu CSDL</span></td>
            </tr>
            <tr>
                <th>Database RePassword</th>
                <td><input class="label" type="password" name="redbpass" autocomplete="off" /><span class="note">Nhập lại mật khẩu</span></td>
            </tr>
            <tr>
                <th>Database Prefix</th>
                <td><input class="label" type="text" name="dbprefix" value="{DATA.dbprefix}" /><span class="note">Tiền tố CSDL</span></td>
            </tr>
            <!-- BEGIN: deltable -->
            <tr>
                <td colspan="2">
                	<input type="checkbox" name="deltable" value="1" />
                    <span class="note">Tồn tại bảng CSDL có cùng tiền tố, xóa các bảng tồn tại?</span>
                </td>
            </tr>
            <!-- END: deltable -->
            <tr>
                <td colspan="2"><center><input type="button" onclick="history.back();" name="back" value="Back" /><input type="submit" name="next" value="Next" /></center></td>
            </tr>
        </tbody>
    </table>
</form> 
<!-- END: main -->