<?php
	//Attempt to add an extra security feature; unprotected pages cannot be "previous page'd" into.
	//Unneded with my proper use of session :D, leaving it here anyways because this is kind of a cool idea.
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
	// So I don't have to deal with uninitialized $_REQUEST['guess']
	$_REQUEST['guess']=!empty($_REQUEST['guess']) ? $_REQUEST['guess'] : '';
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
		<?php 
		include('navigation.php');
		?>
		<nav>
			<style>
				.guess {background-color: white;}
				.guess a {color: black;}
			</style>
		</nav>
		<main>
			<section>
				<h1>Guess Game</h1>
				<?php 

				if($_SESSION["GuessGame"]->getState()!="correct"){ ?>
					<form method="post">
						<input type="text" name="guess" value="<?php echo($_REQUEST['guess']); ?>" /> <input type="submit" name="submit" value="guess" />
					</form>
				<?php } ?>

				<?php echo(view_errors($errors)); ?> 

				<?php 
					foreach($_SESSION['GuessGame']->history as $key=>$value){
						echo("<br/> $value");
					}
					if($_SESSION["GuessGame"]->getState()=="correct"){ 
				?>
					<form method="post">
						<input type="submit" name="submit" value="start again" />
					</form>
				<?php 
					} 
				?>
			</section>
			<?php include('gameStats.php');?>
		</main>
		<?php include('footer.php');?>
	</body>
</html>

