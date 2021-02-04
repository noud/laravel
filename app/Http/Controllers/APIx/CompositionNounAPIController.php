<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCompositionNounAPIRequest;
use App\Http\Requests\API\UpdateCompositionNounAPIRequest;
use App\Models\CompositionNoun;
use App\Repositories\CompositionNounRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class CompositionNounController
 * @package App\Http\Controllers\API
 */

class CompositionNounAPIController extends AppBaseController
{
    /** @var  CompositionNounRepository */
    private $compositionNounRepository;

    public function __construct(CompositionNounRepository $compositionNounRepo)
    {
        $this->compositionNounRepository = $compositionNounRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/compositionNouns",
     *      summary="Get a listing of the CompositionNouns.",
     *      tags={"CompositionNoun"},
     *      description="Get all CompositionNouns",
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
     *                  @SWG\Items(ref="#/definitions/CompositionNoun")
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
        $compositionNouns = $this->compositionNounRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($compositionNouns->toArray(), 'Composition Nouns retrieved successfully');
    }

    /**
     * @param CreateCompositionNounAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/compositionNouns",
     *      summary="Store a newly created CompositionNoun in storage",
     *      tags={"CompositionNoun"},
     *      description="Store CompositionNoun",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CompositionNoun that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CompositionNoun")
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
     *                  ref="#/definitions/CompositionNoun"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCompositionNounAPIRequest $request)
    {
        $input = $request->all();

        $compositionNoun = $this->compositionNounRepository->create($input);

        return $this->sendResponse($compositionNoun->toArray(), 'Composition Noun saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/compositionNouns/{id}",
     *      summary="Display the specified CompositionNoun",
     *      tags={"CompositionNoun"},
     *      description="Get CompositionNoun",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CompositionNoun",
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
     *                  ref="#/definitions/CompositionNoun"
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
        /** @var CompositionNoun $compositionNoun */
        $compositionNoun = $this->compositionNounRepository->find($id);

        if (empty($compositionNoun)) {
            return $this->sendError('Composition Noun not found');
        }

        return $this->sendResponse($compositionNoun->toArray(), 'Composition Noun retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateCompositionNounAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/compositionNouns/{id}",
     *      summary="Update the specified CompositionNoun in storage",
     *      tags={"CompositionNoun"},
     *      description="Update CompositionNoun",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CompositionNoun",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CompositionNoun that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CompositionNoun")
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
     *                  ref="#/definitions/CompositionNoun"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCompositionNounAPIRequest $request)
    {
        $input = $request->all();

        /** @var CompositionNoun $compositionNoun */
        $compositionNoun = $this->compositionNounRepository->find($id);

        if (empty($compositionNoun)) {
            return $this->sendError('Composition Noun not found');
        }

        $compositionNoun = $this->compositionNounRepository->update($input, $id);

        return $this->sendResponse($compositionNoun->toArray(), 'CompositionNoun updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/compositionNouns/{id}",
     *      summary="Remove the specified CompositionNoun from storage",
     *      tags={"CompositionNoun"},
     *      description="Delete CompositionNoun",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CompositionNoun",
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
        /** @var CompositionNoun $compositionNoun */
        $compositionNoun = $this->compositionNounRepository->find($id);

        if (empty($compositionNoun)) {
            return $this->sendError('Composition Noun not found');
        }

        $compositionNoun->delete();

        return $this->sendSuccess('Composition Noun deleted successfully');
    }
}
