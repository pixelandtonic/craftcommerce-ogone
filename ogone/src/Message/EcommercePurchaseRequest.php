<?php

namespace Omnipay\Ogone\Message;

use Omnipay\Common\Message\AbstractRequest;

/**
 * OGone Authorize Request
 */
class EcommercePurchaseRequest extends AbstractRequest
{
    protected $liveEndpoint = 'https://secure.ogone.com/ncol/prod/orderstandard_utf8.asp';
    protected $testEndpoint = 'https://secure.ogone.com/ncol/test/orderstandard_utf8.asp';

    public function getPspId()
    {
        return $this->getParameter('pspId');
    }

    public function setPspId($value)
    {
        return $this->setParameter('pspId', $value);
    }

    public function getLanguage()
    {
        return $this->getParameter('language');
    }

    public function setLanguage($value)
    {
        return $this->setParameter('language', $value);
    }

    public function getTestMode()
    {
        return $this->getParameter('testMode');
    }

    public function setTestMode($value)
    {
        return $this->setParameter('testMode', $value);
    }

    public function getShaIn()
    {
        return $this->getParameter('shaIn');
    }

    public function setShaIn($value)
    {
        return $this->setParameter('shaIn', $value);
    }

    public function getShaAlgo()
    {
        return $this->getParameter('shaAlgo');
    }

    public function setShaAlgo($value)
    {
        return $this->setParameter('shaAlgo', $value);
    }

    public function getData()
    {
        $this->validate('amount', 'returnUrl');

        $data = array();
        $data['PSPID'] = $this->getPspId();
        $data['ORDERID'] = $this->getTransactionId();
        $data['AMOUNT'] = number_format($this->getAmount() * 100, 0, '', '');
        $data['CURRENCY'] = $this->getCurrency();
        $data['LANGUAGE'] = $this->getLanguage();
        $data['OPERATION'] = 'SAL';

        //----------------------------------------
        // Return URLs
        //----------------------------------------
        $data['ACCEPTURL'] = $this->getReturnUrl();
        $data['DECLINEURL'] = $this->getCancelUrl();
        $data['CANCELURL'] = $this->getCancelUrl();
        //$data['EXCEPTIONURL'] = $this->getCancelUrl();

        //----------------------------------------
        // Force Payment Method
        //----------------------------------------
        if ($this->httpRequest->request->get('ogone_pm')) {
            $data['PM'] = $this->httpRequest->request->get('ogone_pm');
        }

        if ($this->httpRequest->request->get('ogone_brand')) {
            $data['BRAND'] = $this->httpRequest->request->get('ogone_brand');
        }

        //----------------------------------------
        // Optional
        //----------------------------------------
        if ($this->getCard()) {
            $data['CN'] = $this->getCard()->getName();
            $data['EMAIL'] = $this->getCard()->getEmail();
            $data['OWNERADDRESS'] = $this->getCard()->getAddress1();
            $data['OWNERZIP'] = $this->getCard()->getPostcode();
            $data['OWNERTOWN'] = $this->getCard()->getCity();
            $data['OWNERCTY'] = $this->getCard()->getCountry();
            $data['OWNERTELNO'] = $this->getCard()->getPhone();
        }

        //----------------------------------------
        // SHAIN Secret Code (Required)
        //----------------------------------------
        $shaIn = $this->getShaIn();

        if (!$shaIn) {
            throw new InvalidRequestException('Missing required shaIn');
        }

        // All parameters have to be arranged alphabetically
        ksort($data);
        array_map('trim', $data);

        //----------------------------------------
        // Generate Security Hash
        // http://payment-services.ingenico.com/ogone/support/guides/integration%20guides/e-commerce/security-pre-payment-check
        //----------------------------------------
        $shaString = '';

        foreach ($data as $key => $val) {
            // Parameters that do not have a value should NOT be included in the string to hash
            if (!$val) continue;

            $shaString .= "{$key}=$val{$shaIn}";
        }

        // All three SHA algo are supported
        switch ($this->getShaAlgo()) {
            case 'sha256':
                $shaSign = hash('sha256', $shaString);
                break;
            case 'sha512':
                $shaSign = hash('sha512', $shaString);
                break;
            default:
                $shaSign = sha1($shaString);
                break;
        }

        $data['SHASIGN'] = $shaSign;

        return $data;
    }

    public function sendData($data)
    {
        return $this->response = new EcommercePurchaseResponse($this, $data);
    }

    public function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }
}