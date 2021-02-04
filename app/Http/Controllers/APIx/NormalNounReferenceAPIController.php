<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateNormalNounReferenceAPIRequest;
use App\Http\Requests\API\UpdateNormalNounReferenceAPIRequest;
use App\Models\NormalNounReference;
use App\Repositories\NormalNounReferenceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class NormalNounReferenceController
 * @package App\Http\Controllers\API
 */

class NormalNounReferenceAPIController extends AppBaseController
{
    /** @var  NormalNounReferenceRepository */
    private $normalNounReferenceRepository;

    public function __construct(NormalNounReferenceRepository $normalNounReferenceRepo)
    {
        $this->normalNounReferenceRepository = $normalNounReferenceRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/normalNounReferences",
     *      summary="Get a listing of the NormalNounReferences.",
     *      tags={"NormalNounReference"},
     *      description="Get all NormalNounReferences",
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
     *                  @SWG\Items(ref="#/definitions/NormalNounReference")
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
        $normalNounReferences = $this->normalNounReferenceRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($normalNounReferences->toArray(), 'Normal Noun References retrieved successfully');
    }

    /**
     * @param CreateNormalNounReferenceAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/normalNounReferences",
     *      summary="Store a newly created NormalNounReference in storage",
     *      tags={"NormalNounReference"},
     *      description="Store NormalNounReference",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="NormalNounReference that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/NormalNounReference")
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
     *                  ref="#/definitions/NormalNounReference"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateNormalNounReferenceAPIRequest $request)
    {
        $input = $request->all();

        $normalNounReference = $this->normalNounReferenceRepository->create($input);

        return $this->sendResponse($normalNounReference->toArray(), 'Normal Noun Reference saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/normalNounReferences/{id}",
     *      summary="Display the specified NormalNounReference",
     *      tags={"NormalNounReference"},
     *      description="Get NormalNounReference",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of NormalNounReference",
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
     *                  ref="#/definitions/NormalNounReference"
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
        /** @var NormalNounReference $normalNounReference */
        $normalNounReference = $this->normalNounReferenceRepository->find($id);

        if (empty($normalNounReference)) {
            return $this->sendError('Normal Noun Reference not found');
        }

        return $this->sendResponse($normalNounReference->toArray(), 'Normal Noun Reference retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateNormalNounReferenceAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/normalNounReferences/{id}",
     *      summary="Update the specified NormalNounReference in storage",
     *      tags={"NormalNounReference"},
     *      description="Update NormalNounReference",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of NormalNounReference",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="NormalNounReference that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/NormalNounReference")
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
     *                  ref="#/definitions/NormalNounReference"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateNormalNounReferenceAPIRequest $request)
    {
        $input = $request->all();

        /** @var NormalNounReference $normalNounReference */
        $normalNounReference = $this->normalNounReferenceRepository->find($id);

        if (empty($normalNounReference)) {
            return $this->sendError('Normal Noun Reference not found');
        }

        $normalNounReference = $this->normalNounReferenceRepository->update($input, $id);

        return $this->sendResponse($normalNounReference->toArray(), 'NormalNounReference updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/normalNounReferences/{id}",
     *      summary="Remove the specified NormalNounReference from storage",
     *      tags={"NormalNounReference"},
     *      description="Delete NormalNounReference",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of NormalNounReference",
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
        /** @var NormalNounReference $normalNounReference */
        $normalNounReference = $this->normalNounReferenceRepository->find($id);

        if (empty($normalNounReference)) {
            return $this->sendError('Normal Noun Reference not found');
        }

        $normalNounReference->delete();

        return $this->sendSuccess('Normal Noun Reference deleted successfully');
    }
}
