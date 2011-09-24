<?php

include("Date.php");



?>

<html>
<head>
</head>

<body>

<script language="javascript">
// create Date object for current location
var d = new Date();
document.write(d+"<br>");
// convert to msec since Jan 1 1970
var localTime = d.getTime();

document.write(localTime);
</script>

</body>

</html>