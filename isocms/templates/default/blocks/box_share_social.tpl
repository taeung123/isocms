{if $mod eq 'home'}
<meta property="og:type" content="website" />
{else}
<meta property="og:type" content="article" />
{/if}
<meta property="og:title" content="{$global_title_page|html_entity_decode|strip_tags}" />
<meta property="og:description" content="{$global_description_page|strip_tags|truncate:300}" />
<meta property="og:image" content="{$DOMAIN_NAME}{$global_image_page}" />
<meta property="og:url" content="{$DOMAIN_NAME}{$REQUEST_URI}" />
<meta property="og:image:alt" content="{$global_title_page|html_entity_decode|strip_tags}" />
<meta property="og:image:type" content="image/jpeg" />
<meta property="og:image:width" content="320">
<meta property="og:image:height" content="350">
<meta data-react-helmet="true" name="twitter:card" content="summary"/>
<meta data-react-helmet="true" name="twitter:title" content="{$global_title_page|html_entity_decode|strip_tags}"/>
<meta data-react-helmet="true" name="twitter:description" content="{$global_description_page|strip_tags|truncate:300}"/>
<meta data-react-helmet="true" name="twitter:image:url" content="{$DOMAIN_NAME}{$global_image_page}"/>
<meta data-react-helmet="true" name="twitter:site" content="@{$twitter_site}"/>
<meta data-react-helmet="true" name="twitter:creator" content="@{$twitter_site}">