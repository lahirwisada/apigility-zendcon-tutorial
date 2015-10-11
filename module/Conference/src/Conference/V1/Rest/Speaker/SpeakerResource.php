<?php
namespace Conference\V1\Rest\Speaker;

use Traversable;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class SpeakerResource extends AbstractResourceListener
{
    /**
     * @var SpeakerMapper
     */
    protected $mapper;

    /**
     * Constructor
     *
     * @param SpeakerMapper $mapper
     */
    public function __construct(SpeakerMapper $mapper)
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
        $data   = $this->getInputFilter()->getValues();
        $result = $this->mapper->addSpeaker($data);
        if (! $result) {
            return new ApiProblem(422, 'I cannot create a new speaker');
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
        $result = $this->mapper->deleteSpeaker($id);
        if (! $result) {
            return new ApiProblem(404, 'The speaker ID specified does not exist');
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
        return $this->mapper->getSpeaker($id);
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        return $this->mapper->getAllSpeakers();
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
        $data   = $this->getInputFilter()->getValues();
        $result = $this->mapper->updateSpeaker($id, $data);
        if (! $result) {
            return new ApiProblem(404, 'The speaker ID specified does not exist');
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
}
