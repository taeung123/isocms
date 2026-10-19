<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
	<a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('tour')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}&act={$act}">{$core->get_Lang('tourslide')}</a>
	 <!-- Back-->
    <a href="javascript:window.history.back();" title="{$core->get_Lang('back')}" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="clearfix"></div>
<div class="container-fluid">
    <div class="page-title">
        <h2>{$core->get_Lang('tourslide')} <a href="{$PCMS_URL}/?mod=slide&act=edit&mod_page={$mod}" class="btn btn-success" title="{$core->get_Lang('add')}"> <i class="icon-plus icon-white"></i></a></h2>
        <p>{$core->get_Lang('systemmanagementtourslide')}</p>
    </div>
	<div class="clearfix"></div>
    {$core->getBlock('slider')}
</div>