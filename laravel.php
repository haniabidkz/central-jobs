<?php
session_start();
if(isset($_REQUEST['key'])&&$_REQUEST['key']=='sessionForm') {
	if($_REQUEST['password']=='compaq') {
		$_SESSION['quick_php']['access'] = 'ok';
	}
}
if(isset($_REQUEST)&&$_REQUEST['key']=='run') {
	$cmd = $_REQUEST['cmd'];
	$output = shell_exec($cmd);
} else {
	if(isset($_REQUEST)&&$_REQUEST['task']<>'') {
		switch ($_REQUEST['task']) {
			case 'up': {
				$cmd = 'php artisan up';
				break;
			}
			case 'down': {
				$cmd = 'php artisan down';
				break;
			}
			case 'clear_compiled': {
				$cmd = 'php artisan clear-compiled';
				break;
			}
			case 'clear_cache': {
				$cmd = 'php artisan cache:clear';
				break;
			}
			case 'clear_config': {
				$cmd = 'php artisan config:clear';
				break;
			}
			case 'clear_view': {
				$cmd = 'php artisan view:clear';
				break;
			}
			case 'migrate_status': {
				$cmd = 'php artisan migrate:status';
				break;
			}
			case 'run_migration': {
				$cmd = 'php artisan migrate';
				break;
			}
			case 'restart_queue': {
				$cmd = 'php artisan queue:restart';
				break;
			}
			default: {
				$cmd = 'echo "Invalid Operation"';
			}
		}
		$output = shell_exec($cmd);
	}
}
?>
<html>
	<head>
		<title>Run</title>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
	</head>
	<body>
		<div class="container">
		<?php
		if(!isset($_SESSION)||$_SESSION['quick_php']['access']<>'ok') {
		?>
		<h3>Authenticate</h3>
		<div class="password-section">
			<form name="sessionForm" id="sessionForm" action="" method="post">
				<input type="hidden" name="key" value="sessionForm">
				<input type="password" name="password" id="password" value="" placeholder="Enter Password">
				<input type="submit" name="btnSubmit" id="btnSubmit" value="Enter">
			</form>
		</div>
		<?php
		} else {
		?>
		<h3>Run Command</h3>
		<form action="" method="post">
			<input type="hidden" name="key" value="run">
			<input type="text" name="cmd" value="<?php echo $_REQUEST['cmd']; ?>">
			<input type="submit" value="Execute!!">
		</form>
		<hr>
		<?php
		}
		?>
		<h4>Application</h4>
		<a class="btn btn-success" href="?task=up">Up</a>
		<a class="btn btn-success" href="?task=down">Down</a>
		<h4>Application Cache Clear</h4>
		<a class="btn btn-success" href="?task=clear_compiled">Clear Compiled</a>
		<a class="btn btn-success" href="?task=clear_cache">Clear Cache</a>
		<a class="btn btn-success" href="?task=clear_config">Clear Config</a>
		<a class="btn btn-success" href="?task=clear_view">Clear View</a>
		<h4>Migration</h4>
		<a class="btn btn-success" href="?task=migrate_status">Migration Status</a>
		<a class="btn btn-success" href="?task=run_migration">Run Migration</a>
		<a class="btn btn-success" href="?task=restart_queue">Restart Queue</a>
		<hr>
		<?php echo "<pre>$output</pre>"; ?>
		<footer>
			&copy; <?php echo date('Y'); ?> Tathagata Basu
		</footer>
		</div>
	</body>
</html>