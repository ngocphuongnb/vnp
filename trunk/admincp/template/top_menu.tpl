<!-- BEGIN: main -->
<ul class="nav">           
    <!-- BEGIN: loop -->
    <li class="vnp-dropdown">
        <a href="{LINK_DATA.href}" class="dropdown-toggle vnp-ajax" data-toggle="dropdown">
            <i class="nav-icon cup"></i> {LINK_DATA.anchor} <b class="caret"></b>
        </a>
        <!-- BEGIN: sub -->
        <ul class="dropdown-menu">
            <!-- BEGIN: loop -->
            <!-- BEGIN: main -->
            <li><a class="vnp-ajax" href="{SUB_DATA.href}"> {SUB_DATA.anchor} </a></li>
            <!-- END: main -->
            {BREAK}
            <!-- END: loop -->
        </ul>
        <!-- END: sub -->
    </li>
    <!-- END: loop -->            
    <!-- BEGIN: customloop -->
    <li class="vnp-dropdown">{CUSTOM}</li>
    <!-- END: customloop -->
</ul>
<!-- END: main -->