{$clsISO->getTemplate("blocks/schema/component/hotel")}
{literal}
<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Hotel",
        "name": "{/literal}{$title_hotel}{literal}",
            "description": "{/literal}{$intro_hotel|html_entity_decode|replace:'"':'\"'|strip_tags}{literal}",
            "address": {
                "@type": "PostalAddress",
                "addressCountry": "{/literal}{$_LANG_ID}{literal}",
                "addressLocality": "",
                "addressRegion": "{/literal}{$district_name}{literal}",
                "postalCode": "",
                "streetAddress": "{/literal}{$clsHotel->getAddress($hotel_id,$oneItem)}{literal}"
            },
            "telephone": "{/literal}{$oneItem.phone}{literal}",
            "photo": [
                {/literal}{section name=i loop=$listImage}{literal}
                    "{/literal}{$DOMAIN_NAME}{$listImage[i].image}{literal}",
                {/literal}{/section}{literal}
                "{/literal}{$DOMAIN_NAME}{$oneItem.image}{literal}"
            ]
        }
</script>
{/literal}