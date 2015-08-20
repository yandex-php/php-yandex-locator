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
        if (isset($this->_data['position']['altitude']) && !empty($this->_data['position']['altitude'])) {
            $result = (float)$this->_data['position']['altitude'];
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
        if (isset($this->_data['position']['altitude_precision']) && !empty($this->_data['position']['altitude_precision'])) {
            $result = (float)$this->_data['position']['altitude_precision'];
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
        if (isset($this->_data['position']['latitude']) && !empty($this->_data['position']['latitude'])) {
            $result = (float)$this->_data['position']['latitude'];
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
        if (isset($this->_data['position']['longitude']) && !empty($this->_data['position']['longitude'])) {
            $result = (float)$this->_data['position']['longitude'];
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
        if (isset($this->_data['position']['precision']) && !empty($this->_data['position']['precision'])) {
            $result = (float)$this->_data['position']['precision'];
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
        if (isset($this->_data['position']['type']) && !empty($this->_data['position']['type'])) {
            $result = trim($this->_data['position']['type']);
        }
        return $result;
    }
}