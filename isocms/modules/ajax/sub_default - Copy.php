<?php
function default_ajSubmitSubscribe() {
	global $core,$mod,$act, $clsConfiguration;
	$clsSubscribe = new Subscribe();
	#
	$email = $_POST['subcribe_email'];
	$name = $_POST['subcribe_name'];
	if(isset($_POST['Signmeup']) && $_POST['Signmeup']=='Signmeup'){
		if($clsSubscribe->checkValidEmail($email) == '0') {
			$max_id = $clsSubscribe->getMaxId();
			$field = "subscribe_id,fullname,email,user_ip,reg_date,receive_newsletter";
			$value = "'".$max_id."','".$name."','".$email."','".$_SERVER['REMOTE_ADDR']."','".time()."','1'";
			#
			if($clsSubscribe->insertOne($field,$value)) {
				$clsSubscribe->sendMail($max_id);
				echo '_SUCCESS|||'.html_entity_decode($clsConfiguration->getValue('SiteMsg_SubscribeSuccess')); die();
			}
		} else {
			echo '_EXIST|||'.$core->get_Lang('Email address already exists !'); die();
		}
	}
}
function default_ajMakeSelectboxCountry(){
	global $core,$core;
	$clsCountry = new Country();
	#
	$all=$clsCountry->getAll("is_trash=0 order by order_no asc");
	$html='<select class="selectbox" name="destination">
		   	   <option value="">'.$core->get_Lang('Select country').'</option>';
	if(!empty($all)){
		foreach($all as $item){
			$html.='<option value="'.$item[$clsCountry->pkey].'">'.$clsCountry->getTitle($item[$clsCountry->pkey]).'</option>';
		}
	}
	$html .= '</select>';
	echo $html; die();
}
function default_ajaxMakeSelectboxDeparture(){
	global $core,$mod,$act,$core;
	#
	$clsCountry = new Country();
	$clsCity = new City();
	$clsTour = new Tour();
	#
	$country_id = $_POST['country_id'];
	$modue = $_POST['mod'];
	$departure_id = isset($_POST['departure_id'])?$_POST['departure_id']:'';
	#
	$html = '';
	if($modue!='home'){
		$html .='<option value="">-- '.$core->get_Lang('Select').' --</option>';
	}		
	$lstCity = $clsCity->getAll("is_trash=0 and is_start_point=1 and country_id='".$country_id."' order by order_no asc",$clsCity->pkey);
	if(!empty($lstCity)){
		foreach($lstCity as $item){
			if($clsTour->countTourGolobal($country_id, $item[$clsCity->pkey])>0){
				$selected = ($departure_id==$item[$clsCity->pkey])?'selected="selected"':'';
				$html.='<option value="'.$item[$clsCity->pkey].'" '.$selected.'>'.$clsCity->getTitle($item[$clsCity->pkey]).'</option>';
			}
		}
	}
	if($html==''){
		$html .= '<option value="0">No Starting Ports</option>';
	}
	echo $html; die();
}

function default_ajLoadMoreTourSearch() {
	global $core, $mod, $act, $assign_list, $core,$extLang,$_lang,$clsISO,$cat_id,$profile_id,$country_id,$cat_ID,$duration_ID,$price_range_ID;
	global $dbconn;
	
	$now_day =isset($_POST['now_day']) ? $_POST['now_day'] : '';	
	$country_id = isset($_POST['country_id']) ? $_POST['country_id'] : '';
	$cat_ID = isset($_POST['cat_ID']) ? $_POST['cat_ID'] : '';
	$duration_ID = isset($_POST['duration_id']) ? $_POST['duration_id'] : '';
	$price_range_ID =isset($_POST['price_range_id']) ? $_POST['price_range_id'] : '';		
	$sortby = isset($_POST['sortby']) ? $_POST['sortby'] : '';

	$clsTourCategory  = new TourCategory(); 
	$clsTour = new Tour();
	$clsReviews= new Reviews(); 
	$cond ="is_trash=0 and is_online=1";
	if($country_id>0){
		$cond.= " and tour_id IN (SELECT tour_id FROM ".DB_PREFIX."tour_destination WHERE is_trash=0 and country_id IN ($country_id))";
	}
	if(!empty($cat_ID)){
		$cat_ID = explode(',',$cat_ID);
		$cond.=" and (";
		for($i=0;$i<count($cat_ID);$i++) {
			if($i==0 && count($cat_ID)==1){
				$cond.=" (cat_id='".$cat_ID[$i]."' or list_cat_id like '%|".$cat_ID[$i]."|%')";
			}elseif(count($cat_ID)>1 && $i< (count($cat_ID)-1)){
					$cond.="(cat_id='".$cat_ID[$i]."' or list_cat_id like '%|".$cat_ID[$i]."|%') or ";
			}else{
				$cond.="(cat_id='".$cat_ID[$i]."' or list_cat_id like '%|".$cat_ID[$i]."|%')";
			}
		}
		$cond.=")";
	}
	/*print_r($cond);die();*/
	if(!empty($price_range_ID)) {
		$clsPriceRange=new PriceRange();
		$SQLMINRATE = "SELECT MIN(min_rate) FROM ".DB_PREFIX."price_range WHERE price_range_id IN ($price_range_ID) and type='TOUR'";
		
		$SQLMAXRATE = "SELECT MAX(max_rate) FROM ".DB_PREFIX."price_range WHERE price_range_id IN ($price_range_ID) and max_rate<>'0' and type='TOUR'";
		
		$SQLMINMAXRATE = "SELECT MIN(max_rate) FROM ".DB_PREFIX."price_range WHERE price_range_id IN ($price_range_ID) and type='TOUR'";
		
		#
        
		$min_rate= $dbconn->GetOne($SQLMINRATE);
		$minmax_rate= $dbconn->GetOne($SQLMINMAXRATE);
		$assign_list['minmax_rate']=$minmax_rate;
		if($minmax_rate=='0'){
			$max_rate=0;
		}
		else{
		$max_rate= $dbconn->GetOne($SQLMAXRATE);
		}


		$assign_list['min_rate']=$min_rate;
		$assign_list['max_rate']=$max_rate;

		if($min_rate>0 && $max_rate>0){
		$cond.=" and trip_price > '$min_rate' and trip_price < '$max_rate'";
		}elseif($min_rate==0 && $max_rate>0){
		$cond.=" and trip_price < '$max_rate'";
		}elseif($min_rate>0 && $max_rate==0){
		$cond.=" and trip_price >= '$min_rate'";
		}elseif($min_rate==0 && $max_rate==0){
		$cond.=" and trip_price >= '$min_rate'";
		}
		else{
		$cond.=" and trip_price > '$min_rate'";
		}
		
	}
	
	if(!empty($duration_ID)){
		$cond.= " and number_day IN($duration_ID)";
		$assign_list["duration_ID"] = $duration_ID;
	}
	$order_by =" ";

	if ($sortby == 'rating-asc') {
		$order_by =" order by order_no asc";

	} elseif ($sortby == 'rating-desc') {
		$order_by =" order by order_no desc";
	} elseif ($sortby =='offer-asc') {
		$order_by =" order by hot_deals desc";
	} elseif ($sortby =='offer-desc') {
		$order_by =" order by hot_deals asc";
	} elseif ($sortby =='new-desc') {
		$order_by =" order by reg_date desc";
	} else {
		$order_by =" order by reg_date asc";
	}
	
	$numberPage = isset( $_POST['page'] )? $_POST['page']:1;
	$itemOnPage = 12;
	$limit = " limit ".(($numberPage-1)*$itemOnPage).",".($itemOnPage);
	#
	$listTour = $clsTour->getAll($cond.$order_by.$limit, $clsTour->pkey);
	$html = '';
	if(!empty($listTour)){
		for ($i = 0; $i < count($listTour); $i++) {
			$title = $clsTour->getTitle($listTour[$i]['tour_id']);
			$link = $clsTour->getLink($listTour[$i]['tour_id']);
			$image =  $clsTour->getImage($listTour[$i]['tour_id'],355,236);
			$duration=$clsTour->getLTripDuration($listTour[$i]['tour_id']);
	
			$html .= '<li class="box grid-item case02" '.($i>11?'style="display: none;"':'').'>';
			$html .= '<div class="image">';
			$html .= '<div class="tour-collection-actions_2516"></div>';
			$html .= '<span style="cursor:pointer" class="'.($profile_id!=''?'addWishlist':'exitLogin').' heart-o inline-block text-center btnwl" title="'.$core->get_Lang('Saved to wishlist').'" clsTable="Tour" data="'.$listTour[$i]['tour_id'].'" id="addwishlistTour'.$listTour[$i]['tour_id'].'" profile_id="'.$profile_id.'">'.$clsTour->getOneField('wishlist_num',$listTour[$i]['tour_id']).'</span>';
			$html .= '<div class="bottom">'.$duration.'</div>';
			$html .= '<a href="'.$link.'" target="_blank"><img alt="'.$title.'" src="'.$image.'" width="100%" data-normal="'.$image.'"></a>';
			$html .= '</div>';
			$html .= '<div class="desc row_no_marging_padding">';
			  $html .= '<div class="name"><a href="'.$link.'" target="_blank">'.$title.'</a></div>';
			  $html .= '<div style="width:100%; display:table">';
				$html .= '<div class="left"><label class="rate-1">'.$clsReviews->getStarNew($listTour[$i]['tour_id']).'</label>';
				$html .= '<span class="review_text">'.$clsReviews->getToTalReview($listTour[$i]['tour_id'],'tour').' '.$core->get_Lang('reviews').'</span>';
				$html .= '</div>';
				 if($clsTour->getTripPrice($listTour[$i]['tour_id'],$now_day)>0 && $clsTour->getLTripPriceOld($listTour[$i]['tour_id']) >0){
                      $html .= '<div class="price">
                          <div>
                              <div class="price_left">
                                <span class="original_price">'.$clsISO->getRate().' '.$clsTour->getLTripPriceOld($listTour[$i]['tour_id']).'</span></span>
                              </div>
                              <div class="discounted_price">
                                    <span>'.$clsISO->getRate().' '.$clsTour->getTripPrice($listTour[$i]['tour_id'],$now_day).'</span>
                              </div>
                          </div>
                      </div>';
				 }elseif(($clsTour->getTripPrice($listTour[$i]['tour_id'],$now_day)==0 || $clsTour->getTripPrice($listTour[$i]['tour_id'],$now_day)=='') && $clsTour->getLTripPriceOld($listTour[$i]['tour_id'])>0){
                      $html .= '<div class="price">
                        <div>
                          <div class="price_left no_discount">
                            <span class="discounted_price">'.$clsISO->getRate().' '.$clsTour->getLTripPriceOld($listTour[$i]['tour_id']).'</span>
                          </div>
                        </div>
                      </div>';
				}elseif($clsTour->getTripPrice($listTour[$i]['tour_id'],$now_day)>0 && ($clsTour->getLTripPriceOld($listTour[$i]['tour_id'])== 0 || $clsTour->getLTripPriceOld($listTour[$i]['tour_id'])=='')){
                      $html .= '<div class="price">
                        <div>
                          <div class="price_left no_discount">
                            <span class="discounted_price">'.$clsISO->getRate().' '.$clsTour->getTripPrice($listTour[$i]['tour_id'],$now_day).'</span>
                          </div>
                        </div>
                      </div>';
				}else{}
			$html .= '</div></div>
			</li>';                     
		}
	}
	echo $html;
	die();
}

function default_sortTour() {
	global $core, $mod, $act, $assign_list, $core,$extLang,$_lang,$clsISO,$cat_id,$profile_id;
	global $dbconn;
	
	$price_range_ID =isset($_POST['price_range_ID']) ? $_POST['price_range_ID'] : '';		
	$now_day =isset($_POST['now_day']) ? $_POST['now_day'] : '';	
	$city_id = isset($_POST['city_id']) ? $_POST['city_id'] : '';
	$country_id = isset($_POST['country_id']) ? $_POST['country_id'] : '';
	$cat_id = isset($_POST['cat_id']) ? $_POST['cat_id'] : '';
	$cat_ID = isset($_POST['cat_ID']) ? $_POST['cat_ID'] : '';
	$duration_ID = isset($_POST['duration_ID']) ? $_POST['duration_ID'] : '';
	$country_id = $clsISO->makeSlashListFromArrayComma($country_id);
	$cat_ID = $clsISO->makeSlashListFromArrayComma($cat_ID);
	$price_range_ID = $clsISO->makeSlashListFromArrayComma($price_range_ID);

	$duration_ID = $clsISO->makeSlashListFromArrayComma($duration_ID);

	$sortby = isset($_POST['sortby']) ? $_POST['sortby'] : '';


	

	$clsTourCategory  = new TourCategory(); 
	$clsTour = new Tour();
	$clsReviews= new TourReview(); 
	$cond ="is_trash=0 and is_online=1";
	if($country_id>0){
		$cond.= " and tour_id IN (SELECT tour_id FROM ".DB_PREFIX."tour_destination WHERE is_trash=0 and country_id IN ($country_id))";
	}
	if(!empty($cat_ID)){
		$cat_ID = explode(',',$cat_ID);
		$cond.=" and (";
		for($i=0;$i<count($cat_ID);$i++) {
			if($i==0 && count($cat_ID)==1){
				$cond.=" (cat_id='".$cat_ID[$i]."' or list_cat_id like '%|".$cat_ID[$i]."|%')";
			}elseif(count($cat_ID)>1 && $i< (count($cat_ID)-1)){
					$cond.="(cat_id='".$cat_ID[$i]."' or list_cat_id like '%|".$cat_ID[$i]."|%') or ";
			}else{
				$cond.="(cat_id='".$cat_ID[$i]."' or list_cat_id like '%|".$cat_ID[$i]."|%')";
			}
		}
		$assign_list["cat_ID"] = $cat_ID;
		$cond.=")";
		
	}
	/*print_r($cond);die();*/
	if(!empty($price_range_ID)) {
		$clsPriceRange=new PriceRange();
		$SQLMINRATE = "SELECT MIN(min_rate) FROM ".DB_PREFIX."price_range WHERE price_range_id IN ($price_range_ID) and type='TOUR'";
		
		$SQLMAXRATE = "SELECT MAX(max_rate) FROM ".DB_PREFIX."price_range WHERE price_range_id IN ($price_range_ID) and max_rate<>'0' and type='TOUR'";
		
		$SQLMINMAXRATE = "SELECT MIN(max_rate) FROM ".DB_PREFIX."price_range WHERE price_range_id IN ($price_range_ID) and type='TOUR'";
		
		#
        
		$min_rate= $dbconn->GetOne($SQLMINRATE);
		$minmax_rate= $dbconn->GetOne($SQLMINMAXRATE);
		$assign_list['minmax_rate']=$minmax_rate;
		if($minmax_rate=='0'){
			$max_rate=0;
		}
		else{
		$max_rate= $dbconn->GetOne($SQLMAXRATE);
		}


		$assign_list['min_rate']=$min_rate;
		$assign_list['max_rate']=$max_rate;

		if($min_rate>0 && $max_rate>0){
		$cond.=" and trip_price > '$min_rate' and trip_price < '$max_rate'";
		}elseif($min_rate==0 && $max_rate>0){
		$cond.=" and trip_price < '$max_rate'";
		}elseif($min_rate>0 && $max_rate==0){
		$cond.=" and trip_price >= '$min_rate'";
		}elseif($min_rate==0 && $max_rate==0){
		$cond.=" and trip_price >= '$min_rate'";
		}
		else{
		$cond.=" and trip_price > '$min_rate'";
		}
		
	}
	
	if(!empty($duration_ID)){
		$cond.= " and number_day IN($duration_ID)";
		$assign_list["duration_ID"] = $duration_ID;
	}
	//$limit = ' limit 0,9';
	$limit = '';
	$order_by =" ";

	if ($sortby == 'rating-asc') {
		$order_by =" order by order_no asc";

	} elseif ($sortby == 'rating-desc') {
		$order_by =" order by order_no desc";
	} elseif ($sortby =='offer-asc') {
		$order_by =" order by hot_deals desc";
	} elseif ($sortby =='offer-desc') {
		$order_by =" order by hot_deals asc";
	} elseif ($sortby =='new-desc') {
		$order_by =" order by reg_date desc";
	} else {
		$order_by =" order by reg_date asc";
	}
	#
	$listTour = $clsTour->getAll($cond.$order_by.$limit, $clsTour->pkey);
	$html = '';
	if(!empty($listTour)){
		for ($i = 0; $i < count($listTour); $i++) {
			$title = $clsTour->getTitle($listTour[$i]['tour_id']);
			$link = $clsTour->getLink($listTour[$i]['tour_id']);
			$image =  $clsTour->getImage($listTour[$i]['tour_id'],355,236);
			$duration=$clsTour->getLTripDuration($listTour[$i]['tour_id']);
	
			$html .= '<li class="box grid-item case02" '.($i>11?'style="display: none;"':'').'>';
			$html .= '<div class="image">';
			$html .= '<div class="tour-collection-actions_2516"></div>';
			$html .= '<span style="cursor:pointer" class="'.($profile_id!=''?'addWishlist':'exitLogin').' heart-o inline-block text-center btnwl" title="'.$core->get_Lang('Saved to wishlist').'" clsTable="Tour" data="'.$listTour[$i]['tour_id'].'" id="addwishlistTour'.$listTour[$i]['tour_id'].'" profile_id="'.$profile_id.'">'.$clsTour->getOneField('wishlist_num',$listTour[$i]['tour_id']).'</span>';
			$html .= '<div class="bottom">'.$duration.'</div>';
			$html .= '<a href="'.$link.'" target="_blank"><img alt="'.$title.'" src="'.$image.'" width="100%" data-normal="'.$image.'"></a>';
			$html .= '</div>';
			$html .= '<div class="desc row_no_marging_padding">';
			  $html .= '<div class="name"><a href="'.$link.'" target="_blank">'.$title.'</a></div>';
			  $html .= '<div style="width:100%; display:table">';
				$html .= '<div class="left"><label class="rate-1">'.$clsReviews->getStarNew($listTour[$i]['tour_id']).'</label>';
				$html .= '<span class="review_text">'.$clsReviews->getToTalReview($listTour[$i]['tour_id']).' reviews</span>';
				$html .= '</div>';
				 if($clsTour->getTripPrice($listTour[$i]['tour_id'],$now_day)>0 && $clsTour->getLTripPriceOld($listTour[$i]['tour_id']) >0){
                      $html .= '<div class="price">
                          <div>
                              <div class="price_left">
                                <span class="original_price">'.$clsISO->getRate().' '.$clsTour->getLTripPriceOld($listTour[$i]['tour_id']).'</span></span>
                              </div>
                              <div class="discounted_price">
                                    <span>'.$clsISO->getRate().' '.$clsTour->getTripPrice($listTour[$i]['tour_id'],$now_day).'</span>
                              </div>
                          </div>
                      </div>';
				 }elseif(($clsTour->getTripPrice($listTour[$i]['tour_id'],$now_day)==0 || $clsTour->getTripPrice($listTour[$i]['tour_id'],$now_day)=='') && $clsTour->getLTripPriceOld($listTour[$i]['tour_id'])>0){
                      $html .= '<div class="price">
                        <div>
                          <div class="price_left no_discount">
                            <span class="discounted_price">'.$clsISO->getRate().' '.$clsTour->getLTripPriceOld($listTour[$i]['tour_id']).'</span>
                          </div>
                        </div>
                      </div>';
				}elseif($clsTour->getTripPrice($listTour[$i]['tour_id'],$now_day)>0 && ($clsTour->getLTripPriceOld($listTour[$i]['tour_id'])== 0 || $clsTour->getLTripPriceOld($listTour[$i]['tour_id'])=='')){
                      $html .= '<div class="price">
                        <div>
                          <div class="price_left no_discount">
                            <span class="discounted_price">'.$clsISO->getRate().' '.$clsTour->getTripPrice($listTour[$i]['tour_id'],$now_day).'</span>
                          </div>
                        </div>
                      </div>';
				}else{}
			$html .= '</div></div>
			</li>';                     
		}
	}
	else $html = '<div class="alert alert-warning">
					  <strong>No Data.
				  </div>';
	echo $html.'$$$'.count($listTour);
	die();
}

function default_sortCruise() {
	global $core, $mod, $act, $assign_list, $core,$extLang,$_lang,$clsISO,$cat_id;
	global $dbconn;

	
	$cat_id = isset($_POST['cat_id']) ? $_POST['cat_id'] : '';
	$sortby = isset($_POST['sortby']) ? $_POST['sortby'] : '';


	

	$clsCruiseCat  = new CruiseCat(); $assign_list["clsCruiseCat"] = $clsCruiseCat;
	$clsCruise = new Cruise(); $assign_list["clsCruise"] = $clsCruise;
	$clsReviewsCruise= new ReviewsCruise(); $assign_list["clsReviewsCruise"] = $clsReviewsCruise;
	$cond ="is_trash=0 and is_online=1 and (cat_id='$cat_id' or list_cat_id like '%|$cat_id|%')";
	
	//$limit = ' limit 0,9';
	$limit = '';
	$order_by =" ";

	if ($sortby == 'popular') {
		$order_by =" order by order_no asc";

	} elseif ($sortby == 'rating') {
		$order_by =" order by order_no desc";
	} elseif ($sortby =='price-asc') {
		$order_by =" order by price desc";
	}else {
		$order_by =" order by reg_date asc";
	}
	#
	$listCruise = $clsCruise->getAll($cond.$order_by.$limit, $clsTour->pkey);
	$html = '';
	if(!empty($listCruise)){
		for ($i = 0; $i < count($listCruise); $i++) {
			$title = $clsCruise->getTitle($listCruise[$i]['cruise_id']);
			$link = $clsCruise->getLink($listCruise[$i]['cruise_id']);
			$image =  $clsCruise->getImage($listCruise[$i]['cruise_id'],653,433);
			$duration=$clsCruise->getLTripDuration($listCruise[$i]['cruise_id']);
			$html .= '<div class="box col-lg-4 col-sm-6 col-xs-6" '.($i>8?'style="display: none;"':'').'>';
			$html .= '<div class="item"><a href="'.$link.'" data="'.$listCruise[$i]['cruise_id'].'" class="cl-img clickviewedCruise"><img src="'.$image.'" alt="'.$title.'">';
			if($clsCruise->checkCruiseStore($listCruise[$i]['cruise_id'],'BEST')){
				$html .= '<span class="special text-bold z_12 text-center">'.$core->get_Lang('Best Seller').'</span> ';
			}
			$html .= '<span class="heart-o inline-block text-center btnwl" onclick="return false" id="w69" style="display:none">166</span> </a>
			  <div class="cl-caption">
				<div class="has-feedback">
				  <h5 class="z_18 f_hn text-bold c2a"><a data="'.$listCruise[$i]['cruise_id'].'" class="clickviewedCruise" href="{$link}" title="{$title}">{$title}</a></h5>
				  <div class="box-review">
					<label class="rate-1">'.$clsCruise->getStarNew($listCruise[$i]['cruise_id']).'</label>
					<label class="review"> <span class="text-bold inline-block text-center n-rate">'.$clsReviewsCruise->getRateScoreCruise($listCruise[$i]['cruise_id']).'</span> <strong class="inline-block text-uppercase">'.$clsReviewsCruise->getTextRate($listCruise[$i]['cruise_id']).'</strong> <a class="n-review inline-block"><b>'.$clsReviews->getToTalReview($listCruise[$i]['cruise_id']).'</b> reviews</a> </label>
				  </div>
				  <div class="price text-right">'.$core->get_Lang('From').' '.$clsISO->getRate().'
					<label class="block f_hn z_24"><sup>$</sup><b>'.$clsCruise->getLTripPrice($listCruise[$i]['cruise_id'],$now_month,2).'</b></label>
				  </div>
				</div>
				<address>
				<i class="fa fa-map-marker c2a"></i> <strong>'.$core->get_Lang('Address').':</strong> '.$clsCruise->getCityAround($listCruise[$i]['cruise_id']).'
				</address>';
				if($clsCruise->getDiscountText($listCruise[$i]['cruise_id'])!=''){
				$html .= '<div id="owl-home-1">
				  <div class="tag"><i class="fa fa-tags"></i> '.$clsCruise->getDiscountText($listCruise[$i]['cruise_id']).'</div>
				</div>';
				}
			 $html .= ' </div>
			</div>';
			$html .= '</div>';                     
		}
	}
	else $html = '<div class="alert alert-warning">
					  <strong>No Data.
				  </div>';
	echo $html.'$$$'.count($listCruise);
	die();
}




function default_ajaxMakeSelectboxCity(){
	global $core,$mod,$act,$core;
	#
	$clsCountry = new Country();
	$clsCity = new City();
	$clsTour = new Tour();
	$clsLang = new _Lang();
	#
	$country_id = $_POST['country_id'];
	$departure_id = $_POST['departure_id'];
	$city_id = isset($_POST['city_id'])?$_POST['city_id']:'';
	#
	$html = '<option value="">-- '.$clsLang->get_Lang('Destination').' --</option>';
	$lstCity = $clsCity->getAll("is_trash=0 and country_id='".$country_id."' order by order_no asc",$clsCity->pkey);
	if(!empty($lstCity)){
		foreach($lstCity as $item){
			if($clsTour->countTourGolobal($country_id, $departure_id, $item[$clsCity->pkey])>0){
				$selected = ($city_id==$item[$clsCity->pkey])?'selected="selected"':'';
				$html.='<option value="'.$item[$clsCity->pkey].'" '.$selected.'>'.$clsCity->getTitle($item[$clsCity->pkey]).'</option>';
			}
		}
	}
	echo $html; die();
}
function default_ajMakeSelectboxCategory(){
	global $core,$mod,$act,$core;
	$clsCategory = new Category();
	$clsCountry = new Country();
	$clsTour = new Tour();
	#
	$country_id =1;
	$departure_id = $_POST['departure_id'];
	$city_id = $_POST['city_id'];
	$cat_id = isset($_POST['cat_id'])?$_POST['cat_id']:'';
	#
	$html = '<option value="">-- '.$core->get_Lang('Category').' --</option>';
	$lstCategoryDB = $clsCategory->getAll("is_trash=0 and _type='TOUR' order by order_no asc", $clsCategory->pkey);
	$lstCategory = array();
	#
	if(!empty($lstCategoryDB)){
		foreach($lstCategoryDB as $k=>$v){
			if($clsTour->countTourGolobal($country_id=1, $departure_id, $city_id, $v[$clsCategory->pkey]) > 0){
				$selected = ($cat_id==$v[$clsCategory->pkey])?'selected="selected"':'';
				$html.='<option value="'.$v[$clsCategory->pkey].'" '.$selected.'>'.$clsCategory->getTitle($v[$clsCategory->pkey]).'</option>';
			}
		}
	}
	echo $html; die();
}
function default_ajMakeSelectboxDuration(){
	global $core,$mod,$core;
	$clsTour = new Tour();
	$clsCountry = new Country();
	#
	$country_id = intval($_POST['country_id']);
	$departure_id = intval($_POST['departure_id']);
	$city_id = intval($_POST['city_id']);
	$cat_id = intval($_POST['cat_id']);
	$duration = isset($_POST['duration'])?$_POST['duration']:'';
	#
	$html = '<option value="">-- '.$core->get_Lang('Duration').' --</option>';
	#
	$cond = "is_trash=0 and is_online=1";
	if($country_id > 0) $cond .= " and tour_id IN (SELECT tour_id FROM ".DB_PREFIX."tour_destination WHERE country_id='$country_id')";
	if($city_id > 0) $cond .= " and tour_id IN (SELECT tour_id FROM ".DB_PREFIX."tour_destination WHERE city_id='$city_id')";
	if($departure_id > 0) $cond .= " and depart_point_id='$departure_id'";
	if($cat_id > 0) $cond .= " and tour_id IN (SELECT tour_id FROM ".DB_PREFIX."tour_domain_store WHERE domain_id='"._DOMAIN_ID."' and cat_id='$cat_id')";
	#
	$tmp='';
	$lstTour=$clsTour->getAll($cond." order by number_day ASC limit 0,1000");
	if(!empty($lstTour)){
		for ($i=0; $i < count($lstTour); $i++) {
			$tmp .= $clsTour->getSelectTripDuration($lstTour[$i]['tour_id']).'|';
		}
	}
	$tmp = array_unique(explode('|', $tmp));
	if(!empty($tmp)){
		foreach($tmp as $key=>$val){
			if($val!='' && $val!='n/a'){
				$selected = ($duration==$clsTour->convertDuration($val))?'selected="selected"':'';
				$html.='<option value="'.$clsTour->convertDuration($val).'" '.$selected.'>'.$val.'</option>';
			}
		}
	}
	echo $html; die();
}
function default_ajaxLoadTourGlobal(){
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $core_ID,$title_page,$description_page,$keyword_page,$extLang;
	global $clsISO, $core;
	# Country
	$clsCategory = new Category(); $assign_list['clsCategory']=$clsCategory;
	$clsCountry=new Country(); $assign_list['clsCountry']=$clsCountry;
	$clsTour = new Tour(); $assign_list["clsTour"] = $clsTour;
	$clsCity = new City(); $assign_list['clsCity']=$clsCity;
	#
	$mod = $_POST['mod'];
	$act = $_POST['act'];
	$recordPerPage = isset($_POST['recordPerPage']) ? intval($_POST['recordPerPage']):10;
	$currentPage = isset($_POST['page'])?intval($_POST['page']):1;
	#
	$cond = "";
	$cond .= "is_trash=0 and is_online=1";
	$order_by = ' ORDER BY order_no DESC';
	
	if($mod=='destination' && $act=='country'){
		$country_id = $_POST['country_id'];
		$show = isset($_POST['show'])?$_POST['show']:'';
		$cat_id = 0;
		if($show=='sortcat'){
			$cat_id = $_POST['cat_id'];
		}
		$duration = '';
		if($show=='sortcatduration'){
			$cat_id = $_POST['cat_id'];
			$duration = $_POST['duration'];
		}
		if($show=='sortduration'){
			$duration = $_POST['duration'];
		}
		#
		$cond = "1=1";
		if(intval($country_id)==8){
			$cond.=" and is_mutiple=1";
		}else{
			$cond.=" and is_mutiple=0 and tour_id IN (SELECT tour_id FROM default_tour_destination WHERE country_id='".$country_id."')";
		}
		#
		$cond .=" and tour_id IN (SELECT tour_id FROM default_tour_domain_store WHERE val='1'".(intval($cat_id)>0?" and list_cat_id like '%|".$cat_id."|%'":'')." and domain_id = '"._DOMAIN_ID."')";
		if(trim($duration) != ''){
			$tmp = explode('-',$duration);
			$number_day = intval($tmp[0]);
			$number_night = intval($tmp[1]);
			$cond.= " and number_day='$number_day' and number_night='$number_night'";
		}
	}
	else if($mod=='destination' && $act=='city'){
		$country_id = $_POST['country_id'];
		$city_id = $_POST['city_id'];
		$show = isset($_POST['show'])?$_POST['show']:'';
		$cat_id = 0;
		if($show=='sortcat'){
			$cat_id = $_POST['cat_id'];
		}
		$duration = '';
		if($show=='sortcatduration'){
			$cat_id = $_POST['cat_id'];
			$duration = $_POST['duration'];
		}
		if($show=='sortduration'){
			$duration = $_POST['duration'];
		}
		#
		$cond .=" and tour_id IN (SELECT tour_id FROM default_tour_destination WHERE country_id='".$country_id."' and city_id='$city_id') and tour_id IN (SELECT tour_id FROM default_tour_domain_store WHERE val='1'".(intval($cat_id)>0?" and list_cat_id like '%|".$cat_id."|%'":'')." and domain_id = '"._DOMAIN_ID."')";
		if(trim($duration) != ''){
			$tmp = explode('-',$duration);
			$number_day = intval($tmp[0]);
			$number_night = intval($tmp[1]);
			$cond.= " and number_day='$number_day' and number_night='$number_night'";
		}
	}
	else if($mod=='tour' && $act=='cat'){
		$show = isset($_POST['show'])?$_POST['show']:'';
		$cat_id = $_POST['cat_id'];
		#
		$cond .=" and tour_id IN (SELECT tour_id FROM default_tour_domain_store WHERE val='1' and list_cat_id like '%|$cat_id|%' and domain_id='"._DOMAIN_ID."')";
		#
		$duration = '';
		if($show=='duration'){
			$duration = $_POST['duration'];
			$tmp = explode('-',$duration);
			$number_day = $tmp[0];
			$number_night = $tmp[1];
			$cond.= " and number_day='$number_day' and number_night='$number_night'";
		}
		if($show=='top'){
			$order_by = " order by reg_date DESC";
		}
	}
	else if($mod=='tour' && $act=='country'){
		$show = isset($_POST['show'])?$_POST['show']:'';
		$cat_id = $_POST['cat_id'];
		$country_id = $_POST['country_id'];
		#
		$cond .=" and tour_id IN (SELECT tour_id FROM default_tour_destination WHERE country_id='".$country_id."') and tour_id IN (SELECT tour_id FROM default_tour_domain_store WHERE val='1' and list_cat_id like '%|$cat_id|%' and domain_id='"._DOMAIN_ID."')";
		#
		$duration = '';
		if($show=='duration'){
			$duration = $_POST['duration'];
			$tmp = explode('-',$duration);
			$number_day = $tmp[0];
			$number_night = $tmp[1];
			$cond.= " and number_day='$number_day' and number_night='$number_night'";
		}
		if($show=='top'){
			$order_by = " order by reg_date DESC";
		}
	}
	else if($mod=='tour' && $act=='promotion'){
		$cond .= " and is_selling=1 and tour_id IN (SELECT tour_id FROM ".DB_PREFIX."tour_domain_store WHERE val='1' and domain_id='"._DOMAIN_ID."')";
		$order_by = " order by order_selling desc";
	}
	#
	$offset = ($currentPage-1)*$recordPerPage;
	$limit = " limit $offset,$recordPerPage";
	//echo $cond.$order_by.$limit; die();
	
	$Html = '';
	$lstTour = $clsTour->getAll($cond.$order_by.$limit, $clsTour->pkey);
	if(is_array($lstTour) && count($lstTour)>0){
		for($i=0; $i < count($lstTour); $i++){
			$tour_id = $lstTour[$i][$clsTour->pkey];
			$Html .='
			<li>
				<a class="photo" href="'.$clsTour->getLink($tour_id).'" title="'.$clsTour->getTitle($tour_id).'"> 
					<img src="'.$clsTour->getImage($tour_id,234,138).'" alt="'.$clsTour->getTitle($tour_id).'" width="234" height="138"/>
					<span class="dayandnight">
						<i class="time-icon"></i> '.$clsTour->getTripDuration($tour_id).'
					</span>
					'.(!$clsTour->checkIsOffer($tour_id) && $lstTour[$i]['hot_deals']?'<i class="hotDeals">-'.$lstTour[$i]['hot_deals'].'%</i>' : '').'
				</a>';
			$Html .= '<div class="body">';
			$Html .= '<h3 class="title"><a class="photo" href="'.$clsTour->getLink($tour_id).'" title="'.$clsTour->getTitle($tour_id).'">'.$clsTour->getTitle($tour_id).'</a></h3>';
			if($clsTour->getCityAround($tour_id) != ''){
				$Html .= '<div class="location"><img align="absmiddle" src="'.URL_IMAGES.'/point.png" alt="" /> '.$clsTour->getCityAround($tour_id).'</div>';
			}
			$Html .= '<div class="introCrx">
				'.$clsISO->myTruncate($clsTour->getIntro($tour_id),150).'
			</div>';
			$Html .= '<p class="price mgt10"><b>'.$core->get_Lang('Price').':</b> <span class="pc-unit">'.$clsTour->getTripPrice($tour_id).'</span>'.($clsTour->getTripPriceOld($tour_id) > 0 ? '<span class="pc-unit-old">'.$clsISO->getRate().' '.$clsTour->getTripPriceOld($tour_id).'</span>' : '' ).'
			</p>';		
			$Html .= '
				</div>
			</li>';
		}
	}else{
		$Html = 'NOT_RESULT';
	}
	sleep(1);
	echo $Html; die();
}
function default_loadTotalTripHandle(){
	global $core,$mod,$act,$core;
	$clsCategory = new Category();
	$clsCountry = new Country();
	$clsTour = new Tour();
	#
	$country_id = intval($_POST['country_id']);
	$city_id = intval($_POST['city_id']);
	$cat_id = intval($_POST['cat_id']);
	$duration = $_POST['duration'];
	#
	$cond = "is_trash=0 and is_online=1";
	if($country_id > 0) $cond .= " and tour_id IN (SELECT tour_id FROM ".DB_PREFIX."tour_destination WHERE country_id='$country_id')";
	if($city_id > 0) $cond .= " and tour_id IN (SELECT tour_id FROM ".DB_PREFIX."tour_destination WHERE city_id='$city_id')";
	if($cat_id > 0) $cond .= " and tour_id IN (SELECT tour_id FROM ".DB_PREFIX."tour_domain_store WHERE domain_id='"._DOMAIN_ID."' and cat_id='$cat_id')";
	if($duration != '' && $duration != '0'){
		$tmp = explode('-',$duration);
		$number_day = $tmp[0];
		$number_night = $tmp[1];
		$cond .= " and number_day='$number_day' and number_night='$number_night'";
	}
	#
	$total = $clsTour->countItem($cond);
	echo $total; die();
}
function default_ajLoadSelectDestination(){
	global $core,$mod,$act,$_LANG_ID;
	#
	$clsCountry = new Country();
	$clsCity = new City();
	$clsTour = new Tour();
	#
	$departure_point_ID = intval($_POST['departure_point_ID']);
	#
	$html = '<option value="0">'.$core->get_Lang('Select All').'</option>';
	if($departure_point_ID != 0){
        $lstItems = $clsCity->getAll("is_trash=0 and is_online=1 order by order_no asc",$clsCity->pkey);
        if(is_array($lstItems) && count($lstItems) > 0){
            for($i=0; $i<count($lstItems); $i++){
                if($clsTour->countTourDeparturePoint($departure_point_ID,$lstItems[$i][$clsCity->pkey],0)>0){
                    $html .= '<option value="'.$lstItems[$i][$clsCity->pkey].'" '.($destination_ID==$lstItems[$i][$clsCity->pkey]).'>'.$clsCity->getTitle($lstItems[$i][$clsCity->pkey]).'</option>';
                }
            }
            unset($lstItems);
        }
    }

	#
	echo $html; die();
}
function default_ajLoadSelectDestinationDeparture(){
	global $core,$mod,$act,$_LANG_ID,$clsISO;
	#
	$clsCountry = new Country();
	$clsCity = new City();
	$clsTour = new Tour();
	$clsTourStartDate = new TourStartDate();
	$clsTourDestination = new TourDestination();
	#
	
	$departure_point_ID = intval($_POST['departure_point_ID']);
	$tour_group_id = intval($_POST['tour_group_id']);

	#
	$lstTourStartDate = $clsTourStartDate->getAll("is_trash=0 and is_online=1 and start_date >= '".time()."' and tour_id IN(SELECT tour_id FROM ".DB_PREFIX."tour_store) and tour_id IN(SELECT tour_id FROM ".DB_PREFIX."tour where is_trash=0 and is_online=1 and tour_group_id='$tour_group_id') order by start_date asc",$clsTourStartDate->pkey.',tour_id');
	$assign_list['lstTourStartDate']= $lstTourStartDate;
//	print_r($departure_point_id);die();
	$cond = "is_trash=0 and is_online=1";
	$list_tour_id = array();
	foreach($lstTourStartDate as $k =>$v){
		$tour_id = $v['tour_id'];
		$tmp = !empty($tour_id) ? $clsISO->getArrayByTextSlash($tour_id) : array();
//		var_dump($tour_id);
		if(!empty($tmp)){
			foreach($tmp as $id){
				if(!in_array($id, $list_tour_id)){
					$list_tour_id[] = $id;
				}
			}
		}

	}
	$list_tour_id = implode(",",$list_tour_id);
	$html = '<option value="0">'.$core->get_Lang('Điểm đến').'</option>';
	$lstItems = $clsTourDestination->getAll("is_trash=0 and tour_id IN ($list_tour_id) and city_id IN (SELECT city_id from ".DB_PREFIX."city WHERE is_trash=0 and is_online=1) order by order_no asc",$clsTourDestination->pkey.',city_id');
	if($departure_point_ID != 0){
		if(is_array($lstItems) && count($lstItems) > 0){
			 $list_city_id = array();
				foreach($lstItems as $k =>$v){
					$city_id = $clsTourDestination->getOneField('city_id', $v[$clsTourDestination->pkey]);
					$tmp = !empty($city_id) ? $clsISO->getArrayByTextSlash($city_id) : array();
					if(!empty($tmp)){
						foreach($tmp as $id){
							if(!in_array($id, $list_city_id)){
								$list_city_id[] = $id;
							}
						}
					}

				}
			 	foreach($list_city_id as $one_city) {
					 if($clsTour->countTourDeparturePointStartDate($departure_point_ID,$one_city,0,$list_tour_id)>0){
						$html .= '<option value="'.$one_city.'">'.$clsCity->getTitle($one_city).'</option>';
					 }

				}
            unset($lstItems);
        }
    }else{
		if(is_array($lstItems) && count($lstItems) > 0){
			 $list_city_id = array();
				foreach($lstItems as $k =>$v){
					$city_id = $clsTourDestination->getOneField('city_id', $v[$clsTourDestination->pkey]);
					$tmp = !empty($city_id) ? $clsISO->getArrayByTextSlash($city_id) : array();
					if(!empty($tmp)){
						foreach($tmp as $id){
							if(!in_array($id, $list_city_id)){
								$list_city_id[] = $id;
							}
						}
					}

				}
			 	foreach($list_city_id as $one_city) {
					$html .= '<option value="'.$one_city.'">'.$clsCity->getTitle($one_city).'</option>';

				}
            unset($lstItems);
        }
	}

	#
	echo $html; die();
}
function default_ajLoadSelectCategory(){
	global $core,$mod,$act,$_LANG_ID;
	#
	$clsTourCategory = new TourCategory();
	$clsCountry = new Country();
	$clsTour = new Tour();
	#
	$departure_point_ID = intval($_POST['departure_point_ID']);
	$city_id = intval($_POST['city_id']);
	$cat_id = intval($_POST['cat_id']);
	
	#
	$html = '<option value="0">'.$core->get_Lang('Select All').'</option>';
	$lstCategory = $clsTourCategory->getAll("is_trash=0 and is_online=1 order by order_no asc", $clsTourCategory->pkey);
	if(is_array($lstCategory) && count($lstCategory) > 0){
		foreach($lstCategory as $k=>$v){
			if($clsTour->countTourDeparturePoint($departure_point_ID, $city_id, $v[$clsTourCategory->pkey]) > 0){
				$html.='<option value="'.$v[$clsTourCategory->pkey].'" '.($cat_id==$v[$clsTourCategory->pkey]?'selected="selected"':'').'>'.$clsTourCategory->getTitle($v[$clsTourCategory->pkey]).'</option>';
			}
		}
    }

 	#
	echo $html; die();
}


function default_loadCabinType(){
	global $core,$mod,$act,$clsISO;
	#
	$clsCountry = new Country();
	$clsCity = new City();
	$clsTour = new Tour();
	#
	$cruise_id = $_POST['cruise_id'];

	$cruise_itinerary_id = $_POST['cruise_itinerary_id'];
	$departure_date = $_POST['departure_date'];
	
	#-- Cruise Rooms
	$clsCruiseCabin = new CruiseCabin();$assign_list["clsCruiseCabin"] = $clsCruiseCabin;
	$lstCruiseCabin = $clsCruiseCabin->getAll("is_trash=0 and cruise_id = '$cruise_id' order by order_no desc");
	$assign_list['lstCruiseCabin']=$lstCruiseCabin;
	
	$clsCruiseProperty = new CruiseProperty();
	$assign_list['clsCruiseProperty'] = $clsCruiseProperty;
	$listTypeRoom = $clsCruiseProperty->getAll("is_trash=0 and type='TypeRoom' order by order_no desc");
	
	$assign_list['listTypeRoom']=$listTypeRoom;
	
	
	#
	$html = '<table border="1">
    <thead>
        <tr>
            <th colspan="'.count($listTypeRoom).'" align="center" style="text-align:center; border:1px solid #ddd">'.$core->get_Lang('Cabin Types').'</th>
        </tr>
        <tr>';
            for($i=0; $i<count($listTypeRoom); $i++){
            $html.='<th width="72px" align="center" style="border:1px solid #ddd; text-align:center">'.$clsCruiseProperty->getTitle($listTypeRoom[$i][$clsCruiseProperty->pkey]).'
                <div class="clearfix"></div>
                <span style="font-size:11px; color:#FFF">'.$clsCruiseProperty->getIntro($listTypeRoom[$i][$clsCruiseProperty->pkey]).'</span>
            </th>';
			}
        $html.='</tr>
    </thead>
    <tbody>';
        $html.='<tr>';
			for($k=0; $k<count($listTypeRoom); $k++){
            $html.='<td width="72px" align="center" class="text-center" style="border:1px solid #ddd">
			<select name="cabinSelect'.$listTypeRoom[$k][$clsCruiseProperty->pkey].'" cabin_type_id="'.$listTypeRoom[$k][$clsCruiseProperty->pkey].'">
                    '.$clsISO->getSelect(1,10).'
                </select>';
	
           $html.=' </td>';
		}
        $html.='</tr>';
    $html.='</tbody>
    
    </table>
	
	';
	
	#
	echo $html; die();
}


function default_loadPriceCabin(){
	global $core,$mod,$act,$clsISO;
	#
	$clsCountry = new Country();
	$clsCity = new City();
	$clsTour = new Tour();
	$clsCruiseItinerary = new CruiseItinerary();
	$assign_list["clsCruiseItinerary"] = $clsCruiseItinerary;
	$clsCruise = new Cruise();
	#
	$cruise_id = $_POST['cruise_id'];

	$cruise_itinerary_id = $_POST['cruise_itinerary_id'];
	$assign_list['cruise_itinerary_id']=$cruise_itinerary_id; 
	
	$oneItem = $clsCruiseItinerary->getOne($cruise_itinerary_id);
	
	$departure_date = $_POST['departure_date'];
	/*$departure_date = $clsISO->parseTextToTime($departure_date);
	*/
	$departure_date = date('m',strtotime($departure_date));
	$sql = "cruise_itinerary_id='$cruise_itinerary_id' and high_season_month like '%|".$departure_date."|%' limit 0,1";
	$lstCruiseItinerary = $clsCruiseItinerary->getAll($sql);
	/*$totalCruiseItinerary=count($lstCruiseItinerary);*/
	$totalCruiseItinerary= $clsCruiseItinerary->countItem($sql);
	$assign_list['totalCruiseItinerary']=$totalCruiseItinerary; 
	
	if($totalCruiseItinerary >0){
		$seasson='high';
	}else{
		$seasson='low';
	}
	$assign_list['seasson']=$seasson; 
	
	$cruise_property_id = $_POST['cruise_property_id'];
	$num_adult = $_POST['num_adult'];
	$num_child = $_POST['num_child'];
	
	
	
	#list all Room and hotel Facilities
	$list_high_season_month = $oneItem['high_season_month'];
	
	$lsthighSeasson = array();
	if($list_high_season_month != '' && $list_high_season_month != '0'){
		$list_high_season_month = str_replace('||','|',$list_high_season_month);
		$list_high_season_month = ltrim($list_high_season_month,'|');
		$list_high_season_month = rtrim($list_high_season_month,'|'); 
		$TMP = explode('|',$list_high_season_month);
		for($i=0; $i<count($TMP); $i++){
			if(!in_array($TMP[$i],$lsthighSeasson)){
				$lsthighSeasson[] = $TMP[$i];
			}
		}
	}
	$assign_list['lsthighSeasson']=$lsthighSeasson; 
	
	
	unset($lsthighSeasson);
	
	
	
	#-- Cruise Rooms
	$clsCruiseCabin = new CruiseCabin();$assign_list["clsCruiseCabin"] = $clsCruiseCabin;
	$lstCruiseCabin = $clsCruiseCabin->getAll("is_trash=0 and cruise_id = '$cruise_id' order by order_no desc");
	$assign_list['lstCruiseCabin']=$lstCruiseCabin;
	
	$clsCruiseProperty = new CruiseProperty();
	$assign_list['clsCruiseProperty'] = $clsCruiseProperty;
	$listTypeRoom = $clsCruiseProperty->getAll("is_trash=0 and type='TypeRoom' order by order_no desc");
	
	$assign_list['listTypeRoom']=$listTypeRoom;
	
	#
	$html = '
		<tr>
		<th>'.$core->get_Lang('Room Types').'</th>
		<th class="text-center">'.$core->get_Lang('Max').'</th>
		<th class="text-center">'.$core->get_Lang('Conditions').'</th>
		<th class="text-center" >Book</th>
		</tr>';
		for($i=0;$i<count($lstCruiseCabin); $i++){
		$max_adult =$clsCruiseCabin->getMaxAdult($lstCruiseCabin[$i][$clsCruiseCabin->pkey]);
		$max_child =$clsCruiseCabin->getMaxChild($lstCruiseCabin[$i][$clsCruiseCabin->pkey]);
		$cabin_size =$clsCruiseCabin->getCabinSize($lstCruiseCabin[$i][$clsCruiseCabin->pkey]);
		$bed_option =$clsCruiseCabin->getBedOption($lstCruiseCabin[$i][$clsCruiseCabin->pkey]);
		$price=$clsCruiseCabin->getValuePriceCruiseCabin($lstCruiseCabin[$i][$clsCruiseCabin->pkey],$cruise_itinerary_id,$cruise_property_id,$seasson,$num_adult);
		if($price > 0){
			$html.='<tr>
			<td class="media">
			<div class="pull-left">
			<img src="'.$clsCruiseCabin->getImage($lstCruiseCabin[$i][$clsCruiseCabin->pkey],248,136).'" alt="'.$clsCruiseCabin->getTitle($lstCruiseCabin[$i][$clsCruiseCabin->pkey]).'">
			</div>
			
			<div class="media-body">
				<h5 class="media-heading z_14 text-bold">'.$clsCruiseCabin->getTitle($lstCruiseCabin[$i][$clsCruiseCabin->pkey]).'</h5>
				<ul class="list-inline c6 z_11">
				<li><i class="fa fa-cube"></i> '.$core->get_Lang('Size').': '.$cabin_size.' m2</li>
				<li><i class="fa fa-user"></i> '.$core->get_Lang('Max Adults').': '.$max_adult.'</li>
				<li><i class="fa fa-hotel"></i> '.$core->get_Lang('Bed options').': '.$bed_option.'</li>
				</ul>
				<a href="javascript:void(0);" rel="nofollow" data-toggle="modal" data-target="#RoomModal'.$lstCruiseCabin[$i][$clsCruiseCabin->pkey].'"> <i class="fa fa-info-circle"></i> '.$core->get_Lang('Show more').'</a>
				
				
				<div class="modal fade roomModal" id="RoomModal'.$lstCruiseCabin[$i][$clsCruiseCabin->pkey].'" tabindex="-1" role="dialog" aria-labelledby="roomModalLabel" aria-hidden="false">
					<div class="modal-dialog modal-lg" role="document">    	
						<div class="modal-content" id="container-room-detail">
							<div class="modal-header">
							<button type="button" class="close c6" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="fa fa-times"></span></button>
							<h4 class="modal-title text-uppercase c2a z_18" id="roomModalLabel">'.$clsCruiseCabin->getTitle($lstCruiseCabin[$i][$clsCruiseCabin->pkey]).'</h4>
							</div>
							<div class="modal-body">
								<div class="row">
									<div class="col-md-6">
										<img src="'.$clsCruiseCabin->getImage($lstCruiseCabin[$i][$clsCruiseCabin->pkey],409,218).'"/>
									
										<div class="m-item" style="margin-top:30px">
											<h5><span>'.$core->get_Lang('DESCRIPTION').'</span></h5>
											<div class="m-content">
											<strong>'.$core->get_Lang('Cabin size').':</strong> '.$cabin_size.' sqm <br>
											<strong>'.$core->get_Lang('Bed size').':</strong> '.$bed_option.'<br>
											<strong>'.$core->get_Lang('Max People').':</strong>  '.$max_adult.' Adults,'.$max_child.' Children                 	</p>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="m-item">
											<h5><span>'.$core->get_Lang('Cabin Facilities').'</span></h5>
											<div class="m-content">
											<ul class="list-col-2">
											'.$clsCruiseCabin->getCabinFa($lstCruiseCabin[$i][$clsCruiseCabin->pkey]).'
											</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			</td>
			<td class="tb-per" style="vertical-align:middle">
				<div class="has-feedback">
					<ul class="list-inline">
					<li class="adult">';
					for($a=0;$a<$max_adult;$a++){
					$html.='<span class="fa fa-user"></span>';
					}
					$html.='</li>';
					if($max_child > 0){
					$html.='<li>+</li>
					<li class="child">';
	
					for($c=0;$c<$max_child;$c++){
					$html.='<span class="fa fa-user"></span>';
					}
					$html.='</li>';
					}
					$html.='</ul>';
					if($max_child > 0){
					$html.='<div class="tooltip-user">
					'.$core->get_Lang('Max adults').': '.$max_adult.' <br>
					'.$core->get_Lang('Max children').': '.$max_child.' ('.$core->get_Lang('up to 12 years of age').')
					</div>';
					}else{
					$html.='<div class="tooltip-user">
					'.$core->get_Lang('Max adults').': '.$max_adult.'
					</div>';
					}
				$html.='</div>
			</td>
			<td  class="bg-e1 tb-cond">';
				if($clsCruise->getEasyCancellation($cruise_id)!=''){
				$html.='<div class="has-feedback">
					<label class="c2a">'.$core->get_Lang('Easy cancellation').' <i class="fa fa-info"></i></label>
					<div class="cond-sup">
						'.$clsCruise->getEasyCancellation($cruise_id).'
					</div>
				</div>';
				}
				if($clsCruise->getBookingCondition($cruise_id) !=''){
				$html.='<ul class="list-check z_12">
					'.$clsCruise->getBookingCondition($cruise_id).'
				</ul>';
				}
			$html.='</td>
			<td  class="linkBook" style="vertical-align:middle; text-align:center">';
				if($price > 0){
				$html.='<strong class="z_24 price-show">
				   '.$clsCruiseCabin->getPriceCruiseCabin($lstCruiseCabin[$i][$clsCruiseCabin->pkey],$cruise_itinerary_id,$cruise_property_id,$seasson,$num_adult).'
				</strong>
				<form method="post" action="" class="form-inline">
				<input type="hidden" name="cruise_itinerary_id" value="'.$cruise_itinerary_id.'">
				<input type="hidden" name="cruise_cabin_id" value="'.$lstCruiseCabin[$i][$clsCruiseCabin->pkey].'">
				<input type="hidden" name="cruise_property_id" value="'.$cruise_property_id.'">
				<input type="hidden" name="number_adult" value="'.$num_adult.'">
				<input type="hidden" name="totalPrice" value="'.$clsCruiseCabin->getValuePriceCruiseCabin($lstCruiseCabin[$i][$clsCruiseCabin->pkey],$cruise_itinerary_id,$cruise_property_id,$seasson,$num_adult).'">
				<input type="hidden" name="departure_date" value="'.$_POST['departure_date'].'">
				<button type="submit" style="width:120px" class="btn btn-style-2a btn-block" id="bookingCabin'.$lstCruiseCabin[$i][$clsCruiseCabin->pkey].'">'.$core->get_Lang('Booking').'</button>
				<input type="hidden" name="BookingCabin" value="BookingCabin">
				</form>';
				}else{
					$html.='<p>'.$core->get_Lang('Sorry, this cabin is fully booked already').'. </p>';
				}
			$html.='</td>
			</tr>';
			}
		}
	
	
	
	
	$html.='';

	#
	echo $html; die();
}
function default_loadPriceCabinMobile(){
	global $core,$mod,$act,$clsISO;
	#
	$clsCountry = new Country();
	$clsCity = new City();
	$clsTour = new Tour();
	$clsCruiseItinerary = new CruiseItinerary();
	$assign_list["clsCruiseItinerary"] = $clsCruiseItinerary;
	$clsCruise = new Cruise();
	#
	$cruise_id = $_POST['cruise_id'];

	$cruise_itinerary_id = $_POST['cruise_itinerary_id'];
	$assign_list['cruise_itinerary_id']=$cruise_itinerary_id; 
	
	$oneItem = $clsCruiseItinerary->getOne($cruise_itinerary_id);
	
	$departure_date = $_POST['departure_date'];
	$departure_date = $clsISO->parseTextToTime($departure_date);
	$departure_date = date('m',strtotime($departure_date));
	
	$lstCruiseItinerary = $clsCruiseItinerary->getAll("cruise_itinerary_id='$cruise_itinerary_id' and high_season_month like '%|".$departure_date."|%' limit 0,1");
	$totalCruiseItinerary=count($lstCruiseItinerary);
	$assign_list['totalCruiseItinerary']=$totalCruiseItinerary; 
	
	if($totalCruiseItinerary ==1){
		$seasson='high';
	}else{
		$seasson='low';
	}
	
	$assign_list['seasson']=$seasson; 
	
	$cruise_property_id = $_POST['cruise_property_id'];
	$num_adult = $_POST['num_adult'];
	$num_child = $_POST['num_child'];
	
	
	
	#list all Room and hotel Facilities
	$list_high_season_month = $oneItem['high_season_month'];
	
	$lsthighSeasson = array();
	if($list_high_season_month != '' && $list_high_season_month != '0'){
		$list_high_season_month = str_replace('||','|',$list_high_season_month);
		$list_high_season_month = ltrim($list_high_season_month,'|');
		$list_high_season_month = rtrim($list_high_season_month,'|'); 
		$TMP = explode('|',$list_high_season_month);
		for($i=0; $i<count($TMP); $i++){
			if(!in_array($TMP[$i],$lsthighSeasson)){
				$lsthighSeasson[] = $TMP[$i];
			}
		}
	}
	$assign_list['lsthighSeasson']=$lsthighSeasson; 
	
	
	unset($lsthighSeasson);
	
	
	#-- Cruise Rooms
	$clsCruiseCabin = new CruiseCabin();$assign_list["clsCruiseCabin"] = $clsCruiseCabin;
	$lstCruiseCabin = $clsCruiseCabin->getAll("is_trash=0 and cruise_id = '$cruise_id' order by order_no desc");
	
	$assign_list['lstCruiseCabin']=$lstCruiseCabin;
	
	$clsCruiseProperty = new CruiseProperty();
	$assign_list['clsCruiseProperty'] = $clsCruiseProperty;
	$listTypeRoom = $clsCruiseProperty->getAll("is_trash=0 and type='TypeRoom' order by order_no desc");
	
	$assign_list['listTypeRoom']=$listTypeRoom;
	
	#
	$html = '
	<tr>
		<td class="caption"><p class="ic-unlock"> <strong>'.$core->get_Lang('Book now to get this fantastic price').'.</strong> '.$core->get_Lang('If you book later, there a chance the price will go up or the cruise will be sold out').'. </p></td>
  </tr>';
  
  for($i=0;$i<count($lstCruiseCabin); $i++){
		$max_adult =$clsCruiseCabin->getMaxAdult($lstCruiseCabin[$i][$clsCruiseCabin->pkey]);
		$max_child =$clsCruiseCabin->getMaxChild($lstCruiseCabin[$i][$clsCruiseCabin->pkey]);
		$cabin_size =$clsCruiseCabin->getCabinSize($lstCruiseCabin[$i][$clsCruiseCabin->pkey]);
		$bed_option =$clsCruiseCabin->getBedOption($lstCruiseCabin[$i][$clsCruiseCabin->pkey]);
		$price=$clsCruiseCabin->getValuePriceCruiseCabin($lstCruiseCabin[$i][$clsCruiseCabin->pkey],$cruise_itinerary_id,$cruise_property_id,$seasson,$num_adult);
  $html.='<tr>
    <td class="tb-main"><div class="item media">
        <div class="pull-left"> <img src="'.$clsCruiseCabin->getImage($lstCruiseCabin[$i][$clsCruiseCabin->pkey],248,136).'" alt="'.$clsCruiseCabin->getTitle($lstCruiseCabin[$i][$clsCruiseCabin->pkey]).'"></div>
		<div class="media-body"> 
			<h5 class="media-heading z_14 text-bold">'.$clsCruiseCabin->getTitle($lstCruiseCabin[$i][$clsCruiseCabin->pkey]).'</h5>
			<p class="c6 z_11"> <i class="fa fa-cube"></i> '.$core->get_Lang('Size').': '.$cabin_size.' m2<br/>
			<i class="fa fa-user"></i> '.$core->get_Lang('Max Adults').': '.$max_adult.'<br/>
			<i class="fa fa-hotel"></i> '.$core->get_Lang('Bed options').': '.$bed_option.'</p>
			<a href="javascript:void(0);" rel="nofollow" data-toggle="modal" data-target="#RoomModalMobile'.$lstCruiseCabin[$i][$clsCruiseCabin->pkey].'"> <i class="fa fa-info-circle"></i> '.$core->get_Lang('Show more').'</a>
			
			
			<div class="modal fade roomModal" id="RoomModalMobile'.$lstCruiseCabin[$i][$clsCruiseCabin->pkey].'" tabindex="-1" role="dialog" aria-labelledby="roomModalLabel" aria-hidden="false">
				<div class="modal-dialog modal-lg" role="document">    	
					<div class="modal-content" id="container-room-detail">
						<div class="modal-header">
						<button type="button" class="close c6" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="fa fa-times"></span></button>
						<h4 class="modal-title text-uppercase c2a z_18" id="roomModalLabel">'.$clsCruiseCabin->getTitle($lstCruiseCabin[$i][$clsCruiseCabin->pkey]).'</h4>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-md-6">
									<img src="'.$clsCruiseCabin->getImage($lstCruiseCabin[$i][$clsCruiseCabin->pkey],409,218).'"/>
								
									<div class="m-item" style="margin-top:30px">
										<h5><span>'.$core->get_Lang('DESCRIPTION').'</span></h5>
										<div class="m-content">
										<strong>'.$core->get_Lang('Cabin size').':</strong> '.$cabin_size.' sqm <br>
										<strong>'.$core->get_Lang('Bed size').':</strong> '.$bed_option.'<br>
										<strong>'.$core->get_Lang('Max People').':</strong>  '.$max_adult.' Adults,'.$max_child.' Children                 	</p>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="m-item">
										<h5><span>'.$core->get_Lang('Cabin Facilities').'</span></h5>
										<div class="m-content">
										<ul class="list-col-2">
										'.$clsCruiseCabin->getCabinFa($lstCruiseCabin[$i][$clsCruiseCabin->pkey]).'
										</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

        </div>
        <div class="item bg-e1 mt10">
          <div class="row">
            <div class="col-xs-6 tb-cond">';
			  if($clsCruise->getEasyCancellation($cruise_id)!=''){
				$html.='<div class="has-feedback">
					<label class="c2a">'.$core->get_Lang('Easy cancellation').' <i class="fa fa-info"></i></label>
					<div class="cond-sup">
						'.$clsCruise->getEasyCancellation($cruise_id).'
					</div>
				</div>';
				}
				if($clsCruise->getBookingCondition($cruise_id) !=''){
				$html.='<ul class="list-check z_10">
					'.$clsCruise->getBookingCondition($cruise_id).'
				</ul>';
				}
            $html.='</div>
            <div class="col-xs-6 tb-price text-right">
              <p class="z_11">Recommended for you</p>
              <strong class="block z_18 f_hn"> '.$clsCruiseCabin->getPriceCruiseCabin($lstCruiseCabin[$i][$clsCruiseCabin->pkey],$cruise_itinerary_id,$cruise_property_id,$seasson,$num_adult).'</strong>
				<form method="post" action="" class="form-inline">
				<input type="hidden" name="cruise_itinerary_id" value="'.$cruise_itinerary_id.'">
				<input type="hidden" name="cruise_cabin_id" value="'.$lstCruiseCabin[$i][$clsCruiseCabin->pkey].'">
				<input type="hidden" name="cruise_property_id" value="'.$cruise_property_id.'">
				<input type="hidden" name="number_adult" value="'.$num_adult.'">
				<input type="hidden" name="totalPrice" value="'.$clsCruiseCabin->getValuePriceCruiseCabin($lstCruiseCabin[$i][$clsCruiseCabin->pkey],$cruise_itinerary_id,$cruise_property_id,$seasson,$num_adult).'">
				<input type="hidden" name="departure_date" value="'.$_POST['departure_date'].'">
				<button type="submit" style="width:120px" class="btn btn-style-2a btn-block fr mt10" id="bookingCabin'.$lstCruiseCabin[$i][$clsCruiseCabin->pkey].'">'.$core->get_Lang('Booking').'</button>
				<input type="hidden" name="BookingCabin" value="BookingCabin">
				</form>
            </div>
          </div>
        </div>
      </div></td>
  </tr>';
  }

	
	
	
	
	$html.='';

	#
	echo $html; die();
}


function default_ajLoadSelectDuration(){
	global $core, $mod,$_LANG_ID;
	$clsTour = new Tour();
	$clsCountry = new Country();
	#
	$departure_point_id = intval($_POST['departure_point_id']);
	$city_id = intval($_POST['city_id']);
	$cat_id = intval($_POST['cat_id']);
	$duration_id = intval($_POST['duration_id']);
	#
	$html = '<option value="0">'.$core->get_Lang('Tour length').'</option>';
	#
	$cond .= "is_trash=0 and is_online=1";
	if(intval($departure_point_id) > 0){
		$cond .= " and (departure_point_id = '$departure_point_id' or list_departure_point_id like '%|$departure_point_id|%')";
	}
	if($city_id > 0) $cond .= " and tour_id IN (SELECT tour_id FROM ".DB_PREFIX."tour_destination WHERE city_id='$city_id')";
	if($cat_id > 0) $cond .= " and list_cat_id like '%|".$cat_id."|%'";	
	#

	$LISTALL = $clsTour->getAll($cond);
    //var_dump($cond);die();
	$TMP = '';
	$DURATION_HTML = '<option value="0">'.$core->get_Lang('Tour length').'</option>';
	if(is_array($LISTALL) && count($LISTALL) > 0){
		for ($i=0; $i<count($LISTALL); $i++) {
			$TMP .= $clsTour->getSelectTripDuration($LISTALL[$i][$clsTour->pkey]).'|';
		}
		$TMP = array_unique(explode('|', $TMP));
		if(is_array($TMP) && count($TMP) > 0){
			sort($TMP,SORT_NUMERIC);
			foreach($TMP as $key=>$val){
				if($val!='' && $val!='n/a'){
					$DURATION_HTML .= '
				<option value="'.$clsTour->convertDuration($val).'" '.($duration==$clsTour->convertDuration($val)?'selected="selected"':'').'>'.$val.'</option>';
				}
			}
		}
		unset($LISTALL);
    }

	#
	echo $DURATION_HTML; die();
}
function default_ajLoadSelectDurationDeparture(){
	global $core, $mod,$_LANG_ID,$clsISO;
	$clsTour = new Tour();
	$clsCountry = new Country();
	$clsTourStartDate = new TourStartDate();
	#
	$departure_point_id = intval($_POST['departure_point_id']);
	$city_id = intval($_POST['city_id']);
	$cat_id = intval($_POST['cat_id']);
	$duration_id = intval($_POST['duration_id']);
	$tour_group_id = intval($_POST['tour_group_id']);

	#
	
	$lstTourStartDate = $clsTourStartDate->getAll("is_trash=0 and is_online=1 and start_date >= '".time()."' and tour_id IN(SELECT tour_id FROM ".DB_PREFIX."tour_store) and tour_id IN(SELECT tour_id FROM ".DB_PREFIX."tour where is_trash=0 and is_online=1 and tour_group_id='$tour_group_id') order by start_date asc",$clsTourStartDate->pkey.',tour_id');
	$assign_list['lstTourStartDate']= $lstTourStartDate;
//	print_r($departure_point_id);die();
	$cond = "is_trash=0 and is_online=1";
	$list_tour_id = array();
	foreach($lstTourStartDate as $k =>$v){
		$tour_id = $v['tour_id'];
//		print_r($tour_id);die();
		$tmp = !empty($tour_id) ? $clsISO->getArrayByTextSlash($tour_id) : array();
//		print_r($tour_id);
		if(!empty($tmp)){
			foreach($tmp as $id){
				if(!in_array($id, $list_tour_id)){
					$list_tour_id[] = $id;
				}
			}
		}

	}
	$list_tour_id = implode(",",$list_tour_id);
	
	$cond = "is_trash=0 and is_online=1 and tour_id IN ($list_tour_id)";
	if(intval($departure_point_id) > 0){
		$cond .= " and (departure_point_id = '$departure_point_id' or list_departure_point_id like '%|$departure_point_id|%')";
	}
	if($city_id > 0) $cond .= " and tour_id IN (SELECT tour_id FROM ".DB_PREFIX."tour_destination WHERE city_id='$city_id')";
	
	$LISTALL = $clsTour->getAll($cond);
	$TMP = '';
	$DURATION_HTML = '<option value="0">'.$core->get_Lang('Tour length').'</option>';
	if(is_array($LISTALL) && count($LISTALL) > 0){
		for ($i=0; $i<count($LISTALL); $i++) {
			$TMP .= $clsTour->getSelectTripDuration($LISTALL[$i][$clsTour->pkey]).'|';
		}
		$TMP = array_unique(explode('|', $TMP));
		if(is_array($TMP) && count($TMP) > 0){
			sort($TMP,SORT_NUMERIC);
			foreach($TMP as $key=>$val){
				if($val!='' && $val!='n/a'){
					$DURATION_HTML .= '
				<option value="'.$clsTour->convertDuration($val).'" '.($duration==$clsTour->convertDuration($val)?'selected="selected"':'').'>'.$val.'</option>';
				}
			}
		}
		unset($LISTALL);
    }

	#
	echo $DURATION_HTML; die();
}
function default_ajLoadSelectStartDateDeparture(){
	global $core, $mod,$_LANG_ID,$clsISO;
	$clsTour = new Tour();
	$clsCountry = new Country();
	$clsTourStartDate = new TourStartDate();
	#
	$departure_point_id = intval($_POST['departure_point_id']);
	$city_id = intval($_POST['city_id']);
	$duration_id = intval($_POST['duration_id']);
	$tour_group_id = intval($_POST['tour_group_id']);
	#
	$cond ="is_trash=0 and is_online=1 and start_date >= '".time()."' and tour_id IN(SELECT tour_id FROM ".DB_PREFIX."tour_store) and tour_id IN(SELECT tour_id FROM ".DB_PREFIX."tour where is_trash=0 and is_online=1 and tour_group_id='$tour_group_id'";
	$order = " order by start_date asc";
	$lstTourStartDate = $clsTourStartDate->getAll($cond.')'.$order,$clsTourStartDate->pkey.',tour_id');
	$assign_list['lstTourStartDate']= $lstTourStartDate;
//	print_r($departure_point_id);die();
	$list_tour_id = array();
	foreach($lstTourStartDate as $k =>$v){
		$tour_id = $v['tour_id'];
//		print_r($tour_id);die();
		$tmp = !empty($tour_id) ? $clsISO->getArrayByTextSlash($tour_id) : array();
//		print_r($tour_id);
		if(!empty($tmp)){
			foreach($tmp as $id){
				if(!in_array($id, $list_tour_id)){
					$list_tour_id[] = $id;
				}
			}
		}

	}
	$list_tour_id = implode(",",$list_tour_id);
	if(intval($departure_point_id) > 0 && $duration_id==0){
		$cond .=" and (departure_point_id = '$departure_point_id' or list_departure_point_id like '%|$departure_point_id|%'))";
	}elseif(intval($departure_point_id) > 0 && !empty($duration_id)){
		$cond .=" and (departure_point_id = '$departure_point_id' or list_departure_point_id like '%|$departure_point_id|%')";
	}
	if(!empty($duration_id)){
		$cond.= " and number_day IN($duration_id))";
	}
	if($city_id > 0 && $departure_point_id >0){
		$cond .= "and tour_id IN (SELECT tour_id FROM ".DB_PREFIX."tour_destination WHERE city_id='$city_id')";
	}elseif($city_id > 0 && $departure_point_id == 0 && $duration_id==0){
		$cond .= ") and tour_id IN (SELECT tour_id FROM ".DB_PREFIX."tour_destination WHERE city_id='$city_id')";
	}elseif($city_id == 0 && $departure_point_id == 0 && $duration_id==0){
		$cond .=")";
	}
//	print_r($cond.$order);die();
	$LISTALL = $clsTourStartDate->getAll($cond.$order,$clsTourStartDate->pkey.',tour_id');
	$TMP = '';
	$AVAILABLE_HTML = '<option value="0">'.$core->get_Lang('Ngày khởi hành').'</option>';
	if(is_array($LISTALL) && count($LISTALL) > 0){
		$list_start_date = array();
		foreach($LISTALL as $k =>$v){
			$list_start_date_id = $clsTourStartDate->getOneField('start_date',$v['tour_start_date_id']);
			$tmp = !empty($list_start_date_id) ? $clsISO->getArrayByTextSlash($list_start_date_id) : array();
			if(!empty($tmp)){
				foreach($tmp as $id){
					if(!in_array($id, $list_start_date)){
						$list_start_date[] = $id;
					}
				}
			}
		}
		for($i=0; $i<count($list_start_date); $i++) {		
			$AVAILABLE_HTML .= '<option value="'.$clsISO->formatDate($list_start_date[$i],'').'">'.$clsISO->formatDate($list_start_date[$i],'').'</option>';
			
		}
		unset($list_start_date);
	}
	echo $AVAILABLE_HTML; die();
}
function default_ajLoadSelectDurationCruise(){
	
	global $core, $mod;
	$clsCruiseItinerary = new CruiseItinerary();
	#
	$cruise_cat_id = intval($_POST['cruise_cat_id']);
	$cond="is_trash = 0 and is_online=1";
	if($cruise_cat_id){
		$cond.=" and cruise_id IN (SELECT cruise_id FROM ".DB_PREFIX."cruise WHERE is_trash=0 and is_online=1 and (cruise_cat_id='$cruise_cat_id' or list_cat_id like '%|".$cruise_cat_id."|%'))";
	}else{
		$cond.=" and cruise_id IN (SELECT cruise_id FROM ".DB_PREFIX."cruise WHERE is_trash=0 and is_online=1)";
	}
	
	$lstItinerary=$clsCruiseItinerary->getAll($cond." order by number_day asc", $clsCruiseItinerary->pkey);
	
	
	$LISTALL = $clsCruiseItinerary->getAll($cond." order by number_day asc");
	$TMP = '';
	$DURATION_HTML = '<option value="0">'.$core->get_Lang('Duration').'</option>';
	if(is_array($LISTALL) && count($LISTALL) > 0){
		for ($i=0; $i<count($LISTALL); $i++) {
			$TMP .= $clsCruiseItinerary->makeSelectTripDurationNew($LISTALL[$i][$clsCruiseItinerary->pkey]).'|';
		}
		$TMP = array_unique(explode('|', $TMP));
		if(is_array($TMP) && count($TMP) > 0){
			sort($TMP,SORT_NUMERIC);
			foreach($TMP as $key=>$val){
				if($val!='' && $val!='n/a'){
					$DURATION_HTML .= '
					<option value="'.$clsCruiseItinerary->convertDurationSearch($val).'" '.($duration==$clsCruiseItinerary->convertDurationSearch($val)?'selected="selected"':'').'>'.$clsCruiseItinerary->convertTitleDurationSearch($val).'</option>';
				}
			}
		}
		unset($LISTALL);
	}
	#
	echo $DURATION_HTML; die();
	
	
}

function  default_loadToptourHome(){
		global $core, $mod;
	$clsTour=new Tour();
	 $listTopTour = $clsTour->getAll("is_trash=0 and is_online=1 and tour_id IN (SELECT tour_id FROM ".DB_PREFIX."tour_store WHERE _type='HOT' order by order_no ASC)", $clsTour->pkey);



	}