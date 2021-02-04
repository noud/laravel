<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCompositionNounReferenceAPIRequest;
use App\Http\Requests\API\UpdateCompositionNounReferenceAPIRequest;
use App\Models\CompositionNounReference;
use App\Repositories\CompositionNounReferenceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class CompositionNounReferenceController
 * @package App\Http\Controllers\API
 */

class CompositionNounReferenceAPIController extends AppBaseController
{
    /** @var  CompositionNounReferenceRepository */
    private $compositionNounReferenceRepository;

    public function __construct(CompositionNounReferenceRepository $compositionNounReferenceRepo)
    {
        $this->compositionNounReferenceRepository = $compositionNounReferenceRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/compositionNounReferences",
     *      summary="Get a listing of the CompositionNounReferences.",
     *      tags={"CompositionNounReference"},
     *      description="Get all CompositionNounReferences",
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
     *                  @SWG\Items(ref="#/definitions/CompositionNounReference")
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
        $compositionNounReferences = $this->compositionNounReferenceRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($compositionNounReferences->toArray(), 'Composition Noun References retrieved successfully');
    }

    /**
     * @param CreateCompositionNounReferenceAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/compositionNounReferences",
     *      summary="Store a newly created CompositionNounReference in storage",
     *      tags={"CompositionNounReference"},
     *      description="Store CompositionNounReference",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CompositionNounReference that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CompositionNounReference")
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
     *                  ref="#/definitions/CompositionNounReference"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCompositionNounReferenceAPIRequest $request)
    {
        $input = $request->all();

        $compositionNounReference = $this->compositionNounReferenceRepository->create($input);

        return $this->sendResponse($compositionNounReference->toArray(), 'Composition Noun Reference saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/compositionNounReferences/{id}",
     *      summary="Display the specified CompositionNounReference",
     *      tags={"CompositionNounReference"},
     *      description="Get CompositionNounReference",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CompositionNounReference",
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
     *                  ref="#/definitions/CompositionNounReference"
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
        /** @var CompositionNounReference $compositionNounReference */
        $compositionNounReference = $this->compositionNounReferenceRepository->find($id);

        if (empty($compositionNounReference)) {
            return $this->sendError('Composition Noun Reference not found');
        }

        return $this->sendResponse($compositionNounReference->toArray(), 'Composition Noun Reference retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateCompositionNounReferenceAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/compositionNounReferences/{id}",
     *      summary="Update the specified CompositionNounReference in storage",
     *      tags={"CompositionNounReference"},
     *      description="Update CompositionNounReference",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CompositionNounReference",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CompositionNounReference that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CompositionNounReference")
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
     *                  ref="#/definitions/CompositionNounReference"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCompositionNounReferenceAPIRequest $request)
    {
        $input = $request->all();

        /** @var CompositionNounReference $compositionNounReference */
        $compositionNounReference = $this->compositionNounReferenceRepository->find($id);

        if (empty($compositionNounReference)) {
            return $this->sendError('Composition Noun Reference not found');
        }

        $compositionNounReference = $this->compositionNounReferenceRepository->update($input, $id);

        return $this->sendResponse($compositionNounReference->toArray(), 'CompositionNounReference updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/compositionNounReferences/{id}",
     *      summary="Remove the specified CompositionNounReference from storage",
     *      tags={"CompositionNounReference"},
     *      description="Delete CompositionNounReference",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CompositionNounReference",
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
        /** @var CompositionNounReference $compositionNounReference */
        $compositionNounReference = $this->compositionNounReferenceRepository->find($id);

        if (empty($compositionNounReference)) {
            return $this->sendError('Composition Noun Reference not found');
        }

        $compositionNounReference->delete();

        return $this->sendSuccess('Composition Noun Reference deleted successfully');
    }
}
