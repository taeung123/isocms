(function($){
	$.fn.selectstyle = function(option){
		var defaults = {
			width  : 300,
			height : 532,
			theme  : 'light'
		},
		setting = $.extend({}, defaults, option);
		this.each(function(){
			var $this = $(this),
				parent = $(this).parent(),
				html = '',
				html_op = '',
				search = $this.attr('data-search'),
				name = $this.attr('name'),
				style = $this.attr('style'),
				placeholder = $this.attr('placeholder'),
				id = $this.attr('id');
			setting.width = (parseInt($this.attr('width') == null ? $this.width() : $this.attr('width') ) + 10 )+'px';
			setting.theme = $this.attr('theme') != null ? $this.attr('theme') : setting.theme;

			$this.find('option').each(function (e) {
				var $this_a = $(this),
					val = $this_a.val(),
					image = $this_a.attr('data-image'),
					strtolower_title = $this_a.data('strtolower_title'),
					slug = $this_a.data('slug'),
					text = $this_a.html();
				if(val == null){
					val = text;
				}
				html_op += '<li data-slug="'+slug+'" data-strtolower_title="'+strtolower_title+'" data-title="'+text+'" value="'+val+'"';
				if($this_a.attr('font-family') != null){
					html_op += ' style="font-family'+$this_a.attr('font-family')+'"';
				}
				html_op += '>';
				if(image != null){
					html_op += '<div class="ssli_image"><img src="'+image+'"></div>';
				}
				html_op += '<div class="ssli_text">'+text+'</div></li>';
			});
			$this.hide();

			html = 
			'<div class="selectstyle ss_dib '+setting.theme+'" style="width:'+parseInt(setting.width)+'px;">'+
				'<div id="select_style" class="ss_button" style="width:'+parseInt(setting.width)+'px;'+style+'">'+
					'<div class="ss_dib ss_text" id="select_style_text" style="margin-right:15px;width:'+(parseInt(setting.width) - 20)+'px;position:relative;">'+placeholder+'</div>'+
					'<div class="ss_dib ss_image"></div>'+
				'</div>';
			if(search == "true"){
				html += '<ul id="select_style_ul" sid="'+id+'" class="ss_ulsearch" style="max-height:'+setting.height+'px;width:'+(parseInt(setting.width) + 20)+'px;"><div class="search" id="ss_search"><input type="text" placeholder="Tìm kiếm nhanh"></div><ul style="max-height:'+(parseInt(setting.height) - 53)+'px;width:'+(parseInt(setting.width) + 20)+'px;" class="ss_ul">'+html_op+'</ul></ul>';
			}
			else{
				html += '<ul id="select_style_ul" sid="'+id+'" style="max-height:'+setting.height+'px;width:'+(parseInt(setting.width) + 20)+'px;" class="ss_ul">'+html_op+'</ul>';
			}
			
			html += '</div>';
			$(html).insertAfter($this);
			
		});

		$("body").delegate( "div#ss_search input", "keyup", function(e) {
			var val = $(this).val(),slug_val=removeVietnameseTones($(this).val()), flag=false;
			$('#nosearch').remove();
			$(this).parent().parent().find('li').each(function(index, el) {
				if($(el).text().indexOf(val) > -1 || $(el).data('strtolower_title').indexOf(val) > -1 || $(el).data('slug').indexOf(slug_val) > -1){
					$(el).show();
					flag=true;
				}
				else{
					$(el).hide();
				}
			});
			if (!flag) {$(this).parent().parent().append('<div class="nosearch" id="nosearch">Không tìm thấy</div>')};
		});
		$("body").delegate( "div#select_style", "click", function(e) {
			$('ul#select_style_ul').hide();
			var ul = $(this).parent('div').find('ul#select_style_ul');
			ul.show();
			$(this).parent('div').find('#ss_search input').focus();
			var height = ul.height();
			var offset = $(this).offset();
			if(offset.top+height > $(window).height()){
				ul.css({
					marginTop: -(((offset.top+height) - $(window).height()) + 100)
				});
			}
		});
		$("body").delegate("ul#select_style_ul li", "click", function(e) {
			var txt = $(this).data('title'),
				vl = $(this).attr('value'),
				sid = $(this).parents('ul#select_style_ul').attr('sid');
			$(this).parents('ul#select_style_ul').hide();
			$(this).parents('ul#select_style_ul').parent('div').find('div#select_style_text').html(txt);
			$('#'+sid).children('option').filter(function(){return $(this).val()==vl}).prop('selected',true).change();
		});
		$(document).delegate("body", "click", function(e) {
			var clickedOn=$(e.target);
			if(!clickedOn.parents().andSelf().is('ul#select_style_ul, div#select_style')){
				$('ul#select_style_ul').fadeOut(400);
				$('div#ss_search').children('input').val('').trigger('keyup');
			}
		});
	}
})(jQuery);
function removeVietnameseTones(str) {
    str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g,"a"); 
    str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g,"e"); 
    str = str.replace(/ì|í|ị|ỉ|ĩ/g,"i"); 
    str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g,"o"); 
    str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g,"u"); 
    str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g,"y"); 
    str = str.replace(/đ/g,"d");
    str = str.replace(/À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ/g, "A");
    str = str.replace(/È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ/g, "E");
    str = str.replace(/Ì|Í|Ị|Ỉ|Ĩ/g, "I");
    str = str.replace(/Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ/g, "O");
    str = str.replace(/Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ/g, "U");
    str = str.replace(/Ỳ|Ý|Ỵ|Ỷ|Ỹ/g, "Y");
    str = str.replace(/Đ/g, "D");
    str = str.replace(/\u0300|\u0301|\u0303|\u0309|\u0323/g, ""); // ̀ ́ ̃ ̉ ̣  huyền, sắc, ngã, hỏi, nặng
    str = str.replace(/\u02C6|\u0306|\u031B/g, ""); // ˆ ̆ ̛  Â, Ê, Ă, Ơ, Ư
    // Remove extra spaces
    // Bỏ các khoảng trắng liền nhau
    str = str.replace(/ + /g," ");
    str = str.trim();
    return str.toLowerCase();
}