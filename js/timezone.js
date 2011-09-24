function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

var curdate = new Date();
var theoffset=curdate.getTimezoneOffset()+'';

if((theoffset.length)==4)
{
  var thehrs=parseInt(theoffset.substring(1,2));
  var thesign=theoffset.substring(0,1);
  var themin=parseInt(theoffset.substring(2,theoffset.length));
  theoffset = ((thehrs*60)+themin)*60*1000;
  theoffset = ''+thesign+theoffset;
}
else
{
  var thehrs=parseInt(theoffset.substring(1,3));
  var thesign=theoffset.substring(0,1);
  var themin=parseInt(theoffset.substring(3,theoffset.length));
  theoffset = ((thehrs*60)+themin)*60*1000;
  theoffset = ''+thesign+theoffset;
}

if(theoffset=='-43200000'){thezone="GMT-12:00";}if(theoffset=='-39600000'){thezone="GMT-11:00";}if(theoffset=='-36000000'){thezone="Hawaii Standard Time";}if(theoffset=='-34200000'){thezone="Marquesas Time";}if(theoffset=='-32400000'){thezone="Alaska Standard Time";}if(theoffset=='-28800000'){thezone="Pacific Standard Time";}if(theoffset=='-25200000'){thezone="Mountain Standard Time";}if(theoffset=='-21600000'){thezone="Central Standard Time";}if(theoffset=='-18000000'){thezone="Colombia Time";}if(theoffset=='-14400000'){thezone="Atlantic Standard Time";}if(theoffset=='-12600000'){thezone="Newfoundland Standard Time";}if(theoffset=='-10800000'){thezone="Argentine Time";}if(theoffset=='-7200000'){thezone="Fernando de Noronha Time";}if(theoffset=='-3600000'){thezone="Eastern Greenland Time";}if(theoffset=='3600000'){thezone="Central European Time";}if(theoffset=='10800000'){thezone="Eastern African Time";}if(theoffset=='11224000'){thezone="GMT+03:07";}if(theoffset=='12600000'){thezone="Iran Time";}if(theoffset=='14400000'){thezone="Aqtau Time";}if(theoffset=='16200000'){thezone="Afghanistan Time";}if(theoffset=='18000000'){thezone="Aqtobe Time";}if(theoffset=='19800000'){thezone="India Standard Time";}if(theoffset=='20700000'){thezone="Nepal Time";}if(theoffset=='21600000'){thezone="Mawson Time";}if(theoffset=='23400000'){thezone="Myanmar Time";}if(theoffset=='25200000'){thezone="Davis Time";}if(theoffset=='28800000'){thezone="Western Standard Time (Australia)";}if(theoffset=='32400000'){thezone="Choibalsan Time";}if(theoffset=='36000000'){thezone="Eastern Standard Time (New South Wales)";}if(theoffset=='37800000'){thezone="Load Howe Standard Time";}if(theoffset=='39600000'){thezone="Magadan Time";}if(theoffset=='41400000'){thezone="Norfolk Time";}if(theoffset=='43200000'){thezone="New Zealand Standard Time";}if(theoffset=='45900000'){thezone="Chatham Standard Time";}if(theoffset=='46800000'){thezone="GMT+13:00";}if(theoffset=='50400000'){thezone="GMT+14:00";}if(theoffset=='-43200000'){thezone="GMT-12:00";}if(theoffset=='-39600000'){thezone="GMT-11:00";}if(theoffset=='-36000000'){thezone="Hawaii-Aleutian Standard Time";}if(theoffset=='-34200000'){thezone="Marquesas Time";}if(theoffset=='-32400000'){thezone="Alaska Standard Time";}if(theoffset=='-28800000'){thezone="Pacific Standard Time";}if(theoffset=='-25200000'){thezone="Mountain Standard Time";}if(theoffset=='-18000000'){thezone="Central Standard Time";}if(theoffset=='-21600000'){thezone="Easter Is. Time";}if(theoffset=='-14400000'){thezone="Atlantic Standard Time";}if(theoffset=='-12600000'){thezone="Newfoundland Standard Time";}if(theoffset=='-10800000'){thezone="Argentine Time";}if(theoffset=='-7200000'){thezone="Fernando de Noronha Time";}if(theoffset=='3600000'){thezone="Eastern Greenland Time";}if(theoffset=='0'){thezone="Greenwich Mean Time";}if(theoffset=='3600000'){thezone="Central European Time";}if(theoffset=='7200000'){thezone="Eastern European Time";}if(theoffset=='10800000'){thezone="Eastern African Time";}if(theoffset=='11224000'){thezone="GMT+03:07";}if(theoffset=='12600000'){thezone="Iran Time";}if(theoffset=='14400000'){thezone="Aqtau Time";}if(theoffset=='16200000'){thezone="Afghanistan Time";}if(theoffset=='18000000'){thezone="Aqtobe Time";}if(theoffset=='20700000'){thezone="Nepal Time";}if(theoffset=='21600000'){thezone="Mawson Time";}if(theoffset=='23400000'){thezone="Myanmar Time";}if(theoffset=='25200000'){thezone="Christmas Island Time";}if(theoffset=='28800000'){thezone="Brunei Time";}if(theoffset=='32400000'){thezone="Palau Time";}if(theoffset=='34200000'){thezone="Central Standard Time (Northern Territory)";}if(theoffset=='36000000'){thezone="Eastern Standard Time (New South Wales)";}if(theoffset=='37800000'){thezone="Load Howe Standard Time";}if(theoffset=='39600000'){thezone="Magadan Time";}if(theoffset=='41400000'){thezone="Norfolk Time";}if(theoffset=='43200000'){thezone="New Zealand Standard Time";}if(theoffset=='45900000'){thezone="Chatham Standard Time";}if(theoffset=='46800000'){thezone="Tonga Time";}if(theoffset=='50400000'){thezone="Line Is. Time";} 

createCookie('tzoffset',thezone,7);
