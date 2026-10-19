{$clsISO->getTemplate("blocks/schema/component/testimonial")}
{literal}
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@graph": [{
                    "@type": "BreadcrumbList",
                    "@id":"{/literal}{$schema_url}{literal}#breadcrumb",
                    "itemListElement": [
                        {"@type":"ListItem","position":1,"name":"Home","item":"{/literal}{$PCMS_URL}{literal}"},
                        {"@type":"ListItem","position":2,"name":"Testimonial","item":"{/literal}{$schema_url}{literal}"}
                    ]
                },
                {
                    "@type": "WebPage",
                    "@id":"{/literal}{$schema_url}{literal}#webpage",
                    "url":"{/literal}{$schema_url}{literal}",
                    "name":"{/literal}{$schema_name|escape:'html'}{literal}",
                    "isPartOf":{"@id":"{/literal}{$PCMS_URL}{literal}#website"},
                    "breadcrumb":{"@id":"{/literal}{$schema_url}{literal}#breadcrumb"}
                },
                {
                    "@type": "Review",
                    "@id":"{/literal}{$schema_url}{literal}#review",
                    "itemReviewed":{"@id":"{/literal}{$PCMS_URL}{literal}#organization"},
                    "author":{"@type":"Person","name":"{/literal}{$schema_name|escape:'html'}{literal}"}
                }
            ]
        }
    </script>
{/literal}