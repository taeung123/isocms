<?php
#congtech TourReview
class CruiseReview extends dbBasic
{

    function __construct()
    {
        $this->pkey = "reviews_cruise_id";
        $this->tbl = DB_PREFIX . "reviews_cruise";
    }

    function getRegDate($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'reg_date');
        return date('m/d/Y', $one['reg_date']);
    }
    function getStatus($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable . 'is_online');
        $is_online =  $one['is_online'];
        $data_string = " data = '" . $pvalTable . "'";
        if ($is_online == 1) {
            $data_string .= " is_online = '0'";
            return ' <a href="javascrip:void(0)" ' . $data_string . '  class="clickStatusReviews"><i class="fa fa-minus-circle green"></i></a>';
        } else {
            $data_string .= " is_online = '1'";
            return ' <a href="javascrip:void(0)" ' . $data_string . '  class="clickStatusReviews"><i class="fa fa-minus-circle red"></i></a>';
        }
    }
    function getTitle($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'title');
        return $one['title'];
    }
    function cheackStatus($pvalTable = 0)
    {
        global $core;
        $one = $this->getOne($pvalTable);
        $is_online = $one['is_online'];
        $html = '';
        $display_online = $display_off = 'style="display:block;"';
        $time = time();
        if ($is_online == 1) {
            $display_online = 'style="display:none;"';
        }
        if ($is_online == 0) {
            $display_off = 'style="display:none;"';
        }
        $html .= '<div class="vietiso_status_button status_click"></div>
             <span class="notice on_status"  ' . $display_online . '> '
            . $core->get_Lang(' PRIVATE: This article can only be seen via the link in the admin page') .
            '</span>
			<span class="notice off_status" ' . $display_off . ' >
			' . $core->get_Lang(' PUBLIC: This article is available online show normal status') . '</span>
			   <script type="text/javascript">
			   $(".status_click").isoswitchvalue({
                      _value: is_online,
                       _selector: "is_online"
                });
			   	$(".status_click").click(function(){
					if($(this).hasClass("off")){
						 $(".on_status").show();
						 $(".off_status").hide();
					}else{
						  $(".on_status").hide();
						  $(".off_status").show();
				}				
			});
			$(".showdate").datepicker({dateFormat: "dd/mm/yy",	minDate:new Date()});
			   </script>	
			';
        return $html;
    }

    function getFullName($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'fullname');
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

    function getCountry_id($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'country_id');
        return $one['country_id'];
    }

    function getCountry($pvalTable = 0)
    {
        global $_LANG_ID;
        $clsCountry = new _Country();
        $one = $this->getOne($pvalTable);
        return $clsCountry->getTitle($one['country_id']);
    }


    function getSelectByType($selected = '')
    {
        global $core;
        #
        $lstType = $this->getListType();
        $html = '';
        foreach ($lstType as $key => $val) {
            $selected_index = ($selected == $key) ? 'selected="selected"' : '';
            $html .= '<option value="' . $key . '" ' . $selected_index . '>' . $val . '</option>';
        }
        return $html;
    }
    #===========0k> 

    function getRatesCabinQuality($cruise_id = 0, $type = '')
    {
        $one = $this->getOne($cruise_id);
        return $one[$type];
    }
    function getRateScore($cruise_id = 0)
    {
        return $this->countItem("table_id = '$cruise_id'");
    }
    #===========ok>
    function getRateAvg($cruise_id = 0, $value = 0)
    {
        global $dbconn;
        $res = $dbconn->getAll("SELECT AVG(rates) as rates FROM " . $this->tbl . " WHERE table_id = '$cruise_id' and is_trash=0 and is_online = 1");
        if ($value > 0) {
            return $avg = ($res[0]['rates'] / 5) * 100;
        } else {
            return number_format($res[0]['rates'], 1);
        }
    }
    #===========ok>
    function UpdateRateAvg($cruise_id = 0)
    {
        $type = array('food_drink', 'cabin_quality', 'staff_quality', 'entertainment');
        $one = $this->getOne($cruise_id);
        $total = 0;
        $stt = 0;
        foreach ($type as $val) {
            if ($one[$val] > 0) {
                $stt++;
                $total += $one[$val];
            }
        };
        if ($stt > 0 and $total > 0) {
            $avg = $total / $stt;

            return $this->updateOne($cruise_id, "rates = '$avg'");
        }
        return false;
    }
    #===========ok>
    function  get_AVG_ReviewByTable($cruise_id = 0, $type = '', $valu = 0)
    {
        global $dbconn;
        $res = $dbconn->getAll("SELECT AVG($type) as avgs FROM " . $this->tbl . " WHERE  table_id = '$cruise_id' and is_trash=0 and is_online = 1");
        if ($valu > 0) {
            return $avg = ($res[0]['avgs'] / 5) * 100;
        } else {
            return number_format($res[0]['avgs'], 1);
        }
    }
    #===========ok>
    function getTextRateAvg($cruise_id = 0)
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
    #===========ok>
    function getToTalReviewByTable($pvalTable = 0, $avgs = '')
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

        return  $this->countItem("is_trash=0 and is_online = 1 and table_id='$pvalTable' and rates  $avgsCheck");
    }
    #===========ok>
    function getToTalReview($cruise_id = '')
    {
        return $this->countItem("table_id = '$cruise_id' and is_trash=0 and is_online =1");
    }
    #===========ok>
    function getRates($pvalTable = '')
    {
        $one = $this->getOne($pvalTable);
        return $one['rates'];
    }
    #===========ok>
    function getStarNew($pvalTable = '')
    {
        $avgStar = $this->getRateAvg($pvalTable);
        $avg = ($avgStar / 5) * 100;
        return '<span style="width: ' . $avg . '%;"></span>';
    }
    #===========ok>
    function getContent($pvalTable = '', $truncate = true, $limit = 420)
    {
        $one = $this->getOne($pvalTable);
        $string = $one['content'];
        if ($truncate == true) {
            if (strlen($string) < $limit) {
                return $one['content'];
            } else {
                $html = '<div class="clicSeemore"><div class="c_seemore More">';
                $html .= $this->truncate($string, $limit);
                $html .= '<a class="semoreClick"> More </a>';
                $html .= '</div>';
                $html .= '<div class="c_seemore Less">';
                $html .= $string;
                $html .= '<a class="LessClick"> Less </a>';
                $html .= '</div></div>';
                return $html;
            }
        } else {
            return $string;
        }
    }
    #===========ok>

    function getAll($where = '', $sect = '')
    {
        global $dbconn, $extLang;
        if ($where == '') {
            $sect = " 1 = 1";
        }
        if ($sect == '') {
            $sect = " * ";
        }
        return $dbconn->getAll("SELECT " . $sect . " FROM " . $this->tbl . " WHERE  $where");
    }
    function truncate($string = '', $width = 0, $etc = ' ..')
    {
        $wrapped = explode('$trun$', wordwrap($string, $width, '$trun$', false), 2);
        return $wrapped[0] . (isset($wrapped[1]) ? $etc : '');
    }
    function doDelete($pvalTable = 0)
    {
        // Delete
        $this->deleteOne($pvalTable);
        return 1;
    }
}
