<?php
	require "../config/vars.php";
	
	if(isset($_SESSION["user"]))
		unset($_SESSION["user"]);
?>
<html>
<head>
    <title id="pageTitle"><?php echo $messages["tooter.logout"] ?></title>
    <link href="<?php echo $base_directory; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo $base_directory; ?>/assets/img/favicon.ico"/>

</head>
<body style="padding-top: 15px;">
<div class="container-fluid">
    <div class="hero-unit">
        <h3><?php echo $messages["logout.message"] ?></h3>

        <a class="btn btn-primary" href="login.php"><?php echo $messages["logout.login.page"] ?></a>
    </div>
</div>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="<?php echo $base_directory; ?>/assets/js/bootstrap.min.js"></script>
</body>
</html>