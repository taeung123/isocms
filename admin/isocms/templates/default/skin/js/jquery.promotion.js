var aj_search = '';
function isValidDate(date) {
    var pattern = /^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$/;
    return pattern.test(date);
}
$().ready(function() {
	$(document).on('click', '#clickAddPromotion', function(ev) {
		var $_this = $(this);
		vietiso_loading(1);
		$.ajax({
			type: "POST",
			url: path_ajax_script + '/?mod=promotion&act=ajAddPromotion',
			data: {
				'type': $_this.attr('type'),
				'clsTable': $_this.attr('clsTable'),
				'target_id': $_this.attr('target_id'),
			},
			dataType: "html",
			success: function(html) {
				vietiso_loading(0);
				loadPromotion($_this.attr('target_id'),$_this.attr('clsTable'));
			}
		});
		return false;
	});
	$(document).on('click', '.clickEditPromotion', function(ev) {
        var $_this = $(this);
        vietiso_loading(1);
        $.ajax({
            type: "POST",
            url: path_ajax_script + '/index.php?mod=promotion&act=ajLoadPromotionItem',
            data: {
                'promotion_id': $_this.attr('promotion_id'),
                'target_id': $_this.attr('target_id'),
                'clsTable': $_this.attr('clsTable'),
                'tp': 'F'
            },
            dataType: "html",
            success: function(html) {
                makepopupnotresize('700px', 'auto', html, 'SiteFrmPromotionItem');
                $('#SiteFrmPromotionItem').css('top', '20px');
                var $editorID = $('.textarea_price_editor').attr('id');
                $('#' + $editorID).isoTextAreaFix();
                vietiso_loading(0);
            }
        });
        return false;
    });
	$(document).on('click', '.clickEditPromotionPro', function(ev) {
        var $_this = $(this);
        vietiso_loading(1);
        $.ajax({
            type: "POST",
            url: path_ajax_script + '/index.php?mod=promotionpro&act=ajLoadFormPromotionProfessional',
            data: {
                'promotion_id': $_this.attr('promotion_id'),
                'tp': 'Le'
            },
            dataType: "html",
            success: function(html) {
                var w_h = $(window).height();
                var bx_m_h = w_h-40;
                makepopupnotresize('1000px', 'auto', html, 'SiteFrmPromotionProItem');
                $('#SiteFrmPromotionProItem').css({'top':'20px','max-height':bx_m_h+'px','overflow':'auto'});

                /*begin ajax level 2*/
                $.ajax({
                    type: "POST",
                    url: path_ajax_script + '/index.php?mod=promotionpro&act=ajEditSetMem',
                    data: {
                        'tp': 'L',
                        'setting': $.cookie("power_promotion")
                    },
                    dataType: "html",

                    success: function(html) {
                        $('.box_option_mem').html(html);
                    }
                });
                $('.show_date, .show_pro_detail, .show_pro_name').show().attr('openbox','1');
                /*finish ajax level 2*/
                vietiso_loading(0);
            }
        });
        return false;
    });
    $(document).on('click', '.clickInsertPromotion', function(ev) {
        var $_this = $(this);
        $.removeCookie("date_promotion");
        $.removeCookie("discount_value");
        $.removeCookie("power_promotion");
        $.removeCookie("select_product");
        $.removeCookie("name_pro");
        vietiso_loading(1);
        $.ajax({
            type: "POST",
            url: path_ajax_script + '/index.php?mod=promotionpro&act=ajLoadFormPromotionProfessional',
            data: {
				'target_id': $_this.attr('target_id'),
                'tp': 'L'
				
            },
            dataType: "html",
            success: function(html) {
                var w_h = $(window).height();
                var bx_m_h = w_h-40;
                makepopupnotresize('1000px', 'auto', html, 'SiteFrmPromotionProItem');
                $('#SiteFrmPromotionProItem').css({'top': '20px','max-height':bx_m_h+'px','overflow':'auto'});
                /*begin ajax level 2*/
                $.ajax({
                    type: "POST",
                    url: path_ajax_script + '/index.php?mod=promotionpro&act=ajEditSetMem',
                    data: {
                        'tp': 'L',
                        'setting': $.cookie("power_promotion")
                    },
                    dataType: "html",
                    beforeSend: function(){
                        $('.loading_promotion_pro_op').show();
                    },
                    complete: function(){
                        $('.loading_promotion_pro_op').hide();
                    },
                    success: function(html) {
                    	$('.box_option_mem').html(html);
                    }
                });
                $('.unshow_date, .unshow_pro_detail, .unshow_pro_name').hide();
                /*finish ajax level 2*/
            }
        });
        vietiso_loading(0);
        return false;
    });
    function getCheckTextCruiseInti() {
        var result =
            $(".box_cruise_intinerary > li > input:radio:checked").get();
        var columns = $.map(result, function(element) {
            return $(element).attr("value");
        });

        return columns.join(",");
    }
    $(document).on('click', '.clickInsertPromotionGroup', function(ev) {
        var $_this = $(this);
        var type = $(this).attr('type');
        vietiso_loading(1);
        if(type == 'Cruise'){
            $.ajax({
                type: "POST",
                url: path_ajax_script + '/index.php?mod=promotionpro&act=ajLoadFormPromotionAddOne',
                data: {
                    'tp': 'L',
                    'type': type,
                    'target_id': $_this.attr('target_id'),
                    'check_iti': 0,
                },
                dataType: "html",
                success: function(html) {
                    var w_h = $(window).height();
                    var bx_m_h = w_h-40;
                    makepopupnotresize('700px', 'auto', html, 'SiteFrmAddOnePromotionPro');
                    $('#SiteFrmAddOnePromotionPro').css({'top': '20px','max-height':bx_m_h+'px','overflow':'auto'});
                    /*begin ajax level 2*/
                    /* $.ajax({
                         type: "POST",
                         url: path_ajax_script + '/index.php?mod=promotionpro&act=ajEditSetMem',
                         data: {
                             'tp': 'L',
                             'setting': $.cookie("power_promotion")
                         },
                         dataType: "html",
                         beforeSend: function(){
                             $('.loading_promotion_pro_op').show();
                         },
                         complete: function(){
                             $('.loading_promotion_pro_op').hide();
                         },
                         success: function(html) {
                             $('.box_option_mem').html(html);
                         }
                     });
                     $('.unshow_date, .unshow_pro_detail, .unshow_pro_name').hide();*/
                    /*finish ajax level 2*/
                }
            });
        }else{
            $.ajax({
                type: "POST",
                url: path_ajax_script + '/index.php?mod=promotionpro&act=ajLoadFormPromotionAddOne',
                data: {
                    'tp': 'L',
                    'type': type,
                    'target_id': $_this.attr('target_id'),
                },
                dataType: "html",
                success: function(html) {
                    var w_h = $(window).height();
                    var bx_m_h = w_h-40;
                    makepopupnotresize('700px', 'auto', html, 'SiteFrmAddOnePromotionPro');
                    $('#SiteFrmAddOnePromotionPro').css({'top': '20px','max-height':bx_m_h+'px','overflow':'auto'});
                    /*begin ajax level 2*/
                    /* $.ajax({
                         type: "POST",
                         url: path_ajax_script + '/index.php?mod=promotionpro&act=ajEditSetMem',
                         data: {
                             'tp': 'L',
                             'setting': $.cookie("power_promotion")
                         },
                         dataType: "html",
                         beforeSend: function(){
                             $('.loading_promotion_pro_op').show();
                         },
                         complete: function(){
                             $('.loading_promotion_pro_op').hide();
                         },
                         success: function(html) {
                             $('.box_option_mem').html(html);
                         }
                     });
                     $('.unshow_date, .unshow_pro_detail, .unshow_pro_name').hide();*/
                    /*finish ajax level 2*/
                }
            });
        }

        vietiso_loading(0);
        return false;
    });function getCheckRadioOptionlistItems() {
        var result =
            $("ul.list_option_set > li > p > input:radio:checked").get();
        var columns = $.map(result, function(element) {
            return $(element).attr("value");
        });

        return columns.join(",");
    }
    function getCheckTextDatelistItems() {
        var result =
            $(".box_date_promotion > div > div > input:text").get();
        var columns = $.map(result, function(element) {
            return $(element).attr("value");
        });

        return columns.join(",");
    }
    function getCheckTextProductlistItems() {
        var result =
            $(".list_all_tours > .item_tour > .label-cbx > input:checkbox:checked").get();
        var columns = $.map(result, function(element) {
            return $(element).attr("value");
        });

        return columns.join(",");
    }
    function getCheckTypeServicelistItems() {
        var result =
            $(".check_type_service > input:checkbox:checked").get();
        var columns = $.map(result, function(element) {
            return $(element).attr("value");
        });

        return columns.join("|");
    }
    $(document).on('click', '#btn_save_option', function(ev) {
        var the_value = getCheckRadioOptionlistItems();
        var date = new Date();
        var minutes = 60;
        date.setTime(date.getTime() + (minutes * 60 * 1000));
        $.cookie("power_promotion", the_value,{ expires : date });
        $(this).closest('.who_can_see').find('.title_pop_who_see').css('border-radius','8px');
        $(this).closest('.who_can_see').find('.title_pop_who_see .fa').removeClass('fa-angle-double-up').addClass('fa-angle-double-down');
        $(this).closest('.who_can_see').find('.unshow_option').removeClass('unshow_option').addClass('show_option');
        $('.box_option_mem').html('');
        $.ajax({
            type: "POST",
            url: path_ajax_script + '/index.php?mod=promotionpro&act=ajEditSetDate',
            data: {
                'tp': 'L',
                'setting': $.cookie("date_promotion")
            },
            dataType: "html",
            beforeSend: function(){
                $('.loading_promotion_pro_op').show();
            },
            complete: function(){
                $('.loading_promotion_pro_op').hide();
            },
            success: function(html) {
                $('.box_date_promotion').html(html);
                $('.unshow_date').show().attr('openbox','1');
            }
        });
        return false;
    });

    $(document).on('click', '.unshow_option', function(ev) {
        $('.box_option_mem').html('');
        $(this).find('.fa').removeClass('fa-angle-double-up').addClass('fa-angle-double-down');
        $(this).removeClass('unshow_option').addClass('show_option');
        $(this).closest('.who_can_see').find('.title_pop_who_see').css('border-radius','8px');
    })
    ;$(document).on('click', '.show_option', function(ev) {
        $.ajax({
            type: "POST",
            url: path_ajax_script + '/index.php?mod=promotionpro&act=ajEditSetMem',
            data: {
                'tp': 'L',
                'setting': $.cookie("power_promotion")
            },
            dataType: "html",
            beforeSend: function(){
                $('.loading_promotion_pro_op').show();
            },
            complete: function(){
                $('.loading_promotion_pro_op').hide();
            },
            success: function(html) {
                $('.box_option_mem').html(html);

            }
        });
        $(this).find('.fa').removeClass('fa-angle-double-down').addClass('fa-angle-double-up');
        $(this).removeClass('show_option').addClass('unshow_option');
        $(this).closest('.who_can_see').find('.title_pop_who_see').css('border-radius','8px 8px 0 0');
    });

    $(document).on('click', '#btn_save_date', function(ev) {
        var date = new Date();
        var minutes = 60;
        var time_present = date.getDate() + '/' + (date.getMonth() + 1) + '/' +  date.getFullYear();
        var from_bk_date = $(".box_booking_date input[name=from]").val();
        var to_bk_date = $(".box_booking_date input[name=to]").val();
        var from_trvl_date = $(".box_travel_date input[name=from]").val();
        var to_trvl_date = $(".box_travel_date input[name=to]").val();
        if(!isValidDate(from_bk_date)){
            $('.error_row_bk_date').html('From date is valid, please set date exp: '+time_present);
            return  false;
        }else if(!isValidDate(to_bk_date)){
            $('.error_row_bk_date').html('To date is valid, please set date exp: '+time_present);
            return  false;
        }else if(!isValidDate(from_trvl_date)){
            $('.error_row_trvl_date').html('From date is valid, please set date exp: '+time_present);
            return  false;
        }else if(!isValidDate(to_trvl_date)){
            $('.error_row_trvl_date').html('To date is valid, please set date exp: '+time_present);
            return  false;
        }else{
            $('.error_row_bk_date').html('');
            $('.error_row_trvl_date').html('');
        }

    	var value_date_all = getCheckTextDatelistItems();

        date.setTime(date.getTime() + (minutes * 60 * 1000));
        $.cookie("date_promotion", value_date_all,{ expires : date });
        $(this).closest('.date_promotion_pro').find('.title_date_promotion').css('border-radius','8px');
        $(this).closest('.date_promotion_pro').find('.title_date_promotion .fa').removeClass('fa-angle-double-up').addClass('fa-angle-double-down');
        $(this).closest('.date_promotion_pro').find('.unshow_date').removeClass('unshow_date').addClass('show_date');
        $('.box_date_promotion').html('');
        $.ajax({
            type: "POST",
            url: path_ajax_script + '/index.php?mod=promotionpro&act=ajEditSetPromotionDetail',
            data: {
                'tp': 'L',
                'setting': $.cookie("select_product"),
                'setting_dis_value': $.cookie("discount_value")
            },
            dataType: "html",
            beforeSend: function(){
                $('.loading_promotion_pro_dt').show();
            },
            complete: function(){
                $('.loading_promotion_pro_dt').hide();
            },
            success: function(html) {
                $('.box_promotion_detail').html(html);
                $('.unshow_pro_detail').show().attr('openbox','1');

            }
        });
       return false;
    });

    $(document).on('click', '.unshow_date', function(ev) {
        var open_box = $(this).attr('openbox');
        if(open_box == 1){
            $('.box_date_promotion').html('');
            $(this).find('.fa').removeClass('fa-angle-double-up').addClass('fa-angle-double-down');
            $(this).removeClass('unshow_date').addClass('show_date');
            $(this).closest('.date_promotion_pro').find('.title_date_promotion').css('border-radius','8px');
        }

    });
    $(document).on('click', '.show_date', function(ev) {
        var open_box = $(this).attr('openbox');
        if(open_box == 1) {
            $.ajax({
                type: "POST",
                url: path_ajax_script + '/index.php?mod=promotionpro&act=ajEditSetDate',
                data: {
                    'tp': 'L',
                    'setting': $.cookie("date_promotion")
                },
                dataType: "html",
                beforeSend: function(){
                    $('.loading_promotion_pro_dt').show();
                },
                complete: function(){
                    $('.loading_promotion_pro_dt').hide();
                },
                success: function (html) {
                    $('.box_date_promotion').html(html);

                }
            });
            $(this).find('.fa').removeClass('fa-angle-double-down').addClass('fa-angle-double-up');
            $(this).removeClass('show_date').addClass('unshow_date');
            $(this).closest('.date_promotion_pro').find('.title_date_promotion').css('border-radius', '8px 8px 0 0');
        }
    });


    $(document).on('click', '.open_select_product', function(ev) {
        var $_this = $(this);
        var select_type = $(".box_select_type_travel input[name=select_type]:checked").val();
        var h_w = $(window).height();
        var h_pop = h_w - 266;
        vietiso_loading(1);
        $.ajax({
            type: "POST",
            url: path_ajax_script + '/index.php?mod=promotionpro&act=ajLoadFormSelectProduct',
            data: {
                'tp': 'L',
				'h_pop':h_pop,
				'type':select_type,
                'setting': $.cookie("select_product")
            },
            dataType: "html",
            success: function(html) {
                makepopupnotresize('500px', h_pop, html, 'SiteFrmPromotionProSelectItem');
                $('#SiteFrmPromotionProSelectItem').css('top', '20px');
            }
        });
        vietiso_loading(0);
        return false;
    });

    $(document).on('click', '#btn_save_product', function(ev) {
        var value_date = getCheckTextProductlistItems();
        var date = new Date();
        var minutes = 60;
        date.setTime(date.getTime() + (minutes * 60 * 1000));
        $.cookie("select_product", value_date,{ expires : date });
        var $checkboxes = $(".list_all_tours .item_tour .label-cbx input:checkbox:checked").length;
        $(".open_select_product").text($checkboxes+" Product Selected");
        $(".open_select_product").attr("quantity_pro",$checkboxes);
        $(".error_row_select_pro").html('');
       $('#SiteFrmPromotionProSelectItem').find('.close_pop').trigger('click');

        return false;
    });
    $(document).on('click', '#btn_save_all', function(ev) {
        var ticket_quantity = $(".box_set_name input[name=promotion_name]").val();
		var target_id = $(this).attr('target_id');
        $.ajax({
            type: "POST",
            url: path_ajax_script + '/index.php?mod=promotionpro&act=ajSavePromotion',
            data: {
                'tp': 'S',
                'target_id': $(this).attr('target_id'),
                'date_promotion': $.cookie("date_promotion"),
                'discount_value': $.cookie("discount_value"),
                'power_promotion': $.cookie("power_promotion"),
                'select_product': $.cookie("select_product"),
                'name_product':ticket_quantity
            },
            dataType: "json",
            beforeSend: function(){
                $('.loading_promotion_pro_pn').show();
            },
            complete: function(){
                $('.loading_promotion_pro_pn').hide();
            },
            success: function(json) {
                if(json.status == 'OK'){
                    $.removeCookie("date_promotion");
                    $.removeCookie("discount_value");
                    $.removeCookie("power_promotion");
                    $.removeCookie("select_product");
                    $.removeCookie("name_pro");
                    $('#SiteFrmPromotionProItem').find('.close_pop').trigger('click');

                }
                location.reload();
            }
        });

        return false;
    });
    $(document).on('click', '#btn_save_all_up', function(ev) {
        var ticket_quantity = $(".box_set_name input[name=promotion_name]").val();
        var pro_id = $(this).attr('pro_id');
        $.ajax({
            type: "POST",
            url: path_ajax_script + '/index.php?mod=promotionpro&act=ajSavePromotion',
            data: {
                'tp': 'U',
                'promotion_id': pro_id,
                'date_promotion': $.cookie("date_promotion"),
                'discount_value': $.cookie("discount_value"),
                'power_promotion': $.cookie("power_promotion"),
                'select_product': $.cookie("select_product"),
                'name_product':ticket_quantity
            },
            dataType: "json",
            success: function(json) {
                if(json.status == 'OK'){
                    $.removeCookie("date_promotion");
                    $.removeCookie("discount_value");
                    $.removeCookie("power_promotion");
                    $.removeCookie("select_product");
                    $.removeCookie("name_pro");
                    $('#SiteFrmPromotionProItem').find('.close_pop').trigger('click');
                }
                location.reload();
            }
        });

        return false;
    });

    $(document).on('click', '#btn_save_select_discount_product', function(ev) {
        var type_product = $(".box_select_type_travel input[name=select_type]:checked").val();
        var dicount_type = $(".box_type_of_discount .des_type_discount input[name=discount_type]:checked").val();
        var dicount_quantity = $(".box_type_of_discount input[name=discount_quantity]").val();
        var ticket_quantity = $(".box_type_of_discount input[name=ticket_quantity]").val();
        var max_price = $(".box_type_of_discount input[name=max_price]").val();
        var promotion_code = $(".box_type_of_discount input[name=promotion_code]").val();
        var Service_voucher = $(".check_type_service input[name=type_service_voucher]:checked").length;
        var Service_max_price = $(".check_type_service input[name=type_service_max_price]:checked").length;
        var ticket_quantity = $(".box_checkebox_service input[name=ticket_quantity]").val();
        var promotion_code_ip = $(".box_checkebox_service input[name=promotion_code]").val();
        var max_price_ip = $(".box_checkebox_service input[name=max_price]").val();
        /*var quantity_pro_attr = $(".box_select_product .link_select_product .open_select_product").attr("quantity_pro");*/
        var type_service = getCheckTypeServicelistItems();
        var list_val_type_service = '';
        if(type_service){
            list_val_type_service = type_service;
        }
		
		ticket_quantity = (ticket_quantity !== undefined)?ticket_quantity:'';
		promotion_code = (promotion_code !== undefined)?promotion_code:'';
		max_price = (max_price !== undefined)?max_price:'';
        var date = new Date();
        var minutes = 60;
        date.setTime(date.getTime() + (minutes * 60 * 1000));
        if(type_product == undefined){
            $('.error_row_select_type_tour').html('Please choose type travel');
            return false;
        }else {
            $('.error_row_select_type_tour').html('');
        }
       /* if(quantity_pro_attr == 0){
            $(".error_row_select_pro").html('Please choose product')
            return false;
        }else {
            $(".error_row_select_pro").html('');
        }*/
        if(dicount_quantity == 0 || dicount_quantity == undefined){
            $('.error_row_discount_quantity').html('Please filter number voucher');
            return false;
        }else {
            $('.error_row_discount_quantity').html('');
        }
        // alert(Service_voucher);

        if(Service_voucher == 1){
            if(ticket_quantity.length <=0){
                $(".error_row_serv_vourcher").html('Ticket quantity is required up to 1 character');
                return false;
            }else if($.isNumeric(ticket_quantity) == false){
                $(".error_row_serv_vourcher").html('Ticket quantity is number');
                return false;
            }else if(promotion_code_ip.length <=5){
                $(".error_row_serv_vourcher").html('Promotion Code is required up to 6 character');
                return false;
            }else{
                $(".error_row_serv_vourcher").html('');
            }
        }
        if(Service_max_price == 1){
            if(max_price_ip.length <=0){
                $(".error_row_serv_maxprice").html('Max price is required up to 1 character');
                return false;
            }else if($.isNumeric(max_price_ip) == false){
                $(".error_row_serv_maxprice").html('Max price is number');
                return false;
            }else{
                $(".error_row_serv_maxprice").html('');
            }
        }
	
        $.cookie("discount_value", dicount_type+','+dicount_quantity+','+ticket_quantity+','+promotion_code+','+type_product+','+list_val_type_service+','+max_price,{ expires : date });
        $(this).closest('.date_promotion_detail').find('.title_promotion_detail').css('border-radius','8px');
        $(this).closest('.date_promotion_detail').find('.title_promotion_detail .fa').removeClass('fa-angle-double-up').addClass('fa-angle-double-down');
        $(this).closest('.date_promotion_detail').find('.unshow_pro_detail').removeClass('unshow_pro_detail').addClass('show_pro_detail');
        $('.box_promotion_detail').html('');
        $.ajax({
            type: "POST",
            url: path_ajax_script + '/index.php?mod=promotionpro&act=ajEditSetPromotionName',
            data: {
                'tp': 'L',
                'setting': $.cookie("name_pro")
            },
            dataType: "html",
            beforeSend: function(){
                $('.loading_promotion_pro_pd').show();
            },
            complete: function(){
                $('.loading_promotion_pro_pd').hide();
            },
            success: function(html) {
                $('.box_promotion_name').html(html);
                $('.btn_save_all_promotion').show();
            }
        });
        return false;
    });


    $(document).on('click', '.unshow_pro_detail', function(ev) {
        var open_box = $(this).attr('openbox');
        if(open_box == 1) {
            $('.box_promotion_detail').html('');
            $(this).find('.fa').removeClass('fa-angle-double-up').addClass('fa-angle-double-down');
            $(this).removeClass('unshow_pro_detail').addClass('show_pro_detail');
            $(this).closest('.date_promotion_detail').find('.title_promotion_detail').css('border-radius', '8px');
        }
    });
    $(document).on('click', '.show_pro_detail', function(ev) {
        var open_box = $(this).attr('openbox');
        if(open_box == 1) {
            $.ajax({
                type: "POST",
                url: path_ajax_script + '/index.php?mod=promotionpro&act=ajEditSetPromotionDetail',
                data: {
                    'tp': 'L',
                    'setting': $.cookie("select_product"),
                    'setting_dis_value': $.cookie("discount_value")
                },
                dataType: "html",
                beforeSend: function(){
                    $('.loading_promotion_pro_pd').show();
                },
                complete: function(){
                    $('.loading_promotion_pro_pd').hide();
                },
                success: function (html) {
                    $('.box_promotion_detail').html(html);
                    $('.unshow_pro_name').show().attr('openbox','1');

                }
            });
            $(this).find('.fa').removeClass('fa-angle-double-down').addClass('fa-angle-double-up');
            $(this).removeClass('show_pro_detail').addClass('unshow_pro_detail');
            $(this).closest('.date_promotion_detail').find('.title_promotion_detail').css('border-radius', '8px 8px 0 0');
        }
    });
    $(document).on('click', '.unshow_pro_name', function(ev) {
        var open_box = $(this).attr('openbox');
        if(open_box == 1) {
            $('.box_promotion_name').hide();
            $(this).find('.fa').removeClass('fa-angle-double-up').addClass('fa-angle-double-down');
            $(this).removeClass('unshow_pro_name').addClass('show_pro_name');
            $(this).closest('.date_promotion_name').find('.title_promotion_name').css('border-radius','8px');
        }
    })
    ;$(document).on('click', '.show_pro_name', function(ev) {
        var open_box = $(this).attr('openbox');
        if(open_box == 1) {
            $.ajax({
                type: "POST",
                url: path_ajax_script + '/index.php?mod=promotionpro&act=ajEditSetPromotionName',
                data: {
                    'tp': 'L',
                    'setting': $.cookie("name_pro")
                },
                dataType: "html",
                beforeSend: function(){
                    $('.loading_promotion_pro_pn').show();
                },
                complete: function(){
                    $('.loading_promotion_pro_pn').hide();
                },
                success: function(html) {
                    $('.box_promotion_name').html(html);
                    $('.btn_save_all_promotion').show();
                }
            });
            $('.box_promotion_name').show();
            $(this).find('.fa').removeClass('fa-angle-double-down').addClass('fa-angle-double-up');
            $(this).removeClass('show_pro_name').addClass('unshow_pro_name');
            $(this).closest('.date_promotion_name').find('.title_promotion_name').css('border-radius', '8px 8px 0 0');
        }
    });
	$(document).on('click', '.btnSavePromotion', function(ev) {
		var $_this = $(this);
		var $_form = $_this.closest('.frmPop');
		var $cruise_itinerary_id = $_form.find('select[name=cruise_itinerary_id]');
		var $start_date = $_form.find('input[name=start_date]');
		var $end_date = $_form.find('input[name=end_date]');
		var $flag_text = $_form.find('input[name=flag_text]');
		var $promotion_code = $_form.find('input[name=promotion_code]');
		var $promot = $_form.find('input[name=promot]');
		var $promot_agent = $_form.find('input[name=promot_agent]');
		var $deposit = $_form.find('input[name=deposit]');
		var $promotion_id = $_this.attr('promotion_id');
		var $target_id = $_this.attr('target_id');
		var $clsTable = $_this.attr('clsTable');

		if ($start_date.val() == '') {
			$start_date.focus().addClass('error');
			alertify.error(field_is_required);
			return false;
		}
		if ($end_date.val() == '') {
			$end_date.focus().addClass('error');
			alertify.error(field_is_required);
			return false;
		}
		if ($flag_text.val() == '') {
			$flag_text.focus().addClass('error');
			alertify.error(field_is_required);
			return false;
		}

		var adata = {};
		adata['cruise_itinerary_id'] = $cruise_itinerary_id.val();
		adata['start_date'] = $start_date.val();
		adata['end_date'] = $end_date.val();
		adata['flag_text'] = $flag_text.val();
		adata['promot'] = $promot.val();
		adata['promot_agent'] = $promot_agent.val();
		adata['promotion_code'] = $promotion_code.val();
		adata['deposit'] = $deposit.val();
		adata['promotion_id'] = $promotion_id;
		adata['target_id'] = $target_id;
		adata['clsTable'] = $clsTable;
		adata['tp'] = 'S';
		vietiso_loading(1);
		$('#tblPricePromotion').ajaxSubmit({
			type: "POST",
			url: path_ajax_script + '/index.php?mod=promotion&act=ajLoadPromotionItem',
			data: adata,
			dataType: "html",
			success: function(html) {
				vietiso_loading(0);
				if (html.indexOf('_UPDATE_SUCCESS') >= 0) {
					$_this.closest('.frmPop').find('.close_pop').trigger('click');
					if(act=='list_promotion'){
						location.href = REQUEST_URI;
					}else if(mod=='cruise'){
						location.href = REQUEST_URI+'#isotab6';
					}else if(mod=='tour'){
						location.href = REQUEST_URI+'#isotab5';
					}else{
						location.href = REQUEST_URI;
					}
				}
				if (html.indexOf('_ERROR') >= 0) {
					alertify.error(insert_error);
				}
				if (html.indexOf('_EXIST') >= 0) {
					alertify.error(exist_error);
				}
				if (html.indexOf('start_date_invalid') >= 0) {
					$start_date.focus();
					alertify.error(start_date_error);
				}
				if (html.indexOf('promotion_code_invalid') >= 0) {
					$start_date.focus();
					alertify.error(promotion_code_error);
				}
				if (html.indexOf('end_date_invalid') >= 0) {
					$end_date.focus();
					alertify.error(end_date_error);
				}
			}
		});
		return false;
	});
	$(document).on('click', '.clickDeletePromotion', function(ev) {
		if (confirm(confirm_delete)) {
			vietiso_loading(1);
			var $_this = $(this);
			$.ajax({
				type: "POST",
				url: path_ajax_script + '/?mod=promotion&act=ajDeletePromotion',
				data: {
					'promotion_id': $_this.attr("promotion_id"),
					'target_id': $_this.attr("target_id"),
					'clsTable': $_this.attr("clsTable"),
				},
				dataType: "html",
				success: function(html) {
					vietiso_loading(0);
					if(act=='list_promotion'){
						location.href = REQUEST_URI;
					}else if(act=='default'){
						location.href = REQUEST_URI;
					}else{
						loadPromotion($_this.attr('target_id'),$_this.attr('clsTable'));
					}
				}
			});
		}
		return false;
	});
    $(document).on('click', '.clickDeletePromotionAllPro', function(ev) {
        if (confirm(confirm_delete)) {
            vietiso_loading(1);
            var $_this = $(this);
            $.ajax({
                type: "POST",
                url: path_ajax_script + '/?mod=promotionpro&act=ajDeletePromotion',
                data: {
                    'promotion_id': $_this.attr("promotion_id"),
                    'promotion_item_id': $_this.attr("item"),
                    'target_id': $_this.attr("target_id"),
                    'clsTable': $_this.attr("clsTable"),
                },
                dataType: "html",
                success: function(html) {
                    vietiso_loading(0);
                    if(act=='list_promotion'){
                        location.href = REQUEST_URI;
                    }else if(act=='default'){
                        location.href = REQUEST_URI;
                    }else if(act=='promotion' && mod=='cruise'){
						location.reload();
					}else{
                        loadPromotionPro($_this.attr('target_id'),$_this.attr('clsTable'));
                    }
                }
            });
        }
        return false;
    });
    $(document).on('click', '.clickDeletePromotionPro', function(ev) {
        if (confirm(confirm_delete)) {
            vietiso_loading(1);
            var $_this = $(this);
            $.ajax({
                type: "POST",
                url: path_ajax_script + '/?mod=promotionpro&act=ajDeletePromotionItem',
                data: {
                    'promotion_id': $_this.attr("promotion_id"),
                    'promotion_item_id': $_this.attr("item"),
                    'target_id': $_this.attr("target_id"),
                    'clsTable': $_this.attr("clsTable"),
                },
                dataType: "html",
                success: function(html) {
                    vietiso_loading(0);
                    if(act=='list_promotion'){
                        location.href = REQUEST_URI;
                    }else if(act=='default'){
                        location.href = REQUEST_URI;
                    }else{
                        loadPromotionPro($_this.attr('target_id'),$_this.attr('clsTable'));
                    }
                }
            });
        }
        return false;
    });
    $(document).on("click", "#ajGetPromotionProCode", function(ev) {
        var $_this = $(this);
        $.ajax({
            type: "POST",
            url: path_ajax_script+"/index.php?mod=promotion&act=ajGetPromotionCode",
            dataType:"html",
            success: function(html){
                var htm = html.split("|||");
                $("#promotion_code").val(htm[1]);
            }
        });
    });
});
function loadPromotion(target_id,clsTable) {
	vietiso_loading(1);
	var $_this = $(this);
	$.ajax({
		type: "POST",
		url: path_ajax_script + '/?mod=promotion&act=ajLoadPromotion',
		data: {
			'target_id': target_id,
			'clsTable': clsTable
		},
		dataType: "html",
		success: function(html) {
			vietiso_loading(0);
			$("#ListPromotion").html(html);
		}
	});
}
function loadPromotionPro(target_id,clsTable) {
    vietiso_loading(1);
    var $_this = $(this);
    $.ajax({
        type: "POST",
        url: path_ajax_script + "/?mod=promotionpro&act=ajLoadPromotionProItem",
        data: {
            "target_id": target_id,
            "clsTable": clsTable
        },
        dataType: "html",
        success: function(html) {
            vietiso_loading(0);
            $("#ListPromotionPro").html(html);
        }
    });
}
function parentDropdownToggle(e){
	$(e).parent().toggleClass('open');
}