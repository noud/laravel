<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePolitiebureausLocatieAPIRequest;
use App\Http\Requests\API\UpdatePolitiebureausLocatieAPIRequest;
use App\Models\PolitiebureausLocatie;
use App\Repositories\PolitiebureausLocatieRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class PolitiebureausLocatieController
 * @package App\Http\Controllers\API
 */

class PolitiebureausLocatieAPIController extends AppBaseController
{
    /** @var  PolitiebureausLocatieRepository */
    private $politiebureausLocatieRepository;

    public function __construct(PolitiebureausLocatieRepository $politiebureausLocatieRepo)
    {
        $this->politiebureausLocatieRepository = $politiebureausLocatieRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/politiebureausLocaties",
     *      summary="Get a listing of the PolitiebureausLocaties.",
     *      tags={"PolitiebureausLocatie"},
     *      description="Get all PolitiebureausLocaties",
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
     *                  @SWG\Items(ref="#/definitions/PolitiebureausLocatie")
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
        $politiebureausLocaties = $this->politiebureausLocatieRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($politiebureausLocaties->toArray(), 'Politiebureaus Locaties retrieved successfully');
    }

    /**
     * @param CreatePolitiebureausLocatieAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/politiebureausLocaties",
     *      summary="Store a newly created PolitiebureausLocatie in storage",
     *      tags={"PolitiebureausLocatie"},
     *      description="Store PolitiebureausLocatie",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="PolitiebureausLocatie that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/PolitiebureausLocatie")
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
     *                  ref="#/definitions/PolitiebureausLocatie"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreatePolitiebureausLocatieAPIRequest $request)
    {
        $input = $request->all();

        $politiebureausLocatie = $this->politiebureausLocatieRepository->create($input);

        return $this->sendResponse($politiebureausLocatie->toArray(), 'Politiebureaus Locatie saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/politiebureausLocaties/{id}",
     *      summary="Display the specified PolitiebureausLocatie",
     *      tags={"PolitiebureausLocatie"},
     *      description="Get PolitiebureausLocatie",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of PolitiebureausLocatie",
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
     *                  ref="#/definitions/PolitiebureausLocatie"
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
        /** @var PolitiebureausLocatie $politiebureausLocatie */
        $politiebureausLocatie = $this->politiebureausLocatieRepository->find($id);

        if (empty($politiebureausLocatie)) {
            return $this->sendError('Politiebureaus Locatie not found');
        }

        return $this->sendResponse($politiebureausLocatie->toArray(), 'Politiebureaus Locatie retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdatePolitiebureausLocatieAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/politiebureausLocaties/{id}",
     *      summary="Update the specified PolitiebureausLocatie in storage",
     *      tags={"PolitiebureausLocatie"},
     *      description="Update PolitiebureausLocatie",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of PolitiebureausLocatie",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="PolitiebureausLocatie that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/PolitiebureausLocatie")
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
     *                  ref="#/definitions/PolitiebureausLocatie"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdatePolitiebureausLocatieAPIRequest $request)
    {
        $input = $request->all();

        /** @var PolitiebureausLocatie $politiebureausLocatie */
        $politiebureausLocatie = $this->politiebureausLocatieRepository->find($id);

        if (empty($politiebureausLocatie)) {
            return $this->sendError('Politiebureaus Locatie not found');
        }

        $politiebureausLocatie = $this->politiebureausLocatieRepository->update($input, $id);

        return $this->sendResponse($politiebureausLocatie->toArray(), 'PolitiebureausLocatie updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/politiebureausLocaties/{id}",
     *      summary="Remove the specified PolitiebureausLocatie from storage",
     *      tags={"PolitiebureausLocatie"},
     *      description="Delete PolitiebureausLocatie",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of PolitiebureausLocatie",
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
        /** @var PolitiebureausLocatie $politiebureausLocatie */
        $politiebureausLocatie = $this->politiebureausLocatieRepository->find($id);

        if (empty($politiebureausLocatie)) {
            return $this->sendError('Politiebureaus Locatie not found');
        }

        $politiebureausLocatie->delete();

        return $this->sendSuccess('Politiebureaus Locatie deleted successfully');
    }
}
