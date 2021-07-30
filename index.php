<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<title>SIGRPO</title>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
	<style type="text/css">
		.py-3 {
			font-size: 65px;
			font-weight: bolder;
		}
	</style>
</head>
<body onload="startTime()">
	<div class="col-sm-3"></div>
	<div class="well col-md-6">
		<div class="form-group">
			<div class="header">
				<h1 class="text-center" style="font-size: 85px; font-weight: bolder;">SIGRPO</h1>
				<p class="text-center" style="font-size: 25px;">
					<strong>
						<?php

						$dia  = date('D');
						$date = date('d/m/Y');
						switch ($dia) {
							case 'Sun':
							$dia = "Dom";
							break;
							case 'Mon':
							$dia = "Seg";
							break;
							case 'Tue':
							$dia = "Ter";
							break;
							case 'Wed':
							$dia = "Qua";
							break;
							case 'Thu':
							$dia = "Qui";
							break;
							case 'Fri':
							$dia = "Sex";
							break;
							case 'Sat':
							$dia = "Sab";
							break;
						}
						echo $dia.", ".$date;
						?>
					</strong>
				</p>
			</div>
			<script>
				function startTime() {
					var today = new Date();
					var h = today.getHours();
					var m = today.getMinutes();
					var s = today.getSeconds();
					h = checkTime(h);
					m = checkTime(m);
					s = checkTime(s);
					document.getElementById('clock').innerHTML =
					h + ":" + m + ":" + s;
					var t = setTimeout(startTime, 500);
				}

				function checkTime(i) {
					// add zero in front of numbers < 10
					if (i < 10) {i = "0" + i}
					return i;
				}
				
				/*
				* Remover alert depois de 5 segundos
				*/
				$(document).ready(function() {

				  window.setTimeout(function() {
				    $(".alert").fadeTo(1000, 0).slideUp(1000, function(){
				      $(this).remove();
				    });
				  }, 5000);

				});
			</script>
			<?php
			if (isset($_SESSION['msg'])) {
				echo $_SESSION['msg'];
				unset($_SESSION['msg']);
			}
			?>
			<div id="clock" class="text-center" style="font-size: 95px; font-weight: bolder;"></div>
			<form name="myHours" method="post" action="validate.php">
				<div class="btn-group-vertical" role="group" aria-label="Basic example">
					<div class="btn-group">
						<input type="text" name="registro" id="registro" class="form-control text-center" autofocus="true" value="" style="font-size:150px; height: 180px;"/>
					</div>
					<div class="btn-group">
						<button type="button" class="btn btn-outline-secondary py-3" onclick="document.getElementById('registro').value=document.getElementById('registro').value + '1';">1</button>
						<button type="button" class="btn btn-outline-secondary py-3" onclick="document.getElementById('registro').value=document.getElementById('registro').value + '2';">2</button>
						<button type="button" class="btn btn-outline-secondary py-3" onclick="document.getElementById('registro').value=document.getElementById('registro').value + '3';">3</button>
					</div>
					<div class="btn-group">
						<button type="button" class="btn btn-outline-secondary py-3" onclick="document.getElementById('registro').value=document.getElementById('registro').value + '4';">4</button>
						<button type="button" class="btn btn-outline-secondary py-3" onclick="document.getElementById('registro').value=document.getElementById('registro').value + '5';">5</button>
						<button type="button" class="btn btn-outline-secondary py-3" onclick="document.getElementById('registro').value=document.getElementById('registro').value + '6';">6</button>
					</div>
					<div class="btn-group">
						<button type="button" class="btn btn-outline-secondary py-3" onclick="document.getElementById('registro').value=document.getElementById('registro').value + '7';">7</button>
						<button type="button" class="btn btn-outline-secondary py-3" onclick="document.getElementById('registro').value=document.getElementById('registro').value + '8';">8</button>
						<button type="button" class="btn btn-outline-secondary py-3" onclick="document.getElementById('registro').value=document.getElementById('registro').value + '9';">9</button>
					</div>
					<div class="btn-group">
						<button type="button" class="btn btn-outline-secondary py-3" onclick="document.getElementById('registro').value=document.getElementById('registro').value.slice(0, -1);">&lt</button>
						<button type="button" class="btn btn-outline-secondary py-3" onclick="document.getElementById('registro').value=document.getElementById('registro').value + '0';">0</button>
						<button type="submit" class="btn btn-outline-secondary py-3">&gt;</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</body>
</html>
