<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
	<a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('city')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}&act={$act}" title="{$mod}">{$core->get_Lang('settingcity')}</a>
</div>
<div class="clearfix"></div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{$core->get_Lang('settingcity')}</h2>
        <p>{$core->get_Lang('systemmanagementsettingcity')}</p>
    </div>
    <div class="wrap mt10 mb20">
		<div class="hd">
			<span class="bold">{$core->get_Lang('selectsetting')}</span>
		</div>
		<ul class="rsl-list-buttons">
			{assign var=lstCityType value=$clsCityStore->getListType()}
			{foreach from=$lstCityType key=k item=v}
			<li>
				<a href="{$PCMS_URL}/?admin&mod=country&act=store&type={$core->encryptID($k)}">
					<img class="imgIcon" src="{$URL_IMAGES}/checklist-icon.png" width="32" height="32" />
					<span class="text">{$v}</span>
				</a>
			</li>
			{/foreach}
		</ul>
	</div>
	{$core->getBlock('form_setting_module')}
</div>
{literal}
<script type="text/javascript">
	$(document).ready(function(){
		$(".datepicker").datepicker();
	});
</script>
{/literal}