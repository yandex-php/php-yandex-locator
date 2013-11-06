<?php
namespace Yandex\Locator;

/**
 * Class Response
 * @package Yandex\Locator
 * @author Dmitry Kuznetsov <kuznetsov2d@gmail.com>
 * @license The MIT License (MIT)
 * @see http://api.yandex.ru/locator/doc/dg/api/geolocation-api_json.xml?lang=ru#id04EE5318
 */
class Response implements \Serializable
{
    /**
     * @var float Широта в градусах. Имеет десятичное представление с точностью до семи знаков после запятой
     */
    protected $_latitude;
    /**
     * @var float Долгота в градусах. Имеет десятичное представление с точностью до семи знаков после запятой
     */
    protected $_longitude;
    /**
     * @var float Высота над поверхностью мирового океана
     */
    protected $_altitude;
    /**
     * @var float Максимальное расстояние от указанной точки, в пределах которого находится мобильное устройство
     */
    protected $_precision;
    /**
     * @var float Максимальное отклонение от указанной высоты
     */
    protected $_altitudePrecision;
    /**
     * @var string Обозначение способа, которым определено местоположение
     */
    protected $_type;

    public function __construct(array $data)
    {
        if (is_array($data)) {
            $this->_latitude = isset($data['position']['latitude']) && !empty($data['position']['latitude']) ? (float)$data['position']['latitude'] : 0.0;
            $this->_longitude = isset($data['position']['longitude']) && !empty($data['position']['longitude']) ? (float)$data['position']['longitude'] : 0.0;
            $this->_altitude = isset($data['position']['altitude']) && !empty($data['position']['altitude']) ? (float)$data['position']['altitude'] : 0.0;
            $this->_precision = isset($data['position']['precision']) && !empty($data['position']['precision']) ? (float)$data['position']['precision'] : 0.0;
            $this->_altitudePrecision = isset($data['position']['altitude_precision']) && !empty($data['position']['altitude_precision']) ? (float)$data['position']['altitude_precision'] : 0.0;
            $this->_type = isset($data['position']['type']) && !empty($data['position']['type']) ? trim($data['position']['type']) : 0.0;
        }
    }

    /**
     * (PHP 5 >= 5.1.0)<br/>
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @see \Serializable::serialize()
     * @return string the string representation of the object or null
     */
    public function serialize()
    {
        $data = array();
        $reflection = new \ReflectionClass(get_called_class());
        foreach ($reflection->getProperties() as $property) {
            $property->setAccessible(true);
            $key = $property->getName();
            $value = $property->getValue($this);
            $data[$key] = $value;
        }
        return serialize($data);
    }

    /**
     * (PHP 5 >= 5.1.0)<br/>
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @see \Serializable::unserialize()
     * @param string $serialized The string representation of the object.
     * @return void
     */
    public function unserialize($serialized)
    {
        $serialized = unserialize($serialized);
        if (is_array($serialized)) {
            $reflection = new \ReflectionClass(get_called_class());
            foreach ($serialized as $key => $value) {
                $property = $reflection->getProperty($key);
                $property->setAccessible(true);
                $property->setValue($this, $value);
                if ($property->isPrivate() || $property->isProtected()) {
                    $property->setAccessible(false);
                }
            }
        }
    }

    /**
     * @return float
     */
    public function getAltitude()
    {
        return $this->_altitude;
    }

    /**
     * @return float
     */
    public function getAltitudePrecision()
    {
        return $this->_altitudePrecision;
    }

    /**
     * @return float
     */
    public function getLatitude()
    {
        return $this->_latitude;
    }

    /**
     * @return float
     */
    public function getLongitude()
    {
        return $this->_longitude;
    }

    /**
     * @return float
     */
    public function getPrecision()
    {
        return $this->_precision;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->_type;
    }
}