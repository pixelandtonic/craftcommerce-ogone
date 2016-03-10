<?php
namespace Commerce\Gateways\Omnipay;

use Commerce\Gateways\OffsiteGatewayAdapter;

class Ogone_GatewayAdapter extends OffsiteGatewayAdapter
{
    public function handle()
    {
        return "Ogone_Ecommerce";
    }
}
