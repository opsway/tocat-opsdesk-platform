<?php
namespace OpsWay\TocatApi\V1\Rpc\GetBudget;

class GetBudgetControllerFactory
{
    public function __invoke($controllers)
    {
        return new GetBudgetController();
    }
}
