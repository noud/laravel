<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateNormalNounAPIRequest;
use App\Http\Requests\API\UpdateNormalNounAPIRequest;
use App\Models\NormalNoun;
use App\Repositories\NormalNounRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class NormalNounController
 * @package App\Http\Controllers\API
 */

class NormalNounAPIController extends AppBaseController
{
    /** @var  NormalNounRepository */
    private $normalNounRepository;

    public function __construct(NormalNounRepository $normalNounRepo)
    {
        $this->normalNounRepository = $normalNounRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/normalNouns",
     *      summary="Get a listing of the NormalNouns.",
     *      tags={"NormalNoun"},
     *      description="Get all NormalNouns",
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
     *                  @SWG\Items(ref="#/definitions/NormalNoun")
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
        $normalNouns = $this->normalNounRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($normalNouns->toArray(), 'Normal Nouns retrieved successfully');
    }

    /**
     * @param CreateNormalNounAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/normalNouns",
     *      summary="Store a newly created NormalNoun in storage",
     *      tags={"NormalNoun"},
     *      description="Store NormalNoun",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="NormalNoun that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/NormalNoun")
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
     *                  ref="#/definitions/NormalNoun"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateNormalNounAPIRequest $request)
    {
        $input = $request->all();

        $normalNoun = $this->normalNounRepository->create($input);

        return $this->sendResponse($normalNoun->toArray(), 'Normal Noun saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/normalNouns/{id}",
     *      summary="Display the specified NormalNoun",
     *      tags={"NormalNoun"},
     *      description="Get NormalNoun",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of NormalNoun",
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
     *                  ref="#/definitions/NormalNoun"
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
        /** @var NormalNoun $normalNoun */
        $normalNoun = $this->normalNounRepository->find($id);

        if (empty($normalNoun)) {
            return $this->sendError('Normal Noun not found');
        }

        return $this->sendResponse($normalNoun->toArray(), 'Normal Noun retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateNormalNounAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/normalNouns/{id}",
     *      summary="Update the specified NormalNoun in storage",
     *      tags={"NormalNoun"},
     *      description="Update NormalNoun",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of NormalNoun",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="NormalNoun that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/NormalNoun")
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
     *                  ref="#/definitions/NormalNoun"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateNormalNounAPIRequest $request)
    {
        $input = $request->all();

        /** @var NormalNoun $normalNoun */
        $normalNoun = $this->normalNounRepository->find($id);

        if (empty($normalNoun)) {
            return $this->sendError('Normal Noun not found');
        }

        $normalNoun = $this->normalNounRepository->update($input, $id);

        return $this->sendResponse($normalNoun->toArray(), 'NormalNoun updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/normalNouns/{id}",
     *      summary="Remove the specified NormalNoun from storage",
     *      tags={"NormalNoun"},
     *      description="Delete NormalNoun",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of NormalNoun",
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
        /** @var NormalNoun $normalNoun */
        $normalNoun = $this->normalNounRepository->find($id);

        if (empty($normalNoun)) {
            return $this->sendError('Normal Noun not found');
        }

        $normalNoun->delete();

        return $this->sendSuccess('Normal Noun deleted successfully');
    }
}
