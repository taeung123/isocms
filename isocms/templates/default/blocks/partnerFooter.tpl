<div class="box_Partner">
	<div class="container">
		<h3 class="text_bold mb30 text_upper text_center">{$core->get_Lang('Đối tác của chúng tôi')}</h3>
		<div id="boxPartner" class="boxPartner">
			<div class="slideMain" style="height:85px">
				<ul class="slide1" style="height:85px;padding:0">
					<li>
					{section name=i loop=$lstPartner}
					{assign var=title value=$lstPartner[i].title}
					<div class="item">
						<a href="{$clsPartner->getLink($lstPartner[i].partner_id)}" target="_blank"><img title="{$title}" src="{$clsPartner->getImage1($lstPartner[i].partner_id)}" height="auto" width="auto"/></a>
					</div>
					{/section}	    
					 </li>
				 </ul>
			 </div>
		</div>
	</div>
</div>
<script src="{$URL_JS}/jquery.partner.js?v={$upd_version}"></script>
<script type="text/javascript">
var $width_slide_panner = '{$width_slide_panner}';
</script>
{literal}
<style type="text/css">
.box_Partner{padding:40px 0 20px;background:inherit}
.box_Partner h3{font-size:27px}
.boxPartner{width:100%; max-width:950px;overflow:hidden;position:relative;margin:0 auto;height:85px;overflow:hidden;display:block}
.boxPartner li{list-style:none;height:85px}
.boxPartner ul{margin:0}
.boxPartner li .item{width:130px;height:85px;display:inline-block;text-align:center;padding:10px;background:#fff;border:1px solid #ccc;border-radius:0;margin-right:10px;vertical-align:top;float:left;position:relative}
.boxPartner li .item img{display:inline-block;max-width:100%;margin:auto;position:absolute;z-index:1;top:50%;left:50%;-webkit-transform:translate(-50%,-50%);-khtml-transform:translate(-50%,-50%);-moz-transform:translate(-50%,-50%);-ms-transform:translate(-50%,-50%);-o-transform:translate(-50%,-50%);transform:translate(-50%,-50%);max-height:100%}
.boxPartner .mainPartner{width:100%;height:130px;overflow:hidden;border:0}
.boxPartner .mainPartner li{height:128px;display:inline-block;float:left}
@media screen and (max-width: 600px) {
.box_Partner h3 {font-size: 21px;}
}
</style> 
<script type="text/javascript">
$(function(){
	var $ww = $(window).width();
	$('#boxPartner .slide1').width($width_slide_panner);
	$('#boxPartner .slide2').width($width_slide_panner);
	$("#boxPartner").rotate({
		speed : 20
	});
});
</script>
{/literal}