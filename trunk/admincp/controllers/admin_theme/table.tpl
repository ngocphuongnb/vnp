<!-- BEGIN: main -->
<div class="span12">
	<div class="widget-block">
		<div class="widget-head">
			<h5>{LABEL}</h5>
			<div class="widget-control pull-right">
				<a href="#" data-toggle="dropdown" class="btn dropdown-toggle">
                	<i class="icon-cog"></i><b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <!-- BEGIN: menu -->
                    <li><a href="{MENU.href}" title="{MENU.title}"><i class="{MENU.class}"></i> {MENU.anchor}</a></li>
                     <!-- END: menu -->
                </ul>
			</div>
		</div>
		<div class="widget-content">
			<div class="widget-box">
                <table class="data-tbl-boxy table table-bordered">
                    <thead>
                        <tr>
                            <!-- BEGIN: thead -->
                            <th> {THEAD} </th>
                            <!-- END: thead -->
                        </tr>
                    </thead>
                    <tbody>
                    	<!-- BEGIN: row -->
                        <tr>
                        	<!-- BEGIN: col -->
                            <td> {COL} </td>
                            <!-- END: col -->
                        </tr>
                        <!-- END: row -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="{MY_DIR}sources/static/js/data-table.jquery.js"></script>
<script src="{MY_DIR}sources/static/js/TableTools.min.js"></script>
<script src="{MY_DIR}sources/static/js/ColVis.min.js"></script>
<script type="text/javascript">
$(function () {
	$('.data-tbl-boxy').dataTable({
		"sPaginationType": "full_numbers",
		"iDisplayLength": 10,
		"oLanguage": {
			"sLengthMenu": "<span class='lenghtMenu'> _MENU_</span><span class='lengthLabel'>Entries per page:</span>",
		},
		"sDom": '<"tbl-searchbox clearfix"fl<"clear">>,<"table_content"t>,<"widget-bottom"p<"clear">>'
 
	});
	$("div.tbl-searchbox select").addClass('input-small');	 
});
</script>
<style>
table.data-tbl-boxy tr.odd {
	background-color: #f9f9f9;
}
</style>
<!-- END: main -->