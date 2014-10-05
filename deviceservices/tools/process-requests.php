<?php
foreach (glob("requests/*.xml") as $filename) 
{
    try
	{
		$activationinfo = file_get_contents($filename);		
		// load and decode activation info 
		$encodedrequest = new DOMDocument;
		$encodedrequest->loadXML($activationinfo);
		$activationDecoded= base64_decode($encodedrequest->getElementsByTagName('data')->item(0)->nodeValue);
		$fairPlayCertChain= $encodedrequest->getElementsByTagName('data')->item(1)->nodeValue;

		$decodedrequest = new DOMDocument;
		$decodedrequest->loadXML($activationDecoded);
		$nodes = $decodedrequest->getElementsByTagName('dict')->item(0)->getElementsByTagName('*');

		for ($i = 0; $i < $nodes->length - 1; $i=$i+2)
		{
			switch ($nodes->item($i)->nodeValue)
			{
				case "DeviceCertRequest": $deviceCertRequest = base64_decode($nodes->item($i + 1)->nodeValue); break;
				case "SerialNumber": $serialNumber = $nodes->item($i + 1)->nodeValue; break;
				case "DeviceClass": $deviceClass = $nodes->item($i + 1)->nodeValue; break;
			}
		}
		
		include('producttypes.php');
		$devicefolder = '../devices/'.$deviceClass.'/'.$serialNumber.'/';
		if (!file_exists('../devices/'.$deviceClass.'/')) mkdir('../devices/'.$deviceClass.'/');
		if (!file_exists($devicefolder))  mkdir($devicefolder);
		
		$encodedrequest->save($devicefolder.'device-request.xml');
		$decodedrequest->save($devicefolder.'device-request-decoded.xml');
		file_put_contents($devicefolder.'cert-request.crt', $deviceCertRequest);
		file_put_contents($devicefolder.'fairPlayCertChain.crt', '-----BEGIN CERTIFICATE-----'.$fairPlayCertChain.'-----END CERTIFICATE-----');

		echo $filename.'............................ PROCESSED!<br/>';
	} catch (Exception $e) { echo 'Could not parse request file <b>'.basename($filename).'</b><br/>'; }
}
?>