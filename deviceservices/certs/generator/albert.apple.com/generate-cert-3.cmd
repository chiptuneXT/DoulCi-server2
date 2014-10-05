@ECHO OFF
SET OPENSSL_CONF=C:\OpenServer\modules\http\Apache-2.4\conf\openssl.cnf
PATH=%PATH%;C:\OpenServer\modules\http\Apache-2.4\bin

openssl req -new -x509 -nodes -keyout albert_private.key -out albert.crt -days 3653 -config cert_3.cnf -reqexts v3_req -extensions v3_req -passout pass:icloud
openssl x509 -x509toreq -in albert.crt -out albert.csr -signkey albert_private.key -passin pass:icloud
openssl x509 -req -in albert.csr -CA VeriSignClass.crt -CAkey VeriSignClass_private.key -out albert.crt -nameopt RFC2253 -days 3653 -extfile cert_3.cnf -extensions v3_req -passin pass:icloud

del *.csr
pause