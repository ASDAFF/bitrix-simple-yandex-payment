# Прием платежей Яндекс.Деньгами без интеграции и заключения договора в 1С-Битрикс

## Документация
https://money.yandex.ru/i/forms/guide-to-custom-p2p-forms.pdf

## Настройка

Создаем файл для обработки уведомлений о платежах от Яндекс со следующим содержимым:

    <? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php"); ?>
    <? $APPLICATION->IncludeComponent("bitrix:sale.order.payment.receive", "", array(
        "PAY_SYSTEM_ID" => "4",
        "PERSON_TYPE_ID" => "1"
        ),
        false
    ); ?>
    <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>

На странице https://sp-money.yandex.ru/myservices/online.xml настраиваем уведомления о платежах.
Например, мы разместили вышеописанный скрипт по адресу http://yoursite.com/personal/order/payment/yandex.php, указываем этот адрес в верхнем поле, копируем секретный ключ и вставляем в настройки платежной системы в админке Битрикс. Также в настройках указываем номер счета-получателя платежей и указываем, что ps_amount это Сумма счета, а ps_order - Код заказа

Скрипты предоставляются по принципу «как есть» без каких-либо гарантий.
