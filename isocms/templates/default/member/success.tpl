<div class="content-page">
	<div class="container">
		<div class="MH_box">
			<h1 class="headMod"> {if $show eq 'signup'}{$core->get_Lang('Register member success')}{/if}</h1>
			<div class="formatTextStandard mt15"> {if $show eq 'signup'}{$clsConfiguration->getValue('SiteMsg_RegisterSuccess')|html_entity_decode}{/if}
			</div>
		</div>
	</div>
</div>
{literal}
<style>
.content-page{padding-bottom:40px}
</style>
{/literal} 