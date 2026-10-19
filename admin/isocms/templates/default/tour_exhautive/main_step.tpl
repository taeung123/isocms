<form method="post" accept-charset="UTF-8" enctype="multipart/form-data">
	<div class="box_main_step_content">
		<div class="row d-flex flex-wrap full-height">
			<!-- CENTER: MAIN FORM CONTENT -->
			<div class="col-xs-12 col-sm-12 col-md-9">
				<div class="fill_data_box">
					<div class="form_title_and_table_code">

						{if $currentstep=='image'}

							{assign var=image_detail value='image_category_country'}
							<div class="main_step_content_card">
								<div class="main_step_card_header">
									<div class="main_step_card_icon">
										<i class="fa-regular fa-image" aria-hidden="true"></i>
									</div>
									<div class="main_step_card_heading">
										<h3 class="title_box">{$core->get_Lang('Images & Media')}</h3>
										<p>{$core->get_Lang('Manage images for this item')}</p>
									</div>
								</div>

								<div class="main_step_card_body">
									{$clsISO->getBlock('box_detail_image',["image_detail"=>"image_category_country"])}
								</div>
							</div>

						{elseif $currentstep=='generalinformation'}

							<div class="main_step_content_card">
								<div class="main_step_card_header">
									<div class="main_step_card_icon">
										<i class="fa fa-info-circle" aria-hidden="true"></i>
									</div>
									<div class="main_step_card_heading">
										<h3 class="title_box">{$core->get_Lang('General Information')}</h3>
										<p>{$core->get_Lang('Enter the basic information for this item')}</p>
									</div>
								</div>
                                <div class="main_step_card_body main_step_category_country">

                                    {if $clsConfiguration->getValue('SiteHasCat_Tours') eq 1}
                                        <div class="inpt_tour category-country-field category-country-field--travel-style">
                                            <label for="cat_id">
                                                {$core->get_Lang('Travel Style')}
                                                <span class="required_red">*</span>


                                            </label>

                                            <div class="fieldarea">
                                                <div class="category-country-control">
                                                    <select name="cat_id"
                                                        id="cat_id"
                                                        class="glSlBox required category-country-select">
                                                        {$clsTourCategory->makeSelectboxOptionCountryImage($country_id,$oneItem.cat_id)}
                                                    </select>
                                                </div>

                                                <div class="text_help" hidden="">
                                                    {$clsConfiguration->getValue($travel_styles_category_country)|html_entity_decode}
                                                </div>
                                            </div>
                                        </div>
                                    {/if}

                                    <div class="inpt_tour category-country-field category-country-field--country">
                                        <label for="slb_Country">
                                            {$core->get_Lang('Country')}
                                            <span class="required_red">*</span>

                                        </label>

                                        <div class="fieldarea">
                                            <div class="category-country-control">
                                                <select
                                                    class="slb full glSlBox required category-country-select"
                                                    name="iso-country_id"
                                                    id="slb_Country">
                                                    {$clsCountry->makeSelectboxOptionImage($oneItem.country_id)}
                                                </select>
                                            </div>

                                            <div class="text_help" hidden="">
                                                {$clsConfiguration->getValue($destination_category_country)|html_entity_decode}
                                            </div>
                                        </div>
                                    </div>

                                </div>
							</div>

<div class="main_step_content_card main_step_quick_preview">

    <div class="main_step_card_header main_step_preview_header">
        <div class="main_step_card_heading">
            <h3 class="title_box">{$core->get_Lang('Quick Preview')}</h3>
            <p>{$core->get_Lang('Preview how this travel style will appear for the selected country.')}</p>
        </div>

        <a href="{$clsTourCategory->getLink($oneItem.cat_id)|default:'#'}"
           id="categoryCountryPreviewLink"
           class="main_step_preview_link"
           target="_blank"
           rel="noopener noreferrer">
            <i class="fa fa-external-link" aria-hidden="true"></i>
            {$core->get_Lang('View on website')}
        </a>
    </div>

    <div class="main_step_card_body">
        <div class="main_step_preview_card">

            <div class="main_step_preview_image">
                <img
                    id="categoryCountryPreviewImage"
                    src="{$clsClassTable->getImage($pvalTable,80,59)}"
                    
                    alt="{$oneItem.title|default:''|escape:'html'}"
                    onerror="this.onerror=null;this.src='{$URL_IMAGES}/none_image.png';"
                />
                     <!-- <img
                    id="categoryCountryPreviewImage"
                    
                    src="{$clsTourCategory->getImage($oneItem.cat_id)}"
                    alt="{$oneItem.title|default:''|escape:'html'}"
                    onerror="this.onerror=null;this.src='{$URL_IMAGES}/none_image.png';"
                /> -->
            </div>

            <div class="main_step_preview_content">

                <div class="main_step_preview_country">
                    <span id="categoryCountryPreviewCode">
                        {$clsCountry->getOneField('code',$oneItem.country_id)|default:''}
                    </span>

                    <span id="categoryCountryPreviewCountry">
                        <i class="fa fa-globe" aria-hidden="true"></i>
                        {$clsCountry->getTitle($oneItem.country_id)|default:''}
                        
                    </span>
                </div>

                <h3 id="categoryCountryPreviewTitle">
                     {$clsTourCategory->getTitle($oneItem.cat_id)}
                </h3>

                <p id="categoryCountryPreviewDescription">
                    {$oneItem.overview|default:''|strip_tags|truncate:220:'...'}
                </p>

                <div class="main_step_preview_tags"
                     id="categoryCountryPreviewTags">
                    {* Chỉ hiển thị tags nếu có dữ liệu tags thực tế *}
                </div>

            </div>
        </div>
    </div>

</div>

                 

						{elseif $currentstep=='longText'}

							<div class="main_step_content_card">
								<div class="main_step_card_header">
									<div class="main_step_card_icon">
										<i class="fa fa-align-left" aria-hidden="true"></i>
									</div>
									<div class="main_step_card_heading">
										<h3 class="title_box">
											{$core->get_Lang('Description')}

											{assign var=longText_category_country value='longText_category_country'}
											{assign var=help_first value=$longText_category_country}

											{if $CHECKHELP|default:0 eq 1}
												<button data-key="{$longText_category_country}"
													data-label="{$core->get_Lang('Long text')}"
													type="button"
													title="Thêm mô tả"
													onclick="open_texthelp(this, event)"
													class="btn btn-xs btn-default">
													<i class="fa fa-plus-circle"></i>
												</button>
											{/if}
										</h3>
										<p>{$core->get_Lang('Manage the detailed content')}</p>
									</div>
								</div>

								<div class="main_step_card_body">
									<div class="inpt_tour">
										<label for="textarea_intro_editor_overview_{$now}">
											{$core->get_Lang('Description')}
										</label>

										<textarea
											style="width:100%"
											table_id="{$pvalTable}"
											name="iso-content"
											class="textarea_intro_editor"
											data-column="iso-content"
											id="textarea_intro_editor_overview_{$now}"
											cols="255"
											rows="2">{$oneItem.content}</textarea>
									</div>

									{literal}
									<script>
										$(".showdate").datepicker({
											dateFormat: "dd/mm/yy"
										});
									</script>
									{/literal}
								</div>
							</div>

						{elseif $currentstep=='banner'}

							<div class="main_step_content_card">
								<div class="main_step_card_header">
									<div class="main_step_card_icon">
										<i class="fa fa-image" aria-hidden="true"></i>
									</div>
									<div class="main_step_card_heading">
										<h3 class="title_box">{$core->get_Lang('Banner Size')}</h3>
										<p>{$core->get_Lang('Manage the banner image and content')}</p>
									</div>
								</div>

								<div class="main_step_card_body">
									{$core->getBlock('box_detail_category_country_banner')}
								</div>
							</div>

						{/if}

						<!-- STEP NAVIGATION ACTIONS -->
					

					</div>
				</div>
			</div>
			<!-- RIGHT: INSTRUCTIONS -->
            <div class="col-xs-12 col-sm-12 col-md-3 col_instruction">

                <div class="main_step_status_card">

                    <h3 class="main_step_status_title">Status &amp; Options</h3>

                   
                    <div class="main_step_status_field">
                        <label class="main_step_status_label">Status</label>

                        <div class="main_step_status_control">
    <label class="main_step_switch">
        <input
            type="checkbox"
            id="main_step_status_toggle"
            data-val="{if $oneItem.is_online|default:0 eq 1}1{else}0{/if}"
            data-clstable="Category_Country"
            data-pkey="{$clsClassTable->pkey}"
            data-sourse_id="{$pvalTable}"
            {if $oneItem.is_online|default:0 eq 1}checked{/if}
        />
        <span class="main_step_switch_slider"></span>
    </label>

    <span class="main_step_status_text">
        {if $oneItem.is_online|default:0 eq 1}
            Active
        {else}
            Inactive
        {/if}
    </span>
</div>
                    </div>


                    <!-- Sort Order -->
                    <div class="main_step_status_field">
                        <label class="main_step_status_label" for="main_step_sort_order">
                            Sort Order
                        </label>

                        <input
                            type="number"
                            min="0"
                            id="main_step_sort_order"
                            name="order_no"
                            class="main_step_sort_input"
                            value="{$oneItem.order_no|default:1}"
                        />

                        <p class="main_step_status_help">
                            Display order for this item.
                        </p>
                    </div>

                    <div class="main_step_status_divider"></div>

                    <!-- Last Updated -->
                    <div class="main_step_updated">
                        <label class="main_step_status_label">Last Updated</label>
                        {if $oneItem.upd_date|default:0}
                            <div class="main_step_updated_date">
                                <i class="fa-regular fa-calendar"></i> {$oneItem.upd_date|date_format:"%d/%m/%Y %H:%M"}
                            </div>
                        {/if}
                    </div>
                    <!-- Updated By -->
                    <div class="main_step_updated main_step_updated_by">
                        <label class="main_step_status_label">By   {$updated_by_name|default:'—'}</label>
                    </div>

                </div>

                <!-- Instructions: giữ lại nội dung hướng dẫn hiện tại -->
                <div class="instruction_fill_data_box main_step_instruction_card">
                    <div class="main_step_instruction_header">
                        <i class="fa fa-question-circle text-red" aria-hidden="true"></i>
                        <p class="title_box">{$core->get_Lang('Instructions')}</p>
                    </div>

                    <textarea class="content_box"> {$clsConfiguration->getValue($help_first|default:'')}</textarea>
                </div>

            </div>
            	<div class="btn_save_titile_table_code mt30">
							<a data-table_id="{$pvalTable}"
								data-panel="{$arrStep[$step].panel}"
								data-currentstep="{$arrStep[$step].key}"
								data-prevstep="{$prevstep}"
								class="back_step js_save_back_main_step">
								<i class="fa fa-arrow-left" aria-hidden="true"></i>
								{$core->get_Lang('Back')}
							</a>

							<a data-table_id="{$pvalTable}"
								data-panel="{$arrStep[$step].panel}"
								data-currentstep="{$currentstep}"
								data-next_step="{$nextstep}"
								class="js_save_continue_main_step">
								{$core->get_Lang('Save &amp; Continue')}
								<i class="fa fa-arrow-right" aria-hidden="true"></i>
							</a>
						</div>
		</div>
	</div>
</form>

{literal}
<style>
	

/* ======================================
   MAIN STEP - STATUS & OPTIONS
   ====================================== */

.main_step_status_card {
    width: 100% !important;
    margin: 0 0 15px !important;
    padding: 22px !important;
    background: #fff !important;
    border: 1px solid #e1e9f3 !important;
    border-radius: 13px !important;
    box-shadow: 0 1px 3px rgba(25, 55, 90, .06) !important;
    box-sizing: border-box !important;
}

.main_step_status_title {

    font-size: 16px;
    font-weight: 800;
    color: #162643;
    margin-bottom: 16px;
}

.main_step_status_field {
    margin: 0 0 20px !important;
}

.main_step_status_label {
    display: block !important;
    margin: 0 0 10px !important;
    color: #526985 !important;
    font-weight: 600 !important;
        font-size: 12.3px;
}
.main_step_updated_by label{
    margin-left: 23px !important;
    color: #8a97a8 !important;
    text-transform: uppercase;
}
.main_step_status_control {
    display: flex !important;
    align-items: center !important;
    gap: 11px !important;
}

/* Switch */
.main_step_switch {
    position: relative !important;
    display: inline-block !important;
    flex: 0 0 40px !important;
    width: 40px !important;
    height: 22px !important;
    margin: 0 !important;
    cursor: pointer !important;
}

.main_step_switch input {
    width: 0 !important;
    height: 0 !important;
    opacity: 0 !important;
    position: absolute !important;
}

.main_step_switch_slider {
    position: absolute !important;
    inset: 0 !important;
    background: #d6deea !important;
    border-radius: 22px !important;
    transition: background .2s ease !important;
}

.main_step_switch_slider:before {
    content: "" !important;
    position: absolute !important;
    width: 18px !important;
    height: 18px !important;
    left: 2px !important;
    top: 2px !important;
    background: #fff !important;
    border-radius: 50% !important;
    box-shadow: 0 1px 3px rgba(0, 0, 0, .12) !important;
    transition: transform .2s ease !important;
}

.main_step_switch input:checked + .main_step_switch_slider {
    background: #20b363 !important;
}

.main_step_switch input:checked + .main_step_switch_slider:before {
    transform: translateX(18px) !important;
}
.main_step_category_country label{
    font-size: 13.3px !important;
}
.main_step_switch input:focus-visible + .main_step_switch_slider {
    outline: 2px solid #8bb9f5 !important;
    outline-offset: 3px !important;
}

.main_step_status_text {
    color: #e53e3e !important;
    font-weight: 600 !important;
}

.main_step_status_control.is-active .main_step_status_text {
    color: #16a05a !important;
}
#categoryCountryPreviewCountry .fa-globe{
        margin-right: 10px;
}
/* Sort order */
.main_step_sort_input {
    display: block !important;
    width: 100% !important;
    height: 44px !important;
    padding: 10px 12px !important;
    color: #24364b !important;
    background: #fff !important;
    border: 1px solid #c9c2b4 !important;
    border-radius: 5px !important;
    box-shadow: none !important;
    box-sizing: border-box !important;
}
.
.main_step_sort_input:focus {
    border-color: #8baed8 !important;
    outline: none !important;
    box-shadow: 0 0 0 2px rgba(64, 130, 210, .1) !important;
}
.headPop h3 {
    padding: 0;
        margin-left: 13px !important;
        background: none;
}
.main_step_status_help {
    margin: 8px 0 0 !important;
    color: #8295ad !important;
    line-height: 1.5 !important;
}

.main_step_status_divider {
    width: 100% !important;
    height: 1px !important;
    margin: 0 0 20px !important;
    background: #e1e9f3 !important;
}

/* Last Updated */
.main_step_updated {
    margin: 0 !important;
}

.main_step_updated_date {
    display: flex !important;
    align-items: center !important;
    gap: 10px !important;
    color: #203650 !important;
    font-weight: 700;
}

.main_step_updated_date i {
    color: #8295ad !important;
}

.main_step_updated_date strong {
    font-weight: 600 !important;
}

/* Instructions card */
.main_step_instruction_card {
    width: 100% !important;
    margin-top: 15px !important;
    overflow: hidden !important;
    background: #fff !important;
    border: 1px solid #e1e9f3 !important;
    border-radius: 13px !important;
    box-shadow: 0 1px 3px rgba(25, 55, 90, .06) !important;
}

.main_step_instruction_header {
    display: flex !important;
    align-items: center !important;
    gap: 8px !important;
    padding: 14px !important;
    border-bottom: 1px solid #edf1f6 !important;
}

.main_step_instruction_header .title_box {
    margin: 0 !important;
    color: #43556d !important;
    font-weight: 600 !important;
}

.main_step_instruction_card .content_box {
    padding: 16px !important;
    color: #71849e !important;
    line-height: 1.6 !important;
}



.box_main_step_content {
    width: 100%;
    min-width: 0;
    padding: 20px;
    background: #f3f6fc;
    border-radius: 12px;
    box-sizing: border-box;
}

.box_main_step_content > .row {
    margin-left: -10px;
    margin-right: -10px;
    align-items: flex-start;
}

.box_main_step_content > .row > [class*="col-"] {
    padding-left: 10px;
    padding-right: 10px;
    margin-bottom: 20px;
    min-width: 0;
}
.col-form-label,.inpt_tour label {
    font-size: 17px ;
    font-weight: 800 !important;
    color: #162643 !important;
    margin-bottom: 5px !important;
}
.fa-plus-circle{
        font-size: 25px;
}
.box_main_step_content .main_step_navigation {
    background: #fff;
    border: 1px solid #e1e8f2;
    border-radius: 12px;
    padding: 16px;
    box-shadow: 0 2px 8px rgba(26, 54, 93, 0.04);
}
.btn-default {
    border-color: white !important;
}
.box_main_step_content .main_step_navigation_header {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 0 0 14px;
    margin-bottom: 10px;
    border-bottom: 1px solid #edf1f7;
    color: #263750;
    font-weight: 700;
}

/* QUICK PREVIEW */
.main_step_quick_preview {
    margin-top: 18px;
    overflow: visible;
}

.main_step_quick_preview_header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 16px;
}

.main_step_preview_link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    flex-shrink: 0;
    padding: 9px 14px;
    border: 1px solid #d8e2f0;
    border-radius: 9px;
    background: #fff;
    color: #173b68;
    font-weight: 600;
    text-decoration: none !important;
}

.main_step_preview_link:hover {
    border-color: #9db7dd;
    background: #f5f8fd;
}

.main_step_preview_card {
    display: grid;
    grid-template-columns: 220px minmax(0, 1fr);
    gap: 20px;
    padding: 16px;
    border: 1px solid #e0e9f5;
    border-radius: 11px;
    background: #fff;
}

.main_step_preview_image {
    width: 100%;
    height: 150px;
    overflow: hidden;
    border-radius: 9px;
    background: #edf3fa;
}

.main_step_preview_image img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.main_step_preview_content {
    min-width: 0;
}

.main_step_preview_country {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 10px;
    padding: 6px 10px;
    border-radius: 20px;
    background: #f0f5fc;
    color: #193957;
    font-size: 13px;
    font-weight: 600;
}

#categoryCountryPreviewCode {
    font-size: 12px;
    font-weight: 700;
}

#categoryCountryPreviewTitle {
    margin: 0 0 10px;
    color: #102b4d;
    font-size: 20px;
    font-weight: 700;
    line-height: 1.4;
}

#categoryCountryPreviewDescription {
    margin: 0 0 12px;
    color: #647a96;
    font-size: 14px;
    line-height: 1.6;
    overflow-wrap: anywhere;
}

.main_step_preview_tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.main_step_preview_tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 11px;
    border-radius: 20px;
    background: #eef3fb;
    color: #1a416f;
    font-size: 12px;
    font-weight: 600;
}



.box_main_step_content .main_step_navigation_header i {
    color: #2563eb;
}

.box_main_step_content .main_step_navigation_list {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.box_main_step_content .main_step_navigation_item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px;
    border-radius: 8px;
    color: #52627a;
    text-decoration: none;
    border: 1px solid transparent;
    transition: background .2s ease, color .2s ease;
}

.box_main_step_content .main_step_navigation_item i {
    width: 18px;
    text-align: center;
    color: #7c8ca5;
}

.box_main_step_content .main_step_navigation_item:hover {
    background: #f4f7fc;
    color: #2563eb;
}

.box_main_step_content .main_step_navigation_item.active {
    background: #edf4ff;
    border-color: #d8e6ff;
    color: #1d4ed8;
    font-weight: 700;
}

.box_main_step_content .main_step_navigation_item.active i {
    color: #2563eb;
}

/* Main content card */
.box_main_step_content .fill_data_box {
    width: 100%;
    min-width: 0;
		    padding: 0 !important;
}

.box_main_step_content .form_title_and_table_code {
    width: 100%;
    min-width: 0;
}

.box_main_step_content .main_step_content_card {
    width: 100%;
    background: #fff;
    border: 1px solid #e1e8f2;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(26, 54, 93, 0.04);
}

.box_main_step_content .main_step_card_header {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 20px;
    border-bottom: 1px solid #edf1f7;
}

.box_main_step_content .main_step_card_icon {
    display: flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 40px;
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: #edf4ff;
    color: #2563eb;
}

.box_main_step_content .main_step_card_heading {
    flex: 1;
    min-width: 0;
}

.box_main_step_content .main_step_card_heading .title_box {
    margin: 0 0 6px;
    color: #1e293b;
    font-weight: 700;
}

.box_main_step_content .main_step_card_heading p {
    margin: 0;
    color: #718096;
    line-height: 1.6;
}

.box_main_step_content .main_step_card_body {
    padding: 20px;
    min-width: 0;
}

.box_main_step_content .inpt_tour {
    margin-bottom: 22px;
}

.box_main_step_content .inpt_tour:last-child {
    margin-bottom: 0;
}


.box_main_step_content .inpt_tour .fieldarea {
    width: 100%;
    min-width: 0;
}

.box_main_step_content .inpt_tour select,
.box_main_step_content .inpt_tour input[type="text"],
.box_main_step_content .inpt_tour input[type="url"],
.box_main_step_content .inpt_tour textarea,
.box_main_step_content .inpt_tour .glSlBox,
.box_main_step_content .inpt_tour .slb {
    max-width: 100%;
    box-sizing: border-box;
    border: 1px solid #d8e1ed;
    border-radius: 8px;
    background-color: #fff;
}

.box_main_step_content .inpt_tour select,
.box_main_step_content .inpt_tour input[type="text"],
.box_main_step_content .inpt_tour input[type="url"] {
    min-height: 44px;
    padding: 10px 12px;
}

.box_main_step_content .inpt_tour textarea {
    padding: 12px;
}

.box_main_step_content .inpt_tour select:focus,
.box_main_step_content .inpt_tour input:focus,
.box_main_step_content .inpt_tour textarea:focus {
    border-color: #7aa7f8;
    outline: 0;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, .1);
}

/* Existing help content */
.box_main_step_content .text_help {
    margin-top: 8px;
    padding: 10px 12px;
    border-radius: 8px;
    background: #f8fafc;
    color: #64748b;
}

/* Right instruction card */
.box_main_step_content .main_step_instruction_card {
    padding: 16px;
    background: #fff;
    border: 1px solid #e1e8f2;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(26, 54, 93, 0.04);
}

.box_main_step_content .main_step_instruction_header {
    display: flex;
    align-items: center;
    gap: 9px;
    padding-bottom: 12px;
    margin-bottom: 12px;
    border-bottom: 1px solid #edf1f7;
}

.box_main_step_content .main_step_instruction_header .title_box {
    margin: 0;
    color: #334155;
    font-weight: 700;
}

.box_main_step_content .main_step_instruction_header .fa {
    color: #ef4444;
}

.box_main_step_content .main_step_instruction_card .content_box {
    color: #64748b;
    line-height: 1.7;
    overflow-wrap: anywhere;
    width: 100%;
}

/* Back and Save & Continue */
.box_main_step_content .btn_save_titile_table_code {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-top: 0 !important;
    padding: 16px 0 0;
}

.box_main_step_content .btn_save_titile_table_code a {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    min-height: 42px;
    padding: 10px 16px;
    border-radius: 8px;
    cursor: pointer;
    text-decoration: none;
    transition: background .2s ease, border-color .2s ease;
}

.box_main_step_content .btn_save_titile_table_code .back_step {
    color: #475569;
    background: #fff;
    border: 1px solid #d8e1ed;
    margin-left: auto;
}

.box_main_step_content .btn_save_titile_table_code .back_step:hover {
    background: #f8fafc;
    border-color: #b9c7d9;
}

.box_main_step_content .btn_save_titile_table_code .js_save_continue_main_step {
    background: #f58220;
    border: 1px solid #f58220;
}

.box_main_step_content .btn_save_titile_table_code .js_save_continue_main_step:hover {
    background: #e87310;
    border-color: #e87310;
}

/* Images and editor should not overflow the card */
.box_main_step_content .main_step_card_body img {
    height: 100%;
}

.box_main_step_content .main_step_card_body iframe {
    max-width: 100%;
}
.list_work_step_insert {
    width: 100%;
    padding: 8px;
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 13px;
    box-shadow: 0 2px 4px rgba(15, 23, 42, 0.04);
    box-sizing: border-box;
}

.list_work_step_insert .panel-group {
    margin: 0;
}

.list_work_step_insert .panel {
    margin: 0;
    background: transparent;
    border: 0;
    border-radius: 0;
    box-shadow: none;
}

.list_work_step_insert .panel-heading {
    padding: 0;
    background: transparent;
    border: 0;
    border-radius: 8px;
}

.list_work_step_insert .panel-heading > a {
    display: flex;
    align-items: center;
    min-height: 42px;
    padding: 10px 13px;
    color: #334155;
    text-decoration: none;
    border-radius: 8px;
    transition: background .2s ease, color .2s ease;
}

.list_work_step_insert .panel-heading > a:hover {
    background: #f3f6fb;
    color: #174a8b;
}

.list_work_step_insert .panel-heading.current > a {
    background: #e7edf7;
    color: #174a8b;
}

.list_work_step_insert .panel-title {
    display: flex;
    align-items: center;
    gap: 11px;
    width: 100%;
    margin: 0;
    color: inherit;
    font-weight: 600;
}

/* Main icons */
.list_work_step_insert .panel-title > i {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 17px;
    min-width: 17px;
    color: #54708f;
}

.list_work_step_insert .panel-heading.current .panel-title > i {
    color: #174a8b;
}

/* Collapse arrow */
.list_work_step_insert .panel-heading > a::after {
    content: "";
    width: 7px;
    height: 7px;
    margin-left: auto;
    border-top: 1.5px solid #8b9bb1;
    border-right: 1.5px solid #8b9bb1;
    transform: rotate(135deg);
    transition: transform .2s ease;
    flex-shrink: 0;
}

/* ==========================================
   MAIN STEP - TRAVEL STYLE / COUNTRY
========================================== */

.main_step_category_country {
    position: relative !important;
    overflow: visible !important;
}

.main_step_category_country .category-country-field {
    position: relative !important;
    margin: 0 0 20px !important;
    overflow: visible !important;
}

.main_step_category_country .category-country-field:last-child {
    margin-bottom: 0 !important;
}

.main_step_category_country .category-country-field > label {
    display: block !important;
    margin: 0 0 8px !important;
    color: #17324f !important;
    font-weight: 600 !important;
}

.main_step_category_country .category-country-field > label .required_red {
    color: #e54848 !important;
}

.main_step_category_country .category-country-field .fieldarea {
    position: relative !important;
    width: 100% !important;
    min-width: 0 !important;
    overflow: visible !important;
}

.main_step_category_country .category-country-control {
    position: relative !important;
    width: 100% !important;
    min-width: 0 !important;
    overflow: visible !important;
}

/* Select gốc: giữ lại cho validation và ISOCMS */
.main_step_category_country select.category-country-select {
    width: 100% !important;
    max-width: 100% !important;
    min-height: 52px !important;
    margin: 0 !important;
    box-sizing: border-box !important;
    border: 1px solid #d8cbb8 !important;
    border-radius: 5px !important;
    background-color: #fffefa !important;
    color: #17324f !important;
}

/* Khi custom JS đã khởi tạo select */
.main_step_category_country
.category-country-custom {
    position: relative !important;
    display: block !important;
    width: 100% !important;
    max-width: 100% !important;
    margin: 0 !important;
    overflow: visible !important;
    box-sizing: border-box !important;
}

.main_step_category_country
.category-country-custom__native {
    position: absolute !important;
    width: 1px !important;
    height: 1px !important;
    min-height: 0 !important;
    opacity: 0 !important;
    pointer-events: none !important;
}

/* Nút select */
.main_step_category_country
.category-country-custom__trigger {
    display: flex !important;
    align-items: center !important;
    position: relative !important;
    width: 100% !important;
    min-height: 52px !important;
    margin: 0 !important;
    padding: 10px 42px 10px 14px !important;
    border: 1px solid #d8cbb8 !important;
    border-radius: 5px !important;
    background: #fffefa !important;
    color: #17324f !important;
    text-align: left !important;
    box-shadow: none !important;
    cursor: pointer !important;
}

.main_step_category_country
.category-country-custom__trigger:focus {
    outline: none !important;
    border-color: #7399d0 !important;
    box-shadow: 0 0 0 2px rgba(54, 105, 180, .12) !important;
}

.main_step_category_country
.category-country-custom__trigger::before,
.main_step_category_country
.category-country-custom__trigger::after {
    content: none !important;
    display: none !important;
}

/* Icon và nội dung */
.main_step_category_country
.category-country-custom__icon {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    flex: 0 0 26px !important;
    width: 26px !important;
    margin-right: 10px !important;
    color: #638db9 !important;
}

.main_step_category_country
.category-country-custom__text {
    flex: 1 1 auto !important;
    min-width: 0 !important;
}

.main_step_category_country
.category-country-custom__name {
    display: block !important;
    overflow: hidden !important;
    color: #17324f !important;
    font-weight: 600 !important;
    text-overflow: ellipsis !important;
    white-space: nowrap !important;
}

.main_step_category_country
.category-country-custom__code {
    display: block !important;
    margin-top: 2px !important;
    color: #71849e !important;
}

/* Chỉ một mũi tên */
.main_step_category_country
.category-country-custom__arrow {
    position: absolute !important;
    top: 50% !important;
    right: 14px !important;
    margin: 0 !important;
    color: #7891ad !important;
    transform: translateY(-50%) !important;
}

.main_step_category_country
.category-country-custom.is-open
.category-country-custom__arrow {
    transform: translateY(-50%) rotate(180deg) !important;
}

/*
 * Menu được chuyển ra body bằng JS.
 * Không đặt menu trong card để tránh bị cắt.
 */
.category-country-custom__menu.category-country-menu-portal {
    position: fixed !important;
    display: block !important;
    z-index: 2147483000 !important;
    max-height: 280px !important;
    margin: 0 !important;
    padding: 5px !important;
    overflow-x: hidden !important;
    overflow-y: auto !important;
    border: 1px solid #dce5f0 !important;
    border-radius: 7px !important;
    background: #fff !important;
    box-shadow: 0 8px 24px rgba(20, 43, 73, .16) !important;
    box-sizing: border-box !important;
}

.category-country-custom__menu.category-country-menu-portal
.category-country-custom__option {
    display: flex !important;
    align-items: center !important;
    gap: 10px !important;
    width: 100% !important;
    min-height: 42px !important;
    margin: 0 !important;
    padding: 9px 10px !important;
    border: 0 !important;
    border-radius: 4px !important;
    background: #fff !important;
    color: #203650 !important;
    text-align: left !important;
    box-shadow: none !important;
    cursor: pointer !important;
}

.category-country-custom__menu.category-country-menu-portal
.category-country-custom__option:hover,
.category-country-custom__menu.category-country-menu-portal
.category-country-custom__option.is-selected {
    background: #eaf0f9 !important;
}

.category-country-custom__menu.category-country-menu-portal
.category-country-custom__check {
    flex: 0 0 16px !important;
    color: #174a8b !important;
    text-align: center !important;
}

/* Card không tạo thanh cuộn ngang */
.main_step_category_country,
.main_step_category_country .fieldarea {
    min-width: 0 !important;
}

.list_work_step_insert .panel-heading > a:not(.collapsed)::after {
    transform: rotate(-45deg);
}

/* Panel body */
.list_work_step_insert .panel-body {
    padding: 5px 0 8px;
    border: 0 !important;
    background: transparent;
}

/* Sub-step list */
.list_work_step_insert .stepbar-list {
    margin: 0;
    padding: 0 0 0 28px;
    list-style: none;
}

.list_work_step_insert .stepbar-list li {
    margin: 2px 0;
    padding: 0;
    list-style: none;
}
.box_left_opt_set .panel-heading a h4{
	background: none !important;
	box-shadow: unset !important;
	padding: 0 !important;
}
.list_work_step_insert .stepbar-list li a {
    display: block;
    padding: 8px 12px;
    color: #64748b;
    background: transparent;
    border-radius: 7px;
    text-decoration: none;
    line-height: 1.5;
    transition: background .2s ease, color .2s ease;
}
/* Icon ảnh Travel Style: thay icon Font Awesome bằng ảnh */
.category-country-custom .category-country-custom__image-icon {
    display: block !important;
    width: 26px !important;
    height: 20px !important;
    min-width: 26px !important;
    max-width: 26px !important;
    margin: 0 !important;
    padding: 0 !important;
    object-fit: cover !important;
    object-position: center !important;
    border: 0 !important;
    border-radius: 2px !important;
    background: transparent !important;
    flex: 0 0 26px !important;
}

/* Ảnh trong từng option của dropdown */
.category-country-custom .category-country-custom__option
.category-country-custom__image-icon {
    width: 24px !important;
    height: 18px !important;
    min-width: 24px !important;
    max-width: 24px !important;
    object-fit: cover !important;
    flex: 0 0 24px !important;
}
.box_left_opt_set .panel-body ul li a.active{
        color: #174a8b !important;
}
/* Country vẫn giữ icon quả địa cầu */
.category-country-field--country
.category-country-custom__icon i {
    color: #628bb7 !important;
    font-size: 14px !important;
}
.list_work_step_insert .stepbar-list li a:hover {
    color: #174a8b;
    background: #f5f7fb;
}
.box_left_opt_set .panel-body ul li a:hover{
    color: #174a8b !important;
}
/* Active sub-step */
.list_work_step_insert .stepbar-list li a.active {
    color: #174a8b;
    background: #f0f4fb;
    font-weight: 600;
}

/* Completed step */
.list_work_step_insert .stepbar-list li a.valid {
    color: #64748b;
}

/* Remove default Bootstrap panel borders */
.list_work_step_insert .panel-default,
.list_work_step_insert .panel-default > .panel-heading,
.list_work_step_insert .panel-collapse,
.list_work_step_insert .panel-body {
    border-color: transparent;
}

/* =====================================================
   CATEGORY COUNTRY CUSTOM SELECT
   Giữ class ISOCMS và ưu tiên CSS mới bằng !important
===================================================== */

.category-country-custom,
.category-country-custom * {
    box-sizing: border-box !important;
}

.category-country-custom {
    position: relative !important;
    display: block !important;
    width: 100% !important;
    min-width: 0 !important;
    margin: 0 !important;
    padding: 0 !important;
    border: 0 !important;
    background: transparent !important;
}

/* Ẩn select gốc nhưng vẫn giữ để submit form và chạy event */
.category-country-custom select.category-country-custom__native {
    position: absolute !important;
    left: 0 !important;
    bottom: 0 !important;
    width: 1px !important;
    height: 1px !important;
    min-width: 0 !important;
    margin: 0 !important;
    padding: 0 !important;
    opacity: 0 !important;
    pointer-events: none !important;
    clip: rect(0, 0, 0, 0) !important;
    clip-path: inset(50%) !important;
}
.booking-list-breadcrumb{
        margin-left: 26px;
    margin-top: 10px;
}
  .v2-breadcrumb, .booking-list-breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    padding-left: 5px;
}
.category-country-custom .category-country-custom__trigger {
    position: relative !important;
    display: flex !important;
    align-items: center !important;
    gap: 10px !important;
    width: 100% !important;
    min-width: 0 !important;
    min-height: 52px !important;
    margin: 0 !important;
    padding: 9px 40px 9px 14px !important;
    border: 1px solid #d4c8b6 !important;
    border-radius: 5px !important;
    background: #fffefa !important;
    color: #17324f !important;
    text-align: left !important;
    line-height: 1.4 !important;
    box-shadow: none !important;
    outline: none !important;
    cursor: pointer !important;
}
.p_tripcode a{
    color: #5c6b80;
}
.category-country-custom .category-country-custom__trigger:hover {
    border-color: #b8c8df !important;
}
.box_top_opt_set {
    padding: 14px;
}
.category-country-custom .category-country-custom__trigger:focus {
    border-color: #315fa8 !important;
    box-shadow: 0 0 0 2px rgba(49, 95, 168, .12) !important;
}
.v2-breadcrumb .fa-angle-right{
    color: #c7d2e0;
    font-size: 11px;
}
.v2-breadcrumb .fa-home,.p_tripcode .fa-arrow-left{
    margin-right: 6px;
}
.category-country-custom .category-country-custom__trigger::before,
.category-country-custom .category-country-custom__trigger::after {
    content: none !important;
    display: none !important;
}
.v2-breadcrumb a{
    font-size: 13px;
     color: #64748B;
}
.p_tripcode a:hover {
    color: #1b4581;
}
.category-country-custom .category-country-custom__trigger
.category-country-custom__icon {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    flex: 0 0 26px !important;
    width: 26px !important;
    min-width: 26px !important;
    margin: 0 !important;
    padding: 0 !important;
    color: #628bb7 !important;
}
.box_info_tour_top h1{
        font-size: 26px;
    font-weight: 800;
    color: #162643;
    letter-spacing: -.3px;
    margin-bottom: 8px;
}
/* Phần tên và mã */
.category-country-custom .category-country-custom__text {
    display: block !important;
    flex: 1 1 auto !important;
    min-width: 0 !important;
    margin: 0 !important;
    padding: 0 !important;
}

.category-country-custom .category-country-custom__name {
    display: block !important;
    margin: 0 !important;
    padding: 0 !important;
    overflow: hidden !important;
    color: #17324f !important;
    font-weight: 600 !important;
    text-overflow: ellipsis !important;
    white-space: nowrap !important;
}

.category-country-custom .category-country-custom__code {
    display: block !important;
    margin: 2px 0 0 !important;
    padding: 0 !important;
    color: #71849e !important;
}

/* Chỉ một mũi tên ở bên phải */
.category-country-custom .category-country-custom__arrow {
    position: absolute !important;
    top: 50% !important;
    right: 14px !important;
    display: block !important;
    margin: 0 !important;
    color: #7891ad !important;
    transform: translateY(-50%) !important;
    transition: transform .15s ease !important;
}

.category-country-custom.is-open
.category-country-custom__arrow {
    transform: translateY(-50%) rotate(180deg) !important;
}

/* Dropdown */
.category-country-custom .category-country-custom__menu {
    position: absolute !important;
    z-index: 100000 !important;
    top: calc(100% + 5px) !important;
    right: 0 !important;
    left: 0 !important;
    display: none !important;
    width: 100% !important;
    max-width: none !important;
    max-height: 280px !important;
    margin: 0 !important;
    padding: 5px !important;
    overflow-x: hidden !important;
    overflow-y: auto !important;
    border: 1px solid #dce5f0 !important;
    border-radius: 7px !important;
    background: #fff !important;
    box-shadow: 0 8px 24px rgba(20, 43, 73, .15) !important;
}

.category-country-custom.is-open
.category-country-custom__menu {
    display: block !important;
}

/* Từng option */
.category-country-custom .category-country-custom__option {
    display: flex !important;
    align-items: center !important;
    gap: 10px !important;
    width: 100% !important;
    min-width: 0 !important;
    min-height: 42px !important;
    margin: 0 !important;
    padding: 9px 10px !important;
    border: 0 !important;
    border-radius: 4px !important;
    background: #fff !important;
    color: #203650 !important;
    text-align: left !important;
    line-height: 1.4 !important;
    box-shadow: none !important;
    cursor: pointer !important;
}

.category-country-custom .category-country-custom__option::before,
.category-country-custom .category-country-custom__option::after {
    content: none !important;
    display: none !important;
}

.category-country-custom .category-country-custom__option:hover,
.category-country-custom .category-country-custom__option.is-selected {
    background: #eaf0f9 !important;
}

.category-country-custom .category-country-custom__option
.category-country-custom__icon {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    flex: 0 0 24px !important;
    width: 24px !important;
    margin: 0 !important;
    color: #628bb7 !important;
}

.category-country-custom .category-country-custom__option
.category-country-custom__text {
    display: flex !important;
    align-items: center !important;
    gap: 8px !important;
    flex: 1 1 auto !important;
    min-width: 0 !important;
}

.category-country-custom .category-country-custom__option
.category-country-custom__name {
    flex: 1 1 auto !important;
    min-width: 0 !important;
    white-space: normal !important;
}

.category-country-custom .category-country-custom__option
.category-country-custom__code {
    flex: 0 0 auto !important;
    margin: 0 0 0 auto !important;
    text-align: right !important;
    white-space: nowrap !important;
}

.category-country-custom .category-country-custom__check {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    flex: 0 0 16px !important;
    width: 16px !important;
    margin: 0 !important;
    color: #174a8b !important;
}

/* Đảm bảo select chiếm toàn bộ chiều rộng fieldarea */
.box_main_step_content .inpt_tour .fieldarea
> .category-country-custom {
    display: block !important;
    width: 100% !important;
    max-width: 100% !important;
}
.category-country-custom__image-icon {
    display: block !important;
    width: 24px !important;
    height: 24px !important;
    min-width: 24px !important;
    object-fit: cover !important;
    border-radius: 3px;
}
.box_top_opt_set .info_tour .body_tour{
    width: 100%;
}
.icon-white {
    margin-top: 4px;
}
@media (max-width: 991px) {
    .box_main_step_content {
        padding: 14px;
    }
.fill_data_box {
    display: inline-block;
    min-height: 30vh;
}
    .box_main_step_content .main_step_navigation_list {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

}

@media (max-width: 767px) {
    .box_main_step_content {
        padding: 10px;
        border-radius: 8px;
    }
    .list_work_step_insert {
        padding: 8px;
        border-radius: 11px;
    }
    .main_step_quick_preview_header {
        flex-direction: column;
    }
    .main_step_status_card {
        padding: 18px !important;
    }
    .main_step_preview_card {
        grid-template-columns: minmax(0, 1fr);
        gap: 14px;
        padding: 12px;
    }

    .main_step_preview_image {
        height: 190px;
    }

    #categoryCountryPreviewTitle {
        font-size: 18px;
    }
    .list_work_step_insert .panel-heading > a {
        min-height: 42px;
        padding: 10px 12px;
    }
    .category-country-custom .category-country-custom__menu {
        max-height: 230px !important;
    }

    .category-country-custom .category-country-custom__trigger {
        min-height: 50px !important;
        padding-right: 36px !important;
    }

    .category-country-custom .category-country-custom__option
    .category-country-custom__code {
        white-space: normal !important;
    }
    .list_work_step_insert .stepbar-list {
        display: flex;
    }
.box_top_opt_set.fixed {
    position: relative;

}
    .list_work_step_insert .stepbar-list li a {
        padding: 9px 12px;
    }
    .box_main_step_content > .row {
        margin-left: -6px;
        margin-right: -6px;
    }

    .box_main_step_content > .row > [class*="col-"] {
        padding-left: 6px;
        padding-right: 6px;
        margin-bottom: 12px;
    }

    .box_main_step_content .main_step_navigation,
    .box_main_step_content .main_step_content_card,
    .box_main_step_content .main_step_instruction_card {
        border-radius: 10px;
    }

    .box_main_step_content .main_step_card_header,
    .box_main_step_content .main_step_card_body {
        padding: 14px;
    }

    .box_main_step_content .main_step_navigation_list {
        grid-template-columns: minmax(0, 1fr);
    }

    .box_main_step_content .btn_save_titile_table_code {
        flex-wrap: wrap;
    }

    .box_main_step_content .btn_save_titile_table_code a {
        flex: 1 1 auto;
    }

    .box_main_step_content .btn_save_titile_table_code .js_save_continue_main_step {
        margin-left: 0;
    }
}

</style>
<script>
    
(function ($, window, document) {
    'use strict';

    var SELECTOR = '#cat_id, #slb_Country';

    function getOptionLabel(option) {
        return $.trim($(option).text());
    }

    function isPlaceholder(option, label) {
        return !option || !option.value ||
            /select category|select country|select travel style/i.test(label);
    }

function positionMenu() {
    if (!$wrapper.hasClass('is-open')) {
        return;
    }

    var rect = $trigger[0].getBoundingClientRect();
    var menuHeight = Math.min($menu[0].scrollHeight || 280, 280);
    var spaceBelow = window.innerHeight - rect.bottom;
    var spaceAbove = rect.top;
    var openAbove = spaceBelow < menuHeight + 10 &&
                    spaceAbove > spaceBelow;

    var top = openAbove
        ? Math.max(8, rect.top - menuHeight - 5)
        : rect.bottom + 5;

    $menu.css({
        position: 'fixed',
        top: top + 'px',
        left: rect.left + 'px',
        width: rect.width + 'px',
        right: 'auto',
        bottom: 'auto',
        zIndex: 2147483000
    });
}

function openMenu() {
    $('.category-country-custom').not($wrapper)
        .removeClass('is-open')
        .find('.category-country-custom__trigger')
        .attr('aria-expanded', 'false');

    $('.category-country-menu-portal').not($menu)
        .hide()
        .removeClass('category-country-menu-portal');

    $wrapper.addClass('is-open');
    $trigger.attr('aria-expanded', 'true');

    // Đưa menu ra khỏi card để tránh overflow của phần tử cha.
    $menu
        .addClass('category-country-menu-portal')
        .appendTo('body')
        .show();

    positionMenu();
}

function closeMenu() {
    $wrapper.removeClass('is-open');
    $trigger.attr('aria-expanded', 'false');

    // Trả menu về wrapper để JS có thể tái sử dụng.
    $menu
        .removeClass('category-country-menu-portal')
        .css({
            position: '',
            top: '',
            left: '',
            width: '',
            right: '',
            bottom: '',
            zIndex: ''
        })
        .hide()
        .appendTo($wrapper);
}

// Cập nhật vị trí khi cuộn trang hoặc thay đổi kích thước.
$(window)
    .off('.categoryCountryPosition')
    .on('scroll.categoryCountryPosition resize.categoryCountryPosition', function () {
        $('.category-country-custom.is-open').each(function () {
            var $openWrapper = $(this);
            var $openTrigger = $openWrapper.find(
                '.category-country-custom__trigger'
            );
            var $openMenu = $('body > .category-country-menu-portal');

            if ($openTrigger.length && $openMenu.length) {
                var rect = $openTrigger[0].getBoundingClientRect();

                $openMenu.css({
                    top: (rect.bottom + 5) + 'px',
                    left: rect.left + 'px',
                    width: rect.width + 'px'
                });
            }
        });
    });

    function initCategoryCountrySelects(context) {
        var $context = $(context || document);

        $context.find(SELECTOR).addBack(SELECTOR).each(function () {
            var select = this;
            var $select = $(select);

            // Không khởi tạo lần thứ hai.
            if ($select.data('category-country-initialized')) {
                refreshCategoryCountrySelect(select);
                return;
            }

            var isCountry = select.id === 'slb_Country';

            var $wrapper = $(
                '<div class="category-country-custom"></div>'
            );

            var $trigger = $(
                '<button type="button" ' +
                    'class="category-country-custom__trigger" ' +
                    'aria-haspopup="listbox" aria-expanded="false">' +
                    '<span class="category-country-custom__icon"></span>' +
                    '<span class="category-country-custom__text">' +
                        '<span class="category-country-custom__name"></span>' +
                        '<span class="category-country-custom__code"></span>' +
                    '</span>' +
                    '<i class="fa fa-chevron-down category-country-custom__arrow" aria-hidden="true"></i>' +
                '</button>'
            );

            var $menu = $(
                '<div class="category-country-custom__menu" role="listbox"></div>'
            );

            $select.data('category-country-initialized', true);

            // Wrapper thay thế vị trí hiển thị của select gốc.
            $select.before($wrapper);
            $wrapper.append($trigger, $menu, $select);
            $select.addClass('category-country-custom__native');

function iconHtml(option) {
    var image = option
        ? ($(option).attr('data-image') || '')
        : '';

    // Chỉ dùng icon quả địa cầu nếu không có ảnh.
    if (isCountry && !image) {
        return '<i class="fa fa-globe" aria-hidden="true"></i>';
    }

    if (!image) {
        image = (window.URL_IMAGES ||
            '/admin/isocms/templates/default/skin/images') +
            '/none_image.png';
    }

    var $img = $('<img>', {
        src: image,
        alt: '',
        class: 'category-country-custom__image-icon'
    });

    $img.on('error', function () {
        var fallback = (window.URL_IMAGES ||
            '/admin/isocms/templates/default/skin/images') +
            '/none_image.png';

        if (this.src !== fallback) {
            this.src = fallback;
        }
    });

    return $img.prop('outerHTML');
}
            function renderSelected() {
                var option = select.options[select.selectedIndex];
                var label = option ? getOptionLabel(option) : '';
                var placeholder = isPlaceholder(option, label);
                
                $trigger.find('.category-country-custom__icon').html(iconHtml(option));

                $trigger.find('.category-country-custom__name')
                    .text(label || (isCountry ? 'Select country' : 'Select category'));

                $trigger.find('.category-country-custom__code')
                    .text(!isCountry && !placeholder
                        ? 'Code: ' + option.value
                        : '');

                $trigger.toggleClass('is-placeholder', placeholder);
            }

            function renderOptions() {
                $menu.empty();

                $.each(select.options, function (_, option) {
                    var label = getOptionLabel(option);
                    var selected = option.selected;
                    var placeholder = isPlaceholder(option, label);

                    var $item = $(
                        '<button type="button" ' +
                            'class="category-country-custom__option" ' +
                            'role="option"></button>'
                    );

                    var $icon = $('<span class="category-country-custom__icon"></span>');
                    var $text = $('<span class="category-country-custom__text"></span>');
                    var $name = $('<span class="category-country-custom__name"></span>');
                    var $code = $('<span class="category-country-custom__code"></span>');
                    var $check = $('<span class="category-country-custom__check"></span>');

                    $icon.html(iconHtml(option));
                    $name.text(label);

                    if (!isCountry && !placeholder) {
                        $code.text('Code: ' + option.value);
                    }

                    $text.append($name, $code);
                    $check.html(selected
                        ? '<i class="fa fa-check" aria-hidden="true"></i>'
                        : '');

                    $item.attr('aria-selected', selected ? 'true' : 'false');
                    $item.toggleClass('is-selected', selected);
                    $item.append($icon, $text, $check);

                    $item.on('click', function (event) {
                        event.preventDefault();

                        if (option.disabled) {
                            return;
                        }

                        // Để native select phát sinh change cho code ISOCMS.
                        if (select.value !== option.value) {
                            select.value = option.value;
                            $select.trigger('change');
                        } else {
                            renderSelected();
                            renderOptions();
                        }

                        closeMenu($wrapper, $trigger);
                    });

                    $menu.append($item);
                });
            }

                $trigger.on('click', function (event) {
                    event.preventDefault();
                    event.stopPropagation();

                    var isOpen = $wrapper.hasClass('is-open');

                    closeAllCategoryCountryMenus();

                    if (!isOpen) {
                        $wrapper.addClass('is-open');
                        $trigger.attr('aria-expanded', 'true');

                        // Đưa lựa chọn đang chọn vào vùng nhìn thấy nếu cần.
                        var $selected = $menu.find('.is-selected');
                        if ($selected.length) {
                            $menu.scrollTop(
                                Math.max(0, $selected.position().top -
                                    $menu.height() / 2)
                            );
                        }
                    }
                });

                $select.on('change.categoryCountryCustom', function () {
                    renderSelected();
                    renderOptions();
                });

                $wrapper.on('keydown', function (event) {
                    if (event.key === 'Escape') {
                        closeMenu($wrapper, $trigger);
                        $trigger.trigger('focus');
                    }
                });

            function closeMenu($wrap, $button) {
                $wrap.removeClass('is-open');
                $button.attr('aria-expanded', 'false');
            }

            renderSelected();
            renderOptions();
        });
    }

    function closeAllCategoryCountryMenus() {
        $('.category-country-custom.is-open').each(function () {
            $(this)
                .removeClass('is-open')
                .find('.category-country-custom__trigger')
                .attr('aria-expanded', 'false');
        });
    }

    function refreshCategoryCountrySelect(select) {
        var $select = $(select);
        var $wrapper = $select.closest('.category-country-custom');

        if (!$wrapper.length) {
            return;
        }

        var isCountry = select.id === 'slb_Country';
        var option = select.options[select.selectedIndex];
        var label = option ? getOptionLabel(option) : '';
        var placeholder = isPlaceholder(option, label);

        $wrapper.find('.category-country-custom__icon').html(
            isCountry
                ? '<i class="fa fa-globe" aria-hidden="true"></i>'
                : '<img alt=""  src="/files/thumb?w=250&amp;h=170&amp;src=/isocms/templates/default/skin/images/noimage.png" >'
        );

        $wrapper.find('.category-country-custom__name')
            .first()
            .text(label || (isCountry ? 'Select country' : 'Select category'));

        $wrapper.find('.category-country-custom__code')
            .first()
            .text(!isCountry && !placeholder ? 'Code: ' + option.value : '');

        $wrapper.find('.category-country-custom__trigger')
            .toggleClass('is-placeholder', placeholder);

        var $menu = $wrapper.find('.category-country-custom__menu').empty();

        $.each(select.options, function (_, item) {
            var itemLabel = getOptionLabel(item);
            var selected = item.selected;
            var itemPlaceholder = isPlaceholder(item, itemLabel);

            var $row = $('<button type="button" class="category-country-custom__option" role="option"></button>');
            var $icon = $('<span class="category-country-custom__icon"></span>');
            var $text = $('<span class="category-country-custom__text"></span>');
            var $name = $('<span class="category-country-custom__name"></span>');
            var $code = $('<span class="category-country-custom__code"></span>');
            var $check = $('<span class="category-country-custom__check"></span>');

            $icon.html(isCountry
                ? '<i class="fa fa-globe" aria-hidden="true"></i>'
                : '<i class="fa fa-picture-o" aria-hidden="true"></i>');

            $name.text(itemLabel);

            if (!isCountry && !itemPlaceholder) {
                $code.text('Code: ' + item.value);
            }

            $text.append($name, $code);
            $check.html(selected ? '<i class="fa fa-check" aria-hidden="true"></i>' : '');

            $row.attr('aria-selected', selected ? 'true' : 'false')
                .toggleClass('is-selected', selected)
                .append($icon, $text, $check);

            $row.on('click', function (event) {
                event.preventDefault();

                if (item.disabled) {
                    return;
                }

                if (select.value !== item.value) {
                    select.value = item.value;
                    $select.trigger('change');
                }

                closeAllCategoryCountryMenus();
            });

            $menu.append($row);
        });
    }

    $(function () {
        initCategoryCountrySelects(document);
    });

    $(document).on('click.categoryCountryCustom', function (event) {
        if (!$(event.target).closest('.category-country-custom').length) {
            closeAllCategoryCountryMenus();
        }
    });

    // Gọi sau khi form được nạp hoặc thay thế bằng AJAX.
    window.initCategoryCountrySelects = function (context) {
        initCategoryCountrySelects(context || document);
    };

    window.refreshCategoryCountrySelect = refreshCategoryCountrySelect;

})(jQuery, window, document);

(function ($) {
	'use strict';

	function initMainStepEditor() {
		if (typeof $.fn.isoTextArea === 'function') {
			$('.textarea_intro_editor').each(function () {
				var $editor = $(this);

				if (!$editor.data('main-step-editor-initialized')) {
					$editor.isoTextArea();
					$editor.data('main-step-editor-initialized', true);
				}
			});
		}
	}

	$(document).ready(function () {
		initMainStepEditor();

		$(document)
			.off('click.mainStepToggle', '.toggle-row')
			.on('click.mainStepToggle', '.toggle-row', function () {
				$(this).closest('tr').toggleClass('open_tr');
			});
	});

})(jQuery);

(function ($) {
    'use strict';

    function updateMainStepStatus(isActive) {
        var $toggle = $('#main_step_status_toggle');

        if (!$toggle.length) {
            return;
        }

        var $control = $toggle.closest('.main_step_status_control');

        $toggle.prop('checked', !!isActive);
        $toggle.attr('data-val', isActive ? '1' : '0');

        $control.toggleClass('is-active', !!isActive);
        $control.find('.main_step_status_text')
            .text(isActive ? 'Active' : 'Inactive');
    }

    $(document).on('change', '#main_step_status_toggle', function () {
        var $toggle = $(this);
        var oldValue = parseInt($toggle.attr('data-val'), 10) || 0;
        var newValue = $toggle.is(':checked') ? 1 : 0;

        var id = $toggle.attr('data-sourse_id');

        if (!id) {
            updateMainStepStatus(oldValue === 1);
            alertify.error('Không tìm thấy ID bản ghi.');
            return;
        }

        $toggle.prop('disabled', true);

        $.ajax({
            type: 'POST',
            url: path_ajax_script + '/?mod=' + mod +
                '&act=ajCheckPublicCategoryCountry',
            dataType: 'json',
            data: {
                id: id,
                is_online: newValue
            },
            success: function (json) {
                if (json && json.result === '_SUCCESS') {
                    updateMainStepStatus(newValue === 1);

                    // Đồng bộ nút Public / Private hiện có.
                    var $publicButton = $('.toggle_opt .online_tour').first();

                    if ($publicButton.length) {
                        if (newValue === 1) {
                            $publicButton
                                .removeClass('private_tour')
                                .attr('data-val', '0')
                                .attr('data-text_last', 'Private')
                                .html(
                                    '<i class="fa-solid fa-house"></i> Public'
                                );
                        } else {
                            $publicButton
                                .addClass('private_tour')
                                .attr('data-val', '1')
                                .attr('data-text_last', 'Public')
                                .html(
                                    '<i class="fa-solid fa-lock"></i> Private'
                                );
                        }
                    }

                    // alertify.success('Cập nhật trạng thái thành công.');
                } else {
                    updateMainStepStatus(oldValue === 1);
                    // alertify.error('Không thể cập nhật trạng thái.');
                }
            },
            error: function () {
                updateMainStepStatus(oldValue === 1);
                alertify.error('Lỗi kết nối khi cập nhật trạng thái.');
            },
            complete: function () {
                $toggle.prop('disabled', false);
            }
        });
    });

    $(function () {
        var $toggle = $('#main_step_status_toggle');

        if ($toggle.length) {
            updateMainStepStatus($toggle.is(':checked'));
        }
    });

})(jQuery);

</script>
{/literal}