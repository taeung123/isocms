<?php
class Voucher extends dbBasic
{
	function __construct()
	{
		global $_LANG_ID;
		$this->pkey = "voucher_id";
		$this->tbl = DB_PREFIX . "voucher";
	}
	function checkItemInCart($voucher_id = 0)
	{
		if (intval($voucher_id) == 0) return 0;
		$cart = vnSessionExists('cartSession')
			? vnSessionGetVar('cartSession') : array();
		if (empty($cart)) return 0;
		foreach ($cart as $k => $v) {
			if ($v[$this->pkey] == $voucher_id) {
				return 1;
				break;
			}
		}
		return 0;
	}
	function checkOnlineBySlug($voucher_id = 0, $slug = '')
	{
		$item = $this->getAll("is_trash=0 and is_online=1 and voucher_id='$voucher_id' and slug='$slug'");
		if (empty($item))
			return 0;
		return 1;
	}
	function getErrorMsg($tour_id = 0)
	{
		global $core;
		#
		$oneTour = $this->getOne($tour_id, 'image');
		$msg = '';
		if ($oneTour['image'] == '') {
			$msg .= $core->get_Lang('missimages');
		}
		if ($this->getTripCode($tour_id) == '') {
			$msg .= $core->get_Lang('misscodetour');
		}

		$clsTourItinerary = new TourItinerary();
		if ($clsTourItinerary->countItem("is_trash=0 and tour_id='$tour_id'") == 0) {
			$msg .= $core->get_Lang('missitinerary');
		}
		return $msg;
	}
	function getVoucherByParent($id_cate = 0)
	{
		$clsVoucherCate = new VoucherCat();
		$cate = $clsVoucherCate->getChildParent($id_cate);
		return $res = $this->getAll("is_trash=0 and is_online=1 and cat_id IN ( $cate ) ORDER BY RAND(), order_no DESC  limit 12", $this->pkey);
	}
	function updateRateAvg($voucher_id = 0)
	{
		global $core, $dbconn;
		$clsComment = new Comment();
		$total_comments = $clsComment->countItem("is_trash=0 and is_active='1' and type_id='_review' and for_id='{$voucher_id}'");
		$total_stars = $clsComment->sumItem("number_star", "is_trash=0 and is_active='1' and type_id='_review' and for_id='{$voucher_id}'");

		$score = 0;
		if ($total_comments > 0) {
			$score = round(($total_stars / $total_comments), 1);
		}
		$this->updateOne($voucher_id, "score_avg='{$score}'");
	}
	function getRateAvg($voucher_id = 0)
	{
		global $core, $dbconn;
		$clsComment = new Comment();
		$score = $this->getOneField('score_avg', $voucher_id);
		$total = $clsComment->countItem("is_trash=0 and is_active='1' and type_id='_review' and for_id='{$voucher_id}'");
		$ret[] = $total;
		$ret[] = $score;
		return $ret;
	}
	function getTotalReview($voucher_id = 0)
	{
		$ret = $this->getRateAvg($voucher_id);
		return $ret[0];
	}
	function getTitle($pvalTable = 0, $oDataTable = null)
	{
		if (!isset($oDataTable['title'])) {
			$oDataTable = $this->getOne($pvalTable, "title");
		}
		return $oDataTable['title'];
	}
	function getColor($pvalTable = 0)
	{
		$oDataTable = $this->getOne($pvalTable, "color");
		return $oDataTable['color'];
	}
	function getSupplierId($pvalTable = 0)
	{
		$oDataTable = $this->getOne($pvalTable, "supplier_id");
		return $oDataTable['supplier_id'];
	}
	function getListVoucherStatus() {
		$data = array('1' => 'Active', '0' => 'Inactive');
		return $data;
	}
	function getListLabelVoucherStatus()
	{
		$data = array(
			'0' => 'None', 
			'1' => 'Hot',
			'2' => 'New',
			'3' => 'Featured',
			'4' => 'Best Seller',
		);
		return $data;
	}
	function getLabel($pvalTable = 0)
	{
		$oDataTable = $this->getOne($pvalTable, "label");
		foreach ($this->getListLabelVoucherStatus() as $key => $val) {
			if ($oDataTable['label'] == $key) {
				$oDataTable['label'] = $val;
				break;
			}
		}
		return $oDataTable['label'];
	}
	function getIventory($pvalTable = 0)
	{
		$html = '';
		$data = array('1' => 'Còn hàng', '2' => 'Hết hàng');
		$one = $this->getOne($pvalTable);
		foreach ($data as $key => $val) {
			if ($key == $one['inventory']) {
				$selected = 'selected';
			} else {
				$$selected = '';
			}
			$html .= '	<option ' . $selected . ' value="' . $key . '">' . $val . '</option>';
		}
		return $html;
	}
	function getSlug($pvalTable = 0, $oDataTable = array())
	{
		if (!isset($oDataTable['slug'])) {
			$oDataTable = $this->getOne($pvalTable, "slug");
		}
		return $oDataTable['slug'];
	}
	function getIntro($pvalTable = 0, $one = null)
	{
		if (!isset($one['intro'])) {
			$one = $this->getOne($pvalTable, 'intro');
		}
		return html_entity_decode($one['intro']);
	}
	function getContent($pvalTable = 0, $one = null)
	{
		if (!isset($one['content'])) {
			$one = $this->getOne($pvalTable, 'content');
		}
		return html_entity_decode($one['content']);
	}
	function getInclusion($pvalTable = 0, $one = null)
	{
		if (!isset($one['inclusion'])) {
			$one = $this->getOne($pvalTable, 'inclusion');
		}
		return $one['inclusion'];
	}
	function getExclusion($pvalTable = 0, $one = null)
	{
		if (!isset($one['exclusion'])) {
			$one = $this->getOne($pvalTable, 'exclusion');
		}
		return $one['exclusion'];
	}
	function getNote($pvalTable = 0, $one = null)
	{
		if (!isset($one['note'])) {
			$one = $this->getOne($pvalTable, 'note');
		}
		return $one['note'];
	}
	function getTaxable($pvalTable = 0, $one = null)
	{
		if (!isset($one['taxable'])) {
			$one = $this->getOne($pvalTable, 'taxable');
		}
		return $one['taxable'];
	}
	function getContiOrder($pvalTable = 0, $one = null)
	{
		if (!isset($one['continue_order'])) {
			$one = $this->getOne($pvalTable, 'continue_order');
		}
		return $one['continue_order'];
	}
	function getLocation($pvalTable = 0, $one = null)
	{
		if (!isset($one['location'])) {
			$one = $this->getOne($pvalTable, 'location');
		}
		return html_entity_decode($one['location']);
	}
	function getCheckTime($pvalTable = 0, $_args = array())
	{
		$one = $this->getOne($pvalTable, 'checkinOut');
		return $one['checkinOut'];
	}
	function getTimeApplication($pvalTable = 0, $one = null)
	{
		if (!isset($one['timeApplication'])) {
			$one = $this->getOne($pvalTable, 'timeApplication');
		}
		return $one['timeApplication'];
	}
	function getOldPrice($pvalTable = 0, $one = null)
	{
		global $core, $dbconn, $extLang, $_LANG_ID, $_lang, $clsConfiguration, $clsISO;
		if (!isset($one['price'])) {
			$one = $this->getOne($pvalTable, 'price');
		}
		return $clsISO->formatPrice($one['price']) . $clsISO->getShortRate();
	}
	function getNewPrice($pvalTable = 0, $_args = array())
	{
		global $core, $dbconn, $extLang, $_LANG_ID, $_lang, $clsConfiguration, $clsISO;
		$one = $this->getOne($pvalTable, 'price_input');
		return $clsISO->formatPrice($one['price_input']) . $clsISO->getShortRate();
	}
	function getStripIntro($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable, 'intro,content');
		if (!empty($one['intro'])) {
			return strip_tags(html_entity_decode($one['intro']));
		} else {
			return strip_tags(html_entity_decode($one['content']));
		}
	}
	function getSupplier($supplier_id = 0, $fields = "*")
	{
		$clsSupplier = new VoucherSupply();
		$res = $clsSupplier->getOne($supplier_id, $fields);
		return $res;
	}
	function getBySlug($slug = '')
	{
		$res = $this->getAll("is_trash=0 and slug='{$slug}' limit 0,1", $this->pkey);
		return $res[0][$this->pkey];
	}
	function getCode($pvalTable = 0)
	{
		$oDataTable = $this->getOne($pvalTable, "code");
		return $oDataTable['code'];
	}
	function getStatus($pvalTable = 0, $oDataTable = array())
	{
		$oDataTable = $this->getOne($pvalTable, "is_inventory,continue_order");
		if ($oDataTable['is_inventory'] == 0) { // Khong quan ly kho
			return 0;
		} else {
			$clsStock = new Stock();
			$tmp = $clsStock->getAll("voucher_id='{$pvalTable}' limit 0,1", "quantily");
			$quantily = !empty($tmp) ? (int) $tmp[0]['quantily'] : 0;
			if ($quantily <= 0 && $oDataTable['continue_order'] == 0)
				return 1;
			return 0;
		}
	}
	function checkSelected($data = [], $val = '', $sect = '')
	{
		if (is_array($data) && !empty($data)) {
			foreach ($data as $item) {
				if ($item == $val) {
					return $sect;
				}
			}
		} else {
			if ($data == $val) {
				return $sect;
			}
		}
		return false;
	}
	function checkInCat($type_id = 0, $voucher_id = 0)
	{
		$where = "is_trash=0 and is_online='1' and voucher_id='{$voucher_id}'";
		return $this->countItem("{$where} and list_type_id like '%|{$type_id}|%'") ? 1 : 0;
	}
	function countVoucherByCategory($category_id = 0)
	{
		$where = "is_trash=0 and is_online='1' and cat_id = '{$category_id}'";
		return count($this->getAll($where));
	}	
	function getInfoPrice($voucher_id = 0)
	{
		global $core, $dbconn, $clsISO;
		$clsDiscount = new Discount();
	}
	function checkIsPromotion($voucher_id = 0, $return = false)
	{
		$clsDiscount = new Discount();
		$ok = 0;
		$timer = time();
		$field = "discount_id,more_information,list_voucher_id,list_category_id";
		$where = "is_trash=0 and status='1' and discount_rule='promotion'";
		$cond = "is_trash=0 and is_online='1' and voucher_id='{$voucher_id}'";
		$tmp = $clsDiscount->getAll("{$where} and start_date<='{$timer}' and if(is_due_date='1', due_date>'{$timer}', 1=1) order by reg_date DESC", $field);
		$discount_info = array();
		if (!empty($tmp)) {
			foreach ($tmp as $discount) {
				$more_information = !empty($discount['more_information'])
					? @json_decode($discount['more_information'], true)
					: array();

				$type = $more_information['type'];
				$discount_id = $discount['discount_id'];

				if ($type == 'all') {
					$ok = 1;
					$discount_info = $more_information;
					$discount_info['discount_id'] = $discount_id;
					break;
				} else {
					$field = "list_{$type}_id";
					$value_field = $discount[$field];
					$arr_value_field = !empty($value_field)
						? json_decode($value_field, true) : array();
					if (!empty($arr_value_field) && is_array($arr_value_field)) {
						if ($type == 'voucher') {
							if (in_array($voucher_id, $arr_value_field)) {
								$ok = 1;
								$discount_info = $more_information;
								$discount_info['discount_id'] = $discount_id;
								break;
							}
						} else {
							foreach ($arr_value_field as $cat_id) {
								if ($this->countItem("{$cond} and (cat_id='{$cat_id}' or list_cat_id like '%|{$cat_id}|%')") > 0) {
									$ok = 1;
									$discount_info = $more_information;
									$discount_info['discount_id'] = $discount_id;
									break;
								}
							}
						}
					}
				} // End If

			}
		}
		return !$return ? $ok : array('is_discount' => $ok, 'discount_info'	=> $discount_info);
	}
	function getPercent($voucher_id = 0)
	{
		global $clsISO, $core;
		$price = $this->getPriceOrigin($voucher_id);
		$price_old = $this->getOneField('price', $voucher_id);
		$price_minus = $price_old - $price;
		return round($price_minus / $price_old, 2) * 100;
	}
	function getPrice($voucher_id = 0, $oDataTable = array(), $type = 'List', $is_format = true)
	{
		global $clsISO, $core, $_LANG_ID;
		$clsProperty = new Property();
		if (!isset($oDataTable['price'])) {

			$oDataTable = $this->getOne($voucher_id, "price,unit");
		}
		$price = $clsISO->parsePriceDecimal($oDataTable['price']);
		$unit = $clsProperty->getTitle($oDataTable['unit'] ?? '');
		$price_promotion = 0;
		/** Check discount */
		//		$result = $this->checkIsPromotion($voucher_id, true);
		if (_IS_PROMOTION == 1) {
			$result = $clsISO->getPromotion($voucher_id, 'Voucher', time(), time(), $type_check = 'get_more_info');
			$discount_type = $result['discount_type'] ?? 0;
			$promotion = $result['discount_value'] ?? 0;
			$promotion = !empty($promotion) ? $promotion : 0;
			$promotion = str_replace('.', '', $promotion);



			if ($discount_type == 1) {
				$price -= $promotion;
				$price_promotion = $promotion;
			} else {
				$price -= $price * $promotion / 100;
				$price_promotion = $price * $promotion / 100;
			}
		}
		/*var_dump($result);die;
        if($result['is_discount']){
            $discount_type = $result['discount_info']['discount_type'];
            $discount_value = $result['discount_info']['discount_value'];
            if($discount_type=='amount'){
                $price -= $clsISO->parsePriceDecimal($discount_value);
            } else if($discount_type=='percentage') {
                $price -= ($price*$clsISO->parsePriceDecimal($discount_value))/100;
            }
        }*/
		$html = '';
		if ($price > 0) {
			if ($_LANG_ID == 'vn') {
				if ($is_format) {
					if ($type == 'Detail') {
						if (!empty($price_promotion)) {
							$html .= '<p class="text_from p_price"><del>' . $clsISO->formatPrice($price_promotion) . $clsISO->getShortCurrency() . '</del>' . $clsISO->formatPrice($price) . $clsISO->getShortCurrency() . '</p>';
						} else {
							$html .= '<p class="text_from p_price">' . $clsISO->formatPrice($price) . $clsISO->getShortCurrency() . '</p>';
						}
					} else {
						$html = '<p class="text_from p_text">' . $core->get_Lang('Only from') . '</p>';
						if (!empty($price_promotion)) {
							$html .= '<p class="text_from p_price"><del>' . $clsISO->formatPrice($price_promotion) . $clsISO->getShortCurrency() . '</del>' . $clsISO->formatPrice($price) . $clsISO->getShortCurrency() . '</p>';
						} else {
							$html .= '<p class="text_from p_price">' . $clsISO->formatPrice($price) . $clsISO->getShortCurrency() . '</p>';
						}
						if (!empty($unit)) {
							$html .= '<p class="text_unit p_text">/' . $unit . '</p>';
						}
					}

					return $html;
				} else {
					return $price;
				}
			} else {
				if ($is_format) {
					if ($type == 'Detail') {
						if (!empty($price_promotion)) {
							$html .= '<p class="text_from p_price"><del>' . $clsISO->getShortCurrency() . $clsISO->formatPrice($price_promotion) .  '</del>' . $clsISO->getShortCurrency() . $clsISO->formatPrice($price) .  '</p>';
						} else {
							$html .= '<p class="text_from p_price">' . $clsISO->getShortCurrency() . $clsISO->formatPrice($price) .  '</p>';
						}
					} else {
						$html = '<p class="text_from p_text">' . $core->get_Lang('Only from') . '</p>';
						if (!empty($price_promotion)) {
							$html .= '<p class="text_from p_price"><del>' . $clsISO->getShortCurrency() . $clsISO->formatPrice($price_promotion) .  '</del>' . $clsISO->getShortCurrency() . $clsISO->formatPrice($price) .  '</p>';
						} else {
							$html .= '<p class="text_from p_price">' . $clsISO->getShortCurrency() . $clsISO->formatPrice($price) .  '</p>';
						}
						if (!empty($unit)) {
							$html .= '<p class="text_unit p_text">/' . $unit . '</p>';
						}
					}

					return $html;
				} else {
					return $price;
				}
			}
		}
	}
	function getPriceOld($voucher_id = 0, $oDataTable = array(), $type = 'List', $is_format = true)
	{
		global $clsISO, $core;
		$clsProperty = new Property();
		if (!isset($oDataTable['price'])) {

			$oDataTable = $this->getOne($voucher_id, "price,unit");
		}
		$price = $clsISO->parsePriceDecimal($oDataTable['price']);
		$unit = $clsProperty->getTitle($oDataTable['unit']);
		$price_promotion = 0;
		/** Check discount */
		//		$result = $this->checkIsPromotion($voucher_id, true);
		if (_IS_PROMOTION == 1) {
			$result = $clsISO->getPromotion($voucher_id, 'Voucher', time(), time(), $type_check = 'get_more_info');
			$discount_type = $result['discount_type'];
			$promotion = $result['discount_value'];
			$promotion = !empty($promotion) ? $promotion : 0;
			$promotion = str_replace('.', '', $promotion);



			if ($discount_type == 1) {
				$price -= $promotion;
				$price_promotion = $promotion;
			} else {
				$price -= $price * $promotion / 100;
				$price_promotion = $price * $promotion / 100;
			}
		}
		/*var_dump($result);die;
		if($result['is_discount']){
			$discount_type = $result['discount_info']['discount_type'];
			$discount_value = $result['discount_info']['discount_value'];
			if($discount_type=='amount'){
				$price -= $clsISO->parsePriceDecimal($discount_value);
			} else if($discount_type=='percentage') {
				$price -= ($price*$clsISO->parsePriceDecimal($discount_value))/100;
			}
		}*/
		if ($price > 0) {
			if ($is_format) {
				if ($type == 'Detail') {
					if (!empty($price_promotion)) {
						$html .= '<p class="text_from p_price"><del>' . $clsISO->getShortCurrency() . $clsISO->formatPrice($price_promotion) . '</del>' . $clsISO->getShortCurrency() . $clsISO->formatPrice($price) . '</p>';
					} else {
						$html .= '<p class="text_from p_price">' . $clsISO->getShortCurrency() . $clsISO->formatPrice($price) . '</p>';
					}
				} else {
					$html = '<p class="text_from p_text">' . $core->get_Lang('From') . '</p>';
					if (!empty($price_promotion)) {
						$html .= '<p class="text_from p_price"><del>' . $clsISO->getShortCurrency() . $clsISO->formatPrice($price_promotion) . '</del>' . $clsISO->getShortCurrency() . $clsISO->formatPrice($price) . '</p>';
					} else {
						$html .= '<p class="text_from p_price">' . $clsISO->getShortCurrency() . $clsISO->formatPrice($price) . '</p>';
					}
					if (!empty($unit)) {
						$html .= '<p class="text_unit p_text">/' . $unit . '</p>';
					}
				}

				return $html;
			} else {
				return $price;
			}
		}
	}
	function getPriceSort($voucher_id = 0, $oDataTable = array())
	{
		global $clsISO, $core;
		if (!isset($oDataTable['price'])) {
			$oDataTable = $this->getOne($voucher_id, "price");
		}
		$price = $clsISO->parsePriceDecimal($oDataTable['price']);
		/** Check discount */
		$result = $this->checkIsPromotion($voucher_id, true);
		if ($result['is_discount']) {
			$discount_type = $result['discount_info']['discount_type'];
			$discount_value = $result['discount_info']['discount_value'];
			if ($discount_type == 'amount') {
				$price -= $clsISO->parsePriceDecimal($discount_value);
			} else if ($discount_type == 'percentage') {
				$price -= ($price * $clsISO->parsePriceDecimal($discount_value)) / 100;
			}
		}
		if ($price > 0) {
			return $price;
		}
	}
	function getPriceOrigin($voucher_id = 0)
	{
		global $clsISO, $core;
		$one = $this->getOne($voucher_id, "price");
		$price = $clsISO->parsePriceDecimal($one['price']);
		/** Check discount */
		$result = $this->checkIsPromotion($voucher_id, true);
		if ($result['is_discount']) {
			$discount_type = $result['discount_info']['discount_type'];
			$discount_value = $result['discount_info']['discount_value'];
			if ($discount_type == 'amount') {
				$price -= $clsISO->parsePriceDecimal($discount_value);
			} else if ($discount_type == 'percentage') {
				$price -= ($price * $clsISO->parsePriceDecimal($discount_value)) / 100;
			}
		}
		return $price;
	}
	function getHotDeals($voucher_id = 0)
	{
		global $clsISO;
		$one = $this->getOne($voucher_id, 'hot_deals');
		return $one['hot_deals'];
	}
	function getLink($pvalTable = 0, $oDataTable = array())
	{
		global $extLang, $_LANG_ID;
		return $extLang . '/v' . $pvalTable . '-' . $this->getSlug($pvalTable, $oDataTable) . '.html';
	}

	function getImage($pvalTable = 0, $w = 0, $h = 0, $oDataTable = array())
	{
		global $clsISO;
		if (!isset($oDataTable['image'])) {
			$oDataTable = $this->getOne($pvalTable, "image");
		}
		$image = URL_IMAGES . '/noimage.png';
		
		if (!empty($oDataTable['image'])) {
			$image = $oDataTable['image'];
			if ($w != 0 && $h != 0) {
				$path = "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($image)}";
				return str_replace('//', '/', $path);
			}
		}

		return $image;
	}
	function getImageUrl($pvalTable = 0)
	{
		$one = $this->getOne($pvalTable);
		return $one['image'];
	}
	function getListByCat($cat_id = 0, $limit = '')
	{
		global $core;
		$cond = "is_trash=0 and is_online=1";
		if (intval($cat_id) > 0) {
			$cond .= " and (cat_id = '$cat_id' or list_cat_id like '%|" . $cat_id . "|%')";
		}
		$cond .= " order by order_no desc";
		if (intval($limit) > 0) {
			$cond .= " limit 0," . $limit;
		}
		$lstItemDB = $this->getAll($cond, $this->pkey);
		$numItemDB = count($lstItemDB);
		$lstItem = array();
		if ($lstItemDB[0][$this->pkey] != '' && $numItemDB > 0) {
			for ($i = 0; $i < $numItemDB; $i++) {
				$lstItem[] = array(
					'title'	=> $this->getTitle($lstItemDB[$i][$this->pkey], $lstItemDB[$i]),
					'link'	=> $this->getLink($lstItemDB[$i][$this->pkey], $lstItemDB[$i]),
					'image'	=> $this->getImage($lstItemDB[$i][$this->pkey], 270, 220),
					'price'	=> $this->getPrice($lstItemDB[$i][$this->pkey], $lstItemDB[$i]),
					$this->pkey => $lstItemDB[$i][$this->pkey]
				);
			}
			unset($lstItemDB);
		}
		return $lstItem;
	}
	function getPricePromotion($voucher_id = 0, $one = null)
	{
		global $clsISO;
		if (!isset($one['price'])) {
			$one = $this->getOne($voucher_id, "price");
		}
		return $clsISO->formatPrice($one['price']) . ' ' . $clsISO->getShortCurrency();
	}
	function getPricePromotion2($voucher_id = 0)
	{
		global $clsISO;
		$one = $this->getOne($voucher_id, "price");
		return $clsISO->formatPrice($one['price']);
	}
	function getPricePromotionO($voucher_id = 0)
	{
		global $clsISO;
		$one = $this->getOne($voucher_id, "price");
		return $one['price'];
	}
	function getPriceVoucher($voucher_id = 0)
	{
		global $clsISO;
		$one = $this->getOne($voucher_id, "price");
		return $one['price'];
	}
	function getHTMLRateStar($voucher_id = 0, $is_full = false)
	{
		$tmp = $this->getRateAvg($voucher_id);
		$score = $tmp[1];
		$html = '<div class="voucher-rating__score">';
		if (strpos($score, '.') == false) {
			if ($score == 0) {
				$html .= '<span class="star_00"></span>';
				$html .= '<span class="star_00"></span>';
				$html .= '<span class="star_00"></span>';
				$html .= '<span class="star_00"></span>';
				$html .= '<span class="star_00"></span>';
			} else {
				for ($i = 0; $i < $score; $i++) {
					$html .= '<span class="star_10"></span>';
				}
				for ($i = 0; $i < (5 - $score); $i++) {
					$html .= '<span class="star_00"></span>';
				}
			}
		} else {
			$res = explode('.', $score);
			$n1 = $res[0];
			$n2 = $res[1];
			for ($i = 0; $i < $n1; $i++) {
				$html .= '<span class="star_10"></span>';
			}
			if ($n2 > 0) {
				$html .= '<span class="star_0' . $n2 . '"></span>';
			}
			for ($i = 0; $i < (5 - ($n1 + 1)); $i++) {
				$html .= '<span class="star_00"></span>';
			}
		}
		$html .= '</div>' . ($tmp[0] > 0 ? '<span class="totalVote pull-left">(' . $tmp[0] . ($is_full ? ' đánh giá' : '') . ')</span>' : '');
		return $html;
	}
	function getTotalBooking($voucher_id = 0)
	{
		return mt_rand(0, 100);
	}
	function getQuantityInStock($voucher_id = 0)
	{
		$clsStock = new Stock();
		if ((int) $voucher_id == 0) return 0;
		$tmp = $clsStock->getAll("voucher_id='{$voucher_id}'", "quantily");
		if (!empty($tmp))
			return $tmp[0]['quantily'];
		return 0;
	}
	function getTotalQuantityInStock($voucher_id = 0)
	{
		$clsStock = new Stock();
		if ((int) $voucher_id == 0) return 0;
		$tmp = $clsStock->getAll("voucher_id='{$voucher_id}'", "total_quantily");
		if (!empty($tmp))
			return $tmp[0]['total_quantily'];
		return 0;
	}
	function getTitleInCategory($voucher_id = 0)
	{
		$clsCategory = new Category();
		//	if((int) $voucher_id==0) return 0;
		$tmp = $this->getAll("voucher_id='{$voucher_id}'", "cat_id");
		$cat_id = $tmp[0]['cat_id'];
		//	print_r($cat_id);die();
		$tmp = $clsCategory->getTitle($cat_id);
		//	print_r($tmp);die();
		if (!empty($tmp))
			return $tmp;
		return $tmp;
	}
	function doDelete($pvalTable = 0)
	{
		$this->deleteOne($pvalTable);
		/** Delete Image */
		$clsDiscountItem = new DiscountItem();
		$clsDiscountItem->deleteByCond("item_id='$pvalTable' and clsTable ='Voucher'");

		$clsImage = new Image();
		$clsImage->deleteByCond("type='_PRODUCT' and table_id='{$pvalTable}'");
		/* Store */
		$clsVoucherStore = new VoucherStore();
		$clsVoucherStore->deleteByCond("voucher_id='{$pvalTable}'");
		/** Delete Stock */
		$clsStock = new Stock();
		$clsStock->deleteByCond("voucher_id='{$pvalTable}'");
		return 1;
	}

	function getLinkContact()
	{
		global $_LANG_ID, $extLang;
		return $extLang . '/voucher/enquiry.html';
	}
}
