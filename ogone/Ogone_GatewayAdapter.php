<?php
namespace Commerce\Gateways\Omnipay;

use Commerce\Gateways\BaseGatewayAdapter;

class Ogone_GatewayAdapter extends BaseGatewayAdapter
{
    public function handle()
    {
        return "Ogone_Ecommerce";
    }
}
