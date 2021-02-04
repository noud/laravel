<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAdresAPIRequest;
use App\Http\Requests\API\UpdateAdresAPIRequest;
use App\Models\Adres;
use App\Repositories\AdresRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class AdresController
 * @package App\Http\Controllers\API
 */

class AdresAPIController extends AppBaseController
{
    /** @var  AdresRepository */
    private $adresRepository;

    public function __construct(AdresRepository $adresRepo)
    {
        $this->adresRepository = $adresRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/adres",
     *      summary="Get a listing of the Adres.",
     *      tags={"Adres"},
     *      description="Get all Adres",
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
     *                  @SWG\Items(ref="#/definitions/Adres")
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
        $adres = $this->adresRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($adres->toArray(), 'Adres retrieved successfully');
    }

    /**
     * @param CreateAdresAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/adres",
     *      summary="Store a newly created Adres in storage",
     *      tags={"Adres"},
     *      description="Store Adres",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Adres that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Adres")
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
     *                  ref="#/definitions/Adres"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateAdresAPIRequest $request)
    {
        $input = $request->all();

        $adres = $this->adresRepository->create($input);

        return $this->sendResponse($adres->toArray(), 'Adres saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/adres/{id}",
     *      summary="Display the specified Adres",
     *      tags={"Adres"},
     *      description="Get Adres",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Adres",
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
     *                  ref="#/definitions/Adres"
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
        /** @var Adres $adres */
        $adres = $this->adresRepository->find($id);

        if (empty($adres)) {
            return $this->sendError('Adres not found');
        }

        return $this->sendResponse($adres->toArray(), 'Adres retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateAdresAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/adres/{id}",
     *      summary="Update the specified Adres in storage",
     *      tags={"Adres"},
     *      description="Update Adres",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Adres",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Adres that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Adres")
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
     *                  ref="#/definitions/Adres"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateAdresAPIRequest $request)
    {
        $input = $request->all();

        /** @var Adres $adres */
        $adres = $this->adresRepository->find($id);

        if (empty($adres)) {
            return $this->sendError('Adres not found');
        }

        $adres = $this->adresRepository->update($input, $id);

        return $this->sendResponse($adres->toArray(), 'Adres updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/adres/{id}",
     *      summary="Remove the specified Adres from storage",
     *      tags={"Adres"},
     *      description="Delete Adres",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Adres",
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
        /** @var Adres $adres */
        $adres = $this->adresRepository->find($id);

        if (empty($adres)) {
            return $this->sendError('Adres not found');
        }

        $adres->delete();

        return $this->sendSuccess('Adres deleted successfully');
    }
}
