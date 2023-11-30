<!DOCTYPE html>
<html lang="en">

	<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="../styles/login.css"/>

        <link rel="apple-touch-icon" sizes="180x180" href="../images/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="../images/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="../images/favicon-16x16.png">
        <link rel="manifest" href="../images/site.webmanifest">

		<script src="../scripts/login.js" type="text/javascript"></script>
		<title>Login</title>
	</head>

	<body>
		<div id="signUpBoxes">
			<h1 class="header">Login</h1>
			<form method="post" class="form" id="form" action="../scripts/index.php" onsubmit="return Validate(form);">
				<div>
					<div class="form-control">
						<label for="email">Email:</label>
						<input type="email" name="email" id="email" required/>
						<small>Error</small>
					</div>
					
					<div class="form-control">
						<label for="password">Password:</label>
						<input type="password" name="password" id="password" required/>
						<small>Error</small>
					</div>
					
					<input type="hidden" name="hiddenField" id="hiddenField" value="e11869d1186d0791" />
					
					<button type="submit" name="submit_form" id="submit_form">Login</button>
				</div>
			</form>
		</div>
	</body>
</html>