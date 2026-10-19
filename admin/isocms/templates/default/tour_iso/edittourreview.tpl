<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('reviewstour')}</a>
    <a>&raquo;</a>
    <a href="{$curl}" title="{$act}">{if $pvalTable}{$core->get_Lang('edit')} #{$pvalTable}{else}{$core->get_Lang('add')}{/if}</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{if $pvalTable}{$clsClassTable->getTitle($pvalTable)}{else}{$core->get_Lang('Add New Review Tours')}{/if}</h2>
        <p>{$core->get_Lang('Please enter all required fields')}</p>
    </div>
	<div class="clearfix"></div>
    <form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
    	<div id="clienttabs">
            <ul>
                <li class="tabchild"><a href="#"><i class="iso-bassic"></i> {$core->get_Lang('generalinformation')}</a></li>
            </ul>
        </div>
        <div class="clearfix"></div>
        <div id="tab_content">
        	<div class="tabbox" style="display:block">
                <div class="wrap">
                	 <div class="photobox fl mr20 image">
                        {if $_isoman_use eq '1'}
                        	<img src="{$oneItem.image}" alt="{$core->get_Lang('images')}" id="isoman_show_image" />
                            <input type="hidden" id="isoman_hidden_image" name="isoman_url_image" value="{$oneItem.image}" />
                            <a href="javascript:void()" title="{$core->get_Lang('change')}" class="photobox_edit ajOpenDialog" isoman_for_id="image" isoman_val="{$oneItem.image}" isoman_name="image"><i class="iso-edit"></i></a>
                            {if $oneItem.image}
                            <a pvalTable="{$pvalTable}" clsTable="TourReview" href="javascript:void()" title="{$core->get_Lang('delete')}" class="photobox_edit deleteItemImage" g="imgItem">X</a>
                            {/if}
                        {else}
                            <img src="{$oneItem.image}" alt="{$core->get_Lang('noimages')}" id="imgTestimonial_image" />
                            <input type="hidden" name="image_src" value="" class="hidden_src" id="imgTestimonial_hidden" />
                            <a href="javascript:void()" title="{$core->get_Lang('Change')}" class="photobox_edit editInlineImage" g="imgTestimonial">
                                <i class="iso-edit"></i>
                            </a> 
                            <input type="file" style="display:none" id="imgTestimonial_file" g="imgTestimonial" class="editInlineImageFile" name="image" />
                        {/if}
                    </div>
                    <div class="fl span75">
                    	<div class="row-span">
                        	<div class="fieldlabel bold"><u class="color_r">* {$core->get_Lang('title')}</u></div>
                            <div class="fieldarea">
                            	<input class="text full required" name="iso-title" value="{$clsClassTable->getTitle($pvalTable)}" maxlength="255" type="text">
                            </div>
                        </div>
                        <div class="row-span">
                        	<div class="fieldlabel bold"><u class="color_r">* {$core->get_Lang('fullname')}</u></div>
                            <div class="fieldarea">
                            	<input class="text full required" name="iso-fullname" value="{$clsClassTable->getFullName($pvalTable)}" maxlength="255" type="text">
                            </div>
                        </div>
                        <div class="row-span">
                        	<div class="fieldlabel bold"><u class="color_r">* {$core->get_Lang('national')}</u></div>
                            <div class="fieldarea">
                                <select name="iso-country_id" class="glSlBox required" style="width:60%">
                                    {section name=i loop=$listCountry}
                                    <option {if $oneItem.country_id eq $listCountry[i].country_id}selected="selected"{/if} value="{$listCountry[i].country_id}">{$clsCountry->getTitle($listCountry[i].country_id)}</option>
                                    {/section}
                                </select>
                            </div>
                        </div>
                        <div class="row-span">
                            <div class="fieldlabel bold"><u class="color_r">* {$core->get_Lang('status')}</u></div>
                            <div class="fieldarea">
                            <div class="vietiso_status_button"></div>
                            <script type="text/javascript">
                                var is_online = '{$clsClassTable->getOneField("is_online",$pvalTable)}';
                            </script>
                            {literal}
                            <script type="text/javascript">
                                $(document).ready(function(){
                                    $('.vietiso_status_button').isoswitchvalue({
                                        _value:is_online,
                                        _selector:'iso-is_online'
                                    });
                                });
                            </script>
                            {/literal}
                            <span class="notice" id="prv_status" {if $clsClassTable->getOneField("is_online",$pvalTable) eq 1}style="display:none;"{/if}>PRIVATE: {$core->get_Lang('This article can only be seen via the link in the admin page')}.</span>
                            <span class="notice" id="pub_status" {if $clsClassTable->getOneField("is_online",$pvalTable) eq 0}style="display:none;"{/if}>PUBLIC: {$core->get_Lang('This article is available online show normal status')}</span>
                            </div>
                        </div>
                        <div class="row-span">
                        	<div class="fieldlabel bold"><u class="color_r">* {$core->get_Lang('tourtravelled')}</u></div>
                        	<div class="fieldarea requiredMask">
                            	<strong id="tourTitle">
                                	{if $tour_id}{$clsTour->getTitle($tour_id)}{else}{$core->get_Lang('Not Data')}!{/if}
                                </strong>
                            	<div class="clearfix"></div>
                                <input placeholder="{$core->get_Lang('Enter the name you want to find tour')}" id="searchkey" type="text" class="text full" maxlength="255" style="width:95%" tabindex="4" /> <a class="btn_empty_search" title="{$core->get_Lang('Close')}" style="display:inline-block; cursor:pointer;vertical-align:middle"><i class="icon-upload"></i></a>
                                <ul class="listSearchQuick" id="quickSearch" style="display:none"></ul>
                            </div>
                        </div>
                        <div class="row-span">
                        	<span class="notice">{$core->get_Lang('content')}.</span>
                        	{$clsForm->showInput('content')}
                        </div>
                    </div>
                </div>
        	</div>
        </div>
        <div class="clearfix"><br /></div>
        <fieldset class="submit-buttons">
            {$saveBtn}{$saveList}
            <input type="hidden" id="tourIdKey" name="iso-tour_id" value="{$tour_id}" />
            <input value="Update" name="submit" type="hidden">
        </fieldset>
    </form>
</div>
<script type="text/javascript">
	var path_ajax_script = '{$PCMS_URL}';
	var tour_review_id = '{$pvalTable}';
</script>
{literal}
<script type="text/javascript">
	var aj_search = '';
	$(document).ready(function(){
		$("#searchkey").keyup(function(){
			var _this = $(this);
			if(_this.val()!=''){
				clearTimeout(aj_search);	
				search_tour();
			}else{
				$("#quickSearch").hide();	
			}
		});
		$(document).on('click', '.clickChooiseTour', function(ev){
			var $_this = $(this);
			var $tour_id = $_this.attr('data');
			vietiso_loading(1);
			$.ajax({
				type:'POST',	
				url:path_ajax_script+'/index.php?mod='+mod+'&act=ajUpdateTourGlobal',	
				data: {
					'tour_review_id': tour_review_id,
					'tour_id': $tour_id
				},	
				dataType:'html',	
				success:function(html){
					vietiso_loading(0);
					if(html.indexOf('_SUCCESS')>=0){
						$_this.remove();
						$('#tourTitle').text($_this.text());
						$('#tourIdKey').val($tour_id);
					}
				}
			});
		});
	});
	function search_tour(){
		aj_search = setTimeout(function(){
			$.ajax({
				type:'POST',	
				url:path_ajax_script+'/index.php?mod='+mod+'&act=ajGetSearch',	
				data:{
					"keyword":$("#searchkey").val()
				},	
				dataType:'html',	
				success:function(html){
					$("#quickSearch").show().html(html);	
				}
			});
		},500);
	}
</script>
{/literal}