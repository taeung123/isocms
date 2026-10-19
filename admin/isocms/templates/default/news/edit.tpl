<link rel="stylesheet" href="{$URL_CSS}/jquery.autocomplete.css?v={$upd_version}" type="text/css" />
<script type="text/javascript" src="{$URL_JS}/jquery.autocomplete.min.js?v={$upd_version}"></script>
<div class="breadcrumb">
    <strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('news')}</a>
	<a>&raquo;</a>
	<a href="{$curl}" title="{$act}">{if $pvalTable}{$core->get_Lang('edit')} #{$pvalTable}{else}{$core->get_Lang('add')}{/if}</a>
    <!-- Back -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{if $pvalTable}{$clsClassTable->getTitle($pvalTable)}{else}{$core->get_Lang('Add New News')}{/if}</h2>
        {if $pvalTable}
        <div class="permalinkbox">
            <div class="wrap permalink_show">
                <strong><a href="{$DOMAIN_NAME}{$clsClassTable->getLink($pvalTable)}" target="_blank"><img align="absmiddle" src="{$URL_IMAGES}/v2/link.png" /> {$DOMAIN_NAME}{$clsClassTable->getLink($pvalTable)}</a></strong>
            </div>
        </div>
        {/if}
    </div>
    <div class="clearfix"><br /></div>
    <form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
        <div id="clienttabs">
            <ul>
                <li class="tabchild"><a href="#"><i class="iso-bassic"></i> {$core->get_Lang('generalinformation')}</a></li>
                {if $pvalTable}<li class="tabchild"><a href="#">{$core->get_Lang('seosdvanced')}</a></li>{/if}
            </ul>
        </div>
        <div class="clearfix"></div>
        <div id="tab_content">
            <div class="tabbox" style="display:block">
                <div class="wrap">
					<div class="fl col_Left full_width_767">
						<div class="photobox image">
                            {if $_isoman_use eq '1'}
                                <img src="{$oneItem.image}" alt="Hình ảnh" id="isoman_show_image" />
                                <input type="hidden" id="isoman_hidden_image" name="isoman_url_image" value="{$oneItem.image}" />
                                <a href="javascript:void()" title="Thay đổi" class="photobox_edit ajOpenDialog" isoman_for_id="image" isoman_val="{$oneItem.image}" isoman_name="image"><i class="iso-edit"></i></a>
                                {if $oneItem.image}
                                    <a pvalTable="{$pvalTable}" clsTable="News" href="javascript:void()" title="Xóa" class="photobox_edit deleteItemImage" data-name_input="isoman_url_image" g="imgItem">X</a>
                                {/if}
                            {else}
                                <img src="{$oneItem.image}" alt="Chưa có hình ảnh" id="imgTestimonial_image" />
                                <input type="hidden" name="image_src" value="" class="hidden_src" id="imgTestimonial_hidden" />
                                <a href="javascript:void()" title="{$_lang->get_Lang('Change')}" class="photobox_edit editInlineImage" g="imgTestimonial">
                                    <i class="iso-edit"></i>
                                </a>
                                <input type="file" style="display:none" id="imgTestimonial_file" g="imgTestimonial" class="editInlineImageFile" name="image" />
                            {/if}
                        </div>
                        <div class="photobox image" style="height: 90px;margin-top: 30px;">
                            {if $_isoman_use eq '1'}
                                <img src="{$oneItem.logo_news}" alt="Hình ảnh" id="isoman_show_logo_news" />
                                <input type="hidden" id="isoman_hidden_logo_news" name="isoman_url_logo_news" value="{$oneItem.logo_news}" />
                                <a href="javascript:void()" title="Thay đổi" class="photobox_edit ajOpenDialog" isoman_for_id="logo_news" isoman_val="{$oneItem.logo_news}" isoman_name="logo_news"><i class="iso-edit"></i></a>
                                {if $oneItem.logo_news}
                                    <a pvalTable="{$pvalTable}" clsTable="News" href="javascript:void()" title="Xóa" class="photobox_edit deleteItemImage" data-name_input="isoman_url_logo_news" g="imgItem">X</a>
                                {/if}
                            {else}
                                <img src="{$oneItem.logo_news}" alt="Chưa có hình ảnh" id="imgTestimonial_logo_news" />
                                <input type="hidden" name="logo_news_src" value="" class="hidden_src" id="imgTestimonial_hidden" />
                                <a href="javascript:void()" title="{$_lang->get_Lang('Change')}" class="photobox_edit editInlineImage" g="imgTestimonial">
                                    <i class="iso-edit"></i>
                                </a>
                                <input type="file" style="display:none" id="imgTestimonial_file" g="imgTestimonial" class="editInlineImageFile" name="logo_news" />
                            {/if}
                        </div>
                        <p>Logo</p>
                    </div>
					<div class="fr col_Right full_width_767">
                        <div class="row-span">
                            <div class="fieldlabel bold">{$core->get_Lang('title')} <span class="color_r">* </span></div>
                            <div class="fieldarea">
                                <input class="text full required" name="iso-title" value="{$clsClassTable->getTitle($pvalTable)}" maxlength="255" type="text">
                            </div>
                        </div>
                       {if $clsISO->getCheckActiveModulePackage($package_id,$mod,'category','default')}
						<div class="row-span">
							<div class="fieldlabel bold">{$core->get_Lang('category')} <span class="color_r">* </span></div>
							<div class="fieldarea">
								<select name="iso-newscat_id" class="slb required" style="width:300px;padding:4px">
									{$clsNewsCategory->makeSelectboxOption($newscat_id)}
								</select>
							</div>
						</div>
                        {/if}
                        <div class="row-span">
                            <div class="fieldlabel bold">{$core->get_Lang('status')}</div>
                            <div class="fieldarea">
							<div class="checkbox-switch">
								{if $clsClassTable->getOneField("is_online",$pvalTable) eq 1}
								<input type="checkbox" checked value="1" name="is_online" class="input-checkbox" id="toolbar-active">
								{else}
								<input type="checkbox" value="1" name="is_online" class="input-checkbox" id="toolbar-active">
								{/if}
								<div class="checkbox-animate">
									<span class="checkbox-off">PRIVATE</span>
									<span class="checkbox-on">PUBLIC</span>
								</div>
							</div>	
							<span class="notice" id="prv_status" {if $clsClassTable->getOneField("is_online",$pvalTable) eq 1}style="display:none;"{/if}>PRIVATE: {$core->get_Lang('This article can only be seen via the link in the admin page')}.</span>
							<span class="notice" id="pub_status" {if $clsClassTable->getOneField("is_online",$pvalTable) eq 0}style="display:none;"{/if}>PUBLIC: {$core->get_Lang('This article is available online show normal status')}.</span>
						</div>
                        </div>
						{if $pvalTable gt 0 and $clsISO->getCheckActiveModulePackage($package_id,$mod,'tag','customize')}
						<div class="row-span">
							<div class="fieldlabel bold">{$core->get_Lang('Tags')}</div>
							<div class="fieldarea">
								<input type="text" name="list_tag_id" id="tags-input" value="{$clsTag->getTagsListText($classTable,$pvalTable)}" data-role="tagsinput" placeholder="{$core->get_Lang('Add new tag')}" />
							</div>
						</div>
						{literal}
						<script type="text/javascript">
							$('#tags-input').tagsinput({
								allowDuplicates: true,
								confirmKeys: [13, 188]
							});
							$('.bootstrap-tagsinput input[type=text]').keypress(function(e){
								var keyCode = e.which || e.keyCode;
								if (keyCode == '13') {
								  e.preventDefault();
								}
							});
						</script>
						<style>
							.bootstrap-tagsinput{width: 100%}
							.bootstrap-tagsinput span{font-size: 14px}
						</style>
						{/literal}
						{/if}
                    </div>
                </div>
				<div class="wrap mt30">
					{if $clsISO->getBrowser() eq 'computer'}
					<div id="v-nav">
						<ul>
							<li class="tabchildcol first current"><a href="javascript:void(0);"><strong>{$core->get_Lang('Short text')}</strong></a> <span class="color_r">*</span></li>
							<li class="tabchildcol"><a href="javascript:void(0);"><strong>{$core->get_Lang('Long text')}</strong></a> <span class="color_r">*</span></li>
						</ul>
						<div class="tab-content" style="display: block;">
							<div class="format-setting-wrap">
								 {$clsForm->showInput('intro')}
							</div>
						</div>
						<div class="tab-content" style="display: none;">
							<div class="format-setting-wrap">
								 {$clsForm->showInput('content')}
							</div>
						</div>
					</div>
					{else}
					<div id="v-nav">
						<div class="row-span">
                            <div class="fieldlabel bold">{$core->get_Lang('Short text')}</div>
                            <div class="fieldarea">
								 {$clsForm->showInput('intro')}
							</div>
						</div>
						<div class="row-span">
                            <div class="fieldlabel bold">{$core->get_Lang('Long text')}</div>
                            <div class="fieldarea">
								{$clsForm->showInput('content')}
							</div>
						</div>
					</div>
					{/if}
            	</div>
            </div>
            {if $pvalTable}
            <div class="tabbox" style="display:none">
                {$core->getBlock('meta_box_detail')}
            </div>
            {/if}
        </div>
        <div class="clearfix"><br /></div>
        <fieldset class="submit-buttons">
            {$saveBtn}{$saveList}
            <input value="Update" name="submit" type="hidden" />
        </fieldset>
    </form>
</div>
<script type="text/javascript">
var $type = '_NEWS';
var $SiteHasTags_News = "{$clsISO->getCheckActiveModulePackage($package_id,$mod,'tag','customize')}";
</script>
<link rel="stylesheet" href="{$URL_CSS}/chosen.css?v={$upd_version}" type="text/css" media="all">
<script type="text/javascript" src="{$URL_JS}/chosen.jquery.js?v={$upd_version}"></script>
<script type="text/javascript" src="{$URL_THEMES}/news/jquery.news.js?v={$upd_version}"></script>