<div class="iso_box_setting">
    <div class="iso_box_head">
        <div class="iso_box_head d-flex justify-content-between">
            <div class="iso_box_title">
                <h1> {$core->get_Lang('emailtemplate')} </h1>
                <span>{$core->get_Lang('Create and save email templates instantly to save time, send emails completely automatically')}</span>
             </div>
             <div class="iso_box_button">
                 <a href="{$PCMS_URL}/?mod=email_template&act=edit_2024" class="iso_btn_add" title="{$core->get_Lang('Add')} {$core->get_Lang('emailtemplate')}">{$core->get_Lang('Add')} {$core->get_Lang('emailtemplate')}</a>
             </div>
        </div>
        <form method="GET" class="iso_filter_form">								
            <div class="d-flex align-items-center iso_filter_box">
                <select name="email_cat_id" class="iso_filter_select">
                    <option value="0">{$core->get_Lang('Category')}</option>
                    {section name=i loop=$lstEmailTemplateCat}
                        <option {if $email_cat_id eq $lstEmailTemplateCat[i].email_template_cat_id}selected="selected"{/if} value="{$lstEmailTemplateCat[i].email_template_cat_id}">
                            {$clsEmailTemplateCat->getTitle($lstEmailTemplateCat[i].email_template_cat_id)}
                        </option>
                    {/section}
                </select>
                <button type="submit" class="iso_filter_btn" >Tìm kiếm</button>
            </div>
        </form>
    </div>
    <div class="iso_box_body">
        <table class="table tbl-grid table-striped table_responsive" border="1"> 
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
                            <button class="btn btn_dropdown dropdown-toggle" type="button" data-toggle="dropdown">
                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a title="{$core->get_Lang('edit')}" href="{$PCMS_URL}/index.php?mod=email_template&act=edit_2024&email_template_id={$core->encryptId($lstEmailTemplate[j].email_template_id)}"><i class="icon-pencil"></i> <span>{$core->get_Lang('edit')}</span></a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                {/section}
            </tbody>
            {/if}
            {/section}
        </table>
    </div>
</div>