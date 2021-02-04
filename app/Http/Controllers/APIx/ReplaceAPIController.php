<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateReplaceAPIRequest;
use App\Http\Requests\API\UpdateReplaceAPIRequest;
use App\Models\Replace;
use App\Repositories\ReplaceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class ReplaceController
 * @package App\Http\Controllers\API
 */

class ReplaceAPIController extends AppBaseController
{
    /** @var  ReplaceRepository */
    private $replaceRepository;

    public function __construct(ReplaceRepository $replaceRepo)
    {
        $this->replaceRepository = $replaceRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/replaces",
     *      summary="Get a listing of the Replaces.",
     *      tags={"Replace"},
     *      description="Get all Replaces",
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
     *                  @SWG\Items(ref="#/definitions/Replace")
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
        $replaces = $this->replaceRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($replaces->toArray(), 'Replaces retrieved successfully');
    }

    /**
     * @param CreateReplaceAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/replaces",
     *      summary="Store a newly created Replace in storage",
     *      tags={"Replace"},
     *      description="Store Replace",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Replace that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Replace")
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
     *                  ref="#/definitions/Replace"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateReplaceAPIRequest $request)
    {
        $input = $request->all();

        $replace = $this->replaceRepository->create($input);

        return $this->sendResponse($replace->toArray(), 'Replace saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/replaces/{id}",
     *      summary="Display the specified Replace",
     *      tags={"Replace"},
     *      description="Get Replace",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Replace",
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
     *                  ref="#/definitions/Replace"
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
        /** @var Replace $replace */
        $replace = $this->replaceRepository->find($id);

        if (empty($replace)) {
            return $this->sendError('Replace not found');
        }

        return $this->sendResponse($replace->toArray(), 'Replace retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateReplaceAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/replaces/{id}",
     *      summary="Update the specified Replace in storage",
     *      tags={"Replace"},
     *      description="Update Replace",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Replace",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Replace that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Replace")
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
     *                  ref="#/definitions/Replace"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateReplaceAPIRequest $request)
    {
        $input = $request->all();

        /** @var Replace $replace */
        $replace = $this->replaceRepository->find($id);

        if (empty($replace)) {
            return $this->sendError('Replace not found');
        }

        $replace = $this->replaceRepository->update($input, $id);

        return $this->sendResponse($replace->toArray(), 'Replace updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/replaces/{id}",
     *      summary="Remove the specified Replace from storage",
     *      tags={"Replace"},
     *      description="Delete Replace",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Replace",
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
        /** @var Replace $replace */
        $replace = $this->replaceRepository->find($id);

        if (empty($replace)) {
            return $this->sendError('Replace not found');
        }

        $replace->delete();

        return $this->sendSuccess('Replace deleted successfully');
    }
}
