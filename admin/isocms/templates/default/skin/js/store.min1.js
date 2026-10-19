jQuery.popup={show:function(url,options){var defaults={wparamet:'',wposition:'center',wtoolbar:'no',wdirectories:'no',wstatus:'no',wscrollbars:'yes',wresizable:'no',wmenubar:'no',wlocation:'no',wwidth:800,wheight:600};var options=jQuery.extend(defaults,options);var xpos,ypos;if(options.wposition=='center'){xpos=(screen.width-options.wwidth)/2;ypos=(screen.height-options.wheight)/2;}
else if(options.wposition=='right'){xpos=screen.width-options.wwidth;ypos=screen.height-options.wheight;}
else{xpos=0;ypos=0;}
url=(options.wparamet=='')?url:url+'?'+options.wparamet;var nwin=window.open(url,"NVCOM","toolbar="+options.wtoolbar+",location="+options.wlocation+",width="+options.wwidth+",height="+options.wheight+",directories="+options.wdirectories+",status="+options.wstatus+",scrollbars="+options.wscrollbars+",resizable="+options.wresizable+", menubar="+options.wmenubar);nwin.moveTo(xpos,ypos);nwin.focus();return jQuery;}};
(function($){$.fn.extend({isoswitchvalue:function(options){var defaults={_value: 1,_selector:''};var options=$.extend(defaults,options);return this.each(function(){var $_this = $(this);var $_opts = options;$_this.addClass(($_opts._value==1?'on':'off'));$_this.append('<span class="on">PUBLIC</span>');$_this.append('<span class="off">PRIVATE</span>');$_this.append('<input type="hidden" name="'+$_opts._selector+'" class="'+$_opts._selector+'" value="'+($_opts._value==''?'0':$_opts._value)+'">');$_this.click(function(){if($_this.hasClass('on')){$_this.removeClass('on').addClass('off');$('input[name='+$_opts._selector+']').val(0);$('#prv_status').show();$('#pub_status').hide();}else{$_this.removeClass('off').addClass('on');$('input[name='+$_opts._selector+']').val(1);$('#prv_status').hide();$('#pub_status').show();}});});}});})(jQuery);
(function($){$.fn.extend({isodatepicker:function(){ return this.each(function(){$(this).datepicker({'minDate': new Date(),'dateFormat': "dd-mm-yy",changeMonth: true,changeYear: true});});}});})(jQuery);
(function($){$.fn.extend({isopriceformat:function(){return this.each(function(){$(this).priceFormat({centsLimit:''});});}});})(jQuery);
/* Jquery Plugin Accorddion */
!function(c){c.fn.smk_Accordion=function(e){var n=c.extend({animation:!0,showIcon:!0,closeAble:!1,slideSpeed:200},e),a=this,i=function(){a.createStructure(),a.clickHead()};return this.createStructure=function(){a.addClass("smk_accordion"),!0===n.showIcon&&a.addClass("acc_with_icon"),!0===n.showIcon&&a.find(".acc_head").prepend('<div class="acc_icon_expand"></div>'),a.find(".accordion_in .acc_content").not(".acc_active .acc_content").hide()},this.clickHead=function(){a.on("click",".acc_head",function(){var e=c(this).parent();0==e.hasClass("acc_active")&&(a.find(".acc_content").slideUp(n.slideSpeed),a.find(".accordion_in").removeClass("acc_active")),e.hasClass("acc_active")?!1!==n.closeAble&&(e.children(".acc_content").slideUp(n.slideSpeed),e.removeClass("acc_active")):(c(this).next(".acc_content").slideDown(n.slideSpeed),e.addClass("acc_active"))})},i(),this}}(jQuery);
/*
    jQuery Masked Input Plugin
    Copyright (c) 2007 - 2015 Josh Bush (digitalbush.com)
    Licensed under the MIT license (http://digitalbush.com/projects/masked-input-plugin/#license)
    Version: 1.4.1
*/
!function(factory) {
    "function" == typeof define && define.amd ? define([ "jquery" ], factory) : factory("object" == typeof exports ? require("jquery") : jQuery);
}(function($) {
    var caretTimeoutId, ua = navigator.userAgent, iPhone = /iphone/i.test(ua), chrome = /chrome/i.test(ua), android = /android/i.test(ua);
    $.mask = {
        definitions: {
            "9": "[0-9]",
            a: "[A-Za-z]",
            "*": "[A-Za-z0-9]"
        },
        autoclear: !0,
        dataName: "rawMaskFn",
        placeholder: "_"
    }, $.fn.extend({
        caret: function(begin, end) {
            var range;
            if (0 !== this.length && !this.is(":hidden")) return "number" == typeof begin ? (end = "number" == typeof end ? end : begin, 
            this.each(function() {
                this.setSelectionRange ? this.setSelectionRange(begin, end) : this.createTextRange && (range = this.createTextRange(), 
                range.collapse(!0), range.moveEnd("character", end), range.moveStart("character", begin), 
                range.select());
            })) : (this[0].setSelectionRange ? (begin = this[0].selectionStart, end = this[0].selectionEnd) : document.selection && document.selection.createRange && (range = document.selection.createRange(), 
            begin = 0 - range.duplicate().moveStart("character", -1e5), end = begin + range.text.length), 
            {
                begin: begin,
                end: end
            });
        },
        unmask: function() {
            return this.trigger("unmask");
        },
        mask: function(mask, settings) {
            var input, defs, tests, partialPosition, firstNonMaskPos, lastRequiredNonMaskPos, len, oldVal;
            if (!mask && this.length > 0) {
                input = $(this[0]);
                var fn = input.data($.mask.dataName);
                return fn ? fn() : void 0;
            }
            return settings = $.extend({
                autoclear: $.mask.autoclear,
                placeholder: $.mask.placeholder,
                completed: null
            }, settings), defs = $.mask.definitions, tests = [], partialPosition = len = mask.length, 
            firstNonMaskPos = null, $.each(mask.split(""), function(i, c) {
                "?" == c ? (len--, partialPosition = i) : defs[c] ? (tests.push(new RegExp(defs[c])), 
                null === firstNonMaskPos && (firstNonMaskPos = tests.length - 1), partialPosition > i && (lastRequiredNonMaskPos = tests.length - 1)) : tests.push(null);
            }), this.trigger("unmask").each(function() {
                function tryFireCompleted() {
                    if (settings.completed) {
                        for (var i = firstNonMaskPos; lastRequiredNonMaskPos >= i; i++) if (tests[i] && buffer[i] === getPlaceholder(i)) return;
                        settings.completed.call(input);
                    }
                }
                function getPlaceholder(i) {
                    return settings.placeholder.charAt(i < settings.placeholder.length ? i : 0);
                }
                function seekNext(pos) {
                    for (;++pos < len && !tests[pos]; ) ;
                    return pos;
                }
                function seekPrev(pos) {
                    for (;--pos >= 0 && !tests[pos]; ) ;
                    return pos;
                }
                function shiftL(begin, end) {
                    var i, j;
                    if (!(0 > begin)) {
                        for (i = begin, j = seekNext(end); len > i; i++) if (tests[i]) {
                            if (!(len > j && tests[i].test(buffer[j]))) break;
                            buffer[i] = buffer[j], buffer[j] = getPlaceholder(j), j = seekNext(j);
                        }
                        writeBuffer(), input.caret(Math.max(firstNonMaskPos, begin));
                    }
                }
                function shiftR(pos) {
                    var i, c, j, t;
                    for (i = pos, c = getPlaceholder(pos); len > i; i++) if (tests[i]) {
                        if (j = seekNext(i), t = buffer[i], buffer[i] = c, !(len > j && tests[j].test(t))) break;
                        c = t;
                    }
                }
                function androidInputEvent() {
                    var curVal = input.val(), pos = input.caret();
                    if (oldVal && oldVal.length && oldVal.length > curVal.length) {
                        for (checkVal(!0); pos.begin > 0 && !tests[pos.begin - 1]; ) pos.begin--;
                        if (0 === pos.begin) for (;pos.begin < firstNonMaskPos && !tests[pos.begin]; ) pos.begin++;
                        input.caret(pos.begin, pos.begin);
                    } else {
                        for (checkVal(!0); pos.begin < len && !tests[pos.begin]; ) pos.begin++;
                        input.caret(pos.begin, pos.begin);
                    }
                    tryFireCompleted();
                }
                function blurEvent() {
                    checkVal(), input.val() != focusText && input.change();
                }
                function keydownEvent(e) {
                    if (!input.prop("readonly")) {
                        var pos, begin, end, k = e.which || e.keyCode;
                        oldVal = input.val(), 8 === k || 46 === k || iPhone && 127 === k ? (pos = input.caret(), 
                        begin = pos.begin, end = pos.end, end - begin === 0 && (begin = 46 !== k ? seekPrev(begin) : end = seekNext(begin - 1), 
                        end = 46 === k ? seekNext(end) : end), clearBuffer(begin, end), shiftL(begin, end - 1), 
                        e.preventDefault()) : 13 === k ? blurEvent.call(this, e) : 27 === k && (input.val(focusText), 
                        input.caret(0, checkVal()), e.preventDefault());
                    }
                }
                function keypressEvent(e) {
                    if (!input.prop("readonly")) {
                        var p, c, next, k = e.which || e.keyCode, pos = input.caret();
                        if (!(e.ctrlKey || e.altKey || e.metaKey || 32 > k) && k && 13 !== k) {
                            if (pos.end - pos.begin !== 0 && (clearBuffer(pos.begin, pos.end), shiftL(pos.begin, pos.end - 1)), 
                            p = seekNext(pos.begin - 1), len > p && (c = String.fromCharCode(k), tests[p].test(c))) {
                                if (shiftR(p), buffer[p] = c, writeBuffer(), next = seekNext(p), android) {
                                    var proxy = function() {
                                        $.proxy($.fn.caret, input, next)();
                                    };
                                    setTimeout(proxy, 0);
                                } else input.caret(next);
                                pos.begin <= lastRequiredNonMaskPos && tryFireCompleted();
                            }
                            e.preventDefault();
                        }
                    }
                }
                function clearBuffer(start, end) {
                    var i;
                    for (i = start; end > i && len > i; i++) tests[i] && (buffer[i] = getPlaceholder(i));
                }
                function writeBuffer() {
                    input.val(buffer.join(""));
                }
                function checkVal(allow) {
                    var i, c, pos, test = input.val(), lastMatch = -1;
                    for (i = 0, pos = 0; len > i; i++) if (tests[i]) {
                        for (buffer[i] = getPlaceholder(i); pos++ < test.length; ) if (c = test.charAt(pos - 1), 
                        tests[i].test(c)) {
                            buffer[i] = c, lastMatch = i;
                            break;
                        }
                        if (pos > test.length) {
                            clearBuffer(i + 1, len);
                            break;
                        }
                    } else buffer[i] === test.charAt(pos) && pos++, partialPosition > i && (lastMatch = i);
                    return allow ? writeBuffer() : partialPosition > lastMatch + 1 ? settings.autoclear || buffer.join("") === defaultBuffer ? (input.val() && input.val(""), 
                    clearBuffer(0, len)) : writeBuffer() : (writeBuffer(), input.val(input.val().substring(0, lastMatch + 1))), 
                    partialPosition ? i : firstNonMaskPos;
                }
                var input = $(this), buffer = $.map(mask.split(""), function(c, i) {
                    return "?" != c ? defs[c] ? getPlaceholder(i) : c : void 0;
                }), defaultBuffer = buffer.join(""), focusText = input.val();
                input.data($.mask.dataName, function() {
                    return $.map(buffer, function(c, i) {
                        return tests[i] && c != getPlaceholder(i) ? c : null;
                    }).join("");
                }), input.one("unmask", function() {
                    input.off(".mask").removeData($.mask.dataName);
                }).on("focus.mask", function() {
                    if (!input.prop("readonly")) {
                        clearTimeout(caretTimeoutId);
                        var pos;
                        focusText = input.val(), pos = checkVal(), caretTimeoutId = setTimeout(function() {
                            input.get(0) === document.activeElement && (writeBuffer(), pos == mask.replace("?", "").length ? input.caret(0, pos) : input.caret(pos));
                        }, 10);
                    }
                }).on("blur.mask", blurEvent).on("keydown.mask", keydownEvent).on("keypress.mask", keypressEvent).on("input.mask paste.mask", function() {
                    input.prop("readonly") || setTimeout(function() {
                        var pos = checkVal(!0);
                        input.caret(pos), tryFireCompleted();
                    }, 0);
                }), chrome && android && input.off("input.mask").on("input.mask", androidInputEvent), 
                checkVal();
            });
        }
    });
});
$().ready(function(){
	var timer = '';
	var timer_system_tab = '';
	var timer_popup = '';
	$(window).load(function(){
		$('#ajax_loading').fadeOut(1600);
	});
	if($('.isotimepicker').length > 0){
		$('.isotimepicker').mask("99:99");
	}
	if($('#v-nav>ul>li').length > 0){
		var items = $('#v-nav>ul>li').each(function () {
			$(this).click(function () {
				//remove previous class and add it to clicked tab
				items.removeClass('current');
				$(this).addClass('current');
				//hide all content divs and show current one
				//$('#v-nav>div.tab-content').hide().eq(items.index($(this))).show();
		
				//$('#v-nav>div.tab-content').hide().eq(items.index($(this))).fadeIn(100);    
		
				$('#v-nav>div.tab-content').hide().eq(items.index($(this))).show();
				window.location.hash = $(this).attr('tab');
			});
		});
	}
	$(".price-In,.priceFormat").priceFormat({
		thousandsSeparator: '.',
		centsLimit: 0
	});
	if($('.textarea_intro_editor').length > 0){
		$('.textarea_intro_editor').each(function(){
			var $_this = $(this);
			var $editorID = $_this.attr('id');
			$('#'+$editorID).isoTextAreaFull();
		});
	}
	if($('.textarea_intro_editor_simple').length > 0){
		$('.textarea_intro_editor_simple').each(function(){
			var $_this = $(this);
			var $editorID = $_this.attr('id');
			$('#'+$editorID).isoTextAreaSimple();
		});
	}
	if($('.accordion').length > 0){
		$(".accordion").smk_Accordion({
			showIcon: true, //boolean
			animation: true, //boolean
			closeAble: false, //boolean
			slideSpeed: 200 //integer, miliseconds
		});
	}
	// System event click global.
	$(".btn-export").live('click',function(){
		if($(this).hasClass('open')){
		$('.dateExport').hide();
		$(this).removeClass('open');
		}else{
			$('.dateExport').show();
			$(this).addClass('open');
		}
	});
	$(document).on('click', '#searchbtn, #searchBtn', function(ev){
		ev.preventDefault();
		$('#forums').submit();
	});
	$(document).on('click', '.ClickDistace', function(ev){
		var $_this=$(this);
		vietiso_loading(1);	
		$.ajax({	
			type: "POST",
			url: path_ajax_script+'/?mod='+mod+'&act=SiteHotelCustomField',	
			data: {"hotel_id" : hotel_id, 'tp' : 'C'},	
			dataType: "html",	
			success: function(html){
				vietiso_loading(0);
				loadCustomField(hotel_id);
			}	
		});		
		return false;	
	});
	$(document).on('click', '.SiteClickPublic', function(ev){
		var $_this = $(this);
		var $_rel = $_this.attr('rel');
		var adata = {};
		adata['clsTable'] = $_this.attr('clsTable');;
		adata['pkey'] = $_this.attr('pkey');
		adata['pvalTable'] = $_this.attr('sourse_id');
		adata['toField'] = $_this.attr('toField') != undefined ? $_this.attr('toField') : 'is_online';
		adata['val'] = parseInt($_rel)==0?1:0;
		adata['allowDuplicate'] = 1;
		
		$_this.find('i.fa').attr('class','fa fa-circle-o-notch fa-spin spin');
		$.ajax({
			type: "POST",
			url: path_ajax_script+"/index.php?mod=home&act=saveField",
			data: adata,
			dataType: "html",
			success: function(html){
				$_this.find('i.fa').attr('class','fa');
				if(parseInt($_rel)==1){
					$_this.find('i.fa').addClass('fa-minus-circle').addClass('red');
					$_this.attr('rel',0);
				}else{
					$_this.find('i.fa').addClass('fa-check-circle').addClass('green');
					$_this.attr('rel',1);
				}
			}
		});
		return false;
	});
	
	$(document).on('click', '.SiteClickLock', function(ev){
		var $_this = $(this);
		var $_rel = $_this.attr('rel');
		var adata = {};
		adata['clsTable'] = $_this.attr('clsTable');;
		adata['pkey'] = $_this.attr('pkey');
		adata['pvalTable'] = $_this.attr('sourse_id');
		adata['toField'] = $_this.attr('toField') != undefined ? $_this.attr('toField') : 'is_online';
		adata['val'] = parseInt($_rel)==0?1:0;
		adata['allowDuplicate'] = 1;
		
		$_this.find('i.fa').attr('class','fa fa-circle-o-notch fa-spin spin');
		$.ajax({
			type: "POST",
			url: path_ajax_script+"/index.php?mod=home&act=saveField",
			data: adata,
			dataType: "html",
			success: function(html){
				$_this.find('i.fa').attr('class','fa');
				if(parseInt($_rel)==0){
					$_this.find('i.fa').addClass('fa-minus-circle').addClass('red');
					$_this.attr('rel',1);
				}else{
					$_this.find('i.fa').addClass('fa-check-circle').addClass('green');
					$_this.attr('rel',0);
				}
			}
		});
		return false;
	});
	
	$(document).on('click', '.confirm_delete', function(ev){ 
		var $_this = $(this);
		if(confirm(confim_delete)){
			window.location.href = $_this.attr('href');
		}
		return false;
	});
	$(document).on('click', '.deleteItemImage', function(ev){ 
		if(confirm(confirm_delete)){
			var _this = $(this);
			var name	= _this.data('name_input');
			var adata = {
				'pvalTable' : _this.attr('pvalTable'),
				'clsTable'	: _this.attr('clsTable'),
				
			};
			vietiso_loading(1);
			$.ajax({
				type: "POST",
				url:path_ajax_script+'/index.php?mod=home&act=ajDeleteItemImage',
				data: adata,
				dataType: "html",
				success: function(html){
					vietiso_loading(0);
					_this.closest('.image').find('img').attr("src","");
					if(name!='' && name!='undefined'){
					  _this.closest('.image').find('input[name='+name+']').val("");
					 }else{
					   _this.closest('.image').find('input[name=isoman_url_image]').val("");
					 }
					
					_this.remove();
				}
			});
		}
		return false;
	});
	$(document).on('click', '.deleteItemImageHtml', function(ev){ 
		if(confirm(confirm_delete)){
			var _this = $(this);
			var name	= _this.data('name_input');
			var adata = {
				'pvalTable' : _this.attr('pvalTable'),
				'clsTable'	: _this.attr('clsTable'),
				
			};
			vietiso_loading(1);
			vietiso_loading(0);
			_this.closest('.image').find('img').attr("src","");
			if(name!='' && name!='undefined'){
			  _this.closest('.image').find('input[name='+name+']').val("");
			 }else{
			   _this.closest('.image').find('input[name=isoman_url_image]').val("");
			 }
			_this.remove();
		}
		return false;
	});
	$(document).on('click', '.btn-delete-all', function (ev) {
		var $_this = $(this);
		var $listID = getCheckBoxValueByClass('chkitem');
		var $clsTable = $_this.attr('clsTable');
		if ($listID == '') {
			alertify.error(confirm_delete);
			return false;
		} else {
			if (confirm(confirm_delete)) {
				vietiso_loading(1);
				$.ajax({
					type: "POST",
					url: path_ajax_script + '/?mod=home&act=ajDeleteMultiItem',
					data: {"listID": $listID.join('|'),"clsTable": $clsTable},
					dataType: "html",
					success: function (html) {
						window.location.reload();
					}
				});
			}
		}
		return false;
	});
	$(document).on('click', '.btn-delete-all-promotion-pro', function (ev) {
		var $_this = $(this);
		var $listID = getCheckBoxValueByClass('chkitem');
		var $clsTable = $_this.attr('clsTable');
		if ($listID == '') {
			alertify.error(confirm_delete);
			return false;
		} else {
			if (confirm(confirm_delete)) {
				vietiso_loading(1);
				$.ajax({
					type: "POST",
					url: path_ajax_script + '/?mod=home&act=ajDeleteMultiItemPromotionPro',
					data: {"listID": $listID.join('|'),"clsTable": $clsTable},
					dataType: "html",
					success: function (html) {
						window.location.reload();
					}
				});
			}
		}
		return false;
	});
	$(document).on('click', '.btn-delete-all-booking', function (ev) {
        var $_this = $(this);
        var $listID = getCheckBoxValueByClass('chkitem');
        var $clsTable = $_this.attr('clsTable');
        var $type = $_this.attr('type');
        if ($listID == '') {
            alertify.error(confirm_delete);
            return false;
        } else {
            if (confirm(confirm_delete)) {
                // vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url: path_ajax_script + '/?mod=home&act=ajDeleteMultiItemBooking',
                    data: {"listID": $listID.join(','),"clsTable": $clsTable,"type": $type},
                    dataType: "html",
                    success: function (html) {
                        window.location.reload();
                    }
                });
            }
        }
        return false;
	});
    $(document).on('click', '.btn-delete-all-new', function (ev) {
        var $_this = $(this);
        var $listID = getCheckBoxValueByClass('chkitem');
        var $clsTable = $_this.attr('clsTable');
        if ($listID == '') {
            alertify.error(confirm_delete);
            return false;
        } else {
            if (confirm(confirm_delete)) {
                // vietiso_loading(1);
                $.ajax({
                    type: "POST",
                    url: path_ajax_script + '/?mod=home&act=ajDeleteMultiItemNew',
                    data: {"listID": $listID.join(','),"clsTable": $clsTable},
                    dataType: "html",
                    success: function (html) {
                        window.location.reload();
                    }
                });
            }
        }
        return false;
    });
	$(document).on('click', '.close_pop', function (ev) {
		var id = $(this).closest('.frmPop').attr('id');
		$('#'+id).remove();
		$('#isoblanketpop_'+id).remove();
		return false;
	});
	$(document).on('click', '.close_Div', function (ev) {
		var $_this = $(this);
		$_this.closest('.autosugget').stop(false, true).slideUp();
		return false;
	});
	$('a.scroll_top').click(function(){
		if($('body').scrollTop() > 0)
			$('body').animate({scrollTop: 0}, 500, 'easeOutBounce');
		return false; 
	});
	if(mod=='home' && act=='default' && $( ".homecolumn" ).length > 0){
		$( ".homecolumn" ).sortable({ handle : '.widget-header',connectWith: ['.homecolumn'], stop: function() { saveHomeWidgets(); }});
		$( ".homewidget" ).find( ".widget-header" ).prepend( "<span class='ui-icon ui-icon-minusthick'></span>");
		$( ".widget-header .ui-icon" ).click(function() {
			$( this ).toggleClass( "ui-icon-minusthick" ).toggleClass( "ui-icon-plusthick" );
			$( this ).parents( ".homewidget:first" ).find( ".widget-content" ).toggle();
		});
	}
	$(document).on('change', '.gotopage', function (ev) {
		var $_this = $(this);
		window.location.href = $_this.val().toString();
	});
	// End system click global
	
	// Sytem message notification
	if($('#message').length > 0 ){
		var $ok = true;
		if($ok){
			var $message_W = $('#message').outerWidth(false);
			$('#message').animate({'right':10},200).fadeIn().delay(5000).animate({'right':-$message_W},500);
			$ok = false;
		}
	}
	// System tab click
	if($("#clienttabs").length>0){
		makeClientTab();
	}
	if($("#clienttabsCol").length>0){
		makeClientTabCol();
	}
	if($("#isotabs").length>0){
		var _cookie_name = 'systab_'+mod+'_'+act;
		var _cookie_val = $.cookie(_cookie_name);
		clearTimeout(timer_system_tab);
		if(_cookie_val != ''){
			timer_system_tab = setTimeout(function(){
				$('#'+_cookie_val).trigger('click');
			},100);
		}
		makeSystemTab();
	}
	// System send feedback for admin.
	$(document).on('click', '#button_send_feedback', function (ev) {
		var $_this = $(this);
		vietiso_loading(1);
		$.ajax({
			type: "POST",
			url: path_ajax_script + '/?mod=home&act=ajOpenFeedback',
			data: {'tp':'F'},
			dataType: "html",
			success: function (html) {
				vietiso_loading(0);
				makepopup(600,'',html,'feedbackPop');
			}
		});
		return false;
	});	
	$(document).on('click', '#send_feedback', function (ev) {
		var $_this = $(this);
		var $message_feedback = $('#message_feedback');
		if($message_feedback.val()==''){
			$message_feedback.focus();
			alertify.error(field_is_required);
			return false;
		}
		vietiso_loading(1);
		$.ajax({
			type: "POST",
			url: path_ajax_script + '/?mod=home&act=ajOpenFeedback',
			data: {'tp':'S','type': $('#type').val(),'REQUEST_URI' : REQUEST_URI,'message': $message_feedback.val()},
			dataType: "html",
			success: function (html) {
				vietiso_loading(0);
				if(html.indexOf('_SUCCESS') >=0){
					alertify.success('Success !');
					$('#feedbackPop .close_pop').trigger('click');
				}else{
					alertify.success('Error !');
				}
				console.log(html);
			}
		});
		return false;
	});
	// System notes for personal.
	$(document).on('click', '.ajManageSystemNote', function (ev) {
		var $_this = $(this);
		vietiso_loading(1);
		$.ajax({
			type: "POST",
			url: path_ajax_script + '/?mod=home&act=ajOpenNote',
			data: {'tp':'F'},
			dataType: "html",
			success: function (html) {
				vietiso_loading(0);
				makepopup(600,'',html,'NotePop');
				setViewTextAreaByClass('textarea');
			}
		});
		return false;
	});
	// System checkbox list.
	$('#check_all').live('change',function(){
		var _this=$(this);
		var checked=_this.attr('checked');
		if(checked=='checked' || checked){
			$('input[class=chkitem]').attr('checked',true);
			setList();
		}else{
			$('input[class=chkitem]').removeAttr('checked');
			setList();
		}
	});
	$('input[class=chkitem]').live('change',function(){
		setList();
	});
	
	$("#all_check").live('click',function(){
		var rel = $(this).attr('rel');
		var chk = $(this).is(":checked")?1:0;
		$('.'+rel).each(function(){
			if(chk) {
				$(this).attr('checked','checked');
			} else {
				$(this).removeAttr('checked');
			}
		});
	});
	$("#all_check_attr").live('click',function(){
		var rel = $(this).attr('rel');
		var chk = $(this).is(":checked")?1:0;
		$('.'+rel).each(function(){
			if(chk) {
				$(this).attr('checked','checked');
			} else {
				$(this).removeAttr('checked');
			}
		});
	});
});
function saveHomeWidgets(){
	console.log('Moved !');
}
function setSelectOpen(elem) {
    if (document.createEvent) {
        var e = document.createEvent("MouseEvents");
        e.initMouseEvent("mousedown", true, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
        elem[0].dispatchEvent(e);
    } else if (element.fireEvent) {
        elem[0].fireEvent("onmousedown");
    }
}
function getCheckBoxValueByClass(classname){
	var names = [];
	$('.'+classname+':checked').each(function() { 
		names.push(this.value);
	});
	return names;
}
function makeGlobalTab(tabid){
	$('#'+tabid+'_ul li').each(function(tbs){
		$(this).attr('id','tabs_'+tabid+'_'+tbs)
		.addClass('tabs_child')
		.addClass('tabs_child_'+tabid)
		.find('a').attr('href','javascript:void();');
	});
	$('#'+tabid+'_ul li:first').addClass('tabselected');
	$('.tabboxchild_'+tabid).each(function(tbs){
		$(this).attr('id','showtabs_'+tabid+'_'+tbs);
	});
	$('#'+tabid+'_ul li.tabs_child_'+tabid).live('click',function(){
		var elid = $(this).attr("id");
		var tour_property_id = $(this).attr("tour_property_id");
		$('#'+tabid+'_ul li.tabs_child_'+tabid).removeClass("tabselected");
		$(this).addClass("tabselected");
		$('.tabboxchild_'+tabid).hide();
		$("#show"+elid).show();
		if(mod=='tour' && act=='property'){
		loadListSizeGroup(tour_property_id,'SIZEGROUP');
		}
		return false;
	});
}
function makeSystemTab(){
	$('#isotabs li').each(function(tbs){
		$(this).attr('id','isotab'+tbs).addClass('tab').find('a').attr('data','#isotabs'+tbs);
	});
	$('.isotabbox').each(function(tbs){
		$(this).attr('id','isotab'+tbs+'box');
		$(this).attr('data',tbs);
	});
	if(checkfiltertour==1)
	$(".isotabbox").css("display","block");
	else
	$(".isotabbox").css("display","none");
	
	$(document).on('click', '#isotabs .tab', function(ev){
		var tabid = $(this).attr("id");
		var _cookie_name = 'systab_'+mod+'_'+act;
		$("#isotabs .tab").removeClass("tabselected");
		if($("#"+tabid+"box").is(':visible')){
			$("#"+tabid+"box").hide();
			$.cookie(_cookie_name,'');
		}else{
			$(".isotabbox").hide();
			$("#"+tabid+"box").show();
			$("#isotabs #"+tabid).addClass("tabselected");
			$.cookie(_cookie_name,tabid);
		}
		return false;
	});
	return true;
}
function makeClientTab(){
	if(!$("#clienttabs").hasClass('disabled')){
		$('#clienttabs li').each(function(tbs){
			$(this).attr('id','tab'+tbs).addClass('tab').find('a').attr('data','#isotab'+tbs);
		});
		$('.tabbox').each(function(tbs){
			$(this).attr('id','tab'+tbs+'box');
			$(this).attr('data',tbs);
		});
		$(".tabbox").css("display","none");
		var selectedTab;
		$("#clienttabs .tab").live('click',function(){
			if($(this).hasClass('disabled')){return false;}
			if($(this).find('a').attr('isTab')!='0'){
				var elid = $(this).attr("id");
				$(".tab").removeClass("tabselected");
				$("#"+elid).addClass("tabselected");
				if (elid != selectedTab) {
					$(".tabbox").hide();
					$("#"+elid+"box").show();
					selectedTab = elid;
				}
				if($(this).find('a').attr('submit')=='_NOT'){
					$('.submit-buttons').hide();
				}else{
					$('.submit-buttons').show();
				}
				var hs = $(this).find('a').attr('data');
				setTimeout(function(){window.location.hash = hs;},200);
			}
			return false;
		});
		selectedTab = location.hash.substring(1)!=''?location.hash.substring(4):'tab0';
		if($("#"+selectedTab).length==0) selectedTab = 'tab0';
		$("#"+selectedTab).addClass("tabselected");
		$("#"+selectedTab+"box").css("display","");
		if($('#'+selectedTab).find('a').attr('submit')=='_NOT'){
			$('.submit-buttons').hide();
		}else{
			$('.submit-buttons').show();
		}
		if(location.hash.indexOf('iso')!=-1){
			setTimeout(function(){
				window.location.hash = 'iso'+selectedTab;
			},200);
		}
	}
}
function makeClientTabCol(){
	if(!$("#clienttabsCol").hasClass('disabled')){
		$('#clienttabsCol li').each(function(tbs){
			$(this).attr('id','tabcol'+tbs).addClass('tabcol').find('a').attr('data','#isotabCol'+tbs);
		});
		$('.tabboxcol').each(function(tbs){
			$(this).attr('id','tabcol'+tbs+'boxcol');
			$(this).attr('data',tbs);
		});

		var selectedTab;
		$("#clienttabsCol .tabcol").live('click',function(){
			if($(this).hasClass('disabled')){return false;}
			if($(this).find('a').attr('isTab')!='0'){
				var elid = $(this).attr("id");
				$(".tabcol").removeClass("tabselected");
				$("#"+elid).addClass("tabselected");
				if (elid != selectedTab) {
					$(".tabboxcol").hide();
					$("#"+elid+"boxcol").show();
					selectedTab = elid;
				}
				if($(this).find('a').attr('submit')=='_NOT'){
					$('.submit-buttons').hide();
				}else{
					$('.submit-buttons').show();
				}
				var hs = $(this).find('a').attr('data');
				setTimeout(function(){window.location.hash = hs;},200);
			}
			return false;
		});
		selectedTab = location.hash.substring(1)!=''?location.hash.substring(4):'tab0';
		if($("#"+selectedTab).length==0) selectedTab = 'tabcol0';
		$("#"+selectedTab).addClass("tabselected");
		$("#"+selectedTab+"boxcol").css("display","");
		if($('#'+selectedTab).find('a').attr('submit')=='_NOT'){
			$('.submit-buttons').hide();
		}else{
			$('.submit-buttons').show();
		}
		if(location.hash.indexOf('iso')!=-1){
			setTimeout(function(){
				window.location.hash = 'iso'+selectedTab;
			},200);
		}
	}
}
function getmaxzindex(){
	var maxindex = 0;
	$('div').each(function(){
		var zindex = parseInt($(this).css('z-index'));
		if(zindex>maxindex) maxindex=zindex;
	});
	return maxindex;
}
function makepopup(width,height,content,name){
	if($('#'+name).length > 0){
	}else{
		$('<div id="isoblanketpop_'+name+'">').css({
			 position: 'fixed',
			 top: 0, 
			 left: 0,
			 height: $(document).height(), 
			 width: '100%',
			 opacity: 0.3, 
			 backgroundColor: 'black',
		  }).appendTo(document.body).addClass("stacked");
		$('<div id="'+name+'" class="frmPop">').appendTo(document.body).html(content);
		$('#'+name)
		.css('position','fixed')
		.css('width',width)
		.css('height',height)
		.css("left",($(window).width()-$('#'+name).width())/2 + "px")
		.css("top",($(window).height()-$('#'+name).height())/2-20 + "px")
		.addClass("stacked")
		.addClass("transition")
		.addClass("fadeInUp")
		.show().find('.required:first').focus();
	}
	$('#'+name).find('input').live('keydown',function(e){
		if(e.keyCode==13){
			$(this).closest('.frmPop').find('.submitClick').click();
			return false;
		}
		if(e.keyCode==27){
			$(this).closest('.frmPop').find('.close_pop').click(); 
			return false;
		}
	});
	$('#'+name).draggable({
		containment:"body",
		cancel:".form",
		handle:'.headPop'
	});
	$('#'+name).resizable();
}
function makepopupnotresize(width,height,content,name){
	if($('#'+name).length > 0){
	}else{
		$('<div id="isoblanketpop_'+name+'">').css({
			 position: 'fixed',
			 top: 0, 
			 left: 0,
			 height: $(document).height(), 
			 width: '100%',
			 opacity: 0.3, 
			 backgroundColor: 'black',
		  }).appendTo(document.body).addClass("stacked");
		$('<div id="'+name+'" class="frmPop">').appendTo(document.body).html(content);
		$('#'+name)
		.css('position','fixed')
		.css('width',width)
		.css('height',height)
		.css("left",($(window).width()-$('#'+name).width())/2 + "px")
		.css("top",($(window).height()-$('#'+name).height())/2-20 + "px")
		.addClass("stacked")
		.addClass("transition")
		.addClass("zoomOut")
		.show().find('.required:first').focus();
	}
	$('#'+name).find('input').live('keydown',function(e){
		if(e.keyCode==13){
			$(this).closest('.frmPop').find('.submitClick').click();
			return false;
		}
		if(e.keyCode==27){
			$(this).closest('.frmPop').find('.close_pop').click(); 
			return false;
		}
	});
	$('#'+name).draggable({
		containment:"body",
		cancel:".form",
		handle:'.headPop'
	});
}
function reinstance_makepopup(name){
	$('#'+name)
		.css('position','fixed')
		.css('width',width)
		.css('height',height)
		.css("left",($(window).width()-$('#'+name).width())/2 + "px")
		.css("top",($(window).height()-$('#'+name).height())/2-20 + "px")
		.addClass("stacked");
}
function vietiso_loading($show){
	if($show==1){ $('#ajax_loading').fadeIn(200);}
	if($show==0){ $('#ajax_loading').fadeOut(1200);}
	if($show==2){ $('#ajax_loading').fadeOut(100);}
	if($show==5){ $('#ajax_loading').fadeOut(500);}
}
function checkVaidEmail(email){
	var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/; 
	return regex.test(email);
}
function checkVaidUrl(url){
	var regex = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
	return regex.test(url);
}
function getStats(id) {
    var body = tinymce.get(id).getBody(), text = tinymce.trim(body.innerText || body.textContent);
    return {
        chars: text.length,
        words: text.split(/[\w\u2019\'-]+/).length
    };
}
function setCounter($_id,$max,$infoShow){
	var optionsCounter = {
		'maxCharacterSize': $max,
		'displayFormat': ''
	};
	$_id.textareaCount(optionsCounter, function(data){
		var result = data.input + '/' + data.max;
			$infoShow.html(result);
	});
}
function setViewTextAreaByClass($class){
	$("."+$class).each(function(){
		$(this).val($(this).val().replace(/<br\s?\/?>/g,"\n"));
	});
}
function _reload(){
	$('#searchbtn').trigger('click');
	return false;
}
function delete_cookie(name) {
	document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/";
}
function zCheckAll(oForm) {
	$('#'+oForm).find('input[type="checkbox"]').attr("checked","checked");
}
function zUncheckAll(oForm) {
	$('#'+oForm).find('input[type="checkbox"]').removeAttr("checked");
}
function setList(){
	var $check_all=1;
	var $list_id ="";
	var $check_count = 0;

	$('input[class=chkitem]').each(function(){
		var $_this=$(this);
		if($_this.attr('checked')=='checked' || $_this.attr('checked')){
			$list_id += $_this.val()+'|';
			$check_count += 1;
		}else{
			$check_all=0;	
		}
	});
	if($check_count > 0){  
		$('.btn-delete-all').show(); 
		$('.btn-delete-all-new').show();
		$('.btn-delete-all-booking').show();
	}
	else{  
		$('.btn-delete-all').hide(); 
		$('.btn-delete-all-new').hide();
		$('.btn-delete-all-booking').hide();
	}

	$('#list_selected_chkitem').val($list_id);
	if($check_all==0){
		$('#check_all').removeAttr('checked');
	}
	else{
		$('#check_all').attr('checked','checked');
	}
};

/* ============================================================
 * bootstrap-dropdown.js v2.0.3
 * http://twitter.github.com/bootstrap/javascript.html#dropdowns
 * ============================================================
 * Copyright 2012 Twitter, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ============================================================ */
!function ($) {
  "use strict"; // jshint ;_;
 /* DROPDOWN CLASS DEFINITION
  * ========================= */
  var toggle = '[data-toggle="dropdown"]'
    , Dropdown = function (element) {
        var $el = $(element).on('click.dropdown.data-api', this.toggle)
        $('html').on('click.dropdown.data-api', function () {
          $el.parent().removeClass('open')
        })
      }
  Dropdown.prototype = {
    constructor: Dropdown
  , toggle: function (e) {
      var $this = $(this)
        , $parent
        , selector
        , isActive
      if ($this.is('.disabled, :disabled')) return
      selector = $this.attr('data-target')
      if (!selector) {
        selector = $this.attr('href')
        selector = selector && selector.replace(/.*(?=#[^\s]*$)/, '') //strip for ie7
      }
      $parent = $(selector)
      $parent.length || ($parent = $this.parent())
      isActive = $parent.hasClass('open')
      clearMenus()
      if (!isActive) $parent.toggleClass('open')
      return false
    }
  }
  function clearMenus() {
    $(toggle).parent().removeClass('open')
  }
  /* DROPDOWN PLUGIN DEFINITION
   * ========================== */
  $.fn.dropdown = function (option) {
    return this.each(function () {
      var $this = $(this)
        , data = $this.data('dropdown')
      if (!data) $this.data('dropdown', (data = new Dropdown(this)))
      if (typeof option == 'string') data[option].call($this)
    })
  }
  $.fn.dropdown.Constructor = Dropdown
  /* APPLY TO STANDARD DROPDOWN ELEMENTS
   * =================================== */
  $(function () {
    $('html').on('click.dropdown.data-api', clearMenus)
    $('body')
      .on('click.dropdown', '.dropdown form', function (e) { e.stopPropagation() })
      .on('click.dropdown.data-api', toggle, Dropdown.prototype.toggle)
  })

}(window.jQuery);
var height = $(window).height();
$(".Review").css({'height':height});

var cookieList = function(cookieName) {
//When the cookie is saved the items will be a comma seperated string
//So we will split the cookie by comma to get the original array
    var cookie = $.cookie(cookieName);
//Load the items or a new array if null.
    var items = cookie ? cookie.split(/,/) : new Array();

//Return a object that we can use to access the array.
//while hiding direct access to the declared items array
//this is called closures see http://www.jibbering.com/faq/faq_notes/closures.html
    return {
        "add": function(val) {
            //Add to the items.
            items.push(val);
            //Save the items to a cookie.
            //EDIT: Modified from linked answer by Nick see
            //      http://stackoverflow.com/questions/3387251/how-to-store-array-in-jquery-cookie
            $.cookie(cookieName, items.join(','));
        },
        "remove": function (val) {
            //EDIT: Thx to Assef and luke for remove.
            indx = items.indexOf(val);
            if(indx!=-1) items.splice(indx, 1);
            $.cookie(cookieName, items.join(','));        },
        "clear": function() {
            items = null;
            //clear the cookie.
            $.cookie(cookieName, null);
        },
        "items": function() {
            //Get all the items.
            return items;
        }
    }
}