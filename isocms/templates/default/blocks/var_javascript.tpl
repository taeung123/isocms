<script defer>
	const DOMAIN_NAME='{$DOMAIN_NAME}';
	const path_ajax_script='{$PCMS_URL}';
	const URL_IMAGES = '{$URL_IMAGES}';
	const LANG_ID = '{$_LANG_ID}';
	const extLang = '{$extLang}';
	const mod = '{$mod}';
	const act = '{$act}'; 
	const URL_JS = '{$URL_JS}';
	const URL_CSS = '{$URL_CSS}';
	const deviceType = "{$deviceType}";

	let appID = '{$appID}';
	let AppSecret = '{$AppSecret}';
	let chUrl = '/js/channel.html';
	let loggedIn = '{$loggedIn}';
	let return_url = '{$return_url}';
	let REQUEST_URI = '{$REQUEST_URI}';
	let OAUTHURL = 'https://accounts.google.com/o/oauth2/auth?';
	let VALIDURL = 'https://www.googleapis.com/oauth2/v1/tokeninfo?access_token=';
    let SCOPE = 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email';
	let CLIENTID = '{$GoogleID}';
	let REDIRECT = DOMAIN_NAME+'/oauth2callback';
	let TYPE = 'token';
	let _url = OAUTHURL + 'scope=' + SCOPE + '&client_id=' + CLIENTID + '&redirect_uri=' + REDIRECT + '&response_type=' + TYPE;
	let acToken;
	let tokenType;
	let expiresIn;
	let user;
	let This_field_is_required = '{$core->get_Lang("This field is required")}'; 
	let facebook_plugin_lang = '{$facebook_plugin_lang}';
	let Days = '{$core->get_Lang("Days")}';
	let Hours = '{$core->get_Lang("Hours")}';
	let Minutes = '{$core->get_Lang("Mins")}';
	let Seconds = '{$core->get_Lang("Secs")}';
	let nd = '{$core->get_Lang("nd")}';
	let rd = '{$core->get_Lang("rd")}';
	let th = '{$core->get_Lang("th")}';
	let st = '{$core->get_Lang("st")}';
	let Day = '{$core->get_Lang("Day")}';
	let Month = '{$core->get_Lang("Month")}';
	let Year = '{$core->get_Lang("Year")}';
	let January = '{$core->get_Lang("January")}'
	let February = '{$core->get_Lang("February")}';
	let March = '{$core->get_Lang("March")}';
	let April = '{$core->get_Lang("April")}';
	let May = '{$core->get_Lang("May")}';
	let June = '{$core->get_Lang("June")}';
	let July = '{$core->get_Lang("July")}';
	let August = '{$core->get_Lang("August")}';
	let Septemper = '{$core->get_Lang("September")}';
	let September = '{$core->get_Lang("September")}';
	let October = '{$core->get_Lang("October")}';
	let November = '{$core->get_Lang("November")}';
	let December = '{$core->get_Lang("December")}';
	let Jan = '{$core->get_Lang("Jan")}'
	let Feb = '{$core->get_Lang("Feb")}';
	let Mar = '{$core->get_Lang("Mar")}';
	let Apr = '{$core->get_Lang("Apr")}';
	let Jun = '{$core->get_Lang("Jun")}';
	let Jul = '{$core->get_Lang("Jul")}';
	let Aug = '{$core->get_Lang("Aug")}';
	let Sep = '{$core->get_Lang("Sep")}';
	let Oct = '{$core->get_Lang("Oct")}';
	let Nov = '{$core->get_Lang("Nov")}';
	let Dec = '{$core->get_Lang("Dec")}';
	let Mo = '{$core->get_Lang("Mo")}'
	let Tu = '{$core->get_Lang("Tu")}';
	let We = '{$core->get_Lang("We")}';
	let Th = '{$core->get_Lang("Th")}';
	let Fr = '{$core->get_Lang("Fr")}';
	let Sa = '{$core->get_Lang("Sa")}';
	let Su = '{$core->get_Lang("Su")}';
    let Mon = '{$core->get_Lang("Mon")}'
	let Tue = '{$core->get_Lang("Tue")}';
	let Wed = '{$core->get_Lang("Wed")}';
	let Thu = '{$core->get_Lang("Thu")}';
	let Fri = '{$core->get_Lang("Fri")}';
	let Sat = '{$core->get_Lang("Sat")}';
	let Sun = '{$core->get_Lang("Sun")}';
    let Monday = '{$core->get_Lang("Monday")}'
	let Tuesday = '{$core->get_Lang("Tuesday")}';
	let Wednesday = '{$core->get_Lang("Wednesday")}';
	let Thursday = '{$core->get_Lang("Thursday")}';
	let Friday = '{$core->get_Lang("Friday")}';
	let Saturday = '{$core->get_Lang("Saturday")}';
	let Sunday = '{$core->get_Lang("Sunday")}';
	let Today = '{$core->get_Lang("Today")}';
	let night = '{$core->get_Lang("night")}';
	let nights = '{$core->get_Lang("nights")}';
	let Done = '{$core->get_Lang("Done")}';
	let Prev = '{$core->get_Lang("Prev")}';
	let Next = '{$core->get_Lang("Next")}';
	let dateFormat = "dd/mm/yy";
    let title_question = `{$core->get_Lang('Question!')}`;
    let text_question = `{$core->get_Lang('Please answer this question')}`;
    let wrong_answer = `{$core->get_Lang("Your answer is wrong")}`;
    let try_again = `{$core->get_Lang("Fail! Please try again")}`;
    let is_loading = `{$core->get_Lang("Loading")}...`;
    let is_sending = `{$core->get_Lang("Sending")}...`;
    let view_more = `{$core->get_Lang('View more')}`;
    let view_less = `{$core->get_Lang('Less more')}`;
	
	let msg_email_required = "{$core->get_Lang('Your email should not be empty')}!";
	let msg_email_not_valid = "{$core->get_Lang('Your email is not valid')}!";
	let msg_success = "{$core->get_Lang('Sign up for email success')}!";
	let msg_exits = "{$core->get_Lang('Email address already exists')}!";
	let subscribe_error = "{$core->get_Lang('subscribe error')}!";

	let iso_calendar_weekdays = {
        shorthand: ['{$core->get_Lang("Sun")}', '{$core->get_Lang("Mon")}', '{$core->get_Lang("Tue")}', '{$core->get_Lang("Wed")}', '{$core->get_Lang("Thu")}', '{$core->get_Lang("Fri")}', '{$core->get_Lang("Sat")}'], 
        longhand: ['{$core->get_Lang("Sunday")}', '{$core->get_Lang("Monday")}', '{$core->get_Lang("Tuesday")}', '{$core->get_Lang("Wednesday")}', '{$core->get_Lang("Thursday")}', '{$core->get_Lang("Friday")}', '{$core->get_Lang("Saturday")}']
    };
    let iso_calendar_months = {
        shorthand: ['{$core->get_Lang("Jan")}', '{$core->get_Lang("Feb")}', '{$core->get_Lang("Mar")}', '{$core->get_Lang("Apr")}', '{$core->get_Lang("May")}', '{$core->get_Lang("Jun")}', '{$core->get_Lang("Jul")}', '{$core->get_Lang("Aug")}', '{$core->get_Lang("Sep")}', '{$core->get_Lang("Oct")}', '{$core->get_Lang("Nov")}', '{$core->get_Lang("Dec")}'],
        longhand: ['{$core->get_Lang("January")}', '{$core->get_Lang("February")}', '{$core->get_Lang("March")}', '{$core->get_Lang("April")}', '{$core->get_Lang("May")}', '{$core->get_Lang("June")}', '{$core->get_Lang("July")}', '{$core->get_Lang("August")}', '{$core->get_Lang("September")}', '{$core->get_Lang("October")}', '{$core->get_Lang("November")}', '{$core->get_Lang("December")}'],
    };
	let quick_search = `{$core->get_Lang('Find a destination')}`;
    let msg_search = `{$core->get_Lang('Please enter your input search')}`;
	let iso_datepicker = {
        dateFormat: 'dd/mm/yy',
        minDate: 1,
        prevText: "{$core->get_Lang('Trước')}",
        nextText: "{$core->get_Lang('Sau')}",
        currentText: "{$core->get_Lang('Hôm nay')}",
        monthNames: [Jan, Feb, Mar, Apr, May, Jun, Jul, Aug, Sep, Oct, Nov, Dec],
        dayNamesMin: [Mo, Tu, We, Th, Fr, Sa, Su]
    };
	let msg_fullname_required = "{$core->get_Lang('Your first name should not be empty')}!";
    let msg_phone_required = "{$core->get_Lang('Your telephone should not be empty')}!";
    let msg_country_id_not_valid = "{$core->get_Lang('Please select country')}!";
    let msg_confirmemail_not_valid = "{$core->get_Lang('Email addresses do not match')}!";
    let showInfo = "{$core->get_Lang('Show more information')}";
    let hideInfo = "{$core->get_Lang('information hidden')}";
    let Cancel = '{$core->get_lang("Cancel")}';
    let Confirm = '{$core->get_lang("Confirm")}';
    let delete_text = '{$core->get_lang("Are you sure you want to delete?")}';
    let remove_text = '{$core->get_lang("Are you sure you want to remove?")}';
    let loading = '{$core->get_lang("loading")}';
    let DateofBirth = '{$core->get_lang("Birthday")}';
    let msg_recapcha = "{$core->get_Lang('You must check Recaptcha')}";
</script>