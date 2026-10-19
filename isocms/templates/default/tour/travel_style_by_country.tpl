<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css"/>
<script defer src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
<link rel="stylesheet" href="{$URL_CSS}/cat2024.css?v={$upd_version}"/>

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
            $('.typeSearch').change(function() {
                $(this).closest('form').submit();
            });
        })
    </script>
{/literal}