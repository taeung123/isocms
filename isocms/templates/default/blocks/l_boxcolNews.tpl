<div class="sidebar">
	<form action="" method="post">
		{*
		<div class="input-group txtbox_search mb-3">
			<input type="text" class="form-control clear key_blog_search" placeholder="{$core->get_Lang("Search")}" name="key_blog" value="{$key_blog}" />
			<button type="submit" class="input-group-text txtbox_searchtxt iso_btn_search">
				<i class="fa fa-search" aria-hidden="true"></i>
			</button>
		</div>
		*}
		{if $lstCategory && $clsISO->getCheckActiveModulePackage($package_id,'news','category','default')}
		<div class="box_filter mt-lg-0 mt-5">
			<div class="linkNewsCat mb40">
				<h2 class="titleBoxCat">{if $act eq 'cat'}{$core->get_Lang('Other')} {/if}{$core->get_Lang('Categories')}</h2>
				<div class="filter-checkbox">
					{section name=i loop=$lstCategory}
						{assign var = title value = $clsNewsCategory->getTitle($lstCategory[i].newscat_id,$lstCategory[i])}
						<div class="iso_btn_search typeSearch" href="{$clsNewsCategory->getLink($lstCategory[i].newscat_id,$lstCategory[i])}">
							<input id="cat_id_{$lstCategory[i].newscat_id}" name="cat_id[]" class="form-check-input" type="checkbox" value="{$lstCategory[i].newscat_id}"
								   {if $lstCategory[i].newscat_id eq $newscat_id}checked{/if} />
							<label for="cat_id_{$lstCategory[i].newscat_id}" class="form-check-label">
								{$title}
							</label>
						</div>
					{/section}
				</div>
			</div>
		</div>
		{/if}

		{if $lstLatestNews}
			<div class="newsPopular mb20">
				<h2 class="titleBoxPopular">{$core->get_Lang('Featured news')}</h2>
				{section name=i loop=$lstLatestNews}
					{assign var = link value = $clsNews->getLink($lstLatestNews[i].news_id,$lstLatestNews[i])}
					{assign var = title value = $clsNews->getTitle($lstLatestNews[i].news_id,$lstLatestNews[i])}
					{assign var = image value = $clsNews->getImage($lstLatestNews[i].news_id,76,76,$lstLatestNews[i])}
					<div class="list_post">
						<a href="{$link}" title="{$title}"><img class="full-width img100 lazy" src="{$URL_IMAGES}/pixel.png" data-src="{$image}" alt="{$title}"></a>
						<div class="content_recent">
							<h3><a href="{$link}" title="{$title}">{$title}</a></h3>
						</div>
					</div>
				{/section}
			</div>
		{/if}

	</form>
</div>

{*Code cũ*}
{*
<div class="sidebar">
	{if $lstCategory && $clsISO->getCheckActiveModulePackage($package_id,'news','category','default')}
    <div class="linkNewsCat mb40">
		<h2 class="titleBoxCat">{if $act eq 'cat'}{$core->get_Lang('Other')} {/if}{$core->get_Lang('Categories')}</h2>
		<ul>
			{section name=i loop=$lstCategory}
			{assign var = title value = $clsNewsCategory->getTitle($lstCategory[i].newscat_id,$lstCategory[i])}
			<li class="category-link {if $lstCategory[i].newscat_id eq $newscat_id} active{/if}"><a href="{$clsNewsCategory->getLink($lstCategory[i].newscat_id,$lstCategory[i])}" title="{$title}"><i class="fa fa-angle-right" aria-hidden="true"></i> {$title}</a></li>
			{/section}
		</ul>
    </div>
	{/if}
	{if $lstLatestNews}
	<div class="newsPopular mb20">
        <h2 class="titleBoxPopular">{$core->get_Lang('Featured news')}</h2>
		{section name=i loop=$lstLatestNews}
		{assign var = link value = $clsNews->getLink($lstLatestNews[i].news_id,$lstLatestNews[i])}
		{assign var = title value = $clsNews->getTitle($lstLatestNews[i].news_id,$lstLatestNews[i])}
		{assign var = image value = $clsNews->getImage($lstLatestNews[i].news_id,76,76,$lstLatestNews[i])}
		<div class="list_post">
			<a href="{$link}" title="{$title}"><img class="full-width img100 lazy" src="{$URL_IMAGES}/pixel.png" data-src="{$image}" alt="{$title}"></a>
			<div class="content_recent">
				<h3><a href="{$link}" title="{$title}">{$title}</a></h3>
			</div>
		</div>
		{/section}
    </div>
	{/if}
</div>
*}

