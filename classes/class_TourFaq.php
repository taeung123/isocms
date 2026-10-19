<?php
class TourFaq extends dbBasic{
	function __construct(){
		$this->pkey = "tour_faq_id";
		$this->tbl = DB_PREFIX."tour_faq";
	}
	function getMaxOrderNoByTour($tour_id){
		$res = $this->getAll("tour_id='$tour_id' order by order_no DESC limit 0,1");
		return intval($res[0]['order_no'])+1;
	}
	function checkExist($tour_id){
		$res = $this->getAll("tour_id='$tour_id' limit 0,1");
		return (!empty($res))?1:0;
	}
	function getContent($news_id){
		global $_LANG_ID;
		$one=$this->getOne($news_id,'content');
		if (!$one || !is_array($one)) {
        return '';
    }
    return html_entity_decode($one['content']);
	}
		function getTitle($pvalTable,$one=null){
		if(!isset($one['title'])){
			$one=$this->getOne($pvalTable,'title');	
		}		
		return $one['title'];
	}
}
?>