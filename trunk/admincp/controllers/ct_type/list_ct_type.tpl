<!-- BEGIN: main -->
<!-- BEGIN: choose_ct_type -->
<table width="100%" class="table table-bordered">
    <tbody>
        <tr>
            <td width="78%"><strong>Loại nội dung</strong></td>
        </tr>
        <!-- BEGIN: loop -->
        <tr>
            <td>
            	<a class="vnp-ajax" href="{action_link}list_ct_type&ct_type={TYPE.content_type_name}"><strong>{TYPE.content_type_title}</strong></a>
                <a class="del-ct_type fr" id="{TYPE.content_type_name}" href="javascript:void(0);"><i class="color-icons delete_co"></i></a>
                <a class="vnp-ajax fr" href="{action_link}edit_ct_type&ct_type={TYPE.content_type_name}"><i class="color-icons application_edit_co"></i></a>
                <a class="vnp-ajax fr" href="{action_link}list_ct_type&ct_type={TYPE.content_type_name}"><i class="color-icons add_co"></i></a>
            </td>
       	</tr>
        <!-- END: loop -->
    </tbody>
</table>
<!-- END: choose_ct_type -->
<script type="text/javascript">
$(document).ready(function() {
    $('.del-ct_type').click(function() {
		obj = $(this);
        $.ajax({
			type: "POST",
			url: "ajax.php?ajax=1&ctl=ct_type&action=Ajax_delete_ct_type",
			dataType: "json",
			data: { ct_type: obj.attr('id') },
			
			beforeSend: function() {
				showLoading(".row-fluid");
			},
			
			success: function ( data ){
				if( data.status == 'ok' )
				{
					$('.row-fluid').html(data.content);
				}
				else
				{
					alert(data.content);
				}
				hideLoading(".row-fluid");
			}
		});
    });
});
</script>
<!-- END: main -->