<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAddAPIRequest;
use App\Http\Requests\API\UpdateAddAPIRequest;
use App\Models\Add;
use App\Repositories\AddRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class AddController
 * @package App\Http\Controllers\API
 */

class AddAPIController extends AppBaseController
{
    /** @var  AddRepository */
    private $addRepository;

    public function __construct(AddRepository $addRepo)
    {
        $this->addRepository = $addRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/adds",
     *      summary="Get a listing of the Adds.",
     *      tags={"Add"},
     *      description="Get all Adds",
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
     *                  @SWG\Items(ref="#/definitions/Add")
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
        $adds = $this->addRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($adds->toArray(), 'Adds retrieved successfully');
    }

    /**
     * @param CreateAddAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/adds",
     *      summary="Store a newly created Add in storage",
     *      tags={"Add"},
     *      description="Store Add",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Add that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Add")
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
     *                  ref="#/definitions/Add"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateAddAPIRequest $request)
    {
        $input = $request->all();

        $add = $this->addRepository->create($input);

        return $this->sendResponse($add->toArray(), 'Add saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/adds/{id}",
     *      summary="Display the specified Add",
     *      tags={"Add"},
     *      description="Get Add",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Add",
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
     *                  ref="#/definitions/Add"
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
        /** @var Add $add */
        $add = $this->addRepository->find($id);

        if (empty($add)) {
            return $this->sendError('Add not found');
        }

        return $this->sendResponse($add->toArray(), 'Add retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateAddAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/adds/{id}",
     *      summary="Update the specified Add in storage",
     *      tags={"Add"},
     *      description="Update Add",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Add",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Add that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Add")
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
     *                  ref="#/definitions/Add"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateAddAPIRequest $request)
    {
        $input = $request->all();

        /** @var Add $add */
        $add = $this->addRepository->find($id);

        if (empty($add)) {
            return $this->sendError('Add not found');
        }

        $add = $this->addRepository->update($input, $id);

        return $this->sendResponse($add->toArray(), 'Add updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/adds/{id}",
     *      summary="Remove the specified Add from storage",
     *      tags={"Add"},
     *      description="Delete Add",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Add",
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
        /** @var Add $add */
        $add = $this->addRepository->find($id);

        if (empty($add)) {
            return $this->sendError('Add not found');
        }

        $add->delete();

        return $this->sendSuccess('Add deleted successfully');
    }
}
