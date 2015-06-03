//
// poetrymembership.js -- AJAX login functions for LitKicks Action Poetry
//                        (using on evolt.org/jpmaster77 PHP Login code)
//
// Levi Asher December 2007
//
// requires Yahoo YUI
//

function cleanISOCrap(s) {
   // this is my very primitive attempt at solving problems with 
   // microsoft ISO-8859-1 characters
   
   s=s.replace(/\u2018/g,"'");
   s=s.replace(/\u2019/g,"'");
   s=s.replace(/\u201c/g,'"');
   s=s.replace(/\u201d/g,'"');
   s=s.replace(/\u8220/g,"'");
   s=s.replace(/\u8221/g,"'");
   s=s.replace(/\u2026/g,"...");
   s=s.replace(/\u2002/g,"");
   s=s.replace(/\u2003/g,"");
   s=s.replace(/\u2009/g,"");
   s=s.replace(/\u2012/g,"--");
   s=s.replace(/\u2013/g,"--");
   s=s.replace(/\u2014/g,"--");
   s=s.replace(/\u2015/g,"--");
   s = encodeURIComponent(s);
   return(s);
}

function getCheckedValue(radioObj) {
   if (!radioObj) {
      return "";
   }
   var radioLength = radioObj.length;
   if (radioLength == undefined) {
      if (radioObj.checked) {
	 return radioObj.value;
      } else {
	 return "";
      }
   }
   for (var i = 0; i < radioLength; i++) {
     if (radioObj[i].checked) {
        return radioObj[i].value;
     }
   }
   return "";
}

//////////////////////////////////////////////////
//
// displayPoetryFooter -- universal footer
//

var displayPoetryFooter = function(boxEl, username) {
   var barStr = "<hr noshade color=#444444 size=1 width=380 />";
   if (boxEl!=null) {
      if ((username!=null) && (username!="Guest") && (username!="null") && (username!="")) {
         contentStr = "You are logged in as <b>" + 
                      "<a href=\"ActionProfile?who=" +
		      username + "\">" + username + "</a>" + 
		      "<br /><br /></b>" +
		      "<a href=\"ActionPoetryHome\">View Poems</a>" +
		      " &#8226; <a href=\"ActionPoetryWrite\">Write a Poem</a>" +
		      " &#8226; <a href=\"ActionPoetryManageProfile\">Edit Account Info</a>" +
		      " &#8226; <a href=\"#\" onClick=\"doPoetryLogout(); return(false);\">Logout</a>" +
		      "<br /><a href=\"ActionPoetryArchives\">Archives</a>" + 
                      "<br /><br />";
      } else {
	 contentStr = "<a href=\"ActionPoetryHome\">View Poems</a>" +
	              " &#8226; <a href=\"ActionPoetryLogin\">Login</a>" +
	              " &#8226; <a href=ActionPoetryRegister>Register</a>" +
	              " &#8226; <a href=\"ActionPoetryForgotPassword\">Forgot Password?</a><br />" +
	              "<a href=http://www.litkicks.com>Return to LitKicks</a>" +
		      " &#8226; <a href=\"ActionPoetryArchives\">Archives</a>" + 
                      "<br /><br />";
      }
      var helpMsg = "<br /><br />If you have problems registering, logging in or editing your profile,<br />please email <a href=mailto:litkicks@gmail.com>litkicks@gmail.com</a> with a detailed description<br />of the problem.";
      boxEl.innerHTML = barStr + contentStr;
   }
}

///////////////////////////////
// 
// logout methods
//

var handlePoetryLogoutFailure = function(o) {
   var statusboxEl = document.getElementById("statusbox");
   var failMsg = "Connection failure -- please try again later";
   if (statusboxEl!=null) {
      statusboxEl.innerHTML = failMsg;
   }
}

var handlePoetryLogoutSuccess = function(o) {
   var statusboxEl = document.getElementById("statusbox");
   var mainboxEl = document.getElementById("mainbox");
   var footerboxEl = document.getElementById("footerbox");
   if (mainboxEl!=null) {
      var root = o.responseXML.documentElement;

      var contentStr = "";
      var username = null;
      var statusNodes = root.getElementsByTagName("logoutstatus");
      if (statusNodes==null) {
         contentStr = "<br /><b>An error has occurred while logging out.</b>";
      } else {
         contentStr = "<br /><b>Please " +
	              "<a href=\"ActionPoetryLogin\">Login</a> or " + 
		      "<a href=\"ActionPoetryRegister\">Register</a>" +
                      "</b>";
      }
         
      mainboxEl.innerHTML = contentStr;
      statusboxEl.innerHTML = "";
      displayPoetryFooter(footerboxEl, null);
   }
}

var poetryLogoutCallback =
{
   success: handlePoetryLogoutSuccess,
   failure: handlePoetryLogoutFailure,
   argument: { foo:"foo", bar:"bar" }
};

var doPoetryLogout = function(o) {
   var sUrl = "APTest/Membership/processXML.php";
   var postdata = "sublogout=1";
   var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, poetryLogoutCallback, postdata);
}

///////////////////////////////
// 
// login methods 
//

var handlePoetryLoginFailure = function(o) {
   var statusboxEl = document.getElementById("statusbox");
   var failMsg = "Connection failure -- please try again later";
   if (statusboxEl!=null) {
      statusboxEl.innerHTML = failMsg;
   }
}

var handlePoetryLoginSuccess = function(o) {
   var statusboxEl = document.getElementById("statusbox");
   var mainboxEl = document.getElementById("mainbox");
   if (mainboxEl!=null) {
      var root = o.responseXML.documentElement;

      var loginNodes = root.getElementsByTagName("loginstatus");
      var loginStatus = loginNodes[0].childNodes[0].nodeValue;
      var username = null;
      var usernameNodes = root.getElementsByTagName("username");
      if (usernameNodes[0]!=null) {
         username = usernameNodes[0].childNodes[0].nodeValue;
      }

      if (username!=null) {
         displayPoetryFooter(mainboxEl, username);
      } else {
         contentStr = "<b>Could not log in.</b><br /><br />" + 
		      "<a href=ActionPoetryLogin>Please try again</a>." + 
                      "</b>";
         mainboxEl.innerHTML = contentStr;
      }
   }
}

var poetryLoginCallback =
{
   success: handlePoetryLoginSuccess,
   failure: handlePoetryLoginFailure,
   argument: { foo:"foo", bar:"bar" }
};

function sendPoetryLoginRequest(loginform) {
   var user = loginform.user.value;
   var pass = loginform.pass.value;
   var rem = loginform.remember.value;
   var postData = "user=" + user + "&pass=" + pass + "&remember=" + rem + "&sublogin=1";
   var sUrl = "APTest/Membership/processXML.php";
   var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, poetryLoginCallback, postData);
}
 
///////////////////////////////
// 
// register methods 
//

var handlePoetryRegisterFailure = function(o) {
   var statusboxEl = document.getElementById("statusbox");
   var failMsg = "Connection failure -- please try again later";
   if (statusboxEl!=null) {
      statusboxEl.innerHTML = failMsg;
   }
}

var handlePoetryRegisterSuccess = function(o) {
   var statusboxEl = document.getElementById("statusbox");
   var footerboxEl = document.getElementById("footerbox");
   var mainboxEl = document.getElementById("mainbox");
   if (mainboxEl!=null) {
      var root = o.responseXML.documentElement;

      var registerNodes = root.getElementsByTagName("registerstatus");
      var registerStatus = registerNodes[0].childNodes[0].nodeValue;

      var usernameNodes = root.getElementsByTagName("username");
      var username = usernameNodes[0].childNodes[0].nodeValue;

      var contentStr = "";
      if (registerStatus!="success") {
         var messageNodes = root.getElementsByTagName("message");
         var message = messageNodes[0].childNodes[0].nodeValue; 
         contentStr = "<b>" + 
                      "Registration could not be completed: <br />" + message + 
                      "</b>";
      } else {
         contentStr = "Registration complete!  Please <a href=\"ActionPoetryLogin\">log in now</a> to edit your member<br />profile. Action Poetry will be ready to accept new poetry very<br />soon.";
	 //contentStr = "Registration complete: please <a href=ActionPoetryLogin>login</a>";
      }
      mainboxEl.innerHTML = contentStr;
      statusboxEl.innerHTML = "";            
      displayPoetryFooter(footerbox, "Guest");
   }
}

var poetryRegisterCallback =
{
   success: handlePoetryRegisterSuccess,
   failure: handlePoetryRegisterFailure,
   argument: { foo:"foo", bar:"bar" }
};

function sendPoetryRegisterRequest(registerform) {
   var user = registerform.user.value;
   var pass = registerform.pass.value;
   var pass2 = registerform.pass2.value;
   var email = registerform.email.value;
   var firstname = registerform.firstname.value;
   var lastname = registerform.lastname.value;
   var postData = "user=" + user + "&pass=" + pass + "&pass2=" + pass2 + "&email=" + email + "&firstname=" + firstname + "&lastname=" + lastname + "&subjoin=1";
   var sUrl = "APTest/Membership/processXML.php";
   var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, poetryRegisterCallback, postData);
}

 
///////////////////////////////
// 
// manage profile methods 
//

var handlePoetryManageProfileFailure = function(o) {
   var statusboxEl = document.getElementById("statusbox");
   var failMsg = "Connection failure -- please try again later";
   if (statusboxEl!=null) {
      statusboxEl.innerHTML = failMsg;
   }
}

var handlePoetryManageProfileSuccess = function(o) {
   var statusboxEl = document.getElementById("statusbox");
   var mainboxEl = document.getElementById("mainbox");
   var footerboxEl = document.getElementById("footerbox");
   if (mainboxEl!=null) {
      var root = o.responseXML.documentElement;

      var manageNodes = root.getElementsByTagName("editstatus");
      var manageStatus = manageNodes[0].childNodes[0].nodeValue;

      var usernameNodes = root.getElementsByTagName("username");
      var username = usernameNodes[0].childNodes[0].nodeValue;

      var contentStr = "";
      if (manageStatus!="success") {
         var messageNodes = root.getElementsByTagName("message");
         var message = messageNodes[0].childNodes[0].nodeValue; 
         contentStr = "<b>Error while updating profile:</b><br />" + 
	              message + "<br /><br />";
      } else {
         contentStr = "Profile has been updated.<br />";
      }
      mainboxEl.innerHTML = contentStr;
      statusboxEl.innerHTML = "";              
      displayPoetryFooter(footerboxEl, username);
   }
}

var poetryManageProfileCallback =
{
   success: handlePoetryManageProfileSuccess,
   failure: handlePoetryManageProfileFailure,
   argument: { foo:"foo", bar:"bar" }
};

function sendPoetryManageProfileRequest(manageform) {
   var user = manageform.user.value;
   var newpass = manageform.newpass.value;
   var curpass = manageform.curpass.value;
   var email = manageform.email.value;
   var firstname = manageform.firstname.value;
   var lastname = manageform.lastname.value;
   var email_visible = manageform.emailvisible.checked;
   var descrip = manageform.descrip.value;
   var url = manageform.url.value;
   var postData = "user=" + user + "&newpass=" + newpass + "&curpass=" + curpass + 
                  "&email=" + email + "&firstname=" + firstname + "&lastname=" + lastname + 
		  "&email_visible=" + email_visible + "&descrip=" + descrip + 
		  "&url=" + url + "&submanage=1";
   var sUrl = "APTest/Membership/processXML.php";
   var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, poetryManageProfileCallback, postData);
}

///////////////////////////////
// 
// forgot password methods 
//

var handlePoetryForgotFailure = function(o) {
   var statusboxEl = document.getElementById("statusbox");
   var failMsg = "Connection failure -- please try again later";
   if (statusboxEl!=null) {
      statusboxEl.innerHTML = failMsg;
   }
}

var handlePoetryForgotSuccess = function(o) {
   var statusboxEl = document.getElementById("statusbox");
   var mainboxEl = document.getElementById("mainbox");
   var footerboxEl = document.getElementById("footerbox");
   if (mainboxEl!=null) {
      var root = o.responseXML.documentElement;

      var forgotNodes = root.getElementsByTagName("forgotstatus");
      var forgotStatus = forgotNodes[0].childNodes[0].nodeValue;
     
      var usernameNodes = root.getElementsByTagName("username");
      var username = usernameNodes[0].childNodes[0].nodeValue;

      var contentStr = "";
      if (forgotStatus=="success") {
         contentStr = "<b>Forgot Password?</b><br /><br />" + 
	              "A new password has been generated<br /> " +
		      "and sent to your email address." +
		      "<br /><br />"; 
      } else {
         contentStr = "Error: could not send email"; 
      }
      mainboxEl.innerHTML = contentStr;
      statusboxEl.innerHTML = "";              
      displayPoetryFooter(footerboxEl, null);
   }
}

var poetryForgotCallback =
{
   success: handlePoetryForgotSuccess,
   failure: handlePoetryForgotFailure,
   argument: { foo:"foo", bar:"bar" }
};

function sendPoetryForgotRequest(forgotform) {
   var user = forgotform.user.value;
   var postData = "user=" + user + "&subforgot=1";
   var sUrl = "APTest/Membership/processXML.php";
   var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, poetryForgotCallback, postData);
}
 
///////////////////////////////
// 
// write poem methods 
//

var handlePoetryWriteFailure = function(o) {
   var statusEl = document.getElementById("statusbox");
   var failMsg = "Connection failure -- please try again later";
   if (statusEl!=null) {
      statusEl.innerHTML = failMsg;
   }
}

var handlePoetryWriteSuccess = function(o) {
   var statusEl = document.getElementById("statusbox");
   var mainboxEl = document.getElementById("mainbox");
   var footerboxEl = document.getElementById("footerbox");
   if (mainboxEl!=null) {
      var root = o.responseXML.documentElement;

      var writeNodes = root.getElementsByTagName("writestatus");
      var writeStatus = writeNodes[0].childNodes[0].nodeValue;
      
      var usernameNodes = root.getElementsByTagName("username");
      var username = usernameNodes[0].childNodes[0].nodeValue;

      var contentStr = "";
      if (writeStatus=="success") {
         var poemAdded = 0;
         var ratingAdded = 0;
         var poemNodes = root.getElementsByTagName("poemadded");
         var ratingNodes = root.getElementsByTagName("ratingadded");
	 if ((poemNodes!=null) && (poemNodes[0]!=null)) {
	    poemAdded = 1;
	 }
	 if ((ratingNodes!=null) && (ratingNodes[0]!=null)) {
	    ratingAdded = 1;
	 }

         if (poemAdded) {
            contentStr = "<b>Thank you.</b><br /><br />" +
	   	         "Your contribution will be reviewed and<br />" +
		         "will appear on the site shortly." + 
		         "<br /><br /><a href=ActionPoetryHome>" + 
		         "Return to Action Poetry</a>";
         } else if (ratingAdded) {
            contentStr = "<b>Thank you.</b>" +
		         "<br /><br /><a href=ActionPoetryHome>" + 
		         "Return to Action Poetry</a>";
	 } else {
            contentStr = "<a href=ActionPoetryHome>" + 
		         "Return to Action Poetry</a>";
	 }
      } else {
         contentStr = "<b>" + 
                      "Error: could not save to database<br /> (" + 
		      writeStatus + ")" +
                      "</b>";
      }
      mainboxEl.innerHTML = contentStr;
      displayPoetryFooter(footerboxEl, username);
   }
}

var poetryWriteCallback =
{
   success: handlePoetryWriteSuccess,
   failure: handlePoetryWriteFailure,
   argument: { foo:"foo", bar:"bar" }
};

function sendPoetryWriteRequest(poemform) {
   var poemRaw = poemform.poem.value;
   var titleRaw = poemform.title.value;
   var poem = cleanISOCrap(poemRaw);
   var title = cleanISOCrap(titleRaw);
   var poemrating = getCheckedValue(poemform.poemrating);
   if ((poemrating!=1) && (poemrating!=2)) {
      poemrating = 0;
   }
   var responseto = poemform.responseto.value;
   if ((responseto==null) || (responseto=="none")) {
      responseto = 0;
   }
   var postData = null;
   if ((poem!=null) && (title!=null) && 
       (poemrating!=null) && (responseto!=null)) {
      postData = "title=" + title + 
                 "&poem=" + poem + 
                 "&rating=" + poemrating + 
		 "&responseto=" + responseto +
		 "&subpoem=1";
   } else if ((poem!=null) && (title!=null)) {
      postData = "title=" + title + 
                 "&poem=" + poem + 
		 "&subpoem=1";
   } else if ((poemrating!=null) && (responseto!=null)) {
      postData =  "rating=" + poemrating + 
                  "&responseto=" + responseto +
                  "&subpoem=1";
   }
   if (postData!=null) {
      var sUrl = "APTest/Membership/processXML.php";
      var request = YAHOO.util.Connect.asyncRequest('POST', sUrl, poetryWriteCallback, postData);
   }
}

// 
// END of actionpoetry.js 
//
///////////////////////////////////
//
