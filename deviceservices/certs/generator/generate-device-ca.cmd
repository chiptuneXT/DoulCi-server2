@ECHO OFF
SET OPENSSL_CONF=C:\OpenServer\modules\http\Apache-2.4\conf\openssl.cnf
PATH=%PATH%;C:\OpenServer\modules\http\Apache-2.4\bin
REM iPhone Device CA
openssl req -new -x509 -keyout iPhoneDeviceCA_private.key -out iPhoneDeviceCA.crt -days 3653 -set_serial 0x01 -config extensions_device_ca.cnf -reqexts v3_req -extensions v3_req -passout pass:icloud
rem openssl x509 -x509toreq -in iPhoneDeviceCA.crt -out iPhoneDeviceCA.csr -signkey iPhoneDeviceCA_private.key -passin pass:icloud
rem openssl x509 -req -in iPhoneDeviceCA.csr -CA iPhoneCA.crt -CAkey iPhoneCA_private.key -out iPhoneDeviceCA.crt -days 3653 -extfile extensions_device_ca.cnf -extensions v3_req -set_serial 0x01 -passin pass:icloud
REM --------

pause