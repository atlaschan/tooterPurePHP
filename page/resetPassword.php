<?php
	require "../config/vars.php";
	
	$error = null;
	if(isset($_POST["email"]))
	{
		$controller = new tooter_controller_PasswordController($stormpath);
		
		$customer = null;
		$email = $_POST["email"];
		if(!empty($_SESSION["user"]))
		{
			$customer = $_SESSION["user"];
			$email = $customer->getEmail();
		}
		$status = $controller->processResetPassword($customer, $email);
		if(!empty($status))
		{
			if($status->getStatus() == Tooter_Service::SUCCESS)
				redirect("resetPasswordMsg.php");
			else
				$error = $status->getError();
		}
	}
	
?>
<html>
<head>
    <title id="pageTitle"><?php echo $messages["signUp.now"] ?></title>
    <link href="<?php echo $base_directory; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo $base_directory; ?>/assets/img/favicon.ico"/>
</head>
<body style="padding-top: 15px;">
<div class="container-fluid">
    <div class="hero-unit">
        <h3><?php echo $messages["reset.password.title"] ?></h3>
		
        <form id="user" action="resetPassword.php" method="POST">
            <div class="control-group">
                <?php echo $messages["reset.password.message"] ?>
            </div>
            <div class="control-group">
						<?php
							if(!empty($error))
							{
								$id = $error->getId();
								$styleClass = $error->getStyleClass();
								if(isset($messages[$error->getMessage()]))
									$errorMessage = $messages[$error->getMessage()];
								else
									$errorMessage = $error->getMessage();
								echo "<div id=\"$id\" class=\"$styleClass\">$errorMessage</div>";
							}
						?>
            </div>
            <div class="control-group">
                <label for="email"><?php echo $messages["customer.email"] ?></label>
                <input id="email" name="email" type="text" value=""/>
            </div>
            <div class="control-group">
                <div class="controls">
                    <a class="btn" href="login.php"><?php echo $messages["return.message"] ?></a>
                   <button class="btn btn-primary" type="submit"><?php echo $messages["customer.password.reset"] ?></button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="<?php echo $base_directory; ?>/assets/js/bootstrap.min.js"></script>
</body>
</html>