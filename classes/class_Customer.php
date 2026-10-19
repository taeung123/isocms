<?php
class Customer extends dbBasic
{
	function __construct()
	{
		$this->pkey = "customer_id";
		$this->tbl = DB_PREFIX . "customer";
	}
	function getTitle($customer_id = 0)
	{
		$one = $this->getOne($customer_id, 'full_name');
		return $one['full_name'];
	}
	function getEmail($customer_id = 0)
	{
		$one = $this->getOne($customer_id, 'email');
		return $one['email'];
	}
	function getLinkDemo($customer_id = 0)
	{
		global $core;
		$package_id = $this->getOneField('package_id', $customer_id);
		if ($package_id == 1) {
			$domain = 'https://essentials.isocms.com';
		} elseif ($package_id == 2) {
			$domain = 'https://professional.isocms.com';
		} elseif ($package_id == 3) {
			$domain = 'https://premium.isocms.com';
		} elseif ($package_id == 4) {
			$domain = 'https://isocms.com';
		}
		return $domain . '/3fc0f600e81000ea520761167710f908/' . $core->encryptID($customer_id);
	}
	function getImageUrl($customer_id = 0)
	{
		global $clsISO;
		$one = $this->getOne($customer_id, 'image');
		$url_image = $oneTable['image'];
		return $clsISO->tripslashUrl($url_image);
	}
	function getIcon($customer_id = 0)
	{
		global $clsISO;
		$oneTable = $this->getOne($customer_id, "image");
		$url_image = $oneTable['image'];
		return $clsISO->tripslashUrl($url_image);
	}
	function getMetaDescription($pvalTable = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($pvalTable, 'intro');
		return html_entity_decode($one['intro']);
	}
	function getStripIntro($customer_id = 0)
	{
		$one = $this->getOne($customer_id, 'intro');
		return strip_tags(html_entity_decode($one['intro']));
	}
	function getIntro($customer_id = 0)
	{
		$one = $this->getOne($customer_id, 'intro');
		return html_entity_decode($one['intro']);
	}
	function checkExist($customer_id = 0, $type = '')
	{
		$res = $this->getAll("customer_id='$customer_id' and type='$type' limit 0,1");
		return (!empty($res)) ? 1 : 0;
	}
	function doDelete($customer_id = 0)
	{
		$this->deleteOne($customer_id);
		return 1;
	}
}
