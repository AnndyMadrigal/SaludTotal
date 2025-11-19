<?php

    function ShowCSS()
    {
        echo '
        <head>
            <meta charset="utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
            <title>Proyecto Web MN</title>
            <meta name="description" content="" />
            
            <link rel="stylesheet" href="../css/boxicons.css" />
            <link rel="stylesheet" href="../css/core.css" class="template-customizer-core-css" />
            <link rel="stylesheet" href="../css/theme-default.css" class="template-customizer-theme-css" />
            <link rel="stylesheet" href="../css/demo.css" />
            <link rel="stylesheet" href="../css/perfect-scrollbar.css" />
            <link rel="stylesheet" href="../css/page-auth.css" />
            <script src="../js/helpers.js"></script>
            <script src="../js/config.js"></script>
        </head>';
    }

    function ShowJS()
    {
      echo '
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
        <script src="../js/popper.js"></script>
        <script src="../js/bootstrap.js"></script>
        <script src="../js/perfect-scrollbar.js"></script>
        <script src="../js/menu.js"></script>
        <script src="../js/main.js"></script>
        <script async defer src="https://buttons.github.io/buttons.js"></script>';
    }

?>