@ECHO OFF
SET OPENSSL_CONF=C:\OpenServer\modules\http\Apache-2.4\conf\openssl.cnf
PATH=%PATH%;C:\OpenServer\modules\http\Apache-2.4\bin

rem openssl x509 -in iPhoneDeviceCA_minacriss.crt -pubkey -noout > iPhoneDeviceCA_minacriss.key
rem openssl x509 -in iPhoneDeviceCA_apple.crt -pubkey -noout > iPhoneDeviceCA_apple.key
rem openssl x509 -in iPhoneDeviceCA_team.crt -pubkey -noout > iPhoneDeviceCA_team.key

rem extract public key from private key
openssl rsa -in iPhoneDeviceCA_private.key -out iPhoneDeviceCA_public.key -outform PEM -pubout -passin pass:icloud

pause