<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAdjectiveAPIRequest;
use App\Http\Requests\API\UpdateAdjectiveAPIRequest;
use App\Models\Adjective;
use App\Repositories\AdjectiveRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class AdjectiveController
 * @package App\Http\Controllers\API
 */

class AdjectiveAPIController extends AppBaseController
{
    /** @var  AdjectiveRepository */
    private $adjectiveRepository;

    public function __construct(AdjectiveRepository $adjectiveRepo)
    {
        $this->adjectiveRepository = $adjectiveRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/adjectives",
     *      summary="Get a listing of the Adjectives.",
     *      tags={"Adjective"},
     *      description="Get all Adjectives",
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
     *                  @SWG\Items(ref="#/definitions/Adjective")
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
        $adjectives = $this->adjectiveRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($adjectives->toArray(), 'Adjectives retrieved successfully');
    }

    /**
     * @param CreateAdjectiveAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/adjectives",
     *      summary="Store a newly created Adjective in storage",
     *      tags={"Adjective"},
     *      description="Store Adjective",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Adjective that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Adjective")
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
     *                  ref="#/definitions/Adjective"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateAdjectiveAPIRequest $request)
    {
        $input = $request->all();

        $adjective = $this->adjectiveRepository->create($input);

        return $this->sendResponse($adjective->toArray(), 'Adjective saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/adjectives/{id}",
     *      summary="Display the specified Adjective",
     *      tags={"Adjective"},
     *      description="Get Adjective",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Adjective",
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
     *                  ref="#/definitions/Adjective"
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
        /** @var Adjective $adjective */
        $adjective = $this->adjectiveRepository->find($id);

        if (empty($adjective)) {
            return $this->sendError('Adjective not found');
        }

        return $this->sendResponse($adjective->toArray(), 'Adjective retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateAdjectiveAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/adjectives/{id}",
     *      summary="Update the specified Adjective in storage",
     *      tags={"Adjective"},
     *      description="Update Adjective",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Adjective",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Adjective that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Adjective")
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
     *                  ref="#/definitions/Adjective"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateAdjectiveAPIRequest $request)
    {
        $input = $request->all();

        /** @var Adjective $adjective */
        $adjective = $this->adjectiveRepository->find($id);

        if (empty($adjective)) {
            return $this->sendError('Adjective not found');
        }

        $adjective = $this->adjectiveRepository->update($input, $id);

        return $this->sendResponse($adjective->toArray(), 'Adjective updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/adjectives/{id}",
     *      summary="Remove the specified Adjective from storage",
     *      tags={"Adjective"},
     *      description="Delete Adjective",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Adjective",
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
        /** @var Adjective $adjective */
        $adjective = $this->adjectiveRepository->find($id);

        if (empty($adjective)) {
            return $this->sendError('Adjective not found');
        }

        $adjective->delete();

        return $this->sendSuccess('Adjective deleted successfully');
    }
}
