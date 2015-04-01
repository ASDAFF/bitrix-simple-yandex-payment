<?
$ps_receiver = trim(CSalePaySystemAction::GetParamValue("ps_receiver"));
$ps_amount = trim(CSalePaySystemAction::GetParamValue("ps_amount"));
$ps_order = trim(CSalePaySystemAction::GetParamValue("ps_order"));

CModule::IncludeMOdule('sale');

$arOrder = CSaleOrder::GetByID($ps_order);

if ($arOrder["PAYED"] == "Y")
    LocalRedirect("/personal/orders/");

$data = array(
    "receiver" => $ps_receiver,
    "formcomment" => "Оплата заказа №" . $ps_order,
    "short-dest" => "Оплата заказа №" . $ps_order,
    "quickpay-form" => "shop",
    "targets" => "Оплата заказа №" . $ps_order,
    "sum" => $ps_amount,
    "label" => "ORDER#" . $ps_order,
    "paymentType" => "PC",
);
?>

<form name="order" action="https://money.yandex.ru/quickpay/confirm.xml" method="post" id="sale_payment">	
<?	
	foreach($data as $key => $value) {
		if (strlen($value) > 0) {?>
        	<input type="hidden" name="<?=$key?>" value="<?=htmlspecialchars($value)?>"/>
			<?
    	}
	}	
?>
</form>
<a href="javascript: void(0);" onclick="document.getElementById('sale_payment').submit(); return false;">Оплатить заказ</a>