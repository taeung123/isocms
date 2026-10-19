$().ready(function(){
	// Page Promotion - Mod: Promotion - Act: Edit
	if(mod == 'testimonial' && act== 'edit') {
		/* TAG NEWS */
		if($SiteHasTags_Testimonial==1){
			$("#txtTag").autocomplete(availableTags, {
				minChars: 1,
				width: 200,
				matchContains: true,
				autoFill: false,
				formatItem: function(row, i, max) {
					return row.name;
				},
				formatResult: function(row) {
					return row.val;
				}
			});
			$('#txtTag').keypress(function(e) {
				var key;
				if (window.event)
					key = window.event.keyCode;
				else
					key = e.which;
				if (key == 13) {
					$('#addTag').trigger('click');
				}
			});
			$(document).on('click', '#addTag', function(ev){
				var newval = $('#txtTag').val();
				if (newval != '') {
					vietiso_loading(1);
					$.ajax({
						type: "POST",
						url: path_ajax_script+'/index.php?mod='+mod+'&act=ajSiteTestimonialTags',
						data: {"for_id": pvalTable,"val": $('#txtTag').val(),"type": $type,'tp': 'S'},
						dataType: "html",
						success: function(html) {
							vietiso_loading(0);
							if(html.indexOf('_EXIST') >= 0) {
								alertify.error(exist_error);
							} else {
								$('#listTag').append(html);
								$('#txtTag').val('').focus();
							}
						}
					});
					return false;
				}
			});
			$(document).on('click', '.closeTag', function(ev){
				if(confirm(confirm_delete)){
					var $_this = $(this);
					var id = $_this.attr('id');
					var sp = id.split('-');
					var tag_module_id = sp[1];
					vietiso_loading(1);
					$.ajax({
						type: "POST",
						url: path_ajax_script + '/index.php?mod='+mod+'&act=ajSiteTestimonialTags',
						data: {"tag_module_id": tag_module_id,'tp': 'D'},
						dataType: "html",
						success: function(html) {
							vietiso_loading(0);
							$_this.parent().remove();
						}
					});
				}
				return false;
			});
			function stopRKey(evt) {
				var evt = (evt) ? evt : ((event) ? event : null);
				var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
				if ((evt.keyCode == 13) && (node.type == "text")) {
					return false;
				}
			}
			document.onkeypress = stopRKey;
		}
	}
});