 <!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->
      <!--sidebar start-->
 <? if(false){ ?>
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->

				<ul class="sidebar-menu" id="nav-accordion">
					<p class="centered"><a href="profile.html"></a></p>
					<h5 class="centered">Marcel Newman</h5>
					
					{foreach="$menu as $key => $value"}
					
						{if="$value.hasSub"}
						
							<li class="sub-menu">
								<a href="#" {if="$value.selected"}class="active"{/if}>
									<i class="{$value.icon} fa"></i><span>{$value.name}</span>
								</a>
								
								<ul class="sub">
									{foreach="$value.submenu as $k => $v"}
									
										<li {if="$v.selected"} class="active"{/if}><a href="{$v.link}">{$v.name}</a></li>
										
									{/foreach}
								</ul>	
								
							</li>
							
						{else}
							
							<li class="mt">
								<a href="{$value.link}" {if="$value.selected"} class="active"{/if}><i class="{$value.icon} fa"></i><span>{$value.name}</span></a>
								<!--<div class="arrow"></div>-->
							</li>					
							
						{/else}

					{/foreach}
				
              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->
<?}?>

 <nav class="navbar navbar-default">
     <div class="container-fluid">
         <!-- Brand and toggle get grouped for better mobile display -->
         <div class="navbar-header">
             <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                 <span class="sr-only">Toggle navigation</span>
                 <span class="icon-bar"></span>
                 <span class="icon-bar"></span>
                 <span class="icon-bar"></span>
             </button>
             <a class="navbar-brand" href="/"><img src="/static/default/img/logo_old.png" style="margin-top: -13px;"/> </a>
         </div>

         <!-- Collect the nav links, forms, and other content for toggling -->
         <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
             <ul class="nav navbar-nav">
                 {foreach="$menu as $key => $value"}

                     {if="$value.hasSub"}

                     <li class="dropdown {if="$value.selected"}active{/if}">
                         <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{$value.name} <span class="caret"></span></a>
                         <ul class="dropdown-menu" role="menu">
                             {foreach="$value.submenu as $k => $v"}

                                 <li {if="$v.selected"} class="active"{/if}><a href="{$v.link}">{$v.name}</a></li>

                             {/foreach}
                         </ul>
                     </li>

                     {else}

                     <li>
                         <a href="{$value.link}" {if="$value.selected"} class="active"{/if}><span>{$value.name}</span></a>
                         <!--<div class="arrow"></div>-->
                     </li>

                 {/else}

                 {/foreach}

             </ul>
             <ul class="nav navbar-nav navbar-right">
                 <li><a href="/admin/logout">Log Out</a></li>
             </ul>
         </div><!-- /.navbar-collapse -->
     </div><!-- /.container-fluid -->
 </nav>
      