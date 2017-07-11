<?php
namespace Commerce\Gateways\Omnipay;

use Commerce\Gateways\OffsiteGatewayAdapter;

class Ogone_GatewayAdapter extends OffsiteGatewayAdapter
{
    public function handle()
    {
        // This is the omnipay class name compatible with `Omnipay::create`.
        // See https://github.com/thephpleague/omnipay-common/blob/master/src/Omnipay.php#L100-L103
        return "Ogone_Ecommerce";
    }
}
