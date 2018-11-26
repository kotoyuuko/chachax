<?php

define('CHACHAX_VERSION', '0.4.1');

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
