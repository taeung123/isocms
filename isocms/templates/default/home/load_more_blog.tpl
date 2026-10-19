{section name=i loop=$lstTopBlog}
    {assign var=getTitle_Blog value=$clsBlog->getTitle($lstTopBlog[i].blog_id)}
    {assign var=getLink_Blog value=$clsBlog->getLink($lstTopBlog[i].blog_id)}
    <div class="col-md-3 item box">
        <a href="{$getLink_Blog}" title="{$getTitle_Blog}" class="">
            <img class="lazy img100" src="{$clsBlog->getImage($lstTopBlog[i].blog_id,296,184)}" alt="{$getTitle_Blog}"/>
        </a>
        <div class="blog_body">
            <h3 class="limit_2line size18"><a href="{$getLink_Blog}" class="color_1c1c1c" title="{$getTitle_Blog}">{$getTitle_Blog}</a></h3>
            <time class="time">{$clsISO->converTimeToText4($clsBlog->getOneField('publish_date',$lstTopBlog[i].blog_id))}</time>
            <div class="intro limit_3line">
                {$clsBlog->getIntro($lstTopBlog[i].blog_id)|strip_tags}
            </div>
        </div>
    </div>
{/section}