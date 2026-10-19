{$core->getBlock('2024_breadcrumb')}
<form action="" id="hnv_filter_form_tour" method="post">
{$core->getBlock('2024_box_intro')}
{$core->getBlock('box_item_tour')}
</form>
{$core->getBlock('tour_recently_viewed')}
{$core->getBlock('2024_review_customer')}
{$core->getBlock('dev_helpcenter_topdest')}
{literal}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            $('#cat_list_owl').owlCarousel({
                loop:true,
                margin:10,
                nav:false,
                dots:false,
                responsive:{
                    0:{
                        items:1
                    },
                    600:{
                        items:3
                    },
                    1000:{
                        items:5
                    }
                }
            });
            $('.typeSearch').change(function() {
                $(this).closest('form').submit();
            });
        })
    </script>
{/literal}