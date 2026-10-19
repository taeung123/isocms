$().ready(function(){
	// Page Promotion - Mod: Promotion - Act: Edit
	if(mod == 'reviews' && act== 'edit') {
		loadListChoose($('.chooseTypeReviews').val());
		$(document).on('change', '.chooseTypeReviews', function(ev){
			var $_this = $(this);
			loadListChoose($_this.val());
		});
	}
});
function loadListChoose($type) {
	$.ajax({
		type: "POST",
		url: path_ajax_script+'/index.php?mod='+mod+'&act=ajaxLoadListChoose',
		data: {'reviews_id':$reviews_id,'type':$type},
		dataType: "html",
		success: function(html){
			$('#loadListChoose').html(html);
		}
	});
}