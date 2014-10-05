<?php
header("Content-Type: application/xml");
echo
'<plist version="1.0">
	<dict>
		<key>iphone-activation</key>
		<dict>
			<key>ack-received</key>
			<true/>
			<key>show-settings</key>
			<true/>
		</dict>
	</dict>
</plist>';
?>