<?php 
session_start();
require_once('contactform/inc/contactform.config.php');
require_once('contactform/class/class.contactform.php');

$contactform_obj = new contactForm($cfg);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="https://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Mitgliedsantrag HSV wiengolf</title>

<link rel="stylesheet" type="text/css" href="contactform/css/contactform.css"/>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

<script src="contactform/js/contactform.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/0.9.0/jquery.mask.min.js"></script>

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.17/themes/smoothness/jquery-ui.css">

<script>
$(function(){$( "#element-6" ).datepicker({firstDay: 1, changeMonth: true, changeYear: true, dateFormat: "dd.mm.yy", maxDate: "+1Y", yearRange: "1920:2025", monthNames: [ "Januar","Februar","März","April","Mai","Juni","Juli","August","September","Oktober","November","Dezember" ], monthNamesShort: [ "Jan","Feb","Mär","Apr","Mai","Jun",	"Jul","Aug","Sep","Okt","Nov","Dez" ],	dayNames: [ "Sonntag","Montag","Dienstag","Mittwoch","Donnerstag","Freitag","Samstag" ],	dayNamesShort: [ "So","Mo","Di","Mi","Do","Fr","Sa" ],	dayNamesMin: [ "So","Mo","Di","Mi","Do","Fr","Sa" ] });
});

$(function(){$( "#element-26" ).datepicker({firstDay: 1, changeMonth: true, changeYear: true, dateFormat: "dd.mm.yy", maxDate: "+1Y", yearRange: "1920:2025", monthNames: [ "Januar","Februar","März","April","Mai","Juni","Juli","August","September","Oktober","November","Dezember" ], monthNamesShort: [ "Jan","Feb","Mär","Apr","Mai","Jun",	"Jul","Aug","Sep","Okt","Nov","Dez" ],	dayNames: [ "Sonntag","Montag","Dienstag","Mittwoch","Donnerstag","Freitag","Samstag" ],	dayNamesShort: [ "So","Mo","Di","Mi","Do","Fr","Sa" ],	dayNamesMin: [ "So","Mo","Di","Mi","Do","Fr","Sa" ] });
});

$(function() {$( "#element-20" ).mask('SS00 0000 0000 0000 0000 00', {placeholder: '____ ____ ____ ____ ____ __'});
});
$(function() {$( "#element-6" ).mask('00.00.0000', {placeholder: '__.__.____'});
});
$(function() {$( "#element-26" ).mask('00.00.0000', {placeholder: '__.__.____'});
});
$(function() {$( "#element-12" ).mask('+000000000000000000');
});
$(function() {$( "#element-31" ).mask('0000 000000 0000', {placeholder: '____ ______ ____'});
});
$(function() {$( "#element-32" ).mask('00/00', {placeholder: '__/__'});
});
</script>
  <script type="text/javascript">
  function showfield(name){
    if(name=='3')document.getElementById('div1').style.display="block";
    else document.getElementById('div1').style.display="none";
  }
 
  function showfield2(name){
    if(name=='1' || name=='2')document.getElementById('div2').style.display="block";
    else document.getElementById('div2').style.display="none";
    if(name=='1' || name=='2')document.getElementById('div3').style.display="block";
    else document.getElementById('div3').style.display="none";
	
    if(name=='5')document.getElementById('div4').style.display="block"; 
    else if(name=='6')document.getElementById('div4').style.display="block";
    else document.getElementById('div4').style.display="none";
  }
 
 function hidefield() {
 document.getElementById('div1').style.display='none';
 document.getElementById('div4').style.display='none';
 }
  </script>
</head>
<body onload="hidefield()">

<div id="contactform">

<div id="contactform-content">

<div class="element">
	<div class="option-container">
	<span class="title  " style="color:#ea1c2f;font-family:Arial;font-size:1.9em;font-weight:bold;">Mitgliedsantrag HSV wiengolf</span><img src="hsv-golf-logo.png" alt="logo" width="63" height="69" align="absbottom" /></div>
</div>


<div class="element">
	<div class="option-container">
	  <div class="paragraph  " name="element-29" id="element-29" style="color:#000000;font-family:Verdana;font-size:0.8em;font-weight:normal;">
	    <div align="justify"><strong>Bitte füllen Sie das nachfolgende Formular vollständig aus. Sie erhalten in Folge den vorausgefüllten Mitgliedsantrag als PDF an die von Ihnen angegebene E-Mail-Adresse. Übermitteln Sie uns dann bitte den unterfertigten Mitgliedsantrag und das SEPA-Lastschrift-Mandat sowie alle nötigen Beitrittsunterlagen per E-Mail an <a href="mailto:sl.golf@hsv-wien.at">sl.golf@hsv-wien.at</a> oder per Post an das HSV Sekretariat, In den Gabrissen 91, 1210 Wien.</strong><br>
	      <br>
	      </div>
      </div></div>
</div>

<div class="element">
	<label id="label-element-1" class="label" style="color:#ea1c2f;font-family:Trebuchet MS;font-size:1.2em;font-weight:normal;">
	<span class="labelelementvalue">Persönliche Daten</span>
	<span class="required"></span></label>
    </div>
<div class="element">
<table width="300" border="1" cellspacing="1" cellpadding="1">
  <tr>
    <td>    
<div class="element">

	<label id="label-element-30" class="label" style="color:#ea1c2f;font-family:Trebuchet MS;font-size:1.0em;font-weight:normal;">
	<span class="labelelementvalue">Titel</span>
	<span class="required"></span></label>

	<div class="errormessage" id="errormessage-element-30"></div>

	<div class="option-container">
	<input class="af-inputtext af-formvalue  " name="element-30" id="element-30" value="" style="color:#000000;font-family:Verdana;font-size:0.8em;font-weight:normal;width:260px;border-style:solid; border-color:#dcdcdc;-moz-border-radius:5px;-khtml-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;border-width:1px;padding:5px;" type="text"></div>
	<input style="display:none" value="30" checked="" name="requiredelement[]" id="requiredelement-30" type="checkbox">
</div>

<div class="element">

	<label id="label-element-3" class="label" style="color:#ea1c2f;font-family:Trebuchet MS;font-size:1.0em;font-weight:normal;">
	<span class="labelelementvalue">Vorname</span>
	<span class="required"></span></label>

	<div class="errormessage" id="errormessage-element-3"></div>

	<div class="option-container">
	<input class="af-inputtext af-formvalue  " name="element-3" id="element-3" value="" style="color:#000000;font-family:Verdana;font-size:0.8em;font-weight:normal;width:260px;border-style:solid; border-color:#dcdcdc;-moz-border-radius:5px;-khtml-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;border-width:1px;padding:5px;" type="text"></div>
	<input style="display:none" value="3" checked="" name="requiredelement[]" id="requiredelement-3" type="checkbox">
</div>

<div class="element">

	<label id="label-element-4" class="label" style="color:#ea1c2f;font-family:Trebuchet MS;font-size:1.0em;font-weight:normal;">
	<span class="labelelementvalue">Nachname</span>
	<span class="required"></span></label>

	<div class="errormessage" id="errormessage-element-4"></div>

	<div class="option-container">
	<input class="af-inputtext af-formvalue  " name="element-4" id="element-4" value="" style="color:#000000;font-family:Verdana;font-size:0.8em;font-weight:normal;width:260px;border-style:solid; border-color:#dcdcdc;-moz-border-radius:5px;-khtml-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;border-width:1px;padding:5px;" type="text"></div>
	<input style="display:none" value="4" checked="" name="requiredelement[]" id="requiredelement-4" type="checkbox">
</div>

<div class="element">

	<label id="label-element-5" class="label" style="color:#ea1c2f;font-family:Trebuchet MS;font-size:1.0em;font-weight:normal;">
	<span class="labelelementvalue">Geschlecht </span>
    <span class="required"></span></label>

	<div class="errormessage" id="errormessage-element-5"></div>

	<div class="option-container">
	      <select class="af-select af-formvalue  " name="element-5" id="element-5" style="color:#000000;font-family:Verdana;font-size:0.8em;font-weight:normal;width:272px;border-style:solid; border-color:#dcdcdc;-moz-border-radius:5px;-khtml-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;border-width:1px;padding:5px;" >
	      <option value="männlich" selected="selected">männlich</option>
	      <option value="weiblich">weiblich</option>
        </select>
</div>
    <input style="display:none" value="5" checked="" name="requiredelement[]" id="requiredelement-5" type="checkbox">
</div>

<div class="element">

	<label id="label-element-6" class="label" style="color:#ea1c2f;font-family:Trebuchet MS;font-size:1.0em;font-weight:normal;">
	<span class="labelelementvalue">Geburtsdatum </span><span class="required"></span></label>

	<div class="errormessage" id="errormessage-element-6"></div>

	<div class="option-container">
	<input class="af-inputtext af-formvalue  " name="element-6" id="element-6" placeholder="tt.mm.jjjj" value="" style="color:#000000;font-family:Verdana;font-size:0.8em;font-weight:normal;width:260px;border-style:solid; border-color:#dcdcdc;-moz-border-radius:5px;-khtml-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;border-width:1px;padding:5px;" type="text"></div>
    <input style="display:none" value="6" checked="" name="requiredelement[]" id="requiredelement-6" type="checkbox">
</div>

<div class="element">

	<label id="label-element-7" class="label" style="color:#ea1c2f;font-family:Trebuchet MS;font-size:1.0em;font-weight:normal;">
	<span class="labelelementvalue">Staatsbürgerschaft </span><span class="required"></span></label>

	<div class="errormessage" id="errormessage-element-7"></div>

	<div class="option-container">
	<input class="af-inputtext af-formvalue  " name="element-7" id="element-7" value="" style="color:#000000;font-family:Verdana;font-size:0.8em;font-weight:normal;width:260px;border-style:solid; border-color:#dcdcdc;-moz-border-radius:5px;-khtml-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;border-width:1px;padding:5px;" type="text"></div>
    <input style="display:none" value="7" checked="" name="requiredelement[]" id="requiredelement-7" type="checkbox">
</div>

<div class="element">

	<label id="label-element-8" class="label" style="color:#ea1c2f;font-family:Trebuchet MS;font-size:1.0em;font-weight:normal;">
	<span class="labelelementvalue">Adresse </span><span class="required"></span></label>

	<div class="errormessage" id="errormessage-element-8"></div>

	<div class="option-container">
	<input class="af-inputtext af-formvalue  " name="element-8" id="element-8" value="" style="color:#000000;font-family:Verdana;font-size:0.8em;font-weight:normal;width:260px;border-style:solid; border-color:#dcdcdc;-moz-border-radius:5px;-khtml-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;border-width:1px;padding:5px;" type="text"></div>
    <input style="display:none" value="8" checked="" name="requiredelement[]" id="requiredelement-8" type="checkbox">
</div>

<div class="element">

	<label id="label-element-9" class="label" style="color:#ea1c2f;font-family:Trebuchet MS;font-size:1.0em;font-weight:normal;">
	<span class="labelelementvalue">Postleitzahl </span><span class="required"></span></label>

	<div class="errormessage" id="errormessage-element-9"></div>

	<div class="option-container">
	<input class="af-inputtext af-formvalue  " name="element-9" id="element-9" value="" style="color:#000000;font-family:Verdana;font-size:0.8em;font-weight:normal;width:260px;border-style:solid; border-color:#dcdcdc;-moz-border-radius:5px;-khtml-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;border-width:1px;padding:5px;" type="text"></div>
    <input style="display:none" value="9" checked="" name="requiredelement[]" id="requiredelement-9" type="checkbox">
</div>

<div class="element">

	<label id="label-element-10" class="label" style="color:#ea1c2f;font-family:Trebuchet MS;font-size:1.0em;font-weight:normal;">
	<span class="labelelementvalue">Ort </span><span class="required"></span></label>

	<div class="errormessage" id="errormessage-element-10"></div>

	<div class="option-container">
	<input class="af-inputtext af-formvalue  " name="element-10" id="element-10" value="" style="color:#000000;font-family:Verdana;font-size:0.8em;font-weight:normal;width:260px;border-style:solid; border-color:#dcdcdc;-moz-border-radius:5px;-khtml-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;border-width:1px;padding:5px;" type="text"></div>
    <input style="display:none" value="10" checked="" name="requiredelement[]" id="requiredelement-10" type="checkbox">
</div>

<div class="element">

	<label id="label-element-11" class="label" style="color:#ea1c2f;font-family:Trebuchet MS;font-size:1.0em;font-weight:normal;">
	<span class="labelelementvalue">Land </span><span class="required"></span></label>

	<div class="errormessage" id="errormessage-element-11"></div>

	<div class="option-container">
	<input class="af-inputtext af-formvalue  " name="element-11" id="element-11" value="" style="color:#000000;font-family:Verdana;font-size:0.8em;font-weight:normal;width:260px;border-style:solid; border-color:#dcdcdc;-moz-border-radius:5px;-khtml-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;border-width:1px;padding:5px;" type="text"></div>
    <input style="display:none" value="11" checked="" name="requiredelement[]" id="requiredelement-11" type="checkbox">
</div>



<div class="element">

	<label id="label-element-12" class="label" style="color:#ea1c2f;font-family:Trebuchet MS;font-size:1.0em;font-weight:normal;">
	<span class="labelelementvalue">Telefon </span><span class="required"></span></label>

	<div class="errormessage" id="errormessage-element-12"></div>

	<div class="option-container">
	<input class="af-inputtext af-formvalue  " name="element-12" id="element-12" placeholder="+43 xxx xx xx" value="" style="color:#000000;font-family:Verdana;font-size:0.8em;font-weight:normal;width:260px;border-style:solid; border-color:#dcdcdc;-moz-border-radius:5px;-khtml-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;border-width:1px;padding:5px;" type="text"></div>
    <input style="display:none" value="12" checked="" name="requiredelement[]" id="requiredelement-12" type="checkbox">
</div>

<div class="element">

	<label id="label-element-13" class="label" style="color:#ea1c2f;font-family:Trebuchet MS;font-size:1.0em;font-weight:normal;">
	<span class="labelelementvalue">E-Mail</span>
	<span class="required"></span></label>

	<div class="errormessage" id="errormessage-element-13"></div>

	<div class="option-container">
	<input class="af-inputtext af-email af-formvalue  " name="element-13" id="element-13"  placeholder="email@beispiel.at" value="" style="color:#000000;font-family:Verdana;font-size:0.8em;font-weight:normal;width:260px;border-style:solid; border-color:#dcdcdc;-moz-border-radius:5px;-khtml-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;border-width:1px;padding:5px;" type="text"></div>
	<input name="form_emailnotificationinputid" id="form_emailnotificationinputid" value="element-3" style="display:none" type="hidden">
	<input name="form_emailnotificationinputid" id="form_emailnotificationinputid" value="element-3" style="display:none" type="hidden">
	<input checked="" style="display:none" value="13" name="emailrequiredelement[]" id="emailrequiredelement-13" type="checkbox">
</div>
&nbsp;</td>
  </tr>
</table>
</div>
<div class="element">
	<label id="label-element-14" class="label" style="color:#ea1c2f;font-family:Trebuchet MS;font-size:1.2em;font-weight:normal;">
	<span class="labelelementvalue">Mitgliedschaft </span><span class="required"></span></label>
	</div>
 <div class="element">
   <table width="300" border="1" cellspacing="1" cellpadding="1">
  <tr>
    <td> 
    <div class="element">  
	<label id="label-element-34" class="label" style="color:#ea1c2f;font-family:Trebuchet MS;font-size:1.0em;font-weight:normal;">
	<span class="labelelementvalue">Ab dem Jahr </span><span class="required"></span></label>

	<div class="errormessage" id="errormessage-element-34"></div>

	<div class="option-container">
	    <select class="af-select af-formvalue  " name="element-34" id="element-34" style="color:#000000;font-family:Verdana;font-size:0.8em;font-weight:normal;width:272px;border-style:solid; border-color:#dcdcdc;-moz-border-radius:5px;-khtml-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;border-width:1px;padding:5px;" >
	      <option value="1" selected="selected">2020</option>
	      <option value="2">2021</option>
	      <option value="3">2022</option>
        </select>

	</div>
    <input style="display:none" value="34" checked="" name="requiredelement[]" id="requiredelement-34" type="checkbox">
</div>
      
  <div class="element">  
	<label id="label-element-15" class="label" style="color:#ea1c2f;font-family:Trebuchet MS;font-size:1.0em;font-weight:normal;">
	<span class="labelelementvalue">Typ </span><span class="required"></span></label>

	<div class="errormessage" id="errormessage-element-15"></div>

	<div class="option-container">
	    <select class="af-select af-formvalue  " name="element-15" id="element-15" onchange="showfield2(this.options[this.selectedIndex].value)" style="color:#000000;font-family:Verdana;font-size:0.8em;font-weight:normal;width:272px;border-style:solid; border-color:#dcdcdc;-moz-border-radius:5px;-khtml-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;border-width:1px;padding:5px;" >
	      <option value="1" selected="selected">Diners Standard: EUR 179,- *</option>
	      <option value="2">Diners Standard mit Extra Golf VIP-Card: EUR 199,- *</option>
        </select>

	</div>
    <input style="display:none" value="15" checked="" name="requiredelement[]" id="requiredelement-15" type="checkbox">
</div>

<div class="element">
<div id="div2">
	<label id="label-element-31" class="label" style="color:#ea1c2f;font-family:Trebuchet MS;font-size:1.0em;font-weight:normal;">
	<span class="labelelementvalue">Kartennummer </span><span class="required"></span></label>

	<div class="errormessage" id="errormessage-element-31"></div>

	<div class="option-container">
	<input class="af-inputtext af-formvalue  " name="element-31" id="element-31" placeholder="____ ______ ____" value="" style="color:#000000;font-family:Verdana;font-size:0.8em;font-weight:normal;width:260px;border-style:solid; border-color:#dcdcdc;-moz-border-radius:5px;-khtml-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;border-width:1px;padding:5px;" type="text"></div>
    <input style="display:none" value="31" checked="" name="requiredelement[]" id="requiredelement-31" type="checkbox">
</div>
</div>
<div class="element">
<div id="div3">
	<label id="label-element-32" class="label" style="color:#ea1c2f;font-family:Trebuchet MS;font-size:1.0em;font-weight:normal;">
	<span class="labelelementvalue">Gültig bis </span><span class="required"></span></label>

	<div class="errormessage" id="errormessage-element-32"></div>

	<div class="option-container">
	<input class="af-inputtext af-formvalue  " name="element-32" id="element-32" placeholder="__/__" value="" style="color:#000000;font-family:Verdana;font-size:0.8em;font-weight:normal;width:260px;border-style:solid; border-color:#dcdcdc;-moz-border-radius:5px;-khtml-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;border-width:1px;padding:5px;" type="text"></div>
    <input style="display:none" value="32" checked="" name="requiredelement[]" id="requiredelement-32" type="checkbox">
</div>
</div>
<div class="element">
<div id="div4">
	<label id="label-element-33" class="label" style="color:#ea1c2f;font-family:Trebuchet MS;font-size:1.0em;font-weight:normal;">
	<span class="labelelementvalue">Drei Kundennumer </span><span class="required"></span></label>

	<div class="errormessage" id="errormessage-element-33"></div>

	<div class="option-container">
	<input class="af-inputtext af-formvalue  " name="element-33" id="element-33" placeholder="" value="" style="color:#000000;font-family:Verdana;font-size:0.8em;font-weight:normal;width:260px;border-style:solid; border-color:#dcdcdc;-moz-border-radius:5px;-khtml-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;border-width:1px;padding:5px;" type="text"></div>
    <input style="display:none" value="33" checked="" name="requiredelement[]" id="requiredelement-33" type="checkbox">
</div>
</div>
<div class="element">

    	<label id="label-element-16" class="label" style="color:#ea1c2f;font-family:Trebuchet MS;font-size:1.0em;font-weight:normal;">
	<span class="labelelementvalue">Ich bin... </span><span class="required"></span></label>
    	<div class="errormessage" id="errormessage-element-16"></div>
        	<div class="option-container">
  <select class="af-select af-formvalue  " name="element-16" id="element-16" onchange="showfield(this.options[this.selectedIndex].value)" style="color:#000000;font-family:Verdana;font-size:0.8em;font-weight:normal;width:272px;border-style:solid; border-color:#dcdcdc;-moz-border-radius:5px;-khtml-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;border-width:1px;padding:5px;" >
  <option value="1" selected="selected">...Golfer mit Platzerlaubnis (PE= -54)</option>
  <option value="2">...Golfer mit Turniererlaubnis (TE -45)</option>
  <option value="3">...Golfer mit Clubvorgabe/Stammvorgabe</option>

  </select>
</div> 
    <input style="display:none" value="16" checked="" name="requiredelement[]" id="requiredelement-16" type="checkbox">
</div>


<div class="element">
<div id="div1">
	<label id="label-element-17" class="label" style="color:#ea1c2f;font-family:Trebuchet MS;font-size:1.0em;font-weight:normal;">
	<span class="labelelementvalue">HCP (optional)</span><span class="required"></span></label>
    
	<div class="errormessage" id="errormessage-element-17"></div>
    
<div class="option-container">
	<input class="af-inputtext af-formvalue  " name="element-17" id="element-17" value="" style="color:#000000;font-family:Verdana;font-size:0.8em;font-weight:normal;width:260px;border-style:solid; border-color:#dcdcdc;-moz-border-radius:5px;-khtml-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;border-width:1px;padding:5px;text-transform: uppercase;" type="text"></div>
   
    <input style="display:none" value="17" checked="" name="requiredelement[]" id="requiredelement-17" type="checkbox">
</div>
</div>
<div class="element">

	<label id="label-element-18" class="label" style="color:#000000;font-family:Trebuchet MS;font-size:0.6em;font-weight:normal;">
	<span class="labelelementvalue">* ab dem vollendenten 21. Lebensjahr zzgl. ÖGV-Abgaben und Spesen von insgesamt EUR 50,-</span>
	<span class="required"></span></label>
</div>

</td>
  </tr>
</table>
	</div>
<div class="element">

	<label id="label-element-18" class="label" style="color:#ea1c2f;font-family:Trebuchet MS;font-size:1.2em;font-weight:normal;">
	<span class="labelelementvalue">SEPA Informationen</span>
	<span class="required"></span></label>
</div>
<div class="element">
 <table width="300" border="1" cellspacing="1" cellpadding="1">
  <tr>
    <td>   
   
   <div class="element">

	<label id="label-element-20" class="label" style="color:#ea1c2f;font-family:Trebuchet MS;font-size:1.0em;font-weight:normal;">
	<span class="labelelementvalue">IBAN</span></label>

	<div class="errormessage" id="errormessage-element-20"></div>


	<div class="option-container">
	<input class="af-inputtext af-formvalue  " name="element-20" id="element-20" placeholder="AT__ ____ ____ ____ ____ __" style="color:#000000;font-family:Verdana;font-size:0.8em;font-weight:normal;width:260px;border-style:solid; border-color:#dcdcdc;-moz-border-radius:5px;-khtml-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;border-width:1px;padding:5px;text-transform: uppercase;" type="text"></div>
</div>
   <div class="element">

	<label id="label-element-21" class="label" style="color:#ea1c2f;font-family:Trebuchet MS;font-size:1.0em;font-weight:normal;">
	<span class="labelelementvalue">BIC</span></label>

	<div class="errormessage" id="errormessage-element-21"></div>



	<div class="option-container">
	<input name="element-21" type="text" class="af-inputtext af-formvalue  " id="element-21" style="color:#000000;font-family:Verdana;font-size:0.8em;font-weight:normal;width:260px;border-style:solid; border-color:#dcdcdc;-moz-border-radius:5px;-khtml-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;border-width:1px;padding:5px;text-transform: uppercase;" value="" maxlength="11"></div>
</div>

&nbsp;</td>
  </tr>
</table>
</div>

<div class="element">
	<label id="label-element-22" class="label" style="color:#ea1c2f;font-family:Trebuchet MS;font-size:1.2em;font-weight:normal;">
	<span class="labelelementvalue">Lichtbildausweis Informationen</span><span class="required"></span></label>
    	</div>
<div class="element">
 <table width="300" border="1" cellspacing="1" cellpadding="1">
  <tr>
    <td>          
   <div class="element"> 
	<label id="label-element-23" class="label" style="color:#ea1c2f;font-family:Trebuchet MS;font-size:1.0em;font-weight:normal;">
	<span class="labelelementvalue">Typ</span><span class="required"></span></label>

	<div class="errormessage" id="errormessage-element-23"></div>

	<div class="option-container">
	    <select class="af-select af-formvalue  " name="element-23" id="element-23" style="color:#000000;font-family:Verdana;font-size:0.8em;font-weight:normal;width:272px;border-style:solid; border-color:#dcdcdc;-moz-border-radius:5px;-khtml-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;border-width:1px;padding:5px;" >
	      <option value="Führerschein" selected="selected">Führerschein</option>
	      <option value="Reisepass">Reisepass</option>
	      <option value="Personalausweis">Personalausweis</option>
	      <option value="Identitätsausweis">Identitätsausweis</option>
	      <option value="Waffenpass">Waffenpass</option>
	      <option value="Amtlicher Dienstausweis">Amtlicher Dienstausweis</option>
        </select>

	</div>
    <input style="display:none" value="23" checked="" name="requiredelement[]" id="requiredelement-23" type="checkbox">
</div>

<div class="element">

	<label id="label-element-24" class="label" style="color:#ea1c2f;font-family:Trebuchet MS;font-size:1.0em;font-weight:normal;">
	<span class="labelelementvalue">Ausstellende Behörde </span><span class="required"></span></label>

	<div class="errormessage" id="errormessage-element-24"></div>

	<div class="option-container">
	<input class="af-inputtext af-formvalue  " name="element-24" id="element-24" value="" style="color:#000000;font-family:Verdana;font-size:0.8em;font-weight:normal;width:260px;border-style:solid; border-color:#dcdcdc;-moz-border-radius:5px;-khtml-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;border-width:1px;padding:5px;" type="text"></div>
    <input style="display:none" value="24" checked="" name="requiredelement[]" id="requiredelement-24" type="checkbox">
</div>

<div class="element">

	<label id="label-element-25" class="label" style="color:#ea1c2f;font-family:Trebuchet MS;font-size:1.0em;font-weight:normal;">
	<span class="labelelementvalue">Ausweis Nummer </span><span class="required"></span></label>

	<div class="errormessage" id="errormessage-element-25"></div>

	<div class="option-container">
	<input class="af-inputtext af-formvalue  " name="element-25" id="element-25" value="" style="color:#000000;font-family:Verdana;font-size:0.8em;font-weight:normal;width:260px;border-style:solid; border-color:#dcdcdc;-moz-border-radius:5px;-khtml-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;border-width:1px;padding:5px;" type="text"></div>
    <input style="display:none" value="25" checked="" name="requiredelement[]" id="requiredelement-25" type="checkbox">
</div>

<div class="element">

	<label id="label-element-26" class="label" style="color:#ea1c2f;font-family:Trebuchet MS;font-size:1.0em;font-weight:normal;">
	<span class="labelelementvalue">Ausstellungsdatum </span><span class="required"></span></label>

	<div class="errormessage" id="errormessage-element-26"></div>

	<div class="option-container">
	<input class="af-inputtext af-formvalue  " name="element-26" id="element-26" placeholder="tt.mm.jjjj" value="" style="color:#000000;font-family:Verdana;font-size:0.8em;font-weight:normal;width:260px;border-style:solid; border-color:#dcdcdc;-moz-border-radius:5px;-khtml-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;border-width:1px;padding:5px;" type="text"></div>
    <input style="display:none" value="26" checked="" name="requiredelement[]" id="requiredelement-26" type="checkbox">
</div>
&nbsp;</td>
  </tr>
</table>
</div>
<div class="element">

	<label id="label-element-27" class="label" style="color:#ea1c2f;font-family:Trebuchet MS;font-size:1.2em;font-weight:normal;">
	<span class="labelelementvalue">Anmerkung</span></label>

	<div class="errormessage" id="errormessage-element-27"></div>

	<div class="option-container">
	<textarea class="af-textarea af-formvalue  " name="element-27" id="element-27" style="color:#000000;font-family:Verdana;font-size:0.8em;font-weight:normal;width:287px;border-style:solid; border-color:#dcdcdc;-moz-border-radius:5px;-khtml-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;border-width:1px;padding:5px;" rows="6"></textarea></div>
</div>





<div class="element">
	<div class="option-container">
	<input name="element-28" id="element-28" value="Formular abschicken" class="submit  " style="color:#555555;font-family:Arial;font-size:1.3em;font-weight:bold;background-color:#f1f1f1;border:1px solid #cccccc;width:230px;; " type="submit"></div></div>
	<div id="validation">Validierung wird durchgeführt</div>

<?php
unset($_SESSION['checkform'])
?>

</div><!--contactform-content-->

</div><!--contactform-->

</body>


</html>