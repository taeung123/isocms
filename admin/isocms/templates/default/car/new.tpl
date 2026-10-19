<div class="breadcrumb">
	<strong>You are here : </strong>
	<a href="{$PCMS_URL}" title="Home">Home</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}">Cars Management</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}&act={$act}&{$pkeyTable}={$pvalTable}">Add New</a>
</div>
<div class="container-fluid">
    <div class="page-title">
    	<a href="javascript:window.history.back();" class="back fr">Back</a>
        <h2>Cars Management</h2>
        <p>Please complete all required fields&nbsp;&nbsp;&nbsp;</p>
    </div>
	<div class="clearfix"></div>
    <form id="edititem" method="post" action="" enctype="multipart/form-data" class="validate-form">
    	<div id="clienttabs">
        	<ul>
            	<li><a href="javascript:void(0);"><i class="icon-info-sign"></i> Information</a></li>
            </ul>
        </div>
        <div class="tab_content" id="tab_content">
        	<div class="tabbox">
                <div class="wrap">
					<div class="photobox fl image">
						<img src="{$oneItem.image}" alt="" id="imgPost_image" />
						<input type="hidden" name="image_src" value="{$oneItem.image}" class="hidden_src" id="imgPost_hidden" />
						<input type="file" style="display:none" id="imgPost_file" g="imgPost" class="editInlineImageFile" name="image" />
						<a href="javascript:void()" title="{$_lang->get_Lang('Change')}" class="photobox_edit editInlineImage" g="imgPost">
							<i class="iso-edit"></i>
						</a>
					</div>
					<div class="fr" style="width:79%">
                    	<div class="row-span">
                        	<div class="fieldlabel"><span class="requiredMask">*</span> {$core->get_Lang('Name of car')}</div>
                            <div class="fieldarea">
                            	<input class="text full fontLarge required" name="iso-{$title}" value="{$clsClassTable->getOneField($title,$pvalTable)}" maxlength="255" type="text">
                            </div>
                        </div>
						{if 1 eq 2}<div class="row-span">
                        	<div class="fieldlabel"><span class="requiredMask">*</span> {$core->get_Lang('Car Group')}</div>
                            <div class="fieldarea">
                            	<select name="iso-group_id" class="select slb span30">
									{$clsProperty->getSelectByProperty('CarGroup',$oneItem.group_id)}
								</select>
								<span class="notice-short">Select one group.</span>
                            </div>
                        </div>
						<div class="row-span">
                        	<div class="fieldlabel"><span class="requiredMask">*</span> {$core->get_Lang('Car Class')}</div>
                            <div class="fieldarea">
                            	<select name="iso-class_id" class="select slb span30">
									{$clsProperty->getSelectByProperty('CarClass',$oneItem.class_id)}
								</select>
								<span class="notice-short">Select one class.</span>
                            </div>
                        </div>{/if}
						{if 1 eq 2}<div class="row-span">
                        	<div class="fieldlabel"><span class="requiredMask">*</span> {$core->get_Lang('Suppliers')}</div>
                            <div class="fieldarea">
								{assign var = list_supplier_id value = $oneItem.list_supplier_id}
                            	<select multiple="multiple" name="supplier_id[]" class="select slb span60 multipleSelect">
									{section name=i loop=$listSupplier}
									<option {if $clsISO->checkContainer($list_supplier_id,$listSupplier[i].provider_id)}selected="selected"{/if} value="{$listSupplier[i].provider_id}">{$clsProvider->getTitle($listSupplier[i].provider_id)}</option>
									{/section}
								</select>
								<span class="notice-short">Select more supplier.</span>
                            </div>
                        </div>{/if}
						<div class="row-span">
                            <div class="fieldlabel"><span class="requiredMask">*</span> {$core->get_Lang('Status')}</div>
                            <div class="fieldarea">
                            <div class="vietiso_status_button"></div>
                            <script type="text/javascript">
                                var is_online = '{$clsClassTable->getOneField("is_online",$pvalTable)}';
                            </script>
                            {literal}
                            <script type="text/javascript">
                                $(document).ready(function(){
                                    $('.vietiso_status_button').isoswitchvalue({
                                        _value:is_online,
                                        _selector:'iso-is_online'
                                    });
                                });
                            </script>
                            {/literal}
                            <span class="notice" id="prv_status" {if $clsClassTable->getOneField("is_online",$pvalTable) eq 1}style="display:none;"{/if}>PRIVATE: Xe này chỉ được nhìn thấy thông qua link trong trang quản trị.</span>
                            <span class="notice" id="pub_status" {if $clsClassTable->getOneField("is_online",$pvalTable) eq 0}style="display:none;"{/if}>PUBLIC: Xe  này hiển thị trên website online ở trạng thái bình thường</span>
                            </div>
                        </div>
						{if 1 eq 2}<table class="form" cellpadding="2" cellspacing="2">
							<tr>
								<tr>
								<td class="fieldlabel span15">{$core->get_Lang('Type of seat')}</td>
								<td class="fieldarea">
									<select class="select" id="slb_Seat" name="iso-seat_id">
										{$clsProperty->getSelectByProperty('CarSeat',$oneItem.seat_id)}
									</select>
									{literal}
									<script type="text/javascript">
										$(function(){
											$('#slb_Seat').change(function(){
												var $_this = $(this);
												var $min_value = $_this.find('option:selected').attr('min_value');
												$('input[name=iso-passenger]').val($min_value);
											});
										});
									</script>
									{/literal}
								</td>
								<td class="fieldlabel span15">{$core->get_Lang('Passenger')}</td>
								<td class="fieldarea">
									<input type="number" class="text full" name="iso-passenger" value="{$clsClassTable->getOneField('passenger',$pvalTable)}" style="width:60%" />
								</td>
								<td class="fieldlabel span15">{$core->get_Lang('Baggage Quantity')}</td>
								<td class="fieldarea">
									<input type="number" class="text full" name="iso-baggage" value="{$clsClassTable->getOneField('baggage',$pvalTable)}" style="width:90%" />
								</td>
								<td class="fieldlabel span15">{$core->get_Lang('Doors Quantity')}</td>
								<td class="fieldarea">
									<input type="number" onclick="this.select();" class="text full" name="iso-door" value="{$clsClassTable->getOneField('door',$pvalTable)}" style="width:90%" />
								</td>
							</tr>
						</table>
						<div class="row-span mt10">
                        	<div class="fieldlabel-full bold">{$core->get_Lang('Car Description')}</div>
                            <div class="fieldarea-full mt5">
                            	{$clsForm->showInput($content)}
                            </div>
                        </div>
						<fieldset>
							<legend>Car Facilities</legend>
							<div class="wrap">
								{section name=i loop=$list_CarFacilities}
								<label class="lblcheck "><input type="checkbox" name="CarFacilities[]" value="{$list_CarFacilities[i].property_id}" /> {$clsProperty->getTitle($list_CarFacilities[i].property_id)}</label>
								{/section}
							</div>
						</fieldset>{/if}
					</div>
                </div>
        	</div>
        </div>
		<div class="clearfix"><br /></div>
        <fieldset class="submit-buttons">
            {$saveBtn}{$saveList}{$resetBtn}
            <input value="Insert" name="submit" type="hidden">
        </fieldset>
    </form>
</div>