<?php
namespace Yandex\Locator;

/**
 * Class Api
 * @package Yandex\Locator
 * @author Dmitry Kuznetsov <kuznetsov2d@gmail.com>
 * @license The MIT License (MIT)
 * @see http://api.yandex.ru/locator/
 */
class Api
{
    /**
     * @var string Версия используемого api
     */
    protected $_version = '1.0';
    /**
     * @var array
     */
    protected $_filters = array();
    /**
     * @var \Yandex\Locator\Response|null
     */
    protected $_response;

    /**
     * @see http://api.yandex.ru/maps/form.xml
     * @param string $token
     * @param null|string $version
     */
    public function __construct($token, $version = null)
    {
        if (!empty($version)) {
            $this->_version = (string)$version;
        }
        $this->_transport = new \Yandex\Locator\Transport();
        $this->_filters['common'] = array(
            'version' => $this->_version,
            'api_key' => $token
        );
        $this->reset();
    }

    /**
     * Сброс фильтров
     * @return self
     */
    public function reset()
    {
        $this->_filters['gsm_cells'] = array();
        $this->_filters['wifi_networks'] = array();
        $this->_filters['ip'] = array();
        return $this;
    }

    /**
     * @throws Exception
     * @return self
     */
    public function load()
    {
        $apiUrl = 'http://api.lbs.yandex.net/geolocation';
        $data = $this->_transport->post($apiUrl, $this->_filters);
        if ($data['code'] == 200) {
            $tmp = json_decode($data['data'], true);
            if (!is_null($tmp)) {
                $this->_response = new \Yandex\Locator\Response($tmp);
            } else {
                $msg = sprintf('Bad response: %s', var_export($data, true));
                throw new \Yandex\Locator\Exception(trim($msg));
            }
        } else {
            $msg = strip_tags($data['data']);
            throw new \Yandex\Locator\Exception(trim($msg), $data['code']);
        }
        return $this;
    }

    /**
     * @return null|Response
     */
    public function getResponse()
    {
        return $this->_response;
    }

    /**
     * Добавление описание соты
     * @param int $countryCode Код страны (MCC, Mobile Country Code)
     * @param int $operatorId Код сети мобильной связи (MNC, Mobile Network Code).
     * @param int $cellId Идентификатор соты (CID, Cell Identifier)
     * @param int $lac Код местоположения (LAC, Location area code).
     * @param null|int $signalStrength Уровень сигнала (dBm). Элемент зарезервирован
     * @param null|int $age Время в миллисекундах, прошедшее с момента получения данных. Элемент зарезервирован
     * @return self
     */
    public function setGsmCells($countryCode, $operatorId, $cellId, $lac, $signalStrength = null, $age = null)
    {
        $data = array(
            'countrycode' => $countryCode,
            'operatorid' => $operatorId,
            'cellid' => $cellId,
            'lac' => $lac
        );
        if (!empty($signalStrength)) {
            $data['signal_strength'] = $signalStrength;
        }
        if (!empty($age)) {
            $data['age'] = $age;
        }
        $this->_filters['gsm_cells'][] = $data;
        return $this;
    }

    /**
     * Описание wi-fi сети
     * @param string $mac MAC-адрес в символьном представлении. Байты могут разделяться дефисом, точкой, двоеточием или указываться слитно без разделителя
     * @param null|int $signalStrength Уровень сигнала (dBm). Элемент зарезервирован
     * @param null|int $age Время в миллисекундах, прошедшее с момента получения данных. Элемент зарезервирован
     * @return self
     */
    public function setWiFiNetworks($mac, $signalStrength = null, $age = null)
    {
        $data = array(
            'mac' => (string)$mac
        );
        if (!empty($signalStrength)) {
            $data['signal_strength'] = $signalStrength;
        }
        if (!empty($age)) {
            $data['age'] = $age;
        }
        $this->_filters['wifi_networks'][] = $data;
        return $this;
    }

    /**
     * Описание IP
     * @param string $ip IP-адрес мобильного устройства
     * @return self
     */
    public function setIp($ip)
    {
        $this->_filters['ip']['address_v4'] = (string)$ip;
        return $this;
    }
}