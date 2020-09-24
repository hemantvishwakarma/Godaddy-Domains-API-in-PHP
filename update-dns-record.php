<?php 

error_reporting(0);
$API_KEY 	= "";
$API_SECRET = "";
$domain 	= 'hemu8796.com';
$msg = '';
$TypeList = array('A','CNAME','MX','TXT','SRV','AAAA');
	
$domainDNSList = array();
//-----------GET DOMAINS RECORDS----------
foreach($TypeList as $typeData) {
	$url = "https://api.ote-godaddy.com/v1/domains/".$domain."/records/".$typeData;

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
	$dnsListData = json_decode($result, true);
	$domainDNSList[$typeData]=$dnsListData;
}
//print_r($domainDNSList);exit;

///---------------------UPDATE DNS RECORD----------------------
if($_GET['action'] == 'update') {
	$dns_domain 	= strtolower($domain);
	$dns_type 		= $_POST['type'];
	$dns_name 		= $_POST['name'];

	$dns_data 		= $_POST['data'];
	$dns_port 		= $_POST['port']==''?10:$_POST['port'];
	$dns_priority 	= $_POST['priority']==''?10:$_POST['priority'];
	$dns_protocol 	= $_POST['protocol']==''?'string':$_POST['protocol'];
	$dns_service 	= $_POST['service']==''?'string':$_POST['service'];
	$dns_ttl 		= $_POST['ttl_input'];
	$dns_weight 	= $_POST['weight']==''?'10':$_POST['weight'];

	$dns_records = "[{\"data\": \"$dns_data\",\"port\": $dns_port,\"priority\": $dns_priority,\"protocol\": \"$dns_protocol\",\"service\": \"$dns_service\",\"ttl\": $dns_ttl,\"weight\": $dns_weight}]";

//		return json_encode($dns_records);exit;
	$url2 = "https://api.ote-godaddy.com/v1/domains/$dns_domain/records/$dns_type/$dns_name";

	$header = array(
			'Authorization: sso-key '.$API_KEY.':'.$API_SECRET.'',
			'Content-Type: application/json',
			'Accept: application/json'
	);

	$ch = curl_init();
	$timeout=60;

	curl_setopt($ch, CURLOPT_URL, $url2);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);  
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT'); // Values: GET, POST, PUT, DELETE, PATCH, UPDATE  
	curl_setopt($ch, CURLOPT_POSTFIELDS, $dns_records);
	//curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	$result = curl_exec($ch);
	curl_close($ch);
		$result = json_decode($result, true);
//		print_r($result);exit;
	if(!$result) {
		$msg='<div class="alert alert-success">Your record is saved</div>';
		header('Location: update-dns-record.php');
	} else {
		$msg='<div class="alert alert-danger">'.$result['errors'][0].'</div>';
	}
}
?>


<html>
	<head>
		<title>Godaddy API - How to update DNS Records using GoDaddy API</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.4.0.min.js"></script>		
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>		
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	</head>
	<body>
		<div class="container" style="margin-top: 3%">
			<h1 class="text-center">Youtube - <a target="_blank" href="https://www.youtube.com/playlist?list=PLuKH7Xd7LecedHne7xz5aEeshwFhoy60g">Go To Playlist</a></h1>
			<h3 class="text-center">How to update DNS Records using GoDaddy API</h3>
			<?php if($msg) {echo $msg; } ?>
			<table class="table table-bordered table-striped">
				<thead>
					<th>Type</th>
					<th>Name</th>
					<th>Value</th>
					<th>TTL</th>
					<th>Action</th>
				</thead>
				<tbody>
					<?php //foreach($dns as $dn) {
							$i= 0; foreach($domainDNSList as $dnlist) {
							if($dnlist) {
//										echo '<pre>';print_r($dnlist);
							foreach($dnlist as $record) {
						?>
							<tr>
								<td><?php echo $record['type']?></td>
								<td><?php 
									if($record['service'] && $record['protocol'])
										echo $record['service'].'.'.$record['protocol'].'.'.$record['name'];
									else
										echo $record['name'];

									?></td>
								<td><?php 
									if($record['weight'] && $record['port']) {
										echo $record['priority'].' '.$record['weight'].' '.$record['port'].' '.$record['data'];
									} else {
										echo $record['data'];
										if($record['priority']) echo ' (priority : '.$record['priority'].')';
									}
								?></td>
								<td>
								<?php 
									if($record['ttl']=='1800')
										echo '1/2 Hour';
									else if($record['ttl']=='3600')
										echo '1 Hour';
									else if($record['ttl']=='43200')
										echo '12 Hours';
									else if($record['ttl']=='86400')
										echo '1 Day';
									else if($record['ttl']=='604800')
										echo '1 Week';
									else 
										echo $record['ttl'] .' Seconds';
								?>

								</td>
								<td><a href="javascript:void(0);" id="edit<?php echo $i;?>">edit</a></td>
							</tr>
							<tr id="dnsFormRow<?php echo $i;?>" style="display: none;"> 
								<td colspan="5">
									<div id="alertMsg<?php echo $i;?>"></div>
									<form class="dns-form" method="post" action="update-dns-record.php?action=update" id="dnsForm<?php echo $i;?>">
										<input type="hidden" name="domain" value="<?php echo $domain?>">
										<input type="hidden" name="type" value="<?php echo $record['type']?>">
										<div class="row">
											<?php if($record['type']=='SRV') {?>
												<div class="col-md-3 form-group" id="ServiceDiv">
													<label>Service </label>
													<input type="text" name="service" value="<?php echo $record['service']?>" class="form-control">
												</div>

												<div class="col-md-3 form-group" id="ProtocolDiv">
													<label>Protocol </label>
													<input type="text" name="protocol" value="<?php echo $record['protocol']?>" class="form-control">
												</div>
											<?php } ?>
											<div class="col-md-2 form-group">
												<?php if($record['type']=='SRV') {?>
												<label>Name</label>
												<?php } else {?>
												<label>Host</label>														
												<?php } ?>

												<input type="text" name="name" value="<?php echo $record['name']?>" class="form-control">
											</div>
											<div class="col-md-3 form-group">
												<?php if($record['type']=='TXT') {?>
												<label>TXT Value</label>
												<?php } else if($record['type']=='SRV') {?>
												<label>Target</label>
												<?php } else {?>
												<label>Points to</label>
												<?php } ?>
												<input type="text" name="data" value="<?php echo $record['data']?>" class="form-control">
											</div>
											<?php if($record['type']=='MX' || $record['type']=='SRV') {?>
												<div class="col-md-3 form-group">
													<label>Priority </label>
													<input type="number" min="0" value="<?php echo $record['priority']?>" name="priority" class="form-control">
												</div>
											<?php } ?>
											<?php if($record['type']=='SRV') {?>
											<div class="col-md-3 form-group" id="WeightDiv">
												<label>Weight </label>
												<input type="number" min="0" value="<?php echo $record['weight']?>" name="weight" class="form-control">
											</div>
											<div class="col-md-3 form-group" id="PortDiv">
												<label>Port </label>
												<input type="number" min="0" value="<?php echo $record['port']?>" name="port" class="form-control">
											</div>
											<?php } ?>
											<div class="col-md-2 form-group">
												<label>TTL</label>
												<select id="ttl<?php echo $i;?>" name="ttl" class="form-control" style="padding: 0;margin: 0;">
													<option <?php echo $record['ttl']=='1800'?'selected':'';?> value="1800">1/2 Hour</option>
													<option <?php echo $record['ttl']=='3600'?'selected':'';?> value="3600">1 Hour</option>
													<option <?php echo $record['ttl']=='43200'?'selected':'';?> value="43200">12 Hours</option>
													<option <?php echo $record['ttl']=='86400'?'selected':'';?> value="86400">1 Day</option>
													<option <?php echo $record['ttl']=='604800'?'selected':'';?> value="604800">1 Week</option>
													<option <?php if($record['ttl']=='-1' || $record['ttl']<1800) echo 'selected';?> value="custom">custom</option>
												</select>
											</div>
											<div id="ttlInput<?php echo $i;?>" class="col-md-2 form-group" style="display: <?php echo $record['ttl']<1800 ? 'block':'none'?>;">
												<label>Seconds</label>
												<input type="text" class="form-control" id="tllInputVal<?php echo $i;?>" value="<?php echo $record['ttl'];?>" name="ttl_input" required>
											</div>
											<div class="col-md-2 form-group">
												<p style="margin: 0">&nbsp;</p>
												<button type="submit" id="submitBtn<?php echo $i;?>" class="btn btn-primary btn-sm" style="padding: .39rem .5rem;font-size: .875rem;">Save</button>
												<button type="button" class="btn outline-btn btn-sm" id="cancel<?php echo $i;?>" style="padding: .39rem .5rem;font-size: .875rem;">Cancel</button>
											</div>
										</div>
									</form>
									<script>
										$(document).on('change', '#ttl<?php echo $i;?>', function() {
											var ttlValue<?php echo $i;?> = $('#ttl<?php echo $i;?>').val();
											if(ttlValue<?php echo $i;?> == 'custom') {
												$('#ttlInput<?php echo $i;?>').show();
												$('#tllInputVal<?php echo $i;?>').val('');
											} else {
												$('#ttlInput<?php echo $i;?>').hide();
												$('#tllInputVal<?php echo $i;?>').val(ttlValue<?php echo $i;?>);
											}
										})

										$(document).on('click', '#edit<?php echo $i;?>', function() {
											$('#dnsFormRow<?php echo $i;?>').show();
										})

										$(document).on('click', '#cancel<?php echo $i;?>', function() {
											$('#dnsFormRow<?php echo $i;?>').hide();
										})
//										$(document).ready(function(){
//											$('#dnsForm<?php echo $i;?>').on('submit', function(e){
//												$('#submitBtn<?php echo $i;?>').html('please wait...');
//												updateDNSRecord($(this).serialize(), <?php echo $i;?>);
//												return false;
//											});
//										});
									</script>
								</td>
							</tr>
						<?php $i++;} } } ?>
						<tr>
							<td colspan="5" class="text-right">
								<a href="javascript:void(0)" id="addNewRecordBtn"><strong>add new record</strong></a>
							</td>
						</tr>
				</tbody>
			</table>
			
			<div id="addDnsDiv" style="display: none;">	
				<div id="alertMsg25"></div>						
				<form class="dns-form" id="addDnsForm"  method="post" action="update-dns-record.php?action=update">
					<div style="width: 20%;">
						<select class="form-control" id="Type" name="type" style="padding: 0;margin: 0;">
							<option value="">select</option>
							<?php foreach($TypeList as $dn) {?>											
								<option value="<?php echo $dn?>"><?php echo $dn?></option>
							<?php } ?>
						</select>
					</div>
					<input type="hidden" name="domain" value="<?php echo $domain?>">
					<span>&nbsp;</span>
					<div class="row" id="addDnsRow" style="display: none;">

						<div class="col-md-3 form-group" id="ServiceDiv" style="display: none">
							<label>Service </label>
							<input type="text" name="service" class="form-control">
						</div>

						<div class="col-md-3 form-group" id="ProtocolDiv" style="display: none">
							<label>Protocol </label>
							<input type="text" name="protocol" class="form-control">
						</div>

						<div class="col-md-2 form-group">
							<label id="HostLabel">Host</label>
							<input type="text" name="name" class="form-control" required>
						</div>
						<div class="col-md-3 form-group">
							<label id="txtLevel">Points to</label>
							<input type="text" name="data" class="form-control" required>
						</div>
						<div class="col-md-3 form-group" id="PriorityDiv" style="display: none">
							<label>Priority </label>
							<input type="number" min="0" value="" name="priority" class="form-control">
						</div>
						<div class="col-md-3 form-group" id="WeightDiv" style="display: none">
							<label>Weight </label>
							<input type="number" min="0" value="" name="weight" class="form-control">
						</div>
						<div class="col-md-3 form-group" id="PortDiv" style="display: none">
							<label>Port </label>
							<input type="number" min="0" value="" name="port" class="form-control">
						</div>

						<div class="col-md-2 form-group">
							<label>TTL</label>
							<select id="ttl" name="ttl" required class="form-control" style="padding: 0;margin: 0;">
								<option value="">select</option>
								<option value="1800">1/2 Hour</option>
								<option value="3600">1 Hour</option>
								<option value="43200">12 Hours</option>
								<option value="86400">1 Day</option>
								<option value="604800">1 Week</option>
								<option value="custom">custom</option>
							</select>
						</div>
						<div id="ttlInput" class="col-md-2 form-group" style="display: none;">
							<label>Seconds</label>
							<input type="text" class="form-control" id="tllInputVal" name="ttl_input">
						</div>									
					</div>
					<div class="col-md-12 text-right form-group">
						<p style="margin: 0">&nbsp;</p>
						<button type="submit" id="submitBtn25" class="btn btn-primary btn-sm" style="padding: .39rem .5rem;font-size: .875rem;">Save</button>

						<button type="button" class="btn outline-btn btn-sm" id="cancel" style="padding: .39rem .5rem;font-size: .875rem;">Cancel</button>
					</div>
				</form>
				<script>
					$(document).on('change', '#Type', function() {
						var TypeVal = $(this).val()
						if(TypeVal) {
							$('#addDnsRow').show();
							if(TypeVal=='MX')
								$('#PriorityDiv').show();																				
							else if(TypeVal=='TXT') {
								$('#txtLevel').html('TXT Value');
								$('#PriorityDiv').hide();
							}
							else if (TypeVal=='SRV') {
								$('#txtLevel').html('Target');
								$('#ServiceDiv').show();
								$('#ServiceDiv input').prop('required',true);
								$('#ProtocolDiv').show();
								$('#ProtocolDiv input').prop('required',true);
								$('#HostLabel').html('Name');
								$('#PriorityDiv').show();
								$('#WeightDiv').show();
								$('#PortDiv').show();
							}										
							else {
								$('#txtLevel').html('Points to');
								$('#HostLabel').html('Host');
								$('#ServiceDiv').hide();
								$('#ServiceDiv input').prop('required',false);
								$('#ProtocolDiv').hide();
								$('#ProtocolDiv input').prop('required',false);
								$('#PriorityDiv').hide();
								$('#WeightDiv').hide();
								$('#PortDiv').hide();
								$('#PriorityDiv').hide();
							}
						}
						else
							$('#addDnsRow').hide();
					});

					$(document).on('change', '#ttl', function() {
						var ttlValue = $('#ttl').val();
						if(ttlValue == 'custom') {
							$('#ttlInput').show();
							$('#tllInputVal').val('');
						} else {
							$('#ttlInput').hide();
							$('#tllInputVal').val(ttlValue);
						}
					})

					$(document).on('click', '#addNewRecordBtn', function() {
						$('#addDnsDiv').show();
					})

					$(document).on('click', '#cancel', function() {
						$('#addDnsDiv').hide();
					})
					$(document).ready(function(){
						$('#addDnsForm').on('submit', function(e){
							$('#submitBtn25').html('please wait...');
							updateDNSRecord($(this).serialize(), '25');
							return false;
						});
					});
				</script>			
			</div>
	</body>
</html>


<!--
<script>
function updateDNSRecord(fdata, i){
//	alert(fdata);return false;
	$.ajax({
	  type	: 'POST',
	  url	: 'update-dns-record.php?action=update',
	  data	: fdata,	 
	  success: function(response) {
		  console.log('sdfsfd'+response);return false;
		  var obj = jQuery.parseJSON(response);
		  if(obj.code=='INVALID_RECORDS'){
			  $('#alertMsg'+i).html('<div class="text-danger">'+obj.errors+'</div>');
			  $('#submitBtn'+i).html('Save');
		  }
		  else if(obj.code=='INVALID_BODY'){
			  $('#alertMsg'+i).html('<div class="text-danger">'+obj.message+'</div>');
			  $('#submitBtn'+i).html('Save');
		  } else if(obj.status='success') {
			  $('#alertMsg'+i).html('<div class="text-success">'+obj.message+'</div>');
			  $('#submitBtn'+i).html('Save');
			  $('#preloader').show();
			  //location.reload();
		  }
	  }
	});
}
</script>-->
