<?php

class Reviews extends dbBasic
{
    function __construct()
    {
        global $_LANG_ID;
        $this->pkey = "reviews_id";
        $this->tbl = DB_PREFIX . "reviews";
    }

    function getRegDate($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable);
        return date('m/d/Y', $one['reg_date']);
    }

    function getTitle($pvalTable = 0, $one = null)
    {
        if (!isset($one['title'])) {
            $one = $this->getOne($pvalTable, 'title');
        }
        return $one['title'];
    }

    function getContent($pvalTable = 0, $limit = 400, $truncate = true, $one = null)
    {
        global $dbconn, $core;
        if (!isset($one['content'])) {
            $one = $this->getOne($pvalTable, 'content');
        }
        $string = $one['content'];

        if ($truncate == true) {
            if (strlen($string) < $limit) {
                return html_entity_decode($string);
            } else {
                $html = '<div class="clickSeemore"><div class="c_seemore More">';
                $html .= strip_tags(html_entity_decode($this->truncate($string, $limit)));
                $html .= '<a href="javascript:void(0);" class="semoreClick">' . $core->get_Lang('More') . '</a>';
                $html .= '</div>';
                $html .= '<div class="c_seemore Less" style="display:none">';
                $html .= html_entity_decode($string);
                $html .= '<a href="javascript:void(0);" class="LessClick">' . $core->get_Lang('Less') . '</a>';
                $html .= '</div></div>';
                return $html;
            }
        } else {
            return $string;
        }
    }

    function truncate($string = '', $width = 0, $etc = ' ..')
    {
        $wrapped = explode('$trun$', wordwrap($string, $width, '$trun$', false), 2);
        return $wrapped[0] . (isset($wrapped[1]) ? $etc : '');
    }

    function getFullName($pvalTable = 0, $one = null)
    {
        if (!isset($one['fullname'])) {
            $one = $this->getOne($pvalTable, 'fullname');
        }
        return $one['fullname'];
    }

    function getEmail($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'email');
        return $one['email'];
    }

    function getReview_date($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'review_date');
        return $one['review_date'];
    }

    function getRates($pvalTable = 0, $one = null)
    {
        if (!isset($one['rates'])) {
            $one = $this->getOne($pvalTable, 'rates');
        }
        return $one['rates'];
    }

    function getRatesStar($pvalTable = 0, $one = null)
    {
        if (!isset($one['rates'])) {
            $one = $this->getOne($pvalTable, 'rates');
        }
        $rates = $one['rates'];
        return '<span style="width: ' . ($rates * 20) . '%;"></span>';
    }

    function getNewRates($pvalTable = 0, $one = null)
    {
        global $core;
        if (!isset($one['rates'])) {
            $one = $this->getOne($pvalTable, 'rates');
        }
        return number_format($one['rates'], 1) . ' - ' . $this->getTextRateOne($pvalTable);
    }

    function getTextRateOne($pvalTable = 0, $one = null)
    {
        global $core;
        if (!isset($one['rates'])) {
            $one = $this->getOne($pvalTable, 'rates');
        }
        $rateScore = $one['rates'];
        if ($rateScore >= 5)
            return $core->get_Lang("Excellent");
        if ($rateScore >= 4 && $rateScore < 5)
            return $core->get_Lang("Very good");
        if ($rateScore >= 3 && $rateScore < 4)
            return $core->get_Lang("Good");
        if ($rateScore >= 2 && $rateScore < 3)
            return $core->get_Lang("Average");
        if ($rateScore >= 2 && $rateScore < 1)
            return $core->get_Lang("Poor");
        if ($rateScore >= 1 && $rateScore > 0)
            return $core->get_Lang("Terrible");
        if ($rateScore <= 0)
            return $core->get_Lang("No reviews");
    }

    function getRateProcess($rate = 0, $table_id = 0, $mod = '')
    {
        global $core;
        $totalReview = $this->getToTalReview($table_id, $mod);
        $totalReviewOneRate = $this->getToTalReviewByRate($rate, $table_id, $mod);
        $rateProcess = ($totalReviewOneRate ?? 0 / $totalReview ?? 0) * 100;
        return number_format($rateProcess, 0);
    }

    function getRateProcessNoLogin($rate = 0, $table_id = 0, $mod = '')
    {
        global $core;
        $totalReview = $this->getToTalReviewNoLogin($table_id, $mod);
        $totalReviewOneRate = $this->getToTalReviewByRateNoLogin($rate, $table_id, $mod);
        if($totalReview == 0){
            return 0;
        }
        $rateProcess = ($totalReviewOneRate / $totalReview) * 100;
        return number_format($rateProcess, 0);
    }

    function getTextRate($cruise_id = 0)
    {
        global $core;
        $rateScore = $this->getRateAvg($cruise_id);
        if ($rateScore >= 5)
            return $core->get_Lang("Excellent");
        if ($rateScore >= 4 && $rateScore < 5)
            return $core->get_Lang("Very good");
        if ($rateScore >= 3 && $rateScore < 4)
            return $core->get_Lang("Good");
        if ($rateScore >= 2 && $rateScore < 3)
            return $core->get_Lang("Average");
        if ($rateScore >= 2 && $rateScore < 1)
            return $core->get_Lang("Poor");
        if ($rateScore >= 1 && $rateScore > 0)
            return $core->get_Lang("Terrible");
        if ($rateScore <= 0)
            return $core->get_Lang("No reviews");
    }


    function getTextRateAvg($table_id = 0, $type = '')
    {
        global $core, $clsISO;
        $rateScore = $this->getRateAvg($table_id, $type);
        #
        if ($rateScore >= 5)
            return $core->get_Lang("Excellent");
        if ($rateScore >= 4 && $rateScore < 5)
            return $core->get_Lang("Very good");
        if ($rateScore >= 3 && $rateScore < 4)
            return $core->get_Lang("Good");
        if ($rateScore >= 2 && $rateScore < 3)
            return $core->get_Lang("Average");
        if ($rateScore >= 2 && $rateScore < 1)
            return $core->get_Lang("Poor");
        if ($rateScore >= 1 && $rateScore > 0)
            return $core->get_Lang("Terrible");
        if ($rateScore <= 0)
            return $core->get_Lang("No reviews");
    }

    function getRecommend($table_id = 0, $type = '')
    {
        global $core;
        $rateScore = $this->getRateAvg($table_id, $type);
        $recommend = $rateScore * 20;
        if ($recommend > 0) {
            return number_format($recommend, 0);
        } else {
            return 100;
        }
    }

    function getToTalReviewByTable($table_id = '', $type = '', $avgs = '')
    {
        if ($avgs == 'Excellent') {
            $avgsCheck = ' >= 5';
        } elseif ($avgs == 'Very good') {
            $avgsCheck = ' >= 4 and rates < 5';
        } elseif ($avgs == 'Good') {
            $avgsCheck = ' >= 3 and rates < 4';
        } elseif ($avgs == 'Average') {
            $avgsCheck = ' >= 2 and rates < 3';
        } elseif ($avgs == 'Poor') {
            $avgsCheck = ' >= 1 and rates < 2';
        } elseif ($avgs == 'Terrible') {
            $avgsCheck = ' >= 0.1 and rates < 1';
        } else {
            $avgsCheck = '  = 0';
        }

        if (!empty($table_id)) {
            if (_ISOCMS_CLIENT_LOGIN == 1) {
                return $this->countItem("is_trash=0 and is_online = 1 and table_id='$table_id' and type='$type' and rates  $avgsCheck");
            } else {
                return $this->countItem("is_trash=0 and is_online = 1 and table_id='$table_id' and type='$type' and rates  $avgsCheck");
            }
        }

        return 0;
    }

    function getToTalReviewByTableNoLogin($table_id = '', $type = '', $avgs = '')
    {
        if ($avgs == 'Excellent') {
            $avgsCheck = ' >= 5';
        } elseif ($avgs == 'Very good') {
            $avgsCheck = ' >= 4 and rates < 5';
        } elseif ($avgs == 'Good') {
            $avgsCheck = ' >= 3 and rates < 4';
        } elseif ($avgs == 'Average') {
            $avgsCheck = ' >= 2 and rates < 3';
        } elseif ($avgs == 'Poor') {
            $avgsCheck = ' >= 1 and rates < 2';
        } elseif ($avgs == 'Terrible') {
            $avgsCheck = ' >= 0.1 and rates < 1';
        } else {
            $avgsCheck = '  = 0';
        }

        $allReviews = $this->getAll("is_trash=0 and is_online = 1 and profile_id=0 and table_id='$table_id' and type='$type' and rates  $avgsCheck", $this->pkey);
        return $allReviews ? count($allReviews) : 0;
    }

    function getRateStar($pvalTable = '', $type = '')
    {
        $avgStar = $this->getRateAvg($pvalTable, $type);
        $avg = ($avgStar / 5) * 100;
        return $avg;
    }

    function getStarNew($pvalTable = '', $type = '')
    {
        $avgStar = $this->getRateAvg($pvalTable, $type);
        $avg = ($avgStar / 5) * 100;
        return '<span style="width: ' . $avg . '%;"></span>';
    }

    function getStarNewNoLogin($pvalTable = '', $type = '')
    {
        $avgStar = $this->getRateAvgNoLogin($pvalTable, $type);
        $avg = ($avgStar / 5) * 100;
        return '<span style="width: ' . $avg . '%;"></span>';
    }

    function getStarNewIcon($pvalTable = '', $type = '')
    {
        global $clsISO;
        #
        $star_avg = $this->getRateAvg($pvalTable, $type);
        $star_percent = ($star_avg / 5) * 100;
        #
        $html = '';
        $html .= '
            <div class="hnv_rating_star">
                <span class="hnv_rating_star_list">';
        for ($i = 1; $i <= 5; $i++) {
            $html .= '<i class="fa-thin fa-star" aria-hidden="true"></i>';
        }
        $html .= '
                </span>
                <span class="hnv_rating_star_list hnv_rating_star_list_absolute" style="width: ' . $star_percent . '%">';
        for ($i = 1; $i <= 5; $i++) {
            $html .= '<i class="fa-solid fa-star" aria-hidden="true"></i>';
        }
        $html .= '
                </span>
            </div>
        ';
        $html .= '
            <style>
                .hnv_rating_star {
                    position: relative;
                }
                .hnv_rating_star_list {
                    color: #ffd012 !important;
                }
                .hnv_rating_star_list_absolute {
                    position: absolute;
                    top: 50%;
                    transform: translateY(-50%);
                    left: 0;
                    display: flex;
                    background: #ffd012;
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                }
            </style>
        ';
        #
        return $html;
    }

    function getStarNewIconNoLogin($pvalTable = '', $type = '')
    {
        global $clsISO;
        #
        $star_avg = $this->getRateAvgNologin($pvalTable, $type);
        $star_percent = ($star_avg / 5) * 100;
        #
        $html = '';
        $html .= '
            <div class="hnv_rating_star">
                <span class="hnv_rating_star_list">';
        for ($i = 1; $i <= 5; $i++) {
            $html .= '<i class="fa-thin fa-star" aria-hidden="true"></i>';
        }
        $html .= '
                </span>
                <span class="hnv_rating_star_list hnv_rating_star_list_absolute" style="width: ' . $star_percent . '%">';
        for ($i = 1; $i <= 5; $i++) {
            $html .= '<i class="fa-solid fa-star" aria-hidden="true"></i>';
        }
        $html .= '
                </span>
            </div>
        ';
        $html .= '
            <style>
                .hnv_rating_star {
                    position: relative;
                }
                .hnv_rating_star_list {
                    color: #ffd012 !important;
                }
                .hnv_rating_star_list_absolute {
                    position: absolute;
                    top: 50%;
                    transform: translateY(-50%);
                    left: 0;
                    display: flex;
                    background: #ffd012;
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                }
            </style>
        ';
        #
        return $html;
    }

    function getStarCatNew($tourcat_id = 0, $type = '')
    {
        $avgStar = $this->getRateCatAvg($tourcat_id, $type);
        $avg = ($avgStar / 5) * 100;
        return '<span style="width: ' . $avg . '%;"></span>';
    }

    function getStarGroupNew($tour_group_id = 0, $type = '')
    {
        $avgStar = $this->getRateGroupAvg($tour_group_id, $type);
        $avg = ($avgStar / 5) * 100;
        return '<span style="width: ' . $avg . '%;"></span>';
    }

    function getStarCountryNew($country_id = 0, $type = '')
    {
        $avgStar = $this->getRateCountryAvg($country_id, $type);
        $avg = ($avgStar / 5) * 100;
        return '<span style="width: ' . $avg . '%;"></span>';
    }

    function getStarCityNew($city_id = 0, $type = '')
    {
        $avgStar = $this->getRateCityAvg($city_id, $type);
        $avg = ($avgStar / 5) * 100;
        return '<span style="width: ' . $avg . '%;"></span>';
    }

    function getCountry_id($pvalTable = 0, $one = null)
    {
        if (!isset($one['country_id'])) {
            $one = $this->getOne($pvalTable, 'country_id');
        }
        return $one['country_id'];
    }

    function getCountry($pvalTable = 0, $one = null)
    {
        global $_LANG_ID;
        $clsCountry = new _Country();
        if (!isset($one['country_id'])) {
            $one = $this->getOne($pvalTable, 'country_id,title');
        }
        return $clsCountry->getTitle($one['country_id'], $one);
    }

    function getListType()
    {
        global $core, $package_id, $clsISO;
        $listType = array();
        if ($clsISO->getCheckActiveModulePackage($package_id, 'reviews', 'default', 'default', 'tour')) {
            $listType['tour'] = $core->get_Lang('Tours');
        }
        if ($clsISO->getCheckActiveModulePackage($package_id, 'reviews', 'default', 'default', 'voucher')) {
            $listType['voucher'] = $core->get_Lang('Voucher');
        }
        if ($clsISO->getCheckActiveModulePackage($package_id, 'reviews', 'default', 'default', 'cruise')) {
            $listType['cruise'] = $core->get_Lang('Cruises');
        }
        if ($clsISO->getCheckActiveModulePackage($package_id, 'reviews', 'default', 'default', 'hotel')) {
            $listType['hotel'] = $core->get_Lang('Hotels');
        }
        return $listType;
    }

    function getNameService($pvalTable = 0)
    {
        global $core;
        $clsTour = new Tour();
        $clsCruise = new Cruise();
        $clsVoucher = new Voucher();
        $clsHotel = new Hotel();
        $one = $this->getOne($pvalTable);
        if ($one['type'] == 'tour') {
            return $clsTour->getTitle($one['table_id']);
        } elseif ($one['type'] == 'cruise') {
            return $clsCruise->getTitle($one['table_id']);
        } elseif ($one['type'] == 'voucher') {
            return $clsVoucher->getTitle($one['table_id']);
        } elseif ($one['type'] == 'hotel') {
            return $clsHotel->getTitle($one['table_id']);
        }
    }

    function getLinkService($pvalTable = 0)
    {
        global $core, $DOMAIN_NAME, $extLang;
        $clsTour = new Tour();
        $clsCruise = new Cruise();
        $clsVoucher = new Voucher();
        $one = $this->getOne($pvalTable);
        if ($one['type'] == 'tour') {
            return DOMAIN_NAME . $clsTour->getLink($one['table_id']);
        } elseif ($one['type'] == 'cruise') {
            return DOMAIN_NAME . $clsCruise->getLink($one['table_id']);
        } elseif ($one['type'] == 'voucher') {
            return DOMAIN_NAME . $clsVoucher->getLink($one['table_id']);
        }
    }

    function getTextByType($selected = '')
    {
        $lstType = $this->getListType();
        return $lstType[$selected];
    }

    function getSelectByType($selected = '')
    {
        global $core, $package_id, $clsISO;
        #
        $lstType = $this->getListType();
        $html = '';
        foreach ($lstType as $key => $val) {
            $selected_index = ($selected == $key) ? 'selected="selected"' : '';
            $html .= '<option value="' . $key . '" ' . $selected_index . '>' . $val . '</option>';
        }
        return $html;
    }

    function getSelectRankByType($selected = '', $type = '')
    {
        global $core, $package_id, $clsISO;
        #

        $html = '';
        if ($type == "tour" || $type == 'voucher') {
            for ($i = 1; $i <= 5; $i++) {
                $selected_index = ($selected == $i) ? 'selected="selected"' : '';
                $html .= '<option value="' . $i . '" ' . $selected_index . '>' . ($i . ' ' . $core->get_Lang('star')) . '</option>';
            }
        } else {
            for ($i = 1; $i <= 5; $i++) {
                $selected_index = ($selected == $i) ? 'selected="selected"' : '';
                $html .= '<option value="' . $i . '" ' . $selected_index . '>' . ($i . ' ' . $core->get_Lang('star')) . '</option>';
            }
        }
        return $html;
    }

    function getToTalReviewBackup($cruise_id = 0)
    {
        $clsReviewsCruise = new ReviewsCruise();
        return $clsReviewsCruise->getToTalReview($cruise_id);
    }

    function getToTalReview($table_id = 0, $type = '')
    {
        if (_ISOCMS_CLIENT_LOGIN == 1) {
            if ($type != '' && $table_id > 0) {
                return $this->countItem("is_trash=0 and is_online=1 and table_id = '$table_id' and type='$type'");
            } else {
                return $this->countItem("is_trash=0 and is_online=1");
            }
        } else {
            if ($type != '' && $table_id > 0) {
                return $this->countItem("is_trash=0 and is_online=1 and table_id = '$table_id' and type='$type'");
            } else {
                return $this->countItem("is_trash=0 and is_online=1");
            }
        }
    }

    function getToTalReviewNoLogin($table_id = 0, $type = '')
    {
        global $clsISO;

        if ($type != '' && $table_id > 0) {
            $allReviews = $this->getAll("is_trash=0 and is_online=1 and table_id = '$table_id' and type='$type'");

            return $allReviews ? count($allReviews) : 0;
        } else {
            $allReviews = $this->getAll("is_trash=0 and is_online=1");
            return $allReviews ? count($allReviews) : 0;
        }
    }

    function getTotalReviewByRate($rate = 0, $table_id = 0, $type = '')
    {
        if (_ISOCMS_CLIENT_LOGIN == 1) {
            if ($type != '' && $table_id > 0) {
                return $this->countItem("is_trash=0 and is_online=1 and table_id = '$table_id' and rates='$rate' and type='$type'");
            } else {
                return $this->countItem("is_trash=0 and is_online=1 and rates='$rate'");
            }
        } else {
            if ($type != '' && $table_id > 0) {
                return $this->countItem("is_trash=0 and is_online=1 and table_id = '$table_id' and rates='$rate' and type='$type'");
            } else {
                return $this->countItem("is_trash=0 and is_online=1 and rates='$rate'");
            }
        }
    }

    function getTotalReviewByRateNoLogin($rate = 0, $table_id = 0, $type = '')
    {

        if ($type != '' && $table_id > 0) {
            $allReviews = $this->getAll("is_trash=0 and is_online=1 and table_id = '$table_id' and rates='$rate' and type='$type'");
            return $allReviews ? count($allReviews) : 0;
        } else {
            $allReviews = $this->getAll("is_trash=0 and is_online=1 and rates='$rate'");
            return $allReviews ? count($allReviews) : 0;
        }
    }

    function getToTalReviewCat($cat_id = 0, $type = '')
    {
        if ($type == 'tour') {
            return $this->countItem("is_trash=0 and is_online=1 and table_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour where is_trash=0 and is_online=1 and list_cat_id like '%|" . $cat_id . "|%') and type='$type'");
        } else {
            return $this->countItem("is_trash=0 and is_online=1 and table_id IN (SELECT cruise_id FROM " . DB_PREFIX . "cruise where is_trash=0 and is_online=1 and list_cat_id like '%|" . $cat_id . "|%') and type='$type'");
        }
    }

    function getToTalReviewByGroup($tour_group_id = 0, $type = '')
    {
        if ($type == 'tour') {
            $cond = "is_trash=0 and is_online=1 and table_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour where is_trash=0 and is_online=1 and tour_group_id='$tour_group_id') and type='$type'";
            return $this->getAll($cond) ? count($this->getAll($cond)) : 0;
        } else {
            $cond = "is_trash=0 and is_online=1 and table_id IN (SELECT cruise_id FROM " . DB_PREFIX . "cruise where is_trash=0 and is_online=1 and tour_group_id='$tour_group_id') and type='$type'";
            return $this->getAll($cond) ? count($this->getAll($cond)) : 0;
        }
    }

    function getToTalReviewByCountry($country_id = 0, $type = '')
    {
        if ($type == 'tour') {
            $cond = "is_trash=0 and is_online=1 and table_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour where is_trash=0 and is_online=1) and table_id IN(SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE is_trash=0 and country_id='$country_id') and type='$type'";
            return $this->getAll($cond) ? count($this->getAll($cond)) : 0;
        } else {
            $cond = "is_trash=0 and is_online=1 and table_id IN (SELECT cruise_id FROM " . DB_PREFIX . "cruise where is_trash=0 and is_online=1) and table_id IN(SELECT tour_id FROM " . DB_PREFIX . "cruise_destination WHERE is_trash=0 and country_id='$country_id') and type='$type'";
            return $this->getAll($cond) ? count($this->getAll($cond)) : 0;
        }
    }

    function getToTalReviewByCity($city_id = 0, $type = '')
    {
        if ($type == 'tour') {
            $cond = "is_trash=0 and is_online=1 and table_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour where is_trash=0 and is_online=1) and table_id IN(SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE is_trash=0 and city_id='$city_id') and type='$type'";
            return $this->getAll($cond) ? count($this->getAll($cond)) : 0;
        } else {
            $cond = "is_trash=0 and is_online=1 and table_id IN (SELECT cruise_id FROM " . DB_PREFIX . "cruise where is_trash=0 and is_online=1) and table_id IN(SELECT tour_id FROM " . DB_PREFIX . "cruise_destination WHERE is_trash=0 and city_id='$city_id') and type='$type'";
            return $this->getAll($cond) ? count($this->getAll($cond)) : 0;
        }
    }

    function getRateScore($cruise_id = 0)
    {
        return $this->countItem("table_id = '$cruise_id'");
    }

    function getRateAvg($table_id = '', $type = '', $typeScore = 5)
    {
        global $dbconn, $clsISO;
        if ($type != '' && $table_id > 0) {
            $res = $dbconn->getRow("SELECT AVG(rates) as rates FROM default_reviews WHERE is_online=1 and is_trash=0 and table_id = '$table_id' and type='$type'");
        } else {
            $res = $dbconn->getRow("SELECT AVG(rates) as rates FROM default_reviews WHERE is_online=1 and is_trash=0");
        }
        $rates = $res['rates'] ?? 0;
        if ($rates != 0) {

            if ($typeScore == '10') {
                return number_format($rates  * 2, 1);
            }
            return number_format($rates, 1);
        }

        return $rates;
    }

function getRateAvgNoLogin(
    $table_id = 0,
    $type = '',
    $typeScore = 5
) {
    global $dbconn;

    $table_id = (int) $table_id;
    $type = preg_replace(
        '/[^a-zA-Z0-9_]/',
        '',
        trim((string) $type)
    );

    $cond = "
        is_online = 1
        AND is_trash = 0
        AND profile_id = 0
    ";

    if ($table_id > 0 && $type !== '') {
        $cond .= "
            AND table_id = '{$table_id}'
            AND type = '{$type}'
        ";
    }

    /*
     * COALESCE đảm bảo AVG không trả NULL
     * khi chưa có đánh giá.
     */
    $res = $dbconn->getAll("
        SELECT COALESCE(AVG(rates), 0) AS rates
        FROM default_reviews
        WHERE {$cond}
    ");

    $rate = 0.0;

    if (
        is_array($res)
        && isset($res[0])
        && isset($res[0]['rates'])
        && is_numeric($res[0]['rates'])
    ) {
        $rate = (float) $res[0]['rates'];
    }

    if ((int) $typeScore === 10) {
        $rate *= 2;
    }

    return number_format(
        $rate,
        1,
        '.',
        ''
    );
}
    function fetchAvgRating($table_id = 0, $type = '')
    {
        global $dbconn;
        $res = $dbconn->getAll("SELECT AVG(rates) as rates FROM default_reviews WHERE is_online=1 and is_trash=0 and table_id = '$table_id' and type='$type'");
        return number_format($res[0]['rates'] ?? 0, 1);
    }

    function getBestRate($table_id = 0, $type = '')
    {
        if ($type != '' && $table_id > 0) {
            $one = $this->getByCond("is_trash=0 and is_online=1 and table_id='$table_id' and type='$type' order by rates desc limit 0,1", $this->pkey . ",rates");
        } else {
            $one = $this->getByCond("is_trash=0 and is_online=1 order by rates desc limit 0,1", $this->pkey . ", rates");
        }
        return !empty($one) ? $one['rates'] : 0;
    }

    function getRateCatAvg($cat_id = 0, $type = '')
    {
        global $dbconn;
        if ($type == 'tour') {
            $res = $dbconn->getAll("SELECT AVG(rates) as rates FROM default_reviews WHERE is_online=1 and is_trash=0 and table_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour where is_trash=0 and is_online=1 and list_cat_id like '%|" . $cat_id . "|%') and type='$type'");
        } else {
            $res = $dbconn->getAll("SELECT AVG(rates) as rates FROM default_reviews WHERE is_online=1 and is_trash=0 and table_id IN (SELECT cruise_id FROM " . DB_PREFIX . "cruise where is_trash=0 and is_online=1 and list_cat_id like '%|" . $cat_id . "|%') and type='$type'");
        }
        return number_format($res[0]['rates'], 1);
    }

    function getRateGroupAvg($tour_group_id = 0, $type = '')
    {
        global $dbconn;
        if ($type == 'tour') {
            $res = $dbconn->getAll("SELECT AVG(rates) as rates FROM default_reviews WHERE is_online=1 and is_trash=0 and table_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour where is_trash=0 and is_online=1 and tour_group_id='$tour_group_id') and type='$type'");
        } else {
            $res = $dbconn->getAll("SELECT AVG(rates) as rates FROM default_reviews WHERE is_online=1 and is_trash=0 and table_id IN (SELECT cruise_id FROM " . DB_PREFIX . "cruise where is_trash=0 and is_online=1 and tour_group_id='$tour_group_id') and type='$type'");
        }
        return number_format($res[0]['rates'], 1);
    }

    function getRateCountryAvg($country_id = 0, $type = '')
    {
        global $dbconn;
        if ($type == 'tour') {
            $res = $dbconn->getAll("SELECT AVG(rates) as rates FROM default_reviews WHERE is_online=1 and is_trash=0 and table_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour where is_trash=0 and is_online=1) and table_id IN(SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE is_trash=0 and country_id='$country_id') and type='$type'");
        } else {
            $res = $dbconn->getAll("SELECT AVG(rates) as rates FROM default_reviews WHERE is_online=1 and is_trash=0 and table_id IN (SELECT cruise_id FROM " . DB_PREFIX . "cruise where is_trash=0 and is_online=1) and table_id IN(SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE is_trash=0 and country_id='$country_id') and type='$type'");
        }
        return number_format($res[0]['rates'], 1);
    }

    function getRateCityAvg($city_id = 0, $type = '')
    {
        global $dbconn;
        if ($type == 'tour') {
            $res = $dbconn->getAll("SELECT AVG(rates) as rates FROM default_reviews WHERE is_online=1 and is_trash=0 and table_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour where is_trash=0 and is_online=1) and table_id IN(SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE is_trash=0 and city_id='$city_id') and type='$type'");
        } else {
            $res = $dbconn->getAll("SELECT AVG(rates) as rates FROM default_reviews WHERE is_online=1 and is_trash=0 and table_id IN (SELECT cruise_id FROM " . DB_PREFIX . "cruise where is_trash=0 and is_online=1) and table_id IN(SELECT tour_id FROM " . DB_PREFIX . "tour_destination WHERE is_trash=0 and city_id='$city_id') and type='$type'");
        }
        return number_format($res[0]['rates'], 1);
    }

    function getBestRateCat($cat_id = 0, $type = '')
    {
        if ($type == 'tour') {
            $one = $this->getAll("is_trash=0 and is_online=1 and table_id IN (SELECT tour_id FROM " . DB_PREFIX . "tour where is_trash=0 and is_online=1 and list_cat_id like '%|" . $cat_id . "|%') and type='$type' order by rates desc limit 0,1", $this->pkey, "rates");
        } else {
            $one = $this->getAll("is_trash=0 and is_online=1 and table_id IN (SELECT cruise_id FROM " . DB_PREFIX . "cruise where is_trash=0 and is_online=1 and list_cat_id like '%|" . $cat_id . "|%') and type='$type' order by rates desc limit 0,1", $this->pkey, "rates");
        }

        return $one[0]['rates'];
    }

    function doDelete($pvalTable = 0)
    {
        // Delete
        $this->deleteOne($pvalTable);
        $clsImage = new Image();
        $listImages = $this->getReviewImages($pvalTable);
        foreach ($listImages as $img) {
            $clsImage->deleteOne($img['image_id']);
            $file_path =  $_SERVER['DOCUMENT_ROOT'] . $img['image'];

            if (is_file($file_path)) {
                @unlink($file_path);
            }
        }
        return 1;
    }

    function sendMail_bak($email = '', $mes = '', $type = '')
    {
        global $core, $clsISO, $clsConfiguration, $_LANG_ID, $email_template_review_tour_id, $email_template_review_cruise_id;
        #
        $clsEmailTemplate = new EmailTemplate();
        #
        if ($type == 'tour') {
            $email_template_id = $email_template_review_tour_id;
        } else {
            $email_template_id = $email_template_review_cruise_id;
        }

        #
        header('Content-Type: text/html; charset=utf-8');
        $message = $clsEmailTemplate->getContent($email_template_id);
        $message = str_replace('[%PAGE_NAME%]', PAGE_NAME, $message);
        $message = str_replace('{URL}', 'http://' . $_SERVER['HTTP_HOST'], $message);
        $message = str_replace('[%CUSTOMER_EMAIL%]', $email, $message);
        $message = str_replace('[%CUSTOMER_MES%]', $mes, $message);
        $message = str_replace('[%CUSTOMER_FULLNAME%]', $email, $message);


        $message = str_replace('[%COMPANY_HOTLINE%]', $clsConfiguration->getValue('CompanyHotline'), $message);
        $message = str_replace('[%COMPANY_EMAIL%]', $clsConfiguration->getValue('CompanyEmail'), $message);
        $message = str_replace('[%COMPANY_NAME%]', $clsConfiguration->getValue('CompanyName_' . $_LANG_ID), $message);
        $message = str_replace('[%COMPANY_ADDRESS%]', $clsConfiguration->getValue('CompanyAddress_' . $_LANG_ID), $message);
        $message = str_replace('[%COMPANY_PHONE%]', $clsConfiguration->getValue('CompanyPhone'), $message);
        $message = str_replace('[%COMPANY_FAX%]', $clsConfiguration->getValue('CompanyFax'), $message);
        $message = str_replace('[%COMPANY_WEBSITE%]', DOMAIN_NAME, $message);
        $message = str_replace('[%info_social%]', $clsConfiguration->getHTMLSocial(), $message);
        $message = str_replace('[%info_license%]', $clsConfiguration->getValue('GPKD'), $message);
        $message = str_replace('[%DOMAIN_NAME%]', DOMAIN_NAME, $message);
        $message = str_replace('[%DATETIME%]', date('Y', time()), $message);

        #

        $from = $clsEmailTemplate->getFromEmail($email_template_id);

        $owner = $clsEmailTemplate->getFromName($email_template_id);
        $to = $email;
        $subject = $clsEmailTemplate->getSubject($email_template_id) . ' ' . PAGE_NAME;
        $subject = str_replace('[%PAGE_NAME%]', '', $subject);

        $is_send_email = $clsISO->sendEmail($from, $to, $subject, $message, $owner);

        $to = $clsEmailTemplate->getCopyTo($email_template_id);
        if (!empty($to)) {
            $owner = $clsEmailTemplate->getFromName($email_template_id);
            $subject = $clsEmailTemplate->getSubject($email_template_id) . ' ' . PAGE_NAME;
            $subject = str_replace('[%PAGE_NAME%]', '', $subject);
            //		$is_send_email = $clsISO->sendEmail($from,$to,$subject,$message,$owner);
            $lstto = explode(',', $to);
            foreach ($lstto as $it) {
                $multi_email = trim($it);
                if ($multi_email) {
                    $is_send_email = $clsISO->sendEmail($from, $multi_email, $subject, $message, $owner);
                    continue;
                }
            }
        }

        return 1;
    }

    function sendMail($email = '', $reviews_id = 0, $type = '', $mes = '')
    {
        global $core, $clsISO, $clsConfiguration, $_LANG_ID, $email_template_review_tour_id, $email_template_review_cruise_id;
        #
        $clsEmailTemplate = new EmailTemplate();

        $reviews = $this->getOne($reviews_id);
        $title = '';
        $urlNew = '';
        if ($type == 'tour') {
            $clsTour = new Tour();
            $title = $clsTour->getTitle($reviews['table_id']);
            $urlNew = DOMAIN_URL . $clsTour->getLink($reviews['table_id']);
        } else if ($type == 'cruise') {
            $clsCruise = new Cruise();
            $title = $clsCruise->getTitle($reviews['table_id']);
            $urlNew = DOMAIN_URL . $clsCruise->getLink($reviews['table_id']);
        } else if ($type == 'voucher') {
            $clsVoucher = new Voucher();
            $title = $clsVoucher->getTitle($reviews['table_id']);
            $urlNew = DOMAIN_URL . $clsVoucher->getLink($reviews['table_id']);
        }
        $CUSTOMER_MES = '';
        $CUSTOMER_MES .= "<br><a target='_blank' rel='nofollow' href=" . $urlNew . "><strong>Link: " . $title . "</strong></a>";

        $CUSTOMER_MES .= "<br><strong>Title:</strong>" . $reviews['title'];

        $mes = str_replace("&lt;br&gt;", "<br />", $mes);

        // Wrap the whole mes in <p> tags
        $mes = "<p>" . str_replace("<br />", "</p><p>", $mes) . "</p>";

        $CUSTOMER_MES .= "<br><strong>Content:</strong>" . $mes . "<br>";

        $list_image = $this->getReviewImages($reviews_id);
        foreach ($list_image as $image) {
            $CUSTOMER_MES .= '<img style="max-width: 100%;height: 150px; margin:10px" src="' . DOMAIN_URL . $image['image'] . '" alt="' . $reviews['title'] . '" width="150" height="150">';
        }

        #
        if ($type == 'tour') {
            $email_template_id = $email_template_review_tour_id;
        } else {
            $email_template_id = $email_template_review_cruise_id;
        }

        #
        header('Content-Type: text/html; charset=utf-8');
        $message = $clsEmailTemplate->getHeader($email_template_id);
        $message .= $clsEmailTemplate->getContent($email_template_id);
        $message .= $clsEmailTemplate->getFooter($email_template_id);

        $message = str_replace('[%PAGE_NAME%]', PAGE_NAME, $message);
        $message = str_replace('{URL}', 'http://' . $_SERVER['HTTP_HOST'], $message);
        $message = str_replace('[%CUSTOMER_EMAIL%]', $email, $message);
        $message = str_replace('[%CUSTOMER_MES%]', $mes, $message);
        $message = str_replace('[%CUSTOMER_FULLNAME%]', $email, $message);


        $message = str_replace('[%COMPANY_HOTLINE%]', $clsConfiguration->getValue('CompanyHotline'), $message);
        $message = str_replace('[%COMPANY_EMAIL%]', $clsConfiguration->getValue('CompanyEmail'), $message);
        $message = str_replace('[%COMPANY_NAME%]', $clsConfiguration->getValue('CompanyName_' . $_LANG_ID), $message);
        $message = str_replace('[%COMPANY_ADDRESS%]', $clsConfiguration->getValue('CompanyAddress_' . $_LANG_ID), $message);
        $message = str_replace('[%COMPANY_PHONE%]', $clsConfiguration->getValue('CompanyPhone'), $message);
        $message = str_replace('[%COMPANY_FAX%]', $clsConfiguration->getValue('CompanyFax'), $message);
        $message = str_replace('[%COMPANY_WEBSITE%]', DOMAIN_NAME, $message);
        $message = str_replace('[%info_social%]', $clsConfiguration->getHTMLSocial(), $message);
        $message = str_replace('[%info_license%]', $clsConfiguration->getValue('GPKD'), $message);
        $message = str_replace('[%DOMAIN_NAME%]', DOMAIN_NAME, $message);
        $message = str_replace('[%DATETIME%]', date('Y', time()), $message);

        #

        $from = $clsEmailTemplate->getFromEmail($email_template_id);

        $owner = $clsEmailTemplate->getFromName($email_template_id);
        $to = $email;
        $subject = $clsEmailTemplate->getSubject($email_template_id) . ' ' . PAGE_NAME;
        $subject = str_replace('[%PAGE_NAME%]', '', $subject);

        $is_send_email = $clsISO->sendEmail($from, $to, $subject, $message, $owner);

        $to = $clsEmailTemplate->getCopyTo($email_template_id);
        if (!empty($to)) {
            $owner = $clsEmailTemplate->getFromName($email_template_id);
            $subject = $clsEmailTemplate->getSubject($email_template_id) . ' ' . PAGE_NAME;
            $subject = str_replace('[%PAGE_NAME%]', '', $subject);
            //		$is_send_email = $clsISO->sendEmail($from,$to,$subject,$message,$owner);
            $lstto = explode(',', $to);
            foreach ($lstto as $it) {
                $multi_email = trim($it);
                if ($multi_email) {
                    $is_send_email = $clsISO->sendEmail($from, $multi_email, $subject, $message, $owner);
                    continue;
                }
            }
        }

        return 1;
    }

    function textName($fullname = '')
    {
        return strtoupper(substr($fullname, 0, 2));
    }

    function getReviewImages($table_id = 0)
    {
        $clsImage = new Image();
        $images = $clsImage->getAll("is_trash = 0 and table_id = $table_id and type = '_REVIEW' order by order_no DESC", $clsImage->pkey . ', image');

        return $images;
    }

    function countArray($array = [])
    {
        return count($array);
    }

    function getReviews($id = 0, $act = '', $type = 'tour')
    {
        global $dbconn, $core;
        $cond = " is_trash = 0 and is_online = 1";

        $arr_txt_review = ["Bad", "Average", "Good", "Excellent", "Wonderful"];
        $txtReview = array_map([$core, "get_Lang"], $arr_txt_review);

        if (!empty($type)) {
            $cond   .=  ' and type = "' . $type . '"';
        }

        $countReview = $this->countItem("$cond and table_id = $id");

        $sqlAverageRate = "SELECT AVG(rates) FROM $this->tbl WHERE $cond and table_id = $id";
        $averageRateRaw = $dbconn->GetOne($sqlAverageRate);

        // Ép kiểu về float và dùng giá trị mặc định 0 nếu null
        $averageRate = round((float)($averageRateRaw ?? 0), 1);

        // Tính index, đảm bảo luôn là số
        $index = round($averageRate - 1);


        switch ($act) {
            // Chữ đánh giá
            case 'txt_review':
                $rec = $txtReview[$index] ?? $core->get_Lang('No review');
                break;

            // Điểm trung bình
            case 'avg_point':
                $rec = number_format($averageRate, 1);
                break;

            // Tổng số review
            default:
                $review = ($countReview > 1) ? $core->get_Lang("reviews") : $core->get_Lang("review");
                $rec = "$countReview $review";
                break;
        }
        return $rec;
    }

    function getPhone($pvalTable = 0, $one = null)
    {
        if (!isset($one['phone'])) {
            $one = $this->getOne($pvalTable, 'phone');
        }
        return $one['phone'];
    }
}
