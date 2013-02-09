<?php
	require "../config/vars.php";
	
	$error = null;
	if(isset($_POST["firstName"]))
	{
		$user = new tooter_model_User;
		$user->setFirstName($_POST["firstName"]);
		$user->setLastName($_POST["lastName"]);
		$user->setEmail($_POST["email"]);
		$user->setPassword($_POST["password"]);
		$user->setConfirmPassword($_POST["confirmPassword"]);
		$user->setGroupUrl($_POST["groupUrl"]);
		
		$controller = new tooter_controller_SignUpController($stormpath);
		
		$status = $controller->processSubmit($user);
		if(!empty($status))
		{
			if($status->getStatus() == Tooter_Service::SUCCESS)
			{
				$obj = $status->getObj();
				$_SESSION["user"] = $obj["user"];
				redirect("tooter.php");
			}
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
        <h3><?php echo $messages["signUp.now"] ?></h3>
        <form id="customer" action="signUp.php" method="POST">
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
                <label class="control-label" for="firstName"><?php echo $messages["customer.first.name"] ?></label>
                <input id="firstName" name="firstName" type="text" value="<?=isset($_POST["firstName"])?$_POST["firstName"]:""?>"/>
            </div>
            <div class="control-group">
                <label class="control-label" for="lastName"><?php echo $messages["customer.last.name"] ?></label>
                <input id="lastName" name="lastName" type="text" value="<?=isset($_POST["lastName"])?$_POST["lastName"]:""?>"/>
            </div>
            <div class="control-group">
                <label class="control-label" for="email"><?php echo $messages["customer.email"] ?></label>
                <input id="email" name="email" type="text" value="<?=isset($_POST["email"])?$_POST["email"]:""?>"/>
            </div>
            <div class="control-group">
                <label class="control-label" for="password"><?php echo $messages["customer.password"] ?></label>
                <input id="password" name="password" type="password" value=""/>
            </div>
            <div class="control-group">
                <label class="control-label" for="confirmPassword"><?php echo $messages["customer.password.confirm"] ?></label>
                <input id="confirmPassword" name="confirmPassword" type="password" value=""/>
            </div>
            <div class="control-group">
                <label class="radio inline" style="margin-left: -18px !important;"><?php echo $messages["customer.account.type"] ?>:</label>&nbsp;
                <label class="radio inline">
                    <input id="groupUrl1" name="groupUrl" class="radio" type="radio" value="<?=$application_property["stormpath.sdk.administrator.rest.url"]?>"/> Administrator
                </label>
                <label class="radio inline">
                    <input id="groupUrl2" name="groupUrl" class="radio" type="radio" value="<?=$application_property["stormpath.sdk.premium.rest.url"]?>"/> Premium
                </label>
                <label class="radio inline">
                    <input id="groupUrl3" name="groupUrl" class="radio" type="radio" value="" checked="checked"/> Basic
                </label>
            </div>
            <div class="control-group">
                <div class="controls">
                    <a class="btn" href="<?php echo $current_directory; ?>/login.php"><?php echo $messages["return.message"] ?></a>
                   <button class="btn btn-primary" type="submit"><?php echo $messages["customer.register"] ?></button>
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