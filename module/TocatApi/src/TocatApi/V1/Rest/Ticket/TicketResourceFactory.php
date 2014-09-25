<?php
namespace TocatApi\V1\Rest\Ticket;

class TicketResourceFactory
{
    public function __invoke($services)
    {
        return new TicketResource();
    }
}
