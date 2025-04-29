<?php
$host = str_replace('www.', '', $_SERVER['HTTP_HOST']);

if ($host !== 'golf.frameless.at') {
	$cfg['email'] = 'm.kozak@hframeless.at';
} else {
	$cfg['email'] = 'sl.golf@hsv-wien.at';
}

// Gültiger Promocode
$cfg['promo_code'] = 'GOLF2025';

$cfg['form_validationmessage'] = 'Die Generierung Ihres Mitgliedsantrags war erfolgreich. Sie erhalten umgehend Ihr Anmeldeformular per E-Mail.<br /><br />Schönes Spiel, Ihr HSV wiengolf';
$cfg['form_error_captcha'] = 'Wert stimmt nicht &uuml;berein';
$cfg['form_error_emptyfield'] = 'Dieses Feld muss ausgefüllt werden.';
$cfg['form_error_promo'] = 'Promotioncode ist ung&uuml;ltig.';
$cfg['form_error_invalidemailaddress'] = 'Bitte tragen Sie eine gültige E-Mail Adresse ein';
$cfg['form_emailnotificationtitle'] = 'Herzlich Willkommen zur HSV Sektion Golf';
$cfg['form_emailnotificationmessage'] = 'neue Anmeldung
';
$cfg['form_emailnotificationinputid'] = 'element-13';

?>
