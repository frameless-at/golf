<?php
session_start();
header('Content-Type: application/json');

require_once('../inc/contactform.config.php');
require_once('../class/class.contactform.php');

$contactform_obj = new contactForm($cfg);

$post_required_element = [
	'element-3','element-4','element-5','element-6','element-7',
	'element-8','element-9','element-10','element-11','element-12',
	'element-20','element-21','element-24','element-25','element-26'
];
$post_required_email = ['element-13'];

// POST-Verarbeitung
if (isset($_POST['form_value_array']) && is_array($_POST['form_value_array'])) {
	foreach ($_POST['form_value_array'] as $value) {
		$contactform_obj->mergePost($value);
	}
}

// Übergabe-Check
if (!isset($contactform_obj->merge_post) || !is_array($contactform_obj->merge_post)) {
	echo json_encode(['status' => 'error', 'message' => 'Fehlerhafte Datenübertragung.']);
	exit;
}

$errors = [];

// Pflichtfelder prüfen
foreach ($post_required_element as $required_id) {
	$found = false;
	foreach ($contactform_obj->merge_post as $field) {
		if ($field['elementid'] === $required_id && trim($field['elementvalue']) !== '') {
			$found = true;
			break;
		}
	}
	if (!$found) {
		$errors[] = [
			'elementid'    => $required_id,
			'errormessage' => $cfg['form_error_emptyfield']
		];
	}
}

// E-Mail-Feld prüfen
foreach ($post_required_email as $email_id) {
	foreach ($contactform_obj->merge_post as $field) {
		if ($field['elementid'] === $email_id) {
			if (!filter_var(trim($field['elementvalue']), FILTER_VALIDATE_EMAIL)) {
				$errors[] = [
					'elementid'    => $email_id,
					'errormessage' => $cfg['form_error_invalidemailaddress']
				];
			}
		}
	}
}

// Promo-Code Prüfung (optional, case-insensitive)
$expected_promo_code = $cfg['promo_code'] ?? '';
foreach ($contactform_obj->merge_post as $field) {
	if ($field['elementid'] === 'element-31') {
		$promo_value = trim($field['elementvalue']);
		if ($promo_value !== '' && strcasecmp($promo_value, $expected_promo_code) !== 0) {
			$errors[] = [
				'elementid'    => 'element-31',
				'errormessage' => $cfg['form_error_promo']
			];
		}
	}
}

// Fehler zurückgeben
if (!empty($errors)) {
	echo json_encode(['status' => 'error', 'message' => $errors]);
	exit;
}

// Alles gut
echo json_encode(['status' => 'ok', 'message' => 'Formular erfolgreich verarbeitet.']);
exit;
