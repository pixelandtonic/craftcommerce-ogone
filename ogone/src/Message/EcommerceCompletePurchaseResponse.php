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
        } else {
            // Check if the Status is either 5/6/9
            if (str_replace(array(5,4,9), '', $this->data['STATUS']) == false) {
                return true;
            }
        }

        return false;
    }

    public function getTransactionReference()
    {
        return isset($this->data['ACCEPTANCE']) ? $this->data['ACCEPTANCE'] : null;
    }

}