@ECHO OFF
SET OPENSSL_CONF=C:\OpenServer\modules\http\Apache-2.4\conf\openssl.cnf
PATH=%PATH%;C:\OpenServer\modules\http\Apache-2.4\bin
REM root CA
openssl req -new -x509 -keyout RootCA_private.key -out RootCA.crt -days 3653 -set_serial 0x02 -config extensions_root_ca.cnf -reqexts v3_req -extensions v3_req -passout pass:icloud
REM --------
REM iPhone CA
openssl req -new -x509 -keyout iPhoneCA_private.key -out iPhoneCA.crt -days 3653 -set_serial 0x17 -config extensions_iphone_ca.cnf -reqexts v3_req -extensions v3_req -passout pass:icloud
openssl x509 -x509toreq -in iPhoneCA.crt -out iPhoneCA.csr -signkey iPhoneCA_private.key -passin pass:icloud
openssl x509 -req -in iPhoneCA.csr -CA RootCA.crt -CAkey RootCA_private.key -out iPhoneCA.crt -days 3653 -extfile extensions_iphone_ca.cnf -extensions v3_req  -set_serial 0x17 -passin pass:icloud
REM --------
REM iPhone Device CA
openssl req -new -x509 -keyout iPhoneDeviceCA_private.key -out iPhoneDeviceCA.crt -days 3653 -set_serial 0x01 -config extensions_device_ca.cnf -reqexts v3_req -extensions v3_req -passout pass:icloud
openssl x509 -x509toreq -in iPhoneDeviceCA.crt -out iPhoneDeviceCA.csr -signkey iPhoneDeviceCA_private.key -passin pass:icloud
openssl x509 -req -in iPhoneDeviceCA.csr -CA iPhoneCA.crt -CAkey iPhoneCA_private.key -out iPhoneDeviceCA.crt -days 3653 -extfile extensions_device_ca.cnf -extensions v3_req  -set_serial 0x01 -passin pass:icloud
REM --------
REM iPhone Activation
openssl req -new -x509 -keyout iPhoneActivation_private.key -out iPhoneActivation.crt -days 3653 -set_serial 0x02 -config extensions_activation.cnf -reqexts v3_req -extensions v3_req -passout pass:icloud
openssl x509 -x509toreq -in iPhoneActivation.crt -out iPhoneActivation.csr -signkey iPhoneActivation_private.key -passin pass:icloud
openssl x509 -req -in iPhoneActivation.csr -CA iPhoneCA.crt -CAkey iPhoneCA_private.key -out iPhoneActivation.crt -days 3653 -extfile extensions_activation.cnf -extensions v3_req  -set_serial 0x02 -passin pass:icloud
REM --------
REM Device
REM openssl x509 -req -in cert-request.csr -CA iPhoneDeviceCA.crt -CAkey iPhoneDeviceCA_private.key -out serverCASigned.crt -days 3653 -extfile extensions_device.cnf -extensions usr_cert -CAcreateserial -passin pass:icloud
rem openssl x509 -req -in cert-request.csr -CA iPhoneDeviceCA.crt -CAkey iPhoneDeviceCA_private.key -out serverCASigned.crt -days 3653 -extfile extensions_device.cnf -extensions usr_cert -CAserial cert-sn.srl -passin pass:icloud
del *.csr
REM --------
REM 
REM openssl req -new -x509 -keyout iPhoneDeviceCA_private.key -out iPhoneDeviceCA.crt -days 3653 -set_serial 1 -config extensions_device_ca.cnf -reqexts v3_req -extensions v3_req -passout pass:icloud
REM openssl x509 -req -in cert-request.csr -CA iPhoneDeviceCA.crt -CAkey iPhoneDeviceCA_private.key -out signedCA_openssl.crt -days 3653 -extfile extensions_device.cnf -extensions usr_cert  -CAserial iPhoneDeviceCA.srl -passin pass:icloud

rem extract public key from private key
openssl rsa -in iPhoneDeviceCA_private.key -out iPhoneDeviceCA_public.key -outform PEM -pubout -passin pass:icloud
