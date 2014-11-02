<?php
namespace OpsWay\TocatApi\V1\Rpc\ListOrders;

class ListOrdersControllerFactory
{
    public function __invoke($controllers)
    {
        return new ListOrdersController();
    }
}
