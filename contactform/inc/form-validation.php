<?php
header('Content-Type: application/json');

session_start();

require_once('../inc/contactform.config.php');

require_once('../class/class.contactform.php');

$contactform_obj = new contactForm($cfg);

$post_required_element = array('element-3','element-4','element-5','element-6','element-7','element-8','element-9','element-10','element-11','element-12','element-20','element-21','element-24','element-25','element-26');

$post_required_email = array('element-13');

$post_required_promo = array('element-31');

//-------------------------------------------
// Patch to make it work again with PHP 8.3
// Author: frameless Media
// 08.04.2025 
//-------------------------------------------

if (isset($_POST['form_value_array']) && is_array($_POST['form_value_array'])) {
	foreach ($_POST['form_value_array'] as $value) {
		$contactform_obj->mergePost($value);
	}
}

// merge_post prüfen UND sicherstellen, dass es ein Array ist
if (isset($contactform_obj->merge_post) && is_array($contactform_obj->merge_post)) {
	foreach ($contactform_obj->merge_post as $key => $value) {
		$post_element_ids[] = $value['elementid'];
	}
} else {
		echo json_encode(['status' => 'error', 'message' => 'Fehlerhafte Datenübertragung.']);
		exit;
	}
// Erfolgreich verarbeitet – JSON-Antwort senden
echo json_encode([
	'status' => 'ok',
	'message' => 'Formular erfolgreich verarbeitet.'
]);
exit;


//-------------------------------------------
// end Patch
//-------------------------------------------

//-------------------------------------------
// original Code
//-------------------------------------------
/**
 * required files and elements are written in saveform.php
 * $post_required_element = array...
 * $post_required_email = array...
 * json error message for invalid captcha (captcha_img_string)
 */


/*
if($_POST['form_value_array'])
{
	foreach($_POST['form_value_array'] as $value)
	{
		$contactform_obj->mergePost($value);

	}
}


if($contactform_obj->merge_post)
{
	foreach($contactform_obj->merge_post as $key=>$value)
	{
		$post_element_ids[] = $value['elementid'];
	}
} else {
	exit;
}

*/
//-------------------------------------------
// end original Code
//-------------------------------------------

//print_r($post_element_id);

if($post_required_element && $contactform_obj->merge_post)
{
	
	foreach($post_required_element as $value)
	{
		foreach($contactform_obj->merge_post as $key=>$vvalue)
		{
			if($vvalue['elementid'] == $value)
			{
				if(!$vvalue['elementvalue'])
				{	//echo $value."\r\n";
					$json_error .= '{"elementid":"'.$value.'",  "errormessage": "'.addcslashes($contactform_obj->cfg['form_error_emptyfield'], '"').'"},';
					
				}
				break;
			}
		}


		// for empty checkboxes (checkbox values array not in merge_post)
		if(!in_array($value, $post_element_ids)){
			$json_error .= '{"elementid":"'.$value.'",  "errormessage": "'.addcslashes($contactform_obj->cfg['form_error_emptyfield'], '"').'"},';
		}
	}
}


//check Promo code;

if($post_required_promo && $contactform_obj->merge_post)
{
	
	foreach($post_required_promo as $value)
	{
		foreach($contactform_obj->merge_post as $key=>$vvalue)
		{
			if($vvalue['elementid'] == $value)
			{
				if($vvalue['elementvalue'] == "")
				{	}
				else if($vvalue['elementvalue'] == "Sommer-50%")
				{	}
				else if($vvalue['elementvalue'] == "KABARETT19")
				{	}
				else if($vvalue['elementvalue'] == "Promo16e2512")
				{	}
				else if($vvalue['elementvalue'] == "Promo16z2113")
				{	}
				else if($vvalue['elementvalue'] == "Promo16j5204")
				{	}
				else if($vvalue['elementvalue'] == "Promo16b3475")
				{	}
				else if($vvalue['elementvalue'] == "Promo16l8326")
				{	}
				else if($vvalue['elementvalue'] == "Promo16r6117")
				{	}
				else if($vvalue['elementvalue'] == "Promo16u7838")
				{	}
				else if($vvalue['elementvalue'] == "Promo16o1729")
				{	}
				else
				{	
					$json_error .= '{"elementid":"'.$value.'",  "errormessage": "'.addcslashes($contactform_obj->cfg['form_error_promo'], '"').'"},';
				}
				break;
			}
		}
	}
}

if($post_required_email)
{
	
	foreach($post_required_email as $value)
	{
		foreach($contactform_obj->merge_post as $key=>$vvalue)
		{
			if($vvalue['elementid'] == $value)
			{
				if(!$contactform_obj->isEmail($vvalue['elementvalue']))
				{
					$json_error .= '{"elementid":"'.$value.'",  "errormessage": "'.addcslashes($contactform_obj->cfg['form_error_invalidemailaddress'], '"').'"},';
	
				}
				break;
			}
		}
		
	}
}


if($json_error)
{
	$json_response = '{'
							.'"status":"nok",'
							.'"message":['.substr($json_error,0,-1).']'
							.'}';
} else{
	
	//print_r($_POST);
	$contactform_obj->sendMail();
	
	if($contactform_obj->cfg['form_emailnotificationinputid'])
	{
		foreach($contactform_obj->merge_post as $key=>$vvalue)
		{
			if($vvalue['elementid'] == $contactform_obj->cfg['form_emailnotificationinputid'])
			{
				$receipt_cfg['email_address'] = $vvalue['elementvalue'];
				//echo $vvalue['elementvalue'];
				break;
			}
		}

		$receipt_cfg['form_emailnotificationtitle'] = $contactform_obj->cfg['form_emailnotificationtitle'];
		$receipt_cfg['form_emailnotificationmessage'] = preg_replace('#<br(\s*)/>|<br(\s*)>#i', "\r\n",$contactform_obj->cfg['form_emailnotificationmessage']);
		$contactform_obj->sendMailReceipt($receipt_cfg);

	}
	
	$json_response = '{'
							.'"status":"ok",'
							.'"message":"'.addcslashes($contactform_obj->cfg['form_validationmessage'], '"').'"'
							.'}';
}

echo $json_response;
?>