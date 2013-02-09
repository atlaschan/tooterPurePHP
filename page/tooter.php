<?php
	require "../config/vars.php";
	
	$user = null;
	if(!isset($_SESSION["user"]))
	{
		redirect("login.php");
	} 
	else
		$user = $_SESSION["user"];
		
	//var_dump($user);
	
	$error = null;
	if(isset($_POST["tootMessage"]))
	{
		$controller = new tooter_controller_TootController($stormpath);
		$toot = new tooter_model_Toot;
		$toot->setCustomer($user);
		$toot->setTootMessage($_POST["tootMessage"]);
		$status = $controller->submit($toot);
		
		if($status->getStatus() == Tooter_Service::FAILED)
			$error = $status->getError();
	}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title id="pageTitle"><?php echo $messages["tooter.title"] ?></title>
    <link href="<?php echo $base_directory; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo $base_directory; ?>/assets/img/favicon.ico"/>
</head>
<body style="padding-top: 55px;">
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <a class="brand" style="margin-left: 0px;" href="https://www.stormpath.com">Tooter</a>
        <ul class="nav">
            <li class="active"><a href="tooter.php">Home</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?= $user->getFirstName()." ".$user->getLastName();?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="#" id="showAccountTypes"><?php echo $messages["customer.account.type"] ?>: Basic</a></li>
                    <li class="divider"></li>
                    <li class="nav-header"></li>
                    <li><a href="logout.php"><?php echo $messages["tooter.logout"] ?></a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="span12">
            <form id="toot" action="tooter.php" method="POST">
					
					<?php
						if(!empty($error))
						{
							$id = $error->getId();
							$styleClass = $error->getStyleClass();
							$errorMessage = $messages[$error->getMessage()];
							echo "<div id=\"$id\" class=\"$styleClass\">$errorMessage</div>";
						}
						
					?>

                    <div class="control-group">
                        <textarea id="tootMessage" name="tootMessage" maxlength="160" placeholder="Compose your toot here..." rows="3"><?=isset($_POST["tootMessage"])?$_POST["tootMessage"]:""?></textarea>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <button type="submit" class="btn btn-primary">Toot!</button>
                        </div>
                    </div>
                
            </form>
        </div>
    </div>
    <div class="row">
        <div class="span12">
            <h3><?php echo $messages["tooter.toots"] ?></h3>
				<?php
					$list = $user->getTootList();
					//var_dump($list);
					
					if(!empty($list))
					{
						foreach($list as $tootItem)
						{
							//determine account types
							
							$accountTypeClass = "basic";
							/*// put it temporarily and will resolve it later.
							$permissionUtil = new tooter_util_PermissionUtil($application_property);
							if($permissionUtil->hasRole($user, "ADMINISTRATOR"))
								$accountTypeClass = "alert alert-info admin";
							if($permissionUtil->hasRole($user, "PREMIUM_USER"))
								$accountTypeClass = "alert alert-warning premium";*/
							
							//$groupName = $user->getGroupName();
							$groupName = "Basic";
							$firstName = $user->getFirstName();
							$lastName = $user->getLastName();
							$tootMessage = $tootItem->getTootMessage();

							
							echo "<div class=\"well well-small $accountTypeClass\" title=\"Poster's Account Type\" data-content=\"$groupName\">
									<code><a href=\"profile.php\">$firstName $lastName</a>: $tootMessage</code>
								</div>";
						}
					} 
					else 
					{
				?>
            
                <div class="alert">
                    There are no toots!
                </div>
				<?php
					}
				?>
        </div>
    </div>
</div>
<div class="modal" id="accountTypeModalContent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 id="myModalLabel">Account Types</h3>
    </div>
    <div class="modal-body">
        <p>
            <ul>
                <li><b>Basic</b>: Create Toot. Toots are not highlighted.</li>
                <li><b>Premium</b>: Create Toot. Toots are highlighted soft yellow.</li>
                <li><b>Admin</b>: Create Toot. Delete Toot. Toots are highlighted soft blue.</li>
            </ul>
        </p>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Close</button>
    </div>
</div>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="<?php echo $base_directory; ?>/assets/js/bootstrap.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.close').tooltip();
        $('.admin, .premium, .basic').popover({trigger: 'hover', placement: 'top'});
        $('#accountTypeModalContent').modal();
        $('#accountTypeModalContent').modal('hide');
        $('#showAccountTypes').on('click', function() {
            $('#accountTypeModalContent').modal('show');
        });
    });
</script>
</body>
</html>