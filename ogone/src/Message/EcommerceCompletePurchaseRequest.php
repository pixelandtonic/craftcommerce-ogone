<?php

namespace Omnipay\Ogone\Message;

use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Exception\InvalidRequestException;

/**
 * Ogone Complete Purchase Request
 */
class EcommerceCompletePurchaseRequest extends AbstractRequest
{

    public function getData()
    {
        return $this->httpRequest->query->all();
    }

    public function sendData($data)
    {
        return $this->response = new EcommerceCompletePurchaseResponse($this, $data);
    }

}
