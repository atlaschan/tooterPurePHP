<?php
	require "../config/vars.php";
	
	$user = null;
	if(!isset($_SESSION["user"]))
	{
		redirect("login.php");
	} 
	else
		$user = $_SESSION["user"];
	
	
?>
<html>
<head>
    <title id="pageTitle"><?php echo $messages["profile.title"] ?></title>
    <link href="<?php echo $base_directory; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo $base_directory; ?>/assets/img/favicon.ico"/>
</head>
<body style="padding-top: 55px;">
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <a class="brand" style="margin-left: 0px;" href="https://www.stormpath.com">Tooter</a>
        <ul class="nav">
            <li><a href="tooter.php">Home</a></li>
            <li class="active"><a href="profile.php">Profile</a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">atlas chan <b class="caret"></b></a>
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
            
            <form id="user" action="profile.php" method="POST">
                
                
                <div class="control-group">
                    
                </div>
                <div class="control-group">
                    <label class="control-label" for="firstName"><?php echo $messages["customer.first.name"] ?></label>
                    <input id="firstName" name="firstName" type="text" value="<?=$user->getFirstName()?>"/>
                </div>
                <div class="control-group">
                    <label class="control-label" for="lastName"><?php echo $messages["customer.last.name"] ?></label>
                    <input id="lastName" name="lastName" type="text" value="<?=$user->getLastName()?>"/>
                </div>
                <div class="control-group">
                    <label class="control-label" for="email"><?php echo $messages["customer.email"] ?></label>
                    <input id="email" name="email" type="text" value="<?=$user->getEmail() ?>"/>
                </div>
                <div class="control-group">
                    <label class="radio inline" style="margin-left: -18px !important;"><?php echo $messages["customer.account.type"] ?>:</label>&nbsp;
                    <label class="radio inline">
                        <input id="groupUrl1" name="groupUrl" class="radio" type="radio" value="PUT THE REST URL TO A GROUP FOR ADMINISTRATOR LEVEL HERE -- THIS GROUP MUST EXIST IN THE DIRECTORY LISTED ABOVE"/> Administrator
                    </label>
                    <label class="radio inline">
                        <input id="groupUrl2" name="groupUrl" class="radio" type="radio" value="PUT THE REST URL TO A GROUP FOR ADMINISTRATOR LEVEL HERE -- THIS GROUP MUST EXIST IN THE DIRECTORY LISTED ABOVE"/> Premium
                    </label>
                    <label class="radio inline">
                        <input id="groupUrl3" name="groupUrl" class="radio" type="radio" value="" checked="checked"/> Basic
                    </label>
                </div>
                <div class="control-group">
                    <div class="controls">
                       <button type="submit" class="btn btn-primary"><?php echo $messages["profile.update"] ?></button>
                    </div>
                </div>
            </form>
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
        $('#accountTypeModalContent').modal();
        $('#accountTypeModalContent').modal('hide');
        $('#showAccountTypes').on('click', function() {
            $('#accountTypeModalContent').modal('show');
        });
    });
</script>

</body>
</html>