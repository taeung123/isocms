<?php

class ReviewsHotel extends dbBasic
{
    function __construct()
    {
        global $_LANG_ID;
        $this->pkey = "reviews_hotel_id";
        $this->tbl = DB_PREFIX . "reviews_hotel";
    }

    function checkExits($hotel_id = 0)
    {
        $res = $this->getAll("hotel_id = '$hotel_id' limit 0,1");
        return !empty($res) ? 1 : 0;
    }

    function getIdByHotel($hotel_id = 0)
    {
        $res = $this->getAll("hotel_id = '$hotel_id' limit 0,1");
        return $res[0][$this->pkey];
    }

    function getValueByField($hotel_id = 0, $field = '')
    {
        $res = $this->getAll("hotel_id = '$hotel_id' limit 0,1");
        return $res[0][$field] ?? 0;
    }

    function getToTalReview($hotel_id = 0)
    {
        $res = $this->getAll("hotel_id = '$hotel_id' limit 0,1");
        $totalReview = 0;
        if (!empty($res)) {
            $totalReview = ($res[0]['excellent']) + ($res[0]['very_good']) + ($res[0]['good']) + ($res[0]['average']) + ($res[0]['poor']) + ($res[0]['terrible']);
        }
        return $totalReview;
    }

    function getRateScore($hotel_id = 0, $is_val = false)
    {
        $res = $this->getAll("hotel_id = '$hotel_id' limit 0,1");
        $rateScore = 0;
        if (!empty($res)) {
            $totalScore = ($res[0]['staff']) + ($res[0]['amenities']) + ($res[0]['clean']) + ($res[0]['place']) + ($res[0]['food_drink']) + ($res[0]['worthy']);
            $rateScore = round(($totalScore / 10) / 5, 1);
            if ($is_val) {
                $rateScore = $rateScore;
            } else {
                $rateScore = $rateScore . '/10';
            }
        }
        return $rateScore;
    }

    function _getRateScoreStar($hotel_id = 0, $is_val = false)
    {
        $res = $this->getAll("hotel_id = '$hotel_id' limit 0,1");
        $rateScore = 0;
        if (!empty($res)) {
            $totalScore = ($res[0]['staff']) + ($res[0]['amenities']) + ($res[0]['clean']) + ($res[0]['place']) + ($res[0]['food_drink']) + ($res[0]['worthy']);
            $rateScore = $totalScore / 5;
        }
        return $rateScore;
    }

    function getRateScoreStar($hotel_id = 0, $is_val = false)
    {
        global $core, $dbconn;
        $clsReviews = new Reviews();
        $SQL = "SELECT Avg(rates) FROM " . DB_PREFIX . "reviews WHERE is_trash=0 and is_online=1 and type='Hotel'  and table_id = '$hotel_id'";
        $rateScore = $dbconn->GetOne($SQL);
        $rateScore = round(($rateScore), 1);
        return $rateScore * 10 * 2;
    }

    function getRateScoreHotel($hotel_id = 0, $is_val = false)
    {
        $res = $this->getAll("hotel_id = '$hotel_id' limit 0,1");
        $rateScore = 0;
        if (!empty($res)) {
            $totalScore = ($res[0]['staff']) + ($res[0]['amenities']) + ($res[0]['clean']) + ($res[0]['place']) + ($res[0]['food_drink']) + ($res[0]['worthy']);
            $rateScore = round(($totalScore / 10) / 5, 1);
        }
        return $rateScore;
    }

    function getTextRate($hotel_id = 0)
    {
        global $core;
        $res = $this->getAll("hotel_id = '$hotel_id' limit 0,1");
        $rateScore = 0;

        if (!empty($res)) {
            $totalScore = ($res[0]['staff']) + ($res[0]['amenities']) + ($res[0]['clean']) + ($res[0]['place']) + ($res[0]['food_drink']) + ($res[0]['worthy']);
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
