@ECHO OFF
SET OPENSSL_CONF=C:\OpenServer\modules\http\Apache-2.4\conf\openssl.cnf
PATH=%PATH%;C:\OpenServer\modules\http\Apache-2.4\bin
openssl x509 -req -in cert-request.csr -CA iPhoneDeviceCA.crt -CAkey iPhoneDeviceCA_private.key -out serverCASigned.crt -days 3653 -extfile extensions_device.cnf -extensions usr_cert -CAserial cert-sn.srl -passin pass:icloud
pause
REM --------
REM 
REM openssl req -new -x509 -keyout iPhoneDeviceCA_private.key -out iPhoneDeviceCA.crt -days 3653 -set_serial 1 -config extensions_device_ca.cnf -reqexts v3_req -extensions v3_req -passout pass:icloud
REM openssl x509 -req -in cert-request.csr -CA iPhoneDeviceCA.crt -CAkey iPhoneDeviceCA_private.key -out signedCA_openssl.crt -days 3653 -extfile extensions_device.cnf -extensions usr_cert -CAserial cert-sn.srl -passin pass:icloud
