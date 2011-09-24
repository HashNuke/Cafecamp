<?php 
// modify these constants to fit your environment
if (!defined("DB_SERVER")) define("DB_SERVER", "localhost");
if (!defined("DB_NAME")) define("DB_NAME", "jcafecam_workcamp");
if (!defined("DB_USER")) define ("DB_USER", "jcafecam_main");
if (!defined("DB_PASSWORD")) define ("DB_PASSWORD", "some_password");

// some external constants to control the output
define("QS_VAR", "p"); // the variable name inside the query string (don't use this name inside other links)
define("NUM_ROWS", 10); // the number of records on each page
define("STR_FWD", "&raquo;"); // the string is used for a link (step forward)
define("STR_BWD", "&laquo;"); // the string is used for a link (step backward)
define("NUM_LINKS", 10); // the number of links inside the navigation (the default value)
?>
