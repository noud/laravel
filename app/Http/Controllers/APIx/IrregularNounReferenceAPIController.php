<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateIrregularNounReferenceAPIRequest;
use App\Http\Requests\API\UpdateIrregularNounReferenceAPIRequest;
use App\Models\IrregularNounReference;
use App\Repositories\IrregularNounReferenceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class IrregularNounReferenceController
 * @package App\Http\Controllers\API
 */

class IrregularNounReferenceAPIController extends AppBaseController
{
    /** @var  IrregularNounReferenceRepository */
    private $irregularNounReferenceRepository;

    public function __construct(IrregularNounReferenceRepository $irregularNounReferenceRepo)
    {
        $this->irregularNounReferenceRepository = $irregularNounReferenceRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/irregularNounReferences",
     *      summary="Get a listing of the IrregularNounReferences.",
     *      tags={"IrregularNounReference"},
     *      description="Get all IrregularNounReferences",
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
     *                  @SWG\Items(ref="#/definitions/IrregularNounReference")
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
        $irregularNounReferences = $this->irregularNounReferenceRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($irregularNounReferences->toArray(), 'Irregular Noun References retrieved successfully');
    }

    /**
     * @param CreateIrregularNounReferenceAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/irregularNounReferences",
     *      summary="Store a newly created IrregularNounReference in storage",
     *      tags={"IrregularNounReference"},
     *      description="Store IrregularNounReference",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="IrregularNounReference that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/IrregularNounReference")
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
     *                  ref="#/definitions/IrregularNounReference"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateIrregularNounReferenceAPIRequest $request)
    {
        $input = $request->all();

        $irregularNounReference = $this->irregularNounReferenceRepository->create($input);

        return $this->sendResponse($irregularNounReference->toArray(), 'Irregular Noun Reference saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/irregularNounReferences/{id}",
     *      summary="Display the specified IrregularNounReference",
     *      tags={"IrregularNounReference"},
     *      description="Get IrregularNounReference",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of IrregularNounReference",
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
     *                  ref="#/definitions/IrregularNounReference"
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
        /** @var IrregularNounReference $irregularNounReference */
        $irregularNounReference = $this->irregularNounReferenceRepository->find($id);

        if (empty($irregularNounReference)) {
            return $this->sendError('Irregular Noun Reference not found');
        }

        return $this->sendResponse($irregularNounReference->toArray(), 'Irregular Noun Reference retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateIrregularNounReferenceAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/irregularNounReferences/{id}",
     *      summary="Update the specified IrregularNounReference in storage",
     *      tags={"IrregularNounReference"},
     *      description="Update IrregularNounReference",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of IrregularNounReference",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="IrregularNounReference that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/IrregularNounReference")
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
     *                  ref="#/definitions/IrregularNounReference"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateIrregularNounReferenceAPIRequest $request)
    {
        $input = $request->all();

        /** @var IrregularNounReference $irregularNounReference */
        $irregularNounReference = $this->irregularNounReferenceRepository->find($id);

        if (empty($irregularNounReference)) {
            return $this->sendError('Irregular Noun Reference not found');
        }

        $irregularNounReference = $this->irregularNounReferenceRepository->update($input, $id);

        return $this->sendResponse($irregularNounReference->toArray(), 'IrregularNounReference updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/irregularNounReferences/{id}",
     *      summary="Remove the specified IrregularNounReference from storage",
     *      tags={"IrregularNounReference"},
     *      description="Delete IrregularNounReference",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of IrregularNounReference",
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
        /** @var IrregularNounReference $irregularNounReference */
        $irregularNounReference = $this->irregularNounReferenceRepository->find($id);

        if (empty($irregularNounReference)) {
            return $this->sendError('Irregular Noun Reference not found');
        }

        $irregularNounReference->delete();

        return $this->sendSuccess('Irregular Noun Reference deleted successfully');
    }
}
