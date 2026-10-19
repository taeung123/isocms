<?php
/*======================================================================*\
|| #################################################################### ||
|| # The Classes configurations of the ISOCMS                         # ||
|| # ISOCMS 6.0.0 By Luong Tien Dung (luongtiendung@gmail.com)        # ||
|| # ---------------------------------------------------------------- # ||
|| # All PHP code in this file is ©2007-2014 VietISO JSC.             # ||
|| # This file may not be redistributed in whole or significant part. # ||
|| # ---------------- ISOCMS IS NOT FREE SOFTWARE ----------------    # ||
|| # http://www.vietiso.com | http://www.vietiso.com/license.html     # ||
|| #################################################################### ||
\*======================================================================*/
class Setting extends dbBasic
{
	function __construct()
	{
		$this->pkey = "setting_id";
		$this->tbl = DB_PREFIX . "setting";
		#Create Table If Not Exist

	}
	function getLink($type = '')
	{
		$link = '/';
		if ($type == 'ThingsToDo') {
			$link = '/things-to-do/';
		}
		if ($type == 'PlacesToGo') {
			$link = '/places-to-go/';
		}
		if ($type == 'Hotels') {
			$link = '/hotels/';
		}
		if ($type == 'TravelAgency') {
			$link = '/travel-agency/';
		}
		if ($type == 'Restaurant') {
			$link = '/restaurant/';
		}
		if ($type == 'News') {
			$link = '#/news/';
		}
		if ($type == 'AboutUs') {
			$link = '#/news/';
		}
		if ($type == 'ContactUs') {
			$link = '#/news/';
		}
		if ($type == 'Term') {
			$link = '#/news/';
		}
		if ($type == 'Privacy') {
			$link = '#/news/';
		}
		if ($type == 'Sitemap') {
			$link = '/sitemap/';
		}
		return $link;
	}
}
