<?php
//if (isset($_POST['pay_with_bkash'])) {
//  pay_with_bkash($_POST);
//}
function pay_with_bkash()
{
  $app_key = '4f6o0cjiki2rfm34kfdadl1eqq';
  $access_token = get_access_token();
  if ($access_token) {
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://tokenized.sandbox.bka.sh/v1.2.0-beta/tokenized/checkout/create',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => json_encode(array(
        "mode" => "0011",
        "payerReference" => "01619777283",
        "callbackURL" => "https://proshikkhon.com.bd/payment-success/",
        "merchantAssociationInfo" => "MI05MID54RF09123456One",
        "amount" => $_POST['amount'],
        "currency" => "BDT",
        "intent" => "sale",
        "merchantInvoiceNumber" => "Inv0125"
      )),
      CURLOPT_HTTPHEADER => array(
        'x-app-key: '.$app_key,
        'Content-Type: application/json',
        'Authorization: Bearer '.$access_token
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response;
    die();
  }

}
