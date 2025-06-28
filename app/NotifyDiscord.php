<?php

namespace App;

use Illuminate\Support\Facades\Http;

class NotifyDiscord
{
    public static function notify($action_type, $name_data, $data_id)
    {
        $username = 'arthur';
        $password = '118885dd75d966da67c57e0719a79609d1';
        $baseUrl = 'https://6294-2804-14d-32a3-5184-d6e-e06f-7e71-b9de.ngrok-free.app';
        $cookieJar = tempnam(sys_get_temp_dir(), 'jenkins_cookies_');

        // Passo 1: Obter o crumb
        $crumbResponse = Http::withBasicAuth($username, $password)
            ->withOptions(['cookies' => new \GuzzleHttp\Cookie\FileCookieJar($cookieJar, true)])
            ->get("$baseUrl/crumbIssuer/api/xml", [
                'xpath' => 'concat(//crumbRequestField,":",//crumb)'
            ]);

        if ($crumbResponse->failed()) {
            throw new \Exception('Falha ao obter crumb: ' . $crumbResponse->body());
        }

        $crumb = $crumbResponse->body();

        // Passo 2: Fazer a requisição POST
        $response = Http::withBasicAuth($username, $password)
            ->withOptions(['cookies' => new \GuzzleHttp\Cookie\FileCookieJar($cookieJar, true)])
            ->withHeaders([$crumb])
            ->asForm()
            ->post("$baseUrl/job/notificationSearchDiscord/buildWithParameters", [
                'token' => '7877',
                'ACTION_TYPE' => $action_type,
                'USER_NAME' => auth()->user()->name,
                'USER_ID' => auth()->user()->id,
                'NAME_DATA' => $name_data,
                'ID_DATA' => $data_id
            ]);

        // Limpeza
        unlink($cookieJar);
    }
}
