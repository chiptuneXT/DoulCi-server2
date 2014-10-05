<?php
$serverlist = file("servers.txt", FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
		
$requestlist = '';
foreach (glob("requests/*.xml") as $filename) 
{
    $requestlist = $requestlist.'<a href="fake-request.php?file='.basename($filename).'" >'.basename($filename, '.xml').'</a><br/>';
}

$requestfilename = 'requests/'.(isset($_GET['file']) ? $_GET['file'] : 'fake.php');

if (isset($_GET['file']) && file_exists($requestfilename))
{
	$activationinfo = file_get_contents($requestfilename);

	// load and decode activation info 
	$encodedrequest = new DOMDocument;
	$encodedrequest->loadXML($activationinfo);
	$activationDecoded= base64_decode($encodedrequest->getElementsByTagName('data')->item(0)->nodeValue);

	$decodedrequest = new DOMDocument;
	$decodedrequest->loadXML($activationDecoded);
	$nodes = $decodedrequest->getElementsByTagName('dict')->item(0)->getElementsByTagName('*');

	for ($i = 0; $i < $nodes->length - 1; $i=$i+2)
	{
		switch ($nodes->item($i)->nodeValue)
		{
			case "UniqueChipID": $ECID = $nodes->item($i + 1)->nodeValue; break;
			case "IntegratedCircuitCardIdentity": $ICCID = $nodes->item($i + 1)->nodeValue; break;
			case "SerialNumber": $AppleSerialNumber = $nodes->item($i + 1)->nodeValue; break;		
			case "InternationalMobileEquipmentIdentity": $IMEI = $nodes->item($i + 1)->nodeValue; break;		
			case "InternationalMobileSubscriberIdentity": $IMSI = $nodes->item($i + 1)->nodeValue; break;
		}
	}
}
$initialserver = isset($serverlist[0]) ? $serverlist[0] : 'http://localhost/';
foreach($serverlist as $item) { $servers = $servers.'<option value='.$item.'>'.$item.'</option>'; }

echo '
<html>
<title>IDevice activation</title>
<script type="text/javascript">function changeServer(aForm,aValue) { aForm.setAttribute("action",aValue); } </script>
<body>
<form id="request-form" action="'.$initialserver.'" method="POST">
  <p><b>iDevice activation form</b></p>
  <p><input type="submit" value="Activate"></p>
  <p>
		<table>
			<tr>
				<td>
					<table>
						<tr><td>SERVER:</td><td><select name="SRVNAME" size=1 required autofocus onChange="changeServer(this.form,this.value);" style="width: 635px">'.$servers.'</select></td></tr>
						<tr><td>ECID:</td><td><input type="text" size=100 name="ECID" value="'.$ECID.'"></td></tr>
						<tr><td>MachineName:</td><td><input type="text" size=100 name="machineName" value="ICLOUD"></td></tr>
						<tr><td>InStoreActivation:</td><td><input type="text" size=100 name="InStoreActivation" value="false"></td></tr>
						<tr><td>ICCID:</td><td><input type="text" size=100 name="ICCID" value="'.$ICCID.'"></td></tr>
						<tr><td>GUID:</td><td><input type="text" size=100 name="guid" value="0DFAE16C.6F57B068.B803AFB4.CC724E15.96ED2D9C.BFAF971B.95634B69"></td></tr>
						<tr><td>Apple serial number:</td><td><input type="text" size=100 name="AppleSerialNumber" value="'.$AppleSerialNumber.'"></td></tr>
						<tr><td>IMEI:</td><td><input type="text" size=100 name="IMEI" value="'.$IMEI.'"></td></tr>
						<tr><td>IMSI:</td><td><input type="text" size=100 name="IMSI" value="'.$IMSI.'"></td></tr>
						<tr><td>Activation info:</td><td><textarea name="activation-info" cols="80" rows="15" >'.$activationinfo.'</textarea></td></tr>
						<tr><td></td><td><input type="hidden" name="activation-info-base64" value="'.base64_encode($activationinfo).'"></td></tr>
					</table>
				</td>
				<td><div style="overflow:auto;height:500px;width:400px;">'.$requestlist.'</div></td>
			</tr>
		</table>
  </p>  
 </form> 
</body>
</html>';
?>