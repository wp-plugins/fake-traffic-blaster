/*
Fake Traffic Blaster
*/
var daysToLive = "365";
var cookieName = "blog_newvisitor";

function ftReferrer() {
	if (document.referrer && document.referrer != "") {return true;}
	else {return false;}
}
ftReferrer();

function Action(redirectURL) {
	location.href = redirectURL;
}

function readCookie(name) {
 var nameEQ = name + "=";
 var ca = document.cookie.split(';');
 
for(var i=0;i < ca.length;i++) {
var c = ca[i];
while (c.charAt(0)==' ') c = c.substring(1,c.length);
if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
}
return false; 
}

function eraseCookie(name) {
 createCookie(name,"",-1);
}