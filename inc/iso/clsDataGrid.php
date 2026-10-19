<?
/*======================================================================*\
|| #################################################################### ||
|| # Core Function                                                    # ||
|| # ISOCMS 5.0.0 By Luong Tien Dung (luongtiendung@gmail.com)        # ||
|| # ---------------------------------------------------------------- # ||
|| # All PHP code in this file is ©2007-2014 VietISO JSC.             # ||
|| # This file may not be redistributed in whole or significant part. # ||
|| # ---------------- ISOCMS IS NOT FREE SOFTWARE ----------------    # ||
|| # http://www.vietiso.com | http://www.vietiso.com/license.html     # ||
|| #################################################################### ||
\*======================================================================*/
class DataGrid extends Paging{
	var $columns 			=	array();
	var $totalCols			=	0;	
	var $tableAttrib		=	"";
	var $headerClass		=	"gridheader";
	var $headerClass1		=	"gridheader1";
	var $gridrowClass		=	"gridrow";
	var $gridrowClass1		=	"gridrow1";
	var $gridrowClass2		=	"gridrow2";
	var $gridrowClass3		=	"gridrow3";
	//
	var $orderby 	= "";
	var $table 		= 	"";
	var $cond 		= 	"";
	var $query 		= 	"";
	var $queryc 	= 	"";
	var $pkey 		= 	"";
	var $dataGrid 	= 	"";
	var $title		=	"Title";
	//function
	function __construct($_curPage="", $_rowsPerPage=10){
		Paging::Paging($_curPage, $_rowsPerPage);
	}
	//function
	function setDbTable($_table, $_cond=""){
		$this->table = $_table;
		$this->cond = $_cond;
	}
	//function
	function setDbQuery($_query, $_queryc){
		$this->query = $_query;
		$this->queryc = $_queryc;
	}	
	//function
	function setTitle($_title){
		$this->title = $_title;
	}
	function getLang($key){
		global $_LANG;
		if (strpos($key, " ")!==false){
			$arr = str_word_count($key, 1);
			foreach ($arr as $k => $v){
				$val = trim($v, "'?,");
				$trans= (isset($_LANG[$val]))? $_LANG[$val] : $val;
				$key = str_replace($val, $trans, $key);
				
			}
			return $key;
		}else{
			$val = trim($key, "'?,");
			$trans= (isset($_LANG[$val]))? $_LANG[$val] : $val;
			$key = str_replace($val, $trans, $key);
			return $key;
		}
		return $key;
	}
	function get_Lang($key){
		global $_LANG_ID,$dbconn,$core;
		return $core->get_Lang($key);
	}
	//function
	function getTitle(){
		return $this->title;
	}
	//function
	function setPkey($_pkey){
		$this->pkey = $_pkey;
	}
	//function
	function setOrderBy($_orderby=""){
		$this->orderby = $_orderby;
	}
	//function
	function setDataLoad($_dataload=""){
		$this->_dataload = base64_encode($_dataload);
	}
	//function
	function addColumnHidden($colname){
		$this->columns[] = array("colname"=>$colname, "coltype"=>"hidden", "attrib"=>$attrib);
		$this->totalCols++;
	}
	//function	
	function addColumnLabel($colname,$coltitle="", $attrib="align='left'"){
		if ($coltitle=="") $coltitle = $colname;
		$this->columns[] = array("colname"=>$colname, "coltitle"=>$coltitle, "coltype"=>"label", "attrib"=>$attrib);
		$this->totalCols++;
	}
	//function	
	function addColumnAction($colname,$coltitle="", $attrib=""){
		if($colname=='move'){
			$this->addColumnAction('move_up',"Move up", $attrib="");
			$this->addColumnAction('move_down',"Move down", $attrib="");
			$this->addColumnAction('move_top',"Move top", $attrib="");
			$this->addColumnAction('move_bottom',"Move bottom", $attrib="");
		}
		else{
			$this->columns[] = array("colname"=>$this->pkey, "coltitle"=>$coltitle, "coltype"=>"action", "attrib"=>$attrib, "_action"=>$colname);
			$this->totalCols++;
		}
	}
	//function
	function addColumnText($colname,$coltitle="", $attrib="align='left'"){
		if ($coltitle=="") $coltitle = $colname;
		$this->columns[] = array("colname"=>$colname, "coltitle"=>$coltitle, "coltype"=>"text", "attrib"=>$attrib);
		$this->totalCols++;
	}
	//function
	function addColumnTextTable($colname,$coltitle="",$class="",$fnc="", $attrib="align='left'"){
		if ($coltitle=="") $coltitle = $colname;
		$this->columns[] = array("colname"=>$colname, "coltitle"=>$coltitle, "coltype"=>"texttable", "attrib"=>$attrib, "class"=>$class, "fnc"=>$fnc);
		$this->totalCols++;
	}
	//function
	function addColumnOrderLabel($colname,$coltitle="", $attrib="align='left'"){
		if ($coltitle=="") $coltitle = $colname;
		$this->columns[] = array("colname"=>$colname, "coltitle"=>$coltitle, "coltype"=>"orderlabel", "attrib"=>$attrib);
		$this->totalCols++;
	}
	//function
	function addColumnEmail($colname,$coltitle="", $attrib="align='left'"){
		if ($coltitle=="") $coltitle = $colname;
		$this->columns[] = array("colname"=>$colname, "coltitle"=>$coltitle, "coltype"=>"email", "attrib"=>$attrib);
		$this->totalCols++;
	}
	//function
	function addColumnUrl($colname, $coltitle="", $attrib="align='left'", $tagA="<a href='%1%'>%1%</a>"){
		if ($coltitle=="") $coltitle = $colname;
		$this->columns[] = array("colname"=>$colname, "coltitle"=>$coltitle, "coltype"=>"url", "attrib"=>$attrib, "tagA"=>$tagA);
		$this->totalCols++;
	}
	//function
	function addColumnImage($colname,$coltitle="", $imgattr="border:0", $attrib="align='left'"){
		if ($coltitle=="") $coltitle = $colname;
		$this->columns[] = array("colname"=>$colname, "coltitle"=>$coltitle, "coltype"=>"image", "imgattr"=>$imgattr, "attrib"=>$attrib);
		$this->totalCols++;
	}
	//function
	function addColumnCheckBox($colname,$coltitle="", $attrib="align='left'", $arrContants=""){
		if ($coltitle=="") $coltitle = $colname;
		$this->columns[] = array("colname"=>$colname, "coltitle"=>$coltitle, "coltype"=>"checkbox", "attrib"=>$attrib, "arrContants"=>$arrContants);
		$this->totalCols++;
	}
	//function
	function addColumnSelect($colname,$coltitle="", $attrib="align='left'", $arrOptions="", $valueSameOption=0){
		if ($coltitle=="") $coltitle = $colname;
		$this->columns[] = array("colname"=>$colname, "coltitle"=>$coltitle, "coltype"=>"select", "attrib"=>$attrib, "arrOptions"=>$arrOptions, "valueSameOption"=> $valueSameOption);
		$this->totalCols++;
	}
	//function
	function addColumnDate($colname,$coltitle="", $attrib="align='left'", $date_format="m/d/Y"){
		if ($coltitle=="") $coltitle = $colname;
		$this->columns[] = array("colname"=>$colname, "coltitle"=>$coltitle, "coltype"=>"date", "attrib"=>$attrib, "date_format"=>$date_format);
		$this->totalCols++;
	}
	//function
	function showColumnLabel($c, $value){
		if (strlen($value)>200) $value = substr($value, 0, 200)."...";
		return html_entity_decode($value);
	}
	//function
	function showColumnAction($c, $value, $pval){
		global $core,$clsISO,$dbconn;
		$pval = $core->encryptID($pval);
		$html = '';
		if($c['_action']=='view'){
			$href = $clsISO->getLinkView($this->table,$core->decryptID($pval));
			$html = '
				<a class="btn btn-success" target="_blank" href="'.$href.'"><i class="icon-eye-open icon-white"></i></a>
			';
		}
		if($c['_action']=='edit'){
			$href = $this->baseURL.'&_base_url='.base64_encode($this->baseURL).'&act=edit&'.$this->pkey.'='.$pval;
			$html = '
				<a class="btn btn-primary" href="'.$href.'"><i class="icon-edit icon-white"></i></a>
			';
		}
		if($c['_action']=='delete'){
			$href = $this->baseURL.'&act=delete&'.$this->pkey.'='.$pval;
			$html = '
				<a class="btn btn-danger" href="'.$href.'"><i class="icon-remove icon-white"></i></a>
			';
		}
		if($c['_action']=='trash'){
			$tmp = $dbconn->getAll("select is_trash from ".$this->table." where ".$this->pkey."='".$core->decryptID($pval)."' limit 0,1");
			if($tmp[0]['is_trash']==0){
				$href = $this->baseURL.'&act=trash&'.$this->pkey.'='.$pval;
				$html = '
					<a title="'.$core->get_Lang("Move to trash").'" class="btn btn-warning fileinput-button" href="'.$href.'"><i class="icon-trash icon-white"></i></a>
				';
			}
			else{
				$href = $this->baseURL.'&act=restore&'.$this->pkey.'='.$pval;
				$html = '
					<a title="'.$core->get_Lang("Restore from trash").'" class="btn btn-success fileinput-button" href="'.$href.'"><i class="icon-refresh icon-white"></i></a>
				';
			}
		}
		if($c['_action']=='move_up'){
			$href = $this->baseURL.'&act=move&_base_url='.base64_encode($this->baseURL).'&_dataload='.$this->_dataload.'&direct=up&'.$this->pkey.'='.$pval;
			$html = '<a href="'.$href.'" title="'.$this->get_Lang($c['coltitle']).'"><i class="icon-arrow-up"></i></a>';
		}
		if($c['_action']=='move_down'){
			$href = $this->baseURL.'&act=move&_base_url='.base64_encode($this->baseURL).'&_dataload='.$this->_dataload.'&direct=down&'.$this->pkey.'='.$pval;
			$html = '<a href="'.$href.'" title="'.$this->get_Lang($c['coltitle']).'"><i class="icon-arrow-down"></i></a>';
		}
		if($c['_action']=='move_top'){
			$href = $this->baseURL.'&act=move&_base_url='.base64_encode($this->baseURL).'&_dataload='.$this->_dataload.'&direct=top&'.$this->pkey.'='.$pval;
			$html = '<a href="'.$href.'" title="'.$this->get_Lang($c['coltitle']).'"><i class="icon-circle-arrow-up"></i></a>';
		}
		if($c['_action']=='move_bottom'){
			$href = $this->baseURL.'&act=move&_base_url='.base64_encode($this->baseURL).'&_dataload='.$this->_dataload.'&direct=bottom&'.$this->pkey.'='.$pval;
			$html = '<a href="'.$href.'" title="'.$this->get_Lang($c['coltitle']).'"><i class="icon-circle-arrow-down"></i></a>';
		}
		return $html;
	}
	//function
	function showColumnEmail($c, $value){
		return "<a href='mailto:$value'>".$value."</a>";
	}
	/*//function
	function showColumnUrl($c, $value){
		return "<a href='$value' target='_blank'>".$value."</a>";
	}*/
	function showColumnUrl($c, $value){
		global $core;
		//$value.= "&return=".base64_encode($_SERVER['QUERY_STRING']);
		$tagA = str_replace("%1%", $core->encryptID($value), $c["tagA"]);
		return $tagA;
	}
	//function
	function showColumnOrderLabel($c, $value) {
		return html_entity_decode($value);
	}
	//function
	function showColumnImage($c, $value){
		if(eregi('swf',$value))	
			return '<embed width="130px" allowscriptaccess="always" wmode="opaque" quality="high" bgcolor="#ffffff" name="cplayer" id="cplayer" src="'.URL_UPLOADS.'/'.$value.'" type="application/x-shockwave-flash"/>';
		else	
			return "<img src='".URL_UPLOADS."/$value' ".$c["imgattr"]." title='".$value."'>";
	}
	//function
	function showColumnText($c, $value, $pval){
		$name = $c["colname"];
		$html = "<input type=\"text\" name=\"".$name."List[".$pval."]\" id=\"$name\" value=\"$value\" style='width:100%'>\n";
		return $html;
	}
	//function
	function showColumnTextTable($c, $value, $pval){
		global $core;
		$name = $c["colname"];
		$clsClassTable = new $c["class"];
		$html =$clsClassTable->{$c["fnc"]}($value);
		return $html;
	}
	//function
	function showColumnCheckBox($c, $value, $pval){
		return $value;
	}
	//function
	function showColumnSelect($c, $value, $pval=""){
		$html = "<select name='".$c["colname"]."List[".$pval."]' style='font-size:10px'>";
		if (is_array($c["arrOptions"])){
			foreach ($c["arrOptions"] as $key => $val){
				$val1 = ($valueSameOption==1)? $val : $key;
				$selected = ($val1==$value)? "selected" : "";
				$html.= "<option value='$val1' $selected >$val</option>\n";
			}
		}
		$html.= "</select>";
		return $html;
	}
	//function
	function showColumnDate($c, $value, $pval){
		return date($c["date_format"], $value);
	}
	//function
	function showColumn($c, $value, $pval=""){
		$html = "";
		switch ($c["coltype"]){
			case "label"	: $html.= $this->showColumnLabel($c, $value); break;
			case "text"		: $html.= $this->showColumnText($c, $value, $pval); break;
			case "texttable": $html.= $this->showColumnTextTable($c, $value, $pval); break;
			case "checkbox"	: $html.= $this->showColumnCheckBox($c, $value, $pval); break;
			case "select"	: $html.= $this->showColumnSelect($c, $value, $pval); break;
			case "date"		: $html.= $this->showColumnDate($c, $value, $pval); break;
			case "email"	: $html.= $this->showColumnEmail($c, $value, $pval); break;
			case "url"		: $html.= $this->showColumnUrl($c, $value, $pval); break;
			case "image"	: $html.= $this->showColumnImage($c, $value, $pval); break;
			case "orderlabel"	: $html.= $this->showColumnOrderLabel($c, $value, $pval); break;
			case "action"	: $html.= $this->showColumnAction($c, $value, $pval); break;
		}
		return $html;
	}
	//function
	function setTableAttrib($_attrib=""){
		$this->tableAttrib = $_attrib;
	}
	//function
	function setHeaderClass($_headerClass, $_headerClass1){
		$this->headerClass = $_headerClass;
		$this->headerClass1 = $_headerClass1;
	}
	//function
	function showJS(){
		$html="
<script language='javascript'>
function CheckAll() {
	 var fmobj = document.".$this->formName.";
	 for (var i=0;i<fmobj.elements.length;i++) {
		 var e = fmobj.elements[i];
		 if ((e.name != 'allbox') && (e.type=='checkbox') && (!e.disabled)) {
			 e.checked = fmobj.allbox.checked;
		 }
	 }
	 return true;
}
function save(){
	document.".$this->formName.".btnSave.value= \"Save\";
	document.".$this->formName.".submit();
}
function confirmDelete() {
	var total = 0;
	var fmobj = document.".$this->formName.";
	for (var i=0;i<fmobj.elements.length;i++) {
	 var e = fmobj.elements[i];
	 if ((e.name != 'allbox') && (e.type=='checkbox') && (!e.disabled)) {
		 if (e.checked) total++;
	 }
	}
	if (total==0){ 
		alert('".$this->get_Lang("YouMustChooseAtLeastOne")."');
		return false;
	}
	if (confirm('".$this->get_Lang("Doyouwanttodelete[OK]:Yes[Cancel]:No?")."')) {
		document.".$this->formName.".action = \"".$this->baseURL."&act=delete\";
		document.".$this->formName.".btnDelete.value= \"Delete\";
		document.".$this->formName.".submit();
		return true;
	}
	return false;
}
function confirmEdit() {
	var total = 0;
	var fmobj = document.".$this->formName.";
	var pvalue = 0;
	for (var i=0;i<fmobj.elements.length;i++) {
	 var e = fmobj.elements[i];
	 if ((e.name != 'allbox') && (e.type=='checkbox') && (!e.disabled)) {
		 if (e.checked){ 
		 	total++;
			pvalue = e.value;
		 }
	 }
	}
	if (total==0 ){ 
		alert('".$this->get_Lang("YouMustChooseAtLeastOne")."');
		return false;
	}
	if (total>1 ){ 
		alert('".$this->get_Lang("YouMustChooseAtLeastOne")."!');
		return false;
	}
	window.location = \"".$this->baseURL."&act=edit&".$this->pkey."=\"+pvalue;
	return true;
}
</script>"."\n";
		return $html;
	}
	//function
	function showDataGrid($formName="", $startPage=0){
		global $mod,$core;
		if ($theForm=="") $theForm = $this->formName;
		$intStart = ($this->curPage-$startPage)*$this->rowsPerPage;
		$orderby = strtolower($this->orderby);		
		if (isset($_GET["sortby"])){
			$sortby = $_GET["sortby"];
			$stype = isset($_GET["stype"])? $_GET["stype"] : "ASC";
			$orderby = $this->orderby = strtolower($sortby." ".$stype);
		}
		if ($orderby==""){
			$orderby = $this->columns[0]["colname"];
		}
		//link to DataSource
		$clsDataSource = new DataSource();
		$clsDataSource->setDbTable($this->table, $this->cond);
		if ($this->pkey!=""){
			$clsDataSource->addField($this->pkey);
		}
		if (is_array($this->columns))
		foreach ($this->columns as $key => $val){
			$clsDataSource->addField($val["colname"]);
		}
		$this->totalRows = $clsDataSource->getTotalRows();
		$this->dataGrid = $clsDataSource->getDataGrid($this->orderby, $intStart, $this->rowsPerPage);		
		//output HTML
		$html = $this->showJS();
		$html.= "<input type='hidden' name='btnSave' id='btnSave' value=''>"."\n";		
		$html.= "<input type='hidden' name='btnDelete' id='btnDelete' value=''>"."\n";
		$html.= '<table '.$this->tableAttrib.'>'."\n";
		$html.= '<tr>'."\n";
		if (is_array($this->columns)){
			$checkboxname = 'checkList';
			$html.= '<td width="1%" class="gridheader '.$this->headerClass.'"><input id="check_all" type="checkbox" /></td>'."\n";
			foreach ($this->columns as $k => $v){
				$hclass = ($k<$this->totalCols-1)? $this->headerClass : $this->headerClass1;
				$html.= '<td '.$v['attrib'].' class="gridheader '.$hclass.'"';
				if($v["coltype"]=='action'){
					$html.=' style="width:10px;"';
				}
				$html.= '>';
				$html.= "<a href='".$this->baseURL."&page=".$this->curPage."&sortby=".$v["colname"].
						"' style='color:black' title='".$this->get_Lang("Sort_by")." \"".$v['coltitle']."\"'>".$this->getLang($v['coltitle']).
						"</a>";
				if (strpos($orderby, $v["colname"])!==false){
					$sortby = $v["colname"];
					$stype = (strpos($orderby, "desc")===false)? "DESC" : "ASC";
					$stype_text = ($stype=="ASC")? "Ascending" : "Descending";
					$ordertype = (strpos($orderby, "desc")===false)? "up" : "down";
					$html.= "<a href='".$this->baseURL."&page=".$this->curPage.
							"&sortby=$sortby&stype=$stype' title='".$stype_text."'>".
							" <img src='".URL_IMAGES."/icon/sort_{$ordertype}.gif' border='0'>".
							"</a>";
				}
				$html.= "</td>"."\n";
			}
		}
		$html.= '</tr>'."\n";
		$cnt = 0;
		if (is_array($this->dataGrid))
		foreach ($this->dataGrid as $key => $val){
			$rclass = ($key<$this->rowsPerPage-1 && $key<$this->totalRows-1)? $this->gridrowClass : $this->gridrowClass2;
			$html.= '<tr>'."\n";
			$html.= '<td width="1%" class="'.$rclass.'" style="text-align:center;">
				<input name="p_key[]" class="chkitem" type="checkbox" value="'.$val->{$this->pkey}.'" />
			</td>'."\n";
			$current_row_down = $this->totalRows - $this->curPage*$this->rowsPerPage - $key;
			foreach ($this->columns as $k => $v){
				if($cnt==0 && ($v['_action']=='move_up'||$v['_action']=='move_top')){
					$html.= '<td></td>';
					continue;
				}
				if($cnt+1==$this->totalRows && ($v['_action']=='move_down'||$v['_action']=='move_bottom')){
					$html.= '<td></td>';
					continue;
				}
				if ($v['coltype']!="hidden"){
					if ($k<$this->totalCols-1){
						$rclass = ($key<$this->rowsPerPage-1 && $key<$this->totalRows-1)? $this->gridrowClass : $this->gridrowClass2;	
					}else{
						$rclass = ($key<$this->rowsPerPage-1 && $key<$this->totalRows-1)? $this->gridrowClass1 : $this->gridrowClass3;	
					}				
					if ($k==0){			
						$href = $this->baseURL.'&act=edit&_base_url='.base64_encode($this->baseURL).'&'.$this->pkey.'='.$core->encryptID($val->{$this->pkey});
						$html.= ($v['coltype']!='orderlabel')? (($mod=='_product')? '<td '.$v['attrib'].' class="'.$rclass.'" ><a class="item_name" href="'.$href.'" target="_blank">'.$this->showColumn($v, $val->$v['colname']).'</a></td>'."\n" : '<td '.$v['attrib'].' class="'.$rclass.'" ><a href="'.$href.'" class="item_name">'.$this->showColumn($v, $val->$v['colname']).'</a></td>'."\n") : (($mod=='product')? '<td '.$v['attrib'].' class="'.$rclass.'" ><a target="_blank" class="item_name" href="'.$href.'">'.$this->showColumn($v, $current_row_down).'</a></td>'."\n" : '<td '.$v['attrib'].' class="'.$rclass.'" ><a href="'.$href.'" class="item_name">'.$this->showColumn($v, $current_row_down).'</a></td>'."\n");
					}else{					
						$column_value = ($v['coltype']!='orderlabel')? $this->showColumn($v, $val->$v['colname'], $val->{$this->pkey}) : $this->showColumn($v, $val->$v['colname'], $current_row_down);
						if ($column_value=="") $column_value = "&nbsp;";
						$html.= ($v['coltype']!='orderlabel')? '<td '.$v['attrib'].' class="'.$rclass.'" >'.$column_value.'</td>'."\n" : '<td '.$v['attrib'].' class="'.$rclass.'" >'.$current_row_down.'</td>'."\n";
					}
				}
			}
			$html.= '</tr>'."\n";	
			$cnt++;
		}			
		$html.= '</table>'."\n";
		return $html;
	}
	//function
	function saveData(){
		global $dbconn;
		foreach ($this->columns as $key => $val){
			$arrList = $_POST[$val["colname"]."List"];
			if (is_array($arrList))
			foreach ($arrList as $k => $v){
				$set = $val["colname"]."='".$v."'";
				$sql = "UPDATE ".$this->table." SET $set WHERE ".$this->pkey."='$k'";
				$dbconn->Execute($sql);
			}
		}
	}
}
?>