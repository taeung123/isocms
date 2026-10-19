{literal}
<script type="text/javascript">
	$(function(){
		/*$.lockfixed("#sidebar_elements", {offset: {top:0, bottom:61}});*/
		$(document).on('click', '.dropdown-toggle', function(ev){
			var $_this = $(this);
			var $_sub = $_this.parent().find('.submenu');
			if($_sub.is(':visible')){
				$_sub.stop(false,true).slideUp();
				$_this.find('.arrow').removeClass('fa-angle-up').addClass('fa-angle-down');
				$_this.parent().removeClass('active');
			}else{
				$('.submenu:visible').stop(false,true).slideUp();
				$('.arrow').removeClass('fa-angle-up').addClass('fa-angle-down');
				$_sub.stop(false,true).slideDown();
				$_this.find('.arrow').removeClass('fa-angle-down').addClass('fa-angle-up');
				$_this.parent().addClass('active');
				
			}
			return false;
		});
		var $ww = $(window).width(),
			stickyOffset = $('#sidebar').offset().top;
		$(window).scroll(function(){
			var sticky = $('#sidebar');
			scroll = $(window).scrollTop();
			if (scroll >= stickyOffset || scroll >= 35){
				sticky.addClass('fixed');
			} else{
				sticky.removeClass('fixed');
			}
		});
	});
</script>
{/literal}
<ul id="sidebar-nav" class="nav nav-list">
	<li class="{if $mod eq 'home'} active{/if}">
		<a class="nav-header" href="{$PCMS_URL}" title="{$PAGE_NAME}">
			<div class="ico"><i class="fa fa-home"></i></div>
			<span class="menu-text bold">{$core->get_Lang('Dashboard')}</span>
		</a>
	</li>
	{assign var=lstAdminButtonLeft value=$clsAdminButton->getAll('is_active=1 and parent_id=0 and _type="_LEFT" order by order_no asc')}
	{section name=k loop=$lstAdminButtonLeft}
	{assign var=id value=$lstAdminButtonLeft[k].adminbutton_id}
	{assign var=lstAdminButtonLeftChild value=$clsAdminButton->getChild($id)}
	{if $clsAdminButton->checkPackage($id,$package_id)}
	{if $core->checkAccess($lstAdminButtonLeft[k].mod_page)}
	<li class="{if $mod eq $lstAdminButtonLeft[k].mod_page|| $lstAdminButtonLeft[k].mod_page=='tour'}active{/if}" package_id="{$package_id}">
		<a data-toggle="ripple" {if $lstAdminButtonLeftChild}href="javascript:void(0);" class="nav-header dropdown-toggle {$lstAdminButtonLeft[k].class_page}"{else}class="nav-header" href="{$clsAdminButton->getURL($lstAdminButtonLeft[k].adminbutton_id)}"{/if}>
			<div class="ico"><i class="{$lstAdminButtonLeft[k].class_iconpage}"></i></div>
			<span class="menu-text"> {$core->get_Lang($lstAdminButtonLeft[k].title_page)}</span>
			{if $lstAdminButtonLeftChild}<b class="arrow fa fa-angle-down"></b>{/if}
		</a>
		<div class="submenu" {if $mod ==$lstAdminButtonLeft[k].mod_page|| $lstAdminButtonLeft[k].mod_page=='tour'}style="display:block;"{else}style="display:none;"{/if}>
			<ul class="nav-list sublist">
				{section name=i loop=$lstAdminButtonLeftChild}
				{assign var=sub_id value=$lstAdminButtonLeftChild[i].adminbutton_id}
				{if $clsAdminButton->checkPackage($sub_id,$package_id)}
				{if $core->checkAccess($lstAdminButtonLeftChild[i].mod_page) and $clsAdminButton->checkConfiguration($lstAdminButtonLeftChild[i].adminbutton_id)}
				<li class="{$lstAdminButtonLeftChild[i].class_page}">
					<a data-toggle="ripple" title="{$core->get_Lang($lstAdminButtonLeftChild[i].title_page)}" href="{$clsAdminButton->getURL($lstAdminButtonLeftChild[i].adminbutton_id)}"><span>{if $lstAdminButtonLeftChild[i].image ne ''}<img align="absmiddle" src="{$lstAdminButtonLeftChild[i].image}" width="15px" />{else}<i class="{$lstAdminButtonLeftChild[i].class_iconpage}"></i>{/if} {$core->get_Lang($lstAdminButtonLeftChild[i].title_page)}</span>
					</a>
				</li>
				{/if}
				{/if}
				{/section}
			</ul>
		</div>
	</li>
	{/if}
	{/if}
	{/section}
</ul>