{$clsISO->getTemplate("blocks/schema/component/about")}
{literal}
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@graph": [{
                    "@type": "BreadcrumbList",
                    "@id":"{/literal}{$schema_url}{literal}#breadcrumb",
                    "itemListElement": [
                        {"@type":"ListItem","position":1,"name":"Home","item":"{/literal}{$PCMS_URL}{literal}"},
                        {"@type":"ListItem","position":2,"name":"{/literal}{$schema_name|escape:'html'}{literal}","item":"{/literal}{$schema_url}{literal}"}
                    ]
                },
                {
                    "@type": "WebPage",
                    "@id":"{/literal}{$schema_url}{literal}#webpage",
                    "url":"{/literal}{$schema_url}{literal}",
                    "name":"{/literal}{$schema_name|escape:'html'}{literal}",
                    "description":"{/literal}{$schema_desc|escape:'html'}{literal}",
                    "isPartOf":{"@id":"{/literal}{$PCMS_URL}{literal}#website"},
                    "breadcrumb":{"@id":"{/literal}{$schema_url}{literal}#breadcrumb"}
                },
                {
                    "@type": "AboutPage",
                    "@id":"{/literal}{$schema_url}{literal}#aboutpage",
                    "url":"{/literal}{$schema_url}{literal}",
                    "name":"{/literal}{$schema_name|escape:'html'}{literal}"
                }
            ]
        }
    </script>
{/literal}