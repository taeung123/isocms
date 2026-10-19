{literal}
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@graph": [{
                    "@type": "WebSite",
                    "@id":"{/literal}{$PCMS_URL}{literal}#website",
                    "url":"{/literal}{$PCMS_URL}{literal}",
                    "name":"{/literal}{$PAGE_NAME|escape:'html'}{literal}",
                    "publisher": {
                        "@id": "{/literal}{$PCMS_URL}{literal}#organization"
                    },
                    "potentialAction": {
                        "@type": "SearchAction",
                        "target":"{/literal}{$PCMS_URL}{literal}search?q={search_term_string}",
                        "query-input": "required name=search_term_string"
                    }
                },
                {
                    "@type": "Organization",
                    "@id":"{/literal}{$PCMS_URL}{literal}#organization",
                    "name":"{/literal}{$PAGE_NAME|escape:'html'}{literal}",
                    "url":"{/literal}{$PCMS_URL}{literal}",
                    "logo": {
                        "@type": "ImageObject",
                        "url":"{/literal}{$DOMAIN_NAME|rtrim:'/'}{$clsConfiguration->getValue('HeaderLogo')}{literal}"
                    },
                    "image":"{/literal}{$DOMAIN_NAME|rtrim:'/'}{$ImageShareSocial}{literal}",
                    "description":"{/literal}{$clsConfiguration->getValue('SiteMetaDescription')}{literal}",
                    "address": "{/literal}{$clsConfiguration->getValue('CompanyAddress_vn')}{literal}",
                    "telephone": "{/literal}{$clsConfiguration->getValue('CompanyPhone')}{literal}",
                    "email": "{/literal}{$clsConfiguration->getValue('CompanyEmail')}{literal}",
                    "sameAs": {/literal}{$sameAs|json_encode:true:JSON_UNESCAPED_SLASHES}{literal}
                },
                {
                    "@type": "Place",
                    "geo": {
                        "@type": "GeoCoordinates",
                        "latitude": "{/literal}{$clsConfiguration->getValue('CompanyMapLa')}{literal}",
                        "longitude": "{/literal}{$clsConfiguration->getValue('CompanyMapLo')}{literal}"
                    },
                    "name": "{/literal}{$PAGE_NAME}{literal}"
                }
            ]
        }
    </script>
{/literal}