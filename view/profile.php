
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width">
		<link rel="stylesheet" type="text/css" href="style.css" />
		<title>Games</title>
	</head>
	<body>
	<main>
		<?php 
		include('navigation.php');
		?>
        <nav>
			<style>
				.profile {background-color: white;}
				.profile a {color: black;}
			</style>
		</nav>
        <div>Username: <?php echo($_SESSION['user']);?></div>
		<div>First Name: <?php echo($_SESSION['firstname']);?></div>
		<div>Last Name: <?php echo($_SESSION['lastname']);?></div>
		<div>Campus: <?php echo($_SESSION['campus']);?></div>
		<style> div { padding: 1%; }</style>
		<?php include('gameStats.php');?>
		<?php include('footer.php');?>
    </main>