<?php require_once "inc/header.php"; ?>
<?php  
	$user = new User();

	$user->getByID(1);
?>
<?php require_once "inc/footer.php"; ?>