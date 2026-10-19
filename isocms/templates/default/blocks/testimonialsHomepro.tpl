{if $lstTestimonial}
    {assign var = TitleSiteTestimonial value = TitleTestimonialsHome_|cat:$_LANG_ID}
    {assign var = IntroSiteTestimonial value = IntroTestimonialsHome_|cat:$_LANG_ID}
    <section class="section_box testimonials__box">
        <div class="container">
            <div class="box_testimonial">
                <h2 class="section_box-title section_box-title_testimonials text-center">
                    {*				<a class="color_2c2c2c" href="{$clsISO->getLink('testimonial')}" title="{$clsConfiguration->getValue($TitleSiteTestimonial)}">{$clsConfiguration->getValue($TitleSiteTestimonial)}</a>*}
                    {$clsConfiguration->getValue($TitleSiteTestimonial)}
                </h2>
                <div class="intro_box text-center">{$clsConfiguration->getValue($IntroSiteTestimonial)|html_entity_decode}</div>
                <div class="list_testimonial">
                    <div class="jcarousel-box owl_slide_testimonial owl-carousel">
                        {section name=i loop=$lstTestimonial}
                            {assign var = title_testimonial value = $lstTestimonial[i].title}
                            {assign var = link_testimonial value = $clsTestimonial->getLink($lstTestimonial[i].testimonial_id,$lstTestimonial[i])}
                            <div class="tes_item" data-dot="<button>{$smarty.section.i.index}</button>">
                                <a class="color_444444" href="{$link_testimonial}" title="{$title_testimonial}">
                                    <h3 class="title_test limit_1line">{$title_testimonial}</h3>
                                    <div class="item__intro limit_3line">{$lstTestimonial[i].intro|html_entity_decode|strip_tags} </div>
                                    <div class="box_customer">
                                        <div class="box_avt">
                                            <img width="45" height="45" src="{$URL_IMAGES}/noimage.png"
                                                 data-src="{$clsTestimonial->getImage($lstTestimonial[i].testimonial_id,45,45,$lstTestimonial[i])}"
                                                 alt="{$getTitle}" class="img_customer lazy img100">
                                        </div>
                                        <div class="box_left_customer">
                                            <p class="item_name">{$lstTestimonial[i].name}</p>
                                            <label class="rate-2019 block">{$clsTestimonial->getRatesStar($lstTestimonial[i].testimonial_id,$lstTestimonial[i])}</label>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        {/section}
                    </div>
                </div>
            </div>
        </div>
    </section>
{/if}
{literal}
    <style>
        .section_box.testimonials__box {
            padding-bottom: 100px;
        }

		.section_box-title {
			text-transform: uppercase;
		}
        .testimonials__box .owl-prev,
        .testimonials__box .owl-next {
            text-indent: 0;
            background: unset !important;
            width: 40px;
            height: 40px;
            border: 1px solid #ccc !important;
            border-radius: 50%;
            font-size: 24px !important;
            line-height: 40px !important;

        }

        .testimonials__box .owl-prev {
            left: -62px;
        }

        .testimonials__box .owl-next {
            right: -62px;
        }

        .testimonials__box .intro_box p {
            margin: 0;
        }

        .testimonials__box .intro_box {
            margin-bottom: 25px;
        }

        .section_box.testimonials__box {
            padding-bottom: 100px;
        }

        .testimonials__box .title_testimonials {
            text-align: center;
            color: #1c1c1c;
            font-size: 24px;
            font-weight: 600;
            line-height: 42px;
            margin-bottom: 5px;
        }


        .tes_item {

            background: #fff;

            padding: 30px 25px;

            border-radius: 5px;

            border: 1px solid #e0e0e0;

            margin: 3px;

        }

        .tes_item:hover .title,
        .tes_item:hover .title_test {

            color: var(--main-color-2) !important;

        }

        .tes_item .title_test {

            color: #000;

            font-size: 20px;

            font-weight: 600;

            line-height: 30px;

            margin-bottom: 10px;

        }

        .tes_item .item__intro {

            color: #353535;

            font-size: 14px;

            font-weight: 400;

            line-height: 21px;

            margin-bottom: 37px;

        }

        .tes_item .box_customer {

            display: flex;

            flex-wrap: wrap;

            align-items: center;

        }

        .tes_item .box_customer .box_avt {

            width: 45px;

            height: 45px;

            border-radius: 5px;

            overflow: hidden;

            margin-right: 13px;

        }

        .tes_item .box_customer .box_left_customer {

            width: calc(100% - 58px);

        }

        .tes_item .item_name {

            color: #353535;

            font-size: 14px;

            font-weight: 600;

            line-height: 21px;

            margin-bottom: 0;

        }

        .tes_item .country_user {

            color: #353535;

            font-size: 12px;

            font-weight: 400;

            line-height: 18px;

        }

        .testimonials__box .list_testimonial .owl-prev, .testimonials__box .list_testimonial .owl-next {
            font-size: 0 !important;
        }
    </style>
{/literal}