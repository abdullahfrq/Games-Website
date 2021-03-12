<?php
	// So I don't have to deal with uninitialized $_REQUEST['rps']
	$_REQUEST['rps']=!empty($_REQUEST['rps']) ? $_REQUEST['rps'] : '';
?>
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
		include('navigation.php'); //Include nav bar
		?>
        <nav>
			<style>
				.rps {background-color: white;}
				.rps a {color: black;}
			</style>
		</nav>
		<h1>Welcome to Rock Paper Scissors!</h1>
		<h1>Select 1 for rock, 2 for paper, and 3 for scissors</h1> 
		<?php if($_SESSION["rps"]->getState()!="you won!"){ ?>
			<form method="post">
				<input type="text" name="rps" value="<?php echo($_REQUEST['rps']); ?>" /> <input type="submit" name="submit" value="rps" />
			</form>
		<?php } ?>
		
		<?php echo(view_errors($errors)); ?> 

		<?php 
			foreach($_SESSION['rps']->history as $key=>$value){
				echo("<br/> $value");
			}
			if($_SESSION["rps"]->getState()=="you won!"){ 
		?>
				<form method="post">
					<input type="submit" name="submit" value="start again" />
				</form>
		<?php 
			} 
		?>
            <?php include('gameStats.php');?>
			<?php include('footer.php');?>
		</main>
	</body>
</html>

