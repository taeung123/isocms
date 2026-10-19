<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
    <a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$mod}">{$core->get_Lang('hotels')}</a>
    <!-- Back-->
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">	
        <h2>{$core->get_Lang('Hotel Management')}</h2>
        <p>{$core->get_Lang('systemmanagementhotels')}</p>
    </div>
    <form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
        <fieldset>
            <legend>{$core->get_Lang('confirm')}:</legend>
            {$core->get_Lang('Are you sure delete this')} {$mod|ucfirst} ?
        </fieldset>
        <fieldset class="submit-buttons">
            <button type="submit" name="update" class="btn btn-primary start">
                <i class="icon-ok icon-white"></i>
                <span>{$core->get_Lang('agree')}</span>
            </button>
            <button type="button" class="btn btn-warning delete" onclick="javascript:history.back();">
                <i class="icon-retweet icon-white"></i>
                <span>{$core->get_Lang('no/back')}</span>
            </button>
            <input value="agree" name="agree" type="hidden">
        </fieldset>
    </form>
</div>
