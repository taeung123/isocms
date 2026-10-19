$(function(){
	var _timeout;
	$_document.on('click', '.btnCreate', function(){
		var $_this = $(this),
		 issue_main=$_this.attr('issue_main'),
			$_form = $_this.closest('form'),
			issue_assigned_to_id = $('#issue_assigned_to_id').val();
		if($('#issue_subject').val()==''){
			$Core.alert.error(issue_subject_required);
			return false;
		}
		if($('#user_group_id').val()=='0'){
			$Core.alert.error(user_group_required);
			return false;
		}
		if($('#issue_tracker_id').val()=='0'){
			$Core.alert.error(tracker_required);
			return false;
		}
		if($('#issue_assigned_to_id').val()=='0'){
			$Core.alert.error(issue_assigned_to_required);
			return false;
		}
		if($('#issue_status_id').val()=='0'){
			$Core.alert.error(issue_status_required);
			return false;
		}
		if($('#issue_priority_id').val()=='0'){
			$Core.alert.error(issue_priority_required);
			return false;
		}
		if($('#issue_estimated_hours').val()==''){
			$Core.alert.error(issue_estimated_hours_required);
			return false;
		}
		var issue_content = tinyMCE.activeEditor.getContent();
		if($Core.util.isEmpty(issue_content)){
			issue_content = $Core.util.getTextAreaContent('issue_content');
		}
		//console.log($('#issue_content').length);
		//var issue_content = $Core.util.getTextAreaContent('issue_content');
		//console.log('issue_content:'+issue_content);
		if($Core.util.isEmpty(issue_content)){
			$Core.alert.error(please_input_content);
			return false;
		}
		var _async = true;
		let frag = document.createElement('div')
		// Add the string to the placeholder
		frag.innerHTML = issue_content;
		// Search the placeholder for img tags
		let itemsBase64 = [...frag.querySelectorAll('img')]
	   // Remove items that don't start with data
	  .filter(img => img.getAttribute('src').startsWith('data'))
	  // Get the value of the src tag
	  .map(img => img.getAttribute('src'));
		console.log(itemsBase64);
		if(itemsBase64.length){
			_async = false;
			$.ajax({
				type: "POST",
				url: PCMS_URL + '/index.php?mod=ajax&act=convertBase64toImage',
				data: {
					content : issue_content
				},
				async:false,
				dataType : 'json',
				success: function (res) {
					issue_content = res.content;
				}
			});
		}
		console.log(issue_content);
		toggleIndicatior(1);
		$_form.ajaxSubmit({
			type : "POST",
			url : PCMS_URL+"/issues/ajax/add.cfg",
			data: {'issue_content':issue_content},
			async:_async,
			dataTYpe : 'html',
			success: function(html){
				toggleIndicatior(0);
				if(html.indexOf('_success') >=0){
					var htm = html.split('|||');
					if(issue_assigned_to_id==_frontIsLoggedin_user_id){
						window.location.href= htm[1];
					}else{
						$Core.alert.success(__['addsuccess']);
						if(issue_main===1) {
							loadCalendar();
						}else {
							loadCalendarMain();
						}
					}
					$('.closeEv').trigger('click');
				}else{
					$Core.alert.error('Error !');
				}
			}
		});
	});	
});