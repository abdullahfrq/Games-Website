<!-- CONTROLLER FILE -->

<?php
	require_once "model/GuessGame.php";
	require_once "model/something.php";
	require_once "model/RockPaperScissors.php";
	require_once "model/FrogGame.php";
	require_once "lib/lib.php";


	session_save_path("sess");
	session_start(); 
	
	ini_set('display_errors', 'On');

	$dbconn = db_connect();

	$errors=array();
	$view="";

	/* controller code */
	if(!isset($_SESSION['state'])){
		$_SESSION['state']='login';
	}

	if(isset($_GET['a'])){
        $_SESSION['state']=$_GET['a'];
		header("Location: index.php");
    }

	switch($_SESSION['state']){
		//LOGIN AND REGISTER LOGIC
		case "login":
			// the view we display by default
			$view="login.php";

			// check if submit or not
			if(empty($_REQUEST['submit']) || $_REQUEST['submit']!="login"){
				break;
			}

			// validate and set errors
			if(empty($_REQUEST['user'])){
				$errors[]='user is required';
			}
			if(empty($_REQUEST['password'])){
				$errors[]='password is required';
			}
			if(!empty($errors))break;

			if(!$dbconn){
				$errors[]="Can't connect to db";
				break;
			}
			$query = "SELECT * FROM appuser WHERE userid=$1 and password=$2;";
                	$result = pg_prepare($dbconn, "", $query);
                	$result = pg_execute($dbconn, "", array($_REQUEST['user'], $_REQUEST['password']));
                	if($row = pg_fetch_array($result, NULL, PGSQL_ASSOC)){
						//For use in profile.php, to display profile info, if I have time. It is 2:40 AM :D 
						$_SESSION['user']=$_REQUEST['user'];
						$_SESSION['firstname'] = $row["firstname"];
						$_SESSION['lastname'] = $row["lastname"];
						$_SESSION['campus'] = $row["campus"];
						$_SESSION['GuessGame']=new GuessGame();
						$_SESSION['rps']=new RockPaperScissors();
						$_SESSION['state']='stats'; //Stats is the main page by Arnold's instruction
						$view="stats.php";
						$_SESSION['user']=$_POST['user'];
					} else {
						$errors[]="invalid login";
					}
			break;

		case "register":
			$view="register.php";

			if(empty($_POST['submit']) || $_POST['submit']!="register"){
				break;
			}

			// validate and set errors
			if(!empty($errors))break;

			// validate connection to db
			if(!$dbconn){
				$errors[]="Can't connect to db";
				break;
			}

			//First we check if the user exists
			$query = "SELECT * FROM appuser WHERE userid=$1;";

			//We use prepare statements that are visible only within this session (secure, following arnolds convention)
			//with labels for neatness and control of execution
            $result = pg_prepare($dbconn, "login", $query);
            $result = pg_execute($dbconn, "login", array($_POST['user']));

			//Throw an error as appropriate
			if($row = pg_fetch_array($result, NULL, PGSQL_ASSOC)){
				$errors[]="the requested username is taken";
			} else {
				$query = "INSERT INTO appuser (userid, password, firstname, lastname, campus) VALUES ($1,$2,$3,$4,$5);"; //TODO: HASH THE PASSWORD (jk its 3 AM too late 4 this)
				$result = pg_prepare($dbconn, "register", $query);
				$result = pg_execute($dbconn, "register", array($_POST['user'], $_POST['password'], $_POST['firstname'], $_POST['lastname'], $_POST['campus']));

				if($result) {
					$rows_affected=pg_affected_rows($result);
					$_SESSION['state'] = 'login';
					$view="login.php";
					 //Cheap way through errors[] to give validation to user that the account has been created sucessfully
					$errors[]="the requested user was created successfully";
				}
			}

			break;

		//GAMES LOGIC
		case "frogs":
			$view="frog.php";

			if(!isset($_SESSION['FrogGame'])){
					$_SESSION['FrogGame'] = new FrogGame();
			}
            $view="frog.php";

			if(isset($_GET['frog'])){
                $_SESSION["FrogGame"]->makeMove($_GET['frog']);
                header("location: index.php");
            }

			if(array_key_exists('new', $_POST)){
			   $_SESSION["FrogGame"]->newGame();
			}

			break;

		case "guess":
			$view="guess.php";

			// check if submit or not
			if(empty($_REQUEST['submit'])||$_REQUEST['submit']!="guess"){
				break;
			}

			// validate and set errors
			if(!is_numeric($_REQUEST["guess"]))$errors[]="Guess must be numeric.";
			if(!empty($errors))break;

			// perform operation, switching state and view if necessary
			$_SESSION["GuessGame"]->makeGuess($_REQUEST['guess']);
			if($_SESSION["GuessGame"]->getState()=="correct"){
				$_SESSION['state']="won";
				$view="won.php";
			}

			$_REQUEST['guess']="";
			break;

		case "rps":
			$view="rps.php";
			// check if submit or not
			if(empty($_REQUEST['submit'])||$_REQUEST['submit']!="rps"){
				break;
			}

			// validate and set errors
			if(!is_numeric($_REQUEST["rps"]))$errors[]="Input must be numeric.";
			if(!empty($errors))break;

			// perform operation, switching state and view if necessary
			$_SESSION["rps"]->makeRPS($_REQUEST['rps']);
			if($_SESSION["rps"]->getState()=="you won!"){
				$_SESSION['state']="won";
				$view="won.php";
			}

			$_REQUEST['rps']="";
			break;

		//STATS, WONGAME, UNAVAILABLE, AND PROFILE PAGE LOGIC
		case "unavailable":
			$view="unavailable.php";
			$_SESSION['state']="unavailable";
			break;

		case "stats":
			$view="stats.php";
			break;


		case "won":
			// the view we display by default
			$view="stats.php";

			// check if submit or not
			if(empty($_REQUEST['submit'])||$_REQUEST['submit']!="start again"){
				$errors[]="Invalid request";
				$view="won.php";
			}

			// validate and set errors
			if(!empty($errors))break;

			// perform operation, switching state and view if necessary
			$_SESSION["rps"]=new RockPaperScissors();
			$_SESSION["guess"]=new GuessGame();
			$_SESSION['stats']="stats";
			$view="stats.php"; //Send user back to the main page.
			break;

		case "profile":
			$view="profile.php";
			$_SESSION['state']="profile";

			// validate and set errors
			if(empty($_REQUEST['user'])){
				$errors[]='user is required to view profile';
			}
			if(empty($_REQUEST['password'])){
				$errors[]='login is required to view profile';
			}
			if(!empty($errors))break;

			if(!$dbconn){
				$errors[]="Can't connect to db";
				break;
			}
			break;
			
		//LOGOUT LOGIC
		case "logout":
			session_destroy();
			header("Location: index.php");
			break;

	}
	require_once "view/$view";
?>
