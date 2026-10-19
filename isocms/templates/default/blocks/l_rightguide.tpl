<div class="sticky_fix">
    <div class="sidebar">
        {$core->getBlock('l_rightguide_search')}
    </div>
</div>

{literal}
    <script>
        $(function () {
            $(document).on("click", ".view-more-tour-relate", function () {
                $(".box_blog_tour_relate:hidden").show();
                $(this).hide();
            });
            $(document).on("click", ".view-more-cruise-relate", function () {
                $(".cruise-relate:hidden").show();
                $(this).hide();
            });
        });
    </script>
{/literal}