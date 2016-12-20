<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="AHF PHP"/>
    <meta name="description" content="AHF for php">
    <meta name="author" content="">

    <title>
        <?php
            $view_title = getViewTitle();
            echo isset($view_title)?$view_title.'|AHF':'AHF'
        ?>
    </title>
    <link rel="shortcut icon" href="../../images/favicon.ico" />
    <!-- Bootstrap Core CSS -->
    <link href="../../css/bootstrap.css" rel="stylesheet">
    <link href="../../css/common.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link rel="stylesheet" href="../../fonts/font-awesome/css/font-awesome.min.css">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="http://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
    <?php include_once getViewBody()?>

</body>
</html>

