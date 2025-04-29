<?php
require_once('class.fpdf.php');
require_once('class.phpmailer.php');

class FPDF_CellFit extends FPDF {

    //Cell with horizontal scaling if text is too wide
    function CellFit($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='', $scale=false, $force=true)
    {
        // Guard gegen Division by zero: bei leerem Text direkt Standard-Cell aufrufen
        if ($txt === '' || $this->GetStringWidth($txt) == 0) {
          return $this->Cell($w, $h, $txt, $border, $ln, $align, $fill, $link);
        }
        //Get string width
        $str_width = $this->GetStringWidth($txt);

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
  
  //-------------------------------------------
  // Patch to make it work again with PHP 8.3
  // Author: frameless Media
  // 08.04.2025 
  //-------------------------------------------
  public $merge_post = [];

  // Konstruktor
  public function __construct($cfg) {
      $this->cfg = $cfg;
      $this->merge_post = []; // Initialisierung
  }
  //-------------------------------------------
  // end Patch
  //-------------------------------------------
    
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
      // Titel gezielt aus Formularwerten extrahieren
      $titel = '';
      foreach ($this->merge_post as $entry) {
          if (strtolower($entry['label']) === 'titel') {
              $titel = trim($entry['elementvalue']);
              break;
          }
      }
  
      $mail = new PHPMailer();
      $mail->CharSet = 'UTF-8';
      $mail->isHTML(true);
      $mail->Encoding = 'quoted-printable'; // ← WICHTIG für gute Darstellung
      $mail->From = "sl.golf@hsv-wien.at";
      $mail->FromName = "HSV wiengolf";
  
      $Mailadress = $this->merge_post[11]['elementvalue'];
      $mail->AddAddress($Mailadress);
      $mail->Subject = 'Herzlich Willkommen zum HSV wiengolf';
  
      $Anrede = ($this->merge_post[3]['elementvalue'] === "weiblich") ? "geehrte Frau" : "geehrter Herr";
      $Nachname = $this->merge_post[2]['elementvalue'];
  
      // HTML-Mail-Body
      $mail->Body = "<!DOCTYPE html><html><body>
  <p>Sehr {$Anrede} {$titel} {$Nachname},</p>
  Ihre Onlineanmeldung wurde erfolgreich empfangen.<br>
  Anbei erhalten Sie die ausgefüllten Anmeldeunterlagen mit der Bitte diese unterfertigt zurückzuschicken.<br>
  Um eine schnelle Bearbeitung sicherstellen zu können, ersuchen wir Sie diese per Mail an 
  <a href='mailto:sl.golf@hsv-wien.at'>sl.golf@hsv-wien.at</a> zu senden.<br>
  Alternativ können Sie die Unterlagen auch per Post an unser Sekretariat senden.<br><br>
  HSV WIEN<br>
  In den Gabrissen 91<br>
  1210 Wien<br><br>
  Nach Erhalt der unterfertigten Unterlagen dauert die Bearbeitung des Antrages nur wenige Tage.<br>
  Sie erhalten von uns mit der durchgeführten Anmeldung eine Nachricht.<br>
  Ab diesem Zeitpunkt sind Sie am ÖGV-Server eingetragen und können spielen gehen.<br>
  Die Übermittlung der ÖGV Karte dauert je nach Auftragsvolumen und Druckterminen 4-8 Wochen.<br><br>
  Mit freundlichen Grüßen und schönes Spiel<br><br>
  Michael Blaha, MSc<br>
  Präsident<br>
  HSV WIEN<br>
  <a href='https://golf.hsv-wien.at'>https://golf.hsv-wien.at</a><br>
  <p><img src='https://golf.hsv-wien.at/golfanmeldung/logo_mail.png' alt='logo'></p>
  </body></html>";
  
  // Plaintext-Version als Fallback
  $mail->AltBody = "Sehr {$Anrede} {$titel} {$Nachname},\n\n" .
      "Ihre Onlineanmeldung wurde erfolgreich empfangen.\n" .
      "Anbei erhalten Sie die ausgefüllten Anmeldeunterlagen mit der Bitte diese unterfertigt zurückzuschicken.\n" .
      "Um eine schnelle Bearbeitung sicherzustellen, ersuchen wir Sie diese per Mail an sl.golf@hsv-wien.at zu senden.\n" .
      "Alternativ können Sie die Unterlagen auch per Post an unser Sekretariat senden.\n\n" .
      "HSV WIEN\nIn den Gabrissen 91\n1210 Wien\n\n" .
      "Nach Erhalt der unterfertigten Unterlagen dauert die Bearbeitung des Antrages nur wenige Tage.\n" .
      "Sie erhalten von uns mit der durchgeführten Anmeldung eine Nachricht.\n" .
      "Ab diesem Zeitpunkt sind Sie am ÖGV-Server eingetragen und können spielen gehen.\n" .
      "Die Übermittlung der ÖGV Karte dauert je nach Auftragsvolumen und Druckterminen 4-8 Wochen.\n\n" .
      "Mit freundlichen Grüßen und schönes Spiel\n\n" .
      "Michael Blaha, MSc\nPräsident\nHSV WIEN\nhttps://golf.hsv-wien.at";
    
  //Variablen Definieren
  $timestamp = time();
  $datum = date("d.m.Y", $timestamp);

  $Name = "{$titel} {$this->merge_post[1]['elementvalue']} {$this->merge_post[2]['elementvalue']}";
  $Vorname = $this->merge_post[1]['elementvalue'];
  $Vornach = "{$Vorname} {$Nachname}";
  $Adresse = "{$this->merge_post[6]['elementvalue']}, {$this->merge_post[7]['elementvalue']} {$this->merge_post[8]['elementvalue']}, {$this->merge_post[9]['elementvalue']}";
  $Adresse1 = $this->merge_post[6]['elementvalue'];
  $Adresse2 = "{$this->merge_post[7]['elementvalue']} {$this->merge_post[8]['elementvalue']}, {$this->merge_post[9]['elementvalue']}";
  $PLZ = $this->merge_post[7]['elementvalue'];
  $Land = $this->merge_post[9]['elementvalue'];
  $Ort = $this->merge_post[8]['elementvalue'];
  $Telefon = $this->merge_post[10]['elementvalue'];
  $Jahr = $this->merge_post[12]['elementvalue'];  
  $Mitgliedschaft = $this->merge_post[13]['elementvalue'];
  $Promo = $this->merge_post[16]['elementvalue'];
  $Ichbin = $this->merge_post[17]['elementvalue'];
  $Geburtsdatum = $this->merge_post[4]['elementvalue'];
  $Staatsbuergerschaft = $this->merge_post[5]['elementvalue'];
  $Ausweistyp = $this->merge_post[21]['elementvalue'];
  $Ausweisnummer = $this->merge_post[23]['elementvalue'];
  $Ausweisbehoerde = $this->merge_post[22]['elementvalue'];
  $Ausweisdatum = $this->merge_post[24]['elementvalue'];
  $Ort1 = "{$this->merge_post[8]['elementvalue']}, {$datum}";
  $Ort2 = "Wien, {$datum}";
  $IBAN = $this->merge_post[19]['elementvalue'];
  $BIC = $this->merge_post[20]['elementvalue'];
  $Extracard = $this->merge_post[14]['elementvalue'];
  $Greenfee = $this->merge_post[15]['elementvalue'];

  //PDF Antrag erstellen
  $pdf1 = new FPDF_CellFit();
  $pdf1->AddPage();
  $pdf1->Image('Mitgliedsantrag.png',0,0,210,0);
  $pdf1->SetFont('Arial','B',10); 
  $pdf1->ln(41);
  $pdf1->Cell(29);
  $pdf1->CellFitScale(156,9,$Name,0,1,'',0);
  $pdf1->ln(1);
  $pdf1->Cell(29);
  $pdf1->CellFitScale(156,9,$Adresse,0,1,'',0);
  $pdf1->ln(1);
  $pdf1->Cell(29);
  $pdf1->CellFitScale(59,9,$Telefon,0,1,'',0);
  $pdf1->ln(-9);
  $pdf1->Cell(127);
  $pdf1->CellFitScale(58,9,$Mailadress,0,1,'',0);
  $pdf1->ln(1);
  $pdf1->Cell(29);
  $pdf1->CellFitScale(59,9,$Geburtsdatum,0,1,'',0);
  $pdf1->ln(-9);
  $pdf1->Cell(127);
  $pdf1->CellFitScale(58,9,$Staatsbuergerschaft,0,1,'',0);  
  $pdf1->ln(1);
  $pdf1->Cell(29);
  $pdf1->CellFitScale(59,9,$Ausweistyp,0,1,'',0);
  $pdf1->ln(-9);
  $pdf1->Cell(127);
  $pdf1->CellFitScale(58,9,$Ausweisnummer,0,1,'',0); 
  $pdf1->ln(1);
  $pdf1->Cell(29);
  $pdf1->CellFitScale(59,9,$Ausweisbehoerde,0,1,'',0);
  $pdf1->ln(-9);
  $pdf1->Cell(127);
  $pdf1->CellFitScale(58,9,$Ausweisdatum,0,1,'',0); 
  $pdf1->SetFont('Arial','B',16);
  
  if($Mitgliedschaft == 1){
    $pdf1->Text(11,126,'x');
    $Mitgliedschafttext = "Standard 199";
    $Mitgliedschaftwert = "199";
    }
  if($Mitgliedschaft == 2){
    $pdf1->Text(11,131,'x');
    $Mitgliedschafttext = "Student 149";
    $Mitgliedschaftwert = "149";
    }
  if($Mitgliedschaft == 3){
    $pdf1->Text(84,126,'x');
    $Mitgliedschafttext = "Jugend 99";
    $Mitgliedschaftwert = "99";
    }
  if($Mitgliedschaft == 4){
    $pdf1->Text(84,131,'x');
    $Mitgliedschafttext = "Kinder 0";
    $Mitgliedschaftwert = "0";
    }

  if($Extracard == 2){
    $pdf1->Text(11,141,'x');
    $ichbintext = "Extra Golf VIP Card EUR 30,-";
    }
    
  if($Greenfee == 2){
    $pdf1->Text(84,141,'x');
    $ichbintext = "Greenfee Package EUR 69,-";
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
    $ichbintext = "Stammvorgabe";
    }
     
  $pdf1->SetFont('Arial','B',10);
  $pdf1->ln(131);
  $pdf1->Cell(5);
  $pdf1->CellFitScale(75,9,$Ort1,0,1,'',0); 
  $pdf1->ln(14);
  $pdf1->Cell(5);
  $pdf1->CellFitScale(75,9,$Ort2,0,1,'',0); 
  $pdf1->ln(-139);
  $pdf1->Cell(150);
  $pdf1->CellFitScale(58,8,$Promo,0,1,'',0);
  
  if($Jahr == 1){
    $pdf1->Text(128,120,'2025');
    }
  if($Jahr == 2){
    $pdf1->Text(128,120,'2026');
    }
  if($Jahr == 3){
    $pdf1->Text(128,120,'2027');
    }
    
  //PDF Sepa erstellen
  $pdf2 = new FPDF_CellFit();
  $pdf2->AddPage();
  $pdf2->Image('sepa1.png',0,0,210,0);
  $pdf2->SetFont('Arial','B',14); 
  $pdf2->ln(168);
  $pdf2->Cell(17);
  $pdf2->CellFitScale(172,8,$Name,0,1,'',0);
  $pdf2->ln(2);
  $pdf2->Cell(17);
  $pdf2->CellFitScale(172,8,$Adresse1,0,1,'',0);
  $pdf2->ln(2);
  $pdf2->Cell(17);
  $pdf2->CellFitScale(172,8,$Adresse2,0,1,'',0);
  $pdf2->ln(2);
  $pdf2->Cell(17);
  $pdf2->CellFitScale(107,8,$IBAN,0,1,'',0);
  $pdf2->ln(1);
  $pdf2->Cell(17);
  $pdf2->CellFitScale(107,8,$BIC,0,1,'',0);
  $pdf2->ln(24);
  $pdf2->Cell(2);
  $pdf2->CellFitScale(65,8,$Ort1,0,1,'',0);  
  
  //PDF anhängen
  $antrag = $pdf1->Output('S');
  $sepa = $pdf2->Output('S');
  $mail->AddStringAttachment($antrag, 'Mitgliedsantrag.pdf', 'base64', 'application/pdf');
  $mail->AddStringAttachment($sepa, 'SEPA.pdf', 'base64', 'application/pdf');  
  
  //EMail senden
  $mail->Send();
    
  }
  
  function sendMailReceipt()
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
  //$mail2->AddAddress("sl.golf@hsv-wien.at");
  //$mail2->AddAddress("luka@nikolic.at");
  
  //Betreff der Email setzen
  $mail2->Subject = 'Neues Mitglied HSV wiengolf';
  
  //erster Wert aus Array
  foreach($this->merge_post as $valuetitel)  break;
  {
        $titel = $this->quote_smart($valuetitel['elementvalue']);
      }
      
  //Variablen setzen
  $hcp = $this->merge_post[18]['elementvalue'];
  $Nachname = $this->merge_post[2]['elementvalue'];
  $timestamp = time();
  $datum = date("d.m.Y", $timestamp);
  $Geschlecht = $this->merge_post[3]['elementvalue'];
  $Name = "{$titel} {$this->merge_post[1]['elementvalue']} {$this->merge_post[2]['elementvalue']}";
  $Vorname = $this->merge_post[1]['elementvalue'];
  $Vornach = "{$Vorname} {$Nachname}";
  $Adresse = "{$this->merge_post[6]['elementvalue']}, {$this->merge_post[7]['elementvalue']} {$this->merge_post[8]['elementvalue']}, {$this->merge_post[9]['elementvalue']}";
  $Adresse1 = $this->merge_post[6]['elementvalue'];
  $Adresse2 = "{$this->merge_post[7]['elementvalue']} {$this->merge_post[8]['elementvalue']}, {$this->merge_post[9]['elementvalue']}";
  $PLZ = $this->merge_post[7]['elementvalue'];
  $Land = $this->merge_post[9]['elementvalue'];
  $Ort = $this->merge_post[8]['elementvalue'];
  $Telefon = $this->merge_post[10]['elementvalue'];
  $Mailformular = $this->merge_post[11]['elementvalue'];
  $Jahr = $this->merge_post[12]['elementvalue']; 
  $Mitgliedschaft = $this->merge_post[13]['elementvalue'];
  $Promo = $this->merge_post[16]['elementvalue'];
  $Ichbin = $this->merge_post[17]['elementvalue'];
  $Geburtsdatum = $this->merge_post[4]['elementvalue'];
  $Staatsbuergerschaft = $this->merge_post[5]['elementvalue'];
  $Ausweistyp = $this->merge_post[21]['elementvalue'];
  $Ausweisnummer = $this->merge_post[23]['elementvalue'];
  $Ausweisbehoerde = $this->merge_post[22]['elementvalue'];
  $Ausweisdatum = $this->merge_post[24]['elementvalue'];
  $Anmerkung = $this->merge_post[25]['elementvalue'];
  $Ort1 = "{$Ort}, {$datum}";
  $Ort2 = "Wien, {$datum}";
  $IBAN = $this->merge_post[19]['elementvalue'];
  $IBANDB = str_replace(' ','',$IBAN);
  $BIC = $this->merge_post[20]['elementvalue'];
  $Extracard = $this->merge_post[14]['elementvalue'];
  $Greenfee = $this->merge_post[15]['elementvalue'];

  if($Mitgliedschaft == 1){
    $Mitgliedschafttext = "Standard 199";
    $Mitgliedschaftwert = "199";
    }
  if($Mitgliedschaft == 2){
    $Mitgliedschafttext = "Student 149";
    $Mitgliedschaftwert = "149";
    }
  if($Mitgliedschaft == 3){
    $Mitgliedschafttext = "Jugend 99";
    $Mitgliedschaftwert = "99";
    }
  if($Mitgliedschaft == 4){
    $Mitgliedschafttext = "Kinder 0";
    $Mitgliedschaftwert = "0";
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
        $mail_body .= "<br>".$this->quote_smart($value['elementlabel']).': '.$this->quote_smart($value['elementvalue']);
      }
    }
    
    $mail_body .= "<br>"."--------------------------------------------------------";
    $mail_body .= "<br>".'IP address: '.$_SERVER['REMOTE_ADDR'];
    $mail_body .= "<br>".'Host: '.gethostbyaddr($_SERVER['REMOTE_ADDR']);
 
  $mail2->Body = "Datensatz fuer Import:<br>{$Promo};{$Anmerkung};{$hcp};{$Telefon};{$Mailformular};{$datum};;{$Mitgliedschaftwert};FALSCH;{$Mitgliedschafttext};;{$Adresse1};{$PLZ};{$Land};{$Ort};{$Geburtsdatum};{$Staatsbuergerschaft};;;;{$titel};{$Nachname};{$Vornach};{$Vorname};{$IBANDB};{$BIC};;WAHR;{$datum};{$Geschlecht}<br><br>{$mail_body}";
  
  //CSV
//$file1 = "{$Promo};{$Anmerkung};{$hcp};'{$Telefon};{$Mailformular};{$datum};{$Mitgliedschaftwert};FALSCH;{$Mitgliedschafttext};;{$Adresse1};{$PLZ};{$Land};{$Ort};{$Geburtsdatum};{$Staatsbuergerschaft};;;;{$titel};{$Nachname};{$Vornach};{$Vorname};{$IBANDB};{$BIC};;WAHR;{$datum};{$Geschlecht}";
$file1 = "{$Promo};{$Anmerkung};{$titel};{$Nachname};{$Vorname};{$Adresse1};{$PLZ};{$Ort};{$Land};{$Staatsbuergerschaft};{$Geburtsdatum};{$Geschlecht};'{$Telefon};{$Mailformular};{$hcp};{$datum};{$Mitgliedschafttext};;{$Mitgliedschaftwert};;;;{$Extracard};;;;{$Greenfee};;{$IBANDB};{$BIC};;;{$datum}";

//$file2 = "HCP;Telefon;Mail;Adresse;PLZ;Ort;Staat;Titel;Name;Geburtsdatum;Staatsbuergerschaft;Betrag\r\n{$hcp};'{$Telefon};{$Mailformular};{$Adresse1};{$PLZ};{$Ort};{$Land};{$titel};{$Vornach};{$Geburtsdatum};{$Staatsbuergerschaft};227";	
$file2 = "Titel;Nachname;Vorname;Adresse;PLZ;Ort;Staat;Geburtsdatum;Geschlecht;Telefonnummer;EMailAdresse;Eintritts HCP;Erstellungsdatum;\r\n{$titel};{$Nachname};{$Vorname};{$Adresse1};{$PLZ};{$Ort};{$Land};{$Geburtsdatum};{$Geschlecht};'{$Telefon};{$Mailformular};{$hcp};{$datum}";

//$file3 = "Adresse;PLZ;Ort;Staat;Titel;Name;Betrag\r\n{$Adresse1};{$PLZ};{$Ort};{$Land};{$titel};{$Vornach};30";	
$file3 = "Titel;Nachname;Vorname;Adresse;PLZ;Ort;Staat;Erstellungsdatum;\r\n{$titel};{$Nachname};{$Vorname};{$Adresse1};{$PLZ};{$Ort};{$Land};{$datum}";

    //Attachment
  $filename1 = "Datenbank Import {$Vornach}.csv";
  $filename2 = "GC Anmeldung {$Vornach}.csv";
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
  
  
  /**
  * Nutzt addslashes() für PHP 8.3-Kompatibilität
  */
  protected function quote_smart($value)
  {
    // Wenn es keine Zahl ist, in einfache Anführungszeichen und escapen
    if (!is_numeric($value)) {
        $escaped = addslashes($value);
        $value = "'{$escaped}'";
    }
    return $value;
  }

  
  
}
?>

