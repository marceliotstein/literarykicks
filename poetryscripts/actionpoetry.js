//
// actionpoetry.js -- AJAX responders for LitKicks Action Poetry
//
// Levi Asher December 2007
//
// requires Yahoo YUI
//

function showPoetryExplanation() {
   var poemEl = document.getElementById("poetry");
   if (poemEl!=null) {
      poemEl.innerHTML = "<br />Please click the button above to read a randomly selected poem.  Each time you click another poem will be selected.<br /><br />";
   }
}

var handlePoetryFailure = function(o) {
   var poemEl = document.getElementById("poem");
   var failMsg = "Connection failure -- please try again later";
   if (poemEl!=null) {
      poemEl.innerHTML = failMsg;
   }
}

var poetryCallback =
{
   success: handlePoetrySuccess,
   failure: handlePoetryFailure,
   argument: { foo:"foo", bar:"bar" }
};

var handlePoetryRelatedSuccess = function(o) {
   var poemEl = document.getElementById("poetry2");
   if (poemEl!=null) {
      var root = o.responseXML.documentElement;

      var relatedPoemBlob = "";
      var relatedPoemNodes = root.getElementsByTagName("relatedpoemblob");
      var i = 0;
      if ((relatedPoemNodes[i]!=null) && (relatedPoemNodes[i].childNodes[0]!=null)) { 
         relatedPoemBlobIn = relatedPoemNodes[i].childNodes[0].nodeValue;  
         relatedPoemBlob = relatedPoemBlobIn.replace(/[^\x00-\x80]/g,"");
      }

      var contentStr = "";
      if (relatedPoemBlob.indexOf("by")>0) {
         contentStr = "<br /><font color=#666666><center>Responses:</font></center>" + relatedPoemBlob + "<br /><br />"; 
      }
      poemEl.innerHTML = contentStr;
   }
}

var poetryRelatedCallback =
{
   success: handlePoetryRelatedSuccess,
   failure: handlePoetryFailure,
   argument: { foo:"foo", bar:"bar" }
};

var handlePoetrySuccess = function(o) {
   var poemEl = document.getElementById("poetry");
   if (poemEl!=null) {
      var root = o.responseXML.documentElement;

      var titleNodes = root.getElementsByTagName("title");
      var poemTitle = titleNodes[0].childNodes[0].nodeValue;

      var authorNodes = root.getElementsByTagName("author");
      var poemAuthor = authorNodes[0].childNodes[0].nodeValue;

      var dateNodes = root.getElementsByTagName("date");
      var poemDate = dateNodes[0].childNodes[0].nodeValue;

      var bodyNodes = root.getElementsByTagName("body");
      var poemBodyRaw = bodyNodes[0].childNodes[0].nodeValue;
      var poemBody = poemBodyRaw.replace(/[^\x00-\x80]/g,"");

      var msgIDNodes = root.getElementsByTagName("poem_id");
      var poemMsgID = msgIDNodes[0].childNodes[0].nodeValue;

      var contentStr = "";
      var poemLink = "<a href=\"http://www.litkicks.com/ActionPoem?poem=" + 
                     poemMsgID + "\">(link)</a>";
      contentStr = "<center><table width=\"57%\"><tr>" +
                   "<td align=left><br /><b>" + 
                   poemTitle + "</b><br />" + 
                   poemLink + "<br />" + 
                   "<i>by " + poemAuthor + "</i><br /> " + 
                   poemDate + "<br /><br />" +
                   poemBody + "</td></tr></table>";
      poemEl.innerHTML = contentStr;
      
      // now get all related poems 

      var poemUrl2 = "http://www.litkicks.com/poemXML.php?root=" + poemMsgID;
      //alert(poemUrl2);
      var request = YAHOO.util.Connect.asyncRequest('GET', poemUrl2, poetryRelatedCallback);
   }
}

var poetryCallback =
{
   success: handlePoetrySuccess,
   failure: handlePoetryFailure,
   argument: { foo:"foo", bar:"bar" }
};

function sendPoetryRequest() {
   var sUrl = "http://www.litkicks.com/poemXML.php";
   var rander = (Math.random() * 10000) / 1.0;
   var randUrl = sUrl + "?r=" + rander;
   //alert(randUrl);
   var request = YAHOO.util.Connect.asyncRequest('GET', randUrl, poetryCallback);
}

function sendPoetryRequest2008() {
   var sUrl = "http://www.litkicks.com/poemXML.php";
   var rander = (Math.random() * 10000) / 1.0;
   var randUrl = sUrl + "?year=2008&r=" + rander;
   //alert(randUrl);
   var request = YAHOO.util.Connect.asyncRequest('GET', randUrl, poetryCallback);
}

function sendPoetryRequest2009() {
   var sUrl = "http://www.litkicks.com/poemXML.php";
   var rander = (Math.random() * 10000) / 1.0;
   var randUrl = sUrl + "?year=2009&r=" + rander;
   //alert(randUrl);
   var request = YAHOO.util.Connect.asyncRequest('GET', randUrl, poetryCallback);
}

function sendPoetryRequest2010() {
   var sUrl = "http://www.litkicks.com/poemXML.php";
   var rander = (Math.random() * 10000) / 1.0;
   var randUrl = sUrl + "?year=2010&r=" + rander;
   //alert(randUrl);
   var request = YAHOO.util.Connect.asyncRequest('GET', randUrl, poetryCallback);
}

