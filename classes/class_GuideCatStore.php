<?php
class GuideCatStore extends dbBasic
{
	function __construct()
	{
		$this->pkey = "guidecat_store_id";
		$this->tbl = DB_PREFIX . "guidecat_store";
	}
	function getContent($guidecat_id = 0, $country_id = 0)
	{
		$res = $this->getAll("guidecat_id='$guidecat_id' and country_id='$country_id' LIMIT 0,1");
		if ($res[0][$this->pkey] != '') {
			return html_entity_decode($res[0]['content']);
		}
		return '';
	}
}
