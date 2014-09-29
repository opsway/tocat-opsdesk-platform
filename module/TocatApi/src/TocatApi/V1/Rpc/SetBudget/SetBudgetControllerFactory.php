<?php
namespace TocatApi\V1\Rpc\SetBudget;

class SetBudgetControllerFactory
{
    public function __invoke($controllers)
    {
        return new SetBudgetController();
    }
}
