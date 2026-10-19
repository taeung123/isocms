{*
 "address": {
        "@type": "PostalAddress",
        "streetAddress": "",
        "addressLocality": "",
        "addressRegion": "",
        "addressCountry": "VN"
      },
*}
{$SiteFacebookLink = $clsConfiguration->getValue('SiteFacebookLink')}
{$SiteYoutubeLink = $clsConfiguration->getValue('SiteYoutubeLink')}
{$SiteTwitterLink = $clsConfiguration->getValue('SiteTwitterLink')}
{$sameAs = []}
{if !empty($SiteFacebookLink)}
	{$sameAs[] = "https://www.facebook.com/"|cat:$SiteFacebookLink}
{/if}
{if !empty($SiteYoutubeLink)}
	{$sameAs[] = "https://www.youtube.com/"|cat:$SiteYoutubeLink}
{/if}
{if !empty($SiteTwitterLink)}
	{$sameAs[] = "https://twitter.com/"|cat:$SiteTwitterLink}
{/if}


{* {assign var=schema_url value=$PCMS_URL|rtrim:'/'|cat:$curl}
{assign var=schema_name value=$title_page|default:$PAGE_NAME}
{assign var=schema_desc value=$description_page|default:$PAGE_NAME} *}
{assign var=Founder value=$clsConfiguration->getValue('Founder')|default:''}
{assign var=ImageShareSocial value=$clsConfiguration->getValue('ImageShareSocial')|default:''}
{if empty($ImageShareSocial)}
	{assign var=ImageShareSocial value=$clsConfiguration->getValue('HeaderLogo')|default:''}
{/if}

{if !empty($schema_file)}  
    {$clsISO->getTemplate($schema_file)}
{/if}

<!-- Custom schema  -->
{if !empty($global_schema_markup)}
    <script type="application/ld+json">
        {$global_schema_markup}
    </script>
{/if}