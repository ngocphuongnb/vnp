<!-- BEGIN: main -->
<div class="navbar-inner top-nav">
	<div class="container-fluid">
		<button data-target=".nav-collapse" data-toggle="collapse" class="btn btn-navbar" type="button">
			<span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
		<div class="nav-collapse collapse">
        	<ul class="nav">
            	<li class="dropdown search-responsive">
                	<a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    	<i class="nav-icon magnifying_glass"></i>
                    	<b class="caret"></b>
                    </a>
          			<ul class="dropdown-menu">
            			<li class="top-search">
              				<form action="#" method="get">
                				<div class="input-prepend">
                                	<span class="add-on"><i class="icon-search"></i></span>
                  					<input type="text" id="searchIcon">
                				</div>
              				</form>
            			</li>
          			</ul>
				</li>
                
                <!-- BEGIN: loop -->
                <li class="dropdown">
                	<a href="{LINK_DATA.href}" class="dropdown-toggle" data-toggle="dropdown">
                    	<i class="nav-icon cup"></i> {LINK_DATA.anchor} <b class="caret"></b>
                    </a>
                    <!-- BEGIN: sub -->
            		<ul class="dropdown-menu">
                    	<!-- BEGIN: loop -->
                        <!-- BEGIN: main -->
              			<li><a href="{SUB_DATA.href}"> {SUB_DATA.anchor} </a></li>
                        <!-- END: main -->
                        {BREAK}
                        <!-- END: loop -->
            		</ul>
                    <!-- END: sub -->
          		</li>
                <!-- END: loop -->
                
                <!-- BEGIN: customloop -->
                <li class="dropdown">{CUSTOM}</li>
                <!-- END: customloop -->
                
				<li class="dropdown">
                	<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="nav-icon cog_3"></i>
                    	Themes Settings<b class="caret"></b>
                    </a>
            		<ul class="dropdown-menu">
              			<li class="nav-header">Colors</li>
              			<li class=" clearfix color-block">
                        	<span class="theme-color theme-blue" title="theme-blue"></span>
                            <span class="theme-color theme-light-blue" title="theme-light-blue"></span>
                            <span class="theme-color theme-dark" title="theme-dark"></span>
                            <span class="theme-color theme-chrome" title="theme-chrome"></span>
                            <span class="theme-color theme-chayam" title="theme-chayam"></span>
                            <span class="theme-color theme-default" title="theme-default"></span>
						</li>
              			<li class=" divider hidden-phone hidden-tablet"></li>
              			<li class="nav-header hidden-phone hidden-tablet">Sidebar</li>
                        <li class="theme-settings clearfix hidden-phone hidden-tablet">
                            <div class="btn-group">
                              <button id="sidebar-on" disabled="disabled" class="btn btn-success">On</button>
                              <button id="sidebar-off" class="btn btn-inverse">Off</button>
                            </div>
                        </li>
                        <li class=" divider"></li>
                        <li class="nav-header hidden-phone hidden-tablet">Sidebar Placement</li>
                        <li class="theme-settings clearfix hidden-phone hidden-tablet">
                            <div class="btn-group">
                              <button disabled="disabled" id="left-sidebar" class="btn btn-inverse">Left</button>
                              <button id="right-sidebar" class="btn btn-info">Right</button>
                            </div>
                        </li>
              			<li class="nav-header">Layout</li>
            		</ul>
          		</li>
			</ul>
		</div>
	</div>
</div>
<!-- END: main -->
