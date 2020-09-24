<?php 

$API_KEY 	= "";
$API_SECRET = "";


$url = "https://api.ote-godaddy.com/v1/domains/agreements?tlds=in&privacy=false";

$header = array(
	'Authorization: sso-key '.$API_KEY.':'.$API_SECRET.''
);
$ch = curl_init();
$timeout=60;
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);  
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
$result = curl_exec($ch);
curl_close($ch);
$aggrement = json_decode($result, true);

print_r($aggrement);exit;
?>


<html>
	<head>
		<title>Godaddy API - Domain TLD Agreement</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
	</head>
	<body>
		<div class="container" style="margin-top: 3%">
			<h1>Youtube - <a target="_blank" href="https://www.youtube.com/playlist?list=PLuKH7Xd7LecedHne7xz5aEeshwFhoy60g">Go To Playlist</a></h1>
			<table class="table table-bordered table-striped">
				<thead>
					<th>Domain Name</th>
					<th>Expiry Date</th>
					<th>Status</th>
					<th>Auto Renew</th>
				</thead>
				<tbody>
					<?php foreach($domainList as $dm) {?>
						<tr>
							<td><?php echo $dm['domain']?></td>
							<td><?php echo $dm['expires']?></td>
							<td><?php echo $dm['status']?></td>
							<td><?php echo $dm['renewAuto']=='1'?'Yes':'No'?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</body>
</html>