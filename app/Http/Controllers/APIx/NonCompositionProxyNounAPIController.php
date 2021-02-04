<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateNonCompositionProxyNounAPIRequest;
use App\Http\Requests\API\UpdateNonCompositionProxyNounAPIRequest;
use App\Models\NonCompositionProxyNoun;
use App\Repositories\NonCompositionProxyNounRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class NonCompositionProxyNounController
 * @package App\Http\Controllers\API
 */

class NonCompositionProxyNounAPIController extends AppBaseController
{
    /** @var  NonCompositionProxyNounRepository */
    private $nonCompositionProxyNounRepository;

    public function __construct(NonCompositionProxyNounRepository $nonCompositionProxyNounRepo)
    {
        $this->nonCompositionProxyNounRepository = $nonCompositionProxyNounRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/nonCompositionProxyNouns",
     *      summary="Get a listing of the NonCompositionProxyNouns.",
     *      tags={"NonCompositionProxyNoun"},
     *      description="Get all NonCompositionProxyNouns",
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
     *                  @SWG\Items(ref="#/definitions/NonCompositionProxyNoun")
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
        $nonCompositionProxyNouns = $this->nonCompositionProxyNounRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($nonCompositionProxyNouns->toArray(), 'Non Composition Proxy Nouns retrieved successfully');
    }

    /**
     * @param CreateNonCompositionProxyNounAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/nonCompositionProxyNouns",
     *      summary="Store a newly created NonCompositionProxyNoun in storage",
     *      tags={"NonCompositionProxyNoun"},
     *      description="Store NonCompositionProxyNoun",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="NonCompositionProxyNoun that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/NonCompositionProxyNoun")
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
     *                  ref="#/definitions/NonCompositionProxyNoun"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateNonCompositionProxyNounAPIRequest $request)
    {
        $input = $request->all();

        $nonCompositionProxyNoun = $this->nonCompositionProxyNounRepository->create($input);

        return $this->sendResponse($nonCompositionProxyNoun->toArray(), 'Non Composition Proxy Noun saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/nonCompositionProxyNouns/{id}",
     *      summary="Display the specified NonCompositionProxyNoun",
     *      tags={"NonCompositionProxyNoun"},
     *      description="Get NonCompositionProxyNoun",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of NonCompositionProxyNoun",
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
     *                  ref="#/definitions/NonCompositionProxyNoun"
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
        /** @var NonCompositionProxyNoun $nonCompositionProxyNoun */
        $nonCompositionProxyNoun = $this->nonCompositionProxyNounRepository->find($id);

        if (empty($nonCompositionProxyNoun)) {
            return $this->sendError('Non Composition Proxy Noun not found');
        }

        return $this->sendResponse($nonCompositionProxyNoun->toArray(), 'Non Composition Proxy Noun retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateNonCompositionProxyNounAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/nonCompositionProxyNouns/{id}",
     *      summary="Update the specified NonCompositionProxyNoun in storage",
     *      tags={"NonCompositionProxyNoun"},
     *      description="Update NonCompositionProxyNoun",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of NonCompositionProxyNoun",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="NonCompositionProxyNoun that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/NonCompositionProxyNoun")
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
     *                  ref="#/definitions/NonCompositionProxyNoun"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateNonCompositionProxyNounAPIRequest $request)
    {
        $input = $request->all();

        /** @var NonCompositionProxyNoun $nonCompositionProxyNoun */
        $nonCompositionProxyNoun = $this->nonCompositionProxyNounRepository->find($id);

        if (empty($nonCompositionProxyNoun)) {
            return $this->sendError('Non Composition Proxy Noun not found');
        }

        $nonCompositionProxyNoun = $this->nonCompositionProxyNounRepository->update($input, $id);

        return $this->sendResponse($nonCompositionProxyNoun->toArray(), 'NonCompositionProxyNoun updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/nonCompositionProxyNouns/{id}",
     *      summary="Remove the specified NonCompositionProxyNoun from storage",
     *      tags={"NonCompositionProxyNoun"},
     *      description="Delete NonCompositionProxyNoun",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of NonCompositionProxyNoun",
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
        /** @var NonCompositionProxyNoun $nonCompositionProxyNoun */
        $nonCompositionProxyNoun = $this->nonCompositionProxyNounRepository->find($id);

        if (empty($nonCompositionProxyNoun)) {
            return $this->sendError('Non Composition Proxy Noun not found');
        }

        $nonCompositionProxyNoun->delete();

        return $this->sendSuccess('Non Composition Proxy Noun deleted successfully');
    }
}
