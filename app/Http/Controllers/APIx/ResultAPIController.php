<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateResultAPIRequest;
use App\Http\Requests\API\UpdateResultAPIRequest;
use App\Models\Result;
use App\Repositories\ResultRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class ResultController
 * @package App\Http\Controllers\API
 */

class ResultAPIController extends AppBaseController
{
    /** @var  ResultRepository */
    private $resultRepository;

    public function __construct(ResultRepository $resultRepo)
    {
        $this->resultRepository = $resultRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/results",
     *      summary="Get a listing of the Results.",
     *      tags={"Result"},
     *      description="Get all Results",
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
     *                  @SWG\Items(ref="#/definitions/Result")
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
        $results = $this->resultRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($results->toArray(), 'Results retrieved successfully');
    }

    /**
     * @param CreateResultAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/results",
     *      summary="Store a newly created Result in storage",
     *      tags={"Result"},
     *      description="Store Result",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Result that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Result")
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
     *                  ref="#/definitions/Result"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateResultAPIRequest $request)
    {
        $input = $request->all();

        $result = $this->resultRepository->create($input);

        return $this->sendResponse($result->toArray(), 'Result saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/results/{id}",
     *      summary="Display the specified Result",
     *      tags={"Result"},
     *      description="Get Result",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Result",
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
     *                  ref="#/definitions/Result"
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
        /** @var Result $result */
        $result = $this->resultRepository->find($id);

        if (empty($result)) {
            return $this->sendError('Result not found');
        }

        return $this->sendResponse($result->toArray(), 'Result retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateResultAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/results/{id}",
     *      summary="Update the specified Result in storage",
     *      tags={"Result"},
     *      description="Update Result",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Result",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Result that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Result")
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
     *                  ref="#/definitions/Result"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateResultAPIRequest $request)
    {
        $input = $request->all();

        /** @var Result $result */
        $result = $this->resultRepository->find($id);

        if (empty($result)) {
            return $this->sendError('Result not found');
        }

        $result = $this->resultRepository->update($input, $id);

        return $this->sendResponse($result->toArray(), 'Result updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/results/{id}",
     *      summary="Remove the specified Result from storage",
     *      tags={"Result"},
     *      description="Delete Result",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Result",
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
        /** @var Result $result */
        $result = $this->resultRepository->find($id);

        if (empty($result)) {
            return $this->sendError('Result not found');
        }

        $result->delete();

        return $this->sendSuccess('Result deleted successfully');
    }
}
