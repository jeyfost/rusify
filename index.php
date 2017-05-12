<?php
	session_start();

	include("scripts/connect.php");

	if(isset($_SESSION['userID'])) {
		$activeCheckResult = $mysqli->query("SELECT active FROM users WHERE id = '" . $_SESSION['userID'] . "'");
		$activeCheck = $activeCheckResult->fetch_array(MYSQLI_NUM);

		if ($activeCheck[0] != ACCOUNT_INACTIVE) {
			header("Location: ../school/");
		} else {
			header("Location: personal/registration-continue.php");
		}
	}

	if(isset($_SESSION['userID'])) {
		if(isset($_COOKIE['rusify_login']) and isset($_COOKIE['rusify_password'])) {
			setcookie("rusify_login", "", 0, '/');
			setcookie("rusify_password", "", 0, '/');
			setcookie("rusify_login", $_COOKIE['rusify_login'], time() + 60 * 60 * 24 * 30 * 12, '/');
			setcookie("rusify_password", $_COOKIE['rusify_password'], time() + 60 * 60 * 24 * 30 * 12, '/');
		}
		else {
			$userResult = $mysqli->query("SELECT * FROM users WHERE id = '".$_SESSION['userID']."'");
			$user = $userResult->fetch_assoc();
			setcookie("rusify_login", $user['login'], time() + 60 * 60 * 24 * 30 * 12, '/');
			setcookie("rusify_password", $user['password'], time() + 60 * 60 * 24 * 30 * 12, '/');
		}
	} else {
		if(isset($_COOKIE['rusify_login']) and isset($_COOKIE['rusify_password']) and !empty($_COOKIE['rusify_login']) and !empty($_COOKIE['rusify_password'])) {
			$userResult = $mysqli->query("SELECT * FROM users WHERE login = '".$_COOKIE['rusify_login']."'");
			$user = $userResult->fetch_assoc();

			if(!empty($user) and $user['password'] == $_COOKIE['rusify_password']) {
				$_SESSION['userID'] = $user['id'];
			} else {
				setcookie("rusify_login", "", 0, '/');
				setcookie("rusify_password", "", 0, '/');
			}
		}
	}

	if(isset($_SESSION['userID'])) {
		$visitsResult = $mysqli->query("SELECT visits FROM users WHERE id = '".$_SESSION['userID']."'");
		$visits = $visitsResult->fetch_array(MYSQLI_NUM);
		$count = $visits[0] + 1;

		$mysqli->query("UPDATE users SET last_visit = '".date('d-m-Y H:i:s')."', visits = '".$count."' WHERE id = '".$_SESSION['userID']."'");
	}
?>

<!DOCTYPE html>

<!--[if lt IE 7]><html lang="en" class="lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if IE 7]><html lang="en" class="lt-ie9 lt-ie8"><![endif]-->
<!--[if IE 8]><html lang="en" class="lt-ie9"><![endif]-->
<!--[if gt IE 8]><!-->

<html lang="en">

<!--<![endif]-->

<head>

	<title>Rusify</title>

	<meta charset="utf-8" />
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">

	<link rel="apple-touch-icon" sizes="57x57" href="/img/favicon/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="/img/favicon/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/img/favicon/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="/img/favicon/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/img/favicon/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="/img/favicon/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="/img/favicon/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/img/favicon/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="/img/favicon/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="/img/favicon/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/img/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="/img/favicon/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/img/favicon/favicon-16x16.png">
	<link rel="manifest" href="/img/favicon/manifest.json">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<link rel="stylesheet" href="/libs/font-awesome-4.7.0/css/font-awesome.min.css" />
	<link rel="stylesheet" href="/libs/fancybox/jquery.fancybox.css" />
	<link rel="stylesheet" href="/libs/owl-carousel/owl.carousel.css" />
	<link rel="stylesheet" href="/libs/countdown/jquery.countdown.css" />
	<link rel="stylesheet" href="/libs/unicorn-ui/unicorn-ui.css" />

	<link rel="stylesheet" href="/css/fonts.css" />
	<link rel="stylesheet" href="/css/main.css" />
	<link rel="stylesheet" href="/css/media.css" />

	<!--[if lt IE 9]>
	<script src="/libs/html5shiv/es5-shim.min.js"></script>
	<script src="/libs/html5shiv/html5shiv.min.js"></script>
	<script src="/libs/html5shiv/html5shiv-printshiv.min.js"></script>
	<script src="/libs/respond/respond.min.js"></script>
	<![endif]-->

	<script src="/libs/jquery/jquery-1.11.1.min.js"></script>

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

	<script src="/libs/jquery-mousewheel/jquery.mousewheel.min.js"></script>
	<script src="/libs/fancybox/jquery.fancybox.pack.js"></script>
	<script src="/libs/waypoints/waypoints-1.6.2.min.js"></script>
	<script src="/libs/scrollto/jquery.scrollTo.min.js"></script>
	<script src="/libs/owl-carousel/owl.carousel.min.js"></script>
	<script src="/libs/countdown/jquery.plugin.js"></script>
	<script src="/libs/countdown/jquery.countdown.min.js"></script>
	<script src="/libs/countdown/jquery.countdown-ru.js"></script>
	<script src="/libs/landing-nav/navigation.js"></script>
	<script src="/libs/notify.js/notify.js"></script>
	<script src="/libs/preloader/preloader.js"></script>

	<script src="/js/common.js"></script>
	<script src="/js/index.js"></script>

	<!-- Yandex.Metrika counter --><!-- /Yandex.Metrika counter -->
	<!-- Google Analytics counter --><!-- /Google Analytics counter -->

</head>

<body>

	<div id="page-preloader"><span class="spinner"></span></div>

	<header class="navbar-fixed-top">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="logo">
						<a href="/">Rusify</a>
					</div>
					<div class="login-button-container">
						<a href="" class="sign-in-button" data-toggle="modal" data-target="#sign-in"><i class='fa fa-sign-in' aria-hidden='true'></i> Sign in</a><span class="login-text">&nbsp;&nbsp;or&nbsp;&nbsp;</span><a href= "" class="sign-up-button" data-toggle="modal" data-target="#sign-up"><i class="fa fa-user-plus" aria-hidden="true"></i> Sign up</a>
					</div>
				</div>
			</div>
		</div>
	</header>

	<section class="main">
		<div class="container">
			<div class="row">
				<div class="col-md-8">
					<div class="main-left">
						<h1>Learn Russian with live teachers.</h1>
						<h3>Rusify is an effective way to learn Russian. Find your own teacher and start your study!</h3>
						<br /><br />
						<div class="main-description">
							<div class="main-description-icon" id="icon1">
								<img src="/img/system/profile.png" />
							</div>
							<div class="main-description-text">
								<b>Personal</b>
								<br />
								Our teachers adjust to your goals and level of knowledge in striving for rusifying you.
							</div>
						</div>
						<div style="clear: both;"></div>
						<div class="main-description">
							<div class="main-description-icon">
								<img src="/img/system/trend.png" />
							</div>
							<div class="main-description-text" id="icon2">
								<b>Effective</b>
								<br />
								With Rusify you need not worry about finding materials and try to control level of your skills because our teachers do this for you.
							</div>
						</div>
						<div style="clear: both;"></div>
						<div class="main-description">
							<div class="main-description-icon" id="icon3">
								<img src="/img/system/heart.png" />
							</div>
							<div class="main-description-text">
								<b>Fascinating</b>
								<br />
								Learning new language with live teacher makes the process fascinating.
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="main-right">
						<center><h4>Sign up for free</h4></center>
						<form>
							<br />
							<input type="text" name="mainEmail" id="mainEmailInput" placeholder="Email..." class="form-control" required />
							<input type="password" name="mainPassword" id="mainPasswordInput" placeholder="Password..." class="form-control" required />
							<br />
							<button type="button" class="btn btn-success main-sign-up-button">Sign up</button>
							<br /><br />
							<p class="text-center"><b><a href="" data-toggle="modal" data-target="#sign-in" style="font-size: 12px;">Already have an account?</a></b></p>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	<br />

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="text-center text-header">
					<h2>Save your time</h2>
					<br />
					<div class="col-md-3"></div>
					<div class="col-md-6">
						<div class="computer-icon">
							<img src="/img/system/computer.png" />
						</div>
						<div class="computer-text text-left text" style="margin-top: 0;">
							<b><i class="fa fa-check" aria-hidden="true"></i> Study everywhere</b>
							<br />
							You can learn Russian at any place, where you can find Wi-Fi.
						</div>
						<div class="computer-text text-left text">
							<b><i class="fa fa-check" aria-hidden="true"></i> Any time</b>
							<br />
							Our teachers are ready to meet you when ever you want.
						</div>
						<div class="computer-text text-left text">
							<b><i class="fa fa-check" aria-hidden="true"></i> Native speakers</b>
							<br />
							You get an opportunity to study with native speakers.
						</div>
					</div>
					<div class="col-md-3"></div>
				</div>
			</div>
		</div>
	</div>

	<div class="container-fluid index-grey-container">
		<div class="row">
			<div class="col-md-12">
				<div class="text-center text-header">
					<h2>Money back guarantee</h2>
					<br />
					<div class="col-md-3"></div>
					<div class="col-md-6">
						<div class="guarantee-icon text-center">
							<img src="/img/system/check.png" />
						</div>
						<div class="guarantee-text text-center text" style="margin-top: 0;">
							Do not worry for your money. If your lesson were awful or your teacher did not study with you at the designated time, you will get your money back within 24 hours from the moment of application.
						</div>
					</div>
					<div class="col-md-3"></div>
				</div>
			</div>
		</div>
	</div>

	<div class="container-fluid index-container">
		<div class="row">
			<div class="col-md-12">
				<div class="text-center text-header">
					<h2>Student feedback</h2>
					<h4>We are receiving a large number of reviews on our work. Here are some of them.</h4>
					<br />
					<div class="col-md-4">
						<div class="feedback-container">
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. At blanditiis deleniti doloribus fugiat, minima natus quod. Ad beatae fugiat illum maxime minima molestiae necessitatibus quam reprehenderit, sed. Error, reprehenderit, suscipit!
						</div>
						<div class="feedback-img">
							<img src="/img/system/say.png" />
						</div>
						<div class="feedback-photo text-center">
							<img src="/img/system/photo1.png" />
						</div>
						<div class="text-center">
							<b>Mike C.</b>
						</div>
					</div>
					<div class="col-md-4">
						<div class="feedback-container">
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. At blanditiis deleniti doloribus fugiat, minima natus quod. Ad beatae fugiat illum maxime minima molestiae necessitatibus quam reprehenderit, sed. Error, reprehenderit, suscipit!
						</div>
						<div class="feedback-img">
							<img src="/img/system/say.png" />
						</div>
						<div class="feedback-photo text-center">
							<img src="/img/system/photo2.png" />
						</div>
						<div class="text-center">
							<b>Antonio V.</b>
						</div>
					</div>
					<div class="col-md-4">
						<div class="feedback-container">
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. At blanditiis deleniti doloribus fugiat, minima natus quod. Ad beatae fugiat illum maxime minima molestiae necessitatibus quam reprehenderit, sed. Error, reprehenderit, suscipit!
						</div>
						<div class="feedback-img">
							<img src="/img/system/say.png" />
						</div>
						<div class="feedback-photo text-center">
							<img src="/img/system/photo3.png" />
						</div>
						<div class="text-center">
							<b>Judith R.</b>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="sign-in" role="dialog">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Sign in to Rusify</h4>
			    </div>
				<div class="modal-body">
					<form class="login-form">
						<br />
						<label for="loginInput"><b>Username or email address</b></label>
						<input type="text" name="login" id="loginInput" class="form-control" autofocus="autofocus" placeholder="Username or email address..." required />
						<br />
						<label for="passwordInput"><b>Password</b></label><a href="" class="modal-link" data-toggle="modal" data-target="#password-reset" data-dismiss="modal" onclick="clearResponseField()">Forgot password?</a>
						<input type="password" name="password" id="passwordInput" class="form-control" placeholder="Password..." required />
					</form>
					<br />
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success login-button">Sign in</button>
					<hr />
					<div style="width: 100%; text-align: center;">
						<label style="font-size: 12px;">New to Rusify? </label><a href="" class="modal-link" data-toggle="modal" data-target="#sign-up" data-dismiss="modal" onclick="clearResponseField()">Create an account</a>
					</div>
					<br />
					<div class="response-field"></div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="password-reset" role="dialog">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Reset your password</h4>
			    </div>
				<div class="modal-body">
					<form class="login-form">
						<br />
						<label for="loginInput"><b>Email address</b></label>
						<input type="text" name="email" id="emailInput" class="form-control" autofocus="autofocus" placeholder="Email address..." required />
					</form>
					<br />
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success password-reset-button">Reset my password</button>
					<hr />
					<label style="font-size: 12px;">Remember your password?</label>
					<a href="" data-toggle="modal" data-target="#sign-in" style="font-size: 12px; font-weight: bold; float: right;" onclick="clearResponseField()" data-dismiss="modal">Sign in</a>
					<div class="response-field"></div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="sign-up" role="dialog">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Sign up for free</h4>
			    </div>
				<div class="modal-body">
					<form class="login-form">
						<label for="modalEmailInput">Email</label>
						<input type="text" name="modalEmail" id="modalEmailInput" placeholder="Email..." class="form-control" required />
						<br />
						<label for="modalPasswordInput">Password</label>
						<input type="password" name="modalPassword" id="modalPasswordInput" placeholder="Password..." class="form-control" required />
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success password-reset-button">Sign up</button>
					<hr />
					<label style="font-size: 12px;">Already have an account?</label>
					<a href="" data-toggle="modal" data-target="#sign-in" style="font-size: 12px; font-weight: bold; float: right;" onclick="clearResponseField()" data-dismiss="modal">Sign in</a>
					<div class="response-field"></div>
				</div>
			</div>
		</div>
	</div>

	<footer id="footer-top">
		<div class="row">
			<div class="container">
				<div class="col-md-4 footer-section">
					<span class="font-16">About us</span>
					<br /><br />
					<a href="">Help</a>
					<br />
					<a href="">How it works</a>
					<br />
					<a href="">Who are we</a>
				</div>
				<div class="col-md-4 footer-section">
					<span class="font-16">For students</span>
					<br /><br />
					<a href="">Find a teacher</a>
					<br />
					<a href="">FAQ</a>
				</div>
				<div class="col-md-4 footer-section">
					<span class="font-16">For teachers</span>
					<br /><br />
					<a href="">Work principles</a>
					<br />
					<a href="">Find students</a>
					<br />
					<a href="">FAQ</a>
				</div>
			</div>
			<div class="container" style="border-bottom: 1px dotted #717a82; height: 1px; margin: 30px auto;"></div>
			<div class="container">
				<div class="col-md-4 footer-section">
					<span class="font-16">Support</span>
					<br /><br />
					Need help?
					<br />
					<span class="font-16"><i class="fa fa-envelope" aria-hidden="true"></i> <a href="mailto:support@rusify.org">support@rusify.org</a></span>
				</div>
				<div class="col-md-4 footer-section">
					<span class="font-16">Contacts</span>
					<br /><br />
					<img src="/img/flags/flat/16/US.png" /> <span class="font-16">USA</span>
					<br />
					167 Corey Rd., Suite 206, Brighton, MA 02135
				</div>
				<div class="col-md-4 footer-section">
					<span class="font-16">Rusify social</span>
					<br /><br />
					<i class="fa fa-facebook-official" aria-hidden="true"></i> <a href="">Facebook</a>
					<br />
					<i class="fa fa-vk" aria-hidden="true"></i> <a href="">VK</a>
					<br />
					<i class="fa fa-twitter-square" aria-hidden="true"></i> <a href="">Twitter</a>
					<br />
					<i class="fa fa-youtube-play" aria-hidden="true"></i> <a href="">Youtube</a>
				</div>
			</div>
		</div>
	</footer>

	<footer style="background-color: #32393f;" id="footer-bottom">
		<div class="row">
			<div class="container">
				<div class="col-md-4 footer-section">&copy; <?php if(date('Y') > 2017) {echo "2017 - ".date('Y');} else {
					echo "2017";} ?> Rusify Inc.</div>
				<div class="col-md-4 footer-section">
					<a href="">Terms of service</a> - <a href="">Privacy Policy</a> - <a href="">Refund Policy</a>
				</div>
				<div class="col-md-4 footer-section"></div>
			</div>
		</div>
	</footer>

</body>

</html>