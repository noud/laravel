<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateReferenceAPIRequest;
use App\Http\Requests\API\UpdateReferenceAPIRequest;
use App\Models\Reference;
use App\Repositories\ReferenceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class ReferenceController
 * @package App\Http\Controllers\API
 */

class ReferenceAPIController extends AppBaseController
{
    /** @var  ReferenceRepository */
    private $referenceRepository;

    public function __construct(ReferenceRepository $referenceRepo)
    {
        $this->referenceRepository = $referenceRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/references",
     *      summary="Get a listing of the References.",
     *      tags={"Reference"},
     *      description="Get all References",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/Reference")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $references = $this->referenceRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($references->toArray(), 'References retrieved successfully');
    }

    /**
     * @param CreateReferenceAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/references",
     *      summary="Store a newly created Reference in storage",
     *      tags={"Reference"},
     *      description="Store Reference",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Reference that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Reference")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Reference"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateReferenceAPIRequest $request)
    {
        $input = $request->all();

        $reference = $this->referenceRepository->create($input);

        return $this->sendResponse($reference->toArray(), 'Reference saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/references/{id}",
     *      summary="Display the specified Reference",
     *      tags={"Reference"},
     *      description="Get Reference",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Reference",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Reference"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var Reference $reference */
        $reference = $this->referenceRepository->find($id);

        if (empty($reference)) {
            return $this->sendError('Reference not found');
        }

        return $this->sendResponse($reference->toArray(), 'Reference retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateReferenceAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/references/{id}",
     *      summary="Update the specified Reference in storage",
     *      tags={"Reference"},
     *      description="Update Reference",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Reference",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Reference that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Reference")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Reference"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateReferenceAPIRequest $request)
    {
        $input = $request->all();

        /** @var Reference $reference */
        $reference = $this->referenceRepository->find($id);

        if (empty($reference)) {
            return $this->sendError('Reference not found');
        }

        $reference = $this->referenceRepository->update($input, $id);

        return $this->sendResponse($reference->toArray(), 'Reference updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/references/{id}",
     *      summary="Remove the specified Reference from storage",
     *      tags={"Reference"},
     *      description="Delete Reference",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Reference",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var Reference $reference */
        $reference = $this->referenceRepository->find($id);

        if (empty($reference)) {
            return $this->sendError('Reference not found');
        }

        $reference->delete();

        return $this->sendSuccess('Reference deleted successfully');
    }
}
