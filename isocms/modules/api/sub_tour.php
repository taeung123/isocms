<?php
function tour_getAll(){
	global $smarty,$core,$dbconn,$_LANG_ID,$deviceType,$clsISO,$clsConfiguration;
	#
	$raws_input = file_get_contents('php://input');
	$raws_input = stripslashes(html_entity_decode($raws_input));
	$params = @json_decode($raws_input, true);
	$clsTable = 'Tour';
	$cond = isset($params['cond']) ? $params['cond'] : "";
	$field = isset($params['field']) ? $params['field'] : "*";
	//header('Content-Type: application/json; charset=utf-8');
	//echo json_encode($params); die();
	if(!empty($clsTable)){
		$clsClassTable = new $clsTable();
		if(empty($cond)) $cond = "1=1";
		$dbconn->setFetchMode(ADODB_FETCH_ASSOC);
		$data = $clsClassTable->getAll($cond, 'title, slug,tour_id');
		// Return
		Response::echoResponse(200, array(
			'result' => 'success',
			'data' => $data
		), 'application/json'); die();
	} else {
		Response::echoResponse(200, array(
			'result' => 'error',
			'message' => $core->get_Lang('Invalid Arguments OR Not Empty')
		)); die();
	}
}
?>
