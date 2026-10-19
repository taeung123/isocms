{$clsISO->getTemplate("blocks/schema/component/blog")}
{literal}
    <script type="application/ld+json">
        {
            "@context": "https://schema.org/",
            "@type": "Blog",
            "@id": "{/literal}{$DOMAIN_NAME}{$curl}{literal}",
            "mainEntityOfPage": "{/literal}{$DOMAIN_NAME}{$curl}{literal}",
            "name": "{/literal}
                
                {if $show eq 'Default'}{$core->get_Lang('Our Blog')}
                    
                {else}{$core->get_Lang('Blog listing by destinations')} {$TD}
                    
                {/if}
                
                {literal}",
            "description": "{/literal}{$description_page}{literal}",
            "publisher": {
                "@type": "Organization",
                "@id": "{/literal}{$DOMAIN_NAME}{literal}",
                "name": "VietISO Company",
                "logo": {
                    "@type": "ImageObject",
                    "@id": "{/literal}{$DOMAIN_NAME}/uploads/logo/logo_footer_new.png{literal}",
                    "url": "{/literal}{$DOMAIN_NAME}/uploads/logo/logo_footer_new.png{literal}",
                    "width": "98",
                    "height": "47"
                        }
                    },
                {/literal}
                {if $lstBlogs}
                {literal}
                    "blogPost": [
                {/literal}
                    {section name=i loop=$lstBlogs}
                        {assign var=title_blog value=$clsBlog->getTitle($lstBlogs[i].blog_id,$lstBlogs[i])}
                        {assign var=link_blog value=$clsBlog->getLink($lstBlogs[i].blog_id,$lstBlogs[i])}
                        {assign var=publish_date value=$lstBlogs[i].publish_date|date_format:"%Y-%m-%d"}
                        {assign var=upd_date value=$lstBlogs[i].upd_date|date_format:"%Y-%m-%d"}
                        {assign var=imgBlog value=$clsBlog->getImage($lstBlogs[i].blog_id,828,552,$lstBlogs[i])}
                        {assign var=author value=$lstBlogs[i].author}
                        {assign var=listTag value=$clsBlog->getArrayTag($lstBlogs[i].blog_id,$lstBlogs[i])}
                        {literal}
                            {
                                "@type": "BlogPosting",
                                "@id": "{/literal}{$DOMAIN_NAME}{$link_blog}{literal}#BlogPosting",
                                "mainEntityOfPage": "{/literal}{$DOMAIN_NAME}{$link_blog}{literal}",
                                "headline": "{/literal}{$title_blog}{literal}",
                                "name": "{/literal}{$title_blog}{literal}",
                                "description": "{/literal}{$clsBlog->getIntro($lstBlogs[i].blog_id,$lstBlogs[i])|strip_tags}{literal}",
                                "datePublished": "{/literal}{$publish_date}{literal}",
                                "dateModified": "{/literal}{$upd_date}{literal}",
                                "author": {
                                    "@type": "Person",
                                    "name": "{/literal}{$author}{literal}"
                                },
                                "image": {
                                    "@type": "ImageObject",
                                    "@id": "{/literal}{$DOMAIN_NAME}{$imgBlog}{literal}",
                                    "url": "{/literal}{$DOMAIN_NAME}{$imgBlog}{literal}",
                                    "height": "552",
                                    "width": "828"
                                },
                                "url": "{/literal}{$DOMAIN_NAME}{$link_blog}{literal}"
                            {/literal}
                            {if $listTag}
                                {literal},"keywords": 
                                {/literal}{$listTag|@json_encode}
                                {literal}
                                {/literal}
                            {/if}
                            {literal}
                            }{/literal}
                            {if !$smarty.section.i.last}
                                {literal},
                                {/literal}
                            {/if}
                        {/section}
                    {literal}
                    ]
                    {/literal}
                {/if}
            {literal}
        }
    </script>
{/literal}