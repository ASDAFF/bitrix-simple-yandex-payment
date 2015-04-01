<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$psTitle = "Яндекс.Деньги";
$psDescription = "Оплата со счета на Яндекс.Деньгах";

$arPSCorrespondence = array(
		"ps_amount" => Array(
			"NAME" => "ps_amount",
			"VALUE" => "",
			"DESCR" => "Сумма к оплате",
			"TYPE" => "ORDER",
		),
		"ps_order" => Array(
			"NAME" => "ps_order",
			"VALUE" => "",
			"DESCR" => "Номер заказа",
			"TYPE" => "ORDER",
		),
		"ps_receiver" => Array(
			"NAME" => "ps_receiver",
			"VALUE" => "",
			"DESCR" => "Номер счета",
			"TYPE" => "",
		),
		"ps_key" => Array(
			"NAME" => "ps_key",
			"VALUE" => "",
			"DESCR" => "Секретный ключ",
			"TYPE" => "",
		),
	);
?>