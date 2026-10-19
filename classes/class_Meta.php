<?php
class Meta extends dbBasic
{
    function __construct()
    {
        $this->pkey = "meta_id";
        $this->tbl = DB_PREFIX . "meta";
    }

    function checkExist($pvalTable = 0, $clsTable = '')
    {
        $clsClassTable = new $clsTable();
        $cur_link = $clsClassTable->getPermalink($pvalTable);
        $res = $this->getAll("config_value_permalink='$cur_link' limit 0,1");
        return (!empty($res)) ? 1 : 0;
    }

    function getByCurrentLink($pvalTable = 0, $clsTable = '')
    {
        $clsClassTable = new $clsTable();
        $cur_link = $clsClassTable->getPermalink($pvalTable);
        $meta_id = $this->getByPermalink($cur_link);
        return $meta_id;
    }

    function replaceTitle($pvalTable = 0, $clsTable = '')
    {
        $clsClassTable = new $clsTable();
        $title = $clsClassTable->getTitle($pvalTable);
        return $title;
    }

    function getByPermalink($config_value_permalink = '')
    {
        $all = $this->getAll("is_trash=0 and (config_value_permalink='$config_value_permalink') order by " . $this->pkey . " limit 0,1");
        return $all[0][$this->pkey];
    }

    function getValue($link = '')
    {
        global $_LANG_ID;
        $one = $this->getAll("config_link='$link'");
        return $one[0] ?? [];
    }

    function getMetaTitle($meta_id = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($meta_id, 'config_value_title');
        return $one['config_value_title'] ?? '';
    }
    function getCountMetaTitle($meta_id = 0)
    {
        global $_LANG_ID;
        $meta_title = $this->getMetaTitle($meta_id);
        return  str_word_count($meta_title ?? '');
    }


    function getMetaDescription($meta_id = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($meta_id, 'config_value_intro');
        return strip_tags(html_entity_decode($one['config_value_intro'] ?? ''));
    }

    function getCountMetaDescription($meta_id = 0)
    {
        global $_LANG_ID;
        $meta_description = $this->getMetaDescription($meta_id);
        return  str_word_count($meta_description ?? '');
    }

    function getMetaImage($pvalTable = 0, $w = 0, $h = 0, $oneTable = null)
    {
        global $clsISO, $clsConfiguration;
        if (!isset($oneTable['image'])) {
            $oneTable = $this->getOne($pvalTable, "image");
        }
        if ($oneTable['image'] != '') {
            $image = $oneTable['image'];
            return "/files/thumb?w=$w&h=$h&src={$clsISO->parseImageURL($image)}";
        } else {
            return $clsConfiguration->getValue('ImageShareSocial');
        }
    }

    function getMetaKeyword($meta_id = 0)
    {
        global $_LANG_ID;
        $one = $this->getOne($meta_id, 'config_value_keyword');
        return $one['config_value_keyword'] ?? '';
    }

    function getStatus($field = '', $pvalTable = 0)
    {
        if ($field == 'title') {
            $title = $this->getMetaTitle($pvalTable);
            $number = strlen($title);
            if ($number > 70) {
                return '<strong style="color:red">' . $number . '</strong>';
            }
        }
        if ($field == 'description') {
            $description = $this->getMetaDescription($pvalTable);
            $number = strlen($description);
            if ($number > 160) {
                return '<strong style="color:red">' . $number . '</strong>';
            }
            if ($number < 70) {
                return '<strong style="color:#ccc">' . $number . '</strong>';
            }
        }
        if ($field == 'keyword') {
            return '<strong style="color:#0C0">Good</strong>';
        }

        $status_ok = '<strong style="color:#0C0">' . $number . '</strong>';
        $status_failed = '<strong style="color:red">' . $number . '</strong>';
        $status_failed_short = '<strong style="color:red">' . $number . '</strong>';
        return $status_ok;
    }

    function getConfigLink($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'config_link');
        return $one['config_link'] ?? '';
    }
    function getConfigLinkViewGoogleSearch($pvalTable = 0)
    {
        $one = $this->getOne($pvalTable, 'config_link');
        return str_replace('/', ' › ', str_replace('.html', '', $one['config_link'] ?? ''));
    }


    //schema custom
    public function getSchemaMarkupFromPost($field_name = 'iso-schema_markup')
    {
        $schema_markup = isset($_POST[$field_name])
            ? $_POST[$field_name]
            : '';

        return $this->prepareSchemaMarkup($schema_markup);
    }

    public function prepareSchemaMarkup($schema_markup)
    {
        $schema_markup = trim($schema_markup);

        // Cho phép để trống
        if ($schema_markup === '') {
            return array(
                'success' => true,
                'data' => ''
            );
        }

        // Validate
        $validate = $this->validateSchemaMarkup($schema_markup);

        if (!$validate['success']) {
            return array(
                'success' => false,
                'message' => $validate['message'],
                'data' => ''
            );
        }

        // Normalize
        $normalized = $this->normalizeSchemaMarkup($schema_markup);

        if ($normalized === false) {
            return array(
                'success' => false,
                'message' => 'Không thể normalize Schema.',
                'data' => ''
            );
        }

        return array(
            'success' => true,
            'message' => 'Schema hợp lệ.',
            'data' => $normalized
        );
    }

    /**
     * Validate schema JSON
     */
    public function validateSchemaMarkup($schema_markup)
    {
        $schema_markup = trim($schema_markup);

        if ($schema_markup === '') {
            return array(
                'success' => true,
                'message' => '',
                'data' => null
            );
        }

        // Decode HTML entities
        $schema_markup = html_entity_decode(
            $schema_markup,
            ENT_QUOTES,
            'UTF-8'
        );

        $data = json_decode($schema_markup, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return array(
                'success' => false,
                'message' => 'Schema không đúng định dạng JSON: ' . json_last_error_msg(),
                'data' => null
            );
        }

        if (!is_array($data)) {
            return array(
                'success' => false,
                'message' => 'Schema phải là một JSON object hoặc array.',
                'data' => null
            );
        }

        /*
        * 
        * Schema sử dụng @graph
        */
        if (isset($data['@graph'])) {

            if (empty($data['@context'])) {
                return array(
                    'success' => false,
                    'message' => 'Schema sử dụng @graph nhưng thiếu @context.',
                    'data' => null
                );
            }

            if (!is_array($data['@graph']) || empty($data['@graph'])) {
                return array(
                    'success' => false,
                    'message' => '@graph phải là một mảng và không được để trống.',
                    'data' => null
                );
            }

            foreach ($data['@graph'] as $index => $item) {

                if (!is_array($item)) {
                    return array(
                        'success' => false,
                        'message' => 'Schema trong @graph #' . ($index + 1) . ' không hợp lệ.',
                        'data' => null
                    );
                }

                if (empty($item['@type'])) {
                    return array(
                        'success' => false,
                        'message' => 'Schema trong @graph #' . ($index + 1) . ' thiếu @type.',
                        'data' => null
                    );
                }
            }

            return array(
                'success' => true,
                'message' => 'Schema hợp lệ.',
                'data' => $data
            );
        }

        /*
        * 
        * Schema đơn
        */
        if (isset($data['@context']) || isset($data['@type'])) {

            if (!isset($data['@context'])) {
                return array(
                    'success' => false,
                    'message' => 'Schema bắt buộc phải có @context.',
                    'data' => null
                );
            }

            if (!isset($data['@type'])) {
                return array(
                    'success' => false,
                    'message' => 'Schema bắt buộc phải có @type.',
                    'data' => null
                );
            }

        } else {

            /*
             * Nếu là array nhiều schema
             */
            foreach ($data as $index => $item) {

                if (!is_array($item)) {
                    return array(
                        'success' => false,
                        'message' => 'Schema #' . ($index + 1) . ' không hợp lệ.',
                        'data' => null
                    );
                }

                if (!isset($item['@context'])) {
                    return array(
                        'success' => false,
                        'message' => 'Schema #' . ($index + 1) . ' thiếu @context.',
                        'data' => null
                    );
                }

                if (!isset($item['@type'])) {
                    return array(
                        'success' => false,
                        'message' => 'Schema #' . ($index + 1) . ' thiếu @type.',
                        'data' => null
                    );
                }
            }
        }

        return array(
            'success' => true,
            'message' => 'Schema hợp lệ.',
            'data' => $data
        );
    }

    /**
     * Normalize schema JSON
     */
    public function normalizeSchemaMarkup($schema_markup)
    {
        $schema_markup = trim($schema_markup);

        if ($schema_markup === '') {
            return '';
        }

        // Decode HTML entities như &quot;
        $schema_markup = html_entity_decode(
            $schema_markup,
            ENT_QUOTES,
            'UTF-8'
        );

        $data = json_decode($schema_markup, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return false;
        }

        /*
         * JSON_UNESCAPED_UNICODE:
         * giữ tiếng Việt dễ đọc
         *
         * JSON_UNESCAPED_SLASHES:
         * không biến https:// thành https:\/\/
         */
        return json_encode(
            $data,
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
    }
}
