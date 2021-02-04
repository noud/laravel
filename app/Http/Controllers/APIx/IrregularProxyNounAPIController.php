<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateIrregularProxyNounAPIRequest;
use App\Http\Requests\API\UpdateIrregularProxyNounAPIRequest;
use App\Models\IrregularProxyNoun;
use App\Repositories\IrregularProxyNounRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class IrregularProxyNounController
 * @package App\Http\Controllers\API
 */

class IrregularProxyNounAPIController extends AppBaseController
{
    /** @var  IrregularProxyNounRepository */
    private $irregularProxyNounRepository;

    public function __construct(IrregularProxyNounRepository $irregularProxyNounRepo)
    {
        $this->irregularProxyNounRepository = $irregularProxyNounRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/irregularProxyNouns",
     *      summary="Get a listing of the IrregularProxyNouns.",
     *      tags={"IrregularProxyNoun"},
     *      description="Get all IrregularProxyNouns",
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
     *                  @SWG\Items(ref="#/definitions/IrregularProxyNoun")
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
        $irregularProxyNouns = $this->irregularProxyNounRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($irregularProxyNouns->toArray(), 'Irregular Proxy Nouns retrieved successfully');
    }

    /**
     * @param CreateIrregularProxyNounAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/irregularProxyNouns",
     *      summary="Store a newly created IrregularProxyNoun in storage",
     *      tags={"IrregularProxyNoun"},
     *      description="Store IrregularProxyNoun",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="IrregularProxyNoun that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/IrregularProxyNoun")
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
     *                  ref="#/definitions/IrregularProxyNoun"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateIrregularProxyNounAPIRequest $request)
    {
        $input = $request->all();

        $irregularProxyNoun = $this->irregularProxyNounRepository->create($input);

        return $this->sendResponse($irregularProxyNoun->toArray(), 'Irregular Proxy Noun saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/irregularProxyNouns/{id}",
     *      summary="Display the specified IrregularProxyNoun",
     *      tags={"IrregularProxyNoun"},
     *      description="Get IrregularProxyNoun",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of IrregularProxyNoun",
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
     *                  ref="#/definitions/IrregularProxyNoun"
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
        /** @var IrregularProxyNoun $irregularProxyNoun */
        $irregularProxyNoun = $this->irregularProxyNounRepository->find($id);

        if (empty($irregularProxyNoun)) {
            return $this->sendError('Irregular Proxy Noun not found');
        }

        return $this->sendResponse($irregularProxyNoun->toArray(), 'Irregular Proxy Noun retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateIrregularProxyNounAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/irregularProxyNouns/{id}",
     *      summary="Update the specified IrregularProxyNoun in storage",
     *      tags={"IrregularProxyNoun"},
     *      description="Update IrregularProxyNoun",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of IrregularProxyNoun",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="IrregularProxyNoun that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/IrregularProxyNoun")
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
     *                  ref="#/definitions/IrregularProxyNoun"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateIrregularProxyNounAPIRequest $request)
    {
        $input = $request->all();

        /** @var IrregularProxyNoun $irregularProxyNoun */
        $irregularProxyNoun = $this->irregularProxyNounRepository->find($id);

        if (empty($irregularProxyNoun)) {
            return $this->sendError('Irregular Proxy Noun not found');
        }

        $irregularProxyNoun = $this->irregularProxyNounRepository->update($input, $id);

        return $this->sendResponse($irregularProxyNoun->toArray(), 'IrregularProxyNoun updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/irregularProxyNouns/{id}",
     *      summary="Remove the specified IrregularProxyNoun from storage",
     *      tags={"IrregularProxyNoun"},
     *      description="Delete IrregularProxyNoun",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of IrregularProxyNoun",
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
        /** @var IrregularProxyNoun $irregularProxyNoun */
        $irregularProxyNoun = $this->irregularProxyNounRepository->find($id);

        if (empty($irregularProxyNoun)) {
            return $this->sendError('Irregular Proxy Noun not found');
        }

        $irregularProxyNoun->delete();

        return $this->sendSuccess('Irregular Proxy Noun deleted successfully');
    }
}
