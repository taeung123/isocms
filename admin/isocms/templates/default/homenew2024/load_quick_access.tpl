{if $holderG eq '_modal'}
    <div class="modal-dialog home" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal_btntitle">
                    <h5 class="modal-title" id="exampleModalLabel">{$core->get_Lang('Edit quick access')}</h5>
                    <div class="button_modal">
                        <button type="button" class="btn btn-primary"
                                data-dismiss="modal">{$core->get_Lang('Completed')}</button>
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{$core->get_Lang('Cancel')}</button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="quick_access_html">
                    <div class="loader text-center">
                        ...
                    </div>
                </div>
            </div>
        </div>
    </div>
{else}
    <div class="quick_access_show quick_access_show_top">
        <p class="title text-bold">{$core->get_Lang('Show')}</p>
        <div class="quick_access_list">
            {section name=i loop=$listQuickAccessShow}
                {assign var=admin_id value=$listQuickAccessShow[i].adminbutton_id}
                {if $clsAdminButton->checkPackage($admin_id,$package_id)}
                    {if $core->checkAccess($listQuickAccessShow[i].mod_page)}
                        <div class="quick_access_item">
                            <span class="remove_item_quick_access" data-tp="remove"
                                  data-adminbutton_id="{$listQuickAccessShow[i].adminbutton_id}">x</span>
                            <span class="icon"><img class="imgIcon" src="{$listQuickAccessShow[i].image}" width="28"
                                                    height="28"/></span>
                            <span class="text">{$core->get_Lang($listQuickAccessShow[i].title_page)}</span>
                        </div>
                    {/if}
                {/if}
            {/section}
        </div>
    </div>
    <div class="quick_access_show">
        <p class="title text-bold">{$core->get_Lang('Add to quick access')}</p>
        <div class="quick_access_list">
            {section name=i loop=$listQuickAccess}
                {assign var=admin__id value=$listQuickAccess[i].adminbutton_id}
                {if $clsAdminButton->checkPackage($admin__id,$package_id)}
                    {if $core->checkAccess($listQuickAccess[i].mod_page)}
                        <div class="quick_access_item add_item_quick_access" data-tp="add"
                             data-adminbutton_id="{$listQuickAccess[i].adminbutton_id}">
                            <span class="icon"><img class="imgIcon" src="{$listQuickAccess[i].image}" width="28"
                                                    height="28"/></span>
                            <span class="text">{$core->get_Lang($listQuickAccess[i].title_page)}</span>
                        </div>
                    {/if}
                {/if}
            {/section}
        </div>
    </div>
{/if}

{literal}
	<style>
		.modal-header {
			display: flex;
			justify-content: space-between;
			align-items: center;
		}

		.modal_btntitle {
			display: flex;
			justify-content: space-between;
			width: 100%;
		}

		.button_modal {
			display: flex;
			gap: 10px; /* khoảng cách giữa các nút */
		}

		.modal_btntitle h5 {
			color: var(--primary-1-d-2-d-53, #1D2D53);
			font-family: Roboto;
			font-size: 18px;
			font-style: normal;
			font-weight: 500;
			line-height: 150%; /* 27px */
		}

		.button_modal button {
			color: #666;
			font-family: Roboto;
			font-size: 14px;
			font-style: normal;
			font-weight: 400;
			line-height: 150%; /* 24px */
		}

		.quick_access_item {
			align-items: center;
			gap: 10px;
			border-radius: 5px;
			border: 1px solid #E8E9EA;
			transition: box-shadow 0.3s ease;
			background: #FFF;
		}
		
	</style>
	{/literal}