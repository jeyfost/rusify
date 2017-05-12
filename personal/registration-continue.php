<?php
	session_start();

	include("../scripts/connect.php");

	if(!isset($_SESSION['userID'])) {
		if(!empty($_REQUEST['hash'])) {
			$userResult = $mysqli->query("SELECT active FROM users WHERE hash = '".$mysqli->real_escape_string($_REQUEST['hash'])."'");
			$user = $userResult->fetch_assoc();

			if($user['active'] != ACCOUNT_INACTIVE) {
				$_SESSION['userID'] = $user['id'];
				header("Location: ../school/");
			}
		} else {
			header("Location: ../");
		}
	} else {
		$activeCheckResult = $mysqli->query("SELECT active FROM users WHERE id = '".$_SESSION['userID']."'");
		$activeCheck = $activeCheckResult->fetch_array(MYSQLI_NUM);

		if($activeCheck[0] != ACCOUNT_INACTIVE ) {
			header("Location: ../school/");
		}
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

	<title>Continue your registration</title>

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
		<link rel="stylesheet" href="/libs/kartik/css/fileinput.css" />

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
	<script src="/libs/kartik/js/fileinput.js"></script>

	<script src="/js/common.js"></script>
	<script src="/js/personal/registration.js"></script>

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
				</div>
			</div>
		</div>
	</header>

	<section class="main">
		<div class="col-md-12">
			<div class="row">
				<div class="container text-center">
					<h1>Continue your registration by filling next fields</h1>
					<form class="form-400" id="continueRegistrationForm" method="post">
						<label for="loginInput"><i class="fa fa-user" aria-hidden="true"></i> Username:</label>
						<br />
						<input type="text" class="form-control" placeholder="Username..." id="loginInput" name="login" required />
						<br />
						<label for="firstNameInput"><i class="fa fa-address-card" aria-hidden="true"></i> First name:</label>
						<br />
						<input type="text" class="form-control" placeholder="First name..." id="firstNameInput" name="firstName" required />
						<br />
						<label for="lastNameInput"><i class="fa fa-address-card-o" aria-hidden="true"></i> Last name:</label>
						<br />
						<input type="text" class="form-control" placeholder="Last name..." id="lastNameInput" name="lastName" required />
						<br />
						<label><i class="fa fa-birthday-cake" aria-hidden="true"></i> Select your birth date</label>
						<br /><br />
						<?php
							$month = (int)date('m');

							if($month == 1 or $month == 3 or $month == 5 or $month == 7 or $month == 8 or $month == 10 or $month == 12) {
								$maxDay = 31;
							} elseif($month == 2) {
								if(date('Y') % 4 == 0) {
									$maxDay = 29;
								} else {
									$maxDay = 28;
								}
							} else {
								$maxDay = 30;
							}
						?>
						<div class="form-div" style="margin: 0;">
							<label for="yearInput">Year:</label>
							<br />
							<select class="form-control" id="yearInput" name="year">
								<?php
									for($i = 1900; $i <= date('Y'); $i++) {
										echo "<option value='".$i."'"; if(date('Y') == $i) {echo "selected";} echo ">".$i."</option>";
									}
								?>
							</select>
						</div>
						<div class="form-div">
							<label for="monthInput">Month:</label>
							<br />
							<select class="form-control" id="monthInput" name="month">
								<option value="1" <?php if($month == 1) {echo "selected";} ?>>January</option>
								<option value="2" <?php if($month == 2) {echo "selected";} ?>>February</option>
								<option value="3" <?php if($month == 3) {echo "selected";} ?>>March</option>
								<option value="4" <?php if($month == 4) {echo "selected";} ?>>April</option>
								<option value="5" <?php if($month == 5) {echo "selected";} ?>>May</option>
								<option value="6" <?php if($month == 6) {echo "selected";} ?>>June</option>
								<option value="7" <?php if($month == 7) {echo "selected";} ?>>July</option>
								<option value="8" <?php if($month == 8) {echo "selected";} ?>>August</option>
								<option value="9" <?php if($month == 9) {echo "selected";} ?>>September</option>
								<option value="10" <?php if($month == 10) {echo "selected";} ?>>October</option>
								<option value="11" <?php if($month == 11) {echo "selected";} ?>>November</option>
								<option value="12" <?php if($month == 12) {echo "selected";} ?>>December</option>
							</select>
						</div>
						<div class="form-div">
							<label for="dayInput">Day:</label>
							<br />
							<select class="form-control" id="dayInput" name="day">
								<?php
									for($i = 1; $i <= $maxDay; $i++) {
										echo "<option value='".$i."'"; if((int)date('d') == $i) {echo "selected";} echo ">".$i."</option>";
									}
								?>
							</select>
						</div>
						<div style="clear: both;"></div>
						<br />
						<?php
							$isoResult = $mysqli->query("SELECT * FROM isocodes ORDER BY country LIMIT 1");
							$iso = $isoResult->fetch_assoc();
							$flag = $iso['code'].".png";
						?>
						<label for="countrySelect"><i class="fa fa-globe" aria-hidden="true"></i> <img src="/img/flags/flat/16/<?= $flag ?>" id="flag" title="<?= $iso['country'] ?>" alt="<?= $iso['code'] ?>" /> Select your location</label>
						<br />
						<select id="countrySelect" name="country" class="form-control">
							<?php
								$countryResult = $mysqli->query("SELECT * FROM isocodes ORDER BY country");
								while($country = $countryResult->fetch_assoc()) {
									echo "<option value='".$country['code']."'>".$country['country']."</option>";
								}
							?>
						</select>
						<br />
						<label for="skypeInput"><i class="fa fa-skype" aria-hidden="true"></i> Skype:</label>
						<br />
						<input type="text" class="form-control" placeholder="Skype..." id="skypeInput" name="skype" required />
						<br />
						<label><i class="fa fa-question" aria-hidden="true"></i> Select your role</label>
						<br />
						<div class="radio">
							<label><input type="radio" name="role" id="studentRadio" checked><i class="fa fa-graduation-cap" aria-hidden="true"></i> I'm  a student</label>
						</div>
						<br />
						<div class="radio">
							<label><input type="radio" name="role" id="teacherRadio"><i class="fa fa-universal-access" aria-hidden="true"></i> I'm  a teacher</label>
						</div>
						<br />
						<br />
						<label for="photoInput"><i class="fa fa-camera" aria-hidden="true"></i> Pick your photo:</label>
						<input id="photoInput" name="photo" type="file" accept="image/*" class="file-loading" />
						<br /><br />
						<input type="button" value="Lets go!" id="registrationButton" class="btn btn-success" userid="<?= $_SESSION['userID'] ?>" hash="<?= $mysqli->real_escape_string($_REQUEST['hash']) ?>" />
					</form>
				</div>
			</div>
		</div>
		<div style="clear: both;"></div>
	</section>

	<div style="clear: both;"></div>

	<footer>
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

	<footer style="background-color: #32393f;">
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