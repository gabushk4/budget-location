<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget Location</title>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link href="<?= URL_ROOT ?>public/assets/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="<?= URL_ROOT ?>public/assets/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js" defer></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">

    <link href="<?= URL_ROOT ?>public/css/style.css" rel="stylesheet">

    <?php 
    if (!empty($jsAdd)) {

        foreach ($jsAdd as $path) {
            echo '<script src="' . $path . '" defer></script>';
        }

    }    

    if (!empty($cssAdd)) {

        foreach ($cssAdd as $path) {
            echo '<link rel="stylesheet" href="' . $path . '" />';
        }

    }  
    ?>
</head>