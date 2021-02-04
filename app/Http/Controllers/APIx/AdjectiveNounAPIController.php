<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAdjectiveNounAPIRequest;
use App\Http\Requests\API\UpdateAdjectiveNounAPIRequest;
use App\Models\AdjectiveNoun;
use App\Repositories\AdjectiveNounRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class AdjectiveNounController
 * @package App\Http\Controllers\API
 */

class AdjectiveNounAPIController extends AppBaseController
{
    /** @var  AdjectiveNounRepository */
    private $adjectiveNounRepository;

    public function __construct(AdjectiveNounRepository $adjectiveNounRepo)
    {
        $this->adjectiveNounRepository = $adjectiveNounRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/adjectiveNouns",
     *      summary="Get a listing of the AdjectiveNouns.",
     *      tags={"AdjectiveNoun"},
     *      description="Get all AdjectiveNouns",
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
     *                  @SWG\Items(ref="#/definitions/AdjectiveNoun")
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
        $adjectiveNouns = $this->adjectiveNounRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($adjectiveNouns->toArray(), 'Adjective Nouns retrieved successfully');
    }

    /**
     * @param CreateAdjectiveNounAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/adjectiveNouns",
     *      summary="Store a newly created AdjectiveNoun in storage",
     *      tags={"AdjectiveNoun"},
     *      description="Store AdjectiveNoun",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="AdjectiveNoun that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/AdjectiveNoun")
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
     *                  ref="#/definitions/AdjectiveNoun"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateAdjectiveNounAPIRequest $request)
    {
        $input = $request->all();

        $adjectiveNoun = $this->adjectiveNounRepository->create($input);

        return $this->sendResponse($adjectiveNoun->toArray(), 'Adjective Noun saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/adjectiveNouns/{id}",
     *      summary="Display the specified AdjectiveNoun",
     *      tags={"AdjectiveNoun"},
     *      description="Get AdjectiveNoun",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of AdjectiveNoun",
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
     *                  ref="#/definitions/AdjectiveNoun"
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
        /** @var AdjectiveNoun $adjectiveNoun */
        $adjectiveNoun = $this->adjectiveNounRepository->find($id);

        if (empty($adjectiveNoun)) {
            return $this->sendError('Adjective Noun not found');
        }

        return $this->sendResponse($adjectiveNoun->toArray(), 'Adjective Noun retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateAdjectiveNounAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/adjectiveNouns/{id}",
     *      summary="Update the specified AdjectiveNoun in storage",
     *      tags={"AdjectiveNoun"},
     *      description="Update AdjectiveNoun",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of AdjectiveNoun",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="AdjectiveNoun that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/AdjectiveNoun")
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
     *                  ref="#/definitions/AdjectiveNoun"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateAdjectiveNounAPIRequest $request)
    {
        $input = $request->all();

        /** @var AdjectiveNoun $adjectiveNoun */
        $adjectiveNoun = $this->adjectiveNounRepository->find($id);

        if (empty($adjectiveNoun)) {
            return $this->sendError('Adjective Noun not found');
        }

        $adjectiveNoun = $this->adjectiveNounRepository->update($input, $id);

        return $this->sendResponse($adjectiveNoun->toArray(), 'AdjectiveNoun updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/adjectiveNouns/{id}",
     *      summary="Remove the specified AdjectiveNoun from storage",
     *      tags={"AdjectiveNoun"},
     *      description="Delete AdjectiveNoun",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of AdjectiveNoun",
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
        /** @var AdjectiveNoun $adjectiveNoun */
        $adjectiveNoun = $this->adjectiveNounRepository->find($id);

        if (empty($adjectiveNoun)) {
            return $this->sendError('Adjective Noun not found');
        }

        $adjectiveNoun->delete();

        return $this->sendSuccess('Adjective Noun deleted successfully');
    }
}
