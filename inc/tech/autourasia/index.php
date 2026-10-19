<?php
$image = $_GET['image'];
$time = time();
?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Autour Asia</title>
    <meta http-equiv="refresh" content="100">
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .wrap {
            width: auto;
            margin: 0px auto;
        }
    </style>
</head>

<body leftmargin="0" rightmargin="0">
    <div class="wrap">
        <img src="<?= $image ?>?v=<?= $time ?>" width="100%" />
    </div>

</html>