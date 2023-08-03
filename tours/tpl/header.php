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


    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
        tinymce.init({
          selector: '.mceEditor',
		  
		  	theme: 'silver',
			force_br_newlines : false,
			force_p_newlines : false,
			forced_root_block : '',
			width: '100%',
			content_css: 'css/content.css',
					  
          plugins: 'advlist lists link image code codesample emoticons insertdatetime table',
          toolbar: 'undo redo | styleselect | bold underline italic strikethrough| alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist | fontsize',
		  
          toolbar_mode: 'floating',
          tinycomments_mode: 'embedded',
          tinycomments_author: 'Author name'
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