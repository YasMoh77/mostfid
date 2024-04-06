<!DOCTYPE html>
<html lang="ar"> 
<head> 
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php if(isset($keywords)){ echo $keywords;} ?>
    <?php if(isset($description)){ echo $description; } ?>
    <?php if(isset($canonical)){ echo $canonical;} ?>
    <title><?php echo $title;?></title>

	<!-- google fonts --> 
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;800&family=Amiri:wght@700&family=Damion&family=Noto+Kufi+Arabic:wght@300&family=Italianno&family=Noto+Sans+Arabic:wght@300&family=Cairo:wght@300&family=Noto+Nastaliq+Urdu:wght@700&family=Pinyon+Script&family=Readex+Pro:wght@600&family=Tajawal:wght@300;400;700&family=Waterfall&display=swap" rel="stylesheet">
     <!-- site logo -->
    <link rel="shortcut icon" href="layout/images/logo/favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" href="layout/images/logo/apple-touch-icon.png" />
    <link rel="apple-touch-icon" sizes="57x57" href="layout/images/logo/apple-touch-icon-57x57.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="layout/images/logo/apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon" sizes="76x76" href="layout/images/logo/apple-touch-icon-76x76.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="layout/images/logo/apple-touch-icon-114x114.png" />
    <link rel="apple-touch-icon" sizes="120x120" href="layout/images/logo/apple-touch-icon-120x120.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="layout/images/logo/apple-touch-icon-144x144.png" />
    <link rel="apple-touch-icon" sizes="152x152" href="layout/images/logo/apple-touch-icon-152x152.png" />
    <link rel="apple-touch-icon" sizes="180x180" href="layout/images/logo/apple-touch-icon-180x180.png" />
	<!--bootstrap-->
	<link rel="stylesheet" type="text/css" href="<?php echo $css;?>bootstrap.min.css">
	<!--fontawesome-->
	<link rel="stylesheet" type="text/css" href="<?php echo $css;?>all.min.css">
	<!--css-->
	<link rel="stylesheet" media="screen,print" type="text/css" href="layout/css/style.css?v=<?php echo time(); ?>">

</head>
<body class="body">









