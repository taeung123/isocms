<?
class Package extends dbBasic
{
	function __construct()
	{
		$this->pkey = "package_id";
		$this->tbl = DB_PREFIX . "package";
	}
	function getImage($package_id = 0, $w = 0, $h = 0)
	{
		global $clsISO;
		$image = $this->getOneField('image', $package_id);
		if ($image != '' || $image != '0') {
			return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($image)}";
		}
		return  URL_IMAGES . '/noimage.png';
	}
	function getIcon($package_id = 0)
	{
		global $clsISO;
		$image = $this->getOneField('image', $package_id);
		if ($image != '' || $image != '0') {
			return $clsISO->parseImageURL($image);
		}
		return  URL_IMAGES . '/noimage.png';
	}
	function getUrlImage($package_id = 0)
	{
		global $clsISO;
		$image = $this->getOneField('image', $package_id);
		if ($image != '' || $image != '0') {
			return $clsISO->parseImageURL($image);
		}
		return  URL_IMAGES . '/noimage.png';
	}
	function getSlug($package_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($package_id, 'slug');
		return $one['slug'];
	}

	function getBySlug($slug = '')
	{
		$all = $this->getAll("is_trash=0 and slug='$slug' limit 0,1");
		return $all[0][$this->pkey];
	}

	function getTitle($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'title');
		return $one['title'];
	}
	function getUnit($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'unit');
		return $one['unit'];
	}
	function getPrice($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'price');
		return $one['price'];
	}
	function getDiscountText($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'discount_text');
		return $one['discount_text'];
	}
	function getIntro($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'intro');
		return html_entity_decode($one['intro']);
	}
	function getLink($pvalTable = 0)
	{
		global $extLang;
		return $extLang . '/package/' . $this->getSlug($pvalTable);
	}
	function getLinkViewDemo($package_id = 0)
	{
		global $_LANG_ID, $core;

		$ckeck_code = 'label=1BCAEoggI46AdIM1gEaPQBiAEBmAEquAETyAEa2AEB6AEBiAIBqAIDuAKsoIf-BcACAdICJDhjMjQ3YzYxLTJmYmYtNDYyOS1hOWViLTk0ZDY0ODk3MGE0OdgCBeACAQ;&sid=';
		$enip = $core->encryptID($_SERVER['REMOTE_ADDR']);
		return 'https://' . $this->getDomainPackage($package_id) . '/demo.html?' . $ckeck_code . $core->encryptID($package_id) . '&enip=' . $enip;
	}
	function getDomainPackage($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'domain_pointer');
		return $one['domain_pointer'];
	}
	function getListFeaturePackage($pvalTable = 0)
	{
		global $core, $_LANG_ID;

		$clsFeaturePackage = new FeaturePackage();

		$one = $this->getOne($pvalTable, 'list_feature_package_id');
		$list_feature_package_id = $one['list_feature_package_id'];
		$ListFeaturePackage = $clsFeaturePackage->getAll("is_trash=0 and is_online=1 and feature_package_id IN ($list_feature_package_id) order by order_no ASC", $clsFeaturePackage->pkey);

		return $ListFeaturePackage;
	}
	function getListFeaturePackageByModule($mod = '')
	{
		global $core, $_LANG_ID;

		$clsFeaturePackage = new FeaturePackage();

		$listFeaturePackage = $clsFeaturePackage->getAll("is_trash=0 and is_online=1 and mod_page='$mod' order by order_no ASC", $clsFeaturePackage->pkey . ",mod_page,act_page,type_page,type");

		return $listFeaturePackage ? $listFeaturePackage : [];
	}
	function doDelete($pvalTable = 0)
	{
		$clsISO = new ISO();
		#
		$this->deleteOne($pvalTable);
		return 1;
	}

	function getPackageClient($id = 0)
	{
		static $lstPackage = [
			1 => [
				"id" => 1,
				"title" => "Essentials",
				"key" => "essentials",
				"header_file" => "_header_essentials",
				"footer_file" => "_footer",
			],
			2 => [
				"id" => 2,
				"title" => "Professional",
				"key" => "professional",
				"header_file" => "_header",
				"footer_file" => "_footer",
			],
			3 => [
				"id" => 3,
				"title" => "Premium",
				"key" => "premium",
				"header_file" => "_header",
				"footer_file" => "_footer",
			],
			4 => [
				"id" => 4,
				"title" => "Contact us",
				"key" => "contact_us",
				"header_file" => "_header",
				"footer_file" => "_footer",
			],
		];

		// id = 0 → trả list
		if (!$id) {
			return array_values($lstPackage);
		}

		// id != 0 → trả phần tử hoặc []
		return $lstPackage[$id] ?? [];
	}
}
