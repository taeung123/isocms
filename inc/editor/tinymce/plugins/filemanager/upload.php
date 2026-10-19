<?php

// ==============================
// upload.php (SECURE + COMPATIBLE)enchance her breast
// ==============================

require_once 'session_bootstrap.php';

if (
    empty($_SESSION["verify"]) ||
    $_SESSION["verify"] !== "FileManager4TinyMCE"
) {
    http_response_code(403);
    exit('Forbidden');
}

require_once 'config.php';
require_once 'utils.php';

// ==============================
// CSRF CHECK
// ==============================

if (
    empty($_POST['csrf_token']) ||
    empty($_SESSION['csrf_token']) ||
    !hash_equals(
        $_SESSION['csrf_token'],
        $_POST['csrf_token']
    )
) {

    http_response_code(403);
    exit('Invalid CSRF token');
}

// ==============================
// DETECT CURRENT FOLDER
// ==============================

$fldr = '';

// ưu tiên fldr
if (
    isset($_POST['fldr']) &&
    $_POST['fldr'] !== ''
) {

    $fldr = trim($_POST['fldr'], '/');
}

// fallback path
elseif (
    isset($_POST['path']) &&
    $_POST['path'] !== ''
) {

    $rawPath = str_replace(
        '\\',
        '/',
        $_POST['path']
    );

    /*
    ví dụ:
    ../../../../../uploads/news/2026/

    => lấy phần sau uploads/
    */

    if (
        preg_match(
            '#uploads/(.*)$#',
            $rawPath,
            $m
        )
    ) {

        $fldr = trim($m[1], '/');
    }
}

// ==============================
// SECURITY CHECK
// ==============================

if (
    preg_match(
        '#\.\.|[<>:"|?*]#',
        $fldr
    )
) {

    http_response_code(400);
    exit('Invalid folder path');
}

// ==============================
// BASE PATHS
// ==============================

// REAL uploads dir on disk
$uploadsBase = realpath(
    $_SERVER['DOCUMENT_ROOT']
    . '/uploads'
);

if (!$uploadsBase) {

    http_response_code(500);
    exit('Uploads base missing');
}

// REAL thumbs dir
$thumbsBase =
    $uploadsBase
    . DIRECTORY_SEPARATOR
    . 'thumbs';

// ==============================
// FINAL TARGET PATHS
// ==============================

$targetPath =
    $uploadsBase
    . DIRECTORY_SEPARATOR
    . $fldr;

$targetThumbPath =
    $thumbsBase
    . DIRECTORY_SEPARATOR
    . $fldr;

// normalize
$targetPath = rtrim(
    str_replace('\\', '/', $targetPath),
    '/'
);

$targetThumbPath = rtrim(
    str_replace('\\', '/', $targetThumbPath),
    '/'
);

// ==============================
// ENSURE INSIDE UPLOADS
// ==============================

if (
    strpos($targetPath, $uploadsBase) !== 0
) {

    http_response_code(400);
    exit('Traversal detected');
}

if (
    strpos($targetThumbPath, $thumbsBase) !== 0
) {

    http_response_code(400);
    exit('Traversal detected');
}

// ==============================
// CREATE DIRECTORIES
// ==============================

if (!is_dir($targetPath)) {

    if (
        !mkdir(
            $targetPath,
            0755,
            true
        )
    ) {

        http_response_code(500);
        exit('Cannot create upload dir');
    }
}

if (!is_dir($targetThumbPath)) {

    if (
        !mkdir(
            $targetThumbPath,
            0755,
            true
        )
    ) {

        http_response_code(500);
        exit('Cannot create thumb dir');
    }
}

// ==============================
// UPLOAD FILE
// ==============================

if (
    !empty($_FILES) &&
    isset($_FILES['file']) &&
    $upload_files
) {

    $file = $_FILES['file'];

    // ==============================
    // VALIDATE FILE
    // ==============================

    $validation =
        validateUploadFile($file);

    if (!$validation['status']) {

        http_response_code(400);

        exit(
            htmlspecialchars(
                $validation['message'],
                ENT_QUOTES,
                'UTF-8'
            )
        );
    }

    $ext = $validation['extension'];

    // ==============================
    // SAFE RANDOM NAME
    // ==============================

    /*$newFileName =
        date('YmdHis')
        . '_'
        . bin2hex(random_bytes(8))
        . '.'
        . $ext;*/
	$originalName =
		$_FILES['file']['name'];

	$seoName =
		sanitizeFileName(
			$originalName
		);
	if($sufix_file_name){
		$newFileName =
			$seoName
			. '_'
			. substr(
				bin2hex(random_bytes(4)),0,8)
			. '.'
			. $ext;
	}else{
		$newFileName = $seoName . '.' . $ext;
		$counter = 1;
		while (
			file_exists(
				$targetPath . '/' . $newFileName
			)
		) {
			$newFileName =
				$seoName
				. '-'
				. $counter
				. '.'
				. $ext;

			$counter++;
		}
	}
	

    $targetFile =
        $targetPath
        . '/'
        . $newFileName;

    $targetThumbFile =
        $targetThumbPath
        . '/'
        . $newFileName;

    // ==============================
    // MOVE FILE
    // ==============================

    if (
        !move_uploaded_file(
            $file['tmp_name'],
            $targetFile
        )
    ) {

        http_response_code(500);
        exit('Cannot save file');
    }

    // ==============================
    // IMAGE PROCESSING
    // ==============================

    $isImage =
        in_array(
            $ext,
            $ext_img
        );

    if ($isImage) {

        // validate really image
        $imginfo =
            @getimagesize($targetFile);

        if (!$imginfo) {

            @unlink($targetFile);

            http_response_code(400);

            exit('Invalid image');
        }

        // ==============================
        // RE-ENCODE IMAGE
        // strip metadata / polyglot payload
        // ==============================

        if (
            !reEncodeImage(
                $targetFile,
                $ext
            )
        ) {

            @unlink($targetFile);

            http_response_code(400);

            exit('Invalid image');
        }

        // ==============================
        // CREATE THUMB
        // ==============================

        create_img_gd(
            $targetFile,
            $targetThumbFile,
            122,
            91
        );

        // ==============================
        // AUTO RESIZE
        // ==============================

        if ($image_resizing) {

            $srcWidth  = $imginfo[0];
            $srcHeight = $imginfo[1];

            $newWidth  = $image_width;
            $newHeight = $image_height;

            if (
                $newWidth == 0 &&
                $newHeight == 0
            ) {

                $newWidth  = $srcWidth;
                $newHeight = $srcHeight;

            } elseif ($newWidth == 0) {

                $newWidth =
                    intval(
                        $newHeight
                        * $srcWidth
                        / $srcHeight
                    );

            } elseif ($newHeight == 0) {

                $newHeight =
                    intval(
                        $newWidth
                        * $srcHeight
                        / $srcWidth
                    );
            }

            create_img_gd(
                $targetFile,
                $targetFile,
                $newWidth,
                $newHeight
            );
        }

        // ==============================
        // MAX SIZE LIMIT
        // ==============================

        $imginfo =
            @getimagesize($targetFile);

        if ($imginfo) {

            $srcWidth  = $imginfo[0];
            $srcHeight = $imginfo[1];

            $resize = false;

            if (
                $image_max_width > 0 &&
                $srcWidth > $image_max_width
            ) {

                $resize = true;

                $srcHeight =
                    intval(
                        $image_max_width
                        * $srcHeight
                        / $srcWidth
                    );

                $srcWidth =
                    $image_max_width;
            }

            if (
                $image_max_height > 0 &&
                $srcHeight > $image_max_height
            ) {

                $resize = true;

                $srcWidth =
                    intval(
                        $image_max_height
                        * $srcWidth
                        / $srcHeight
                    );

                $srcHeight =
                    $image_max_height;
            }

            if ($resize) {

                create_img_gd(
                    $targetFile,
                    $targetFile,
                    $srcWidth,
                    $srcHeight
                );
            }
        }
    }
}

// ==============================
// REDIRECT
// ==============================

if (isset($_POST['submit'])) {

// ==============================
// REDIRECT / RELOAD FILE MANAGER
// ==============================

$query = http_build_query([
    'type'      => $_POST['type'] ?? ($_GET['type'] ?? ''),
    'lang'      => $_POST['lang'] ?? ($_GET['lang'] ?? ''),
    'subfolder' => $_POST['subfolder'] ?? ($_GET['subfolder'] ?? ''),
    'popup'     => $_POST['popup'] ?? ($_GET['popup'] ?? ''),
    'field_id'  => $_POST['field_id'] ?? ($_GET['field_id'] ?? ''),
    'editor'    => $_POST['editor'] ?? ($_GET['editor'] ?? ''),
    'fldr'      => $_POST['fldr'] ?? ($_GET['fldr'] ?? ''),
]);

header('Location: dialog.php?' . $query);
exit;
}