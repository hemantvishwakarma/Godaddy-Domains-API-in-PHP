<?php 
error_reporting(0);
$msg = '';
if(isset($_POST['btn']))  
{
	
	if($_POST['domain']) {
				
		$API_KEY 	= "";
		$API_SECRET = "";

		$_POST['domain'] = str_replace('www.', '', $_POST['domain']);
		$_POST['domain'] = str_replace('www', '', $_POST['domain']);
		$_POST['domain'] = str_replace('/', '', $_POST['domain']);
		$_POST['domain'] = str_replace(':', '', $_POST['domain']);
		$_POST['domain'] = str_replace('https', '', $_POST['domain']);
		$_POST['domain'] = str_replace('http', '', $_POST['domain']);
		$_POST['domain'] = trim($_POST['domain']);
		$_POST['domain'] = filter_var($_POST['domain'], FILTER_SANITIZE_URL);
		
		$domainTld = explode('.',$_POST['domain']); 
		if(!$domainTld[1])
			$domainTld=$domainTld[0].'.com';
		else
			$domainTld=$_POST['domain'];
		
		$url = "https://api.ote-godaddy.com/v1/domains/available?domain=".$domainTld;

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
		$checkDomain = json_decode($result, true);
		
//		print_r($checkDomain);
		if($checkDomain['available']==1 || $checkDomain['available']==true){
			$msg='<div class="alert alert-success">Congrats! Your domain <strong>'.$domainTld.'</strong> is available.</div>';
		} else if($checkDomain['code']) {
			$msg='<div class="alert alert-danger">'.$checkDomain['fields'][0]['message'].'</div>';
		} else if($checkDomain['available']=='' || $checkDomain['available']==0) {
			$msg='<div class="alert alert-danger">Sorry! This domain <strong>'.$domainTld.'</strong> is already registered.</div>';
		}
		
	} else {
		$msg='<div class="alert alert-danger">Please enter any domain keyword</div>';
	}
}

?>


<html>
	<head>
		<title>Godaddy API - Check Domain Availablity</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
	</head>
	<body>
		<div class="container" style="margin-top: 3%">
			<h1>Youtube - <a target="_blank" href="https://www.youtube.com/playlist?list=PLuKH7Xd7LecedHne7xz5aEeshwFhoy60g">Go To Playlist</a></h1>
			<br><br>
			<div class="row">
				<div class="col-md-3"></div>
				<div class="col-md-6">
					<?php if($msg) {?>
					<?php echo $msg;?>
					<?php } ?>
					<form action="" method="post">
						<div class="form-group">
							<label>Domain Name (example.com)</label>
							<input type="text" name="domain" placeholder="enter domain keyword" class="form-control">
						</div>
						<button type="submit" name="btn" class="btn btn-primary">Search Domain</button>
					</form>
				</div>
				<div class="col-md-3"></div>
			</div>
			
		</div>
	</body>
</html>