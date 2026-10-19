<?php
/*======================================================================*\
|| #################################################################### ||
|| # The Class of the ISOCMS                                          # ||
|| # ISOCMS 6.0.0 By Luong Tien Dung (luongtiendung@gmail.com)        # ||
|| # ---------------------------------------------------------------- # ||
|| # All PHP code in this file is ©2007-2014 VietISO JSC.             # ||
|| # This file may not be redistributed in whole or significant part. # ||
|| # ---------------- ISOCMS IS NOT FREE SOFTWARE ----------------    # ||
|| # http://www.vietiso.com | http://www.vietiso.com/license.html     # ||
|| #################################################################### ||
\*======================================================================*/
class AdminButton extends dbBasic
{
	function __construct()
	{
		$this->pkey = "adminbutton_id";
		$this->tbl = DB_PREFIX . "adminbutton";
	}
	function getTitle($adminbutton_id)
	{
		global $_LANG_ID;
		$one = $this->getOne($adminbutton_id);
		return $one['title'];
	}
	function getMenu($_type)
	{
		return $this->getAll("_type='" . $_type . "' order by order_no asc");
	}
	function getURL($adminbutton_id)
	{
		global $_LANG_ID;
		$one = $this->getOne($adminbutton_id);
		if ($one['url_page'] != '')
			return ($one['url_page'] == 'javascript:void(0);') ? 'javascript:void(0);' : PCMS_URL . '/?' . $one['url_page'];
		return PCMS_URL . '/?mod=' . $one['mod_page'];
	}
	function getChild($adminbutton_id)
	{
		return $this->getAll("is_trash=0 and is_active=1 and parent_id>0 and parent_id='$adminbutton_id' order by order_no asc");
	}

	function canConfigureQuickAccess($adminbutton_id, $package_id)
	{
		global $core;

		$adminbutton_id = (int)$adminbutton_id;
		$button = $this->getOne($adminbutton_id);
		if (empty($button) || (int)$button['parent_id'] != 110 || $button['_type'] != '_HOME'
			|| (int)$button['is_trash'] != 0 || (int)$button['is_active'] != 1) {
			return false;
		}

		return $this->checkPackage($adminbutton_id, $package_id)
			&& $this->checkDEV($adminbutton_id)
			&& $this->checkConfiguration($adminbutton_id)
			&& $core->checkAccess($button['mod_page']);
	}

	function getQuickAccessItemsByUser($user_id, $is_selected = null)
	{
		$user_id = (int)$user_id;
		$cond = "parent_id=110 AND _type='_HOME' AND is_trash=0 AND is_active=1";
		if ($is_selected === true) {
			$cond .= " AND list_user_id_slash LIKE '%|" . $user_id . "|%'";
		} elseif ($is_selected === false) {
			$cond .= " AND (list_user_id_slash IS NULL OR list_user_id_slash NOT LIKE '%|" . $user_id . "|%')";
		}

		return $this->sortQuickAccessItems($this->getAll($cond . " ORDER BY order_no ASC"));
	}

	function getAllowedQuickAccessItems($user_id, $package_id, $is_selected = null)
	{
		$items = $this->getQuickAccessItemsByUser($user_id, $is_selected);
		$allowed_items = array();
		foreach ((array)$items as $item) {
			if ($this->canConfigureQuickAccess($item[$this->pkey], $package_id)) {
				$allowed_items[] = $item;
			}
		}
		return $allowed_items;
	}

	function getDefaultQuickAccessItems($user_id, $package_id)
	{
		$items = $this->getAllowedQuickAccessItems($user_id, $package_id, null);
		$default_items = array();
		foreach ($items as $item) {
			if (!empty($item['is_quick_access'])) {
				$default_items[] = $item;
			}
		}
		return $default_items;
	}

	function syncQuickAccessSelection($user_id, $selected_ids = array(), $package_id = 0)
	{
		global $clsISO;

		$user_id = (int)$user_id;
		if ($user_id < 1) return false;

		$selected_lookup = array();
		foreach ((array)$selected_ids as $adminbutton_id) {
			$adminbutton_id = (int)$adminbutton_id;
			if ($adminbutton_id > 0) $selected_lookup[$adminbutton_id] = true;
		}

		$list_buttons = $this->getAllowedQuickAccessItems($user_id, $package_id, null);
		$updated = 0;
		foreach ((array)$list_buttons as $button) {
			$adminbutton_id = (int)$button[$this->pkey];
			$list_user_ids = !empty($button['list_user_id_slash'])
				? $clsISO->getArrayByTextSlash($button['list_user_id_slash']) : array();
			$list_user_ids = array_map('intval', (array)$list_user_ids);
			$is_selected = isset($selected_lookup[$adminbutton_id]);
			$has_user = in_array($user_id, $list_user_ids);

			if ($is_selected && !$has_user) {
				$list_user_ids[] = $user_id;
			} elseif (!$is_selected && $has_user) {
				$list_user_ids = array_diff($list_user_ids, array($user_id));
			}

			if ($is_selected != $has_user) {
				$is_saved = $this->update($adminbutton_id, array(
					'list_user_id_slash' => $clsISO->makeSlashListFromArray(array_unique($list_user_ids))
				));
				if (!$is_saved) return array('success' => false, 'updated' => $updated);
				$updated++;
			}
		}

		return array('success' => true, 'updated' => $updated);
	}

	function isDefaultQuickAccess($button = array())
	{
		return !empty($button['is_quick_access']) ? 1 : 0;
	}

	function getDefaultQuickAccessRank($button = array())
	{
		$title = isset($button['title_page']) && $button['title_page'] != ''
			? $button['title_page'] : (isset($button['title']) ? $button['title'] : '');
		$title = strtolower(trim(strip_tags($title)));
		$mod_page = isset($button['mod_page']) ? strtolower(trim($button['mod_page'])) : '';
		$act_page = isset($button['act_page']) ? strtolower(trim($button['act_page'])) : '';
		$url_page = isset($button['url_page']) ? strtolower(html_entity_decode($button['url_page'])) : '';

		if ($mod_page == 'country' || in_array($title, array('destination', 'destinations'))) return 1;
		if (in_array($mod_page, array('tour', 'tour_exhautive')) || in_array($title, array('tour', 'tours'))) return 2;
		if ($mod_page == 'hotel' || in_array($title, array('hotel', 'hotels'))) return 3;
		if ($mod_page == 'cruise' || in_array($title, array('cruise', 'cruises'))) return 4;
		if ($mod_page == 'voucher' || in_array($title, array('voucher', 'vouchers'))) return 5;
		if (in_array($title, array('booking', 'bookings', 'order/booking'))
			|| ($mod_page == 'booking' && ($act_page == 'list_booking' || strpos($url_page, 'act=list_booking') !== false))) return 6;
		if (in_array($mod_page, array('customer', 'member')) || in_array($title, array('customer', 'customers'))) return 7;
		if (in_array($mod_page, array('report', 'reports')) || in_array($title, array('report', 'reports'))) return 8;
		if (in_array($title, array('setting', 'settings'))
			|| ($mod_page == 'setting' && $act_page != 'home' && strpos($url_page, 'act=home') === false)) return 9;

		return 0;
	}

	function sortQuickAccessItems($items = array())
	{
		usort($items, function ($item_a, $item_b) {
			$rank_a = $this->getDefaultQuickAccessRank($item_a);
			$rank_b = $this->getDefaultQuickAccessRank($item_b);
			$sort_a = $rank_a == 9 ? 100000 : ($rank_a > 0 ? $rank_a : 100 + (int)$item_a['order_no']);
			$sort_b = $rank_b == 9 ? 100000 : ($rank_b > 0 ? $rank_b : 100 + (int)$item_b['order_no']);

			if ($sort_a == $sort_b) return 0;
			return $sort_a < $sort_b ? -1 : 1;
		});

		return $items;
	}
	function checkDEV($adminbutton_id)
	{
		global $core;
		if ($core->_SESS->user_id == 1) {
			return 1;
		}
		if ($core->_SESS->user_id == 2) {
			return 1;
		}
		if ($this->getOneField('dev_access', $adminbutton_id)) {
			return (_DEV) ? 1 : 0;
		}
		return 1;
	}

	function checkPackage($adminbutton_id, $package_id)
	{
		global $core;

		$package_check_id = $this->getOneField('package_id', $adminbutton_id);
		$package_check_id = !empty($package_check_id) ? @unserialize($package_check_id) : array();
		if ($package_id == 4) {
			return 1;
		} else {
			if (empty($package_check_id) || !is_array($package_check_id)) {
				return 1;
			} else {
				if (in_array($package_id, $package_check_id)) {
					return 1;
				} else {
					return 0;
				}
			}
		}
	}

	function checkConfiguration($adminbutton_id)
	{
		$clsConfiguration = new Configuration();
		$CONFIGURATION_KEY = $this->getOneField('CONFIGURATION_KEY', $adminbutton_id);
		if (trim($CONFIGURATION_KEY) != '' && $CONFIGURATION_KEY != '0')
			return $clsConfiguration->getValue($CONFIGURATION_KEY);
		//return 1;
		else
			return 1;
	}
	function doDelete($adminbutton_id)
	{
		$lstItem = $this->getAll("parent_id='$adminbutton_id'");
		if (is_array($lstItem) && count($lstItem) > 0) {
			for ($i = 0; $i < count($lstItem); $i++) {
				$this->doDelete($lstItem[$i][$this->pkey]);
			}
			unset($lstItem);
		}
		$this->deleteOne($adminbutton_id);
		#
		return 1;
	}

	function menuSettingTours()
	{
		global $clsISO, $core, $package_id;
		$PCMS_URL = PCMS_URL;
		$lstMenu = [];

		if ($clsISO->getCheckActiveModulePackage($package_id, 'property', 'service', 'default')) {
			$lstMenu[] = [
				"title" => $core->get_Lang('Addon Services'),
				"link" => "{$PCMS_URL}/?&mod=property&act=service",
				"mod" => "property",
				"act" => "service",
				"is_pro" => false,
			];
		}

		if ($clsISO->getCheckActiveModulePackage($package_id, 'tour_exhautive', 'category', 'default')) {
			$lstMenu[] = [
				"title" => $core->get_Lang('Travel Styles'),
				"link" => "{$PCMS_URL}/?&mod=tour_exhautive&act=category",
				"mod" => "tour_exhautive",
				"act" => "category",
				"is_pro" => false,
			];
		}

		if ($clsISO->getCheckActiveModulePackage($package_id, 'tour_exhautive', 'category_country', 'default')) {
			$lstMenu[] = [
				"title" => $core->get_Lang('Travel Styles by Countries'),
				"link" => "{$PCMS_URL}/?&mod=tour_exhautive&act=category_country",
				"mod" => "tour_exhautive",
				"act" => "category_country",
				"is_pro" => false,
			];
		}

		if ($clsISO->getCheckActiveModulePackage($package_id, 'property', 'transport', 'default')) {
			$lstMenu[] = [
				"title" => $core->get_Lang('Transportations'),
				"link" => "{$PCMS_URL}/?mod=property&act=transport",
				"mod" => "property",
				"act" => "transport",
				"is_pro" => false,
			];
		}



		if ($clsISO->getCheckActiveModulePackage($package_id, 'tour_exhautive', 'property', 'default', 'MEAL')) {
			$lstMenu[] = [
				"title" => $core->get_Lang('Meals'),
				"link" => "{$PCMS_URL}/?mod=tour_exhautive&act=property&type=MEAL",
				"mod" => "tour_exhautive",
				"act" => "property",
				"type" => "MEAL",
				"is_pro" => false,
			];
		}

		if ($clsISO->getCheckActiveModulePackage($package_id, 'tour_exhautive', 'property', 'default', 'TOUROPTION')) {
			$lstMenu[] = [
				"title" => $core->get_Lang('Price class'),
				"link" => "{$PCMS_URL}/?mod=tour_exhautive&act=property&type=TOUROPTION",
				"mod" => "tour_exhautive",
				"act" => "property",
				"type" => "TOUROPTION",
				"is_pro" => false,
			];
		}

		if ($clsISO->getCheckActiveModulePackage($package_id, 'tour_exhautive', 'property', 'default', 'VISITORTYPE')) {
			$lstMenu[] = [
				"title" => $core->get_Lang('Adults - Children - Infants type'),
				"link" => "{$PCMS_URL}/?mod=tour_exhautive&act=property&type=VISITORTYPE",
				"mod" => "tour_exhautive",
				"act" => "property",
				"type" => "VISITORTYPE",
				"is_pro" => false,
			];
		}

		if ($clsISO->getCheckActiveModulePackage($package_id, 'tour_exhautive', 'property', 'default', 'TOURGUIDE')) {
			$lstMenu[] = [
				"title" => $core->get_Lang('Tour guides'),
				"link" => "{$PCMS_URL}/?mod=tour_exhautive&act=property&type=TOURGUIDE",
				"mod" => "tour_exhautive",
				"act" => "property",
				"type" => "TOURGUIDE",
				"is_pro" => false,
			];
		}

		if ($clsISO->getCheckActiveModulePackage($package_id, 'tour_exhautive', 'price_range', 'default')) {
			$lstMenu[] = [
				"title" => $core->get_Lang('Price range'),
				"link" => "{$PCMS_URL}/?mod=tour_exhautive&act=price_range",
				"mod" => "tour_exhautive",
				"act" => "price_range",
				"is_pro" => false,
			];
		}

		if ($clsISO->getCheckActiveModulePackage($package_id, 'tour_exhautive', 'property', 'default', 'SIZEGROUP')) {
			$lstMenu[] = [
				"title" => $core->get_Lang('Price for Groups'),
				"link" => "{$PCMS_URL}/?mod=tour_exhautive&act=property&type=SIZEGROUP",
				"mod" => "tour_exhautive",
				"act" => "property",
				"type" => "SIZEGROUP",
				"is_pro" => true,
			];
		}

		$lstMenu[] = [
			"title" => $core->get_Lang('AI Config'),
			"link" => "{$PCMS_URL}/?mod=aiconfig",
			"mod" => "aiconfig",
			"act" => "default",
			"is_pro" => false,
		];

		return $lstMenu;
	}
}
