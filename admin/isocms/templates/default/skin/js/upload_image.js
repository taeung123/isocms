var _timeOut,
$Core = (function($, window, document, undefined) {	
	return {
		init : function(){
		},
		util: {
			toggleIndicatior: function(type){
				if(type==1){ $('#ajax-indicator').fadeIn();}
				if(type==0){ $('#ajax-indicator').fadeOut();}
			},
			checkValidEmail: function(email){
				var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
				return re.test(email);
			},
			delay: function(callback, ms) {
				var timer = 0;
				return function() {
					var context = this, 
						args = arguments;
					clearTimeout(timer);
					timer = setTimeout(() => {
						callback.apply(context, args); 
					}, ms || 0);
				}
			},
			isEmpty: function(value) {
				if(!value || 0 === value.length){
					return true;
				}
				if(typeof(value) == 'number' || typeof(value) == 'boolean'){ 
					return false; 
				}
				if(typeof(value) == 'undefined' || value === '0' || value === null || value=='undefined'){
					return true; 
				}
				if(typeof(value.length) != 'undefined'){
					return value.length == 0;
				}
				var count = 0;
				for(var i in value){
					if(data.hasOwnProperty(i)){
						count ++;
					}
				}
				return count == 0;
			},
			getTextAreaContent: function(id) {
                if ($("#" + id).length)
                    return tinyMCE.get(id).getContent();
                else
                    return '';
            },
			stopEventHandler: function(e){
				e.preventDefault();
				e.stopImmediatePropagation();
			},
			getCheckBoxValueByClass: function(classname) {
                var names = [];
                $('.' + classname + ':checked').each(function() {
                    names.push(this.value);
                });
                return names;
            },
		},
		popup: {
			close: function(name) {
				var _id = name.attr("id");
				if ($("#isoblanketpop_" + _id).length) {
					$("#isoblanketpop_" + _id).remove();
				}
				/* delete all events */
				name.remove();
				if($('.modal').length == 0){
					$('body').removeClass('modal-open');
				}
			},
			open: function (width,height,content,name){
				if($('#'+name).length > 0){
				}else{
					if(!$('body').hasClass('modal-open')){
						$('body').addClass('modal-open');
					}
					$('<div id="isoblanketpop_'+name+'">').css({
						 position: 'fixed',
						 top: 0, 
						 left: 0,
						 height: $_document.height(), 
						 width: '100%',
						 opacity: 0.3, 
						 backgroundColor: 'black',
						 zIndex : '3',
					}).appendTo(document.body).addClass("stacked");
					var html = '<div id="'+name+'" class="modal animated bounceInDown in" style="display:none" tabindex="-1" role="dialog" aria-hidden="false">'+content+'</div>';
					$(document.body).append(html);
					var $win = $(window),
						$thisPop = $('#'+name),
						$overflow = 'auto';
					if($(window).width()<768){
						width = '100vw';
						$overflow = 'auto';
					}
					$thisPop.css('position','fixed')
						.css('overflow',$overflow)
						.css('z-index', '4')
						.css("left",($win.width()-$('#'+name).width())/2 + "px")
						.css("top",($win.height()-$('#'+name).height())/2 + "px")
						.stop(false, true).fadeIn()
						.find('.required:first').focus();
					$thisPop.find('input').on('keydown',function(e){
						var keyCode = e.keyCode || e.which;
						if(keyCode===13){
							$(this).closest('.modal-form').find('.submitClick').click();
							return false;
						}else if(keyCode===27){
							$(this).closest('.modal-form').find('.close_pop').click(); 
							return false;
						}
					});
				}
			},
		},
		alert: {
			alert: function(title, content){
				$.alert({
					title: title,
					content: content,
				});
			},
			confirm: function(title, content, callback){
				$.confirm({
					title: title,
					content: content,
					buttons: {
						ok: function(){
							console.log(typeof(callback));
							if(typeof(callback) === 'function'){
								callback();
							} else {
								$Core.alert.alert(__['Message'], callback);
							}
						},
						cancel: function(){
							// close
						}
					}
				});
			},
		}
	}
})(jQuery, window, document);
$(function(){
	$Core.init();
    $_document.ajaxComplete(function() {
        $Core.init();
    });

});

function gallery_file_drop(e, openFrom='image') {
	
    e.preventDefault();
	var total_galleries = $('.total_galleries').val();
	if(parseInt(total_galleries) >= 9){
		$Core.alert.alert(__['Message'], "H? th?ng cho ph�p hi?n th? t?i da 9 ?nh");	
	} else {
		let file = e.dataTransfer.files[0];
		if (/^image\/\w+/.test(file.type)) {
			gallery_file_upload(file, openFrom);
		}
	}
}
function gallery_file_explorer(_this, e, openFrom='image') {
	e.preventDefault();
	var total_galleries = $('.total_galleries').val();
	if(parseInt(total_galleries) >= 9){
		$Core.alert.alert(__['Message'], "H? th?ng cho ph�p hi?n th? t?i da 9 ?nh");	
	} else {
		$('#'+'isoman-upload-file-image').val("").click();
		$('#'+'isoman-upload-file-image').change(function(){
			let file, files = $(this).prop('files');
			if (files && files.length) {
				file = files[0];
				if (/^image\/\w+/.test(file.type)) {
					gallery_file_upload(file, openFrom);
				}
			}
		});
	}
	return false;
}
function gallery_file_upload(file, openFrom='image'){
	var URL = window.URL || window.webkitURL,
		imgdata = URL.createObjectURL(file),
		filename = $.trim(file.name);
	
	$.post(path_ajax_script+'/index.php?mod=home&act=load_open_cropper', {'tour_id':1, 'imgdata':imgdata,'openFrom':openFrom}, function(html){
		$Core.util.toggleIndicatior(0);
		$Core.popup.open('auto', 'auto', html, 'open_cropper_'+tour_id);
		var URL = window.URL || window.webkitURL,
			$cropper = $('#'+'cropper'),
			$cropper_width = $('#'+'cropper-width'),
			$cropper_height = $('#'+'cropper-height'),
			options = {
                aspectRatio: (4 / 3),
                crop: function(e) {
                    $cropper_width.val(Math.round(e.detail.height));
                    $cropper_height.val(Math.round(e.detail.width));
                }
            },
			originalImageURL = $cropper.attr('src'),
			uploadedImageName = 'cropped.png',
			uploadedImageType = 'image/png',
			uploadedImageURL, $target;
        $cropper.cropper(options);
		$('.ui-cropper-tool').on('click', function(e){
			$Core.util.stopEventHandler(e);
			var $_this = $(this),
				data = $_this.data(),
				cropper = $cropper.data('cropper');
			if (cropper && data.method) {
                data = $.extend({}, data); // Clone a new one
                if (typeof data.target !== 'undefined') {
                    $target = $(data.target);
                    if (typeof data.option === 'undefined') {
                        try {
                            data.option = JSON.parse($target.val());
                        } catch (e) {
                            console.log(e.message);
                        }
                    }
                }
				cropped = cropper.cropped;
				switch (data.method) {
                    case 'rotate':
                        if (cropped && options.viewMode > 0) {
                            $cropper.cropper('clear');
                        }
                        break;
                    case 'getCroppedCanvas':
                        if (uploadedImageType === 'image/jpeg') {
                            if (!data.option) {
                                data.option = {};
                            }
                            data.option.fillColor = '#fff';
                        }
                        break;
                }
				var result = $('#cropper').cropper(data.method, data.option);
                switch (data.method) {
					case 'rotate':
						if (cropped && options.viewMode > 0) {
						  $cropper.cropper('crop');
						}
						break;
					case 'scaleX':
					case 'scaleY':
						$(this).data('option', -data.option);
						break;
					case 'getCroppedCanvas':
						if (result) {
							var imagedata = result.toDataURL(uploadedImageType),
								imgdata = imagedata.replace(/^data:image\/(png|jpg);base64,/, ""),
								$_adata = {'tour_id':tour_id, 'imgdata':imgdata, 'filename':filename};
							if(openFrom == 'gallery'){
								$.post(PCMS_URL+'/index.php?mod='+mod+'&act=upload_gallery', $_adata, function(html){
									$cropper.cropper('destroy');
									$('form')[0].reset();
									$Core.popup.close($('#'+'open_cropper_'+tour_id));
									load_list_gallery(tour_id);
								});
							} else {
								$.post(PCMS_URL+'/index.php?mod='+mod+'&act=upload_image', $_adata, function(html){
									$('form')[0].reset();
									$cropper.cropper('destroy');
									$Core.popup.close($('#'+'open_cropper_'+tour_id));
									if(html.indexOf('_error') >= 0){
										$Core.alert.alert(__['Message'], __['Image upload error']);
									} else {
										$('#image_'+tour_id).attr('src', html);
									}
								});
							}
							return false;
						}
						break;
                    case 'destroy':
                        if (uploadedImageURL) {
                            URL.revokeObjectURL(uploadedImageURL);
                            uploadedImageURL = '';
                            $image.attr('src', originalImageURL);
                        }
                        break;
				}
				if (typeof result === 'object' && result !== cropper && $target) {
					try {
						$target.value = JSON.stringify(result);
					} catch (e) {
						console.log(e.message);
					}
				}
			}
			return false;
		});
	});
}
function pager_gallery_prev(_this, page){
	var tour_id = $(_this).attr('tour_id');
	load_list_gallery(tour_id, {'page':page});
	return false;
}
function pager_gallery_next(_this, page){
	var tour_id = $(_this).attr('tour_id');
	load_list_gallery(tour_id, {'page':page});
	return false;
}
function delete_gallery(_this){

	var tour_id = $(_this).attr('tour_id'),
		tour_image_id = $(_this).attr('tour_image_id');
	$Core.alert.confirm('Confirm', 'Are you sure you want to delete this?', function(){
		var $_adata = {'tour_id':tour_id,'tour_image_id':tour_image_id};
		$Core.util.toggleIndicatior(1);
		$.post(PCMS_URL+'/index.php?mod='+mod+'&act=delete_gallery',$_adata, function(html){
			$Core.util.toggleIndicatior(0);
			if(html.indexOf('success') >= 0){
				load_list_gallery(tour_id, {});
			}
		});
	});
}