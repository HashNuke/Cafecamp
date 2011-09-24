function sendscribble(scribper,scrib,toclose,msgdiv) {

var scribblet = escape($(scrib).val());
  $.ajax({
   type: "POST",
   url: "scribbleit.php",
   data: "id="+scribper+"&scrib="+scribblet,
   success: function(msg){
     togglerspace(toclose);
     var thediv = '#'+msgdiv;
     $(thediv).html('<div id="scribblemsg">Scribbled successfully!</div>');
     Fat.fade_element(msgdiv, 60, 2500, '#FFFF66', '#E0FF91');
     var scribblet = $(scrib).val(' ');
   }
 });

}

function sendscribbledirect(scribper,scrib) {

var scribblet = escape($(scrib).val());
  $.ajax({
   type: "POST",
   url: "scribbleit.php",
   data: "id="+scribper+"&scrib="+scribblet,
   success: function(msg){
     enable_sb();
   }
 });


}

function deletescribble(scribid)
{
   $.ajax({
   type: "POST",
   url: "deletescribble.php",
   data: "id="+scribid,
   success: function(msg){
     var msgdiv = 'scribblebox_'+scribid;
     var thediv = '#'+msgdiv;
     $(thediv).html('<div id="scribblemsg">Scribble deleted successfully!</div>');
     Fat.fade_element(msgdiv, 60, 2500, '#FFFF66', '#E0FF91');
   }
 });
}

function approvefriend(approve_id)
{
  $.get("approvefriendrequest.php", { id: approve_id },
  function(data){
     var thediv = 'frbox_'+approve_id;
     var msgdiv = '#'+thediv;
     $(msgdiv).html('<div id="scribblemsg" style="text-align:center;font-size:90%;padding:3x 3px 3px 3px;">'+data+'</div>');
     Fat.fade_element(thediv, 60, 2500, '#FFFF66', '#E0FF91');
  });

}

function saveprofile()
{
var fname = escape($('#fname').val());
var month = $('#month').val();
var day = $('#day').val();
var year = $('#year').val();
var fnamet = fname;
fnamet = jQuery.trim(fnamet);
if(fnamet.length==0)
{
  $('#pagemsg').html('<div id="failmsg">Err... you must be having a first name!</div>');
  Fat.fade_element('failmsg', 60, 2500, '#CC0000', '#FF4747');
}
else if(!(isleap(year)) && (month=='February') && (day > 28))
{
  $('#pagemsg').html('<div id="failmsg">Err... in a non-leap year February doesn\'t have more than 28 days!</div>');
  Fat.fade_element('failmsg', 60, 2500, '#CC0000', '#FF4747');
}
else if((isleap(year)) && (month=='February') && (day > 29))
{
  $('#pagemsg').html('<div id="failmsg">Err... a leap year on earth doesn\'t have more than 29 days in Feb!</div>');
  Fat.fade_element('failmsg', 60, 2500, '#CC0000', '#FF4747');
}
else
{
var lname = escape($('#lname').val());
var gender = $('#gender').val();
var about = escape($('#about').val());
var country = escape($('#country').val());
var city = escape($('#city').val());
  $.ajax({
   type: "POST",
   url: "saveprofile.php",
   data: "fname="+fname+"&lname="+lname+"&gender="+gender+"&city="+city+"&country="+country+"&y="+year+"&m="+month+"&d="+day+"&a="+about,
   success: function(msg){
     $('#pagemsg').html('<div id="successmsg"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Profile saved!</b></div>');
     Fat.fade_element('successmsg', 60, 2500, '#FFFF66', '#E0FF91');
   }
 });

}
}

function addfriend(uid)
{
  $.get("addfriend.php", { id: uid },
  function(data){
     var thediv = 'addfriend_b';
     var msgdiv = '#'+thediv;
     $(msgdiv).html('<div id="scribblemsg" style="text-align:center;font-size:90%;padding:3x 3px 3px 3px;">'+data+'</div>');
     Fat.fade_element('scribblemsg', 60, 2500, '#FFFF66', '#E0FF91');
  });
}

function ignoreperson(uid)
{
  $.get("ignoreperson.php", { id: uid },
  function(data){
     var thediv = 'ignoreperson_b';
     var msgdiv = '#'+thediv;
     $(msgdiv).html('<div id="scribblemsg" style="text-align:center;font-size:90%;padding:3x 3px 3px 3px;">'+data+'</div>');
     Fat.fade_element('scribblemsg', 60, 2500, '#FFFF66', '#E0FF91');
  });
}

function isleap(yr){
        if ((parseInt(yr)%4) == 0){
            if (parseInt(yr)%100 == 0){
                if (parseInt(yr)%400 != 0){
                    return "false";
                }
                if (parseInt(yr)%400 == 0){
                    return "true";
                }
            }
            if (parseInt(yr)%100 != 0){
                return "true";
            }
        }
        if ((parseInt(yr)%4) != 0){
            return "false";
        }    
    }
    
    
function getElement(aID)
    {
        return (document.getElementById) ?
            document.getElementById(aID) : document.all[aID];
    }

    function getIFrameDocument(aID){ 
        var rv = null; 
        var frame=getElement(aID);
        // if contentDocument exists, W3C compliant (e.g. Mozilla) 

        if (frame.contentDocument)
            rv = frame.contentDocument;
        else // bad IE  ;)

            rv = document.frames[aID].document;
        return rv;
    }

function adjustMyFrameHeight(frname)
{
    var frame = getElement(frname);
    var frameDoc = getIFrameDocument(frname);
    frame.height = frameDoc.body.offsetHeight;
}