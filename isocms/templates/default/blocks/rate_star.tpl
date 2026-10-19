<div class="star_rate">
    <div class="box_parent_star">
		<span class="rating" data-table="{$blog_id}">
            {for $x=1 to 5}
                <i class="fa-thin fa-star star_no_yellow" aria-hidden="true" width="30" height="30" star="{$x}"></i>
            {/for}
		</span>
        <span class="rating rating_yellow" data-table="{$blog_id}" style="width: {$percentRateAVG}%">
            {for $x=1 to 5}
			    <i class="fa-solid fa-star star_yellow" aria-hidden="true" width="30" height="30" star="{$x}"></i>
            {/for}
		</span>
    </div>
    <span id="text_res">{if $totalRate}| {$totalRate} {$core->get_Lang('Voted')}{/if}</span>
</div>
<script>var actAj = 'saveRating',type = 'blog';</script>
{literal}
    <style>
        .star_rate .rating .star_no_yellow {color: rgba(249, 186, 9, 1)}
        .star_rate {padding:0;background: #fff;display: flex; align-items: center; justify-content: flex-end}
        .star_rate .lbl_text {font-size: 16px;line-height: 24px;margin-right: 10px;}
        .star_rate .rating i,.icon_news.star i {color: #cccccc;font-size:30px;width: 30px;}
        .star_rate .rating i.star_yellow,.icon_news.star i.star_yellow {color: rgba(249, 186, 9, 1);cursor: pointer;transition: all 0.3s}
        .star_rate .rating i.star_yellow:before{content: "\f005"}
        .star_rate .rating i:hover {transform: rotate(-5deg) scale(1)}
        .star_rate .box_parent_star {display: inline-block;position: relative; margin-right: 8px}
        /*.star_rate .rating {display: inline-block;flex-wrap: nowrap;width: 165px;justify-content: space-around;white-space: nowrap}*/
        .star_rate .rating {display: inline-block;flex-wrap: nowrap;justify-content: space-around;white-space: nowrap}
        .star_rate .rating_yellow {position: absolute;left: 0;top: 0;width: 50%;white-space: nowrap;overflow-x: hidden}
        #text_res{font-size: 16px;font-weight: 400;line-height: 24px;letter-spacing: 0em;color: rgba(102, 102, 102, 1); margin-left: 6px; white-space: nowrap}
    </style>
    <script>
        $(document).ready(function(){
            $('.box_parent_star .rating i').hover(function(){
                var star = $(this).attr("star");
                $('.box_parent_star .rating .star_no_yellow').removeClass('star_yellow');
                $('.box_parent_star .rating .star_no_yellow').each(function( index ) {
                    if(index < parseInt(star)){
                        $(this).addClass('star_yellow');
                    }
                });
            });

            $('.box_parent_star .rating i').mouseleave(function(){
                console.log(1);
                $('.rating .star_no_yellow').removeClass('star_yellow');
            });
            $('.box_parent_star .rating i').click(function(){
                $.ajax({
                    type: 'POST',
                    url: path_ajax_script+'/index.php?mod='+mod+'&act='+actAj+'&type='+type,
                    dataType:"json",
                    data: {
                        star: $(this).attr('star'),
                        table_id: $('.box_parent_star .rating').data('table')
                    },
                    success: function (json) {
                        if(json.result == true){
                            alert("Thank you for rating!");
                            $('#text_res').text(json.text);
                            $('.box_parent_star .rating_yellow').css('width',json.percentAVG+'%')
                        }else{
                            alert("You have already voted!");
                        }
                    }
                });
            });
        });

    </script>
{/literal}