<?php 
error_reporting(0);
$msg= '';
	
if(isset($_POST['domain'])) {
	
	
	$_POST['domain'] = str_replace('www.', '', $_POST['domain']);
	$_POST['domain'] = str_replace('www', '', $_POST['domain']);
	$_POST['domain'] = str_replace('/', '', $_POST['domain']);
	$_POST['domain'] = str_replace(':', '', $_POST['domain']);
	$_POST['domain'] = str_replace('https', '', $_POST['domain']);
	$_POST['domain'] = str_replace('http', '', $_POST['domain']);
	$_POST['domain'] = trim($_POST['domain']);
	$_POST['domain'] = filter_var($_POST['domain'], FILTER_SANITIZE_URL);

	$domain = explode('.',$_POST['domain']);
	if(!$domain[1])
		$domain=$domain[0].'.com';
	else
		$domain=$_POST['domain'];
	
	
	$bodyContent = '{
	 "consent": {
		"agreedAt": "'.date("Y-m-d\TH:i:s\Z").'",
		"agreedBy": "192.168.1.25",
		"agreementKeys": [
		  "DNRA"
		]
	  },
	  "contactAdmin": {
		"addressMailing": {
		  "address1": "Gomti Nagar",
		  "address2": "Lucknow",
		  "city": "Lucknow",
		  "country": "IN",
		  "postalCode": "226010",
		  "state": "Uttar pradesh"
		},
		"email": "user@example.com",
		"fax": "",
		"jobTitle": "Full Stack Developer",
		"nameFirst": "Hemant",
		"nameLast": "Vishwakarma",
		"nameMiddle": "",
		"organization": "Wizweb Technology",
		"phone": "+91.9876543210"
	  },
	  "contactBilling": {
		"addressMailing": {
		 "address1": "Gomti Nagar",
		  "address2": "Lucknow",
		  "city": "Lucknow",
		  "country": "IN",
		  "postalCode": "226010",
		  "state": "Uttar pradesh"
		},
		"email": "user@example.com",
		"fax": "",
		"jobTitle": "Full Stack Developer",
		"nameFirst": "Hemant",
		"nameLast": "Vishwakarma",
		"nameMiddle": "",
		"organization": "Wizweb Technology",
		"phone": "+91.9876543210"
	  },
	  "contactRegistrant": {
		"addressMailing": {
		  "address1": "Gomti Nagar",
		  "address2": "Lucknow",
		  "city": "Lucknow",
		  "country": "IN",
		  "postalCode": "226010",
		  "state": "Uttar pradesh"
		},
		"email": "user@example.com",
		"fax": "",
		"jobTitle": "Full Stack Developer",
		"nameFirst": "Hemant",
		"nameLast": "Vishwakarma",
		"nameMiddle": "",
		"organization": "Wizweb Technology",
		"phone": "+91.9876543210"
	  },
	  "contactTech": {
		"addressMailing": {
		  "address1": "Gomti Nagar",
		  "address2": "Lucknow",
		  "city": "Lucknow",
		  "country": "IN",
		  "postalCode": "226100",
		  "state": "Uttar pradesh"
		},
		"email": "user@example.com",
		"fax": "",
		"jobTitle": "Full Stack Developer",
		"nameFirst": "Hemant",
		"nameLast": "Vishwakarma",
		"nameMiddle": "",
		"organization": "Wizweb Technology",
		"phone": "+91.9807321564"
	  },
	  "domain": "'.$domain.'",
	  "nameServers": [
		"ns50.domaincontrol.com",
		"ns60.domaincontrol.com"
	  ],
	  "period": 2,
	  "renewAuto": true
	}';


	$API_KEY 	= "3mM44UbC1dUFgm_XiVsriCcSKa3roqFL88opw";
	$API_SECRET = "Atq73KaYHZxByFBQvBE1c5";

	$url = "https://api.ote-godaddy.com/v1/domains/purchase";

	$header = array(
		'Authorization: sso-key '.$API_KEY.':'.$API_SECRET.'',
		"Content-Type: application/json",
		'Accept: application/json'
	);
	$ch = curl_init();

	$timeout=60;

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST'); // Values: GET, POST, PUT, DELETE, PATCH, UPDATE 
	curl_setopt($ch, CURLOPT_POSTFIELDS, $bodyContent);
	//curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	//execute call and return response data.
	$result = curl_exec($ch);
	//close curl connection
	curl_close($ch);
	// decode the json response
	$PurchaseDomain = json_decode($result, true);

	if($PurchaseDomain['code']){
		$msg= '<div class="alert alert-danger">'.$PurchaseDomain['message'].'</div>';		
	} else if($PurchaseDomain['orderId']) {
		$price = $PurchaseDomain['total']/1000000;
		$msg= '<div class="alert alert-success">Congrats! Your domain ('.$domain.') is registered. <br><p>'.$PurchaseDomain['currency'].$price.'</p></div>';
	}
//		print_r($PurchaseDomain);exit;


}
?> 

<html>
	<head>
		<title>Godaddy API - How to register or purchase domain from Godaddy API</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
	</head>
	<body>
		<div class="container" style="margin-top: 3%">
			<h1 class="text-center">Youtube - <a target="_blank" href="https://www.youtube.com/playlist?list=PLuKH7Xd7LecedHne7xz5aEeshwFhoy60g">Go To Playlist</a></h1>
			<br><br>
			<div class="row">
				<div class="col-md-3"></div>
				<div class="col-md-6">
					<h1>How to register or purchase domain from Godaddy API</h1>
					<?php if($msg) {?>
						<?php echo $msg;						
					?>
					<?php } ?>
					<form method="post" action="">
						<div class="form-group">
							<label>Domain Name</label>
							<input type="text" name="domain" class="form-control" value="<?php echo $_POST['domain']?>">
						</div>
						<hr>
						<button type="submit" class="btn btn-success">Purchase domain</button>
					</form>
				</div>
				<div class="col-md-3"></div>
			</div>
			
		</div>
	</body>
</html>