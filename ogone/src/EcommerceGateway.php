<?php

namespace Omnipay\Ogone;

use Omnipay\Common\AbstractGateway;
use Omnipay\Ogone\Message\AuthorizeRequest;


/**
 * OGone Class
 * http://payment-services.ingenico.com/ogone/support/guides/integration%20guides/e-commerce
 */
class EcommerceGateway extends AbstractGateway
{
    public function getName()
    {
        return 'Ogone - e-Commerce';
    }

    public function getDefaultParameters()
    {
        return array(
            'pspId' => '',
            'shaIn' => '',
            'shaOut' => '',
            'shaAlgo' => 'sha1', // sha1, sha256, sha512
            'language' => 'en_US',
            'testMode' => false,
        );
    }

    public function getPspId()
    {
        return $this->getParameter('pspId');
    }

    public function setPspId($value)
    {
        return $this->setParameter('pspId', $value);
    }

    public function getShaIn()
    {
        return $this->getParameter('shaIn');
    }

    public function setShaIn($value)
    {
        return $this->setParameter('shaIn', $value);
    }

    public function getShaOut()
    {
        return $this->getParameter('shaOut');
    }

    public function setShaOut($value)
    {
        return $this->setParameter('shaOut', $value);
    }

    public function getShaAlgo()
    {
        return $this->getParameter('shaAlgo');
    }

    public function setShaAlgo($value)
    {
        return $this->setParameter('shaAlgo', $value);
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

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Ogone\Message\EcommercePurchaseRequest', $parameters);
    }

    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Ogone\Message\EcommerceCompletePurchaseRequest', $parameters);
    }
}
