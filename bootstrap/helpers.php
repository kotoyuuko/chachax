<?php

define('CHACHAX_VERSION', '0.4.4');

if ( ! function_exists('route_class')) {
    function route_class()
    {
        return str_replace('.', '-', Route::currentRouteName());
    }
}

if ( ! function_exists('vmess_uri')) {
    function vmess_uri(App\Models\Service $service, App\Models\Node $node)
    {
        $settings = json_decode($node->settings, true);

        $data = array_merge([
            'v' => '2',
            'ps' => $node->name,
            'add' => $node->address,
            'port' => $node->port,
            'id' => $service->uuid,
            'aid' => $service->alter_id,
            'net' => $node->network,
            'type' => 'none',
            'host' => '',
            'path' => '',
            'tls' => $node->tls ? 'tls' : '',
        ], $settings ?? []);

        $json = json_encode($data);

        return 'vmess://' . base64_encode($json);
    }
}

if ( ! function_exists('eapay_add')) {
    function eapay_add() {
        $url = 'https://api.eapay.cc/v1/order/add';
    }
}

if ( ! function_exists('eapay_sign')) {
    function eapay_sign($data) {
        $key = config('eapay.appkey');
        ksort($data);
        $sign_str = '';
        foreach ($data as $k=>$v) {
            $sign_str .= "{$k}={$v}&";
        }
        $sign_str = "{$sign_str}key={$key}";
        return strtoupper(md5($sign_str));
    }
}

if ( ! function_exists('eapay_redirect')) {
    function eapay_redirect($no) {
        return redirect()->to('https://api.eapay.cc/v1/order/pay/no/' . $no);
    }
}
