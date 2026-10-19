<?php
class Car extends dbBasic
{
	function __construct()
	{
		$this->pkey = "car_id";
		$this->tbl = DB_PREFIX . "car";
	}
	function getTitle($pval = 0)
	{
		global $core, $_LANG_ID;
		$one = $this->getOne($pval, 'title');
		return $one['title'];
	}
	function getHtmlContent($car_id = 0)
	{
		global $core, $_LANG_ID;
		$one = $this->getOne($car_id, 'intro');

		$html = '<div class=\"modal-dialog modal-md mg0\">';
		$html .= '<div class=\"modal-header mg0\">';
		$html .= '<h3 class=\"modal-title\">' . $this->getTitle($car_id) . '</h3>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '<div class=\"modal-body\">';
		$html .= '<div class=\"row\">';
		$html .= '<div class=\"col-md-6\">';
		$html .= '<img class=\"mt30\" src=' . $this->getImage($car_id, 600, 350) . ' alt=' . $this->getTitle($car_id) . ' width=\"100%\" height=\"auto\" />';

		$html .= '</div>';
		$html .= '<div class=\"col-md-6\">';
		$html .= '<div class=\"entry_roomht_des\">';
		$html .= '<div class=\"htr_header_detail mt20\">';
		$html .= '<div class=\"box__center\">';
		$html .= '<h3 class=\"h3bold\">' . $core->get_Lang('Vehicle Information') . '</h3>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '<p><label>' . $core->get_Lang('Vehicle type') . ':</label> ' . $this->getVehicleType($car_id) . '</p>';
		$html .= '<p><label>' . $core->get_Lang('Seat number ') . ':</label> ' . $this->getNumberSeat($car_id) . '</p>';
		$html .= '<p><label>' . $core->get_Lang('Passengers') . ':</label> ' . $this->getPassenger($car_id) . '</p>';
		$html .= '<p><label>' . $core->get_Lang('Air-conditioner') . ':</label> ' . $this->getAirConditioner($car_id) . '</p>';
		$html .= '<p><label>' . $core->get_Lang('Seat belt') . ':</label> ' . $this->getSeatBelt($car_id) . '</p>';
		$html .= '<p><label>' . $core->get_Lang('Luggage') . ':</label> ' . $this->getLuggage($car_id) . '</p>';
		$html .= '<p><label>' . $core->get_Lang('Infant seat') . ':</label> ' . $this->getInfantSeat($car_id) . '</p>';
		$html .= '<p><label>' . $core->get_Lang('Toddle seat') . ':</label> ' . $this->getToddleSeat($car_id) . '</p>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '<div class=\"clearfix\"></div>';

		if ($this->getIntro($car_id) != '') {
			$html .= '<h4>' . $core->get_Lang('Vehicle Description') . '</h4>';
			$html .= '<div class=\"intro_tinymce\">' . $this->getIntro($car_id) . '</div>';
		}
		if ($this->getSeatBeltNote($car_id) != '') {
			$html .= '<div class=\"clearfix\"></div>';
			$html .= '<h4>' . $core->get_Lang('Seat Belt Note') . '</h4>';
			$html .= '<div class=\"intro_tinymce\">' . $this->getSeatBeltNote($car_id) . '</div>';
		}
		if ($this->getLuggageNote($car_id) != '') {
			$html .= '<div class=\"clearfix\"></div>';
			$html .= '<h4>' . $core->get_Lang('Luggage Note') . '</h4>';
			$html .= '<div class=\"intro_tinymce\">' . $this->getLuggageNote($car_id) . '</div>';
		}
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</div>';
		return $html;
	}
	function getMetaDescription($pvalTable = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($pvalTable, 'intro');
		return html_entity_decode($one['intro']);
	}
	function getIntro($car_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($car_id, 'intro');
		return html_entity_decode($one['intro']);
	}
	function getPriceOneKm($car_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($car_id, 'price_one_km');
		$price = $one['price_one_km'];
		return html_entity_decode($price);
	}
	function getSeatBeltNote($car_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($car_id, 'seat_belt_note');
		$seat_belt_note = $one['seat_belt_note'];
		return html_entity_decode($seat_belt_note);
	}
	function getLuggageNote($car_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($car_id, 'luggage_note');
		$luggage_note = $one['luggage_note'];
		return html_entity_decode($luggage_note);
	}
	function getContent($car_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($car_id, 'content');
		return $one['content'];
	}
	function getGroupID($car_id = 0)
	{
		global $_LANG_ID;
		$one = $this->getOne($car_id);
		return $one['group_id'];
	}
	function getVehicleType($car_id = 0)
	{
		global $_LANG_ID;
		$clsProperty = new Property();
		$vehicle_type_id = $this->getOneField('vehicle_type_id', $car_id);
		$vehicle_type = $clsProperty->getTitle($vehicle_type_id);
		return $vehicle_type;
	}
	function getNumberSeat($car_id = 0)
	{
		global $_LANG_ID;
		$number_seat = $this->getOneField('number_seat', $car_id);
		return $number_seat;
	}
	function getPassenger($car_id = 0)
	{
		global $_LANG_ID;
		$passenger = $this->getOneField('passenger', $car_id);
		return $passenger;
	}
	function getAirConditioner($car_id = 0)
	{
		global $_LANG_ID;
		$air_condition = $this->getOneField('air_condition', $car_id);
		return $air_condition;
	}
	function getSeatBelt($car_id = 0)
	{
		global $_LANG_ID;
		$belt_seat = $this->getOneField('belt_seat', $car_id);
		return $belt_seat;
	}
	function getInfantSeat($car_id = 0)
	{
		global $_LANG_ID;
		$infant_seat = $this->getOneField('infant_seat', $car_id);
		return $infant_seat;
	}
	function getToddleSeat($car_id = 0)
	{
		global $_LANG_ID;
		$toddle_seat = $this->getOneField('toddle_seat', $car_id);
		return $toddle_seat;
	}
	function getDoor($car_id = 0)
	{
		global $_LANG_ID;

		$door = $this->getOneField('door', $car_id);
		if (intval($door) > 0)
			return $door;
		return 'n/a';
	}
	function getLuggage($car_id = 0)
	{
		global $_LANG_ID;

		$luggage = $this->getOneField('luggage', $car_id);
		return $luggage;
	}
	function getSelectByCar($selected = '', $supplier_id = 0)
	{
		global $core, $_lang;
		#
		$sql = "is_trash=0";
		if (intval($supplier_id) > 0) {
			$sql .= " and list_supplier_id like '%|" . $supplier_id . "|%'";
		}
		$all = $this->getAll($sql);
		$html = '<option value="">Please select</option>';
		if (!empty($all)) {
			$i = 0;
			foreach ($all as $item) {
				$selected_index = ($selected == $item[$this->pkey]) ? 'selected="selected"' : '';
				$html .= '<option value="' . $item[$this->pkey] . '" ' . $selected_index . '>' . $this->getTitle($item[$this->pkey]) . '</option>';
				++$i;
			}
		}
		return $html;
	}
	function checkVehicleType($list_vehicle_type_id = 0, $vehicle_type_id = 0)
	{
		global $clsISO;

		if ($clsISO->checkInArray($list_vehicle_type_id, $vehicle_type_id))
			return 1;
		return 0;
	}
	function checkPropertyAvailable($car_id = 0, $property_id = 0)
	{
		global $clsISO;
		$listID = $this->getOneField('list_CarFacilities', $car_id);

		if ($clsISO->checkContainer($listID, $property_id))
			return 1;
		return 0;
	}
	function getImage($pvalTable = 0, $w = 0, $h = 0)
	{
		global $clsISO;
		#
		$oneTable = $this->getOne($pvalTable, "image");
		if ($oneTable['image'] != '') {
			$image = $oneTable['image'];
			return $clsISO->tripslashImage($image, $w, $h);
		}
		$noimage = URL_IMAGES . '/noimage.png';
		return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($noimage)}";
	}
	function getUrlImage($pvalTable = 0)
	{
		global $clsISO;
		$oneTable = $this->getOne($pvalTable, "image");
		$url_image = $oneTable['image'];
		return $clsISO->tripslashUrl($url_image);
	}
	function doDelete($pvalTable = 0)
	{
		$this->deleteOne($pvalTable);
		return 1;
	}
}
