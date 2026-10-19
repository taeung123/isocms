<div class="breadcrumb">
	<strong>Bạn đang ở:</strong>
	<a href="{$PCMS_URL}" title="Trang chủ">{$core->get_Lang('Home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="Cài đặt">{$core->get_Lang('Installation')}</a>
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('Come back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{$core->get_Lang('Config')}</h2>
    </div>
	<div class="clearfix"></div>
	<div class="setting_nav_box">
		<div class="setting_nav_list">
			<div class="row">
				<div class="col-sm-6">
					<div class="setting_nav_item">
						<a href="{$PCMS_URL}/?mod=setting">
							<div class="nav_icon">
								<i class="fa fa-cog" aria-hidden="true"></i>
							</div>
							<div class="nav_body">
								<p class="title">{$core->get_Lang('generalsetting')}</p>
							</div>
						</a>
					</div>
					<div class="setting_nav_item">
						<a href="{$PCMS_URL}/?mod=setting&act=profile">
							<div class="nav_icon">
								<i class="fa fa-home" aria-hidden="true"></i>
							</div>
							<div class="nav_body">
								<p class="title">{$core->get_Lang('companyprofile')}</p>
							</div>
						</a>
					</div>
					<div class="setting_nav_item">
						<a href="{$PCMS_URL}/?mod=email_template">
							<div class="nav_icon">
								<i class="fa fa-envelope" aria-hidden="true"></i>
							</div>
							<div class="nav_body">
								<p class="title">{$core->get_Lang('emailtemplate')}</p>
							</div>
						</a>
					</div>
					<div class="setting_nav_item">
						<a href="{$PCMS_URL}/?mod=setting&act=mailconfig">
							<div class="nav_icon">
								<i class="fa fa-envelope" aria-hidden="true"></i>
							</div>
							<div class="nav_body">
								<p class="title">{$core->get_Lang('mailconfig')}</p>
							</div>
						</a>
					</div>
					<div class="setting_nav_item">
						<a href="{$PCMS_URL}/?mod=meta">
							<div class="nav_icon">
								<i class="fa fa-tags" aria-hidden="true"></i>
							</div>
							<div class="nav_body">
								<p class="title">{$core->get_Lang('Seo &amp; Meta Tags')}</p>
							</div>
						</a>
					</div>
					<div class="setting_nav_item">
						<a href="{$PCMS_URL}/?mod=setting&act=social">
							<div class="nav_icon">
								<i class="fa fa-tags" aria-hidden="true"></i>
							</div>
							<div class="nav_body">
								<p class="title">{$core->get_Lang('Social network links')}</p>
							</div>
						</a>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="setting_nav_item">
						<a href="{$PCMS_URL}/?mod=setting&act=message">
							<div class="nav_icon">
								<i class="fa fa-comments" aria-hidden="true"></i>
							</div>
							<div class="nav_body">
								<p class="title">{$core->get_Lang('Notice')}</p>
							</div>
						</a>
					</div>
					<div class="setting_nav_item">
						<a href="{$PCMS_URL}/?mod=lang_front">
							<div class="nav_icon">
								<i class="fa fa-language" aria-hidden="true"></i>
							</div>
							<div class="nav_body">
								<p class="title">{$core->get_Lang('Languages Frontpage')}</p>
							</div>
						</a>
					</div>
					<div class="setting_nav_item">
						<a href="{$PCMS_URL}/?mod=lang">
							<div class="nav_icon">
								<i class="fa fa-language" aria-hidden="true"></i>
							</div>
							<div class="nav_body">
								<p class="title">{$core->get_Lang('Admin Languages')}</p>
							</div>
						</a>
					</div>
					<div class="setting_nav_item">
						<a href="{$PCMS_URL}/?mod=setting&act=pay">
							<div class="nav_icon">
								<i class="fa fa-credit-card" aria-hidden="true"></i>
							</div>
							<div class="nav_body">
								<p class="title">{$core->get_Lang('Payment Gateway')}</p>
							</div>
						</a>
					</div>
					<div class="setting_nav_item">
						<a href="{$PCMS_URL}/?mod=user">
							<div class="nav_icon">
								<i class="fa fa-user" aria-hidden="true"></i>
							</div>
							<div class="nav_body">
								<p class="title">{$core->get_Lang('Full Administrator')}</p>
							</div>
						</a>
					</div>
					<div class="setting_nav_item">
						<a href="{$PCMS_URL}/?mod=usergroup">
							<div class="nav_icon">
								<i class="fa fa-user" aria-hidden="true"></i>
							</div>
							<div class="nav_body">
								<p class="title">{$core->get_Lang('Administrators Role')}</p>
							</div>
						</a>
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>
{literal}
<style>
.setting_nav_box,.setting_nav_list{display: inline-block; width: 100%;}
.setting_nav_item{display: inline-block; width:100%; padding: 10px;}
	.setting_nav_item a{color: #333;}
.setting_nav_item .nav_icon{display: inline-block; width:50px; height: 50px; line-height: 50px; background: #f4f6f8; color: #989898; float: left; text-align: center; margin-right: 10px;}
	.setting_nav_item .nav_icon i{line-height: 50px;}
	.setting_nav_item .nav_body{display: inline-block; width: calc(100% - 60px); float: left; padding: 13px 0}
	.setting_nav_item .nav_body p{font-size: 16px; font-weight: bold; line-height: 24px;}
</style>
{/literal}