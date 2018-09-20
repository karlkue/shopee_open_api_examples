<?php
    $api_authorization_base_url = "https://partner.shopeemobile.com/api/v1/shop/auth_partner";
    $redirect_url = "https://www.google.com";
    
    $partner_id = xxxx;
    $shopid = xxxx;
    $key = "xxxx";
    
    $token_base_string = $key . $redirect_url;
    $token = hash('sha256', $token_base_string);

    $data = array(
        'id' => $partner_id,
        'token' => $token,
        'redirect' => $redirect_url
    );
    
    $api_authorization_url = $api_authorization_base_url . "?" . http_build_query($data);
    // echo $api_authorization_url . "\n";


    $get_order_by_status_url = "https://partner.shopeemobile.com/api/v1/orders/get";
    
    $data = array(
        'order_status' => 'READY_TO_SHIP',
        'partner_id' => $partner_id,
        'shopid' => $shopid,
        'timestamp' => time()
    );

    $sig_base_string = $get_order_by_status_url . "|" . json_encode($data);
    $sig = hash_hmac('sha256', $sig_base_string, $key);

    $header = [
        'Authorization' => $sig
    ];

    $options = array(
        'http' => array(
          'header'  => "Authorization: " . $sig,
          'method'  => 'POST',
          'content' => json_encode($data)
        ),
      );
    $context  = stream_context_create($options);
    $result = file_get_contents($get_order_by_status_url, false, $context);
    var_dump($result);
?>