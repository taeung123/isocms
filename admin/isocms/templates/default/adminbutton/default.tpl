<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')}:</strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$core->get_Lang('adminbuttons')}">{$core->get_Lang('adminbuttons')}</a>
	<!-- Back -->
    <a href="javascript:history.back();" class="back fr">{$core->get_Lang('Back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{$core->get_Lang('Admin Buttons')}</h2>
		{assign var = setting value = 'SiteIntroModule_'|cat:$mod|cat:'_'|cat:$_LANG_ID}
		{if $clsConfiguration->getValue($setting) ne ''}
        <p>{$clsConfiguration->getValue($setting)|html_entity_decode}</p>
		{/if}
    </div>
    <p><b>{$core->get_Lang("options")}:</b> <a href="{$PCMS_URL}/?mod={$mod}&act=edit{if $_type ne ''}&_type={$_type}{/if}">{$core->get_Lang("Add New")}</a></p>
    <p>
    	<strong>{$core->get_Lang('Filter By Admin Buttons Type')}</strong>: 
        <a href="{$PCMS_URL}/?mod={$mod}&_type=_HOME" style="{if $_type eq '_HOME'}font-weight:bold;{/if}">_HOME</a> | 
        <a href="{$PCMS_URL}/?mod={$mod}&_type=_TOP" style="{if $_type eq '_TOP'}font-weight:bold;{/if}">_TOP</a> | 
        <a href="{$PCMS_URL}/?mod={$mod}&_type=_LEFT" style="{if $_type eq '_LEFT'}font-weight:bold;{/if}">_LEFT</a> |
        <a href="{$PCMS_URL}/?mod={$mod}&_type=_SETTING" style="{if $_type eq '_SETTING'}font-weight:bold;{/if}">_SETTING</a>
    </p>
	<div class="infobox">
		<b>Ghi chú</b><br />
		<p>Phân hệ này chỉ ch phép nhà phát triển được phép truy cập</p>
	</div>
    <div class="hastable mt20">
        <table width="100%" cellspacing="0" class="tbl-grid table-striped table_responsive">
        <thead>
        	<tr>
                <th class="gridheader" style="text-align:center; width:30px;"><strong>{$core->get_Lang('No.')}</strong></th>
                <th class="gridheader" style="text-align:left;"><strong>{$core->get_Lang('Name')}</strong></th>
                <th class="gridheader" style="text-align:left;"><strong>{$core->get_Lang('Mod')}</strong></th>
                <th class="gridheader" style="text-align:left;"><strong>{$core->get_Lang('Act')}</strong></th>
                <th class="gridheader" style="text-align:left;"><strong>{$core->get_Lang('URL')}</strong></th>
				<th class="gridheader" style="width:6%;"><strong>{$core->get_Lang('Public')}</strong></th>
                <th class="gridheader" style="text-align:left;"><strong>{$core->get_Lang('Icon')}</strong></th>
                <th class="gridheader"><strong>Action</strong></th>
            </tr>
         </thead>
            <tbody id="SortAble">
            {section name=i loop=$allItem}
			
            <tr style="cursor:move" class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}" id="order_{$allItem[i].adminbutton_id}">
                <td class="index">
                    {$smarty.section.i.index+1}
                </td>
                <td class="posts column-posts num">
                    <a title="Sửa" href="{$PCMS_URL}/?admin&mod={$mod}&act=edit&adminbutton_id={$core->encryptID($allItem[i].adminbutton_id)}"><strong>{$allItem[i].title_page}</strong></a>
                </td>
                <td class="posts column-posts num">
                    {$allItem[i].mod_page}
                </td>
                <td class="posts column-posts num">
                    {$allItem[i].act_page}
                </td>
                <td class="posts column-posts num">
                    {$allItem[i].url_page}
                </td>
				<td style="text-align:center">
					<a href="javascript:void(0);" class="SiteClickPublic" clsTable="AdminButton" pkey="{$pkeyTable}" sourse_id="{$allItem[i].$pkeyTable}" toField="is_active" rel="{$clsClassTable->getOneField('is_active',$allItem[i].$pkeyTable)}" title="{$core->get_Lang('Click to change status')}">
						{if $clsClassTable->getOneField('is_active',$allItem[i].$pkeyTable) eq '1'}
                        <i class="fa-solid fa-circle-check green"></i>
						{else}
                        <i class="fa-solid fa-circle-minus red"></i>
						{/if}
					</a>
				</td>
                <td class="posts column-posts num">
                    <img src="{$allItem[i].image}" width="32px" />
                </td>
                <td style="vertical-align: top; width: 30px; text-align: right; white-space: nowrap;">
					<div class="btn-group">
                        <button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a title="Sửa" 
                                href="{$PCMS_URL}/?admin&mod={$mod}&act=edit&adminbutton_id={$core->encryptID($allItem[i].adminbutton_id)}" 
                                class="dropdown-item">
                                <i class="icon-edit"></i> {$core->get_Lang('edit')}
                                </a>
                            </li>
                            <li>
                                <a class="confirm_delete dropdown-item" 
                                title="{$core->get_Lang('delete')}" 
                                href="{$PCMS_URL}/?admin&mod={$mod}&act=delete&adminbutton_id={$core->encryptID($allItem[i].adminbutton_id)}&_type={$_type}">
                                <i class="icon-trash"></i> {$core->get_Lang('delete')}
                                </a>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>	
                {assign var=id value=$allItem[i].adminbutton_id}
                {assign var=listChild value=$clsClassTable->getAll("is_trash=0 and is_group=0 and parent_id='$id' order by order_no asc")}
                {section name=j loop=$listChild}
                <tr style="cursor:move" class="{if $smarty.section.j.index%2 eq 0}row1{else}row2{/if}" id="order_{$listChild[j].adminbutton_id}">
                    <td class="text-center">|_</td>
                    <td class="posts column-posts num">
                        {$smarty.section.j.iteration}. <a title="Sửa" href="{$PCMS_URL}/?admin&mod={$mod}&act=edit&adminbutton_id={$core->encryptID($listChild[j].adminbutton_id)}"><strong>{$listChild[j].title_page}</strong></a>
                    </td>
                    <td class="posts column-posts num">
                        {$listChild[j].mod_page}
                    </td>
                    <td class="posts column-posts num">
                        {$listChild[j].act_page}
                    </td>
                    <td class="posts column-posts num">
                        {$listChild[j].url_page}
                    </td>
					<td style="text-align:center">
						<a href="javascript:void(0);" class="SiteClickPublic" clsTable="AdminButton" pkey="{$pkeyTable}" sourse_id="{$listChild[j].$pkeyTable}" toField="is_active" rel="{$clsClassTable->getOneField('is_active',$listChild[j].$pkeyTable)}" title="{$core->get_Lang('Click to change status')}">
							{if $clsClassTable->getOneField('is_active',$listChild[j].$pkeyTable) eq '1'}
							<i class="fa-solid fa-circle-check green"></i>
							{else}
							<i class="fa-solid fa-circle-minus red"></i>
							{/if}
						</a>
					</td>
                    <td class="posts column-posts num">
                        <img src="{$listChild[j].image}" width="24px" />
                    </td>
                    <td style="vertical-align: top; width: 30px; text-align: right; white-space: nowrap;">
                        <div class="btn-group">
                            <button class="btn btn_dropdown dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a title="Sửa" 
                                    href="{$PCMS_URL}/?admin&mod={$mod}&act=edit&adminbutton_id={$core->encryptID($listChild[j].adminbutton_id)}" 
                                    class="dropdown-item">
                                    <i class="icon-edit"></i> {$core->get_Lang('edit')}
                                    </a>
                                </li>
                                <li>
                                    <a class="confirm_delete dropdown-item" 
                                    title="{$core->get_Lang('delete')}" 
                                    href="{$PCMS_URL}/?admin&mod={$mod}&act=delete&adminbutton_id={$core->encryptID($listChild[j].adminbutton_id)}&_type={$_type}">
                                    <i class="icon-trash"></i> {$core->get_Lang('delete')}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                {/section}
            {/section}
            </tbody>
        </table>
    </div>
</div>
{literal}
<script type="text/javascript">
	$("#SortAble").sortable({
		opacity: 0.8,
		cursor: 'move',
		start: function(){
			vietiso_loading(1);
		},
		stop: function(){
			vietiso_loading(0);
		},
		update: function(){
			var order = $(this).sortable("serialize")+'&update=update';
			$.post(path_ajax_script+"/index.php?mod=adminbutton&act=ajUpdPosSortAdminbutton", order, 
			
			function(html){
				vietiso_loading(0);
				window.location.reload();
			});

		}
	});	
</script>
{/literal}