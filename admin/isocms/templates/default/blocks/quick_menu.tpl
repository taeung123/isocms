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

	{foreach from=$lstAdminButtonLeft item=btnLeft}
		{assign var=id value=$btnLeft.adminbutton_id}
		{assign var=lstAdminButtonLeftChild value=$clsAdminButton->getChild($id)}
		{if $clsAdminButton->checkPackage($id, $package_id)}
			{if $core->checkAccess($btnLeft.mod_page)}
				<li class="{if $mod eq $btnLeft.mod_page || $btnLeft.mod_page=='tour'}active{/if}" package_id="{$package_id}">
					<a data-toggle="ripple" 
					{if $lstAdminButtonLeftChild}href="javascript:void(0);" class="nav-header dropdown-toggle {$btnLeft.class_page}"{else}class="nav-header" href="{$clsAdminButton->getURL($btnLeft.adminbutton_id)}"{/if}>
						<div class="ico"><i class="{$btnLeft.class_iconpage}"></i></div>
						<span class="menu-text"> {$core->get_Lang($btnLeft.title_page)}</span>
						{if $lstAdminButtonLeftChild}<b class="arrow fa fa-angle-down"></b>{/if}
					</a>
					{if $lstAdminButtonLeftChild}
						<div class="submenu" {if $mod == $btnLeft.mod_page || $btnLeft.mod_page=='tour'}style="display:block;"{else}style="display:none;"{/if}>
							<ul class="nav-list sublist">
								{foreach from=$lstAdminButtonLeftChild item=subBtn}
									{assign var=sub_id value=$subBtn.adminbutton_id}
									{if $clsAdminButton->checkPackage($sub_id, $package_id)}
										{if $core->checkAccess($subBtn.mod_page) and $clsAdminButton->checkConfiguration($subBtn.adminbutton_id)}
											<li class="{$subBtn.class_page}" {$subBtn.mod_page}>
												<a data-toggle="ripple" title="{$core->get_Lang($subBtn.title_page)}" href="{$clsAdminButton->getURL($subBtn.adminbutton_id)}">
													<span>
														<i class="fa fa-angle-right"></i> {$core->get_Lang($subBtn.title_page)}
														{if $subBtn.mod_page=='cruise' || $subBtn.mod_page=='discount' || $subBtn.mod_page=='hotel' || $subBtn.mod_page=='voucher' || ($subBtn.mod_page=='tour_exhautive' && $subBtn.act_page=='store')}
															<span class="badge s_pro label-warning">Pro</span>
														{/if}
													</span>
												</a>
											</li>
										{/if}
									{/if}
								{/foreach}
							</ul>
						</div>
					{/if}
				</li>
			{/if}
		{/if}
	{/foreach}

</ul>