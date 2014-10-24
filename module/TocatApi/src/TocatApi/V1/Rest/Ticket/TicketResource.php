<?php
namespace TocatApi\V1\Rest\Ticket;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class TicketResource extends AbstractResourceListener
{
    protected $_mockData
        = [
            1 => ['uid' => 1, 'ticket_id' => 17179, 'budget' => 0],
            2 => ['uid' => 2, 'ticket_id' => 17177, 'budget' => 1],
            3 => ['uid' => 3, 'ticket_id' => 15337, 'budget' => 2],
            4 => ['uid' => 4, 'ticket_id' => 16482, 'budget' => 5.5],
            5 => ['uid' => 5, 'ticket_id' => 10000, 'budget' => 10],
        ];

    /**
     * Create a resource
     *
     * @param  mixed $data
     *
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        return new ApiProblem(405, 'The POST method has not been defined');
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     *
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for individual resources');
    }

    /**
     * Delete a collection, or members of a collection
     *
     * @param  mixed $data
     *
     * @return ApiProblem|mixed
     */
    public function deleteList($data)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for collections');
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     *
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        $data = array_column($this->_mockData, 'uid', 'ticket_id');
        if (array_key_exists($id, $data)) {
            return $this->_mockData[$data[$id]];
        } else {
            return new ApiProblem(404, 'Not Found');
        }
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     *
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = array())
    {
        return $this->_mockData;
    }

    /**
     * Patch (partial in-place update) a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     *
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for individual resources');
    }

    /**
     * Replace a collection or members of a collection
     *
     * @param  mixed $data
     *
     * @return ApiProblem|mixed
     */
    public function replaceList($data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for collections');
    }

    /**
     * Update a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     *
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        if ($data->budget > 100) {
            return new ApiProblem(406, 'Budget value is not acceptable');
        }
        $dataSource = array_column($this->_mockData, 'uid', 'ticket_id');
        if (array_key_exists($id, $dataSource)) {
            $this->_mockData[$dataSource[$id]] = $data;
            return $this->_mockData[$dataSource[$id]];
        } else {
            return new ApiProblem(404, 'Not Found');
        }

    }
}
