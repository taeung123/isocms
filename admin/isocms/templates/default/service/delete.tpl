<div class="breadcrumb">
	<strong>{$core->get_Lang('You are here')}:</strong>
	<a href="{$PCMS_URL}">{$core->get_Lang('Dashboard')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('Service')}</a>
    <a>&raquo;</a>
    <a>Xác nhận xóa</a>
    <!-- // -->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('Back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">	
        <h2>{$core->get_Lang('Travel Service')}</h2>
    </div>
    <div class="clearfix"><br /></div>
    <form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
        <fieldset>
            <legend>{$core->get_Lang('Confirm')}:</legend>
            {$core->get_Lang('You sure you want to delete')} {$mod|ucfirst} ?
        </fieldset>
        <fieldset class="submit-buttons">
            <button type="submit" name="update" class="btn btn-primary start">
                <i class="icon-ok icon-white"></i>
                <span>{$core->get_Lang('Agree')}</span>
            </button>
            <button type="button" class="btn btn-warning delete" onclick="javascript:history.back();">
                <i class="icon-retweet icon-white"></i>
                <span>{$core->get_Lang('No/Back')}</span>
            </button>
            <input value="agree" name="agree" type="hidden">
        </fieldset>
    </form>
</div>
