<?php session_start(); ?>


<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    
    <link href="css/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">
    <link href="css/owl.carousel.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-select.min.css" rel="stylesheet" type="text/css">
    <link href="css/fileinput.min.css" rel="stylesheet" type="text/css">
    <link href="css/superlist.css" rel="stylesheet" type="text/css">

	<link rel='icon' href='images/favicon.ico' type='image/x-icon'/ >


<!--- <script src="//cdn.tinymce.com/4/tinymce.min.js"></script> -->
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
 tinymce.init({
	selector: '.mceEditor',
	theme: 'silver',
	force_br_newlines : false,
	force_p_newlines : false,
	forced_root_block : '',
	width: '100%',	
  
    plugins: [
      'advlist autolink link lists image print preview hr table spellchecker',
      'searchreplace wordcount visualblocks visualchars  fullscreen',
      'save contextmenu directionality emoticons paste textcolor'
    ],
    content_css: 'css/content.css',
    toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | print preview fullpage | forecolor backcolor emoticons image'
  }); 
</script>

    <?php 
		include 'inc/configs.php';
 	?>
	
    <meta http-equiv="refresh" content="<?php echo SESSION_DURATION * 1.5 * 60; ?>">
    
    <title><?php echo SITE_NAME; ?></title>
</head>


<body class="">
	<div class="page-wrapper">   