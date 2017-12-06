<?php
date_default_timezone_set('America/Toronto');
$directory = $_SESSION['base_url'] . "logs/*/*.html";

$logs = glob($directory);

require("config.php");

$now = time();

if($_GET['o'] > 0) {
	$offset = $_GET['o'] * 2592000;
}
else {
	$offset = 0;
}


$mysql_connect = mysqli_connect($mysql["host"], $mysql["username"], $mysql["password"]) or die("Unable to connect to the database.");

function secondsToTime($inputSeconds) {
	$then = new DateTime(date('Y-m-d H:i:s', $inputSeconds));
	$now = new DateTime(date('Y-m-d H:i:s', time()));
	$diff = $then->diff($now);
	return $diff->y . 'y ' . $diff->m . 'm ' . $diff->d . 'd';
}

$commanders = array('FluffyPira' => '<img style="height:20px; width:20px;" src="img/commander/Catmander_tag_(yellow).png" alt="[C]">');

$classtextcolor = array("1" => "text-ele", "2" => "text-mes", "3" => "text-necro", "4" => "text-thief", "5" => "text-ranger", "6" => "text-engi", "7" => "text-guard", "8" => "text-rev", "9" => "text-war", "10" => "text-ele", "11" => "text-mes", "12" => "text-necro", "13" => "text-thief", "14" => "text-ranger", "15" => "text-engi", "16" => "text-guard", "17" => "text-rev", "18" => "text-war", "19" => "text-ele", "20" => "text-mes", "21" => "text-necro", "22" => "text-thief", "23" => "text-ranger", "24" => "text-engi", "25" => "text-guard", "26" => "text-rev", "27" => "text-war");

$range1 = new DateTime();
$range1->setTimestamp($now-$offset);
$range2 = new DateTime();
$range2->setTimestamp($now-$offset-2592000);

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
	<link rel="shortcut icon" href="img/sis.png" type="image/png" />
	<title>[SIS] Sisters not Cisters</title>
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
					<img src="img/sis.png" style="width:50px;height:50px" alt="[SIS]"><span class="navbar-brand mb-0 h1">Sisters Not Cisters</span>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>

					<div class="collapse navbar-collapse" id="navbarSupportedContent">
						<ul class="nav nav-pills ml-auto" id="pills-tab" role="tablist">
							<li class="nav-item active">
								<a class="nav-link" id="pills-nav-raiders" data-toggle="pill" href="#pills-raiders" role="tab" aria-controls="pills-raiders" aria-selected="true">Raiders</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="pills-nav-logs" data-toggle="pill" href="#pills-logs" role="tab" aria-controls="pills-logs" aria-selected="false">Logs</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="pills-nav-resources" data-toggle="pill" href="#pills-resources" role="tab" aria-controls="pills-resources" aria-selected="false">Resources</a>
							</li>
						</ul>
					</div>
				</nav>
				<div class="content-bg">
					<div class="tab-content content-internal" id="pills-tabContent" data-spy="scroll" data-target="#navbar" data-offset="0">
						<div class="tab-pane fade show active" id="pills-raiders" role="tabpanel" aria-labelledby="pills-nav-raiders">
							<h4 id="raiders">Raiders</h4>
							<table class="table">
								<thead class="thead-default"><tr><th style="width:70%">Player:</th><th style="width:30%">Professions:</th>
								</thead>
								<?php
								mysqli_select_db($mysql_connect, $mysql["db"]) or die("Unable to select logon database.");

								#$query = sprintf("SELECT sis_raiders.discord_name, sis_raiders.gw2_name, gw2_characters.id as profile, gw2_characters.name, gw2_characters.role, gw2_characters.race, gw2_characters.age, gw2_classes.id, gw2_classes.name as class, gw2_classes.parentclass FROM sis_raiders
								#INNER JOIN gw2_characters ON sis_raiders.char = gw2_characters.id
								#INNER JOIN gw2_classes ON gw2_classes.id = gw2_characters.class 
								#ORDER BY discord_name ASC;");
							
								$query = sprintf("SELECT DISTINCT gw2_name, discord_name FROM sis_raiders ORDER BY discord_name ASC;");

								$result = mysqli_query($mysql_connect, $query);
								if(!$result)
								{
									echo mysqli_error($mysql_connect);
								}
								else{
									if(mysqli_num_rows($result) == 0)
									{
										echo 'No names.';
									}
									else
									{
										echo '<tbody>';
										while($row = mysqli_fetch_assoc($result)) {
													
											$acct = $row['discord_name'];
										
											$char_query = sprintf("SELECT gw2_characters.id as profile, gw2_characters.name, gw2_characters.role, gw2_classes.id, gw2_classes.name as class FROM sis_raiders INNER JOIN gw2_characters ON sis_raiders.char = gw2_characters.id INNER JOIN gw2_classes ON gw2_classes.id = gw2_characters.class WHERE sis_raiders.discord_name = '%s';", 
											$acct);

											$char_result = mysqli_query($mysql_connect, $char_query);
											if(!$char_result)
											{
												echo mysqli_error($mysql_connect);
											}
											else{
												if(mysqli_num_rows($char_result) == 0)
												{
													echo 'No characters.';
												}
												else
												{
													$profs = '';
													while($char_row = mysqli_fetch_assoc($char_result)) {
														$profs = $profs.'<img src="img/prof/'.$char_row['id'].'.png" alt="'.$char_row['class'].'">';
													}
												}
											}
													
											# "This is fine," she says, as her code burns down around her.
													
											$tag = '';
											$name = $row['discord_name'];
													
											if($commanders[$name]) {
												$tag = $commanders[$name]." ";
											}
													
											echo sprintf("<tr><td style=\"width:70%%\">%s%s</td><td style=\"width:30%%\">%s</td></tr>\n",
											$tag,
											$name,
											$profs);

				
										}
										echo '</tbody>';
									}
								}
								?>
							</table>
						</div>
						<div class="tab-pane fade" id="pills-logs" role="tabpanel" aria-labelledby="pills-nav-logs">
							<h4 id="logs">Logs</h4>
							<?php echo '<!-- Searching between: '.$range1->format('l, F j, Y - H:i:s').' and '.$range2->format('l, F j, Y - H:i:s').'-->'; ?>
							<table class="table table-hover" id="SortTable">
								<thead>
									<tr>
										<th scope="col" onclick="sortTable(0)">Date</th>
										<th scope="col" onclick="sortTable(1)">Boss</th>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach (array_reverse($logs) as $log) {
										$keywords = preg_split("/[-.\/]+/", $log);
										$log = str_replace(' ', '%20', $log);
										$fulldate = date_create_from_format('Ymd His', $keywords[2].$keywords[3]);

										if ((($now-$offset)-$fulldate->format('U')) < 2592000 ) {
											echo '<tr><th scope="row">'.$fulldate->format('l, F j, Y - H:i:s').'</th><td><a href="'.$log.'">'.$keywords[4].'</a></td></tr>';
										}
									}
									?>
								</tbody>
							</table>
						</div>
						<div class="tab-pane fade" id="pills-resources" role="tabpanel" aria-labelledby="pills-nav-resources">
							<h4 id="resources">Resources:</h4>
							<p class="lead">Useful Links for Guild Wars 2 raiders.</p>
							<p><strong>Character Building:</strong></p>
							<ul class="list-unstyled">
								<li><a href="http://metabattle.com/">Metabattle</a></li>
								<li><a href="http://qtfy.eu/">quanTify</a></li>
								<li><a href="https://snowcrows.com/">Snowcrows</a></li>
							</ul>
							<p><strong>Making Money:</strong></p>
							<ul class="list-unstyled">
								<li><a href="https://gw2efficiency.com/account/overview">Guild Wars 2 Efficiency</a></li>
								<li><a href="https://jfnaud.github.io/Guild-Wars-2-Gold-per-hour/">Gold Per Hour</a></li>
								<li><a href="https://www.gw2spidy.com/">Gw2 Spidy</a></li>
							</ul>
							<p><strong>Addons:</strong></p>
							<ul class="list-unstyled">
								<li><a href="https://www.deltaconnected.com/arcdps/">ArcDPS</a></li>
								<li><a href="https://04348.github.io/Gw2Hook/">Gw2 Hook</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		function sortTable(n) {
			var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
			table = document.getElementById("SortTable");
			switching = true;
			//Set the sorting direction to ascending:
			dir = "asc"; 
			/*Make a loop that will continue until
			no switching has been done:*/
			while (switching) {
				//start by saying: no switching is done:
				switching = false;
				rows = table.getElementsByTagName("TR");
				/*Loop through all table rows (except the
					first, which contains table headers):*/
					for (i = 1; i < (rows.length - 1); i++) {
						//start by saying there should be no switching:
						shouldSwitch = false;
						/*Get the two elements you want to compare,
						one from current row and one from the next:*/
						x = rows[i].getElementsByTagName("TD")[n];
						y = rows[i + 1].getElementsByTagName("TD")[n];
						/*check if the two rows should switch place,
						based on the direction, asc or desc:*/
						if (dir == "asc") {
							if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
								//if so, mark as a switch and break the loop:
								shouldSwitch= true;
								break;
							}
						} else if (dir == "desc") {
							if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
								//if so, mark as a switch and break the loop:
								shouldSwitch= true;
								break;
							}
						}
					}
					if (shouldSwitch) {
						/*If a switch has been marked, make the switch
						and mark that a switch has been done:*/
						rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
						switching = true;
						//Each time a switch is done, increase this count by 1:
						switchcount ++;      
					} else {
						/*If no switching has been done AND the direction is "asc",
						set the direction to "desc" and run the while loop again.*/
						if (switchcount == 0 && dir == "asc") {
							dir = "desc";
							switching = true;
						}
					}
				}
			}
	</script>
</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</html>
