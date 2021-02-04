<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateRuleAPIRequest;
use App\Http\Requests\API\UpdateRuleAPIRequest;
use App\Models\Rule;
use App\Repositories\RuleRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class RuleController
 * @package App\Http\Controllers\API
 */

class RuleAPIController extends AppBaseController
{
    /** @var  RuleRepository */
    private $ruleRepository;

    public function __construct(RuleRepository $ruleRepo)
    {
        $this->ruleRepository = $ruleRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/rules",
     *      summary="Get a listing of the Rules.",
     *      tags={"Rule"},
     *      description="Get all Rules",
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
     *                  @SWG\Items(ref="#/definitions/Rule")
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
        $rules = $this->ruleRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($rules->toArray(), 'Rules retrieved successfully');
    }

    /**
     * @param CreateRuleAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/rules",
     *      summary="Store a newly created Rule in storage",
     *      tags={"Rule"},
     *      description="Store Rule",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Rule that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Rule")
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
     *                  ref="#/definitions/Rule"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateRuleAPIRequest $request)
    {
        $input = $request->all();

        $rule = $this->ruleRepository->create($input);

        return $this->sendResponse($rule->toArray(), 'Rule saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/rules/{id}",
     *      summary="Display the specified Rule",
     *      tags={"Rule"},
     *      description="Get Rule",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Rule",
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
     *                  ref="#/definitions/Rule"
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
        /** @var Rule $rule */
        $rule = $this->ruleRepository->find($id);

        if (empty($rule)) {
            return $this->sendError('Rule not found');
        }

        return $this->sendResponse($rule->toArray(), 'Rule retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateRuleAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/rules/{id}",
     *      summary="Update the specified Rule in storage",
     *      tags={"Rule"},
     *      description="Update Rule",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Rule",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Rule that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Rule")
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
     *                  ref="#/definitions/Rule"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateRuleAPIRequest $request)
    {
        $input = $request->all();

        /** @var Rule $rule */
        $rule = $this->ruleRepository->find($id);

        if (empty($rule)) {
            return $this->sendError('Rule not found');
        }

        $rule = $this->ruleRepository->update($input, $id);

        return $this->sendResponse($rule->toArray(), 'Rule updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/rules/{id}",
     *      summary="Remove the specified Rule from storage",
     *      tags={"Rule"},
     *      description="Delete Rule",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Rule",
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
        /** @var Rule $rule */
        $rule = $this->ruleRepository->find($id);

        if (empty($rule)) {
            return $this->sendError('Rule not found');
        }

        $rule->delete();

        return $this->sendSuccess('Rule deleted successfully');
    }
}
