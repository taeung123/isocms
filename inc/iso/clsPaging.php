<?

/**
 *  Created by   :
 *  @author		: Technical Group (technical@nhanviet.vn)
 *  @date		: 2009/1/18
 *  @version		: 2.1.1
 */
class Paging
{
	var $baseURL			=	"";
	var $formName 			=	"";
	var $curPage			=	0;
	var $hasPaging			=	true;
	var $totalRows			=	0;
	var $totalPage 			=	0;
	var $rowsPerPage		=	10;
	var $showPageNums		=	5;
	var $showPrevLink		=	true;
	var $showNextLink		=	true;
	var $showFirstLink 		=	true;
	var $showLastLink		=	true;
	var $showGotoBox		=	true;

	function __construct($_curPage = "", $_rowsPerPage = 10)
	{
		if (isset($_POST["gotoPage"]) && $_POST["gotoPage"] != "") {
			$this->curPage = $_POST["gotoPage"];
		} else {
			if ($_curPage == NULL) {
				$_curPage = isset($_GET["page"]) ? $_GET["page"] : 0;
			}
			$this->curPage = $_curPage;
		}
		$this->rowsPerPage = $_rowsPerPage;
	}

	function setBaseURL($_baseURL = "")
	{
		$this->baseURL = $_baseURL;
	}

	function setFormName($_formName = "theForm")
	{
		$this->formName = $_formName;
	}

	function setCurPage($_curPage = 0)
	{
		$this->curPage = $_curPage;
	}

	function setHasPaging($_hasPaging = true)
	{
		$this->hasPaging = $_hasPaging;
	}

	function setTotalRows($_totalRows = 0)
	{
		$this->totalRows = $_totalRows;
	}

	function setRowsPerPage($_rowsPerPage = 10)
	{
		$this->rowsPerPage = $_rowsPerPage;
	}

	function setShowPageNums($_showPageNums = 0)
	{
		$this->showPageNums = $_showPageNums;
	}

	function setShowPrevLink($_showPrevLink = true)
	{
		$this->showPrevLink = $_showPrevLink;
	}

	function setShowNextLink($_showNextLink = true)
	{
		$this->showNextLink = $_showNextLink;
	}

	function setShowFirstLink($_showFirstLink = true)
	{
		$this->showFirstLink = $_showFirstLink;
	}

	function setShowLastLink($_showLastLink = true)
	{
		$this->showLastLink = $_showLastLink;
	}

	function setShowGotoBox($_showGotoBox = true)
	{
		$this->showGotoBox = $_showGotoBox;
	}
	function get_Lang($key)
	{
		global $_LANG_ID, $dbconn;
		$clsLang = new _Lang();
		$key_upper = strtoupper($key);
		$oneLang = $dbconn->getAll("select * from _lang where upper(keyword)='$key_upper'");
		if ($oneLang[0]["value_1"] != "") {
			if ($oneLang[0]["is_html"] == "0") {
				if ($_LANG_ID == 'vn') {
					return strip_tags(html_entity_decode($oneLang[0]["value_1"]));
				} else if ($_LANG_ID == 'en') {
					return strip_tags(html_entity_decode($oneLang[0]["value_2"]));
				} else
					return 'unknow';
			} else {
				if ($_LANG_ID == 'vn') {
					return html_entity_decode($oneLang[0]["value_1"]);
				} else if ($_LANG_ID == 'en') {
					return html_entity_decode($oneLang[0]["value_2"]);
				} else
					return 'unknow';
			}
		} else
			return html_entity_decode($key);
	}
	function getLang($key)
	{
		global $_LANG;
		if (strpos($key, " ") !== false) {
			$arr = str_word_count($key, 1);
			foreach ($arr as $k => $v) {
				$val = trim($v, "'?,");
				$trans = (isset($_LANG[$val])) ? $_LANG[$val] : $val;
				$key = str_replace($val, $trans, $key);
			}
			return $key;
		} else {
			$val = trim($key, "'?,");
			$trans = (isset($_LANG[$val])) ? $_LANG[$val] : $val;
			$key = str_replace($val, $trans, $key);
			return $key;
		}
		return $key;
	}
	function showPaging($theForm = "")
	{
		if ($theForm == "") $theForm = $this->formName;
		$this->totalPage = ceil($this->totalRows / $this->rowsPerPage);
		//echo $this->curPage;
		$gotoPageOptions = "";
		for ($i = 0; $i < $this->totalPage; $i++) {
			$selected = ($this->curPage == $i) ? "selected" : "";
			$gotoPageOptions .= "<option value='$i' $selected >" . ($i + 1) . "</option>";
		}
		$butNext = ($this->curPage < $this->totalPage - 1) ? "<a href='$this->baseURL&page=" . ($this->curPage + 1) . "' title='" . ($this->curPage + 2) . "'>" . $this->get_Lang("Next") . "</a>" : $this->get_Lang("Next");
		$butPrev = ($this->curPage > 0) ? "<a href='$this->baseURL&page=" . ($this->curPage - 1) . "' title='" . ($this->curPage) . "'>" . $this->get_Lang("Prev") . "</a>" : $this->get_Lang("Prev");
		$listPage = "";
		$first = intval($this->curPage / $this->showPageNums) * $this->showPageNums;
		for ($i = 0; $i < $this->showPageNums; $i++)
			if ($first + $i < $this->totalPage) {
				$p = $first + $i;
				$t = ($this->curPage == $p) ? "<b>" . ($p + 1) . "</b>" : ($p + 1);
				$listPage .= ($this->curPage != $p) ? "<a href='" . $this->baseURL . "&page=$p' title='" . ($p + 1) . "'>$t</a>&nbsp" : "$t&nbsp;";
			}
		if ($listPage == "") $listPage = "0";
		$butNNext = ($first + $this->showPageNums < $this->totalPage - 1) ? "<a href='$this->baseURL&page=" . ($first + $this->showPageNums) . "'  title='" . ($first + $this->showPageNums + 1) . "'>...</a>" : "";
		$butPPrev = ($first - $this->showPageNums >= 0) ? "<a href='$this->baseURL&page=" . ($first - $this->showPageNums) . "' title='" . ($first - $this->showPageNums + 1) . "'>...</a>" : "";


		if ($this->className != "")
			$html = "<table class='" . $this->className . "'>";
		else
			$html = "<table cellpadding='0' cellspacing='0' width='100%' border='0' style='font-size:12px'>";
		$html .= "<tr>";
		$html .=	"<td width='30%' style=\"text-align:left\" nowrap>" . $this->get_Lang("Total") . ": " . $this->totalRows . " " . $this->get_Lang("row") . ", " . $this->totalPage . " " . $this->get_Lang("page") . "</td>";
		$html .= "<td width='40%' style=\"text-align:center\" nowrap>  $butPrev | $butPPrev $listPage $butNNext | $butNext </td>";
		if ($this->showGotoBox) {
			$html .= "<td width='30%' style=\"text-align:right\" nowrap>" . $this->get_Lang("GotoPage") . ":";
			$html .= "<select name='gotoPage' style='font-size:11px' onChange='document.$theForm.submit()'>$gotoPageOptions</select></td>";
		} else {
			$html .= "<td width='30%' style=\"text-align:right\" nowrap></td>";
		}
		$html .= "</tr>";
		$html .= "</table>";
		return $html;
	}
}
