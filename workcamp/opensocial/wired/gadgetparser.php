<?php

require_once("parser_funcs.php");

$parser = xml_parser_create();
xml_set_element_handler($parser, startElemHandler, endElemHandler);
xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
xml_set_character_data_handler($parser, "parsecdata");

xml_parse($parser, $thexmldata);

xml_parser_free($parser);

?>