<?php
namespace TocatApi\V1\Rpc\SetOrderTicket;

class SetOrderTicketControllerFactory
{
    public function __invoke($controllers)
    {
        return new SetOrderTicketController();
    }
}
