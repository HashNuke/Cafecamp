<?php

/*******************************/
/* BEGIN START ELEMENT HANDLER */
/*******************************/
function startElemHandler($parser, $name, $attribs) 
{

	global $app_config;

	if (strcasecmp($name, "Module") == 0) {
		echo("<html><head>");
		$import_js.="<script src=\"core/prototype.js\"></script>  \n";
		$import_js.="<script language=\"javascipt\" src=\"core/io.js\"></script>\n";
		$import_js.="<script language=\"javascipt\" src=\"core/prefs.js\"></script>\n";
		$import_js.="<script language=\"javascipt\" src=\"core/utils.js\"></script>\n";
		$import_js.="<script language=\"javascipt\" src=\"core/json.js\"></script>\n";
		
		echo($import_js);
		
		echo("<link href=\"style.css\" rel=\"stylesheet\" type=\"text/css\">\n");
		echo("</head><body>");
		echo("<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" id=\"appdiv\">");
		
	}
	
		
	if (strcasecmp($name, "ModulePrefs") == 0)
	{
		
		$gadget_title = $attribs['title'];
		$gadget_desc = $attribs['description'];
		$gadget_directory_title = $attrins['directory_title'];
		$gadget_desc = $attribs['author_email'];
		$gadget_screenshot = $attribs['screenshot'];
		$gadget_thumbnail = $attribs['thumbnail'];
		$gadget_height = $attribs['height'];
		$gadget_width = $attribs['width'];
		$gadget_scrolling = $attribs['scrolling']; /* default: true; will enable scrollbars when content exceeds iframe */
		$gadget_author = $attribs['author'];
		$gadget_author_affi = $attribs['author_affiliation'];
		$gadget_author_loc = $attribs['author_loc'];
		$gadget_author_loc = $attribs['author_photo'];
		$gadget_author_loc = $attribs['author_aboutme'];
		$gadget_author_loc = $attribs['author_link'];
		$gadget_author_loc = $attribs['author_quote'];
		echo("<tr>");	
		echo("<td>\n<table id=\"apptitle\" width=\"100%\">\n<tr><td width=\"95%\">\n".$gadget_title);	
		
		echo("</td><td>");
		
		if($app_config['userid']==$app_config['appowner'])
		{
			echo("<div id=\"appsettings\"><a href=\"#\"><img border=\"0\" src=\"".$app_config['script_dir']."images/settings.png\"></a></div>");
		}
		else
		{
			echo("<a href=\"addapps.php?".$theurl."\" target=\"_parent\"><img border=\"0\" src=\"".$app_config['script_dir']."images/addapp.png\"></a>");
		}
		
		echo("</td></tr></table></td></tr><tr><td>");
	}
	
		
	if (strcasecmp($name, "Require") == 0)
	{
		$require_feature = $attribs['feature'];
		$app_config['mod_eng_tag']=1;
		
		if($require_feature=="opensocial-0.7")
		{

			/** writing opensocial related files **/
			$import_js.="<script language=\"javascript\" src=\"".$app_config['script_dir']."content/opensocial.js\"></script>\n";
			$import_js.="<script language=\"javascript\" src=\"".$app_config['script_dir']."content/activity.js\"></script>\n";
			$import_js.="<script language=\"javascript\" src=\"".$app_config['script_dir']."content/address.js\"></script>\n";
			$import_js.="<script language=\"javascript\" src=\"".$app_config['script_dir']."content/collection.js\"></script>\n";
			$import_js.="<script language=\"javascript\" src=\"".$app_config['script_dir']."content/datarequest.js\"></script>\n";
			$import_js.="<script language=\"javascript\" src=\"".$app_config['script_dir']."content/dataresponse.js\"></script>\n";
			$import_js.="<script language=\"javascript\" src=\"".$app_config['script_dir']."content/email.js\"></script>\n";
			$import_js.="<script language=\"javascript\" src=\"".$app_config['script_dir']."content/enum.js\"></script>\n";
			$import_js.="<script language=\"javascript\" src=\"".$app_config['script_dir']."content/environment.js\"></script>\n";
			$import_js.="<script language=\"javascript\" src=\"".$app_config['script_dir']."content/message.js\"></script>\n";
			$import_js.="<script language=\"javascript\" src=\"".$app_config['script_dir']."content/name.js\"></script>\n";
			$import_js.="<script language=\"javascript\" src=\"".$app_config['script_dir']."content/organization.js\"></script>\n";
			$import_js.="<script language=\"javascript\" src=\"".$app_config['script_dir']."content/person.js\"></script>\n";
			$import_js.="<script language=\"javascript\" src=\"".$app_config['script_dir']."content/phone.js\"></script>\n";
			$import_js.="<script language=\"javascript\" src=\"".$app_config['script_dir']."content/responseitem.js\"></script>\n";
			$import_js.="<script language=\"javascript\" src=\"".$app_config['script_dir']."content/url.js\"></script>\n";

		}
		
		if($o_feature=="tabs")
		{
			$import_js.="<script language=\"javascript\" src=\"".$app_config['script_dir']."features/tabs.js\"></script>\n";
		}
		
		if($o_feature=="dynamic-height")
		{
			$import_js.="<script language=\"javascript\" src=\"".$app_config['script_dir']."features/dynamic-height.js\"></script>\n";
		}
		
		if($o_feature=="flash")
		{
			$import_js.="<script language=\"javascript\" src=\"".$app_config['script_dir']."features/flash.js\"></script>\n";
		}
		
		if($o_feature=="minimessage")
		{
			$import_js.="<script language=\"javascript\" src=\"".$app_config['script_dir']."features/minimessage.js\"></script>\n";
		}
		
		if($o_feature=="rpc")
		{
			$import_js.="<script language=\"javascript\" src=\"".$app_config['script_dir']."features/rpc.js\"></script>\n";
		}
		
		if($o_feature=="views")
		{
			$import_js.="<script language=\"javascript\" src=\"".$app_config['script_dir']."features/views.js\"></script>\n";
		}
		
		if($o_feature=="skins")
		{
			$import_js.="<script language=\"javascript\" src=\"".$app_config['script_dir']."features/skins.js\"></script>\n";
		}
		
		if($o_feature=="settitle")
		{
			$import_js.="<script language=\"javascript\" src=\"".$app_config['script_dir']."features/settitle.js\"></script>\n";
		}
	
		echo($import_js);
		
	}
	
	
	if (strcasecmp($name, "optional") == 0)
	{
		$app_config['mod_eng_tag']=1;
		$o_feature = $attribs['feature'];
		
		if($o_feature=="tabs")
		{
			$import_js.="<script language=\"javascript\" src=\"".$app_config['script_dir']."features/tabs.js\"></script>\n";
		}
		
		if($o_feature=="dynamic-height")
		{
			$import_js.="<script language=\"javascript\" src=\"".$app_config['script_dir']."features/dynamic-height.js\"></script>\n";
		}
		
		if($o_feature=="flash")
		{
			$import_js.="<script language=\"javascript\" src=\"".$app_config['script_dir']."features/flash.js\"></script>\n";
		}
		
		if($o_feature=="minimessage")
		{
			$import_js.="<script language=\"javascript\" src=\"".$app_config['script_dir']."features/minimessage.js\"></script>\n";
		}
		
		if($o_feature=="rpc")
		{
			$import_js.="<script language=\"javascript\" src=\"".$app_config['script_dir']."features/rpc.js\"></script>\n";
		}
		
		if($o_feature=="views")
		{
			$import_js.="<script language=\"javascript\" src=\"".$app_config['script_dir']."features/views.js\"></script>\n";
		}
		
		if($o_feature=="skins")
		{
			$import_js.="<script language=\"javascript\" src=\"".$app_config['script_dir']."features/skins.js\"></script>\n";
		}
		
		if($o_feature=="settitle")
		{
			$import_js.="<script language=\"javascript\" src=\"".$app_config['script_dir']."features/settitle.js\"></script>\n";
		}
		
		echo($import_js);
	}
	
	if(strcasecmp($name, "userprefs") == 0)
	{
		$app_config['up_end_tag']="0";
		
		if($app_config['up_end_tag']=="0")
		{	
						
			$app_config['up_end_tag']="1";
			
			echo("<div id=\"appsetdock\">");
			echo("<form name=\"gadgetsettings\" id=\"gadgetsettings\">");
			echo("<script language=\"javascript\">");
			echo("var required_ele=new Array();");
			echo("</script>");
			
		}
		
		$name = $attribs['name'];
		
		if($attribs['display_name']!="")
		{
			$disp_name = $attribs['display_name'];
		}
		else
		{
			$disp_name = $name;
		}
		
			$default_value = $attribs['default_value'];
			$required = $attribs['required'];
			
			if($required=="true")
			{
			$disp_name=$disp_name."<span style=\"color:#ff0000;\">*</span>";
			}
			
			if($datatype=="enum")
			{
				echo("<select name=\"$disp_name\">");
			}
			else if($datatype=="string")
			{
				echo($disp_name.": <input type=\"text\" name=\"$name\" value=\"$default_value\">");
								
				echo("<br>");
			}
			else if($datatype=="hidden")
			{
				
				echo("<input type=\"hidden\" name=\"$name\" value=\"$default_value\">");
			}
			else if($datatype=="bool")
			{
							
				if($default_value=="true")
				{
					echo($disp_name.": <input type=\"checkbox\" name=\"$name\" checked=\"yes\">");
				}
				else
				{
					echo($disp_name.": <input type=\"checkbox\" name=\"$name\">");
				}
				echo("<br>");
			}
			else
			{
				echo($disp_name.": <input type=\"text\" name=\"$name\" value=\"$default_value\">");
				echo("<br>");
			}
			
			if($required=="true")
			{
				echo("<script language=\"javascript\">");
				echo("required_ele.push(\"$name\");");
				echo("</script>");
			}
		
		
	}
	
	if (strcasecmp($name, "content") == 0)
	{
		if($app_config['up_end_tag']==1)
		{
			echo("</form></div>");
		}
			
		$cttype = $attribs['type'];
		
		if($cttype == "html")
		{
		echo("<div id=\"appct\">");
		$app_config['cttype']="html";
		}
		else
		{
		$cttype_href = $attribs['href'];
		$app_config['cttype']="url";
		echo("<iframe src=\"$cttype_href\" id=\"appct\" width=\"100%\" height=\"300px\" style=\"border:0px;\">");
		}
	}


}
/*****************************/
/* END START ELEMENT HANDLER */
/*****************************/




/*****************************/
/* BEGIN END ELEMENT HANDLER */
/*****************************/
function endElemHandler($parser, $name)
{
	if (strcasecmp($name, "module") == 0) {
		echo("</td></tr></table>");
		echo("</body>");
		
		if($_COOKIE['userID']==$_COOKIE['appowner'])
		{
		?>	
				<script language="javascript">
						
								
						Event.observe('appsettings', 'click', function(event)
						{
						 $("appsetdock").toggle();
						});
						$("appsetdock").toggle();
				</script>
				
		<?php
		}
		
		echo("</html>");
		
	}
	
	if (strcasecmp($name, "ModulePrefs") == 0)
	{
		if($app_config['mod_eng_tag']==1)
		{
			echo("</td></tr><tr><td>");
		}
		
	}
	
	if (strcasecmp($name, "content") == 0) {
		if($app_config['cttype']=="url")
		{
		echo("</iframe>");
		}
		else
		{
		echo("</div>");
		}
	}
}
/******************************/
/* END OF END ELEMENT HANDLER */
/******************************/

function parsecdata($parser, $name)
{
global $app_config;
	if($app_config['cttype']=="html")
	{
		$mycontent .= $name;
		echo $mycontent;
	}
}

?>