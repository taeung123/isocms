{literal}
	<script type="application/ld+json">
	{
	"@context": "https://schema.org",
	"@type": "Organization",
	"logo": "{/literal}{$DOMAIN_NAME|rtrim:'/'}{$clsConfiguration->getValue('HeaderLogo')}{literal}",
	"image":"{/literal}{$DOMAIN_NAME|rtrim:'/'}{$ImageShareSocial}{literal}",
	{/literal}{if !empty($Founder)}{literal}"founder":"{/literal}{$Founder}{literal}",{/literal}{/if}{literal}
	"address":"{/literal}{$clsConfiguration->getValue('CompanyAddress_vn')}{literal}",
	"description":"{/literal}{$clsConfiguration->getValue('SiteMetaDescription')}{literal}",
	"contactPoint": [{
	"@type": "ContactPoint",
	"telephone": "{/literal}{$clsConfiguration->getValue('CompanyPhone')}{literal}",
	"email": "{/literal}{$clsConfiguration->getValue('CompanyEmail')}{literal}",
	"contactType": "sales",
	"productSupported":"Du lịch"
	}],
	"sameAs": {/literal}{$sameAs|json_encode:true:JSON_UNESCAPED_SLASHES}{literal}
	}
	</script>
	<script type="application/ld+json">
	{
	"@context": "https://schema.org",
	"@type": "Place",
	"geo": {
	"@type": "GeoCoordinates",
	"latitude": "{/literal}{$clsConfiguration->getValue('CompanyMapLa')}{literal}",
	"longitude": "{/literal}{$clsConfiguration->getValue('CompanyMapLo')}{literal}"
	},
	"name": "{/literal}{$PAGE_NAME}{literal}"
	}
	</script>
	{/literal}