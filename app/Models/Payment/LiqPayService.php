<?php
/*
 * Developed by
 * @author Vasyl Kovalov <raid3r81@gmail.com>
 * Date: 12.06.2023
 */

namespace App\Models\Payment;

use App\Models\Payment\LiqPay;

class LiqPayService
{

    const API_VERSION = '3';

    /**
     * @var string
     */
    public $publicKey;
    /**
     * @var string
     */
    public $privateKey;
    /**
     * @var string
     */
    public $language = 'uk';
    /**
     * @var string
     */
    public $currency = 'UAH';
    /**
     * @var string
     */
    public $payTypes = 'card, privat24, liqpay, apay, gpay';

    public function setLanguage($lang): LiqPayService
    {
        switch ($lang) {
            case 'en-US':
                $this->language = 'en';
                break;
            case 'uk-UA':
            case 'ua':
            case 'uk':
                $this->language = 'uk';
                break;
            case 'ru-RU':
            case 'ru':
                $this->language = 'ru';
                break;
            default:
                $this->language = 'uk';
        }

        return $this;
    }

    public function setContext($publicKey, $privateKey): LiqPayService
    {
        $this->publicKey  = $publicKey;
        $this->privateKey = $privateKey;

        return $this;
    }

    /**
     * @param $params
     *
     * @return array
     * ['url', 'data', 'signature']
     */
    public function getFormData($params): array
    {
        return $this->getLiqPay()->cnb_form_raw($params);
    }

    /**
     * @return LiqPay
     */
    protected function getLiqPay(): LiqPay
    {
        return new LiqPay($this->publicKey, $this->privateKey, $api_url = null);
    }

    public function generatePayParams($orderId, $amount, string $description): array
    {
        return [
            'action'      => 'pay',
            'version'     => self::API_VERSION,
            'public_key'  => $this->publicKey,
            'currency'    => $this->currency,
            'amount'      => $amount,
            'description' => $description,
            'order_id'    => $orderId,
            'pay_types'   => $this->payTypes,
        ];
    }

    public function encodeParams(array $params): string
    {
        return $this->getLiqPay()->encode_params($params);
    }

    public function decodeParams(string $data): array
    {
        return json_decode(base64_decode($data), true);
    }

    public function validateData(string $data, string $signature): bool
    {
        return $this->getSignature($data) === $signature;
    }

    public function getSignature(string $data): string
    {
        return $this->getLiqPay()->getSignature($data);
    }

    /**
     * Call api
     *
     * @param string $path
     * @param array  $params
     *
     * @return array Response
     */
    public function api(string $path, array $params): array
    {
        return (array)$this->getLiqPay()->api($path, $params);
    }

    public function prepareParams(array $params): array
    {
        $params['public_key'] = $this->publicKey;
        $params['version']    = self::API_VERSION;

        return $params;
    }
}
