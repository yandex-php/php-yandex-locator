<?php
namespace Yandex\Locator;

/**
 * Class Response
 * @package Yandex\Locator
 * @author Dmitry Kuznetsov <kuznetsov2d@gmail.com>
 * @license The MIT License (MIT)
 * @see http://api.yandex.ru/locator/doc/dg/api/geolocation-api_json.xml?lang=ru#id04EE5318
 */
class Response
{
    /**
     * @var array Исходные данные
     */
    protected $_data;

    public function __construct(array $data)
    {
        $this->_data = $data;
    }

    public function __sleep()
    {
        return array('_data');
    }

    /**
     * Высота над поверхностью мирового океана
     * @return float|null
     */
    public function getAltitude()
    {
        $result = null;
        if (isset($data['position']['altitude']) && !empty($data['position']['altitude'])) {
            $result = (float)$data['position']['altitude'];
        }
        return $result;
    }

    /**
     * Максимальное отклонение от указанной высоты
     * @return float|null
     */
    public function getAltitudePrecision()
    {
        $result = null;
        if (isset($data['position']['altitude_precision']) && !empty($data['position']['altitude_precision'])) {
            $result = (float)$data['position']['altitude_precision'];
        }
        return $result;
    }

    /**
     * Широта в градусах. Имеет десятичное представление с точностью до семи знаков после запятой
     * @return float|null
     */
    public function getLatitude()
    {
        $result = null;
        if (isset($data['position']['latitude']) && !empty($data['position']['latitude'])) {
            $result = (float)$data['position']['latitude'];
        }
        return $result;
    }

    /**
     * Долгота в градусах. Имеет десятичное представление с точностью до семи знаков после запятой
     * @return float|null
     */
    public function getLongitude()
    {
        $result = null;
        if (isset($data['position']['longitude']) && !empty($data['position']['longitude'])) {
            $result = (float)$data['position']['longitude'];
        }
        return $result;
    }

    /**
     * Максимальное расстояние от указанной точки, в пределах которого находится мобильное устройство
     * @return float|null
     */
    public function getPrecision()
    {
        $result = null;
        if (isset($data['position']['precision']) && !empty($data['position']['precision'])) {
            $result = (float)$data['position']['precision'];
        }
        return $result;
    }

    /**
     * Обозначение способа, которым определено местоположение
     * @return string|null
     */
    public function getType()
    {
        $result = null;
        if (isset($data['position']['type']) && !empty($data['position']['type'])) {
            $result = trim($data['position']['type']);
        }
        return $result;
    }
}