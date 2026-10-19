<link rel="stylesheet" href="{$URL_CSS}/style_v2.css?v={$upd_version}" type="text/css" media="all" />
<div id="page_v2" class="page_container blog-settings-screen">
    <main class="iso-module-list">
        {include file="../components/list_v2/header.tpl"
            header_home_label=$core->get_Lang('Dashboard') header_module_label=$core->get_Lang('Blogs')
            header_title=$core->get_Lang('Blog settings') header_subtitle=$core->get_Lang('Manage blog configuration and categories')}
        <div class="booking-list-toolbar">
            <nav class="booking-status-tabs" aria-label="{$core->get_Lang('Blog settings')}">
                <a href="{$PCMS_URL}/?mod={$mod}&act=setting" class="booking-status-tab v2-status-tab v2-status-tab--primary is-active">{$core->get_Lang('General settings')}</a>
                <a href="{$PCMS_URL}/?mod={$mod}&act=category" class="booking-status-tab v2-status-tab">{$core->get_Lang('Category')}</a>
            </nav>
        </div>
        {$core->getBlock('setting_module_blog')}
    </main>
</div>
