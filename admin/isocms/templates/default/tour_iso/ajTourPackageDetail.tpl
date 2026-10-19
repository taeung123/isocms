<div id="form_tour_package">
    <div class="box_title_trip_code">
        <div class="full-height">
            <div class="fill_data_box">
                <h3 class="title_box">{$core->get_Lang('Tour Package Detail')}</h3>
                <ul class="nav nav-tabs mb30">
                    <li class="active"><a class="tab_item" href="#general" data-toggle="tab">{$core->get_Lang("General")}</a></li>
                    <li><a class="tab_item" href="#price_config" data-toggle="tab">{$core->get_Lang("Price config")}</a></li>
                    <li><a class="tab_item tab_item_price_table" href="#price_table" data-toggle="tab">{$core->get_Lang("Price table")}</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="general">
                        <form action="" method="post"  enctype="multipart/form-data" class="validate-form" id="form_general">
                            <div class="form-group inpt_tour">
                                <label class="col-form-label" for="title">
                                    {$core->get_Lang('Title')} <span class="required_red">*</span>
                                </label>
                                <input class="form-control input-lg required" type="text" id="title" name="title" value="{$oneTourPackage.title}">
                            </div>
                            {if $clsISO->getCheckActiveModulePackage($package_id,'tour_exhautive','property','default','TOURGUIDE')}
                                <div class="form-group inpt_tour">
                                    <label class="col-form-label" for="title">
                                        {$core->get_Lang('Tour guide')}
                                    </label>
                                    <div class="fieldarea">
                                        {foreach from=$listTourGuide item=$item}
                                            <label style="margin-right: 12px">
                                                <input type="checkbox" name="tour_guide[]" value="{$item.tour_property_id}">
                                                {$item.title}
                                            </label>
                                        {/foreach}
                                    </div>
                                </div>
                            {/if}
                            <div class="form-group inpt_tour">
                                <label for="title">{$core->get_Lang('Overview')}</label>
                                <div class="row-span">
                                    <textarea style="width:100%" name="overview" class="textarea_intro_editor" data-column="intro" id="textarea_editor_overview_{$now}" cols="255" rows="2">{$oneTourPackage.overview}</textarea>
                                </div>
                            </div>
                            <input type="hidden" value="{$oneTourPackage.tour_package_id}" name="tour_package_id">
                            <input type="hidden" value="{$pvalTable}" name="tour_id">
                        </form>
                    </div>
                    <div class="tab-pane fade" id="price_config">
                        <form action="" method="post"  enctype="multipart/form-data" class="validate-form" id="form_price_config">
                            <label class="col-form-label fs-20"><strong>{$core->get_Lang('Group size')}</strong></label>
                            <div class="form-group ">
                                <label class="col-form-label"><strong>{$core->get_Lang('Adult')}</strong></label>
                                <div class="admin-toolbar-action mt-0">
                                    <a class="text-link" href="{$PCMS_URL}/?&mod=tour_exhautive&act=property&type=SIZEGROUP" target="_blank"> {$core->get_Lang('Manage')}</a>
                                </div>
                                <div id="slb_ContainerAdultSizeGroup">
                                    <select name="adult_size_group[]" id="adult_size_group" class="chosen-select required" multiple="multiple">
                                        {$clsTourOption->makeSelectboxOption2($tour_option_id_str,'SIZEGROUP',$adult_type_id)}
                                    </select>
                                </div>
                            </div>
                            <!--price new-->
                            <div class="form-group">
                                <div class="box_top_form_group d-flex align-items-center justify-content-between mb10">
                                    <div class="box_option">
                                        <label class="col-form-label label_w"><strong>{$core->get_Lang('Children')}</strong></label>
                                        <select class="type_visitor_package" name="type_visitor_child" data-id="slb_ContainerChildSizeGroup" data-tour_id="{$pvalTable}" data-type="children">
                                            <option value="{$age_type_id}" {if $oneTourPackage.type_visitor_child eq $age_type_id}selected{/if}>{$core->get_Lang("Age")}</option>
                                            <option value="{$height_type_id}" {if $oneTourPackage.type_visitor_child eq $height_type_id}selected{/if}>{$core->get_Lang("Height")}</option>
                                        </select>
                                    </div>
                                    <div class="admin-toolbar-action mt-0">
                                        <a class="text-link fr" href="{$PCMS_URL}/?&mod=tour_exhautive&act=property&type=SIZEGROUP" target="_blank"> {$core->get_Lang('Manage')}</a>
                                    </div>
                                </div>
                                <div id="slb_ContainerChildSizeGroup">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="box_top_form_group d-flex align-items-center justify-content-between mb10">
                                    <div class="box_option">
                                        <label class="col-form-label label_w"><strong>{$core->get_Lang('Infant')}</strong></label>
                                        <select class="type_visitor_package" name="type_visitor_infant" data-id="slb_ContainerInfantSizeGroup" data-tour_id="{$pvalTable}" data-type="infant">
                                            <option value="{$age_type_id}" {if $oneTourPackage.type_visitor_infant eq $age_type_id}selected{/if}>{$core->get_Lang("Age")}</option>
                                            <option value="{$height_type_id}" {if $oneTourPackage.type_visitor_infant eq $height_type_id}selected{/if}>{$core->get_Lang("Height")}</option>
                                        </select>
                                    </div>
                                    <div class="admin-toolbar-action mt-0">
                                        <a class="text-link fr" href="{$PCMS_URL}/?&mod=tour_exhautive&act=property&type=SIZEGROUP" target="_blank"> {$core->get_Lang('Manage')}</a>
                                    </div>
                                </div>
                                <div id="slb_ContainerInfantSizeGroup">
                                </div>
                            </div>
                            <input type="hidden" value="{$oneTourPackage.tour_package_id}" name="tour_package_id">
                            <input type="hidden" value="{$pvalTable}" name="tour_id">
                        </form>
                        <!--end price new-->
                    </div>
                    <div class="tab-pane fade" id="price_table">
                        <form action="" method="post"  enctype="multipart/form-data" class="validate-form" id="form_price_table">
                            <div class="table-wrapper mb-half radius-3 loadPriceConfig">
                                
                            </div>
                            <input type="hidden" value="{$oneTourPackage.tour_package_id}" name="tour_package_id">
                            <input type="hidden" value="{$pvalTable}" name="tour_id">
                        </form>
                    </div>
                </div>
                <div class="btn_save_titile_trip_code">
                    <a class="back_list_tour_package back_step" tour_id="{$pvalTable}" cat_run="{$cat_run}">{$core->get_Lang('Back')}</a>
                    <a class="save_tour_package">{$core->get_Lang('Save')}</a>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    #form_tour_package ul.nav-tabs {
        margin-left: 0 !important;
    }
    #form_tour_package li > a:hover, #form_tour_package li.active > a{
        border: none !important;
        border-bottom: 2px solid var(--main-bg-color, #333) !important;
        color: #000 !important;
        font-weight: bold !important;
    }
</style>
<script>
    const tour_package_id = '{$oneTourPackage.tour_package_id}';
    $(document).ready(function(){
        $(".back_list_tour_package").click(function() {
            loadTourPackage(tour_id);
        });

        $(".type_visitor_package").each(function(index,element){
            let $_this = $(element);
            let $id = $_this.data('id');
            let $type = $_this.data('type');
            let $type_visitor = $_this.val();
            ajOptionPriceTourPackage(tour_id,$type_visitor,$id,$type);
        });

        $(document).on('change', '.type_visitor_package', function(){
            let $_this = $(this);
            let $id = $_this.data('id');
            let $type = $_this.data('type');
            let $type_visitor = $_this.val();
            ajOptionPriceTourPackage(tour_id,$type_visitor,$id,$type);
        });

        $(".save_tour_package").click(function(e) {
            e.preventDefault();
            // Tìm tab đang mở
            const activeForm = $('.tab-pane.active').find('form');

            if (!activeForm.length) {
                alert('Không tìm thấy form trong tab đang mở');
                return;
            }
            const formId = activeForm.attr('id');

            // Xử lý theo form
            if (formId === 'form_general') {
                saveGeneral(activeForm);
            } else if (formId === 'form_price_config') {
                savePriceConfig(activeForm);
            } else if (formId === 'form_price_table') {
                savePriceTable(activeForm);
            }
        });

        $(".tab_item_price_table").click(function(e) {
            let formData = new FormData($("#form_price_table")[0]);
            formData.append("tp", "L");
            $.ajax({
                type: "POST",
                url: path_ajax_script + '/?mod=tour_exhautive&act=ajLoadTPPriceTable',
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function (res) {
                    $(".loadPriceConfig").html(res.html)
                }
            });
        });
    });

    function saveGeneral(form){
        let formData = new FormData(form[0]);
        let _validated = 0;
        var $editorID = $('.textarea_intro_editor').attr('id');

        if($('input.required,select.required,textarea.required', form).length){
            $('input.required,select.required,textarea.required', form).each(function(index, elm){
                if($Core.util.isEmpty($(this).val())){
                    _validated++;
                    $(this).focus();
                    $(this).addClass('error');
                    if($(this).hasClass('chosen-select') && $(this).attr('multiple') == 'multiple'){
                        $(this).next().addClass('error');
                    }
                    return false;

                }else{
                    $(this).removeClass('error');
                    if($(this).hasClass('chosen-select') && $(this).attr('multiple') == 'multiple'){
                        $(this).next().removeClass('error');
                    }
                }
            });
        }

        let overview = tinyMCE.get($editorID).getContent();
        let frag = document.createElement('div');
        frag.innerHTML = overview;
        let itemsBase64 = [...frag.querySelectorAll('img')]
            .filter(img => img.getAttribute('src').startsWith('data'))
            .map(img => img.getAttribute('src'));
        if (itemsBase64.length) {
            $.ajax({
                type: "POST",
                url: PCMS_URL + '/index.php?mod=ajax&act=convertBase64toImage',
                data: {
                    intro: overview
                },
                async: false,
                dataType: 'json',
                success: function (res) {
                    overview = res.intro;
                }
            });
        }

        if(_validated > 0){
            return false;
        }
        formData.append('overview', overview);
        $.ajax({
            type: "POST",
            url: path_ajax_script + '/?mod=tour_exhautive&act=ajSaveTourPackage',
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function (res) {
                vietiso_loading(0);
                if(res.result){
                    alertify.success(res.message);
                    // loadTourPackage(tour_id);
                }else{
                    alertify.error(res.message);
                }
            }
        });
    }

    function savePriceConfig(form) {
        let formData = new FormData(form[0]);
        $.ajax({
            type: "POST",
            url: path_ajax_script + '/?mod=tour_exhautive&act=ajTourPackagePriceCfg',
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function (res) {
                vietiso_loading(0);
                if(res.result){
                    alertify.success(res.message);
                }else{
                    alertify.error(res.message);
                }
            }
        });
    }

    function savePriceTable(form) {
        let formData = new FormData(form[0]);
        formData.append("tp", "S");
        $.ajax({
            type: "POST",
            url: path_ajax_script + '/?mod=tour_exhautive&act=ajLoadTPPriceTable',
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function (res) {
                vietiso_loading(0);
                if(res.result){
                    alertify.success(res.message);
                }else{
                    alertify.error(res.message);
                }
            }
        });
    }

    function ajOptionPriceTourPackage($tour_id,$type_visitor,$id,$type){
        $.ajax({
            type: "POST",
            url: path_ajax_script+"/?mod=tour_exhautive&act=ajOptionPriceTourPackage",
            data:{
                'tour_id':$tour_id,
                'type_visitor':$type_visitor,
                'type':$type,
                'tour_package_id':tour_package_id,
            },
            dataType: "html",
            success: function(html){
                $("#"+$id).html(html);
            }
        });
    }
</script>
