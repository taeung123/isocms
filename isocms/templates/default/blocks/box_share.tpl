<div class="share_news">
	<div class="sharer-icons" data-link_share="{$link_share}" data-title_share="{$title_share}" data-description_share="{$description_share|default:''}">
	</div>
</div>
{literal}
	<style type="text/css">

		.share_detail_box{width: 50px; top: 130px;  z-index: 1;float: left}

		.share_news { display: inline-block; text-align: right; float: right; }

		.share_news .sharer-icons { display: flex; }

		.col-share .share_news .sharer-icons{flex-direction: column;}

		.share_news .sharer-icons a { cursor: pointer; height: 30px; width: 30px; font-size: 16px; text-decoration: none; border: 1px solid transparent; border-radius: 50%; text-align: center; display: flex; justify-content: center; align-items: center; margin-left: 15px; transition: all 0.3s ease-in-out; }

		.col-share .share_news .sharer-icons a{margin-left: 0; margin-bottom:10px;}

		.share_news .sharer-icons a i { transition: transform 0.3s ease-in-out; }

		.share_news .sharer-icons a:hover { color: #fff; }

		.share_news .sharer-icons a.sharer-icon-facebook { color: #1877f2; border-color: #b7d4fb; }

		.share_news .sharer-icons a.sharer-icon-facebook:hover { background: #1877f2; color:#FFF }

		.share_news .sharer-icons a.sharer-icon-twitter { color: #46c1f6; border-color: #b6e7fc; }

		.share_news .sharer-icons a.sharer-icon-twitter:hover { background: #46c1f6; color:#FFF }

		.share_news .sharer-icons a.sharer-icon-linkedin { color: #1385c4; border-color: #89c6e7; }

		.share_news .sharer-icons a.sharer-icon-linkedin:hover { background: #1385c4; color:#FFF }

		.share_news .sharer-icons a.sharer-icon-pinterest { color: #f13434; border-color: #f9b7b7; }

		.share_news .sharer-icons a.sharer-icon-pinterest:hover { background: #f13434; color:#FFF }
.hnv_tour_detail_intro_suggest_share {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 10px;
    width: 100%;
}

/* Nút Share giữ nguyên */
.hnv_tour_detail_intro_suggest_share .icon_share {
    display: inline-flex;
    align-items: center;
    gap: 5px;

    flex: 0 0 auto;
    width: auto;
    height: auto;

    padding: 0;
    margin: 0;

    border: 0;
    background: transparent;
    box-shadow: none;

    white-space: nowrap;
    cursor: pointer;
}

/* Mặc định ẩn danh sách icon */
.hnv_tour_detail_intro_suggest_share .share_box {
    display: none;
    position: static;

    width: auto;
    margin: 0;
    padding: 0;

    background: transparent;
    border: 0;
    box-shadow: none;
}

/* Khi bấm Share */
.hnv_tour_detail_intro_suggest_share .share_box.open {
    display: flex;
    align-items: center;
}



/* Các icon bắt buộc nằm ngang */
.hnv_tour_detail_intro_suggest_share .sharer-icons {
    display: flex !important;
    flex-direction: row !important;
    flex-wrap: nowrap !important;
    align-items: center !important;
    justify-content: flex-start !important;

    gap: 10px !important;
    width: auto !important;

    margin: 0 !important;
    padding: 0 !important;
}

/* Từng icon */
.hnv_tour_detail_intro_suggest_share .sharer-icons > a,
.hnv_tour_detail_intro_suggest_share .sharer-icon {
    position: static !important;

    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;

    width: 36px !important;
    height: 36px !important;
    min-width: 36px !important;
    max-width: 36px !important;

    flex: 0 0 36px !important;
    float: none !important;

    margin: 0 !important;
    padding: 0 !important;

    border-radius: 50% !important;
}
.hnv_tour_detail_intro_suggest_share .icon_share {
    order: 2;
}

.hnv_tour_detail_intro_suggest_share .share_box {
    order: 1;
}
/* Chữ Share */
.hnv_tour_detail_intro_suggest_share_title,
.hnv_tour_detail_intro_suggest_share .share_box_title {
    display: flex;
    align-items: center;
    gap: 5px;
    white-space: nowrap;
    cursor: pointer;
    margin: 0;
}

/* Danh sách icon */
.hnv_tour_detail_intro_suggest_share .share_news {
    position: absolute;
    top: auto !important;
    right: 76px !important;
    left: auto !important;

    display: none;
    align-items: center;
    justify-content: flex-end;
    flex-direction: row;
    gap: 8px;

    padding: 0;
    margin: 0;
    background: transparent;
    border: 0;
    box-shadow: none;
    width: auto;
}

/* Khi mở share */
.hnv_tour_detail_intro_suggest_share .share_box.open .share_news,
.hnv_tour_detail_intro_suggest_share.open .share_news {
    display: flex !important;
}

/* Từng icon */
.hnv_tour_detail_intro_suggest_share .sharer-icon {
    width: 34px;
    height: 34px;
    min-width: 34px;

    display: inline-flex !important;
    align-items: center;
    justify-content: center;

    padding: 0;
    margin: 0;

    border: 1px solid #dfe3e8;
    border-radius: 50%;
    background: #fff;
    text-decoration: none;
    line-height: 1;
}

/* Kích thước biểu tượng */
.hnv_tour_detail_intro_suggest_share .sharer-icon i {
    font-size: 17px;
    line-height: 1;
}

/* Không để CSS cũ biến link thành block */
.hnv_tour_detail_intro_suggest_share .share_news > a {
    display: inline-flex !important;
}

/* Màu icon */
.hnv_tour_detail_intro_suggest_share .sharer-icon-facebook {
    color: #1877f2;
}

.hnv_tour_detail_intro_suggest_share .sharer-icon-twitter {
    color: #1da1f2;
}

.hnv_tour_detail_intro_suggest_share .sharer-icon-linkedin {
    color: #0a66c2;
}

.hnv_tour_detail_intro_suggest_share .sharer-icon-pinterest {
    color: #e60023;
}
/* Khối chứa các icon */
.share_news .sharer-icons{
    display:flex !important;
    flex-direction:row !important;
    flex-wrap:nowrap !important;
    align-items:center !important;
    justify-content:flex-start !important;
    gap:10px !important;
}

/* Các link icon */
.share_news .sharer-icons > a{
    display:inline-flex !important;
    align-items:center;
    justify-content:center;
    width:36px;
    height:36px;
    flex:0 0 36px;
    margin:0 !important;
}

/* Bỏ width:100% hoặc display:block của CSS cũ */
.share_news .sharer-icon{
    display:inline-flex !important;
    float:none !important;
    width:36px;
    height:36px;
}


		@media screen and (min-width:992px) {

			.share_detail_box {left: calc(((100vw - 960px)/2) - 50px);}

		}

		@media screen and (min-width:1100px) {

			.share_detail_box {left: calc(((100vw - 960px)/2) - 70px);}

		}



		@media screen and (min-width:1200px) {

			.share_detail_box {left: calc(((100vw - 1140px)/2) - 50px);}

		}

		@media screen and (min-width:1260px) {

			.share_detail_box {left: calc(((100vw - 1140px)/2) - 60px);}

		}

		@media screen and (min-width:1280px) {

			.share_detail_box {left: calc(((100vw - 1140px)/2) - 70px);}

		}

		@media screen and (min-width:1440px) {

			.share_detail_box {left: calc(((100vw - 1310px)/2) - 65px);}

		}

		@media screen and (min-width:1470px) {

			.share_detail_box {left: calc(((100vw - 1310px)/2) - 80px);}

		}

		@media screen and (max-width:1023px) {

			.share_detail_box {

				width: 50px;

				z-index: 1;

				position: fixed !important;

				top: calc(50% - 80px) !important;

				left: 0;

				background: #fff;

				padding-top: 10px;

			}
			.col-share span{display: none}

		}
	</style>

<script type="text/javascript">
	document.addEventListener("DOMContentLoaded", function () {
		   
		$(".sharer-icons").each(function(index){
			var link_share = $(this).data('link_share');
			var title_share = $(this).data('title_share');
			var description_share = $(this).data('description_share');
			$(this).empty().sharer({
			networks: ["facebook", "twitter", "linkedin", "pinterest"],
			url : DOMAIN_NAME+link_share,
			title : title_share,
			description : description_share,
		});
		});
		$(".icon_share").click(function() {
			$(".share_box").toggleClass('open');
		});
	})
</script>
{/literal} 