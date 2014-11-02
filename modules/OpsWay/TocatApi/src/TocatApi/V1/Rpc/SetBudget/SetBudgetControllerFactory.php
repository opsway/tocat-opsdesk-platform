<?php
namespace OpsWay\TocatApi\V1\Rpc\SetBudget;

class SetBudgetControllerFactory
{
    public function __invoke($controllers)
    {
        return new SetBudgetController();
    }
}
