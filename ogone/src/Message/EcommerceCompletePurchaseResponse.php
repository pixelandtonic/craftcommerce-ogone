<?php

namespace Omnipay\Ogone\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * Ogone Complete Purchase Request
 */
class EcommerceCompletePurchaseResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        if (isset($this->data['STATUS']) === false) {
            return false;
        }

        // Check if the Status is either 5/4/9
        if(in_array($this->data['STATUS'],array(5,4,9))){
            return true;
        }

        return false;
    }

    public function getTransactionReference()
    {
        return isset($this->data['ACCEPTANCE']) ? $this->data['ACCEPTANCE'] : null;
    }

}
