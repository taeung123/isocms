<?php

class VoucherImportService
{
    const MAX_ROWS = 10000;

    /**
     * Read Excel file and convert to voucher array
     */
    public static function readExcel($filePath)
    {
        $result = array(
            'status' => 'success',
            'total' => 0,
            'valid' => 0,
            'invalid' => 0,
            'data' => array()
        );

        if (!file_exists($filePath)) {
            return array(
                'status' => 'error',
                'message' => 'File does not exist'
            );
        }

        /*
         * Load PHPExcel
         */
        require_once DIR_INCLUDES . '/phpexcel/PHPExcel.php';
        require_once DIR_INCLUDES . '/phpexcel/PHPExcel/IOFactory.php';

        try {

            $objPHPExcel = PHPExcel_IOFactory::load($filePath);

        } catch (Exception $e) {

            return array(
                'status' => 'error',
                'message' => 'Cannot read Excel file: ' . $e->getMessage()
            );
        }

        $sheet = $objPHPExcel->getActiveSheet();

        $highestRow = $sheet->getHighestRow();

        /*
         * Header row = 1
         * Data starts from row = 2
         */
        if ($highestRow < 2) {

            return array(
                'status' => 'error',
                'message' => 'Excel file does not contain any data'
            );
        }

        /*
         * Maximum 10,000 vouchers
         */
        $dataRows = $highestRow - 1;

        if ($dataRows > self::MAX_ROWS) {

            return array(
                'status' => 'error',
                'message' => 'Maximum ' . self::MAX_ROWS . ' voucher codes per file'
            );
        }

        /*
         * Read header
         */
        $headers = self::readHeaders($sheet);

        /*
         * Check required header
         */
        $headerMap = self::mapHeaders($headers);

        if (empty($headerMap['voucher_code'])) {

            return array(
                'status' => 'error',
                'message' => 'Missing required column: Voucher Code'
            );
        }

        /*
         * Duplicate checker inside Excel
         */
        $excelCodes = array();

        for ($row = 2; $row <= $highestRow; $row++) {

            $item = array(
                'row' => $row,
                'voucher_code' => '',
                'start_date' => '',
                'expiry_date' => '',
                'price' => 0,
                'usage_limit' => 1,
                'notes' => '',
                'valid' => true,
                'errors' => array()
            );

            /*
             * Voucher Code
             */
            if ($headerMap['voucher_code'] !== false) {

                $cell = $sheet->getCell(
                    $headerMap['voucher_code'] . $row
                );

                $code = trim(
                    (string) $cell->getFormattedValue()
                );

                $item['voucher_code'] = $code;
            }

            /*
             * Expiry Date
             */
            if ($headerMap['expiry_date'] !== false) {

                $cell = $sheet->getCell(
                    $headerMap['expiry_date'] . $row
                );

                $expiryValue = $cell->getValue();

                $item['expiry_date'] = self::normalizeDate(
                    $expiryValue
                );
            }

            /*
            * Start Date
            */
            if ($headerMap['start_date'] !== false) {

                $cell = $sheet->getCell(
                    $headerMap['start_date'] . $row
                );

                $startValue = $cell->getValue();

                $item['start_date'] = self::normalizeDate(
                    $startValue
                );
            }

            /*
            * Price
            */
            if ($headerMap['price'] !== false) {

                $value = $sheet->getCell(
                    $headerMap['price'] . $row
                )->getValue();

                $value = trim((string) $value);

                if ($value !== '') {

                    // Cho phép: 1000000
                    // hoặc: 1,000,000
                    // hoặc: 1.000.000
                    $value = str_replace(
                        array(',', '.'),
                        '',
                        $value
                    );

                    if (!is_numeric($value)) {

                        $item['valid'] = false;

                        $item['errors'][] =
                            'Price must be a number';

                    } else {

                        $price = (float) $value;

                        if ($price < 0) {

                            $item['valid'] = false;

                            $item['errors'][] =
                                'Price must be greater than or equal to 0';

                        } else {

                            $item['price'] = $price;
                        }
                    }
                }
            }

            /*
             * Usage Limit
             */
            if ($headerMap['usage_limit'] !== false) {

                $value = $sheet->getCell(
                    $headerMap['usage_limit'] . $row
                )->getValue();

                $value = trim((string) $value);

                if ($value !== '') {

                    if (!is_numeric($value)) {

                        $item['valid'] = false;

                        $item['errors'][] =
                            'Usage Limit must be a number';

                    } else {

                        $value = (int) $value;

                        if ($value <= 0) {

                            $item['valid'] = false;

                            $item['errors'][] =
                                'Usage Limit must be greater than 0';

                        } else {

                            $item['usage_limit'] = $value;
                        }
                    }
                }
            }

            /*
             * Notes
             */
            if ($headerMap['notes'] !== false) {

                $item['notes'] = trim(
                    (string) $sheet->getCell(
                        $headerMap['notes'] . $row
                    )->getFormattedValue()
                );
            }

            /*
             * Ignore completely empty row
             */
            if (
                $item['voucher_code'] === '' &&
                $item['expiry_date'] === '' &&
                $item['notes'] === ''
            ) {
                continue;
            }

            /*
             * Auto generate voucher code
             */
            if ($item['voucher_code'] === '') {

                $item['voucher_code'] =
                    self::generateVoucherCode();
            }

            /*
             * Validate voucher code
             */
            if (strlen($item['voucher_code']) > 100) {

                $item['valid'] = false;

                $item['errors'][] =
                    'Voucher code is too long';
            }

            /*
             * Validate expiry
             */
            if ($item['expiry_date'] === false) {

                $item['valid'] = false;

                $item['errors'][] =
                    'Invalid Expiry Date';
            }

            /*
            * Validate Start Date
            */
            if ($item['start_date'] === false) {

                $item['valid'] = false;

                $item['errors'][] =
                    'Invalid Start Date';
            }

            if (
                $item['start_date'] !== '' &&
                $item['start_date'] !== false &&
                $item['expiry_date'] !== '' &&
                $item['expiry_date'] !== false
            ) {

                if ($item['start_date'] > $item['expiry_date']) {

                    $item['valid'] = false;

                    $item['errors'][] =
                        'Start Date cannot be greater than Expiry Date';
                }
            }

            /*
             * Duplicate inside Excel
             */
            $codeKey = strtoupper(
                trim($item['voucher_code'])
            );

            if (isset($excelCodes[$codeKey])) {

                $item['valid'] = false;

                $item['errors'][] =
                    'Duplicate voucher code in Excel';

            } else {

                $excelCodes[$codeKey] = $row;
            }

            /*
             * Counters
             */
            $result['total']++;

            if ($item['valid']) {

                $result['valid']++;

            } else {

                $result['invalid']++;
            }

            $result['data'][] = $item;
        }

        return $result;
    }


    /**
     * Read Excel headers
     */
    private static function readHeaders($sheet)
    {
        $headers = array();

        for ($col = 0; $col < 20; $col++) {

            $column = PHPExcel_Cell::stringFromColumnIndex($col);

            $value = trim(
                (string) $sheet
                    ->getCell($column . '1')
                    ->getFormattedValue()
            );

            if ($value !== '') {

                $headers[$column] = $value;
            }
        }

        return $headers;
    }


    /**
     * Map Excel header to system field
     */
    private static function mapHeaders($headers)
    {
        $map = array(
            'voucher_code' => false,
            'start_date' => false,
            'expiry_date' => false,
            'price' => false,
            'usage_limit' => false,
            'notes' => false
        );

        foreach ($headers as $column => $header) {

            $key = strtolower(
                trim($header)
            );

            /*
             * Remove special characters
             */
            $key = preg_replace(
                '/[^a-z0-9]+/',
                '_',
                $key
            );

            $key = trim($key, '_');

            switch ($key) {

                case 'voucher_code':
                case 'code':
                    $map['voucher_code'] = $column;
                    break;

                case 'expiry_date':
                case 'expiry':
                case 'expiration_date':
                    $map['expiry_date'] = $column;
                    break;

                case 'usage_limit':
                case 'usage':
                case 'limit':
                    $map['usage_limit'] = $column;
                    break;

                case 'notes':
                case 'note':
                    $map['notes'] = $column;
                    break;
                case 'start_date':
                case 'start':
                case 'valid_from':
                    $map['start_date'] = $column;
                    break;

                case 'price':
                case 'amount':
                    $map['price'] = $column;
                    break;
            }
        }

        return $map;
    }


    /**
     * Convert Excel date to Y-m-d
     */
    private static function normalizeDate($value)
    {
        if ($value === null || $value === '') {
            return '';
        }

        /*
         * Excel serial date
         */
        if (is_numeric($value)) {

            try {

                $timestamp =
                    PHPExcel_Shared_Date::ExcelToPHP(
                        $value
                    );

                return date(
                    'Y-m-d',
                    $timestamp
                );

            } catch (Exception $e) {

                return false;
            }
        }

        $value = trim((string) $value);

        /*
         * Supported formats
         */
        $formats = array(
            'd/m/Y',
            'd-m-Y',
            'Y-m-d',
            'm/d/Y',
            'Y/m/d'
        );

        foreach ($formats as $format) {

            $date = DateTime::createFromFormat(
                $format,
                $value
            );

            if (
                $date &&
                $date->format($format) === $value
            ) {

                return $date->format('Y-m-d');
            }
        }

        return false;
    }


    /**
     * Generate voucher code
     */
    private static function generateVoucherCode()
    {
        return strtoupper(
            'VC-' .
            date('Ymd') .
            '-' .
            substr(
                strtoupper(
                    md5(
                        uniqid(
                            mt_rand(),
                            true
                        )
                    )
                ),
                0,
                8
            )
        );
    }
}