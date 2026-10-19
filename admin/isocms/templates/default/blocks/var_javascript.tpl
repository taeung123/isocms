<script type="text/javascript">

	var DOMAIN_NAME='{$DOMAIN_NAME}';

	var extLang='{$extLang}';

	var path_ajax_script = '{$PCMS_URL}';

	var URL_JS = "{$URL_JS}"; 

	var PCMS_DIR = "{$PCMS|default:''}";

	var URL_IMAGES = "{$URL_IMAGES}";

	var REQUEST_URI = "{$REQUEST_URI}"; 

	var type= "{$mod}";

	var LANG_ID = "{$_LANG_ID}";

	var mod= "{$mod}";

	var act= "{$act}";

	var crm_date_format="dd/mm/yy";

	var crm_datepicker_format = {

		changeMonth: true,

		changeYear: true,

		showButtonPanel: true,

		dateFormat :crm_date_format,

		yearRange: "-100:+100"

	}

	var checkfiltertour= "{$check|default:false}";

	var pvalTable="{$pvalTable|default:0}";

	var start_date_error = '{$core->get_Lang("start date error")}';

	var end_date_error = '{$core->get_Lang("end date error")}';

	var promotion_code_error = '{$core->get_Lang("promotion code error")}';

	var error = '{$core->get_Lang("error")}';

	var confirm_update_status = '{$core->get_Lang("confirm_update_status")}';

	var confim_delete = '{$core->get_Lang("confirm_delete")}';

	var confirm_delete = '{$core->get_Lang("confirm_delete")}';

	var confirm_cloning = '{$core->get_Lang("confirm_cloning")}';

	var confirm_reset = '{$core->get_Lang("confirm_reset")}';

	var user_group_required = '{$core->get_Lang("user_group_required")}';

	var username_required = '{$core->get_Lang("username_required")}';

	var field_valid = '{$core->get_Lang("field_not_valid")}';

	var field_required = '{$core->get_Lang("field_required")}';

	var field_is_required = '{$core->get_Lang("field_required")}';

	var field_is_link = '{$core->get_Lang("field_link")}';

	var title_required = '{$core->get_Lang("title_required")}';

	var password_required = '{$core->get_Lang("password_required")}';

	var confirm_password_required = '{$core->get_Lang("confirm_password_required")}';

	var confirm_password_in_valid = '{$core->get_Lang("confirm_password_in_valid")}';

	var confirm_replication = '{$core->get_Lang("confirm_replication")}';

	var full_name_required = '{$core->get_Lang("full_name_required")}';

	var insert_success = '{$core->get_Lang("insert_success")}';

	var upload_success = '{$core->get_Lang("upload_success")}';

	var insert_error = '{$core->get_Lang("insert_error")}';

	var upload_error = '{$core->get_Lang("upload_error")}';

	var insert_error_exist = '{$core->get_Lang("insert_error_exist")}';

	var exist_error = '{$core->get_Lang("exist_error")}';

	var exist_title = '{$core->get_Lang("exist_title")}';

	var update_success = '{$core->get_Lang("update_success")}';

	var update_error = '{$core->get_Lang("update_error")}';

	var delete_success = '{$core->get_Lang("delete_success")}';

	var delete_error = '{$core->get_Lang("delete_error")}';

    var number_day_invalid = '{$core->get_Lang("number_day_invalid")}';

	var number_day_exist = '{$core->get_Lang("number_day_exist")}';

	var title_itinerary_exist = '{$core->get_Lang("title_itinerary_exist")}';

	var reset_success = '{$core->get_Lang("reset_success")}';

	var user_name_invalid = '{$core->get_Lang("user_name_invalid")}';

	var password_invalid = '{$core->get_Lang("password_invalid")}';

	var loading = "{$core->get_Lang('loading')}";

	var Select = "{$core->get_Lang('Select')}";

	var save = "{$core->get_Lang('Save')}";

	var Table_of_Contents = '{$core->get_Lang("Table of Contents")}';	

	var txtPublic = '{$core->get_Lang("Public")}';

	var txtPrivate = '{$core->get_Lang("Private")}';

	var txtDraft = '{$core->get_Lang("Draft")}';

	var Closing_date_must_sell_before_departure_of_tour = "{$core->get_Lang('Closing date must sell before departure of tour')}";

	var The_opening_date_must_be_before_the_departure_of_the_tour = "{$core->get_Lang('The opening date must be before the departure of the tour')}";

	var The_date_of_sale_must_be_after_the_opening_date = "{$core->get_Lang('The date of sale must be after the opening date')}";

	

	var No_matching_results = "{$core->get_Lang('No matching results')}";

	var Showing = "{$core->get_Lang('Showing')}";

	var entries = "{$core->get_Lang('entries')}";

	var First = "{$core->get_Lang('First')}";

	var Last = "{$core->get_Lang('Last')}";

	var Previous = "{$core->get_Lang('Previous')}";

	var Next = "{$core->get_Lang('Next')}";

	var Processing = "{$core->get_Lang('Processing')}";

	var Search = "{$core->get_Lang('Search')}";

	var Show = "{$core->get_Lang('Show')}";

	var No_matching_records_found = "{$core->get_Lang('No matching records found')}";

	var activate_to_sort_column_ascending = "{$core->get_Lang('activate to sort column ascending')}";

	var activate_to_sort_column_descending = "{$core->get_Lang('activate to sort column descending')}";

	var to = "{$core->get_Lang('to')}";

	var of = "{$core->get_Lang('of')}";

	var from = "{$core->get_Lang('from')}";

	var filtered = "{$core->get_Lang('filtered')}";

	var total = "{$core->get_Lang('total')}";

	var No_data_available_in_table = "{$core->get_Lang('No data available in table')}";

	var All = "{$core->get_Lang('All')}";

	

	var country = "{$core->get_Lang('country')}";

	var regions = "{$core->get_Lang('regions')}";

	var cities = "{$core->get_Lang('cities')}";

	var area = "{$core->get_Lang('Area')}";

	var attractions = "{$core->get_Lang('attractions')}";

	var continents = "{$core->get_Lang('Continent')}";

	var Select = '{$core->get_Lang("Select")}';

	

	var $Hotel_Region = "";

	var $SiteHasCat_Tours = "{$clsISO->getCheckActiveModulePackage($package_id,'tour','category','default')}";

	var $SiteHasType_Tours = "{$clsConfiguration->getValue('SiteHasType_Tours')}";

	var $SiteHasGroup_Tours = "{$clsISO->getCheckActiveModulePackage($package_id,'tour','group','default')}";

	var $SiteHasCruisesCategory = "{$clsISO->getCheckActiveModulePackage($package_id,'cruise','cat','default')}";

	var $SiteHasCategoryGroup_Tours = "{$clsConfiguration->getValue('SiteHasCategoryGroup_Tours')}";

	var $SiteHasDeparturePoint_Tours = "{$clsISO->getCheckActiveModulePackage($package_id,'tour_exhautive','tour_departure_point','customize')}";

	var $SiteHasHotel_Tours = "{$clsISO->getCheckActiveModulePackage($package_id,'tour','hotel','customize')}";

	

	var $SiteModActive_country = "{$clsISO->getCheckActiveModulePackage($package_id,'country','default','default')}";

    var $SiteModActive_continent = "{$clsISO->getCheckActiveModulePackage($package_id,'continent','default','default')}";

    var $SiteActive_region = "{$clsISO->getCheckActiveModulePackage($package_id,'region','default','default')}";

    var $SiteActive_city = "{$clsISO->getCheckActiveModulePackage($package_id,'city','default','default')}";

    var $SiteHasPriceTableTours = "{$clsConfiguration->getValue('SiteHasPriceTableTours')}";

    var $SitePriceTableType_Tours = '{$clsConfiguration->getValue("SitePriceTableType_Tours")}';

    var $SiteHasStartDate_Tours = "{$clsISO->getCheckActiveModulePackage($package_id,'tour_exhautive','store','default', 'REVQQVJUVVJFLVZpZXRJU08=')}";

    var $SiteHasExtensionTours = "{$clsISO->getCheckActiveModulePackage($package_id,'tour_exhautive','tour_related','customize')}";

    var $SiteHasGalleryImagesTours = "{$clsISO->getCheckActiveModulePackage($package_id,'tour_exhautive','tour_gallery','customize')}";

    var $SiteHasDestinationTours = "{$clsISO->getCheckActiveModulePackage($package_id,'tour_exhautive','destination','customize')}";

    var $SiteHasItineraryTours = "{$clsISO->getCheckActiveModulePackage($package_id,'tour','itinerary','customize')}";

    var $SiteHasStore_Tours = "{$clsConfiguration->getValue('SiteHasStore_Tours')}";

    var $SiteHasCustomContentField_Tours = '{$clsConfiguration->getValue("SiteHasCustomContentField_Tours")}';

    var $check_mod_continent = "{$core->checkAccess('continent')}";

    var $check_mod_country = "{$core->checkAccess('country')}";

	

	var $SiteActive_destination = "{$clsConfiguration->getValue('SiteActive_destination')}";

	var $SiteHasDestinationCruises = "{$clsConfiguration->getValue('SiteHasDestinationCruises')}";

	var $SiteHasGalleryImagesCruises = "{$clsISO->getCheckActiveModulePackage($package_id,'cruise','cruise_photo_gallery','customize')}";

	var $SiteHasCruisesCabin = "{$clsISO->getCheckActiveModulePackage($package_id,'cruise','edit_cabin','default')}";

	var $SiteHasCustomField_Cruise = '{$clsConfiguration->getValue("SiteHasCustomField_Cruise")}';

	var $SiteHasPriceSetup_Cruise = "{$clsConfiguration->getValue('SiteHasPriceSetup_Cruise')}";

	var $SiteHasStartDate_Cruise = "{$clsConfiguration->getValue('SiteHasStartDate_Cruise')}";

	var $SiteHasCruisesProperty = "{$clsConfiguration->getValue('SiteHasCruisesProperty')}";

	var $SiteHasFaqTours = 1

	var $SiteHasCat_Voucher = 1;

	var $SiteHasType_Voucher = 1;

	var $SiteHasGroup_Voucher = 1;

	var $SiteHasCategoryGroup_Voucher = 1;

	var $SiteHasDeparturePoint_Voucher = 1;

	var $SiteHasHotel_Voucher = 1;

	var $SiteHasCat_Combo = 0;

	var $SiteHasType_Combo = 0;

	var $SiteHasGroup_Combo = 0;

	var $SiteHasCategoryGroup_Combo = 0;

	var $SiteHasDeparturePoint_Combo = 0;

	var $SiteHasHotel_Combo = 0;



    var alertMsgPreview = "{$core->get_Lang('is Private')}. {$core->get_Lang('If you want to see it, please turn it on to Public')}";

	</script>