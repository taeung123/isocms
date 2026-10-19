<div class="hnv_setting_main_left">
    <div class="hnv_setting_main_left_title">
        <h3>{$core->get_Lang('Settings')}</h3>
    </div>
    <div class="list-group hnv_list_tab" id="hnv_list_tab" role="tablist">
        {foreach from=$lstMenu key=key item=item}
            {if $core->checkAccess($item.mod_page) and $clsAdminButton->checkConfiguration($item.adminbutton_id)}
            {assign var=menuItem value=$item.menuItem}
            {if $menuItem} 
                <div class="box_lst_setting">
                    <a class="list-group-item-action list-group-item box_lst_setting_title {if $item.parent_active}active{/if}">
                        {$core->get_Lang($item.title_page)}
                    </a>
                    <div class="hnv_list_tab_sub {if $item.parent_active}active{/if}" id="company_sub_list">
                        {foreach from=$menuItem key=k item=i} 
                            {if $core->checkAccess($i.mod_page) and $clsAdminButton->checkConfiguration($i.adminbutton_id)}
                                {assign var=menuItem value=$item.menuItem}
                                <a class="iso_btn_setting list-group-item list-group-item-child {if ($key eq 0 && $k eq 0) || ($item.parent_active && $button_active eq $i.adminbutton_id)}active2{/if}" href="{$i.url_page}" role="tab" aria-controls="list-companyprofile">
                                    {$core->get_Lang($i.title_page)}
                                </a>
                            {/if}
                        {/foreach}
                    </div>
                </div>
            {else} 
                <a class="iso_btn_setting list-group-item list-group-item-action {if $item.parent_active}active{/if}" data-bs-toggle="list" href="{$item.url_page}" role="tab" aria-controls="list-profile">
                    {$core->get_Lang($item.title_page)}
                </a>
            {/if}
            {/if}
        {/foreach}
    </div>
</div>
<script>
    let action_setting = "{$action}";
</script>
{literal}
    <script>
        $(function () {
            if(!action_setting){
                let href_first = $('.iso_btn_setting').first().attr('href');
                openURL(href_first);
            }

            $(document)
                .on('click', '.iso_btn_setting', function (e) {
                    e.preventDefault();
                    $('.iso_btn_setting').removeClass('active2');
                    if($(this).hasClass('list-group-item-child')){
                        $(this).addClass('active2');
                    }else{
                        $('.hnv_list_tab_sub').slideUp();
                    }

                    let href = $(this).attr('href');
                    openURL(href);
                })
                .on('click', '.box_lst_setting_title', function(){
                    $('.iso_btn_setting').removeClass('active2');

                    $('.box_lst_setting_title, .list-group-item').removeClass('active');
                    $(this).addClass('active');
                    $(this).parents('.box_lst_setting').find('.hnv_list_tab_sub').slideToggle();

                    let iso_btn_setting = $(this).parents('.box_lst_setting').find('.hnv_list_tab_sub .iso_btn_setting').first();
                    iso_btn_setting.addClass('active2');
                    let href = iso_btn_setting.attr('href');
                    openURL(href);
                })

            function openURL(href) {
                var link = href;
                $.ajax({
                    url: link,
                    type: 'GET',
                    cache: false,
                    dataType: "html",
                    success: function (result) {
                        $('.hnv_setting_main_right').html(result);
                    }
                });
                window.history.pushState({href: href}, '', href);
                return false;
            }
        });
    </script>
    <style>
        .hnv_list_tab_sub.active{
            display: block;
        }
    </style>
{/literal}
