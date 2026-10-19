<div class="breadcrumb">
	<strong>{$core->get_Lang('youarehere')} : </strong>
	<a href="{$PCMS_URL}" title="{$core->get_Lang('home')}">{$core->get_Lang('home')}</a>
    <a>&raquo;</a>
    <a href="{$PCMS_URL}/index.php?mod={$mod}">{$core->get_Lang('cruise')}</a>
    <a>&raquo;</a>
	<a href="{$curl}" title="{$act}">{if $pvalTable}{$core->get_Lang('edit')} #{$pvalTable}{else}{$core->get_Lang('add')}{/if}</a>
    <a href="javascript:window.history.back();" class="back fr">{$core->get_Lang('back')}</a>
</div>
<div class="container-fluid">
    <div class="page-title">	
        <h2>{$clsClassTable->getTitle($pvalTable)}</h2>
        <div class="permalinkbox">
            <div class="wrap permalink_show">
            	<a href="{$DOMAIN_NAME}{$clsClassTable->getLink($pvalTable)}" target="_blank"><img align="absmiddle" src="{$URL_IMAGES}/v2/link.png" /> <strong>{$DOMAIN_NAME}{$clsClassTable->getLink($pvalTable)}</strong></a> 
            </div>
        </div>
        <div class="wrap">
			{assign var=lstCruiseType value=$clsCruiseStore->getListType()}
			{if $lstCruiseType && $clsISO->getCheckActiveModulePackage($package_id,$mod,'store','default')}
            <div class="group_buttons fr" style="margin-top:-40px">
				{foreach from=$lstCruiseType key=k item=v}
				<label class="lblCheckBox mr10 fl">
					<input type="checkbox" data="{$pvalTable}" _type="{$k}" class="changeToStore" {if $clsCruiseStore->checkExist($pvalTable,$k)}checked="checked"{/if} /><br /> {$v}
				</label>
				{/foreach}
			</div>
			{/if}
		</div>
    </div>
    <div class="clearfix"><br /></div>
	<form method="post" action="" enctype="multipart/form-data" class="validate-form">
		<div id="clienttabs">
			<ul>
				<li><a href="#isotab0"><i class="iso-bassic"></i> {$core->get_Lang('Basic')}</a></li>
                
				{if $clsISO->getCheckActiveModulePackage($package_id,$mod,'edit_cabin','default')}
				<li class="tabchild">
                	<a submit="_NOT" href="#isotab1" onClick="loadListCruiseCabin({$pvalTable});"><i class="fa fa-bar-chart"></i> {$core->get_Lang('Cabin')}</a>
                </li>
				{/if}
				{if $clsISO->getBrowser() ne 'computer'}
					<div class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">
						  # {$core->get_Lang('Other tab')} <span class="caret"></span>
						</a>
						<ul class="dropdown-menu" role="menu">
							{if $clsISO->getCheckActiveModulePackage($package_id,$mod,'itinerary','default')}
							<li><a href="javascript:void();"><i class="fa fa-pie-chart"></i> {$core->get_Lang('itinerary')}</a></li>
							{/if}
	
							{if $lstCruiseFa || $lstCruiseService || $lstCruiseFaActivities}
							<li class="tabchild"><a href="javascript:void(0);"><i class="fa fa-bar-chart"></i> {$core->get_Lang('faservice')}</a></li>
							{/if}
							{if $clsISO->getCheckActiveModulePackage($package_id,$mod,'cruise_photo_gallery','customize')}
							<li><a href="javascript:void();"><i class="fa fa-picture-o"></i> {$core->get_Lang('libraryimage')}</a></li>
							{/if}
							{if $clsISO->getCheckActiveModulePackage($package_id,$mod,'cruise_video','customize')}
							<li><a href="javascript:void(0);"><i class="fa fa-play-circle-o"></i> {$core->get_Lang('Video')}</a></li>
							{/if}
							{if $clsISO->getCheckActiveModulePackage($package_id,'promotionpro','default','default','Cruise')}
							<li><a href="javascript:void(0);"><i class="fa fa-money"></i> {$core->get_Lang('Promotion')}</a></li>
							{/if}
							<li><a href="javascript:void(0);"><i class="fa fa-bar-chart"></i> {$core->get_Lang('Seo')}</a></li>
						</ul>
					 </div>
				{else}
					{if $clsISO->getCheckActiveModulePackage($package_id,$mod,'itinerary','default')}
					<li><a href="#isotab2"><i class="fa fa-pie-chart"></i> {$core->get_Lang('itinerary')}</a></li>
					{/if}
					{if $lstCruiseFa || $lstCruiseService || $lstCruiseFaActivities}
					<li class="tabchild"><a href="#isotab3"><i class="fa fa-bar-chart"></i> {$core->get_Lang('faservice')}</a></li>
					{/if}
					{if $clsISO->getCheckActiveModulePackage($package_id,$mod,'cruise_photo_gallery','customize')}
					<li><a href="#isotab4" onClick="initSysGalleryCruise();"><i class="fa fa-picture-o"></i> {$core->get_Lang('libraryimage')}</a></li>
					{/if}
					{if $clsISO->getCheckActiveModulePackage($package_id,$mod,'cruise_video','customize')}
					<li><a href="#isotab5"><i class="fa fa-play-circle-o"></i> {$core->get_Lang('Video')}</a></li>
					{/if}
					{if $clsISO->getCheckActiveModulePackage($package_id,'promotionpro','default','default','Cruise')}
					<li><a href="#isotab4"><i class="fa fa-money"></i> {$core->get_Lang('Promotion')}</a></li>
					{/if}
					<li><a href="#isotab7"><i class="fa fa-bar-chart"></i> {$core->get_Lang('Seo')}</a></li>    
				{/if} 	
			</ul>
		</div>
		<div id="tab_content">
			<div class="tabbox">
				<div class="wrap">
                	<div class="fl col_Left full_width_767">
						<div class="photobox image">
							{if $_isoman_use eq '1'}
							<img src="{$oneItem.image}" alt="{$core->get_Lang('images')}" id="isoman_show_image" />
							<input type="hidden" id="isoman_hidden_image" name="isoman_url_image" value="{$oneItem.image}">
							<a href="javascript:void()" class="photobox_edit ajOpenDialog" isoman_for_id="image" isoman_val="{$oneItem.image}" isoman_name="image" title="{$core->get_Lang('edit')}"><i class="iso-edit"></i></a>
							{if $oneItem.image}
								<a pvalTable="{$pvalTable}" clsTable="Cruise" href="javascript:void()" title="{$core->get_Lang('delete')}" data-name_input="isoman_url_image" class="photobox_edit deleteItemImage" g="imgItem">X</a>
							{/if}
							{else}
							<img src="{$oneItem.image}" alt="{$core->get_Lang('noimages')}" id="imgTour_image" />
							<input type="hidden" name="image_src" value="{$oneItem.image}" class="hidden_src" id="imgTour_hidden" />
							<a href="javascript:void()" title="{$core->get_Lang('change')}" class="photobox_edit editInlineImage" g="imgTour">
								<i class="iso-edit"></i>
							</a> 
							<input type="file" style="display:none" id="imgTour_file" g="imgTour" class="editInlineImageFile" name="image" />
							{/if}
						</div>
                    </div>
					<div class="fr col_Right full_width_767">
						<div class="row-span">
							<div class="fieldlabel"><strong>{$core->get_Lang('Name')}</strong> <span class="color_r">* </span></div>
							<div class="fieldarea">
                        		<input class="text_32 full-width bold border_aaa required title_capitalize" name="title" value="{$clsClassTable->getTitle($pvalTable)}" maxlength="255" type="text" />
							</div>
                        </div>
                    	{if $clsISO->getCheckActiveModulePackage($package_id,$mod,'cat','default')}
						<div class="row-span">
							<div class="fieldlabel"><strong>{$core->get_Lang('Cruise Class')}</strong> <span class="color_r">*</span></div>
							<div class="fieldarea">
								<select class="glSlBox border_aaa required" name="cruise_cat_id" style="width:250px">
									{$clsCruiseCat->makeSelectboxOption($oneItem.cruise_cat_id,0,0,'--',0,0)} 
								</select>
							</div>
						</div>
                        {/if}
						<div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('Star')}</strong> <span class="color_r">*</span></div>
                            <div class="fieldarea">
								<label class="radio inline"><input type="radio" name="star_number" {if $oneItem.star_number eq '0' or $pvalTable eq '0'}checked="checked"{/if} value="0"> {$core->get_Lang('Un Rated')}</label> 
								{section name=star start=1 loop=6 step=1}
								<label class="radio inline"><input type="radio" name="star_number" {if $oneItem.star_number eq $smarty.section.star.index}checked="checked"{/if} value="{$smarty.section.star.index}">{$smarty.section.star.index} {$core->get_Lang('star')}</label>
								{/section}
                            </div>
                        </div>
						<div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('No. of Cabins')}</strong> <span class="color_r">*</span></div>
                            <div class="fieldarea">
								<input class="text_32 border_aaa required" id="total_cabin" name="total_cabin" value="{$clsClassTable->getOneField('total_cabin',$pvalTable)}" maxlength="255" type="number" style="width:90px" min="0" /> {$core->get_Lang('cabin(s)')}
								
                            </div>
                        </div>
						<div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('Build')}</strong> <span class="color_r">*</span></div>
                            <div class="fieldarea">
								<input class="text_32 border_aaa required" id="build" name="iso-build" value="{$clsClassTable->getOneField('build',$pvalTable)}" placeholder="2002" maxlength="255" type="text" style="width:90px" /> {$core->get_Lang('Ex.2017')}
								
                            </div>
                        </div>
						<div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('Material')}</strong> <span class="color_r">*</span></div>
                            <div class="fieldarea">
								<input class="text_32 border_aaa span50 required" id="material" name="iso-material" value="{$clsClassTable->getOneField('material',$pvalTable)}" placeholder="Wooden Junk" maxlength="255" type="text"/>
								
                            </div>
                        </div>
						<div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('Departure Port')}</strong> <span class="color_r">*</span></div>
                            <div class="fieldarea">
								<input class="text_32 border_aaa span50" id="departure_port" name="iso-departure_port" value="{$clsClassTable->getOneField('departure_port',$pvalTable)}" placeholder="{$core->get_Lang('Block 25, Tuan Chau Island, Halong, Vietnam')}"  type="text"/>
								
                            </div>
                        </div>
						{*<div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('Location Rating')}</strong></div>
                            <div class="fieldarea">
								<input class="text_32 border_aaa span50" id="location_rating" name="iso-location_rating" value="{$clsClassTable->getOneField('location_rating',$pvalTable)}" placeholder="{$core->get_Lang('Exceptional location')}"  type="text"/>
								
                            </div>
                        </div>
                        <div class="row-span">
							<div class="fieldlabel"><strong>{$core->get_Lang('Tags')}</strong></div>
								<div class="fieldarea">
								<div id="slb_ContainerTourTag">
									<select name="tag_id[]" id="tag_id" class="slb full chosen-select" multiple style="width:250px">
										{assign var = selected value = $oneItem.list_tag_id}
										{$clsTag->makeSelectboxOption($selected)}
										{$selected}
									</select>
									<a class="addTag" href="{$PCMS_URL}/?mod=tags " title="manage">.....</a>
								</div>
							</div>
						</div>*}
                        <div class="row-span">
                            <div class="fieldlabel"><strong>{$core->get_Lang('status')}</strong> <span class="color_r">*</span></div>
                            <div class="fieldarea">
								<div class="checkbox-switch">
									{if $clsClassTable->getOneField("is_online",$pvalTable) eq 1}
									<input type="checkbox" checked value="1" name="is_online" class="input-checkbox" id="toolbar-active">
									{else}
									<input type="checkbox" value="1" name="is_online" class="input-checkbox" id="toolbar-active">
									{/if}
									<div class="checkbox-animate">
										<span class="checkbox-off">PRIVATE</span>
										<span class="checkbox-on">PUBLIC</span>
									</div>
								</div>	
								<span class="notice" id="prv_status" {if $clsClassTable->getOneField("is_online",$pvalTable) eq 1}style="display:none;"{/if}>PRIVATE: {$core->get_Lang('This article can only be seen via the link in the admin page')}.</span>
								<span class="notice" id="pub_status" {if $clsClassTable->getOneField("is_online",$pvalTable) eq 0}style="display:none;"{/if}>PUBLIC: {$core->get_Lang('This article is available online show normal status')}.</span>
							</div>
                        </div>
						<div class="clearfix"></div>
						{if $clsISO->getCheckActiveModulePackage($package_id,'cruise','property','default','TravelAs')}

							<div class="mt20" style="border:1px dashed #F90; padding:10px;">
								<div class="row-span">
									<div class="fieldlabel bold"><strong class="color_r">* {$core->get_Lang('Great for group')}</strong></div>
									<div class="fieldarea">
										{section name=i loop=$lstCruiseTravel}
										<label class="inline mb5" style="font-size:0.9em;display:inline-block"><input type="checkbox" {if $clsISO->checkInArray($oneItem.listTravelAs,$lstCruiseTravel[i].cruise_property_id)}checked="checked"{/if} name="listTravelAs[]" value="{$lstCruiseTravel[i].cruise_property_id}"> &nbsp;{$clsCruiseProperty->getTitle($lstCruiseTravel[i].cruise_property_id)}</label> <br/>
										{/section}
									</div>
								</div>
							</div>
						{/if} 
						<div class="row-span mt20" style="border:1px dashed #F90; padding:10px;">
							<div class="fieldlabel bold">
								<strong class="color_r">* {$core->get_Lang('reviewcruise')}</strong>
							</div>
							<div class="fieldarea">
								<div style="width: 100%; margin-right: 20px; float: left;">
									<div class="bold" style="margin:0 0 1.33em">{$core->get_Lang('Score breakdown')}</div>
									<div class="row-span"> 
										<div class="fieldlabel span30">{$core->get_Lang('Cruise quality')}</div> 
										<div class="fieldarea span50 fl"><input class="text full span90 fontLarge price-In" name="cruise_quality" value="{$clsISO->formatNumberToEasyRead($clsReviewsCruise->getValueByField($pvalTable,'cruise_quality'))}"  maxlength="255" type="text" /> %</div>
									</div>
									<div class="row-span"> 
										<div class="fieldlabel span30">{$core->get_Lang('Food/Drink')}</div> 
										<div class="fieldarea span50 fl"><input class="text full span90 fontLarge price-In" name="food_drink" value="{$clsISO->formatNumberToEasyRead($clsReviewsCruise->getValueByField($pvalTable,'food_drink'))}"  maxlength="255" type="text" /> %</div>
									</div>
									<div class="row-span"> 
										<div class="fieldlabel span30">{$core->get_Lang('Cabin quality')}</div> 
										<div class="fieldarea span50 fl"><input class="text full span90 fontLarge price-In" name="cabin_quality" value="{$clsISO->formatNumberToEasyRead($clsReviewsCruise->getValueByField($pvalTable,'cabin_quality'))}"  maxlength="255" type="text" /> %</div>
									</div>
									<div class="row-span"> 
										<div class="fieldlabel span30">{$core->get_Lang('Staff quality')}</div> 
										<div class="fieldarea span50 fl"><input class="text full span90 fontLarge price-In" name="staff_quality" value="{$clsISO->formatNumberToEasyRead($clsReviewsCruise->getValueByField($pvalTable,'staff_quality'))}"  maxlength="255" type="text" /> %</div>
									</div>
									<div class="row-span"> 
										<div class="fieldlabel span30">{$core->get_Lang('Entertainment')}</div> 
										<div class="fieldarea span50 fl"><input class="text full span90 fontLarge price-In" name="entertainment" value="{$clsISO->formatNumberToEasyRead($clsReviewsCruise->getValueByField($pvalTable,'entertainment'))}"  maxlength="255" type="text" /> %</div>
									</div>
								</div>
								<div style="width: 40%; float: left; display:none;">
									<div class="bold" style="margin:0 0 1.33em">{$core->get_Lang('Score breakdown')}</div>
									<div class="row-span"> 
										<div class="fieldlabel span30">{$core->get_Lang('Excellent')}</div> 
										<div class="fieldarea span50 fl"><input class="text full span90 fontLarge price-In" name="excellent" value="{$clsISO->formatNumberToEasyRead($clsReviewsCruise->getValueByField($pvalTable,'excellent'))}"  maxlength="255" type="text" /></div>
									</div>
									<div class="row-span"> 
										<div class="fieldlabel span30">{$core->get_Lang('Very good')}</div> 
										<div class="fieldarea span50 fl"><input class="text full span90 fontLarge price-In" name="very_good" value="{$clsISO->formatNumberToEasyRead($clsReviewsCruise->getValueByField($pvalTable,'very_good'))}"  maxlength="255" type="text" /></div>
									</div>
									<div class="row-span"> 
										<div class="fieldlabel span30">{$core->get_Lang('Good')}</div> 
										<div class="fieldarea span50 fl"><input class="text full span90 fontLarge price-In" name="good" value="{$clsISO->formatNumberToEasyRead($clsReviewsCruise->getValueByField($pvalTable,'good'))}"  maxlength="255" type="text" /></div>
									</div>
									<div class="row-span"> 
										<div class="fieldlabel span30">{$core->get_Lang('Average')}</div> 
										<div class="fieldarea span50 fl"><input class="text full span90 fontLarge price-In" name="average" value="{$clsISO->formatNumberToEasyRead($clsReviewsCruise->getValueByField($pvalTable,'average'))}"  maxlength="255" type="text" /></div>
									</div>
									<div class="row-span"> 
										<div class="fieldlabel span30">{$core->get_Lang('Poor')}</div> 
										<div class="fieldarea span50 fl"><input class="text full span90 fontLarge price-In" name="poor" value="{$clsISO->formatNumberToEasyRead($clsReviewsCruise->getValueByField($pvalTable,'poor'))}"  maxlength="255" type="text" /></div>
									</div>
									<div class="row-span"> 
										<div class="fieldlabel span30">{$core->get_Lang('Terrible')}</div> 
										<div class="fieldarea span50 fl"><input class="text full span90 fontLarge price-In" name="terrible" value="{$clsISO->formatNumberToEasyRead($clsReviewsCruise->getValueByField($pvalTable,'terrible'))}"  maxlength="255" type="text" /></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="clearfix mt20"></div>
				{if $clsISO->getBrowser() eq 'computer'}
                <div id="v-nav">
					<ul>
						
						<li class="first current"><a href="javascript:void(0);"><strong>{$core->get_Lang('About')}</strong></a> <span class="color_r">*</span></li>
						{if $clsISO->getCheckActiveModulePackage($package_id,'cruise','property','default','ThingAbout')}
						<li class="tabchildcol"><a href="javascript:void(0);"><strong>{$core->get_Lang('Things about')}</strong></a> <span class="color_r">*</span></li>
						{/if}
						<li class="tabchildcol"><a href="javascript:void(0);"><strong>{$core->get_Lang('Important Notes')}</strong></a> <span class="color_r">*</span></li>
						<li class="tabchildcol"><a href="javascript:void(0);"><strong>{$core->get_Lang('Inclusions')}</strong></a> <span class="color_r">*</span></li>
						<li class="tabchildcol"><a href="javascript:void(0);"><strong>{$core->get_Lang('Exclusions')}</strong></a> <span class="color_r">*</span></li>
						<li class="tabchildcol"><a href="javascript:void(0);"><strong>{$core->get_Lang('Cruise Policy')}</strong></a> <span class="color_r">*</span></li>
						<li class="tabchildcol"><a href="javascript:void(0);"><strong>{$core->get_Lang('Booking Policy')}</strong></a> <span class="color_r">*</span></li>
                        <li class="tabchildcol"><a href="javascript:void(0);"><strong>{$core->get_Lang('Child Policy')}</strong></a> <span class="color_r">*</span></li>
						
						{if $listCustomField[0].cruise_customfield_id ne ''}
						{section name=i loop=$listCustomField}
						<li class="tabchildcol"><a href="javascript:void(0);"><strong>{$listCustomField[i].fieldname}</strong></a>
						<div class="Site_Custom_Field_Tools" style="display:inline-block;margin-bottom:10px; float:right">
							<a title="{$core->get_Lang('edit')}" cruise_id="{$pvalTable}" data="{$listCustomField[i].cruise_customfield_id}" class="btnedit_customfield" href="javascript:void();"><i class="icon-pencil"></i></a>
							<a title="{$core->get_Lang('delete')}" cruise_id="{$pvalTable}" data="{$listCustomField[i].cruise_customfield_id}" class="btndelete_customfield" href="javascript:void();"><i class="icon-remove"></i></a>
							{if $smarty.section.i.first}
							{else}
							<a title="{$core->get_Lang('move')}" cruise_id="{$pvalTable}" data="{$listCustomField[i].cruise_customfield_id}" class="btnmove_customfield" direct="up" href="javascript:void();"><i class="icon-circle-arrow-up"></i></a>
							{/if}
							{if $smarty.section.i.last}
							{else}
							<a title="{$core->get_Lang('move')}" cruise_id="{$pvalTable}" data="{$listCustomField[i].cruise_customfield_id}" class="btnmove_customfield" direct="down" href="javascript:void();"><i class="icon-circle-arrow-down"></i></a>
							{/if}
						</div>
						</li>
						{/section}
						{/if}
						{if $clsConfiguration->getValue('SiteHasCustomContentField_Tours') eq '1'}
						<li><a class="iso-button-full ClickCustomField color_r" data-cruise_id="{$pvalTable}">
							<i class="fa fa-plus-circle"></i> <strong>{$core->get_Lang('addmoreinformation')}</strong>
						</a>
						</li>
						{/if}
					</ul>
					<div class="tab-content" style="display: block;">
						<div class="row-span row-has-border" style="width:100%">
							<div class="fieldarea" style="width:100%">{$clsForm->showInput('about')}</div>
						</div>
					</div>
					{if $clsISO->getCheckActiveModulePackage($package_id,'cruise','property','default','ThingAbout')}
					<div class="tab-content" style="display: none;">
						<div class="row-span row-has-border" style="width:100%">
							<div class="fieldarea" style="width:100%">
								<div class="row">
									{section name=i loop=$lstThingAbout}
									<label class="col-sm-6 col-md-6 inline mb5" style="font-size:0.9em;display:inline-block"><input type="checkbox" {if $clsISO->checkInArray($oneItem.listThingAbout,$lstThingAbout[i].cruise_property_id)}checked="checked"{/if} name="listThingAbout[]" value="{$lstThingAbout[i].cruise_property_id}"> &nbsp;{$clsCruiseProperty->getTitle($lstThingAbout[i].cruise_property_id)}</label>
									{/section}
								</div>
							</div>
						</div>
					</div>
					{/if}
					<div class="tab-content" style="display: none;">
						<div class="row-span row-has-border" style="width:100%">
							<div class="fieldarea" style="width:100%">{$clsForm->showInput('important_notes')}</div>
						</div>
					</div>
					<div class="tab-content" style="display: none;">
						<div class="row-span row-has-border" style="width:100%">
							<div class="fieldarea" style="width:100%">{$clsForm->showInput('inclusion')}</div>
						</div>
					</div>
					<div class="tab-content" style="display: none;">
						<div class="row-span row-has-border" style="width:100%">
							<div class="fieldarea" style="width:100%">{$clsForm->showInput('exclusion')}</div>
						</div>
					</div>
					<div class="tab-content" style="display: none;">
						<div class="row-span row-has-border" style="width:100%">
							<div class="fieldarea" style="width:100%">{$clsForm->showInput('cruise_policy')}</div>
						</div>
					</div>
					<div class="tab-content" style="display: none;">
						<div class="row-span row-has-border" style="width:100%">
							<div class="fieldarea" style="width:100%">{$clsForm->showInput('booking_policy')}</div>
						</div>
					</div>
                    <div class="tab-content" style="display: none;">
						<div class="row-span row-has-border" style="width:100%">
							<div class="fieldarea" style="width:100%">{$clsForm->showInput('child_policy')}</div>  
						</div>
					</div>
					{if $listCustomField[0].cruise_customfield_id ne ''}
					{section name=i loop=$listCustomField}
					<div class="tab-content" style="display: none;">
						<div class="fieldarea" style="height:450px">
							<textarea style="width:100%; height:450px" cols="255" rows="5" class="Site_Custom_Field_Editor" id="Site_Custom_Field_{$listCustomField[i].cruise_customfield_id}_{$now}" name="Site_Custom_Field_value_{$listCustomField[i].cruise_customfield_id}" >{$listCustomField[i].fieldvalue}</textarea>
						</div>
					</div>
					
					{/section}
					{/if}
				</div>
				{else}
				<div class="row-span">
					<div class="fieldlabel"><strong>{$core->get_Lang('About')}<span class="color_r">*</span></strong></div>
					<div class="fieldarea">
					{$clsForm->showInput('about')}
					</div>
				</div>
				{if $clsISO->getCheckActiveModulePackage($package_id,'cruise','property','default','ThingAbout')}
				<div class="row-span">
					<div class="fieldlabel"><strong>{$core->get_Lang('Things about')}<span class="color_r">*</span></strong></div>
					<div class="fieldarea">
					{section name=i loop=$lstThingAbout}
					<label class="full-width inline mb5" style="font-size:0.9em;display:inline-block"><input type="checkbox" {if $clsISO->checkInArray($oneItem.listThingAbout,$lstThingAbout[i].cruise_property_id)}checked="checked"{/if} name="listThingAbout[]" value="{$lstThingAbout[i].cruise_property_id}"> &nbsp;{$clsCruiseProperty->getTitle($lstThingAbout[i].cruise_property_id)}</label>
					{/section}
					</div>
				</div>
				{/if}
				<div class="row-span">
					<div class="fieldlabel"><strong>{$core->get_Lang('Important Notes')}<span class="color_r">*</span></strong></div>
					<div class="fieldarea">
					{$clsForm->showInput('important_notes')}
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel"><strong>{$core->get_Lang('Inclusions')}<span class="color_r">*</span></strong></div>
					<div class="fieldarea">
					{$clsForm->showInput('inclusion')}
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel"><strong>{$core->get_Lang('Exclusions')}<span class="color_r">*</span></strong></div>
					<div class="fieldarea">
					{$clsForm->showInput('exclusion')}
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel"><strong>{$core->get_Lang('Cruise Policy')}<span class="color_r">*</span></strong></div>
					<div class="fieldarea">
					{$clsForm->showInput('cruise_policy')}
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel"><strong>{$core->get_Lang('Booking Policy')}<span class="color_r">*</span></strong></div>
					<div class="fieldarea">
					{$clsForm->showInput('booking_policy')}
					</div>
				</div>
				<div class="row-span">
					<div class="fieldlabel"><strong>{$core->get_Lang('Child Policy')}<span class="color_r">*</span></strong></div>
					<div class="fieldarea">
					{$clsForm->showInput('child_policy')}
					</div>
				</div>
				
				{if $listCustomField[0].cruise_customfield_id ne ''}
				{section name=i loop=$listCustomField}
				<div class="row-span">
					<div class="fieldlabel"><strong>{$listCustomField[i].fieldname}<span class="color_r">*</span></strong></div>
					<div class="fieldarea">
					<textarea style="width:100%; height:450px" cols="255" rows="5" class="Site_Custom_Field_Editor" id="Site_Custom_Field_{$listCustomField[i].cruise_customfield_id}_{$now}" name="Site_Custom_Field_value_{$listCustomField[i].cruise_customfield_id}" >{$listCustomField[i].fieldvalue}</textarea>
					</div>
				</div>
				{/section}
				{/if}
				{if $clsConfiguration->getValue('SiteHasCustomContentField_Tours') eq '1'}
				<div class="row-span"><a class="iso-button-full ClickCustomField color_r" data-cruise_id="{$pvalTable}">
					<i class="fa fa-plus-circle"></i> <strong>{$core->get_Lang('addmoreinformation')}</strong>
				</a>
				</div>
				{/if}
				{/if}
            </div>    
			{if $clsISO->getCheckActiveModulePackage($package_id,$mod,'edit_cabin','default')}
            <div class="tabbox" style="display:none">
                <p>
                    {$core->get_Lang('overviewcruisecabin')} &nbsp;&nbsp;
                    <a style="vertical-align:middle" href="{$PCMS_URL}/?mod=cruise&act=edit_cabin&cruise_id={$pvalTable}" class="iso-button-primary"><i class="icon-plus-sign"></i> {$core->get_Lang('add')}</a>
                    <a href="javascript:void(0)" class="btn btn-danger btn-delete-all" clsTable="CruiseCabin" style="color:#fff; display:none"> <i class="icon-remove icon-white"></i> <span>{$core->get_Lang('Delete Options')}</span> </a>
                </p>
                <div class="clearfix"></div>
                <input id="list_selected_chkitem" style="display:none" value="0" />
                <table class="tbl-grid table-striped table_responsive" width="100%" cellpadding="0">
                    <thead>
                        <tr>
                            <th class="gridheader" style="width:40px"><input id="check_all" type="checkbox" /></th>
                            <th class="gridheader hiden767" style="width:60px"><strong>{$core->get_Lang('ID')}</strong></th>
                            <th class="gridheader" style="width:70px"><strong>{$core->get_Lang('images')}</strong></th>
                            <th class="gridheader name_responsive name_responsive3" style="text-align:left"><strong>{$core->get_Lang('title')}</strong></th>
                            <th class="gridheader hiden_responsive" style="text-align:center; width:80px"><strong>{$core->get_Lang('cabinsize')}</strong></th>
                            <th class="gridheader hiden_responsive" style="text-align:left; width:120px"><strong>{$core->get_Lang('bedsize')}</strong></th>
                            <th class="gridheader hiden_responsive" style="text-align:center; width:80px"><strong>{$core->get_Lang('extrabed')}</strong></th>
							<th class="gridheader hiden_responsive" style="text-align:center; width:60px"><strong>{$core->get_Lang('status')}</strong></th>
                            <th class="gridheader hiden_responsive" style="text-align:center; width:70px"><strong>{$core->get_Lang('func')}</strong></th>
                        </tr>
                    </thead>
                    <tbody id="tblCruiseCbin">
						{section name=i loop=$listCabin}
						<tr style="cursor:move" class="{cycle values="row1,row2"}" id="order_cabin-{$listCabin[i].cruise_cabin_id}">
							<td class="check_40"><input name="p_key[]" class="chkitem" type="checkbox" value="{$listCabin[i].cruise_cabin_id}" /></td>
							<td class="index hiden767">{$listCabin[i].cruise_cabin_id}</td>
							<td class="index"><img src="{$clsCruiseCabin->getImage($listCabin[i].cruise_cabin_id,60,40)}" alt="{$clsCruiseCabin->getTitle($listCabin[i].cruise_cabin_id)}"  width="60px" height="40px"/></td>
							<td class="name_service">
								<a title="{$core->get_Lang('edit')}" href="{$PCMS_URL}/?mod=cruise&act=edit_cabin&cruise_cabin_id={$core->encryptID($listCabin[i].cruise_cabin_id)}&cruise_id={$pvalTable}"><strong style="font-size:15px;">
								
								{$clsCruiseCabin->getTitle($listCabin[i].cruise_cabin_id)}</strong>
								</a>
								{if $listCabin[i].is_trash eq '1'}<span style="color:#ccc; float:right">[{$core->get_Lang('In Trash')}]</span>{/if}
								<button type="button" class="toggle-row inline_block767 top12" style="display:none"><i class="fa fa-caret fa-caret-down"></i></button>
							</td>
							<td class="block_responsive border_top_responsive" data-title="{$core->get_Lang('cabinsize')}" style="text-align:center"><strong>{$clsCruiseCabin->getCabinSize($listCabin[i].cruise_cabin_id)}</strong></td>
							<td class="block_responsive"  data-title="{$core->get_Lang('bedsize')}" style="text-align:left"><strong>{$clsCruiseCabin->getBedOption($listCabin[i].cruise_cabin_id)}</strong></td>
							<td class="block_responsive"  data-title="{$core->get_Lang('extrabed')}" style="text-align:center"><strong>{$clsCruiseCabin->getExtraBed($listCabin[i].cruise_cabin_id)}</strong></td>
							<td class="block_responsive"  data-title="{$core->get_Lang('status')}" style="text-align:center">
								<a href="javascript:void(0);" class="SiteClickPublic" clsTable="CruiseCabin" pkey="cruise_cabin_id" sourse_id="{$listCabin[i].cruise_cabin_id}" rel="{$clsCruiseCabin->getOneField('is_online',$listCabin[i].cruise_cabin_id)}" title="{$core->get_Lang('Click to change status')}">
									{if $clsCruiseCabin->getOneField('is_online',$listCabin[i].cruise_cabin_id) eq '1'}
									<i class="fa-solid fa-circle-check green"></i>
									{else}
									<i class="fa-solid fa-circle-minus red"></i>
									{/if}
								</a>
							</td>
							<td align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
								<div class="btn-group">
									<button class="btn btn_dropdown dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></button>
									<ul class="dropdown-menu" style="right:0px !important">
										{if $listCabin[i].is_trash eq '0'}
										<li><a title="{$core->get_Lang('edit')}" href="{$PCMS_URL}/?mod=cruise&act=edit_cabin&cruise_cabin_id={$core->encryptID($listCabin[i].cruise_cabin_id)}&cruise_id={$pvalTable}"><i class="icon-edit"></i> <span>{$core->get_Lang('edit')}</span></a></li>
										<li><a title="{$core->get_Lang('trash')}" href="{$PCMS_URL}/?mod=cruise&act=trash_cruise_cabin&cruise_cabin_id={$core->encryptID($listCabin[i].cruise_cabin_id)}&cruise_id={$pvalTable}"><i class="icon-trash"></i> <span>{$core->get_Lang('trash')}</span></a></li>
										{else}
										<li><a title="{$core->get_Lang('restore')}" href="{$PCMS_URL}/?mod=cruise&act=restore_cruise_cabin&cruise_cabin_id={$core->encryptID($listCabin[i].cruise_cabin_id)}&cruise_id={$pvalTable}"><i class="icon-refresh"></i> <span>{$core->get_Lang('restore')}</span></a></li>
										<li><a title="{$core->get_Lang('delete')}" class="confirm_delete" href="{$PCMS_URL}/?mod=cruise&act=delete_cruise_cabin&cruise_cabin_id={$core->encryptID($listCabin[i].cruise_cabin_id)}&cruise_id={$pvalTable}"><i class="icon-remove"></i> <span>{$core->get_Lang('delete')}</span></a></li>
										{/if}
									</ul>
								</div>
							</td>
						</tr>
						{/section}
					</tbody>
                </table>
            </div>
			{/if}
			{if $clsISO->getCheckActiveModulePackage($package_id,$mod,'itinerary','default')}
			<div class="tabbox" style="display:none">
                <div class="row-span-help">{$core->get_Lang('introitinerary')}</div>
                <div class="clearfix"><br /></div>
                <div class="wrap text-line-button">
                    <p>{$core->get_Lang('infoaddday')} </p>
                    <a href="{$PCMS_URL}/index.php?mod=cruise&act=edit_itinerary&cruise_id={$pvalTable}" class="iso-button-primary fl"><i class="icon-plus-sign"></i> {$core->get_Lang('add')}</a>
					<a href="javascript:void(0)" class="btn btn-danger btn-delete-all" clsTable="CruiseItinerary" style="color:#fff; display:none"> <i class="icon-remove icon-white"></i> <span>{$core->get_Lang('Delete Options')}</span> </a>
                </div>	
				<div class="clearfix"></div>
                <div class="hastable" style="margin-bottom:10px">
                    <table class="full-width tbl-grid" cellspacing="0">
                        <tr>
                            <td class="gridheader" style="width:40px"><input id="check_all" type="checkbox" /></td>
                            <td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('Days')}</strong></td>
                            <td class="gridheader" style="text-align:center; width:50px"><strong>{$core->get_Lang('status')}</strong></td>
                            <td class="gridheader" style="text-align:center; width:60px"><strong>{$core->get_Lang('func')}</strong></td>
                        </tr>
                        <tbody id="tblCruiseItinerary">
                            {section name=i loop=$listCruiseItinerary}
                            <tr style="cursor:move" class="{cycle values="row1,row2"}" id="FItinerary-{$listCruiseItinerary[i].cruise_itinerary_id}">
								<td class="index"><input name="p_key[]" class="chkitem" type="checkbox" value="{$listCruiseItinerary[i].cruise_itinerary_id}" /></td>
                                <td>
                                    <a title="{$core->get_Lang('edit')}" href="{$PCMS_URL}/?mod=cruise&act=edit_itinerary&cruise_itinerary_id={$core->encryptID($listCruiseItinerary[i].cruise_itinerary_id)}&cruise_id={$pvalTable}&fromid={$act}"><strong style="font-size:15px;">{$clsCruiseItinerary->getNumberDay($listCruiseItinerary[i].cruise_itinerary_id)}</strong>
                                    </a>
                                    {if $listCruiseItinerary[i].is_trash eq '1'}<span style="color:#ccc; float:right">{$core->get_Lang('In Trash')}</span>{/if}
                                </td>
								<td style="text-align:center">
									<a href="javascript:void(0);" class="SiteClickPublic" clsTable="CruiseItinerary" pkey="cruise_itinerary_id" sourse_id="{$listCruiseItinerary[i].cruise_itinerary_id}" rel="{$clsCruiseItinerary->getOneField('is_online',$listCruiseItinerary[i].cruise_itinerary_id)}" title="{$core->get_Lang('Click to change status')}">
										{if $clsCruiseItinerary->getOneField('is_online',$listCruiseItinerary[i].cruise_itinerary_id) eq '1'}
										<i class="fa-solid fa-circle-check green"></i>
										{else}
										<i class="fa-solid fa-circle-minus red"></i>
										{/if}
									</a>
								</td>
                                <td align="center" style="vertical-align: middle; text-align:center; width: 40px; white-space: nowrap;">
                                    <div class="btn-group">
                                        <button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown"> <i class="icon-cog"></i> <span class="caret"></span></button>
										<ul class="dropdown-menu" style="right:0px !important">
											{if $listCruiseItinerary[i].is_trash eq '0'}
											<li><a title="{$core->get_Lang('edit')}" href="{$PCMS_URL}/?mod=cruise&act=edit_itinerary&cruise_itinerary_id={$core->encryptID($listCruiseItinerary[i].cruise_itinerary_id)}&cruise_id={$pvalTable}"><i class="icon-edit"></i> <span>{$core->get_Lang('edit')}</span></a></li>
											<li><a title="{$core->get_Lang('trash')}" href="{$PCMS_URL}/?mod=cruise&act=trash_cruise_itinerary&cruise_itinerary_id={$core->encryptID($listCruiseItinerary[i].cruise_itinerary_id)}&cruise_id={$pvalTable}"><i class="icon-trash"></i> <span>{$core->get_Lang('trash')}</span></a></li>
											{else}
											<li><a title="{$core->get_Lang('restore')}" href="{$PCMS_URL}/?mod=cruise&act=restore_cruise_itinerary&cruise_itinerary_id={$core->encryptID($listCruiseItinerary[i].cruise_itinerary_id)}&cruise_id={$pvalTable}"><i class="icon-refresh"></i> <span>{$core->get_Lang('restore')}</span></a></li>
											<li><a title="{$core->get_Lang('delete')}" class="confirm_delete" href="{$PCMS_URL}/?mod=cruise&act=delete_cruise_itinerary&cruise_itinerary_id={$core->encryptID($listCruiseItinerary[i].cruise_itinerary_id)}&cruise_id={$pvalTable}"><i class="icon-remove"></i> <span>{$core->get_Lang('delete')}</span></a></li>
											{/if}
										</ul>
                                    </div>
                                </td>
                            </tr>
                            {/section}
                        </tbody>
                    </table>
                </div>
			</div>
			{/if}
			{if $lstCruiseFa || $lstCruiseService || $lstCruiseFaActivities}
            <div class="tabbox" style="display:none">
            	<div>
					
                	{if $lstCruiseFa}
                	<div class="service_left" style="margin-top:0px">
						<h3 class="mb10">{$core->get_Lang('Cruise Facilities')}</h3>
					</div>
                    <div class="service_right ml10">
                    	<div class="checkall" style="margin-bottom:10px">
                            {$core->get_Lang('Check/Uncheck All')} <input type="checkbox" rel="fa_ge" id="all_check">
                        </div>
                        <ul class="list_style_none margin_0" id="list-general">
                        	{section name=i loop=$lstCruiseFa}
							<li><label><input class="fa_ge" type="checkbox" {if $clsISO->checkInArray($oneItem.listCruiseFacilities,$lstCruiseFa[i].cruise_property_id)}checked="checked"{/if} name="listCruiseFacilities[]" value="{$lstCruiseFa[i].cruise_property_id}"> {$clsCruiseProperty->getTitle($lstCruiseFa[i].cruise_property_id)}</label></li>
							{/section}
							<li><a class="color_f00" href="{$PCMS_URL}/?mod=cruise&act=property&type=CruiseFacilities" title="{$core->get_Lang('Add New')}"><i class="fa fa-plus-circle" aria-hidden="true"></i> <label>{$core->get_Lang('Add New')}</label></a></li>
                        </ul>
                    </div>
					<div class="clearfix mb20"></div>
                    {/if}
                    {if $lstCruiseService}
                    <div class="service_left">
						<h3 class="mb10">{$core->get_Lang('Cruise Services')}</h3>
					</div>
                    <div class="service_right ml10">
                    	<div class="checkall" style="margin-bottom:10px">
                            {$core->get_Lang('Check/Uncheck All')} <input type="checkbox" rel="fa_cs" id="all_check">
                        </div>
                        <ul class="list_style_none margin_0" id="list-general">
                        	{section name=i loop=$lstCruiseService}
							<li><label><input class="fa_cs" type="checkbox" {if $clsISO->checkInArray($oneItem.listCruiseServices,$lstCruiseService[i].cruise_property_id)}checked="checked"{/if} name="listCruiseServices[]" value="{$lstCruiseService[i].cruise_property_id}"> {$clsCruiseProperty->getTitle($lstCruiseService[i].cruise_property_id)}</label></li>
							{/section}
							<li><a class="color_f00" href="{$PCMS_URL}/?mod=cruise&act=property&type=CruiseServices" title="{$core->get_Lang('Add New')}"><i class="fa fa-plus-circle" aria-hidden="true"></i> <label>{$core->get_Lang('Add New')}</label></a></li>
                        </ul>
                    </div>
					<div class="clearfix mb20"></div>
                    {/if}
					
                    {if $lstCruiseFaActivities}
                    <div class="service_left">
						<h3 class="mb10">{$core->get_Lang('Activities on Board')}</h3>
					</div>
                    <div class="service_right ml10">
                    	<div class="checkall" style="margin-bottom:10px">
                            {$core->get_Lang('Check/Uncheck All')} <input type="checkbox" rel="fa_ac" id="all_check">
                        </div>
                        <ul class="list_style_none margin_0" id="list-general">
                        	{section name=i loop=$lstCruiseFaActivities}
							<li><label><input class="fa_ac" type="checkbox" {if $clsISO->checkInArray($oneItem.listCruiseFaActivities,$lstCruiseFaActivities[i].cruise_property_id)}checked="checked"{/if} name="listCruiseFaActivities[]" value="{$lstCruiseFaActivities[i].cruise_property_id}"> {$clsCruiseProperty->getTitle($lstCruiseFaActivities[i].cruise_property_id)}</label></li>
							{/section}
							<li><a class="color_f00" href="{$PCMS_URL}/?mod=cruise&act=property&type=CruiseFaActivities" title="{$core->get_Lang('Add New')}"><i class="fa fa-plus-circle" aria-hidden="true"></i> <label>{$core->get_Lang('Add New')}</label></a></li>
                        </ul>
                    </div>
                    {/if}
                </div>
            </div>
			{/if}
            
			{if $clsISO->getCheckActiveModulePackage($package_id,$mod,'cruise_photo_gallery','customize')}
            <div class="tabbox" style="display:none">
               {if $clsISO->getCheckActiveModulePackage($package_id,$mod,'cruise_photo_gallery','customize')}
				<div class="tabboxglobal tabboxchild_globaltabs_media">
					<div id="CruiseGalleryHolder"></div>
				</div>
				{/if}
            </div>
			{/if}
			{if $clsISO->getCheckActiveModulePackage($package_id,$mod,'cruise_video','customize')}
            <div class="tabbox" style="display:none">
            	<div class="row-span-help">
                </div>
                <div class="clearfix"><br /></div>
                <div class="wrap text-line-button">
                    <a style="vertical-align:middle" href="{$PCMS_URL}/index.php?mod=cruise&act=edit_cruise_video&cruise_id={$pvalTable}" class="iso-button-primary fl"><i class="icon-plus-sign"></i>&nbsp;&nbsp;{$core->get_Lang('add')}</a>
                </div>
				{if $listCruiseVideo}
                <div class="hastable" style="margin-bottom:10px">
                    <table class="full-width tbl-grid" cellspacing="0">
                    	<tr>
							<td class="gridheader" style="width:60px;text-align:center; "><strong>{$core->get_Lang('ID')}</strong></td>
                            <td class="gridheader" style="text-align:left"><strong>{$core->get_Lang('title')}</strong></td>
                            <td class="gridheader" colspan="2" style="text-align:center"><b>{$core->get_Lang('func')}</b></td>
                       	</tr>
                       	<tbody id="tblCruiseVideo">
                        	{section name=i loop=$listCruiseVideo}
                            <tr style="cursor:move" class="{if $smarty.section.i.index%2 eq 0}row1{else}row2{/if}" id="order-{$listCruiseVideo[i].cruise_video_id}">
                                <td class="index">{$listCruiseVideo[i].cruise_video_id}</td>
                                <td>
                                    <a title="Edit" href="{$PCMS_URL}/?mod=cruise&act=edit_cruise_video&cruise_video_id={$listCruiseVideo[i].cruise_video_id}&cruise_id={$pvalTable}">
                                       <strong style="font-size:16px;">{$clsCruiseVideo->getTitle($listCruiseVideo[i].cruise_video_id)}</strong>
                                    </a>
                                    {if $listCruiseVideo[i].is_trash eq '1'}<span style="color:#ccc;">[In Trash]</span>{/if}
                                </td>
                                <td style="vertical-align: middle; width: 40px; text-align: right; white-space: nowrap;">
									<div class="btn-group">
										<button class="btn iso-button-standard dropdown-toggle" type="button" data-toggle="dropdown"> <i class="icon-cog"></i> <span class="caret"></span></button>
										<ul class="dropdown-menu" style="right:0px !important">
											{if $listCruiseVideo[i].is_trash eq '0'}
											<li><a title="{$core->get_Lang('edit')}" href="{$PCMS_URL}/?mod=cruise&act=edit_cruise_video&cruise_video_id={$core->encryptID($listCruiseVideo[i].cruise_video_id)}&cruise_id={$pvalTable}"><i class="icon-edit"></i> <span>{$core->get_Lang('edit')}</span></a></li>
											<li><a title="{$core->get_Lang('trash')}" href="{$PCMS_URL}/?mod=cruise&act=trash_cruise_video&cruise_video_id={$core->encryptID($listCruiseVideo[i].cruise_video_id)}&cruise_id={$pvalTable}"><i class="icon-trash"></i> <span>{$core->get_Lang('trash')}</span></a></li>
											{else}
											<li><a title="{$core->get_Lang('restore')}" href="{$PCMS_URL}/?mod=cruise&act=restore_cruise_video&cruise_video_id={$core->encryptID($listCruiseVideo[i].cruise_video_id)}&cruise_id={$pvalTable}"><i class="icon-refresh"></i> <span>{$core->get_Lang('restore')}</span></a></li>
											<li><a title="{$core->get_Lang('delete')}" class="confirm_delete" href="{$PCMS_URL}/?mod=cruise&act=delete_cruise_video&cruise_video_id={$core->encryptID($listCruiseVideo[i].cruise_video_id)}&cruise_id={$pvalTable}"><i class="icon-remove"></i> <span>{$core->get_Lang('delete')}</span></a></li>
											{/if}
										</ul>
                                	</div>
								</td>
                            </tr>
                            {/section}
                        </tbody>
                    </table>
                </div>
				{/if}
            </div>
			{/if}
			{if $clsISO->getCheckActiveModulePackage($package_id,'promotionpro','default','default','Cruise')}
			<div class="tabbox departureTab" style="display:none; float:left">
				
			</div>
			{/if}
			<div class="tabbox" style="display:none">
				{$core->getBlock('meta_box_detail')}
				<div class="g">
					<div data-hveid="70" data-ved="0ahUKEwj2yJPhpLPVAhUGqo8KHbVWCFk4ChAVCEYoBjAG">
						<div class="rc">
							<h3 class="r"><a href="" onMouseDown="" data-href="">{$clsClassTable->getTitle($pvalTable)}</a></h3>
							<div class="s">
								<div>
									<div class="f kv _SWb" style="white-space:nowrap">
										<cite class="_Rm bc">
											<div class="breadcrumb hidden-xs" style="background:none !important; padding:0 !important">
												<a href="{$DOMAIN_NAME}"><span class="reb">{$DOMAIN_NAME}</span> ›</a> 
												<a href="{$clsCruiseCat->getLink($cruisecat_id)}" title="{$clsCruiseCat->getTitle($cruisecat_id)}">
													<span class="reb">{$clsCruiseCat->getTitle($cruisecat_id)}</span> ›
												</a>
												<a title="{$clsClassTable->getTitle($tour_id)}">
													<span class="reb">{$clsClassTable->getTitle($pvalTable)}</span> 
												</a>
											</div>
										</cite>
									</div>
									{if $clsReviews->getRateAvg($pvalTable,'cruise') gt 0}
									{assign var=getRateAvg value=$clsReviews->getRateAvg($pvalTable,'cruise')}
									{else}
									{assign var=getRateAvg value=1}
									{/if}
									{if  $clsReviews->getToTalReview($pvalTable,'cruise') gt 0}
									{assign var=getToTalReview value=$clsReviews->getToTalReview($pvalTable,'cruise')}
									{else}
									{assign var=getToTalReview value=0}
									{/if}
									<div style="width:650px">
										<div class="slp f">
											<g-review-stars><span class="_ayg" aria-label="Được đánh giá {$getRateAvg} trên 5"><span style="width:{$getRateAvg/5*100}%"></span></span></g-review-stars>
											Xếp hạng:{$getRateAvg} - ‎{$getToTalReview} đánh giá
										</div>
										<div>{$clsClassTable->getIntro($pvalTable)|strip_tags|truncate:300}</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
            </div>
            <div class="clearfix"><br /></div>
            <fieldset class="submit-buttons">
                {$saveBtn}{$saveList}
                <input value="Update" name="submit" type="hidden" />
            </fieldset>
		</div>
	</form>
</div>
<link rel="stylesheet" href="{$URL_CSS}/chosen.css?v={$upd_version}" type="text/css" media="all">
<script type="text/javascript">
	var $clsTable = 'CruiseImage';
	var $cruise_id = '{$pvalTable}';
	var country = "{$core->get_Lang('country')}";
	var regions = "{$core->get_Lang('regions')}";
	var cities = "{$core->get_Lang('cities')}";
	var area = "{$core->get_Lang('Area')}";
	var attractions = "{$core->get_Lang('attractions')}";
	var continents = "{$core->get_Lang('continents')}";
	var $check_mod_continent = "{$core->checkAccess('continent')}";
	var $check_mod_country= "{$core->checkAccess('country')}";
	var $SiteModActive_country = "{$clsISO->getCheckActiveModulePackage($package_id,'country','default','default')}";
	var $SiteModActive_continent = "{$clsISO->getCheckActiveModulePackage($package_id,'continent','default','default')}";
	var $SiteActive_region = "{$clsISO->getCheckActiveModulePackage($package_id,'region','default','default')}";
	var $SiteActive_city = "{$clsISO->getCheckActiveModulePackage($package_id,'city','default','default')}";
	var $SiteActive_destination = "{$clsConfiguration->getValue('SiteActive_destination')}";
	var $SiteHasDestinationCruises = "{$clsConfiguration->getValue('SiteHasDestinationCruises')}";
	var $SiteHasGalleryImagesCruises = "{$clsISO->getCheckActiveModulePackage($package_id,$mod,'cruise_photo_gallery','customize')}";
	var $SiteHasCruisesCabin = "{$clsISO->getCheckActiveModulePackage($package_id,'cruise','edit_cabin','default')}";
	var $SiteHasCustomField_Cruise = '{$clsConfiguration->getValue("SiteHasCustomField_Cruise")}';
	var $SiteHasPriceSetup_Cruise = "{$clsConfiguration->getValue('SiteHasPriceSetup_Cruise')}";
	var $SiteHasStartDate_Cruise = "{$clsConfiguration->getValue('SiteHasStartDate_Cruise')}";
	var $SiteHasCruisesProperty = "{$clsConfiguration->getValue('SiteHasCruisesProperty')}";
</script>
<script type="text/javascript" src="{$URL_THEMES}/cruise/jquery.cruise.js?v={$upd_version}"></script>
{literal}
<style type="text/css">
#slb_ContainerTourTag{position:relative}
#slb_ContainerTourTag .chosen-choices {
    border: 1px solid #aaa;
    line-height: 20px;
    padding: 2px 10px;
	padding-right:40px;
}
#slb_ContainerTourTag .addTag{display:inline-block; position:absolute; width:30px; height:30px; top:1px; right:1px; background:#f00; line-height:25px; text-align:center; color:#fff; font-weight:bold}
.col-sm-6{width:50%; float:left}
.col-sm-4{width:33.333333333%; float:left}
.row-span .fieldlabel{width: 180px;padding:0px 10px;float:left;height:32px;line-height:32px;text-align:left;font-size:13px;}
.row-span .fieldarea{width: calc(100% - 180px);float:right;}
</style>
<script type="text/javascript">
	$("#tblCruiseCbin").sortable({
		opacity: 0.8,
		cursor: 'move',
		start: function(){
			vietiso_loading(1);
		},
		stop: function(){
			vietiso_loading(0);
		},
		update: function(){
			var order_cabin = $(this).sortable("serialize")+'&update=update';
			$.post(path_ajax_script+"/index.php?mod=cruise&act=ajUpdPosSortCruiseCabin", order_cabin, 
			
			function(html){
				vietiso_loading(1);
				window.location.reload();
			});
		}
	});
	$("#tblCruiseItinerary").sortable({
		opacity: 0.8,
		cursor: 'move',
		start: function(){
			vietiso_loading(1);
		},
		stop: function(){
			vietiso_loading(0);
		},
		update: function(){
			var FItinerary = $(this).sortable("serialize")+'&update=update';
			$.post(path_ajax_script+"/index.php?mod=cruise&act=ajUpdPosSortItineraryCruise", FItinerary, 
			
			function(html){
				vietiso_loading(1);
				vietiso_loading(0);
			});
		}
	});
	$("#tblCruiseVideo").sortable({
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
			$.post(path_ajax_script+"/index.php?mod=cruise&act=ajUpdPosSortCruiseVideo", order, 
			
			function(html){
				vietiso_loading(1);
				vietiso_loading(0);
			});
		}
	});
</script>
{/literal}