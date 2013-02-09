<?php
	require "../config/vars.php";
	
	$error = null;
	if(isset($_POST["userName"]) and isset($_POST["password"]))
	{
		$customer = new tooter_model_User();
		$customer->setUserName(trim($_POST["userName"]));
		$customer->setPassword(trim($_POST["password"]));
		
		$loginController = new tooter_controller_LoginController($stormpath);
		
		$status = $loginController->submit($customer);
		
		if($status->getStatus() == Tooter_Service::SUCCESS)
		{
			$obj = $status->getObj();
			$_SESSION["user"] = $obj["user"];
			redirect("tooter.php");
		}
		else
		{
			$error = $status->getError();
		}
		
		//var_dump($status);
		
		
	}
?>

<!DOCTYPE html>
<html lang="en">
<?php
	
?>
<head>
    <title id="pageTitle"><?php echo $messages["account.login"]; ?></title>
    <link href="<?php echo $base_directory; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo $base_directory; ?>/assets/img/favicon.ico"/>
</head>
<body style="padding-top: 15px;">
<div class="container-fluid">
    <div class="hero-unit">
        <h1>
            <?php echo $messages["welcome.message"]; ?>
        </h1>

        <h3>
            <?php echo $messages["welcome.sample.app"]; ?>
        </h3>
        <form id="customer" action="login.php" method="POST">
            
			<?php
				if(!empty($error))
				{
					$id = $error->getId();
					$styleClass = $error->getStyleClass();
					$message = $error->getMessage();
					echo "<div class=\"control-group error\">
						<span id=\"$id\" class=\"$styleClass\">$message</span>
						</div>";
				}
			
			?>
            <div class="control-group">
                <label class="control-label" for="userName"><?php echo $messages["customer.userName"]; ?></label>
                <input id="userName" name="userName" type="text" value="<?=isset($_POST["userName"])?$_POST["userName"]:""?>"/>
            </div>
            <div class="control-group">
                <label class="control-label" for="password"><?php echo $messages["customer.password"]; ?></label>
                <input id="password" name="password" type="password" value=""/>
            </div>
            <div id="control-group">
                <button type="submit" class="btn btn-primary"><?php echo $messages["account.login"]; ?></button><br/><br/>
            </div>
            <div id="control-group">
                <a href="<?php echo $current_directory; ?>/resetPassword.php"><?php echo $messages["password.forgot"]; ?></a><br>
                <?php echo $messages["account.dont.have.one"]; ?>
                <a href="<?php echo $current_directory; ?>/signUp.php"><?php echo $messages["account.signup"]; ?></a>
            </div>
        </form>
    </div>
</div>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="<?php echo $base_directory; ?>/assets/js/bootstrap.min.js"></script>
</body>
</html>