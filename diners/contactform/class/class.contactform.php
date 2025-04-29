<?php
require_once('class.fpdf.php');
require_once('class.phpmailer.php');

class FPDF_CellFit extends FPDF {

    //Cell with horizontal scaling if text is too wide
    function CellFit($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $scale=false, $force=true)
    {
        //Get string width
        $str_width=$this->GetStringWidth($txt);

        //Calculate ratio to fit cell
        if($w==0)
            $w = $this->w-$this->rMargin-$this->x;
        $ratio = ($w-$this->cMargin*2)/$str_width;

        $fit = ($ratio < 1 || ($ratio > 1 && $force));
        if ($fit)
        {
            if ($scale)
            {
                //Calculate horizontal scaling
                $horiz_scale=$ratio*100.0;
                //Set horizontal scaling
                $this->_out(sprintf('BT %.2F Tz ET',$horiz_scale));
            }
            else
            {
                //Calculate character spacing in points
                $char_space=($w-$this->cMargin*2-$str_width)/max($this->MBGetStringLength($txt)-1,1)*$this->k;
                //Set character spacing
                $this->_out(sprintf('BT %.2F Tc ET',$char_space));
            }
            //Override user alignment (since text will fill up cell)
            $align='';
        }

        //Pass on to Cell method
        $this->Cell($w,$h,$txt,$border,$ln,$align,$fill,$link);

        //Reset character spacing/horizontal scaling
        if ($fit)
            $this->_out('BT '.($scale ? '100 Tz' : '0 Tc').' ET');
    }

    //Cell with horizontal scaling only if necessary
    function CellFitScale($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,true,false);
    }

    //Cell with horizontal scaling always
    function CellFitScaleForce($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,true,true);
    }

    //Cell with character spacing only if necessary
    function CellFitSpace($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,false,false);
    }

    //Cell with character spacing always
    function CellFitSpaceForce($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
    {
        //Same as calling CellFit directly
        $this->CellFit($w,$h,$txt,$border,$ln,$align,$fill,$link,false,true);
    }

    //Patch to also work with CJK double-byte text
    function MBGetStringLength($s)
    {
        if($this->CurrentFont['type']=='Type0')
        {
            $len = 0;
            $nbbytes = strlen($s);
            for ($i = 0; $i < $nbbytes; $i++)
            {
                if (ord($s[$i])<128)
                    $len++;
                else
                {
                    $len++;
                    $i++;
                }
            }
            return $len;
        }
        else
            return strlen($s);
    }

}

class contactForm{
	
		
	function contactForm($cfg)
	{
		
		/***********************************************************************************************************************************
		 * CONFIGURATION 
		 *
		 * $this->cfg['emailaddress']: the email address on which you want to receive the messages from users through your website
		 * $this->cfg['confirmation_email_subject']: the subject of the email containing the message sent by users through your website
		 * 
		 */
		$this->cfg['captacha_length'] = 6;
		
		$this->cfg['emailaddress'] = $cfg['email'];
		
		$this->cfg['confirmation_email_subject'] = 'Neues Mitglied HSV Sektion Golf';
		
		$this->cfg['form_validationmessage'] = $cfg['form_validationmessage'];
		
		$this->cfg['form_error_captcha'] = $cfg['form_error_captcha'];
		$this->cfg['form_error_emptyfield'] = $cfg['form_error_emptyfield'];
		$this->cfg['form_error_promo'] = $cfg['form_error_promo'];
		$this->cfg['form_error_invalidemailaddress'] = $cfg['form_error_invalidemailaddress'];
		$this->cfg['form_validationmessage'] = $cfg['form_validationmessage'];
		$this->cfg['form_emailnotificationinputid'] = $cfg['form_emailnotificationinputid'];
		$this->cfg['form_emailnotificationtitle'] = $cfg['form_emailnotificationtitle'];
		$this->cfg['form_emailnotificationmessage'] = $cfg['form_emailnotificationmessage'];
		
		$this->mailheaders_brut  = "From: HSV Sektion Golf <sl.golf@hsv-wien.at>\r\n";		
		$this->mailheaders_brut .= "Reply-To: HSV Sektion Golf <sl.golf@hsv-wien.at>\r\n";
		$this->mailheaders_brut .= "MIME-Version: 1.0\r\n";
		$this->mailheaders_brut .= "Content-type: text/plain; charset=utf-8\r\n";
		$this->mailheaders_brut .= "X-Mailer: PHP/".phpversion()."\r\n";
		
		$this->demo = 0;
		$this->envato_link = 'https://codecanyon.net/item/contact-form-generator/1719810';
	}
	
	
	function sendMail()
	{
		
  //erster Wert aus Array
  foreach($this->merge_post as $valuetitel)  break;
  {
				$titel = $this->quote_smart($valuetitel['elementvalue']);
			}

  //Instanz von PHPMailer bilden
  $mail = new PHPMailer();
 
  //Format setzen
  $mail->IsHTML(true);
 
  //Absenderadresse der Email setzen
  $mail->From = "sl.golf@hsv-wien.at";
  
  //Name des Abenders setzen
  $mail->FromName = "HSV wiengolf";
  
  //Empfängeradresse setzen
  $Mailadress = $this->merge_post[11]['elementvalue'];
  $mail->AddAddress($Mailadress);
  $mail->AddAddress("luka@nikolic.at");
  
  //Betreff der Email setzen
  $mail->Subject = 'Herzlich Willkommen zum HSV wiengolf';
 
  //Anrede
  if($this->merge_post[3]['elementvalue'] == "weiblich")
  { $Anrede = "geehrte Frau";
	  }else
	  { $Anrede = "geehrter Herr";
  }
  $Nachname = utf8_decode($this->merge_post[2]['elementvalue']);
  
  //Text der EMail setzen
  $mail->Body = "
<p>Sehr {$Anrede} {$titel} {$Nachname},</p>
Ihre Onlineanmeldung wurde erfolgreich empfangen.<br>
Anbei erhalten Sie die ausgefüllten Anmeldeunterlagen mit der Bitte diese unterfertigt zurückzuschicken.<br>
Um eine schnelle Bearbeitung sicherstellen zu können, ersuchen wir Sie diese per Mail an <a href='mailto:sl.golf@hsv-wien.at'>sl.golf@hsv-wien.at</a> zu senden.<br>
Alternativ können Sie die Unterlagen auch per Post an unser Sekretariat senden.<br>
<br>
HSV wiengolf<br>
Pfarrweg 14/4<br>
2100 Leobendorf<br>
<br>
Nach Erhalt der unterfertigten Unterlagen dauert die Bearbeitung des Antrages nur wenige Tage.<br>
Sie erhalten von uns mit der durchgeführten Anmeldung eine Nachricht.<br>
Ab diesem Zeitpunkt sind Sie am ÖGV-Server eingetragen und können spielen gehen.<br>
Die Übermittlung der ÖGV Karte dauert je nach Auftragsvolumen und Druckterminen 4-8 Wochen.<br>
<br>
Mit freundlichen Grüssen und schönes Spiel<br>
<br>
Ing. Thomas Clausen<br>
Präsident<br>
HSV wiengolf<br>
<a href='https://golf.hsv-wien.at'>https://golf.hsv-wien.at</a><br>
<p><img src='https://golf.hsv-wien.at/golfanmeldung/logo_mail.png' alt='logo'></p>
";
  $mail->AltBody="Sehr {$Anrede} {$titel} {$this->merge_post[2]['elementvalue']},
Ihre Onlineanmeldung wurde erfolgreich empfangen.
Anbei erhalten Sie die ausgefüllten Anmeldeunterlagen mit der Bitte diese unterfertigt zurückzuschicken.
Um eine schnelle Bearbeitung sicherstellen zu können, ersuchen wir Sie diese per Mail an sl.golf@hsv-wien.at zu senden.
Alternativ können Sie die Unterlagen auch per Post an unser Sekretariat senden.

HSV wiengolf
Pfarrweg 14/4
2100 Leobendorf

Nach Erhalt der unterfertigten Unterlagen dauert die Bearbeitung des Antrages nur wenige Tage.
Sie erhalten von uns mit der durchgeführten Anmeldung eine Nachricht.
Ab diesem Zeitpunkt sind Sie am ÖGV-Server eingetragen und können spielen gehen.
Die Übermittlung der ÖGV Karte dauert je nach Auftragsvolumen und Druckterminen 4-8 Wochen.

Mit freundlichen Grüssen und schönes Spiel

Ing. Thomas Clausen
Präsident
HSV wiengolf
https://golf.hsv-wien.at
";
    
  //Variablen Definieren
  $timestamp = time();
  $datum = date("d.m.Y", $timestamp);

  $Name = "{$titel} {$this->merge_post[1]['elementvalue']} {$this->merge_post[2]['elementvalue']}";
  $Vorname = utf8_decode($this->merge_post[1]['elementvalue']);
  $Vornach = "{$Vorname} {$Nachname}";
  $Adresse = "{$this->merge_post[6]['elementvalue']} {$this->merge_post[7]['elementvalue']} {$this->merge_post[8]['elementvalue']} {$this->merge_post[9]['elementvalue']}";
  $Adresse1 = $this->merge_post[6]['elementvalue'];
  $Adresse2 = "{$this->merge_post[7]['elementvalue']} {$this->merge_post[8]['elementvalue']} {$this->merge_post[9]['elementvalue']}";
  $PLZ = $this->merge_post[7]['elementvalue'];
  $Land = $this->merge_post[9]['elementvalue'];
  $Ort = $this->merge_post[8]['elementvalue'];
  $Telefon = $this->merge_post[10]['elementvalue'];
  $Jahr = $this->merge_post[12]['elementvalue'];  
  $Mitgliedschaft = $this->merge_post[13]['elementvalue'];
  $Promo = $this->merge_post[14]['elementvalue'];
  $Ichbin = $this->merge_post[15]['elementvalue'];
  $Geburtsdatum = $this->merge_post[4]['elementvalue'];
  $Staatsbuergerschaft = $this->merge_post[5]['elementvalue'];
  $Ausweistyp = $this->merge_post[19]['elementvalue'];
  $Ausweisnummer = $this->merge_post[21]['elementvalue'];
  $Ausweisbehoerde = $this->merge_post[20]['elementvalue'];
  $Ausweisdatum = $this->merge_post[22]['elementvalue'];
  $Ort1 = "{$this->merge_post[8]['elementvalue']}, {$datum}";
  $Ort2 = "Wien, {$datum}";
  $IBAN = $this->merge_post[17]['elementvalue'];
  $BIC = $this->merge_post[18]['elementvalue'];

  //PDF Antrag erstellen
  $pdf1 = new FPDF_CellFit();
  $pdf1->AddPage();
  $pdf1->Image('Mitgliedsantrag.png',0,0,210,0);
  $pdf1->SetFont('Arial','B',10); 
  $pdf1->ln(41);
  $pdf1->Cell(29);
  $pdf1->CellFitScale(156,9,utf8_decode($Name),0,1,'',0);
  $pdf1->ln(1);
  $pdf1->Cell(29);
  $pdf1->CellFitScale(156,9,utf8_decode($Adresse),0,1,'',0);
  $pdf1->ln(1);
  $pdf1->Cell(29);
  $pdf1->CellFitScale(59,9,$Telefon,0,1,'',0);
  $pdf1->ln(-9);
  $pdf1->Cell(127);
  $pdf1->CellFitScale(58,9,utf8_decode($Mailadress),0,1,'',0);
  $pdf1->ln(1);
  $pdf1->Cell(29);
  $pdf1->CellFitScale(59,9,$Geburtsdatum,0,1,'',0);
  $pdf1->ln(-9);
  $pdf1->Cell(127);
  $pdf1->CellFitScale(58,9,utf8_decode($Staatsbuergerschaft),0,1,'',0);  
  $pdf1->ln(1);
  $pdf1->Cell(29);
  $pdf1->CellFitScale(59,9,utf8_decode($Ausweistyp),0,1,'',0);
  $pdf1->ln(-9);
  $pdf1->Cell(127);
  $pdf1->CellFitScale(58,9,$Ausweisnummer,0,1,'',0); 
  $pdf1->ln(1);
  $pdf1->Cell(29);
  $pdf1->CellFitScale(59,9,utf8_decode($Ausweisbehoerde),0,1,'',0);
  $pdf1->ln(-9);
  $pdf1->Cell(127);
  $pdf1->CellFitScale(58,9,$Ausweisdatum,0,1,'',0); 
  $pdf1->SetFont('Arial','B',16);
  
  if($Mitgliedschaft == 1){
	  $pdf1->Text(11,126,'x');
	  $Mitgliedschafttext = "Normal 199";
	  $Mitgliedschaftwert = "249";
	  }
  if($Mitgliedschaft == 2){
	  $pdf1->Text(11,131,'x');
	  $Mitgliedschafttext = "Extra 219";
	  $Mitgliedschaftwert = "269";
	  }
  if($Mitgliedschaft == 3){
	  $pdf1->Text(11,136,'x');
	  $Mitgliedschafttext = "ÖBH BMLV 169";
	  $Mitgliedschaftwert = "219";
	  }
  if($Mitgliedschaft == 4){
	  $pdf1->Text(11,141,'x');
	  $Mitgliedschafttext = "Student 129";
	  $Mitgliedschaftwert = "179";
	  }
  if($Mitgliedschaft == 5){
	  $pdf1->Text(84,126,'x');
	  $Mitgliedschafttext = "GWD 99";
	  $Mitgliedschaftwert = "149";
 	  }
  if($Mitgliedschaft == 6){
	  $pdf1->Text(84,131,'x');
	  $Mitgliedschafttext = "Kinder";
	  $Mitgliedschaftwert = "0";
	  }
  if($Mitgliedschaft == 7){
	  $pdf1->Text(84,136,'x');
	  $Mitgliedschafttext = "Jugend 79";
	  $Mitgliedschaftwert = "79";
	  }
  if($Mitgliedschaft == 8){
	  $pdf1->Text(84,141,'x');
	  $Mitgliedschafttext = "Jugend 99";
	  $Mitgliedschaftwert = "99";
	  }

  if($Ichbin == 1){
	  $pdf1->Text(13,220,'x');
	  $ichbintext = "Platzerlaubnis";
	  }
  if($Ichbin == 2){
	  $pdf1->Text(13,225,'x');
	  $ichbintext = "Turniererlaubnis";
	  }   
  if($Ichbin == 3){
	  $pdf1->Text(13,230,'x');
	  $ichbintext = "Clubvorgabe/Stammvorgabe";
	  }
	   
  $pdf1->SetFont('Arial','B',10);
  $pdf1->ln(131);
  $pdf1->Cell(5);
  $pdf1->CellFitScale(75,9,utf8_decode($Ort1),0,1,'',0); 
  $pdf1->ln(14);
  $pdf1->Cell(5);
  $pdf1->CellFitScale(75,9,utf8_decode($Ort2),0,1,'',0); 
  $pdf1->ln(-139);
  $pdf1->Cell(150);
  $pdf1->CellFitScale(58,8,$Promo,0,1,'',0);
  
  if($Jahr == 1){
	  $pdf1->Text(128,120,'2017');
	  }
  if($Jahr == 2){
	  $pdf1->Text(128,120,'2016');
	  }
  if($Jahr == 3){
	  $pdf1->Text(128,120,'2018');
	  }
	  
  //PDF Sepa erstellen
  $pdf2 = new FPDF_CellFit();
  $pdf2->AddPage();
  $pdf2->Image('sepa1.png',0,0,210,0);
  $pdf2->SetFont('Arial','B',14); 
  $pdf2->ln(168);
  $pdf2->Cell(17);
  $pdf2->CellFitScale(172,8,utf8_decode($Name),0,1,'',0);
  $pdf2->ln(2);
  $pdf2->Cell(17);
  $pdf2->CellFitScale(172,8,utf8_decode($Adresse1),0,1,'',0);
  $pdf2->ln(2);
  $pdf2->Cell(17);
  $pdf2->CellFitScale(172,8,utf8_decode($Adresse2),0,1,'',0);
  $pdf2->ln(2);
  $pdf2->Cell(17);
  $pdf2->CellFitScale(107,8,$IBAN,0,1,'',0);
  $pdf2->ln(1);
  $pdf2->Cell(17);
  $pdf2->CellFitScale(107,8,$BIC,0,1,'',0);
  $pdf2->ln(24);
  $pdf2->Cell(2);
  $pdf2->CellFitScale(65,8,utf8_decode($Ort1),0,1,'',0);  
  
  //PDF anhängen
  $antrag = $pdf1->Output('S');
  $sepa = $pdf2->Output('S');
  $mail->AddStringAttachment($antrag, 'Mitgliedsantrag.pdf', 'base64', 'application/pdf');
  $mail->AddStringAttachment($sepa, 'SEPA.pdf', 'base64', 'application/pdf');  
  
  //EMail senden
  $mail->Send();
		
	}
/*
	{
		$mail_body .= 'Anmeldung vom: '.date("F j, Y, g:i A")
					."\r\n"."--------------------------------------------------------";

		if($this->merge_post)
		{
			foreach($this->merge_post as $value)
			{
				$mail_body .= "\r\n".$this->quote_smart($value['elementlabel']).': '.$this->quote_smart($value['elementvalue']);
			}
		}
		
		$mail_body .= "\r\n\r\n"."--------------------------------------------------------";
		$mail_body .= "\r\n".'IP address: '.$_SERVER['REMOTE_ADDR'];
		$mail_body .= "\r\n".'Host: '.gethostbyaddr($_SERVER['REMOTE_ADDR']);

		if($this->demo != 1)
		{
			mail($this->cfg['emailaddress'], $this->cfg['confirmation_email_subject'], $mail_body, $this->mailheaders_brut);

		}
	}
*/
	
	function sendMailReceipt($value)
	{
		if($this->demo != 1)
		{
  //Instanz von PHPMailer bilden
  $mail2 = new PHPMailer();
 
  //Format setzen
  $mail2->IsHTML(true);
 
  //Absenderadresse der Email setzen
  $mail2->From = "sl.golf@hsv-wien.at";
  
  //Name des Abenders setzen
  $mail2->FromName = "HSV wiengolf";
  
  //Empfängeradresse setzen
  $mail2->AddAddress("sl.golf@hsv-wien.at");
  $mail2->AddAddress("luka@nikolic.at");
  
  //Betreff der Email setzen
  $mail2->Subject = 'Neues Mitglied HSV wiengolf';
  
  //erster Wert aus Array
  foreach($this->merge_post as $valuetitel)  break;
  {
				$titel = $this->quote_smart($valuetitel['elementvalue']);
			}
			
  //Variablen setzen
  $hcp = $this->merge_post[16]['elementvalue'];
  $Nachname = utf8_decode($this->merge_post[2]['elementvalue']);
  $timestamp = time();
  $datum = date("d.m.Y", $timestamp);
  $Geschlecht = utf8_decode($this->merge_post[3]['elementvalue']);
  $Name = "{$titel} {$this->merge_post[1]['elementvalue']} {$this->merge_post[2]['elementvalue']}";
  $Vorname = utf8_decode($this->merge_post[1]['elementvalue']);
  $Vornach = "{$Vorname} {$Nachname}";
  $Adresse = "{$this->merge_post[6]['elementvalue']} {$this->merge_post[7]['elementvalue']} {$this->merge_post[8]['elementvalue']} {$this->merge_post[9]['elementvalue']}";
  $Adresse1 = utf8_decode($this->merge_post[6]['elementvalue']);
  $Adresse2 = "{$this->merge_post[7]['elementvalue']} {$this->merge_post[8]['elementvalue']} {$this->merge_post[9]['elementvalue']}";
  $PLZ = $this->merge_post[7]['elementvalue'];
  $Land = utf8_decode($this->merge_post[9]['elementvalue']);
  $Ort = utf8_decode($this->merge_post[8]['elementvalue']);
  $Telefon = $this->merge_post[10]['elementvalue'];
  $Mailformular = $this->merge_post[11]['elementvalue'];
  $Jahr = $this->merge_post[12]['elementvalue']; 
  $Mitgliedschaft = utf8_decode($this->merge_post[13]['elementvalue']);
  $Promo = $this->merge_post[14]['elementvalue'];
  $Ichbin = utf8_decode($this->merge_post[15]['elementvalue']);
  $Geburtsdatum = $this->merge_post[4]['elementvalue'];
  $Staatsbuergerschaft = utf8_decode($this->merge_post[5]['elementvalue']);
  $Ausweistyp = utf8_decode($this->merge_post[20]['elementvalue']);
  $Ausweisnummer = $this->merge_post[21]['elementvalue'];
  $Ausweisbehoerde = utf8_decode($this->merge_post[20]['elementvalue']);
  $Ausweisdatum = $this->merge_post[22]['elementvalue'];
  $Anmerkung = $this->merge_post[23]['elementvalue'];
  $Ort1 = "{$Ort}, {$datum}";
  $Ort2 = "Wien, {$datum}";
  $IBAN = $this->merge_post[17]['elementvalue'];
  $IBANDB = str_replace(' ','',$IBAN);
  $BIC = $this->merge_post[18]['elementvalue'];
    if($Mitgliedschaft == 1){
	  $Mitgliedschafttext = "Normal 199";
	  $Mitgliedschaftwert = "249";
	  }
  if($Mitgliedschaft == 2){
	  $Mitgliedschafttext = "Extra 219";
	  $Mitgliedschaftwert = "269";
	  }
  if($Mitgliedschaft == 3){
	  $Mitgliedschafttext = "ÖBH BMLV 169";
	  $Mitgliedschaftwert = "219";
	  }
  if($Mitgliedschaft == 4){
	  $Mitgliedschafttext = "Student 129";
	  $Mitgliedschaftwert = "179";
	  }
  if($Mitgliedschaft == 5){
	  $Mitgliedschafttext = "GWD 99";
	  $Mitgliedschaftwert = "149";
 	  }
  if($Mitgliedschaft == 6){
	  $Mitgliedschafttext = "Kinder";
	  $Mitgliedschaftwert = "0";
	  }
  if($Mitgliedschaft == 7){
	  $Mitgliedschafttext = "Jugend 79";
	  $Mitgliedschaftwert = "79";
	  }
  if($Mitgliedschaft == 8){
	  $Mitgliedschafttext = "Jugend 99";
	  $Mitgliedschaftwert = "99";
	  }

  if($Ichbin == 1){
	  $ichbintext = "Platzerlaubnis";
	  }
  if($Ichbin == 2){
	  $ichbintext = "Turniererlaubnis";
	  }   
  if($Ichbin == 3){
	  $ichbintext = "Clubvorgabe/Stammvorgabe";
	  }
	   
  //Inhalt setzen
  $mail_body = 'Zusatzinformationen:<br>Anmeldung vom: '.date("F j, Y, g:i A")
					."<br>"."--------------------------------------------------------";

		if($this->merge_post)
		{
			foreach($this->merge_post as $value)
			{
				$mail_body .= "<br>".utf8_decode($this->quote_smart($value['elementlabel'])).': '.utf8_decode($this->quote_smart($value['elementvalue']));
			}
		}
		
		$mail_body .= "<br>"."--------------------------------------------------------";
		$mail_body .= "<br>".'IP address: '.$_SERVER['REMOTE_ADDR'];
		$mail_body .= "<br>".'Host: '.gethostbyaddr($_SERVER['REMOTE_ADDR']);
 
  $mail2->Body = "Datensatz für Import:<br>{$Promo};{$Anmerkung};{$hcp};{$Telefon};{$Mailformular};{$datum};;€ {$Mitgliedschaftwert};FALSCH;{$Mitgliedschafttext};;{$Adresse1};{$PLZ};{$Land};{$Ort};{$Geburtsdatum};{$Staatsbuergerschaft};;;;{$titel};{$Nachname};{$Vornach};{$Vorname};{$IBANDB};{$BIC};;WAHR;{$datum};{$Geschlecht}<br><br>{$mail_body}";
	
	//CSV
$file1 = "{$Promo};{$Anmerkung};{$hcp};{$Telefon};{$Mailformular};{$datum};;€ {$Mitgliedschaftwert};FALSCH;{$Mitgliedschafttext};;{$Adresse1};{$PLZ};{$Land};{$Ort};{$Geburtsdatum};{$Staatsbuergerschaft};;;;{$titel};{$Nachname};{$Vornach};{$Vorname};{$IBANDB};{$BIC};;WAHR;{$datum};{$Geschlecht}";	

$file2 = "HCP;Telefon;Mail;Adresse;PLZ;Ort;Staat;Titel;Name;Geburtsdatum;Staatsbürgerschaft;Betrag\r\n{$hcp};{$Telefon};{$Mailformular};{$Adresse1};{$PLZ};{$Ort};{$Land};{$titel};{$Vornach};{$Geburtsdatum};{$Staatsbuergerschaft};€ 190";	

$file3 = "Adresse;PLZ;Ort;Staat;Titel;Name;Betrag\r\n{$Adresse1};{$PLZ};{$Ort};{$Land};{$titel};{$Vornach};€ 190";	
    //Attachment
	$filename1 = "Datenbank Import {$Vornach}.csv";
	$filename2 = "Neulengbach Anmeldung {$Vornach}.csv";
	$filename3 = "Extra Anmeldung {$Vornach}.csv";
    $mail2->AddStringAttachment($file1, $filename1, 'base64', 'text/csv');
    $mail2->AddStringAttachment($file2, $filename2, 'base64', 'text/csv');
    $mail2->AddStringAttachment($file3, $filename3, 'base64', 'text/csv');
	
    //EMail senden
    $mail2->Send();					
			
			//mail($this->cfg['emailaddress'], "Neues Mitglied HSV Sektion Golf", $value['form_emailnotificationmessage'], $this->mailheaders_brut);
		}
	}
	
	function mergePost($value)
	{
		$this->merge_post[$this->merge_post_index]['elementid'] = $value['elementid'];
		$this->merge_post[$this->merge_post_index]['elementvalue'] = trim($value['elementvalue']);
		$this->merge_post[$this->merge_post_index]['elementlabel'] = trim($value['label']);
		$this->merge_post_index++;
	}
	

	function isEmail($email)
	{
		$atom   = '[-a-z0-9\\_]';   // authorized caracters before @
		$domain = '([a-z0-9]([-a-z0-9]*[a-z0-9]+)?)'; // authorized caracters after @
									   
		$regex = '/^' . $atom . '+' .   
		'(\.' . $atom . '+)*' .         
										
		'@' .                           
		'(' . $domain . '{1,63}\.)+' .  
										
		$domain . '{2,63}$/i';          
		
		// test de l'adresse e-mail
		return preg_match($regex, trim($email)) ? 1 : 0;
		
	}
	
	
	function quote_smart($value)
	{
		if(get_magic_quotes_gpc())
		{
			$value = stripslashes($value);
		}
		
		return $value;
	}

	
	
}
?>

