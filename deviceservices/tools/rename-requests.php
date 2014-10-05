<?php
foreach (glob("requests/*.xml") as $filename) 
{
    try
	{
		$requestfile = file_get_contents($filename);
		// load and decode activation info 
		$encodedrequest = new DOMDocument;
		$encodedrequest->loadXML($requestfile);
		$activationDecoded= base64_decode($encodedrequest->getElementsByTagName('data')->item(0)->nodeValue);

		$decodedrequest = new DOMDocument;
		$decodedrequest->loadXML($activationDecoded);
		$nodes = $decodedrequest->getElementsByTagName('dict')->item(0)->getElementsByTagName('*');

		for ($i = 0; $i < $nodes->length - 1; $i=$i+2)
		{
			switch ($nodes->item($i)->nodeValue)
			{
				case "ProductType": $productType = $nodes->item($i + 1)->nodeValue; break;
				case "ProductVersion": $productVersion = $nodes->item($i + 1)->nodeValue; break;
				case "SerialNumber": $serialNumber = $nodes->item($i + 1)->nodeValue; break;
			}
		}

		echo basename($filename).' -><br/>';
		$newfilename = str_replace(',', '.', $productType).'_ios'.$productVersion.'_'.$serialNumber.'.xml';
		echo '<b style="color: green">'.$newfilename.'</b>';
		echo ' ...................................................................... <b>'.
				(rename($filename, 'requests/'.$newfilename) ? 'OK' : 'ERROR').'</b>';
	} catch (Exception $e) {	echo 'Could not parse request file <b>'.basename($filename).'</b>';}
	echo '<br/>------------------------------------------------------------------------------<br/>';
}
?>