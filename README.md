API для работы с сервисом Яндекс.Локатор
========================================
Сервис для определения местоположения по точкам доступа Wi-Fi и сотам мобильных сетей.
Позволяет предоставлять геоинформационные услуги на мобильных устройствах без GPS или при нахождении вне зоны приема GPS.
Местоположение определяется в виде круглой области, в пределах которой находится мобильное устройство.

Установка
---------
Возможна через composer, - для этого в необходимо прописать в зависимости "yandex/locator"


Как использовать
----------------

```php
// использовать встроенный автозагрузчик, либо через composer
require 'autoload.php';

$api = new \Yandex\Locator\Api('your_token');
// Определение местоположения по IP
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