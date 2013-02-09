<?php
	require "../config/vars.php";
	
	
	
?>
<html>
<head>
    <title id="pageTitle"><?=$messages["signUp.now"]?></title>
    <link href="<?=$base_directory ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/vnd.microsoft.icon" href="<c:url value='/assets/img/favicon.ico'/>"/>
</head>
<body style="padding-top: 15px;">
<div class="container-fluid">
    <div class="hero-unit">
        <h3><?=$messages["reset.password.title"]?></h3>
        <div class="control-group">
			<?=$messages["reset.password.submission.message"]?>
        </div>
        <div class="control-group">
            <div class="controls">
                <a class="btn btn-primary" href="login.php"><?=$messages["reset.password.return.to.login"]?></a>
            </div>
        </div>
    </div>
</div>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="<?=$base_directory ?>/assets/js/bootstrap.min.js"></script>
</body>
</html>