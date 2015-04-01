<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); 

$ps_key      = trim(CSalePaySystemAction::GetParamValue("ps_key"));
$ps_receiver = trim(CSalePaySystemAction::GetParamValue("ps_receiver"));
$ps_amount   = trim(CSalePaySystemAction::GetParamValue("ps_amount"));
$ps_order    = trim(CSalePaySystemAction::GetParamValue("ps_order"));

$data['withdraw_amount']    = trim($_REQUEST,"withdraw_amount");
$data['sender']             = trim($_REQUEST,"sender");
$data['sha1_hash']          = trim($_REQUEST,"sha1_hash");
$data['label']              = trim($_REQUEST,"label");
$data['operation_id']       = trim($_REQUEST,"operation_id");

// data hash
$ps_arr = array(
    "notification_type",
    "operation_id",
    "amount",
    "currency",
    "datetime",
    "sender",
    "codepro",
    //"notification_secret",
    //"label",
);

foreach ($ps_arr as $key) {
    $ps_p_sign .= trim($_REQUEST[$key]) . "&";
}
$ps_p_sign .= $ps_key . "&" . $data['label'];
$ps_hash = sha1($ps_p_sign);

if (strtolower($data['sha1_hash']) == strtolower($ps_hash)) {
    if (strpos($data['label'], "ORDER#") !== false) {
        // order info
        $ps_order = explode("#", $data['label']);
        $ps_order = $ps_order[1];
        $arOrder = CSaleOrder::GetByID($ps_order);
        
        if (abs(intval($arOrder["PRICE"]) - intval($data['withdraw_amount'])) <= 1) {
        	CSaleOrder::PayOrder($arOrder["ID"], "Y");
        	CSaleOrder::StatusOrder($arOrder["ID"], 'P');
        	
        	$arFields = array(
        		"PS_STATUS" => "Y",
        		"PAYED" => "Y",
        		"PS_STATUS_CODE" => "Y",
        		"PS_STATUS_DESCRIPTION" => print_r($_REQUEST, true),
        		"PS_STATUS_MESSAGE" => "Оплачено",
        		"PS_SUM" => $data['withdraw_amount'],
        		"PS_CURRENCY" => 'RUB',
        		"PS_RESPONSE_DATE" => Date(CDatabase::DateFormatToPHP(CLang::GetDateFormat("FULL", LANG))),
        		"PAY_VOUCHER_NUM" => $data['operation_id'],
        		"PAY_VOUCHER_DATE" => Date(CDatabase::DateFormatToPHP(CLang::GetDateFormat("FULL", LANG))),
        		"USER_ID" => $arOrder["USER_ID"],
        	);
    
        	CSaleOrder::Update($arOrder["ID"], $arFields);
        	
        	die("OK");
        }
        else die("Неверная сумма оплаты");
    }
    else die("Неверная метка платежа");
}
else die("Неверный хеш");
?>