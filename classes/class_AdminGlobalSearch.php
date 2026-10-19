<?php

class AdminGlobalSearch
{
    private $limitPerModule = 5;

    public function search($keyword = '')
    {
        global $core, $dbconn;

        $keyword = trim(strip_tags((string)$keyword));
        if (strlen($keyword) < 2) {
            return array();
        }

        $like = $dbconn->qstr('%' . $keyword . '%');
        $results = array();

        $modules = array(
            array('access' => 'tour', 'type' => 'Tour', 'icon' => 'fa fa-map', 'model' => 'Tour', 'id' => 'tour_id', 'fields' => 'tour_id,title', 'condition' => "is_trash=0 and title LIKE {$like}", 'mod' => 'tour_exhautive'),
            array('access' => 'hotel', 'type' => 'Hotel', 'icon' => 'fa fa-building', 'model' => 'Hotel', 'id' => 'hotel_id', 'fields' => 'hotel_id,title', 'condition' => "is_trash=0 and title LIKE {$like}", 'mod' => 'hotel'),
            array('access' => 'news', 'type' => 'News', 'icon' => 'fa fa-newspaper-o', 'model' => 'News', 'id' => 'news_id', 'fields' => 'news_id,title', 'condition' => "is_trash=0 and title LIKE {$like}", 'mod' => 'news'),
            array('access' => 'blog', 'type' => 'Blog', 'icon' => 'fa fa-file-text-o', 'model' => 'Blog', 'id' => 'blog_id', 'fields' => 'blog_id,title', 'condition' => "is_trash=0 and title LIKE {$like}", 'mod' => 'blog')
        );

        foreach ($modules as $module) {
            if (!$core->checkAccess($module['access'])) {
                continue;
            }
            $modelClass = $module['model'];
            $model = new $modelClass();
            $items = $model->getAll($module['condition'] . ' order by ' . $module['id'] . ' desc limit 0,' . $this->limitPerModule, $module['fields']);
            foreach ($items as $item) {
                $id = (int)$item[$module['id']];
                $results[] = array(
                    'type' => $module['type'],
                    'icon' => $module['icon'],
                    'title' => html_entity_decode(strip_tags($item['title']), ENT_QUOTES, 'UTF-8'),
                    'url' => PCMS_URL . '/index.php?mod=' . $module['mod'] . '&act=edit&' . $module['id'] . '=' . $core->encryptID($id)
                );
            }
        }

        if ($core->checkAccess('booking')) {
            $booking = new Booking();
            $bookingCondition = "booking_code LIKE {$like} or contact_name LIKE {$like} or full_name LIKE {$like} or email LIKE {$like}";
            $bookings = $booking->getAll('(' . $bookingCondition . ') order by booking_id desc limit 0,' . $this->limitPerModule, 'booking_id,booking_code,contact_name,full_name,email');
            foreach ($bookings as $item) {
                $id = (int)$item['booking_id'];
                $contact = !empty($item['contact_name']) ? $item['contact_name'] : (!empty($item['full_name']) ? $item['full_name'] : $item['email']);
                $title = trim($item['booking_code'] . (!empty($contact) ? ' - ' . $contact : ''));
                $results[] = array(
                    'type' => 'Booking',
                    'icon' => 'fa fa-briefcase',
                    'title' => html_entity_decode(strip_tags($title), ENT_QUOTES, 'UTF-8'),
                    'url' => PCMS_URL . '/index.php?mod=booking&act=edit&action=list_booking&booking_id=' . $core->encryptID($id)
                );
            }
        }

        return $results;
    }
}
