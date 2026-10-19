$(function(){
    function eventHotelAjax($_this, mod, act, formName){
        let type = $_this.data('type');
        let id = $_this.data('id');
        let pKey = $_this.data('key');
        let dataType = type == 'F' ? 'html' : 'json';
        
        if(type == 'D'){
            if(!confirm(confirm_delete)){
                return false;
            }
        }
        let dataAjax = {};
        dataAjax['type'] = type;
        dataAjax[pKey] = id;
        
        $.ajax({
            type: "POST",
            url: path_ajax_script + "/index.php?mod="+mod+"&act=" + act + "&lang=" + LANG_ID,
            data: dataAjax,
            dataType: dataType,
            beforeSend: function(){
                vietiso_loading(1);
            },
            success: function (res) {
                vietiso_loading(0);
                if(type == 'F'){
                    makepopup("80%", "", res, formName);
                }else{
                    if(res.result){
                        window.location.reload();
                    }else{
                        alertify.error(res.msg);
                    }
                }
            },
        });
        return false;
    }

    //Event service
    $(document)
    .on('click', '.iso_event_hotel_services', function(){
        eventHotelAjax($(this), 'hotel', 'ajaxEventHotelService', 'frmHotelService');
    })
    .on('click', '.iso_submitFormClick', function(){
        var _thisClose = $(this).parents('.modal-footer').find('.close_pop');

        let form = $(this).parents('form');
        form.validate();

        let dataAjax = form.serializeArray();
        dataAjax.push({name: "type", value: "S"});

        $.ajax({
            type: "POST",
            url: path_ajax_script + "/index.php?mod=hotel&act=ajaxEventHotelService&lang=" + LANG_ID,
            data: dataAjax,
            dataType: "json",
            beforeSend: function(){
                vietiso_loading(1);
            },
            success: function (json) {
                vietiso_loading(0);
                if(json.result){
                    if(act != 'hotel_package_services'){
                        loadLstServices();
                        _thisClose.trigger('click');
                    }else{
                        window.location.reload();
                    }
                }else{
                    alertify.error(json.msg);
                }
            },
        });
        return false;
    });

    //Event package
    let lstPackageServices = [];
    
    function loadLstPackageService(){
       
        $('.iso_package_services .accordion_in').each(function(){
            let hotel_service_id = $(this).find('.lst_hotel_service_id').val();
            let editorId = $(this).find('.textarea_intro_editor').attr('id');
            let intro = $Core.util.getTextAreaContent(editorId);
            let title = $(this).find('.acc_head_txt').text();
            // Tìm phần tử trong lstPackageServices
            let existingItem = lstPackageServices.find(function(item) {
                return item.hotel_service_id == hotel_service_id;
            });

            if (existingItem) {
                // Nếu tồn tại -> cập nhật lại intro và title
                existingItem.intro = intro;
                existingItem.title = title;
            } else {
                // Nếu chưa có -> thêm mới
                lstPackageServices.push({
                    hotel_service_id: hotel_service_id,
                    title: title,
                    intro: intro
                });
            }
        });
 
    }
    $(document)
    .on('click', '.iso_event_hotel_packages', function(){
        eventHotelAjax($(this), 'hotel', 'ajaxEventHotelPackage', 'frmHotelPackage');
        loadLstPackageService(); //Lấy danh sách service của package khi vừa load popup
    })
    //Chọn service
    .on('click', '.btn_load_service', function(){
        //Lấy id danh sách service đã chọn 
        loadLstServices();
    })
    .on('click', '.iso_btn_service .btn_close', function(){
        $('.iso_box_service').addClass('hidden');
    })
    .on('click', '.iso_btn_service .btn_apply', function(){
        loadLstPackageService(); //Lấy thông tin danh sách service của package trước khi xử lý các thay đổi

        let orderedHotelServiceIds = []; //Danh sách dùng để sắp xếp services

        $('.hotel_service_id').each(function(){
            let hotel_service_id = $(this).val();
            orderedHotelServiceIds.push(hotel_service_id); //Thêm id vào danh sách sắp xếp
            if($(this).prop('checked')){
                let title = $(this).parents('.service').find('.title').text();

                //Kiểm tra nếu id chưa tồn tại và được chọn mới trong mảng thì sẽ thêm mới service vào mảng
                let exists = $.grep(lstPackageServices, function(item) {
                    return item.hotel_service_id == hotel_service_id;
                }).length > 0;
    
                if(!exists){
                    lstPackageServices.push({hotel_service_id: hotel_service_id, title:title, intro: ''});
                }
            }else{
                // Nếu không checked, xóa phần tử khỏi mảng
                lstPackageServices = lstPackageServices.filter(function(item) {
                    return item.hotel_service_id != hotel_service_id;
                });
            }
        });

        // Sắp xếp lại lstPackageServices theo thứ tự xuất hiện trong DOM (dựa vào orderedHotelServiceIds)
        lstPackageServices.sort(function(a, b) {
            return orderedHotelServiceIds.indexOf(a.hotel_service_id) - orderedHotelServiceIds.indexOf(b.hotel_service_id);
        });

        renderLstPackageServices(); //DOM html
        $('.iso_box_service').addClass('hidden');
    })
    .on('click', '.acc_head_delete', function(e){
        e.preventDefault();
        if(confirm(confirm_delete)){
            let id_remove = $(this).parents('.accordion_in').find('.lst_hotel_service_id').val();
            // Nếu không checked, xóa phần tử khỏi mảng
            lstPackageServices = lstPackageServices.filter(function(item) {
                return item.hotel_service_id != id_remove;
            });
            if($(`#iso_hotel_service_${id_remove}`)){
                $(`#iso_hotel_service_${id_remove}`).prop('checked', false);
            }
            $(this).parents('.accordion_in').remove();
            if($('.accordion_in').first()){
                $('.accordion_in').first().addClass('acc_active').find('.acc_content').show();
            }
        }
    })
    .on('click', '.iso_submitFormPackage', function(){
        let form = $(this).parents('form');
        form.validate();

        loadLstPackageService();
        
        let title = form.find('input[name="title"]').val();
        let hotel_package_id = form.find('input[name="hotel_package_id"]').val();
        let dataAjax = {
            hotel_package_id: hotel_package_id,
            title: title,
            type: 'S',
            lstPackageServices: lstPackageServices
        };

        $.ajax({
            type: "POST",
            url: path_ajax_script + "/index.php?mod=hotel&act=ajaxEventHotelPackage&lang=" + LANG_ID,
            data: dataAjax,
            dataType: "json",
            beforeSend: function(){
                vietiso_loading(1);
            },
            success: function (json) {
                vietiso_loading(0);
                if(json.result){
                    window.location.reload();
                }else{
                    alertify.error(json.msg);
                }
            },
        });
        return false;
    });
    
    function renderLstPackageServices(){
        if(lstPackageServices.length > 0){
            let html = '';
            let timestampMs = Date.now();
            $.each(lstPackageServices, function(index, item){
                let hotel_service_id = item.hotel_service_id;
                let title = item.title;
                let intro = item.intro;
                html += `
                    <div class="accordion_in">
                        <input type="hidden" class="lst_hotel_service_id" value="${hotel_service_id}">
                        <div class="acc_head">
                            <div class="acc_icon_expand"></div>
                            <div class="iso_accordion">
                                <div class="acc_head_txt">${title}</div>
                                <div class="acc_head_delete">
                                    <i class="icon-trash"></i>
                                </div>
                            </div>
                        </div>
                        <div class="acc_content" style="display: none">
                            <textarea id="textarea_intro_${timestampMs}_${hotel_service_id}" class="textarea_intro_editor">${intro}</textarea>
                        </div>
                    </div>
                `;
            });

            $('.iso_package_services .accordion').html(html);
            loadTextAreaEditor(); //Load Editor cho textarea

            $('.accordion_in').removeClass('.acc_content');
            if($('.accordion_in').first()){
                $('.accordion_in').first().addClass('acc_active').find('.acc_content').show();
            }
        }
    }

    function loadLstServices(){   

        $.ajax({
            type: "POST",
            url: path_ajax_script + "/index.php?mod=hotel&act=ajaxLoadLstServices&lang=" + LANG_ID,
            data: {},
            dataType: "json",
            beforeSend: function(){
                vietiso_loading(1);
            },
            success: function (json) {
                vietiso_loading(0);
                if(json.result){
                    loadLstPackageService();
                    let lstServices = json.lstServices;
                    let html = '';
                    $.each(lstServices, function(index, item){
                        let hotel_service_id = item.hotel_service_id;
                        let title = item.title;
                        let exists = $.grep(lstPackageServices, function(item) {
                            return item.hotel_service_id == hotel_service_id;
                        }).length > 0;
                        html += `
                            <div class="col-12 col-md-6 col-lg-3">
                                <label class="service" for="iso_hotel_service_${hotel_service_id}">
                                    <input id="iso_hotel_service_${hotel_service_id}" type="checkbox" class="hotel_service_id" value="${hotel_service_id}" ${exists ? 'checked' : ''}>
                                    <span class="title">${title}</span>
                                </label>
                            </div>
                        `;
                    });
                    $('#iso_lst_services').html(html);
                }

                $('.iso_box_service').removeClass('hidden');
            },
        });

        return false;
    }

    function loadTextAreaEditor(){
        if ($('.textarea_intro_editor').length > 0) {
            $('.textarea_intro_editor').each(function () {
                var $_this = $(this);
                var $editorID = $_this.attr('id');
                $('#' + $editorID).isoTextAreaFull();
            });
        }
    }
});