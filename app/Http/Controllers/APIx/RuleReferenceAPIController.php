<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateRuleReferenceAPIRequest;
use App\Http\Requests\API\UpdateRuleReferenceAPIRequest;
use App\Models\RuleReference;
use App\Repositories\RuleReferenceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class RuleReferenceController
 * @package App\Http\Controllers\API
 */

class RuleReferenceAPIController extends AppBaseController
{
    /** @var  RuleReferenceRepository */
    private $ruleReferenceRepository;

    public function __construct(RuleReferenceRepository $ruleReferenceRepo)
    {
        $this->ruleReferenceRepository = $ruleReferenceRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/ruleReferences",
     *      summary="Get a listing of the RuleReferences.",
     *      tags={"RuleReference"},
     *      description="Get all RuleReferences",
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
     *                  @SWG\Items(ref="#/definitions/RuleReference")
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
        $ruleReferences = $this->ruleReferenceRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($ruleReferences->toArray(), 'Rule References retrieved successfully');
    }

    /**
     * @param CreateRuleReferenceAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/ruleReferences",
     *      summary="Store a newly created RuleReference in storage",
     *      tags={"RuleReference"},
     *      description="Store RuleReference",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="RuleReference that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/RuleReference")
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
     *                  ref="#/definitions/RuleReference"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateRuleReferenceAPIRequest $request)
    {
        $input = $request->all();

        $ruleReference = $this->ruleReferenceRepository->create($input);

        return $this->sendResponse($ruleReference->toArray(), 'Rule Reference saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/ruleReferences/{id}",
     *      summary="Display the specified RuleReference",
     *      tags={"RuleReference"},
     *      description="Get RuleReference",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of RuleReference",
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
     *                  ref="#/definitions/RuleReference"
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
        /** @var RuleReference $ruleReference */
        $ruleReference = $this->ruleReferenceRepository->find($id);

        if (empty($ruleReference)) {
            return $this->sendError('Rule Reference not found');
        }

        return $this->sendResponse($ruleReference->toArray(), 'Rule Reference retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateRuleReferenceAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/ruleReferences/{id}",
     *      summary="Update the specified RuleReference in storage",
     *      tags={"RuleReference"},
     *      description="Update RuleReference",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of RuleReference",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="RuleReference that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/RuleReference")
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
     *                  ref="#/definitions/RuleReference"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateRuleReferenceAPIRequest $request)
    {
        $input = $request->all();

        /** @var RuleReference $ruleReference */
        $ruleReference = $this->ruleReferenceRepository->find($id);

        if (empty($ruleReference)) {
            return $this->sendError('Rule Reference not found');
        }

        $ruleReference = $this->ruleReferenceRepository->update($input, $id);

        return $this->sendResponse($ruleReference->toArray(), 'RuleReference updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/ruleReferences/{id}",
     *      summary="Remove the specified RuleReference from storage",
     *      tags={"RuleReference"},
     *      description="Delete RuleReference",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of RuleReference",
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
        /** @var RuleReference $ruleReference */
        $ruleReference = $this->ruleReferenceRepository->find($id);

        if (empty($ruleReference)) {
            return $this->sendError('Rule Reference not found');
        }

        $ruleReference->delete();

        return $this->sendSuccess('Rule Reference deleted successfully');
    }
}
