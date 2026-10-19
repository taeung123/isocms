{literal}
<script type="application/ld+json">
{
"@context": "https://schema.org",
"@type": "WebSite",
"url": "{/literal}{$DOMAIN_NAME}{literal}",
"name": "{/literal}{$PAGE_NAME}{literal}",
"alternateName": "{/literal}{$PAGE_NAME}{literal}"
}
</script>
<script type="application/ld+json">
{
"@context": "https://schema.org",
"@type": "Organization",
"url": "{/literal}{$DOMAIN_NAME}{literal}",
"logo": "{/literal}{$DOMAIN_NAME}{$clsConfiguration->getValue('HeaderLogo')}{literal}",
"image":"{/literal}{$DOMAIN_NAME}{$clsConfiguration->getValue('ImageShareSocial')}{literal}",
"founder":"{/literal}{$clsConfiguration->getValue('Founder')}{literal}",
"address":"{/literal}{$clsConfiguration->getValue('CompanyAddress_vn')}{literal}",
"description":"{/literal}{$clsConfiguration->getValue('SiteMetaDescription')}{literal}",
"contactPoint": [{
"@type": "ContactPoint",
"telephone": "{/literal}{$clsConfiguration->getValue('CompanyPhone')}{literal}",
"email": "{/literal}{$clsConfiguration->getValue('CompanyEmail')}{literal}",
"contactType": "sales",
"productSupported":"Du lịch"
}],
"sameAs": [
"https://www.facebook.com/{/literal}{$clsConfiguration->getValue('SiteFacebookLink')}{literal}",
"https://www.youtube.com/{/literal}{$clsConfiguration->getValue('SiteYoutubeLink')}{literal}",
"https://twitter.com/{/literal}{$clsConfiguration->getValue('SiteTwitterLink')}{literal}",
"https://zalo.me/{/literal}{$clsConfiguration->getValue('SiteZaloLink')}{literal}"
]
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