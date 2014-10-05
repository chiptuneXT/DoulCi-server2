<?php
$text = (array_key_exists('initialtext', $_POST) ? $_POST["initialtext"] : '');
$operation = (array_key_exists('callop', $_POST) ? $_POST["callop"] : null);
$result = (($operation === "Encode") ? base64_encode($text) : (($operation === "Decode") ? base64_decode($text) : "null"));

echo '
<html>
<title>Base64</title>
<body>
<form action="base64-tool.php" method="POST">
  <p><b>Base64 encoder/decoder</b></p>
  <p>
		<table>
			<tr><td>Initial text:</td><td><textarea name="initialtext" cols="80" rows="15">'.$text.'</textarea></td></tr>
		</table>
  </p>
  <p><input type="submit" name="callop" value="Encode"><input type="submit" name="callop" value="Decode"></p>
 </form>
 <br/>
 <b>RESULT:</b><p style="word-wrap: break-word">'.$result.'</p>
</body>
</html>';

?>