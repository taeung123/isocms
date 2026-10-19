<div class="breadcrumb">
	<strong>You are here: </strong>
	<a href="{$PCMS_URL}" title="Trang chủ">Home</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}" title="{$mod}">Why with us ?</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}&act={$act}" title="{$act}">Add new</a>
</div>
<div class="container-fluid">
    <div class="page-title">
    	<a href="javascript:window.history.back();" class="back fr">Back</a>
        <h2>Why with us ?</h2>
    </div>
	<div class="clearfix"></div>
	<form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
    	<div class="row-field">
            <div class="row-heading">{$core->get_Lang('Icon')}</div>
            <div class="coltrols" style="height:50px">
                <img class="isoman_img_pop" id="isoman_show_image" src="{$clsClassTable->getOneField('image',$pvalTable)}" />
                <input type="hidden" id="isoman_hidden_image" value="{$clsClassTable->getOneField('image',$pvalTable)}">
                <input type="text" id="isoman_url_image" name="image" value="{$clsClassTable->getOneField('image',$pvalTable)}" class="text" style="width:50% !important; display:inline-block !important; float:left"><a style="float:left; margin-left:4px; margin-top:-4px;" href="#" class="ajOpenDialog" isoman_for_id="image" isoman_val="{$clsClassTable->getOneField('image',$pvalTable)}" isoman_name="image"><img src="{$URL_IMAGES}/general/folder-32.png" border="0" title="Open" alt="Open"></a>
            </div>
        </div>
        <div class="row-field">
            <div class="row-heading">Type:</div>
            <div class="coltrols">
               <select class="text full" name="iso-type" maxlength="255" >
               <option value="DEFAULT">Default</option>
               <option value="HOME">HOME</option>
               <option value="DESTINATION">DESTINATION</option>
              
               </select>
            </div>
        </div>
    	<div class="row-field">
            <div class="row-heading">Title*:</div>
            <div class="coltrols">
               <input class="text full required" name="iso-title" value="{$clsClassTable->getTitle($pvalTable)}" maxlength="255" type="text" />
            </div>
        </div>
        <div class="row-field">
            <div class="row-heading">Content*:</div>
            <div class="coltrols">{$clsForm->showInput(intro)}</div>
        </div>
        <fieldset class="submit-buttons">
            {$saveBtn} {$resetBtn}
            <input value="Insert" name="submit" type="hidden">
        </fieldset>
    </form>
</div>
{literal}
<script type="text/javascript">
$('.changeToStore').live('change',function(){
	var $_this = $(this);
	var type= $_this.attr('_type');
	$.ajax({
		type: 'POST',
		url: path_ajax_script+'/index.php?mod='+mod+'&act=new',
		data:{'_type' : $_this.attr('_type'),'why_id': $_this.attr('data'),'val' : $_this.is(':checked')?1:0},
		dataType:'html',
		success: function(html){
		}
	});
});
</script>
{/literal}