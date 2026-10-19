{if $message eq 'NotPermission' or $message eq 'notPermission'}
<div id="message">
	<span class="updated">{$core->get_Lang('adminnotallowaccess')}</span>
</div>
{/if}
{if $message eq 'insertSuccess'}
<div id="message" class="add">
	<span><img align="absmiddle" src="{$URL_IMAGES}/icon_admin/add.png" width="32px" />{$core->get_Lang('addnewsuccess')}</span>
</div>
{/if}
{if $message eq 'RestoreSuccess'}
<div id="message" class="restore">
	<span><img align="absmiddle" src="{$URL_IMAGES}/icon_admin/TimeMachine.png" width="32px" />{$core->get_Lang('restoringsuccess')}</span>
</div>
{/if}
{if $message eq 'updateSuccess' or $message eq 'UpdateSuccess'}
<div id="message" class="update">
	<span><img src="{$URL_IMAGES}/icon_admin/iSync.png" width="32px" />{$core->get_Lang('updatesuccessful')}</span>
</div>
{/if}
{if $message eq 'TrashSuccess'}
<div id="message" class="trash">
	<span><img align="absmiddle" src="{$URL_IMAGES}/icon_admin/Trash-Full.png" width="32px" />{$core->get_Lang('movedtotrash')}</span>
</div>
{/if}
{if $message eq 'titleHasExisted'}
<div id="message" class="del">
	<span><img src="{$URL_IMAGES}/icon_admin/Del.png" width="32px" />{$core->get_Lang('Title has Existed')}</span>
</div>
{/if}
{if $message eq 'keyExist'}
	<div id="message" class="del">
		<span><img src="{$URL_IMAGES}/icon_admin/Del.png" width="32px" />{$core->get_Lang('Key has Existed')}</span>
	</div>
{/if}
{if $message eq 'DeleteSuccess'}
<div id="message" class="del">
	<span><img src="{$URL_IMAGES}/icon_admin/Del.png" width="32px" />{$core->get_Lang('deletesuccess')}</span>
</div>
{/if}
{if $message eq 'invalidAccess'}
<div id="message" class="del">
	<span><img src="{$URL_IMAGES}/icon_admin/Lock.png" width="32px" />{$core->get_Lang('youdonothavepermission')}</span>
</div>
{/if}
{if $message eq 'PositionSuccess'}
<div id="message" class="pos">
	<span><img align="absmiddle" src="{$URL_IMAGES}/icon_admin/Pos.png" width="32px" />{$core->get_Lang('positionhasbeenchanged')}</span>
</div>
{/if}
<header id="header" class="header">
	<div class="logo" id="logo">
		<a href="{$PCMS_URL}" title="{$PAGE_NAME}">
			<img height="43px" src="{$URL_IMAGES}/logo_vietisonew.png" alt="{$PAGE_NAME}" />
		</a>
	</div>
	<a href="javascript:void(0);" class="sidebar-collapse-click" id="sidebar-collapse-click">
		<i class="fa fa-bars" aria-hidden="true"></i>
	</a>

	<form class="iso-shell-search" role="search" aria-label="Quick admin navigation">
		<i class="fa fa-search" aria-hidden="true"></i>
		<input type="search" autocomplete="off" placeholder="Search tours, hotels, news, bookings..." aria-label="Global search" aria-expanded="false" aria-controls="isoGlobalSearchResults" />
		<kbd aria-hidden="true">&#8984; K</kbd>
		<div class="iso-shell-search__results" id="isoGlobalSearchResults" role="listbox" hidden></div>
	</form>
	<ul class="menu_header">
		<li><a href="{$PCMS_URL}">{$core->get_Lang('Dashboard')}</a></li>
		<li class="s">|</li>
		<li><a href="{$DOMAIN_NAME}{$extLang}" target="_blank">{$core->get_Lang('clientpage')}</a></li>
		<li class="s">|</li>
		<li><a class="ajManageSystemNote">{$core->get_Lang('notes')}</a></li>
		<li class="s">|</li>
		<li><a class="ClickSiteHelp hidden767" href="javascript:void(0);" mod_page="{$mod}" act_page="{$act}" area_page="">{$core->get_Lang('Help')}</a></li>
		<li class="s">|</li>
		<li><a target="_blank" href="{$DOMAIN_NAME}/inc/tech/sitemapvis.php?token={$clsISO->hashHmacIsoCms()}" >{$core->get_Lang('Sitemap')}</a></li>
	</ul>
	<span class="iso-shell-spacer" aria-hidden="true"></span>

	{if $mod eq 'home'}
	<div class="iso-shell-date" data-from-date="{$dashboard_from_date}" data-to-date="{$dashboard_to_date}">
		<button type="button" class="iso-shell-date__toggle" aria-expanded="false">
			<i class="fa fa-calendar" aria-hidden="true"></i><span></span><i class="fa fa-angle-down" aria-hidden="true"></i>
		</button>
		<div class="iso-shell-popover iso-shell-date__panel" hidden>
			<strong>Dashboard date range</strong>
			<p class="iso-shell-date__hint">Select at least 7 days, up to today.</p>
			<label>From<input type="text" name="iso_date_from" autocomplete="off" readonly /></label>
			<label>To<input type="text" name="iso_date_to" autocomplete="off" readonly /></label>
			<div class="iso-shell-date__error" role="alert" hidden></div>
			<div class="iso-shell-date__actions">
				<button type="button" data-range="week">Last 7 days</button>
				<button type="button" data-apply>Apply</button>
			</div>
		</div>
	</div>
	{/if}

	<div class="iso-shell-notifications">
		<button type="button" class="iso-shell-action" aria-label="Notifications" aria-expanded="false">
			<svg class="iso-shell-notifications__bell" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
				<path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"></path>
				<path d="M10 21h4"></path>
			</svg>
			<span class="iso-shell-notifications__badge" hidden></span>
		</button>
		<div class="iso-shell-popover iso-shell-notifications__panel" hidden>
			<div class="iso-shell-popover__head"><strong>Recent notifications</strong></div>
			<div class="iso-shell-notifications__list"><div class="iso-shell-empty">Loading bookings...</div></div>
		</div>
	</div>

	<div class="header_right">
		{assign var=listLang value=$clsISO->getListLangAdmin()}
		<div class="lang_menu dropdown">
			<a
				class="dropdown-toggle color_333"
				href="#"
				role="button"
				data-bs-toggle="dropdown"
				aria-expanded="false"
			>
				<i class="flag flag-20 flag-20-{$_LANG_ID}"></i>
				{$_LANG_ID}
				<i class="fa fa-angle-down" aria-hidden="true"></i>
			</a>

			{if $listLang|@count > 1}
			<ul class="dropdown-menu dropdown-menu-end">
				{section name=i loop=$listLang}
					{if $listLang[i] ne $_LANG_ID}
					<li>
						<a
							class="dropdown-item"
							title="{$listLang[i]}"
							href="{if $listLang[i] ne $LANG_DEFAULT|default:''}
								{$PCMS_URL}/index.php?lang={$listLang[i]}
							{else}
								{$DOMAIN_NAME}
							{/if}"
						>
							<i class="flag flag-20 flag-20-{$listLang[i]}"></i>
							{$clsISO->getFullLanguage($listLang[i])}
						</a>
					</li>
					{/if}
				{/section}
			</ul>
			{/if}
		</div>

		<div class="user_menu">
			<div class="user_right dropdown">
				<div class="user_name dropdown">
					<a
						class="dropdown-toggle color_333"
						href="#"
						role="button"
						data-bs-toggle="dropdown"
						aria-expanded="false"
					>
						<span>
							{$clsUser->getOneField('first_name',$_loged_id)}
							{$clsUser->getOneField('last_name',$_loged_id)}
						</span>
						<span class="ip">{$clsISO->getRealIP()}</span>
						<i class="fa fa-angle-down" aria-hidden="true"></i>
					</a>

					<ul class="dropdown-menu dropdown-menu-end">
						<li>
							<a
								class="dropdown-item"
								href="{$PCMS_URL}/index.php?mod=user&act=edit&user_id={$core->encryptID($core->_USER.user_id)}"
							>
								{$core->get_Lang('myacount')}
							</a>
						</li>
						<li>
							<a
								class="dropdown-item"
								href="{$PCMS_URL}/?mod=login&act=logout"
							>
								{$core->get_Lang('logout')}
							</a>
						</li>
					</ul>
				</div>

			</div>
		</div>
	</div>
</header>
{if $deviceType ne 'phone'}
	{literal}
	<script type="text/javascript">
		$(function(){
			var $ok = 1;
			if(mod == 'tour_exhautive'||mod == 'combo'||mod == 'hotel' || mod == 'cruise' || mod == 'blog' || mod == 'tour' || mod == 'property'){
				if(!$('#sidebar').hasClass('menu-min')){
					/*$('#sidebar').addClass('menu-min');
					$('#sidebar-collapse-click').addClass('closed');
					$.post(path_ajax_script+'/index.php?mod=home&act=ajOpenSidebar',{'val': 0},function(html){
						console.log(html);
					});*/
					$('#sidebar').removeClass('menu-min');
					$('#sidebar-collapse-click').removeClass('closed');
					$.post(path_ajax_script+'/index.php?mod=home&act=ajOpenSidebar',{'val': $ok},function(html){
						// console.log(html);
					});
				}
			}else{
				if($('#sidebar').hasClass('menu-min')){
					$('#sidebar').removeClass('menu-min');
					$('#sidebar-collapse-click').removeClass('closed');
					$.post(path_ajax_script+'/index.php?mod=home&act=ajOpenSidebar',{'val': $ok},function(html){
						// console.log(html);
					});
				}
			}
			$('#sidebar-collapse-click').click(function(ev){
				ev.preventDefault();
				var $_this = $(this),
					$_sidebar = $('#'+'sidebar');
				if(!$_sidebar.hasClass('menu-min')){
					$ok = 0;
					$_sidebar.addClass('menu-min');
					$_this.addClass('closed');
				}else{
					$ok = 1;
					$_sidebar.removeClass('menu-min');
					$_this.removeClass('closed');
				}
				$.post(path_ajax_script+'/index.php?mod=home&act=ajOpenSidebar',{
					'val': $ok
				}, function(html){
					// Some code
				});
				return false;
			});
			$(window).on('resize', function(){
				var _www = $(window).width(),
					_sidebar = $('#'+'sidebar');
				if(_www < 576){ // Extra small
					if(!_sidebar.hasClass('menu-min')){
						_sidebar.addClass('menu-min');
						$('#sidebar-collapse-click').addClass('closed');
					}
				}
			});
		});
	</script>
	{/literal}
{else}
	{literal}
	<script type="text/javascript">
		$(function(){
			var $ok = 1;
			if(!$('#sidebar').hasClass('menu-min')){
				$('#sidebar').addClass('menu-min');
				$('#sidebar-collapse-click').addClass('closed');
				$.post(path_ajax_script+'/index.php?mod=home&act=ajOpenSidebar',{
					'val': $ok
				},function(html){
					// Some code
				});
			}
			$('#sidebar-collapse-click').click(function(ev){
				ev.preventDefault();
				var $_this = $(this),
					$_sidebar = $('#'+'sidebar');
				if(!$_sidebar.hasClass('menu-min')){
					$ok = 0;
					$_sidebar.addClass('menu-min');
					$_this.addClass('closed');
				}else{
					$ok = 1;
					$_sidebar.removeClass('menu-min');
					$_this.removeClass('closed');
					
				}
				$.post(path_ajax_script+'/index.php?mod=home&act=ajOpenSidebar',{
					'val': $ok
				},function(html){
					// Some code
				});
				return false;
			});
		});
	</script>
	{/literal}
{/if}
<div id="wrapper" class="wrapper">
    <div id="page-body" class="page-body">
		{assign var = SIDEBAR_TOGGLE value = 'SIDEBAR_TOGGLE_'|cat:$_loged_id}
		<div class="sidebar{if $deviceType eq 'phone'} menu-min{else}{if !$clsConfiguration->getValue($SIDEBAR_TOGGLE)} menu-min{/if}{/if}" id="sidebar">
			{literal}
			<script type="text/javascript">
				(function () {
					var sidebar = document.getElementById('sidebar');
					var toggle = document.getElementById('sidebar-collapse-click');
					if (!sidebar || !toggle || window.matchMedia('(max-width: 991px)').matches) return;
					try {
						var savedState = window.localStorage.getItem('isocms_admin_sidebar_collapsed_v2');
						if (savedState !== '0' && savedState !== '1') return;
						var collapsed = savedState === '1';
						sidebar.classList.toggle('menu-min', collapsed);
						toggle.classList.toggle('closed', collapsed);
						toggle.setAttribute('aria-expanded', collapsed ? 'false' : 'true');
					} catch (ignoreSidebarStorage) {}
				}());
			</script>
			{/literal}
			<div id="sidebar_elements">
				{$core->getBlock('quick_menu')}
			</div>
			<aside class="iso-sidebar-promo" aria-label="isoCMS navigation controls">
				<div class="iso-sidebar-promo__content">
					<strong>Powering amazing<br />journeys together.</strong>
					<span>isoCMS &ndash; All in one Travel Management</span>
				</div>
				<button type="button" class="iso-sidebar-promo__collapse" aria-label="Collapse sidebar" title="Collapse sidebar">
					<i class="fa fa-arrow-left" aria-hidden="true"></i>
				</button>
			</aside>
		</div>
		<button type="button" class="iso-shell-overlay" aria-label="Close navigation"></button>
		<div id="page-content" class="page-content">
