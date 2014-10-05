@ECHO OFF
SET OPENSSL_CONF=C:\OpenServer\modules\http\Apache-2.4\conf\openssl.cnf
PATH=%PATH%;C:\OpenServer\modules\http\Apache-2.4\bin
openssl req -new -x509 -keyout VeriSign_private.key -out VeriSign.crt -days 3653 -config cert_1.cnf -reqexts v3_req -extensions v3_req -passout pass:icloud
pause