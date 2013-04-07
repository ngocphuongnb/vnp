<!-- BEGIN: main -->
<ul class="nav" id="jMenu">           
    <!-- BEGIN: loop -->
    <li>
        <a href="{LINK_DATA.href}" class="fNiv vnp-ajax">
            {LINK_DATA.anchor}
        </a>
        <!-- BEGIN: sub -->
        <ul class="dropdown-menu">
            <!-- BEGIN: loop -->
            <!-- BEGIN: main -->
            <li><a class="vnp-ajax" href="{SUB_DATA.href}"><i class="icon-tag icon-white"></i> {SUB_DATA.anchor} </a></li>
            <!-- END: main -->
            {BREAK}
            <!-- END: loop -->
        </ul>
        <!-- END: sub -->
    </li>
    <!-- END: loop -->            
    <!-- BEGIN: customloop -->
    <li>{CUSTOM}</li>
    <!-- END: customloop -->
</ul>
<script type="text/javascript">
$(document).ready(function(){
	$("#jMenu").jMenu({
		ulWidth : '150px',
		effects : {
			effectSpeedOpen : 200,
			effectSpeedClose : 200,
			effectTypeOpen : 'slide',
			effectTypeClose : 'slide',
			effectOpen : 'linear',
			effectClose : 'linear'
		},
		TimeBeforeOpening : 100,
		TimeBeforeClosing : 100,
		animatedText : false,
		paddingLeft: 1		});
})
</script>

<!-- END: main -->