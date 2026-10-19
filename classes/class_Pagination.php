<?php

class Pagination
{
    var $total;
    var $number_per_page;
    var $current_page;
    var $class;
    var $current_class;
    var $link;
    var $link_page_1;

    /**/
    function __construct() {}

    function initianize($config = array())
    {
        if (is_array($config) && count($config) > 0) {
            foreach ($config as $k => $v) {
                $this->$k = $v;
            }
        } else {
            print_r('Initialize pagination object faild !');
            die();
        }
    }

    function getTotalPage()
    {
        if ($this->number_per_page <= 0) {
            $this->number_per_page = 1;
        }
        return ceil($this->total / $this->number_per_page);
    }

    function create_links()
    {
        
        global $core, $deviceType;
        $pagination_system = '';
        $pagination_stages = 1;
        $start_page = ($this->current_page - 1) * $this->number_per_page;

        $previous_page = $this->current_page - 1;
        $next_page = $this->current_page + 1;
        $last_page = @ceil($this->total / $this->number_per_page);

        if ($deviceType == 'phone') {
            if ($last_page > 1) {
                // Trang trước
                if ($this->current_page > 1) {
                    $pagination_system .= '<a class="prev page" href="' . $this->link . '&page=' . $previous_page . '" title="' . $previous_page . '"><i class="fa-light fa-angle-left"></i></a>';
                } else {
                    $pagination_system .= '<a class="prev disabled page" href="javascript:void(0);"><i class="fa-light fa-angle-left"></i></a>';
                }

                // Hiển thị phân trang
                if ($last_page <= 3) {
                    for ($page_counter = 1; $page_counter <= $last_page; $page_counter++) {
                        if ($page_counter == $this->current_page) {
                            $pagination_system .= '<a class="current page">' . $page_counter . '</a>';
                        } else {
                            $pagination_system .= '<a class="page" href="' . $this->link . '&page=' . $page_counter . '">' . $page_counter . '</a>';
                        }
                    }
                } else {
                    if ($this->current_page <= 2) {
                        for ($page_counter = 1; $page_counter <= 3; $page_counter++) {
                            if ($page_counter == $this->current_page) {
                                $pagination_system .= '<a class="current page">' . $page_counter . '</a>';
                            } else {
                                $pagination_system .= '<a class="page" href="' . $this->link . '&page=' . $page_counter . '">' . $page_counter . '</a>';
                            }
                        }
                    } elseif ($this->current_page >= $last_page - 1) {
                        for ($page_counter = $last_page - 2; $page_counter <= $last_page; $page_counter++) {
                            if ($page_counter == $this->current_page) {
                                $pagination_system .= '<a class="current page">' . $page_counter . '</a>';
                            } else {
                                $pagination_system .= '<a class="page" href="' . $this->link . '&page=' . $page_counter . '">' . $page_counter . '</a>';
                            }
                        }
                    } else {
                        for ($page_counter = $this->current_page - 1; $page_counter <= $this->current_page + 1; $page_counter++) {
                            if ($page_counter == $this->current_page) {
                                $pagination_system .= '<a class="current page">' . $page_counter . '</a>';
                            } else {
                                $pagination_system .= '<a class="page" href="' . $this->link . '&page=' . $page_counter . '">' . $page_counter . '</a>';
                            }
                        }
                    }
                }

                // Trang tiếp
                if ($this->current_page < $last_page) {
                    $pagination_system .= '<a class="next page" href="' . $this->link . '&page=' . $next_page . '" title="' . $next_page . '"><i class="fa-light fa-angle-right"></i></a>';
                } else {
                    $pagination_system .= '<a class="next disabled page" href="javascript:void();"><i class="fa-light fa-angle-right"></i></a>';
                }
            }
        } else {
            if ($last_page > 1) {
                // Trang trước
                if ($this->current_page > 1) {
                    $pagination_system .= '<a class="prev page" href="' . $this->link . '&page=' . $previous_page . '" title="' . $previous_page . '"><i class="fa-light fa-angle-left"></i></a>';
                } else {
                    $pagination_system .= '<a class="prev disabled page" href="javascript:void(0);"><i class="fa-light fa-angle-left"></i></a>';
                }

                // Hiển thị phân trang
                if ($last_page <= 4) {
                    // Hiển thị tất cả các trang nếu số trang <= 4
                    for ($page_counter = 1; $page_counter <= $last_page; $page_counter++) {
                        if ($page_counter == $this->current_page) {
                            $pagination_system .= '<a class="current page">' . $page_counter . '</a>';
                        } else {
                            $pagination_system .= '<a class="page" href="' . $this->link . '&page=' . $page_counter . '">' . $page_counter . '</a>';
                        }
                    }
                } else {
                    if ($this->current_page <= 2) {
                        // Hiển thị các trang đầu tiên
                        for ($page_counter = 1; $page_counter <= 3; $page_counter++) {
                            if ($page_counter == $this->current_page) {
                                $pagination_system .= '<a class="current page">' . $page_counter . '</a>';
                            } else {
                                $pagination_system .= '<a class="page" href="' . $this->link . '&page=' . $page_counter . '">' . $page_counter . '</a>';
                            }
                        }
                        $pagination_system .= '<a class="page disabled" href="javascript:void();">...</a>';
                        $pagination_system .= '<a class="page" href="' . $this->link . '&page=' . $last_page . '">' . $last_page . '</a>';
                    } elseif ($this->current_page >= $last_page - 1) {
                        // Hiển thị các trang cuối cùng
                        $pagination_system .= '<a class="page" href="' . $this->link . '&page=1">1</a>';
                        $pagination_system .= '<a class="page disabled" href="javascript:void();">...</a>';
                        for ($page_counter = $last_page - 2; $page_counter <= $last_page; $page_counter++) {
                            if ($page_counter == $this->current_page) {
                                $pagination_system .= '<a class="current page">' . $page_counter . '</a>';
                            } else {
                                $pagination_system .= '<a class="page" href="' . $this->link . '&page=' . $page_counter . '">' . $page_counter . '</a>';
                            }
                        }
                    } else {
                        // Hiển thị các trang xung quanh trang hiện tại
                        $pagination_system .= '<a class="page" href="' . $this->link . '&page=1">1</a>';
                        $pagination_system .= '<a class="page disabled" href="javascript:void();">...</a>';
                        for ($page_counter = $this->current_page - 1; $page_counter <= $this->current_page + 1; $page_counter++) {
                            if ($page_counter == $this->current_page) {
                                $pagination_system .= '<a class="current page">' . $page_counter . '</a>';
                            } else {
                                $pagination_system .= '<a class="page" href="' . $this->link . '&page=' . $page_counter . '">' . $page_counter . '</a>';
                            }
                        }
                        $pagination_system .= '<a class="page disabled" href="javascript:void();">...</a>';
                        $pagination_system .= '<a class="page" href="' . $this->link . '&page=' . $last_page . '">' . $last_page . '</a>';
                    }
                }

                // Trang tiếp
                if ($this->current_page < $last_page) {
                    $pagination_system .= '<a class="next page" href="' . $this->link . '&page=' . $next_page . '" title="' . $next_page . '"><i class="fa-light fa-angle-right"></i></a>';
                } else {
                    $pagination_system .= '<a class="next disabled page" href="javascript:void();" title="Next"><i class="fa-light fa-angle-right"></i></a>';
                }
            }
        }
        return $pagination_system;
    }


    function create_links_page($allow_html = false)
    {
        global $core;
        #
        $pagination_system = '';
        $pagination_stages = 1;
        $start_page = ($this->current_page - 1) * $this->number_per_page;
        //This initializes the page setup
        $previous_page = $this->current_page - 1;
        $next_page = $this->current_page + 1;
        $last_page = @ceil($this->total / $this->number_per_page);
        $last_paged = $last_page - 1;
        $last_link = ($allow_html ? '.html' : '/');
        if ($this->link_page_1 == '') {
            $this->link_page_1 = $this->link . 'page-1' . $last_link;
        }
        // Start
        if ($last_page > 1) {

            // Trang trước
            if ($this->current_page > 1) {
                $pagination_system .= '<a class="prev" href="' . ($previous_page == 1 ? $this->link_page_1 : $this->link . 'page-' . $previous_page . $last_link) . '" title="' . $previous_page . '">' . $core->get_Lang('prev') . '</a>';
            } else {
                $pagination_system .= '<a class="prev disabled" href="javascript:void(0);">' . $core->get_Lang('prev') . '</a>';
            }

            // Nếu không đủ trang tới lúc điểm ngắt
            if ($last_page < 7 + ($pagination_stages * 2)) {
                for ($page_counter = 1; $page_counter <= $last_page; $page_counter++) {
                    if ($page_counter == $this->current_page) {
                        $pagination_system .= '<a class="current page">' . $page_counter . '</a>';
                    } else {
                        $pagination_system .= '<a class="page" href="' . ($page_counter == 1 ? $this->link_page_1 : $this->link . 'page-' . $page_counter . $last_link) . '">' . $page_counter . '</a>';
                    }
                }
            } elseif ($last_page > 5 + ($pagination_stages * 2)) {
                if ($this->current_page < 1 + ($pagination_stages * 2)) {
                    for ($page_counter = 1; $page_counter < 4 + ($pagination_stages * 2); $page_counter++) {
                        if ($page_counter == $this->current_page) {
                            $pagination_system .= '<a class="current page" href="javascript:void();">' . $page_counter . '</a>';
                        } else {
                            $pagination_system .= '<a class="page" href="' . ($page_counter == 1 ? $this->link_page_1 : $this->link . 'page-' . $page_counter . $last_link) . '" title="' . $page_counter . '">' . $page_counter . '</a>';
                        }
                    }
                    $pagination_system .= '<a class="page disabled" href="javascript:void();">...</a>';
                    $pagination_system .= '<a class="page" href="' . $this->link . 'page-' . $last_paged . $last_link . '" title="' . $last_paged . '">' . $last_paged . '</a>';
                    $pagination_system .= '<a class="page" href="' . $this->link . 'page-' . $last_page . $last_link . '" title="' . $last_page . '">' . $last_page . '</a>';
                } elseif ($last_page - ($pagination_stages * 2) > $this->current_page && $this->current_page > ($pagination_stages * 2)) {
                    $pagination_system .= '<a class="page" href="' . $this->link_page_1 . '" title="1">1</a>';
                    $pagination_system .= '<a class="page" href="' . $this->link . 'page-2' . $last_link . '" title="2">2</a>';
                    $pagination_system .= '<a class="page" href="javascript:void();">...</a>';
                    for ($page_counter = ($this->current_page - $pagination_stages); $page_counter <= ($this->current_page + $pagination_stages); $page_counter++) {
                        if ($page_counter == $this->current_page) {
                            $pagination_system .= '<a class="current page" href="javascript:void();">' . $page_counter . '</a>';
                        } else {
                            $pagination_system .= '<a class="page" href="' . ($page_counter == 1 ? $this->link_page_1 : $this->link . 'page-' . $page_counter . $last_link) . '" title="' . $page_counter . '">' . $page_counter . '</a>';
                        }
                    }
                    $pagination_system .= '<a class="page disabled" href="javascript:void();">...</a>';
                    $pagination_system .= '<a class="page" href="' . $this->link . 'page-' . $last_paged . $last_link . '" title="' . $last_paged . '">' . $last_paged . '</a>';
                    $pagination_system .= '<a class="page" href="' . $this->link . 'page-' . $last_page . $last_link . '" title="' . $last_page . '">' . $last_page . '</a>';
                } else {
                    $pagination_system .= '<a class="page" href="' . $this->link_page_1 . '" title="1">1</a>';
                    $pagination_system .= '<a class="page" href="' . $this->link . 'page-2' . $last_link . '" title="2">2</a>';
                    $pagination_system .= '<a class="page" href="javascript:void();" >...</a>';
                    for ($page_counter = $last_page - (2 + ($pagination_stages * 2)); $page_counter <= $last_page; $page_counter++) {
                        if ($page_counter == $this->current_page) {
                            $pagination_system .= '<a class="current page" href="javascript:void();" >' . $page_counter . '</a>';
                        } else {
                            $pagination_system .= '<a class="page" href="' . ($page_counter == 1 ? $this->link_page_1 : $this->link . 'page-' . $page_counter . $last_link) . '" title="' . $page_counter . '">' . $page_counter . '</a>';
                        }
                    }
                }
            }

            //Trang tiếp
            if ($this->current_page < $page_counter - 1) {
                $pagination_system .= '<a class="next" href="' . $this->link . 'page-' . $next_page . $last_link . '" title="' . $next_page . '">' . $core->get_Lang('next') . '</a>';
            } else {
                $pagination_system .= '<a class="next disabled" rel="nofollow" href="javascript:void();">' . $core->get_Lang('next') . '</a>';
            }
        }
        return $pagination_system;
    }

    function pagination_ajax($total = 0, $number_per_page = 0, $current_page = 1, $class = 'paginate_button', $classCurrent = 'paginate_active', $is_showinfo = true)
    {
        global $core;
        #
        $pagination_system = '';
        $pagination_stages = 2;
        $start_page = ($current_page - 1) * $number_per_page;
        //This initializes the page setup
        $previous_page = $current_page - 1;
        $next_page = $current_page + 1;
        $last_page = @ceil($total / $number_per_page);
        $last_paged = $last_page - 1;
        // Start
        if ($is_showinfo) {
            $pagination_system .= '<div class="dataTable_length">';
            $pagination_system .= $core->get_Lang('numberrecord');
            $pagination_system .= '<select class="paginate_length">';
            $pagination_system .= '<option ' . ($number_per_page == 5 ? 'selected="selected"' : '') . ' value="5">5</option>';
            $pagination_system .= '<option ' . ($number_per_page == 10 ? 'selected="selected"' : '') . ' value="10">10</option>';
            $pagination_system .= '<option ' . ($number_per_page == 20 ? 'selected="selected"' : '') . ' value="20">20</option>';
            $pagination_system .= '<option ' . ($number_per_page == 30 ? 'selected="selected"' : '') . ' value="30">30</option>';
            $pagination_system .= '<option ' . ($number_per_page == 40 ? 'selected="selected"' : '') . ' value="40">40</option>';
            $pagination_system .= '</select>';
            $pagination_system .= ' / page';
            $pagination_system .= '</div>';
        }
        if ($last_page > 1) {
            $pagination_system .= '<div class="dataTable_paginate">';
            // Trang trước
            if ($current_page > 1) {
                $pagination_system .= "<a class=\"prev paginate_button\" href=\"javascript:void(0);\" page=" . $previous_page . ">" . $core->get_Lang('prev') . "</a>";
            } else {
                $pagination_system .= "<a class=\"prev paginate_button disabled paginate_button_disabled\" href=\"javascript:void(0);\">" . $core->get_Lang('prev') . "</a>'</a>";
            }
            // Nếu không đủ trang tới điểm ngắt
            if ($last_page < 7 + ($pagination_stages * 2)) {
                $pagination_system .= '<span>';
                for ($page_counter = 1; $page_counter <= $last_page; $page_counter++) {
                    if ($page_counter == $current_page) {
                        $pagination_system .= "<a class='paginate_active'>$page_counter</a>";
                    } else {
                        $pagination_system .= "<a class='paginate_button' page=" . $page_counter . " href='javascript:void(0);'>$page_counter</a>";
                    }
                }
                $pagination_system .= '</span>';
            } elseif ($last_page > 5 + ($pagination_stages * 2)) {
                if ($current_page < 1 + ($pagination_stages * 2)) {
                    $pagination_system .= '<span>';
                    for ($page_counter = 1; $page_counter < 4 + ($pagination_stages * 2); $page_counter++) {
                        if ($page_counter == $current_page) {
                            $pagination_system .= "<a class=\"paginate_active\" href=\"javascript:void();\">$page_counter</a>";
                        } else {
                            $pagination_system .= "<a class=\"paginate_button\" href='javascript:void();' page=" . $page_counter . ">$page_counter</a>";
                        }
                    }
                    $pagination_system .= "<a class=\"paginate_button disabled\" href=\"javascript:void();\">...</a>";
                    $pagination_system .= "<a class=\"paginate_button\" href=\"avascript:void();\" page=" . $last_paged . ">$last_paged</a>";
                    $pagination_system .= "<a class=\"paginate_button\" href=\"javascript:void();\" page=" . $last_page . ">$last_page</a>";
                    $pagination_system .= '</span>';
                } elseif ($last_page - ($pagination_stages * 2) > $current_page && $current_page > ($pagination_stages * 2)) {
                    $pagination_system .= '<span>';
                    $pagination_system .= "<a class=\"paginate_button\" href=\"javascript:void();\" page=\"1\">1</a>";
                    $pagination_system .= "<a class=\"paginate_button\" href=\"javascript:void();\" page=\"2\">2</a>";
                    $pagination_system .= "<a class=\"paginate_button disabled\" href=\"javascript:void();\">...</a>";
                    for ($page_counter = ($current_page - $pagination_stages); $page_counter <= ($current_page + $pagination_stages); $page_counter++) {
                        if ($page_counter == $current_page) {
                            $pagination_system .= "<a class=\"paginate_active\" href=\"javascript:void();\">$page_counter</a>";
                        } else {
                            $pagination_system .= "<a class=\"paginate_button\" href='javascript:void(0);' page=" . $page_counter . ">$page_counter</a>";
                        }
                    }
                    $pagination_system .= "<a class=\"paginate_button disabled\" href=\"javascript:void();\">...</a>";
                    $pagination_system .= "<a class=\"paginate_button\" href=\"javascript:void();\" page=" . $last_paged . ">$last_paged</a>";
                    $pagination_system .= "<a class=\"paginate_button\" href=\"javascript:void();\" page=" . $last_page . ">$last_page</a>";
                    $pagination_system .= '</span>';
                } else {
                    $pagination_system .= '<span>';
                    $pagination_system .= "<a class=\"paginate_button\" href=\"javascript:void();\" page=\"1\">1</a>";
                    $pagination_system .= "<a class=\"paginate_button\" href=\"javascript:void();\" page=\"2\">2</a>";
                    $pagination_system .= "<a class=\"paginate_button disabled\" href=\"javascript:void();\">...</a>";
                    for ($page_counter = $last_page - (2 + ($pagination_stages * 2)); $page_counter <= $last_page; $page_counter++) {
                        if ($page_counter == $current_page) {
                            $pagination_system .= "<a class=\"paginate_active\" href=\"javascript:void();\">$page_counter</a>";
                        } else {
                            $pagination_system .= "<a class=\"paginate_button\" href=\"javascript:void();\" page='" . $page_counter . "'>$page_counter</a>";
                        }
                    }
                    $pagination_system .= '</span>';
                }
            }
            //Trang tiếp
            if ($current_page < $page_counter - 1) {
                $pagination_system .= "<a class=\"next paginate_button\" href=\"javascript:void();\" page=" . $next_page . ">" . $core->get_Lang('next') . "</a>";
            } else {
                $pagination_system .= "<a class=\"next paginate_button disabled paginate_button_disabled\" href=\"javascript:void();\">" . $core->get_Lang('next') . "</a>";
            }
            $pagination_system .= '<input type="hidden" value="' . $current_page . '" name="paginate_current_page" class="paginate_current_page" id="Hid_CurrentPage">';
            $pagination_system .= '</div>';
        }
        return $pagination_system;
    }
}
