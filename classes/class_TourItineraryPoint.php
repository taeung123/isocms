<?php
class TourItineraryPoint extends dbBasic
{
    function __construct()
    {
        $this->pkey = "tour_itinerary_point_id";
        $this->tbl = DB_PREFIX . "tour_itinerary_points";
    }
}
