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
		include('navigation.php');
		?>
        <nav>
			<style>
				.frogs {background-color: white;}
				.frogs a {color: black;}
			</style>
        </nav>
		<h1>Frog Game</h1>
        <div>
			<div>
				<div>
					<div">
						<div>
							<div>
								<table style="margin-left: auto; margin-right: auto;"><tr> <!-- TODO: STYLE THIS IN STYLE.CSS WITH CLASSES -->
								<div>
									<label><?= $_SESSION['FrogGame']->state ?></label>
								</div><br>
								<?php 
								$count = count($_SESSION['FrogGame']->frogs)-1;
                                //For each frog image, load the image
								for ($i = 0; $i <= $count; $i++) {
									?><th><?php
									if ($_SESSION['FrogGame']->frogs[$i] != 0) {
										echo('<a href="index.php?frog='.  $i . '"><img width=75% src="images/frog' . $_SESSION['FrogGame']->frogs[$i] .'.png" alt="free_space" ></a>'); //Load images
									} else {
										?><img width=75% src="images/free.png" alt="tile1" ><?php
									}
									?></th><?php
								}
								?>
								</tr></table>
							</div>
							<!--Moves left and a funny class name for my div/button-->
							<div class ="nostyle"> 
								<form method="post">
									<input class="btn btn-default" type="submit" name="new" value="restart game" />
								</form>
								<label>Moves left: <?= $_SESSION['FrogGame']->maxMoves?></label>
							</div>
							<style> .nostyle { padding: 1%;} </style>
						</div>
					</div>
				</div>
			</div>
            <?php include('gameStats.php');?>
			<?php include('footer.php');?>
		</main>
	</body>
</html>

