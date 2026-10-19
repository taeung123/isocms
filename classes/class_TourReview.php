<?php
#congtech TourReview
class TourReview extends dbBasic
{

    function __construct()
    {
        $this->pkey = "review_tour_id";
        $this->tbl = DB_PREFIX . "reviews_tour";
    }

    function getRegDate($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable);
        return date('m/d/Y', $one['reg_date']);
    }
    function getStatus($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable);
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
        $one = $this->getOne($pvalTable);
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
			   $(".vietiso_status_button").isoswitchvalue({
                      _value: is_online,
                       _selector: "iso-is_online"
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
        $one = $this->getOne($pvalTable);
        return $one['fullname'];
    }
    function getEmail($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable);
        return $one['email'];
    }
    function getReview_date($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable);
        return $one['review_date'];
    }
    function getCountry_id($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable);
        return $one['country_id'];
    }

    function getCountry($pvalTable = 0)
    {
        global $_LANG_ID;
        $clsCountry = new _Country();
        $one = $this->getOne($pvalTable);
        return $clsCountry->getTitle($one['country_id']);
    }
    function getListType()
    {
        global $core;
        $listType = array();
        $listType['Tour'] = $core->get_Lang('Tours');
        $listType['Cruise'] = $core->get_Lang('Cruises');
        return $listType;
    }
    function getTextByType($selected = '')
    {
        $lstType = $this->getListType();
        return $lstType[$selected];
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

    function getRateScore($cruise_id = 0)
    {
        return $this->countItem("table_id = '$cruise_id'");
    }
    #===========ok>
    function getRateAvg($cruise_id = 0)
    {
        global $dbconn;
        $res = $dbconn->getAll("SELECT AVG(rates) as rates FROM " . $this->tbl . " WHERE  table_id = '$cruise_id' and is_trash=0 and is_online = 1");
        return number_format($res[0]['rates'], 1);
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
    function getToTalReviewByTable($pvalTable = '', $avgs)
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
        return $this->countItem("table_id = '$cruise_id' and is_trash=0  and is_online = 1");
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
    function truncate($string, $width, $etc = ' ..')
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
