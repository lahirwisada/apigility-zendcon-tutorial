<?php
namespace Conference\V1\Rest\Talk;

use Traversable;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class TalkResource extends AbstractResourceListener
{
    protected $mapper;

    /**
     * Constructor
     *
     * @param TalkMapper $mapper
     */
    public function __construct(TalkMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        $data   = $this->convertDataToArray($data);
        $result = $this->mapper->addTalk($data);
        if (! $result) {
            return new ApiProblem(422, 'I cannot create a new talk');
        }
        return $result;
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        $result = $this->mapper->deleteTalk($id);
        if (! $result) {
            return new ApiProblem(404, 'The talk ID specified does not exist');
        }
        return true;
    }

    /**
     * Delete a collection, or members of a collection
     *
     * @param  mixed $data
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
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        return $this->mapper->getTalk($id);
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        return $this->mapper->getAllTalks();
    }

    /**
     * Patch (partial in-place update) a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        $data   = $thsi->convertDataToArray($data);
        $result = $this->mapper->updateTalk($id, $data);
        if (! $result) {
            return new ApiProblem(404, 'The talk ID specified does not exist');
        }
        return $result;
    }

    /**
     * Replace a collection or members of a collection
     *
     * @param  mixed $data
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
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for individual resources');
    }

    private function convertDataToArray($data)
    {
        if (is_array($data)) {
            return $data;
        }

        if ($data instanceof Traversable) {
            return $data;
        }

        if (is_scalar($data)) {
            return [];
        }

        $keys = ['id', 'title', 'abstract', 'day', 'start_time', 'end_time'];
        $copy = [];

        foreach ($keys as $key) {
            if (isset($data->{$key})) {
                $copy[$key] = $data->{$key};
            }
        }

        return $copy;
    }
}
