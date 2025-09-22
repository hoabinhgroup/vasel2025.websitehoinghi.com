<?php

namespace Modules\Registration\Traits;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

trait SendRegistrationEmail
{


    protected function sending($data, $template)
    {

        $smtp = config('registration.email');

        // send email api
        $postData = array(
            'sending_server' => $smtp['sending_server'],
            'email' => $data['to'] ?? $data['email'],
            'from_email' => $smtp['from_email'],
            'from_name' => config('registration.email.from_name'),
            'subject' => $data['subject'] ?? $smtp['subject'],
            'reply_to' => $smtp['reply_to'],
            'addCC' => $smtp['cc'],
            'template' => $template
        );

        $this->sendEmailViaApi(config('registration.email.endpoint'), $postData, 'POST');
        return true;
    }

    protected function sendEmailViaApi($url, $data = [], $method = 'GET')
    {
        try {
            if ($method === 'POST' || $method === 'PUT' || $method === 'PATCH') {
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                ])->$method($url, $data);
            } elseif ($method === 'GET') {
                $response = Http::get($url, $data);
            }

            // Trả về kết quả dưới dạng mảng
            return $response->json();
        } catch (\Exception $e) {
            // Xử lý lỗi nếu có
            return ['error' => $e->getMessage()];
        }
    }

    public function parseEmailContent($content, $data)
    {
        $parsed = preg_replace_callback('/{{$(.*?)}}/', function ($matches) use ($data) {
            list($param, $index) = $matches;
            if (isset($data[$index])) {
                return $data[$index];
            }
        }, $content);

        return $parsed;
    }
}
