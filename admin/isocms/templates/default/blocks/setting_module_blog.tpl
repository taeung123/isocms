<div class="breadcrumb">
    <strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang($mod)}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}&act={$act}"
       title="{$core->get_Lang('setting')}">{$core->get_Lang('setting')}</a>
</div>
<div class="clearfix"></div>
<div class="page_container page-tour_setting">
    {$core->getBlock('header_title_module_setting')}
    <div class="container-fluid container-fluid-2 d-flex">
        <div class="menu_setting_box">
            <ul class="ul_menu_setting">
                <li class="current">
                    <a href="http://isocms.com/admin/?mod={$mod}&act={$act}">
                        <span class="text">{$core->get_Lang("Module setting")}</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="content_setting_box">
            <div class="page_detail-title d-flex">
                <div class="title">
                    <h2>{$core->get_Lang('setting')}</h2>
                    <p>{$core->get_Lang('systemmanagementsetting')}</p>
                </div>
            </div>
            <form method="post" action="" enctype="multipart/form-data">
                {$core->getBlock('setting_module_banner')}
                <div class="clearfix"></div>
                {$core->getBlock('meta_box_module_blog')}
                <fieldset class="submit-buttons">
                    {$saveBtn}
                    <input value="UpdateConfiguration" name="submit" type="hidden">
                </fieldset>
            </form>
        </div>
    </div>
</div>
{literal}
    <script type="text/javascript">
        $(document).ready(function () {
            $(".datepicker").datepicker();
        });
    </script>
{/literal}

<link rel="stylesheet" type="text/css" href="{$URL_JS}/cropper/cropper.min.css?v={$upd_version}" media="all"/>
<script type="text/javascript" src="{$URL_JS}/cropper/cropper.min.js?v={$upd_version}"></script>
<script src="{$URL_JS}/cropper/jquery.cropper.js?v={$upd_version}"></script>