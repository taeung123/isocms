<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')}:</strong>
	<a href="{$PCMS_URL}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}?mod=email_template">{$core->get_Lang('emailtemplate')}</a>
	<!-- Back -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="page_container">
	<div class="page-title d-flex">
        <div class="title">
			<h2>{$core->get_Lang('emailtemplate')} <div class="info_module" data-toggle="tooltip" data-placement="right" title="Chức năng quản lý danh sách các {$core->get_Lang('emailtemplate')} trong hệ thống isoCMS">i</div>
			</h2>
			{assign var = setting value = 'SiteIntroModule_'|cat:$mod|cat:'_'|cat:$_LANG_ID}
			{if $clsConfiguration->getValue($setting) ne ''}
			<p>{$clsConfiguration->getValue($setting)|html_entity_decode}</p>
			{/if}
		</div>
		<div class="button_right">
			<a href="{$PCMS_URL}/?mod={$mod}&act=edit" class="btn btn-main btn-addnew" title="{$core->get_Lang('Add')} {$core->get_Lang('emailtemplate')}">{$core->get_Lang('Add')} {$core->get_Lang('emailtemplate')}</a>
		</div>
    </div>
	<div class="container-fluid">
		<div class="clearfix"></div>
		<div class="wrap mt30">
            <div class="filter_box">
				<form id="forums" method="post" class="filterForm" action="">
					{*<div class="form-group form-keyword">
						<input class="form-control" type="text" name="keyword" value="{$keyword}" placeholder="{$core->get_Lang('search')}..." />
					</div>*}
					
					<div class="form-group form-country">
						<select name="email_cat_id" class="form-control" data-width="100%" id="slb_country">
                            <option value="0">{$core->get_Lang('Category')}</option>
							 {section name=i loop=$lstEmailTemplateCat}
                            <option {if $email_cat_id eq $lstEmailTemplateCat[i].email_template_cat_id}selected="selected"{/if} value="{$lstEmailTemplateCat[i].email_template_cat_id}">{$clsEmailTemplateCat->getTitle($lstEmailTemplateCat[i].email_template_cat_id)}</option>
                            {/section}
						</select>
					</div>
					<div class="form-group form-button">
						<button type="submit" class="btn btn-main" id="findtBtn">Tìm kiếm</button>
						<input type="hidden" name="filter" value="filter" />
					</div>
					<div class="form-group form-button hidden">
						<button type="button" class="btn btn-export" id="btn_export">Export</button>
					</div>
				</form>	
			</div>
			<table class="table tbl-grid table-striped table_responsive">
				<thead>
					<tr>
						<th class="gridheader hiden767">ID</th>
						<th class="gridheader text-left name_responsive full-w767">{$core->get_Lang('Name')}</th>
						<th class="gridheader text-left hiden767">{$core->get_Lang('Group')}</th>
						<th class="gridheader text-left hiden767">{$core->get_Lang('LastUpdated')}</th>
						<th class="gridheader text-left hiden767">{$core->get_Lang('UpdateBy')}</th>
						<th class="gridheader text-left hiden767"></th>
					</tr>
				</thead>
				{section name=i loop=$lstCat}
				{assign var=lstEmailTemplate value=$clsClassTable->getListEmailTemplate($lstCat[i].email_template_cat_id)}
				{if $lstEmailTemplate}
				<tbody>
					{section name=j loop=$lstEmailTemplate}
					<tr class="{cycle values="row1,row2"}">
						<td class="text-center hiden767">{$lstEmailTemplate[j].email_template_id}</td>
						<td class="name_service title_td1">{$clsClassTable->getTitle($lstEmailTemplate[j].email_template_id)|truncate:60}
						<button type="button" class="toggle-row inline_block767" style="display:none"><i class="fa fa-caret fa-caret-down"></i></button></td>
						<td class="block_responsive" data-title="{$core->get_Lang('Group')}">{$lstCat[i].title}</td>
						<td class="block_responsive" data-title="{$core->get_Lang('LastUpdated')}">{$lstEmailTemplate[j].upd_date|date_format:"%d/%m/%Y"}</td>
						<td class="block_responsive" data-title="{$core->get_Lang('UpdateBy')}">{$clsUser->getOneField('user_name',$lstEmailTemplate[j].user_id_update)} </td>
						<td class="block_responsive text-center" style="white-space:nowrap;" data-title="{$core->get_Lang('func')}">
							<div class="btn-group">
								<button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
									<i class="fa fa-ellipsis-v" aria-hidden="true"></i>
								</button>
								<ul class="dropdown-menu dropdown-menu-end">
									<li>
										<a title="{$core->get_Lang('edit')}" href="{$PCMS_URL}/index.php?mod={$mod}&act=edit&email_template_id={$core->encryptId($lstEmailTemplate[j].email_template_id)}" class="dropdown-item">
											<i class="icon-pencil"></i> {$core->get_Lang('edit')}
										</a>
									</li>
								</ul>
							</div>
						</td>
					</tr>
					{/section}
				</tbody>


					{if 1==2}
					<div class="wrap">
					{if $smarty.section.i.first}
					<h2 style="font-size:20px;">{$lstCat[i].title}</h2>
					{else}
					<h2 style="font-size:18px; margin:30px 0 5px 0">{$lstCat[i].title}</h2>
					{/if}
					<div class="row">
					{section name=j loop=$lstEmailTemplate}
					<div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 full_width_600">
					<div class="emailtplstandard full-width">
					<a href="{$PCMS_URL}/index.php?mod={$mod}&act=edit&email_template_id={$core->encryptId($lstEmailTemplate[j].email_template_id)}" id="{if 1 eq 1}({$lstEmailTemplate[j].email_template_id}){/if}"><img align="top" src="{$URL_IMAGES}/massmail.png" /> {$clsClassTable->getTitle($lstEmailTemplate[j].email_template_id)|truncate:50}
					</a>
					</div>
					</div>
					{/section}
					</div>
					</div>
					{/if}
				{/if}
				{/section}
			</table>
		</div>
	</div>
</div>