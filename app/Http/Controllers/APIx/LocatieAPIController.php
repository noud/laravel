<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateLocatieAPIRequest;
use App\Http\Requests\API\UpdateLocatieAPIRequest;
use App\Models\Locatie;
use App\Repositories\LocatieRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class LocatieController
 * @package App\Http\Controllers\API
 */

class LocatieAPIController extends AppBaseController
{
    /** @var  LocatieRepository */
    private $locatieRepository;

    public function __construct(LocatieRepository $locatieRepo)
    {
        $this->locatieRepository = $locatieRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/locaties",
     *      summary="Get a listing of the Locaties.",
     *      tags={"Locatie"},
     *      description="Get all Locaties",
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
     *                  @SWG\Items(ref="#/definitions/Locatie")
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
        $locaties = $this->locatieRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($locaties->toArray(), 'Locaties retrieved successfully');
    }

    /**
     * @param CreateLocatieAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/locaties",
     *      summary="Store a newly created Locatie in storage",
     *      tags={"Locatie"},
     *      description="Store Locatie",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Locatie that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Locatie")
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
     *                  ref="#/definitions/Locatie"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateLocatieAPIRequest $request)
    {
        $input = $request->all();

        $locatie = $this->locatieRepository->create($input);

        return $this->sendResponse($locatie->toArray(), 'Locatie saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/locaties/{id}",
     *      summary="Display the specified Locatie",
     *      tags={"Locatie"},
     *      description="Get Locatie",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Locatie",
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
     *                  ref="#/definitions/Locatie"
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
        /** @var Locatie $locatie */
        $locatie = $this->locatieRepository->find($id);

        if (empty($locatie)) {
            return $this->sendError('Locatie not found');
        }

        return $this->sendResponse($locatie->toArray(), 'Locatie retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateLocatieAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/locaties/{id}",
     *      summary="Update the specified Locatie in storage",
     *      tags={"Locatie"},
     *      description="Update Locatie",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Locatie",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Locatie that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Locatie")
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
     *                  ref="#/definitions/Locatie"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateLocatieAPIRequest $request)
    {
        $input = $request->all();

        /** @var Locatie $locatie */
        $locatie = $this->locatieRepository->find($id);

        if (empty($locatie)) {
            return $this->sendError('Locatie not found');
        }

        $locatie = $this->locatieRepository->update($input, $id);

        return $this->sendResponse($locatie->toArray(), 'Locatie updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/locaties/{id}",
     *      summary="Remove the specified Locatie from storage",
     *      tags={"Locatie"},
     *      description="Delete Locatie",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Locatie",
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
        /** @var Locatie $locatie */
        $locatie = $this->locatieRepository->find($id);

        if (empty($locatie)) {
            return $this->sendError('Locatie not found');
        }

        $locatie->delete();

        return $this->sendSuccess('Locatie deleted successfully');
    }
}
