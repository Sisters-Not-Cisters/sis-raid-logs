<?php
	date_default_timezone_set('America/Toronto');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="robots" content="" />
	<meta name="author" content="Elizabeth Wetton" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- <link rel="shortcut icon" href="http://wow.girlcock.club/img/favicon.gif" type="image/gif" /> -->
	<title>[SIS] Raid Logs</title>
	<style>
		body {
			background-image: url("img/bg/dragon.jpg");
			background-repeat: no-repeat;
			background-size: cover;
			background-attachment: fixed;
			background-position: top center;
		}
		.content-bg {
			background-color: rgba(230, 230, 230, 0.9);
		}
		.content-internal {
			padding: 5%;
		}
		</style>
	</head>
	<body>
		<!-- Simple Bootstrap Container. Seems popular with the other raiding guilds.-->
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-8 offset-md-2">
					<!-- Carousel may be classy here -->
					<!-- Similar to qT, let's have our navbar and content all in the section. -->
					<nav id="navbar" class="navbar sticky-top navbar-expand-lg navbar-light bg-light">
						<span class="navbar-brand mb-0 h1">Sisters Not Cisters</span>
						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-icon"></span>
						</button>

						<div class="collapse navbar-collapse" id="navbarSupportedContent">
							<ul class="nav nav-pills ml-auto">
								<li class="nav-item active">
									<a class="nav-link" href="#logs">Logs</a>
								</li>
							</ul>
						</div>
					</nav>
					<div class="content-bg">
						<div class="content-internal" data-spy="scroll" data-target="#navbar" data-offset="0">
							<h4 id="logs">Logs</h4>
							<table class="table table-hover">
								<thead>
									<tr>
										<th scope="col">Date</th>
										<th scope="col">Boss</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$logs = glob("logs/*/*");
										echo "<!--".$logs."-->\n";
										foreach ($logs as $log) {
											echo "<!--".$log."-->\n";
											list($folder, $subfolder, $date, $time, $boss, $ext) = split('[/.-]', $log);
											$fulldate = date_create_from_format('Ymd His', $date.$time);
											echo '<tr><th scope="row">'.$fulldate->format('l, F j, Y - H:i:s').'</th><td><a href="'.$log.'">'.$boss.'</a></th></tr>';
										}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</html>
