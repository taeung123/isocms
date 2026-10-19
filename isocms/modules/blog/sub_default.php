<?php
function default_default()
{
	global $assign_list, $smarty, $core, $dbconn, $mod, $act, $_LANG_ID,
		$title_page, $description_page, $keyword_page, $domain,
		$country_id, $city_id, $cat_id, $extLang, $clsISO, $package_id;

	global $URL_LIBRARY, $URL_CSS, $URL_JS, $upd_version, $v_cache;


	/* =====================================================
	 * ASSET
	 * ===================================================== */

	Asset::css([
		"{$URL_CSS}/compress/owl.carousel.min.css?v={$v_cache}",
	]);

	Asset::js([
		"{$URL_JS}/compress/owl-carousel-2.3.4.min.js?v={$v_cache}"
	]);


	/* =====================================================
	 * OBJECT
	 * ===================================================== */

	$clsBlog = new Blog();
	$assign_list['clsBlog'] = $clsBlog;


	$clsCountryEx = new Country();
	$assign_list['clsCountryEx'] = $clsCountryEx;


	$clsCity = new City();
	$assign_list['clsCity'] = $clsCity;


	$clsRegion = new Region();
	$assign_list['clsRegion'] = $clsRegion;


	$clsTag = new Tag();
	$assign_list['clsTag'] = $clsTag;


	$clsTagBlog = new TagBlog();
	$lisTagBlog = $clsTagBlog->geAllTagBlog();

	$assign_list['lisTagBlog'] = $lisTagBlog;


	$clsBlogCategory = new BlogCategory();
	$assign_list['clsBlogCategory'] = $clsBlogCategory;


	$clsPagination = new Pagination();


	$clsHotel = new Hotel();
	$assign_list['clsHotel'] = $clsHotel;


	$clsGuide = new Guide();
	$assign_list['clsGuide'] = $clsGuide;


	$clsGuideCat = new GuideCat();
	$assign_list['clsGuideCat'] = $clsGuideCat;


	$clsGuideCatStore = new GuideCatStore();
	$assign_list['clsGuideCatStore'] = $clsGuideCatStore;


	$clsCountry = new Country();
	$assign_list['clsCountry'] = $clsCountry;


	/* =====================================================
	 * COUNTRY LIST
	 *
	 * Lấy PRIMARY KEY thật của bảng Country
	 * và alias thành country_id.
	 *
	 * Ví dụ nếu:
	 * $clsCountry->pkey = 'country_id'
	 *
	 * thì vẫn trả về:
	 * country_id
	 *
	 * Nếu pkey khác thì vẫn đúng.
	 * ===================================================== */

	$country_pkey = $clsCountry->pkey;

	$lstCountry = $clsCountry->getAll(
		"is_trash=0 and is_online=1 ORDER BY order_no ASC",
		$country_pkey . " AS country_id,title,slug"
	);

	$assign_list['lstCountry'] = $lstCountry;

	unset($lstCountry);


	/* =====================================================
	 * WEBP
	 * ===================================================== */

	$WebpImage = new WebpImage();

	$source = $_SERVER['DOCUMENT_ROOT'] .
		'/uploads/VietISO/anh-30.jpg.webp';

	if (
		!empty($source) &&
		file_exists($source)
	) {

		$size = @getimagesize($source);

		if ($size !== false) {
			// xử lý nếu cần
		}
	}


	/* =====================================================
	 * GUIDE CATEGORY
	 * ===================================================== */

	$listGuideCat = $clsGuideCat->getAll(
		"is_trash=0 and is_online=1 order by order_no ASC",
		$clsGuideCat->pkey . ',slug,title'
	);

	$assign_list['listGuideCat'] = $listGuideCat;

	unset($listGuideCat);


	/* =====================================================
	 * GET PARAMETER
	 * ===================================================== */

	$show = isset($_GET['show'])
		? trim($_GET['show'])
		: '';

	$assign_list['show'] = $show;


	$type = isset($_GET['type'])
		? trim($_GET['type'])
		: '';

	$assign_list['type'] = $type;


	/*
	 * key chỉ dùng cho SEARCH BLOG.
	 *
	 * KHÔNG dùng key làm country_id.
	 */

	$key_blog = !empty($_GET['key'])
		? trim($_GET['key'])
		: '';

	$assign_list['key_blog'] = $key_blog;


	/*
	 * CATEGORY
	 *
	 * Ví dụ:
	 * ?cat=4,6
	 */

	$list_cats = !empty($_GET['cat'])
		? trim($_GET['cat'])
		: '';

	$assign_list['list_cats'] = $list_cats;


	/* =====================================================
	 * COUNTRY MULTI SELECT
	 *
	 * Ví dụ:
	 *
	 * ?country_id=1,7,78
	 *
	 * $country_id_array:
	 *
	 * array(
	 *     1,
	 *     7,
	 *     78
	 * )
	 * ===================================================== */

	$country_id_search = isset($_GET['country_id'])
		? trim($_GET['country_id'])
		: '';


	$country_id_array = array();


	if ($country_id_search !== '') {

		foreach (
			explode(',', $country_id_search)
			as $id
		) {

			$id = intval($id);


			if (
				$id > 0 &&
				!in_array(
					$id,
					$country_id_array
				)
			) {

				$country_id_array[] = $id;

			}
		}
	}


	/*
	 * Sắp xếp ID để URL ổn định.
	 *
	 * 78,1,7
	 * =>
	 * 1,7,78
	 */

	sort($country_id_array);


	$assign_list['country_id_search'] =
		implode(',', $country_id_array);


	$assign_list['country_id_array'] =
		$country_id_array;


	/* =====================================================
	 * DEFAULT VALUES
	 * ===================================================== */

	$country_id = 0;
	$city_id = 0;
	$region_id = 0;


	$oneItemCountry = array();
	$oneItemCity = array();
	$oneItemRegion = array();


	/* =====================================================
	 * COUNTRY / CITY / REGION
	 * ===================================================== */

	if ($show == 'Default') {

		/*
		 * =================================================
		 * DEFAULT BLOG
		 *
		 * Country lấy từ:
		 *
		 * ?country_id=1,7,78
		 *
		 * KHÔNG lấy từ key.
		 * =================================================
		 */

		if (!empty($country_id_array)) {

			/*
			 * Giữ country_id đầu tiên để tương thích
			 * với các đoạn code cũ cần một ID.
			 *
			 * Danh sách đầy đủ nằm trong:
			 *
			 * $country_id_array
			 */

			$country_id =
				intval(
					$country_id_array[0]
				);


			/*
			 * Lấy thông tin country đầu tiên.
			 */

			$res = $clsCountryEx->getAll(
				"is_trash=0 and is_online=1 and " .
				$clsCountryEx->pkey .
				"='" .
				intval($country_id) .
				"' LIMIT 0,1",
				$clsCountryEx->pkey .
				',slug,title'
			);


			if (!empty($res)) {

				$oneItemCountry =
					$res[0];

			}

		}

	} else {

		/* =================================================
		 * SEO COUNTRY
		 *
		 * /blog/vietnam/
		 * ================================================= */

		$slug_country =
			isset($_GET['slug_country'])
				? trim($_GET['slug_country'])
				: '';


		$slug_country =
			addslashes($slug_country);


		$res = $clsCountryEx->getAll(
			"is_trash=0 and is_online=1 and slug='" .
			$slug_country .
			"' LIMIT 0,1",
			$clsCountryEx->pkey .
			',slug,title'
		);


		if (empty($res)) {

			header(
				'Location:' .
				PCMS_URL .
				$extLang
			);

			exit();

		}


		/*
		 * QUAN TRỌNG:
		 *
		 * Lấy COUNTRY ID từ PRIMARY KEY.
		 *
		 * Không lấy từ:
		 *
		 * $_GET['key']
		 * $_GET['slug_country']
		 */

		$country_id =
			intval(
				$res[0][$clsCountryEx->pkey]
			);


		if ($country_id <= 0) {

			header(
				'Location:' .
				PCMS_URL .
				$extLang
			);

			exit();

		}


		$country_id_array =
			array($country_id);


		$assign_list['country_id_array'] =
			$country_id_array;


		$assign_list['country_id_search'] =
			$country_id;


		$oneItemCountry =
			$res[0];


		/* =================================================
		 * CITY
		 * ================================================= */

		if ($show == 'City') {

			$slug_city =
				isset($_GET['slug_city'])
					? trim($_GET['slug_city'])
					: '';


			$city_id =
				intval(
					$clsCity->getBySlug(
						$slug_city
					)
				);


			if ($city_id <= 0) {

				header(
					'Location:' .
					PCMS_URL .
					$extLang
				);

				exit();

			}


			$oneItemCity =
				$clsCity->getOne(
					$city_id,
					'title,slug'
				);


			if (empty($oneItemCity)) {

				header(
					'Location:' .
					PCMS_URL .
					$extLang
				);

				exit();

			}
		}


		/* =================================================
		 * REGION
		 * ================================================= */

		if ($show == 'Region') {

			$region_id =
				isset($_GET['region_id'])
					? intval($_GET['region_id'])
					: 0;


			if ($region_id <= 0) {

				header(
					'Location:' .
					PCMS_URL .
					$extLang
				);

				exit();

			}


			$oneItemRegion =
				$clsRegion->getOne(
					$region_id,
					'title,slug'
				);


			if (empty($oneItemRegion)) {

				header(
					'Location:' .
					PCMS_URL .
					$extLang
				);

				exit();

			}
		}
	}


	/* =====================================================
	 * ASSIGN COUNTRY / CITY / REGION
	 * ===================================================== */

	$assign_list['country_id'] =
		intval($country_id);


	$assign_list['country_id_array'] =
		$country_id_array;


	$assign_list['city_id'] =
		intval($city_id);


	$assign_list['region_id'] =
		intval($region_id);


	$assign_list['oneItemCountry'] =
		$oneItemCountry;


	$assign_list['oneItemCity'] =
		$oneItemCity;


	$assign_list['oneItemRegion'] =
		$oneItemRegion;


	/* =====================================================
	 * FEATURED BLOG
	 * ===================================================== */

	$featuredBlog =
		$clsBlog->getAll(
			'is_trash=0 ' .
			'and is_approve=1 ' .
			'and is_online=1 ' .
			'ORDER BY num_view DESC LIMIT 0,1',
			$clsBlog->pkey .
			',cat_id,reg_date,publish_date,upd_date,' .
			'author,list_tag_id,intro,title,slug,image'
		);


	$featuredBlogItem =
		!empty($featuredBlog)
			? $featuredBlog[0]
			: array();


	$assign_list['featuredBlog'] =
		$featuredBlogItem;


	/* =====================================================
	 * PAGINATION
	 * ===================================================== */

	$recordPerPage = 9;


	$currentPage =
		isset($_GET['page'])
			? max(
				1,
				intval($_GET['page'])
			)
			: 1;


	$page_Seo =
		isset($_GET['page'])
			? intval($_GET['page'])
			: '';


	$assign_list['page_Seo'] =
		$page_Seo;


	/* =====================================================
	 * BLOG CONDITION
	 * ===================================================== */

	if ($show == 'Default') {

		$cond =
			"is_trash=0 " .
			"and is_approve=1 " .
			"and is_online=1";


		/* =================================================
		 * MULTI COUNTRY
		 *
		 * country_id=1,7,78
		 *
		 * =>
		 *
		 * list_country_id LIKE '%|1|%'
		 * OR
		 * list_country_id LIKE '%|7|%'
		 * OR
		 * list_country_id LIKE '%|78|%'
		 * ================================================= */

		if (!empty($country_id_array)) {

			$country_cond =
				array();


			foreach (
				$country_id_array
				as $cid
			) {

				$cid =
					intval($cid);


				if ($cid > 0) {

					$country_cond[] =
						"list_country_id LIKE '%|" .
						$cid .
						"|%'";

				}
			}


			if (!empty($country_cond)) {

				$cond .=
					" AND (" .
					implode(
						" OR ",
						$country_cond
					) .
					")";

			}
		}


		/* =================================================
		 * BLOG CATEGORY LIST
		 * ================================================= */

		$lstBlogCategory =
			$clsBlogCategory->getAll(
				"is_trash=0 and is_online=1 " .
				"order by order_no asc",
				$clsBlogCategory->pkey .
				", title,slug, icon"
			);


		$assign_list['lstBlogCategory'] =
			$lstBlogCategory;


	} else {


		/* =================================================
		 * COUNTRY PAGE
		 * ================================================= */

		if ($show == 'Country') {

			$cond =
				"is_trash=0 " .
				"and is_approve=1 " .
				"and is_online=1 " .
				"and blog_id IN (" .
				"SELECT blog_id " .
				"FROM " .
				DB_PREFIX .
				"blog_destination " .
				"WHERE country_id='" .
				intval($country_id) .
				"')";


		/* =================================================
		 * CITY PAGE
		 * ================================================= */

		} else if ($show == 'City') {

			$cond =
				"is_trash=0 " .
				"and is_approve=1 " .
				"and is_online=1 " .
				"and blog_id IN (" .
				"SELECT blog_id " .
				"FROM " .
				DB_PREFIX .
				"blog_destination " .
				"WHERE country_id='" .
				intval($country_id) .
				"' " .
				"and city_id='" .
				intval($city_id) .
				"')";


		/* =================================================
		 * REGION PAGE
		 * ================================================= */

		} else {

			$cond =
				"is_trash=0 " .
				"and is_approve=1 " .
				"and is_online=1 " .
				"and blog_id IN (" .
				"SELECT blog_id " .
				"FROM " .
				DB_PREFIX .
				"blog_destination " .
				"WHERE country_id='" .
				intval($country_id) .
				"' " .
				"and region_id='" .
				intval($region_id) .
				"')";
		}
	}


	/* =====================================================
	 * KEYWORD SEARCH
	 * ===================================================== */

	if ($key_blog != '') {

		$key_blog_sql =
			addslashes(
				$key_blog
			);


		$key_blog_slug =
			addslashes(
				$clsISO->replaceSpace(
					$key_blog
				)
			);


		$cond .=
			" AND (" .
			"title LIKE '%" .
			$key_blog_sql .
			"%' " .
			"OR slug LIKE '%" .
			$key_blog_slug .
			"%'" .
			")";
	}


	/* =====================================================
	 * CATEGORY FILTER
	 *
	 * cat=4,6
	 * ===================================================== */

	if (!empty($list_cats)) {

		$list_cat_cond =
			array();


		foreach (
			explode(',', $list_cats)
			as $v
		) {

			$v = intval($v);


			if ($v > 0) {

				$list_cat_cond[] =
					"list_cat_id LIKE '%|" .
					$v .
					"|%'";

			}
		}


		if (!empty($list_cat_cond)) {

			$cond .=
				" AND (" .
				implode(
					" OR ",
					$list_cat_cond
				) .
				")";
		}
	}


	/* =====================================================
	 * REMOVE FEATURED BLOG
	 * ===================================================== */

	if (
		!empty(
			$featuredBlogItem[
				$clsBlog->pkey
			]
		)
	) {

		$cond .=
			" AND " .
			$clsBlog->pkey .
			" <> " .
			intval(
				$featuredBlogItem[
					$clsBlog->pkey
				]
			);
	}


	/* =====================================================
	 * ORDER
	 * ===================================================== */

	$order_by =
		" ORDER BY " .
		$clsBlog->pkey .
		" DESC";


	/* =====================================================
	 * TOTAL RECORD
	 * ===================================================== */

	$allItem =
		$clsBlog->getAll(
			$cond,
			$clsBlog->pkey
		);


	$totalRecord =
		$allItem
			? count($allItem)
			: 0;


	/* =====================================================
	 * PAGINATION LINK
	 * ===================================================== */

	if ($show == 'Default') {

		$link_page =
			$extLang .
			'/blog/';


		/*
		 * Giữ country_id khi phân trang.
		 *
		 * Ví dụ:
		 * /blog/?country_id=1,7,78
		 */

		$query_params =
			array();


		if (!empty($country_id_array)) {

			$query_params['country_id'] =
				implode(
					',',
					$country_id_array
				);

		}


		if (!empty($list_cats)) {

			$query_params['cat'] =
				$list_cats;

		}


		if (!empty($key_blog)) {

			$query_params['key'] =
				$key_blog;

		}


		if (!empty($query_params)) {

			$link_page .=
				'?' .
				http_build_query(
					$query_params
				);

		}


	} else {


		if ($show == 'City') {

			$link_page =
				$extLang .
				'/blog/' .
				$clsCountryEx->getSlug(
					$country_id,
					$oneItemCountry
				) .
				'/' .
				$clsCity->getSlug(
					$city_id,
					$oneItemCity
				) .
				'/';


		} else if ($show == 'Country') {

			$link_page =
				$extLang .
				'/blog/' .
				$clsCountryEx->getSlug(
					$country_id,
					$oneItemCountry
				) .
				'/';


		} else {

			$link_page =
				$extLang .
				'/blog/' .
				$clsCountryEx->getSlug(
					$country_id,
					$oneItemCountry
				) .
				'/' .
				$clsRegion->getSlug(
					$region_id,
					$oneItemRegion
				) .
				'-rg' .
				$region_id;
		}
	}


	/* =====================================================
	 * PAGINATION CONFIG
	 * ===================================================== */

	$config = array(

		'total' =>
			$totalRecord,

		'number_per_page' =>
			$recordPerPage,

		'current_page' =>
			$currentPage,

		'link' =>
			str_replace(
				'.html',
				'/',
				$link_page
			),

		'link_page_1' =>
			$link_page
	);


	$clsPagination->initianize(
		$config
	);


	$page_view =
		$clsPagination->create_links(
			false
		);


	/* =====================================================
	 * OFFSET / LIMIT
	 * ===================================================== */

	$offset =
		($currentPage - 1) *
		$recordPerPage;


	$limit =
		" LIMIT " .
		$offset .
		"," .
		$recordPerPage;


	/* =====================================================
	 * BLOG LIST
	 * ===================================================== */

	$lstBlogs =
		$clsBlog->getAll(
			$cond .
			$order_by .
			$limit,
			$clsBlog->pkey .
			',cat_id,reg_date,publish_date,upd_date,' .
			'author,list_tag_id,intro,title,slug,image'
		);


	/* =====================================================
	 * PAGE OUT OF RANGE
	 * ===================================================== */

	if (
		!$lstBlogs &&
		$currentPage > 1
	) {

		header(
			"Location: " .
			$clsISO->getLink('blog')
		);

		exit();
	}


	$assign_list['lstBlogs'] =
		$lstBlogs;


	$assign_list['page_view'] =
		$page_view;


	$assign_list['totalPage'] =
		$clsPagination->getTotalPage();


	unset($lstBlogs);
	unset($page_view);


	/* =====================================================
	 * HOTEL PLACE
	 * ===================================================== */

	if ($show != 'Default') {


		if ($show == 'City') {

			$listHotelPlace =
				$clsHotel->getAll(
					"is_trash=0 " .
					"and is_online=1 " .
					"and country_id='" .
					intval($country_id) .
					"' " .
					"and city_id='" .
					intval($city_id) .
					"'",
					$clsHotel->pkey .
					',star_id'
				);


		} else if ($show == 'Country') {

			$listHotelPlace =
				$clsHotel->getAll(
					"is_trash=0 " .
					"and is_online=1 " .
					"and country_id='" .
					intval($country_id) .
					"'",
					$clsHotel->pkey .
					',star_id'
				);


		} else {

			/*
			 * FIX:
			 *
			 * country_id='$country_id
			 *
			 * =>
			 *
			 * country_id='$country_id'
			 */

			$listHotelPlace =
				$clsHotel->getAll(
					"is_trash=0 " .
					"and is_online=1 " .
					"and country_id='" .
					intval($country_id) .
					"' " .
					"and region_id='" .
					intval($region_id) .
					"'",
					$clsHotel->pkey .
					',star_id'
				);
		}


		$assign_list['listHotelPlace'] =
			$listHotelPlace;


		unset($listHotelPlace);
	}


	/* =====================================================
	 * LETTER
	 * ===================================================== */

	$letter =
		array();


	foreach (
		range('a', 'z')
		as $i
	) {

		$letter[] = $i;

	}


	$assign_list['letter'] =
		$letter;


	/* =====================================================
	 * TITLE / DESCRIPTION
	 * ===================================================== */

	if ($show == 'Default') {


		if (
			$country_id > 0 &&
			!empty($oneItemCountry)
		) {

			$title_page =
				$clsCountryEx->getTitle(
					$country_id,
					$oneItemCountry
				) .
				' | ' .
				$core->get_Lang('blogs') .
				' | ' .
				PAGE_NAME;


		} else {

			$title_page =
				$core->get_Lang('blogs') .
				' | ' .
				PAGE_NAME;

		}


	} else {


		if (
			$show == 'City' &&
			$city_id > 0
		) {

			$title_page =
				$clsCity->getTitle(
					$city_id,
					$oneItemCity
				) .
				' | ' .
				$core->get_Lang('blogs') .
				' | ' .
				PAGE_NAME;


		} else if (
			$show == 'Country' &&
			$country_id > 0
		) {

			$title_page =
				$clsCountryEx->getTitle(
					$country_id,
					$oneItemCountry
				) .
				' | ' .
				$core->get_Lang('blogs') .
				' | ' .
				PAGE_NAME;


		} else if (
			$show == 'Region' &&
			$region_id > 0
		) {

			$title_page =
				$clsRegion->getTitle(
					$region_id,
					$oneItemRegion
				) .
				' | ' .
				$core->get_Lang('blogs') .
				' | ' .
				PAGE_NAME;


		} else {

			$title_page =
				$core->get_Lang('blogs') .
				' | ' .
				PAGE_NAME;

		}
	}


	/* =====================================================
	 * ASSIGN SEO
	 * ===================================================== */

	$assign_list['title_page'] =
		$title_page;


	$description_page =
		$title_page;


	$assign_list['description_page'] =
		$description_page;
}
function default_cat()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $extLang;
	global $clsISO, $package_id;
	#
	$show = isset($_GET['show']) ? $_GET['show'] : '';
	$assign_list['show'] = $show;

	$clsBlog = new Blog();
	$assign_list['clsBlog'] = $clsBlog;
	$clsCountryEx = new Country();
	$assign_list['clsCountryEx'] = $clsCountryEx;
	$clsCity = new City();
	$assign_list['clsCity'] = $clsCity;
	$clsTag = new Tag();
	$assign_list['clsTag'] = $clsTag;
	$clsBlogCategory = new BlogCategory();
	$assign_list['clsBlogCategory'] = $clsBlogCategory;
	$clsPagination = new Pagination();

	if ($show != 'Cat') {
		$slug_country = isset($_GET['slug_country']) ? $_GET['slug_country'] : '';
		$res = $clsCountryEx->getAll("is_trash=0 and is_online=1 and slug='$slug_country' LIMIT 0,1", $clsCountryEx->pkey . ',title');
		$country_id = $res[0][$clsCountryEx->pkey];
		if (intval($country_id) == 0) {

			header('Location:' . PCMS_URL . $extLang);
			exit();
		}
		$assign_list['country_id'] = $country_id;

		if ($show == 'City') {
			$slug_city = isset($_GET['slug_city']) ? $_GET['slug_city'] : '';
			$city_id = $clsCity->getBySlug($slug_city);
			if (intval($city_id) == 0) {
				header('Location:' . PCMS_URL . $extLang);
				exit();
			}
		}

		$assign_list['city_id'] = $city_id;
	}
	#
	$slug_cat = $_GET['slug_cat'];
	$oneItem = $clsBlogCategory->getAll("is_trash=0 and is_online=1 and slug='$slug_cat' LIMIT 0,1", $clsBlogCategory->pkey . ',title,slug,intro');
	$blogcat_id = intval($oneItem[0][$clsBlogCategory->pkey]);
	if ($blogcat_id == 0) {
		header('location:' . PCMS_URL . $extLang);
		exit();
	}
	$assign_list['blogcat_id'] = $assign_list['cat_id'] = $blogcat_id;
	$assign_list['oneItem'] = $oneItem;

	#
	$title_page = $oneItem[0]['title'];
	$assign_list['title_blog_cat'] = $title_page;
	#
	$recordPerPage = 6;
	$currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
	$page_Seo = isset($_GET['page']) ? intval($_GET['page']) : '';
	$assign_list['page_Seo'] = $page_Seo;

	$cond = "is_trash=0 and is_approve=1 and is_online=1";

	if ($show == 'Country') {
		$cond .= " and (cat_id='$blogcat_id' or list_cat_id like '%|$blogcat_id|%') and  blog_id IN (select blog_id FROM " . DB_PREFIX . "blog_destination WHERE country_id='$country_id')";
	} elseif ($show == 'City') {
		$cond .= " and (cat_id='$blogcat_id' or list_cat_id like '%|$blogcat_id|%') and blog_id IN (select blog_id FROM " . DB_PREFIX . "blog_destination WHERE country_id='$country_id' and city_id ='$city_id')";
	} elseif ($show == 'Region') {
		$cond .= " and (cat_id='$blogcat_id' or list_cat_id like '%|$blogcat_id|%') and blog_id IN (select blog_id FROM " . DB_PREFIX . "blog_destination WHERE country_id='$country_id' and region_id ='$region_id')";
	} else {
		$cond .= " and (cat_id='$blogcat_id' or list_cat_id like '%|$blogcat_id|%')";
	}

	$link_page = $clsBlogCategory->getLink($blogcat_id, $oneItem);

	$order_by = " order by order_no ASC";
	$allBlogCat = $clsBlog->getAll($cond, $clsBlog->pkey);
	$totalRecord = $allBlogCat ? count($allBlogCat) : '0';
	//print_r($totalRecord); die();

	$config = array(
		'total'	=> $totalRecord,
		'number_per_page'	=> $recordPerPage,
		'current_page'	=> $currentPage,
		'link'	=> $link_page,
		'link_page_1'	=> $link_page
	);
	$clsPagination->initianize($config);
	$page_view = $clsPagination->create_links(false);

	$offset = ($currentPage - 1) * $recordPerPage;
	$limit = " LIMIT $offset,$recordPerPage";
	#
	$lstBlogs = $clsBlog->getAll($cond . $order_by . $limit, $clsBlog->pkey . ',cat_id,reg_date,publish_date,title,slug,author,image,intro');
	if (!$lstBlogs && $currentPage > 1) {
		header("Location: " . $link_page);
		exit();
	}
	$assign_list['lstBlogs'] = $lstBlogs;
	unset($lstBlogs);
	$assign_list['page_view'] = $page_view;
	unset($page_view);
	$assign_list['totalPage'] = $clsPagination->getTotalPage();
	$assign_list['list_cats'] = $blogcat_id;
	/*=============Title & Description Page==================*/

	if ($country_id > 0) {
		$title_country_blog = $clsCountryEx->getTitle($country_id, $res[0]);
		$assign_list['title_country_blog'] = $title_country_blog;
		$title_page = $title_page . ' | ' . $title_country_blog . ' | ' . $core->get_Lang('blogs') . ' | ' . PAGE_NAME;
	} elseif ($city_id > 0) {
		$title_city_blog = $clsCity->getTitle($city_id);
		$assign_list['title_city_blog'] = $title_city_blog;
		$title_page = $title_page . ' | ' . $title_city_blog . ' | ' . $core->get_Lang('blogs') . ' | ' . PAGE_NAME;
	} else {
		$title_page = $title_page . ' | ' . $core->get_Lang('blogs') . ' | ' . PAGE_NAME;
	}
	$title_page = $title_page;
	$assign_list["title_page"] = $title_page;
	$description_page = $clsISO->getMetaDescription($blogcat_id, 'BlogCategory', $oneItem);
	$assign_list["description_page"] = $description_page;

	unset($clsBlog);
	unset($clsBlogCategory);
}

function default_tag()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $extLang;
	global $clsISO, $package_id;
	#
	$show = isset($_GET['show']) ? $_GET['show'] : '';
	$assign_list['show'] = $show;

	$clsBlog = new Blog();
	$assign_list['clsBlog'] = $clsBlog;
	$clsCountryEx = new Country();
	$assign_list['clsCountryEx'] = $clsCountryEx;
	$clsCity = new City();
	$assign_list['clsCity'] = $clsCity;
	$clsTag = new Tag();
	$assign_list['clsTag'] = $clsTag;
	$clsBlogCategory = new BlogCategory();
	$assign_list['clsBlogCategory'] = $clsBlogCategory;
	$clsPagination = new Pagination();

	if ($show == 'tag') {
		$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
		$tag_id = $clsTag->getBySlug($slug);
		if (intval($tag_id) == 0) {
			header('Location:' . PCMS_URL . $extLang);
			exit();
		}
	}

	$assign_list['tag_id'] = $tag_id;
	$oneItem = $clsTag->getOne($tag_id);
	$title_page = $clsTag->getTitle($tag_id);

	#
	$recordPerPage = 6;
	$currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;

	$page_Seo = isset($_GET['page_Seo']) ? intval($_GET['page_Seo']) : '';
	$assign_list['page_Seo'] = $page_Seo;

	$cond = "is_trash=0 and is_approve=1 and is_online=1";

	$cond .= " and (list_tag_id like '%|$tag_id|%')";

	$link_page = $clsTag->getLinkTagBlog($tag_id);

	$order_by = " order by order_no ASC";
	$totalRecord = $clsBlog->getAll($cond) ? count($clsBlog->getAll($cond)) : '0';

	$config = array(
		'total'	=> $totalRecord,
		'number_per_page'	=> $recordPerPage,
		'current_page'	=> $currentPage,
		'link'	=> $link_page,
		'link_page_1'	=> $link_page
	);
	$clsPagination->initianize($config);
	$page_view = $clsPagination->create_links(false);

	$offset = ($currentPage - 1) * $recordPerPage;
	$limit = " LIMIT $offset,$recordPerPage";
	#
	$lstBlogs = $clsBlog->getAll($cond . $order_by . $limit, $clsBlog->pkey . ',cat_id,reg_date,publish_date');
	$assign_list['lstBlogs'] = $lstBlogs;
	unset($lstBlogs);
	$assign_list['page_view'] = $page_view;
	unset($page_view);
	$assign_list['totalPage'] = $clsPagination->getTotalPage();

	/*=============Title & Description Page==================*/
	$title_page = $title_page . ' | ' . $core->get_Lang('blogs') . ' | ' . PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = $title_page;
	$assign_list["description_page"] = $description_page;
	/*=============Content Page==================*/
	unset($clsBlog);
	unset($clsBlogCategory);
}

function default_detail()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act,
           $_LANG_ID, $title_page, $description_page,
           $global_image_seo_page, $extLang, $blog_id,
           $clsISO, $package_id, $blogItem;

    /* =========================================
     * CLASS
     * ========================================= */
    $clsBlog = new Blog();
    $assign_list['clsBlog'] = $clsBlog;

    $clsTag = new Tag();
    $assign_list['clsTag'] = $clsTag;

    $clsBlogCategory = new BlogCategory();
    $assign_list['clsBlogCategory'] = $clsBlogCategory;

    /* =========================================
     * GET BLOG ID + SLUG
     * ========================================= */
    $blog_id = isset($_GET['blog_id'])
        ? (int)$_GET['blog_id']
        : 0;

    $slug = isset($_GET['slug'])
        ? trim((string)$_GET['slug'])
        : '';

    /* =========================================
     * CHECK BLOG ONLINE
     * ========================================= */
    if (
        $blog_id <= 0
        || empty($clsBlog->checkOnlineBySlug($blog_id, $slug))
    ) {
        header('Location:' . $clsISO->getLink('blog'));
        exit();
    }

    /* =========================================
     * SESSION VIEW
     * ========================================= */
    $sessionKey = 'blog_' . $blog_id;

    $sessionView = isset($_SESSION[$sessionKey])
        ? $_SESSION[$sessionKey]
        : 0;

    if (!$sessionView) {

        $_SESSION[$sessionKey] = 1;

        $clsBlog->updateOne(
            $blog_id,
            'num_view=num_view+1'
        );
    }

    /* =========================================
     * ASSIGN BLOG ID
     * ========================================= */
    $assign_list['blog_id'] = $blog_id;

    /* =========================================
     * GET BLOG
     *
     * QUAN TRỌNG:
     * đã thêm country_id
     * ========================================= */
    $blogItem = $clsBlog->getOne(
        $blog_id,
        'cat_id,
        country_id,
        rate,
        rate_avg,
        title,
        publish_date,
        upd_date,
        author,
        image,
        list_tag_id,
        intro,
        content,
        slug'
    );

    /* =========================================
     * CHECK BLOG DATA
     * ========================================= */
    if (!is_array($blogItem)) {
        $blogItem = [];
    }

    $assign_list['blogItem'] = $blogItem;

    /* =========================================
     * CATEGORY
     * ========================================= */
    $cat_id = isset($blogItem['cat_id'])
        ? (int)$blogItem['cat_id']
        : 0;

    $assign_list['cat_id'] = $cat_id;

    /* =========================================
     * COUNTRY
     * ========================================= */
    $country_id = isset($blogItem['country_id'])
        ? (int)$blogItem['country_id']
        : 0;

    $assign_list['country_id'] = $country_id;

    /* =========================================
     * RELATED BLOG
     * ========================================= */
    $cond = "
        is_trash=0
        AND is_approve=1
        AND is_online=1
        AND blog_id <> " . (int)$blog_id . "
    ";

    if ($cat_id > 0) {
        $cond .= "
            AND cat_id=" . (int)$cat_id . "
        ";
    }

    /*
     * Chỉ lọc country khi blog thực sự có country_id.
     * Nếu country_id = 0 thì không ép country_id=0.
     */
    if ($country_id > 0) {
        $cond .= "
            AND country_id=" . (int)$country_id . "
        ";
    }

    $lstRelated = $clsBlog->getAll(
        $cond . "
        ORDER BY order_no ASC
        LIMIT 0,4",
        $clsBlog->pkey
        . ',title,slug,rate_avg,rate,intro,country_id,cat_id'
    );

    if (!is_array($lstRelated)) {
        $lstRelated = [];
    }

    $assign_list['lstRelated'] = $lstRelated;

    unset($lstRelated);

    /* =========================================
     * RATING
     * ========================================= */
    $totalRate = isset($blogItem['rate'])
        ? (float)$blogItem['rate']
        : 0;

    $rateAVG = isset($blogItem['rate_avg'])
        ? (float)$blogItem['rate_avg']
        : 0;

    /*
     * Giới hạn rate tránh percent > 100%
     */
    if ($rateAVG < 0) {
        $rateAVG = 0;
    }

    if ($rateAVG > 5) {
        $rateAVG = 5;
    }

    $percentRateAVG = ($rateAVG / 5) * 100;

    $assign_list['percentRateAVG'] = $percentRateAVG;
    $assign_list['totalRate'] = $totalRate;

    /*
     * PHP 8:
     * ép kiểu float trước khi round()
     */
    $rateavg = round($rateAVG, 1);

    /* =========================================
     * DATE
     * ========================================= */
    $publishDate = isset($blogItem['publish_date'])
        ? $blogItem['publish_date']
        : 0;

    $updateDate = isset($blogItem['upd_date'])
        ? $blogItem['upd_date']
        : 0;

    $datePublished = $publishDate
        ? date('Y-m-d H:i:s', (int)$publishDate)
        : '';

    $dateModified = $updateDate
        ? date('Y-m-d H:i:s', (int)$updateDate)
        : '';

    $assign_list['datePublished'] = $datePublished;
    $assign_list['dateModified'] = $dateModified;
    $assign_list['rateavg'] = $rateavg;

    /* =========================================
     * SEO
     * ========================================= */
    $title_page =
        $clsBlog->getTitle($blog_id, $blogItem)
        . ' | '
        . $core->get_Lang('blogs')
        . ' | '
        . PAGE_NAME;

    $assign_list['title_page'] = $title_page;

    $description_page =
        $clsISO->getMetaDescription(
            $blog_id,
            'Blog',
            $blogItem
        );

    $assign_list['description_page'] = $description_page;

    $global_image_seo_page =
        $clsISO->getPageImageShare(
            $blog_id,
            'Blog',
            $blogItem
        );

    $assign_list['global_image_seo_page'] =
        $global_image_seo_page;

    unset($clsBlog);
}
function default_search()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $extLang, $clsISO, $package_id;
	#Promotion
	$clsBlog = new Blog();
	$assign_list['clsBlog'] = $clsBlog;
	$clsTag = new Tag();
	$assign_list['clsTag'] = $clsTag;
	$q = isset($_GET['q']) ? $_GET['q'] : '';
	$assign_list['q'] = $q;
	$slug = $core->replaceSpace($q);
	#
	$lnk = $_SERVER['REQUEST_URI'];
	if (isset($_GET['page'])) {
		$tmp = explode('&', $lnk);
		$n = count($tmp) - 1;
		$la_it = '&' . $tmp[$n];
		$str_len = -strlen($la_it);
		$linkpage = substr($lnk, 0, $str_len);
	} else {
		$linkpage = $lnk;
	}
	$assign_list["linkpage"] = $linkpage;
	#
	$recordPerPage = 6;
	$pageNum = 5;
	$currentPage = isset($_GET["page"]) ? $_GET["page"] : 1;
	$start_limit = ($currentPage - 1) * $recordPerPage;
	$limit = " limit $start_limit,$recordPerPage";
	$cond = "is_trash=0";
	if ($q != '') {
		$cond .= " and (slug_en like '%" . $slug . "%' or slug_vn like '%" . $slug . "%')";
	}
	$cond .= " order by order_no ASC";
	#
	$lstBlog = $clsBlog->getAll($cond . $limit);
	$assign_list['lstBlog'] = $lstBlog;
	#
	$totalRecord = $clsBlog->getAll($cond) ? count($clsBlog->getAll($cond)) : '0';
	$totalPage	 	= ceil($totalRecord / $recordPerPage);
	#
	$first = intval($currentPage / $pageNum) * $pageNum;
	$pageView = "";
	for ($i = 0; $i < $pageNum; $i++) {
		if ($first + $i < $totalPage) {
			$link = $linkpage . "&page=" . ($first + $i + 1);
			$page = ($first + $i + 1 == $currentPage) ? '<a class="current" href="' . $link . '" title="Trang .' . ($first + $i + 1) . '">' . ($first + $i + 1) . '</a>' : '<a href="' . $link . '" title="Trang .' . ($first + $i + 1) . '">' . ($first + $i + 1) . '</a>';
			$pageView .= $page;
		}
	}
	$assign_list['currentPage'] = $currentPage;
	$assign_list['totalRecord'] = $totalRecord;
	$assign_list['recordPerPage'] = $recordPerPage;
	$assign_list['totalPage'] = $totalPage;
	$assign_list['pageNum'] = $pageNum;
	$assign_list['pageView'] = $pageView;
	/*=============Title & Description Page==================*/
	$title_page = $q . ' | ' . $core->get_Lang('searchblog') . ' | ' . PAGE_NAME;
	$assign_list["title_page"] = $title_page;
	$description_page = $title_page;
	$assign_list["description_page"] = $description_page;
	/*=============Content Page==================*/
	unset($clsBlog);
}

function default_saveRating()
{
	global $assign_list, $smarty, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page;
	$table_id = isset($_POST['table_id']) ? $_POST['table_id'] : '';
	$star = isset($_POST['star']) ? $_POST['star'] : 0;
	if ($star < 5) {
		$star = 4;
	}
	$type = isset($_GET['type']) ? $_GET['type'] : 'blog';
	$ip_log = $_SERVER['REMOTE_ADDR'];
	$data = [
		'result'  	=>	false,
		'text'		=>	""
	];
	if (isset($_SESSION['checkVoteNews_' . $table_id . '_' . $type]) && $_SESSION['checkVoteNews_' . $table_id . '_' . $type] == $ip_log) {
		$data = [
			'result'  	=>	false,
			'text'		=>	'| ' . $core->get_Lang('Voted')
		];
	} else if ($table_id != '') {
		if ($type == 'blog') {
			$clsBlog = new Blog();
			$oneItem = $clsBlog->getOne($table_id, 'rate,rate_avg');
			$rate = $oneItem['rate'];
			$rate_avg_new = (($oneItem['rate_avg'] * $rate) + $star) / ($rate + 1);
			$rate_avg_new = number_format($rate_avg_new, 2, '.', '');
			$percentRateAVG = ($rate_avg_new / 5) * 100;
			if ($clsBlog->updateOne($table_id, "rate=$rate+1,rate_avg='" . $rate_avg_new . "'")) {
				$_SESSION['checkVoteNews_' . $table_id . '_' . $type] = $ip_log;
				$data = [
					'result'  		=>	true,
					'text'			=>	'| ' . ($rate + 1) . ' ' . $core->get_Lang('Voted'),
					'percentAVG'	=>	$percentRateAVG
				];
			}
		} else {
			$clsNews = new News();
			$oneItem = $clsNews->getOne($table_id, 'rate,rate_avg');
			$rate = $oneItem['rate'];
			$rate_avg = $oneItem['rate_avg'];
			$rate_avg_new = (($oneItem['rate_avg'] * $rate) + $star) / ($rate + 1);
			$rate_avg_new = number_format($rate_avg_new, 2, '.', '');
			$percentRateAVG = ($rate_avg_new / 5) * 100;
			if ($clsNews->updateOne($table_id, "rate=rate+1,rate_avg='" . $rate_avg_new . "'")) {
				$_SESSION['checkVoteNews_' . $table_id . '_' . $type] = $ip_log;
				$data = [
					'result'  		=>	true,
					'text'			=>	'| ' . ($rate + 1) . ' ' . $core->get_Lang('Voted'),
					'percentAVG'	=>	$percentRateAVG
				];
			}
		}
	}
	echo json_encode($data);
	die();
}
function default_ajSaveBlogComment()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page;
	#
	$clsBlog = new Blog();
	$clsBlogComment = new BlogComment();
	$clsISO = new ISO();
	#
	$fullname = addslashes($_POST['fullname']);
	$email = addslashes($_POST['email']);
	$message = addslashes($_POST['message']);
	$blog_id = $_POST['blog_id'];
	$security_code = isset($_POST["security_code"]) ? $_POST["security_code"] : '';
	$security_code = strtoupper($security_code);
	#
	if ($security_code != $_SESSION['skey']) {
		echo 'invalid_security_code';
		die();
	} else {
		$max_id = $clsBlogComment->getMaxId();
		$f = "blog_comment_id,domain_id,blog_id,link,fullname,email,message,order_no,reg_date,ip_address";
		$v = "'" . $max_id . "',
			'" . _DOMAIN_ID . "',
			'" . $blog_id . "',
			'" . $clsBlog->getLink($blog_id) . "',
			'" . $fullname . "',
			'" . $email . "',
			'" . $message . "',
			'" . $clsBlogComment->getMaxOrderNo() . "',
			'" . time() . "',
			'" . $_SERVER['REMOTE_ADDR'] . "'";
		if ($clsBlogComment->insertOne($f, $v)) {
			$oneTable = $clsBlogComment->getOne($max_id);
			$Html = '';
			$Html .= '
			<li>
				<div class="wrap">
					<span class="author">' . $oneTable['fullname'] . '</span>
					<span class="time"> ' . $clsISO->formatDate3($oneTable['reg_date']) . '</span>
				</p>
				<div class="formatTextStandard"><p>' . html_entity_decode($oneTable['message']) . '</p></div>
			</li>
			';
			echo $Html . '$$$_SUCCESS';
			die();
		} else {
			echo '_ERROR';
		}
	}
}
function default_ajUpdateNumViewBlog()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $city_id, $extLang, $clsISO;
	$clsBlog = new Blog();
	$assign_list["clsBlog"] = $clsBlog;
	$clsBlogCategory = new BlogCategory();
	$assign_list["clsBlogCategory"] = $clsBlogCategory;
	#
	$blog_id = $_POST['blog_id'];
	$assign_list['blog_id'] = $blog_id;
	$oneItem = $clsBlog->getOne($blog_id);

	$num_view = $oneItem['num_view'];
	$num_view = $num_view + 1;
	$assign_list["num_view"] = $num_view;

	$clsBlog->updateOne($blog_id, "num_view=$num_view");
	echo (1);
	die();
}
function default_test_form()
{
	global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act, $_LANG_ID, $title_page, $description_page, $keyword_page, $city_id, $extLang, $clsISO;
	$clsBlog = new Blog();
	$assign_list["clsBlog"] = $clsBlog;
	$clsBlogCategory = new BlogCategory();
	$assign_list["clsBlogCategory"] = $clsBlogCategory;

	die('xxx');
	#
	$blog_id = $_POST['blog_id'];
	$assign_list['blog_id'] = $blog_id;
	$oneItem = $clsBlog->getOne($blog_id);

	$num_view = $oneItem['num_view'];
	$num_view = $num_view + 1;
	$assign_list["num_view"] = $num_view;

	$clsBlog->updateOne($blog_id, "num_view=$num_view");
	echo (1);
	die();
}
function default_video()
{
    global $assign_list, $_CONFIG, $core, $dbconn, $mod, $act;
    global $_LANG_ID, $title_page, $description_page, $keyword_page;
    global $domain, $country_id, $city_id, $cat_id, $extLang;
    global $clsISO, $package_id;

    $clsVideo = new Video();
    $assign_list['clsVideo'] = $clsVideo;

    /* =====================================================
     * XÁC ĐỊNH NGÔN NGỮ
     * ===================================================== */
    $langId = '';

    if (!empty($_GET['lang'])) {
        $langId = strtolower(trim((string) $_GET['lang']));
    } elseif (!empty($_GET['lang_id'])) {
        $langId = strtolower(trim((string) $_GET['lang_id']));
    }

    $requestUri = isset($_SERVER['REQUEST_URI'])
        ? (string) $_SERVER['REQUEST_URI']
        : '/';

    $requestPath = parse_url($requestUri, PHP_URL_PATH);

    if (!is_string($requestPath) || $requestPath === '') {
        $requestPath = '/';
    }

    $requestPath = '/' . ltrim($requestPath, '/');

    /* =====================================================
     * XÁC ĐỊNH LANGUAGE TỪ URL
     * ===================================================== */
    if ($langId === '') {

        if (
            preg_match('#^/vn(?:/|$)#i', $requestPath)
            || preg_match(
                '#^/trai-nghiem-video(?:/|$)#i',
                $requestPath
            )
        ) {
            $langId = 'vn';
        } else {
            $langId = 'en';
        }
    }

    /* =====================================================
     * CHUẨN HÓA LANGUAGE
     * ===================================================== */
    if (in_array(
        $langId,
        ['vi', 'vi-vn', 'vietnamese'],
        true
    )) {
        $langId = 'vn';
    }

    if (in_array(
        $langId,
        ['', 'en-us', 'en-gb', 'english'],
        true
    )) {
        $langId = 'en';
    }

    if (!in_array($langId, ['vn', 'en'], true)) {
        $langId = 'en';
    }

    $assign_list['video_lang_id'] = $langId;

    /* =====================================================
     * KEYWORD
     * ===================================================== */
    $keyword = isset($_GET['keyword'])
        ? trim((string) $_GET['keyword'])
        : '';

    $assign_list['keyword'] = $keyword;

    /* =====================================================
     * ĐIỀU KIỆN VIDEO
     * ===================================================== */

    /*
     * QUAN TRỌNG:
     *
     * Không dùng:
     *     AND type_page=0
     *
     * Video trong database của bạn đang thuộc:
     *     mod_page = home
     *     act_page = default
     */
    $cond = "
        is_trash = 0
        AND is_online = 1
        AND mod_page = 'home'
        AND act_page = 'default'
    ";

    /* =====================================================
     * LANGUAGE
     * ===================================================== */
    if ($langId === 'en') {

        $cond .= "
            AND (
                COALESCE(TRIM(lang_id), '') = ''
                OR LOWER(TRIM(COALESCE(lang_id, ''))) = 'en'
            )
        ";

    } else {

        $cond .= "
            AND LOWER(
                TRIM(COALESCE(lang_id, ''))
            ) = 'vn'
        ";
    }

    /* =====================================================
     * KEYWORD
     * ===================================================== */
    if ($keyword !== '') {

        $keywordSlug = $core->replaceSpace($keyword);

        $cond .= "
            AND (
                title LIKE "
            . $dbconn->qstr('%' . $keyword . '%')
            . "
                OR slug LIKE "
            . $dbconn->qstr('%' . $keywordSlug . '%')
            . "
            )
        ";
    }

    /* =====================================================
     * ORDER
     * ===================================================== */
    $orderBy = "
        ORDER BY order_no ASC, video_id DESC
    ";

    /* =====================================================
     * GET VIDEO
     * ===================================================== */
    try {

        $lstVideos = $clsVideo->getAll(
            $cond . $orderBy,
            $clsVideo->pkey . ",
            reg_date,
            title,
            slug,
            image,
            image_mobile,
            type,
            link,
            lang_id"
        );

    } catch (Throwable $exception) {

        error_log(
            'default_video SQL error: '
            . $exception->getMessage()
            . ' | lang=' . $langId
            . ' | condition='
            . preg_replace('/\s+/', ' ', $cond)
        );

        $lstVideos = [];
    }

    if (!is_array($lstVideos)) {
        $lstVideos = [];
    }

    /* =====================================================
     * FORMAT DATE
     * ===================================================== */
    foreach ($lstVideos as $key => $video) {

        $regDate = isset($video['reg_date'])
            ? $video['reg_date']
            : '';

        $timestamp = 0;

        if (is_numeric($regDate)) {
            $timestamp = (int) $regDate;
        } elseif ($regDate !== '') {
            $timestamp = strtotime($regDate);
        }

        $lstVideos[$key]['reg_date_text'] =
            $timestamp > 0
                ? date('d/m/Y', $timestamp)
                : '';
    }

    /* =====================================================
     * ASSIGN
     * ===================================================== */
    $assign_list['lstVideos'] = $lstVideos;
    $assign_list['totalVideo'] = count($lstVideos);

    $assign_list['page_Seo'] = '';
    $assign_list['page_view'] = '';
    $assign_list['totalPage'] = 1;

    /* =====================================================
     * SEO
     * ===================================================== */
    $title_page =
        $core->get_Lang('Experience Videos')
        . ' | '
        . PAGE_NAME;

    $description_page = $title_page;
    $keyword_page = '';

    $assign_list['title_page'] = $title_page;
    $assign_list['description_page'] = $description_page;
    $assign_list['keyword_page'] = $keyword_page;
}