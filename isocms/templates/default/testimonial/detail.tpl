{assign var=title_testimonial value=$clsTestimonial->getTitle($testimonial_id)}
{assign var=image_testimonial value=$clsTestimonial->getImage($testimonial_id,1200,600)}
<div class="page_container">

	<nav class="breadcrumb-main bg_fff">

		<div class="container">


					<ol class="breadcrumb hidden-xs mt0 bg_fff" itemscope itemtype="https://schema.org/BreadcrumbList">

					<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">

						<a itemprop="item" href="{$PCMS_URL}" title="{$core->get_Lang('Home')}">

							<span itemprop="name" class="reb">{$core->get_Lang('Home')}</span></a>

						<meta itemprop="position" content="1" />

					</li>

					<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">

						<a itemprop="item" href="{$clsISO->getLink('testimonial')}" title="{$core->get_Lang('Testimonials')}">

							<span itemprop="name" class="reb">{$core->get_Lang('Testimonials')}</span></a>

						<meta itemprop="position" content="2" />

					</li>

					<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="current">

						<a itemprop="item" href="{$curl}" title="{$title_testimonial}"> <span itemprop="name" class="reb">{$title_testimonial}</span></a>

						<meta itemprop="position" content="3" />

					</li>

				</ol>


		</div>

	</nav>

	<div class="testimonialPage">

		<div class="container">

			<div class="row">

					<article class="bg_fff">

    <h1 class="size32 title SegoeUILight">
        {$title_testimonial}
    </h1>

    {* =========================================
       COVER IMAGE
       ========================================= *}
    {if !empty($image_testimonial)}
        <div class="testimonial-cover">
            <img
                src="{$image_testimonial|escape:'html'}"
                alt="{$title_testimonial|escape:'html'}"
                width="1200"
                height="600"
                loading="eager"
                decoding="async"
            >
        </div>
    {/if}

    <p class="country text_bold">
        <label class="rate-2019 inline-block">
            {$clsTestimonial->getRatesStar($testimonial_id)}
        </label>

        {$clsTestimonial->getName($testimonial_id)},
        {$clsTestimonial->getCountry($testimonial_id)}
    </p>

    <div class="formatTextStandard">
        {$clsTestimonial->getIntro($testimonial_id)}
    </div>

</article>

					{if $listItem[0].testimonial_id ne ''}

					<div class="related_box mt30" id="listTestimonialsView">

						<!-- <p class="size24 hd mb0">{$core->get_Lang('See more')}</p> -->

						<div class="listTestimonial">

							{section name=i loop=$listItem}

    {assign var=testimonialId value=$listItem[i].testimonial_id}
    {assign var=title value=$clsTestimonial->getTitle($testimonialId)}
    {assign var=link value=$clsTestimonial->getLink($testimonialId)}
    {assign var=image value=$clsTestimonial->getImage($testimonialId,260,200)}

    <div class="item bg_fff">
        <a href="{$link}"
           title="{$title|escape:'html'}">

            {if !empty($image)}
                <div class="photo">
                    <img class="img-responsive img100"
                         src="{$image|escape:'html'}"
                         alt="{$title|escape:'html'}"
                         width="260"
                         height="200"
                         loading="lazy"
                         decoding="async">
                </div>
            {/if}

            <div class="body title">
                <h3 class="testimonials-title">
                    {$title}
                </h3>

                <div class="introCrx">
                    {$clsTestimonial->getIntro($testimonialId)|strip_tags|truncate:235}
                </div>

                <div class="wrap profilet">
                    <strong>
                        {$clsTestimonial->getName($testimonialId)},
                        {$clsTestimonial->getCountry($testimonialId)}
                    </strong>
                </div>

                <div class="star mt10">
                    <label class="rate-2019 block">
                        {$clsTestimonial->getRatesStar($testimonialId)}
                    </label>
                </div>
            </div>
        </a>
    </div>

{/section}

						</div>

					</div>

					{/if} 


			</div>

		</div>

	</div>

</div>