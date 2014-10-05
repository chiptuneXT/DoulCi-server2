@ECHO OFF
SET OPENSSL_CONF=C:\OpenServer\modules\http\Apache-2.4\conf\openssl.cnf
PATH=%PATH%;C:\OpenServer\modules\http\Apache-2.4\bin

openssl req -new -x509 -keyout VeriSignClass_private.key -out VeriSignClass.crt -days 3653 -config cert_2.cnf -reqexts v3_req -extensions v3_req -passout pass:icloud
openssl x509 -x509toreq -in VeriSignClass.crt -out VeriSignClass.csr -signkey VeriSignClass_private.key -passin pass:icloud
openssl x509 -req -in VeriSignClass.csr -CA VeriSign.crt -CAkey VeriSign_private.key -out VeriSignClass.crt -days 3653 -extfile cert_2.cnf -extensions v3_req -passin pass:icloud

del *.csr
pause