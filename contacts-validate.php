<?php 
error_reporting(0);

$msg= '';
	
$bodyContent = '{
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
    "phone": "+91 9876543210"
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
    "phone": "+91 9876543210"
  },
  "contactPresence": {
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
    "phone": "+91 9876543210"
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
    "phone": "+91 9876543210"
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
    "phone": "+91 9807321564"
  },
  "domains": [
    "domains.com"
  ],
  "entityType": "ABORIGINAL"
}';


$API_KEY 	= "3mM44UbC1aTbCD_LqSrxUzYHCwnBfEsF1CByf";
$API_SECRET = "XcMYdiZWryvwTJgarqVWyk";

$url = "https://api.ote-godaddy.com/v1/domains/contacts/validate";

$header = array(
	'Authorization: sso-key '.$API_KEY.':'.$API_SECRET.'',
	"Content-Type: application/json"
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
$dn = json_decode($result, true);
if(!$dn)
	$msg= '<div class="alert alert-success">Your data is correct</div>';
else { 
	$msg= '<div class="alert alert-danger">Your data is incorrect</div>';		
}
//	print_r($dn);



?> 

<html>
	<head>
		<title>Godaddy API - Domain Contacts Validate</title>
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
						<?php echo $msg;
						foreach($dn['fields'] as $error) {
							echo '<p><strong>'.$error['path'].'</strong><br>'.$error['message'].'</p><br><br>';
						}
					?>
					<?php } ?>
					
				</div>
				<div class="col-md-3"></div>
			</div>
			
		</div>
	</body>
</html>