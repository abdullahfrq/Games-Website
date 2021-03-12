<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css" /> <!-- TODO: --CREATE AND STYLE CLASSES-- EXCUSE MY LACK OF STYLING IT IS 3 AM NOW D: -->
		<title>Games</title>
	</head>
	<body>
		<div>
			<div>
				<h1>Games Registration</h1>
				<div>
					<div>
						<form method="post"> <!-- we use a post -->
							<div>
								<input class="forms" type="text" name="user" placeholder="Username"required> <!-- user name -->
							</div>
                            <div>
								<input class="forms" type="password" name="password" placeholder="Password" required> <!-- password -->
							</div>
							<div>
								<div>
									<input class="forms" type="text" name="firstname" placeholder="First Name" required> <!-- first name -->
								</div>
								<div>
									<input class="forms" type="text" name="lastname" placeholder="Last Name" required> <!-- last name -->
								</div>
							</div>
                            <!-- As per MS guidelines, I chose UofT campus selection for radio buttons, with CR lines-->
                            <div>
								<section>
								</section>
								<header>Campus</header>
								<div></div>
								<input type="radio" name="campus" value="St George"> St George<br> 
								<input type="radio" name="campus" value="Scarborough"> Scarborough<br>
								<input type="radio" name="campus" value="Mississauga"> Mississauga<br>
							</div>	
							<input class="btn" type="submit" name="submit" value="register" />
							</th><td><?php echo(view_errors($errors)); ?>
                        </form>
                        <!-- Using logout since the logout feature provides the same functionality as cancelling registration -->
						<section></section>
						<section>
						<a href="index.php?a=logout" class="register">Back</a> 
						</section>
					</div>
				</div>
			</div>

		</div>
	</body>
</html>