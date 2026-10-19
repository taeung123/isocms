{literal}
<style>
#vietiso_sitebadgecontainer{-moz-border-bottom-colors:none;-moz-border-left-colors:none;-moz-border-right-colors:none;-moz-border-top-colors:none;background:none repeat scroll 0 0 #0c5b8b;border-bottom:2px solid #f79c1e;border-bottom-right-radius:10px;border-image:none;border-left:medium none!important;border-right:2px solid #f79c1e;border-top:2px solid #f79c1e;border-top-right-radius:10px;display:inline-block;left:-180px;position:fixed;top:65%;width:230px;z-index:9999999999!important;padding:5px;}
.sitebadge{border-right:1px solid #E7E7E7;max-height:200px;float:left; overflow-y:scroll; overflow-x:hidden;width:180px;padding:10px 8px;}
.sitebadge a.skype{background:url(/isocms/templates/default/skin/images/skype-icon.png) no-repeat scroll left center transparent;color:#fff;display:block;height:21px;line-height:23px;text-align:left;text-decoration:none;width:115px;margin:16px 0 0;padding:0 0 0 25px;font-size:13px}
.sitebadge a.yahoo{background:url(/isocms/templates/default/skin/images/yahoo_chat.png) no-repeat scroll 0 center transparent;color:#fff;display:block;height:21px;line-height:23px;text-align:left;text-decoration:none;width:155px;margin:16px 0 0;padding:0 0 0 25px; font-size:13px}
/*.sitebadge p{background:url(/isocms/template/default/skin/images/hotline.png) no-repeat scroll left center transparent;color:#fff;display:block;height:21px;line-height:21px;text-align:left;margin:16px 0 0;padding:0 0 0 25px;}
*/.sitebadge h2{color:#F58220;display:block;font-size:15px;height:24px;line-height:24px;text-align:center;width:100%;margin:12px 0 0;padding:0;}
.sitebadgeButton{display:block;float:right;width:30px;}
.sitebadgeButton span{background:url(/isocms/templates/default/skin/images/badge_livehelp_en_white.png) no-repeat scroll center center transparent;display:block;height:100%;width:30px;}
</style>
<script type="text/javascript">
$().ready(function(){
	if($('#vietiso_sitebadgecontainer').length > 0){
		$('#vietiso_sitebadgecontainer').hover(function(){
			$('#vietiso_sitebadgecontainer').stop().animate({left:'0px'},500);
		},function(){
			$('#vietiso_sitebadgecontainer').stop().animate({left:'-158px'},500);
		});
		setMinHeight('group_col');
	}
});
function setMinHeight(class_name){
	var min_height = 0;
	$('.'+class_name).each(function(){
		if($(this).height()>min_height) min_height = $(this).height();
	});
	if(min_height<200){
		min_height = 200;
	}
	$('.'+class_name).eq(1).css('height',min_height); 
}
</script>
{/literal}
<div id="vietiso_sitebadgecontainer" style="left:-185px;">
  <div class="sitebadge group_col" style="z-index: 990;">
    {if $listYahoo[0].online_support_id ne ''}
    {section name=i loop=$listYahoo} 
    <a {if $smarty.section.i.first}style="margin-top:0"{/if} href="ymsgr:SendIM?{$listYahoo[i].nick}&amp;m=Hello {$listYahoo[i].title}" title="Support online {$listYahoo[i].name}" class="yahoo">{$listYahoo[i].title}</a> 
    {/section}
    {/if}
    {if $lstSkype[0].online_support_id ne ''}
    {section name=i loop=$lstSkype} 
    <a href="skype:{$lstSkype[i].nick}?call" title="{$lstSkype[i].title}" class="skype">{$lstSkype[i].title}</a> 
    {/section}
    {/if}
    {if $lstPhone[0].online_support_id ne ''}
    {section name=i loop=$lstPhone} 
    <p>{$lstPhone[i].nick}</p> 
    {/section}
    {/if}
  </div>
  <a class="sitebadgeButton group_col" rel="nofollow" id="sitebadgeButton"> <span></span> </a> 
</div>
{if $clsOnlineSupport->checkOnlineAvaiable()}{/if}