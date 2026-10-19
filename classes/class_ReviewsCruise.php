<?php

class ReviewsCruise extends dbBasic
{

    function __construct()
    {

        global $_LANG_ID;

        $this->pkey = "reviews_cruise_id";

        $this->tbl = DB_PREFIX . "reviews_cruise";
    }

    function checkExits($cruise_id = 0)
    {

        $res = $this->getAll("cruise_id = '$cruise_id' limit 0,1");

        return !empty($res) ? 1 : 0;
    }

    function getIdByCruise($cruise_id = 0)
    {

        $res = $this->getAll("cruise_id = '$cruise_id' limit 0,1");

        return $res[0][$this->pkey];
    }

    function getValueByField($cruise_id = 0, $field = '')
    {

        $res = $this->getAll("cruise_id = '$cruise_id' limit 0,1");

        return $res[0][$field];
    }

    function getToTalReview($cruise_id = 0)
    {

        $res = $this->getAll("cruise_id = '$cruise_id' limit 0,1");

        $totalReview = 0;

        if (!empty($res)) {

            $totalReview = ($res[0]['excellent']) + ($res[0]['very_good']) + ($res[0]['good']) + ($res[0]['average']) + ($res[0]['poor']) + ($res[0]['terrible']);
        }

        return $totalReview;
    }

    function getRateScore($cruise_id = 0, $is_val = false)
    {

        $res = $this->getAll("cruise_id = '$cruise_id' limit 0,1");

        $rateScore = 0;

        if (!empty($res)) {

            $totalScore = ($res[0]['cruise_quality']) + ($res[0]['food_drink']) + ($res[0]['cabin_quality']) + ($res[0]['staff_quality']) + ($res[0]['entertainment']);

            $rateScore = round(($totalScore / 10) / 5, 1);

            if ($is_val) {

                $rateScore = $rateScore;
            } else {

                $rateScore = $rateScore . '/10';
            }
        }

        return $rateScore;
    }

    function _getRateScoreStar($cruise_id = 0, $is_val = false)
    {

        $res = $this->getAll("cruise_id = '$cruise_id' limit 0,1");

        $rateScore = 0;

        if (!empty($res)) {

            $totalScore = ($res[0]['cruise_quality']) + ($res[0]['food_drink']) + ($res[0]['cabin_quality']) + ($res[0]['staff_quality']) + ($res[0]['entertainment']);

            $rateScore = $totalScore / 5;
        }

        return $rateScore;
    }

    function getRateScoreStar($tour_id = 0, $is_val = false)
    {

        global $core, $dbconn;

        $clsReviews = new Reviews();

        $SQL = "SELECT Avg(rates) FROM " . DB_PREFIX . "reviews WHERE is_trash=0 and is_online=1 and type='Cruise'  and table_id = '$tour_id'";

        $rateScore = $dbconn->GetOne($SQL);

        $rateScore = round(($rateScore), 1);

        return $rateScore * 10 * 2;
    }

    function getRateScoreCruise($cruise_id = 0, $is_val = false)
    {

        $res = $this->getAll("cruise_id = '$cruise_id' limit 0,1");

        $rateScore = 0;

        if (!empty($res)) {

            $totalScore = ($res[0]['cruise_quality']) + ($res[0]['food_drink']) + ($res[0]['cabin_quality']) + ($res[0]['staff_quality']) + ($res[0]['entertainment']);

            $rateScore = round(($totalScore / 10) / 5, 1);
        }

        return $rateScore;
    }

    function getTextRate($cruise_id = 0)
    {

        global $core;

        $res = $this->getAll("cruise_id = '$cruise_id' limit 0,1");

        $rateScore = 0;

        if (!empty($res)) {

            $totalScore = ($res[0]['cruise_quality']) + ($res[0]['food_drink']) + ($res[0]['cabin_quality']) + ($res[0]['staff_quality']) + ($res[0]['entertainment']);

            $rateScore = round(($totalScore / 10) / 5, 1);

            if ($rateScore >= 9)

                return $core->get_Lang("Excellent");

            if ($rateScore >= 8 && $rateScore < 9)

                return $core->get_Lang("Very good");

            if ($rateScore >= 7 && $rateScore < 8)

                return $core->get_Lang("Good");

            if ($rateScore >= 5 && $rateScore < 7)

                return $core->get_Lang("Average");

            if ($rateScore >= 3 && $rateScore < 5)

                return $core->get_Lang("Poor");

            if ($rateScore < 3)

                return $core->get_Lang("Terrible");
        }
    }
}
