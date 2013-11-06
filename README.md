API для работы с сервисом Яндекс.Локатор
========================================
Определение местоположения по IP

```php
// использовать встроенный автозагрузчик, либо через composer
require 'autoload.php';

$api = new \Yandex\Locator\Api('your_token');
$api->setIp('88.88.88.88');

try {
    $api->load();
} catch (\Yandex\Locator\Exception\CurlError $ex) {
    // ошибка curl
} catch (\Yandex\Locator\Exception\ServerError $ex) {
    // ошибка Яндекса
} catch (\Yandex\Locator\Exception $ex) {
    // какая-то другая ошибка (запроса, например)
}

$response = $api->getResponse();
// как определено положение
$response->getType();
// широта
$response->getLatitude();
// долгота
$response->getLongitude();

// сериализация/десереализация объекта
var_dump(unserialize(serialize($response)));

```