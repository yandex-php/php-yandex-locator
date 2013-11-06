<?php
namespace Yandex\Locator;

/**
 * Class Transport
 * @package Yandex\Locator
 * @author Dmitry Kuznetsov <kuznetsov2d@gmail.com>
 * @license The MIT License (MIT)
 * @method array get(\string $url, array $params = null)
 * @method array post(\string $url, array $params = null)
 * @see http://api.yandex.ru/locator/doc/dg/api/geolocation-api_json.xml?lang=ru#id04110E86
 */
class Transport
{
    const METHOD_POST = 'POST';
    const METHOD_GET = 'GET';

    public function __construct()
    {
    }

    public function __call($method, $arguments)
    {
        $result = null;
        $requestMethod = strtoupper($method);
        if (!in_array($requestMethod, array(self::METHOD_POST, self::METHOD_GET))) {
            throw new Exception(sprintf("Method %s is not supported!", $method));
        } else {
            array_unshift($arguments, $requestMethod);
            $result = call_user_func_array(array($this, 'request'), $arguments);
        }
        return $result;
    }

    /**
     * @param string $method
     * @param string $url
     * @param string|null $data
     * @return array
     * @throws Exception
     */
    public function request($method, $url, $data = null)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        switch ($method) {
            case self::METHOD_POST:
                curl_setopt($curl, CURLOPT_POST, 1);
                if (!empty($data)) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, 'json=' . json_encode($data));
                }
                break;
            default:
                curl_setopt($curl, CURLOPT_HTTPGET, 1);
                break;
        }
        $data = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if (curl_errno($curl)) {
            curl_close($curl);
            throw new \Yandex\Locator\Exception\CurlError(curl_error($curl));
        }
        curl_close($curl);
        if (in_array($code, array(500, 502))) {
            $msg = strip_tags($data);
            throw new \Yandex\Locator\Exception\ServerError(trim($msg));
        }

        $result = array(
            'code' => $code,
            'data' => $data
        );
        return $result;
    }
}