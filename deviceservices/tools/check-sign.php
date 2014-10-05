<?php
include('crypt/RSA.php');
$private_key = file_get_contents("../certs/signature_private.key");
$pkeyid = openssl_pkey_get_private($private_key);
#$public_key = file_get_contents("../certs/signature_public.key");

$accountTokenBase64=base64_encode('{'."\n\t".'"ActivationRandomness" = "F34182B4-4FE1-47D2-96F3-5851EF00D28F";'.
															  "\n\t".'"UniqueDeviceID" = "463fc92a2d3462dec0e2c4f98d445abe46730d6a";'."\n".'}');

// compute signature
openssl_sign($accountTokenBase64, $signature, $pkeyid);

$rsa = new Crypt_RSA(); 
$rsa->loadKey($private_key); 
$rsa->loadKey($rsa->getPublicKey());
$rsa->setSignatureMode(CRYPT_RSA_SIGNATURE_PKCS1); 

echo 'Signature is '.($rsa->verify($accountTokenBase64, $signature) ? 'correct' : 'incorrect');

openssl_free_key($pkeyid);
/*
$pkeyid = openssl_pkey_get_private(file_get_contents("../certs/signature_private.key"));
$public_key = file_get_contents("../certs/signature_public.key");

#$pubkeydetails=openssl_pkey_get_details($pkeyid)["key"];
#$pubkeyid = openssl_pkey_get_public($pubkeydetails);

// compute signature
openssl_sign("test", $signature, $pkeyid);

$result = openssl_verify("test", $signature, $public_key);

echo 'Signature is '.($result == 1 ? 'correct' : $result == 0 ? 'incorrect' : 'erroneous');

openssl_free_key($pkeyid);
#openssl_free_key($pubkeyid);*/
?>