<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateIrregularProxyNounReferenceAPIRequest;
use App\Http\Requests\API\UpdateIrregularProxyNounReferenceAPIRequest;
use App\Models\IrregularProxyNounReference;
use App\Repositories\IrregularProxyNounReferenceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class IrregularProxyNounReferenceController
 * @package App\Http\Controllers\API
 */

class IrregularProxyNounReferenceAPIController extends AppBaseController
{
    /** @var  IrregularProxyNounReferenceRepository */
    private $irregularProxyNounReferenceRepository;

    public function __construct(IrregularProxyNounReferenceRepository $irregularProxyNounReferenceRepo)
    {
        $this->irregularProxyNounReferenceRepository = $irregularProxyNounReferenceRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/irregularProxyNounReferences",
     *      summary="Get a listing of the IrregularProxyNounReferences.",
     *      tags={"IrregularProxyNounReference"},
     *      description="Get all IrregularProxyNounReferences",
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
     *                  @SWG\Items(ref="#/definitions/IrregularProxyNounReference")
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
        $irregularProxyNounReferences = $this->irregularProxyNounReferenceRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($irregularProxyNounReferences->toArray(), 'Irregular Proxy Noun References retrieved successfully');
    }

    /**
     * @param CreateIrregularProxyNounReferenceAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/irregularProxyNounReferences",
     *      summary="Store a newly created IrregularProxyNounReference in storage",
     *      tags={"IrregularProxyNounReference"},
     *      description="Store IrregularProxyNounReference",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="IrregularProxyNounReference that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/IrregularProxyNounReference")
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
     *                  ref="#/definitions/IrregularProxyNounReference"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateIrregularProxyNounReferenceAPIRequest $request)
    {
        $input = $request->all();

        $irregularProxyNounReference = $this->irregularProxyNounReferenceRepository->create($input);

        return $this->sendResponse($irregularProxyNounReference->toArray(), 'Irregular Proxy Noun Reference saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/irregularProxyNounReferences/{id}",
     *      summary="Display the specified IrregularProxyNounReference",
     *      tags={"IrregularProxyNounReference"},
     *      description="Get IrregularProxyNounReference",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of IrregularProxyNounReference",
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
     *                  ref="#/definitions/IrregularProxyNounReference"
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
        /** @var IrregularProxyNounReference $irregularProxyNounReference */
        $irregularProxyNounReference = $this->irregularProxyNounReferenceRepository->find($id);

        if (empty($irregularProxyNounReference)) {
            return $this->sendError('Irregular Proxy Noun Reference not found');
        }

        return $this->sendResponse($irregularProxyNounReference->toArray(), 'Irregular Proxy Noun Reference retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateIrregularProxyNounReferenceAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/irregularProxyNounReferences/{id}",
     *      summary="Update the specified IrregularProxyNounReference in storage",
     *      tags={"IrregularProxyNounReference"},
     *      description="Update IrregularProxyNounReference",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of IrregularProxyNounReference",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="IrregularProxyNounReference that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/IrregularProxyNounReference")
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
     *                  ref="#/definitions/IrregularProxyNounReference"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateIrregularProxyNounReferenceAPIRequest $request)
    {
        $input = $request->all();

        /** @var IrregularProxyNounReference $irregularProxyNounReference */
        $irregularProxyNounReference = $this->irregularProxyNounReferenceRepository->find($id);

        if (empty($irregularProxyNounReference)) {
            return $this->sendError('Irregular Proxy Noun Reference not found');
        }

        $irregularProxyNounReference = $this->irregularProxyNounReferenceRepository->update($input, $id);

        return $this->sendResponse($irregularProxyNounReference->toArray(), 'IrregularProxyNounReference updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/irregularProxyNounReferences/{id}",
     *      summary="Remove the specified IrregularProxyNounReference from storage",
     *      tags={"IrregularProxyNounReference"},
     *      description="Delete IrregularProxyNounReference",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of IrregularProxyNounReference",
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
        /** @var IrregularProxyNounReference $irregularProxyNounReference */
        $irregularProxyNounReference = $this->irregularProxyNounReferenceRepository->find($id);

        if (empty($irregularProxyNounReference)) {
            return $this->sendError('Irregular Proxy Noun Reference not found');
        }

        $irregularProxyNounReference->delete();

        return $this->sendSuccess('Irregular Proxy Noun Reference deleted successfully');
    }
}
