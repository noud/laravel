<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAfbeeldingAPIRequest;
use App\Http\Requests\API\UpdateAfbeeldingAPIRequest;
use App\Models\Afbeelding;
use App\Repositories\AfbeeldingRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class AfbeeldingController
 * @package App\Http\Controllers\API
 */

class AfbeeldingAPIController extends AppBaseController
{
    /** @var  AfbeeldingRepository */
    private $afbeeldingRepository;

    public function __construct(AfbeeldingRepository $afbeeldingRepo)
    {
        $this->afbeeldingRepository = $afbeeldingRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/afbeeldings",
     *      summary="Get a listing of the Afbeeldings.",
     *      tags={"Afbeelding"},
     *      description="Get all Afbeeldings",
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
     *                  @SWG\Items(ref="#/definitions/Afbeelding")
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
        $afbeeldings = $this->afbeeldingRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($afbeeldings->toArray(), 'Afbeeldings retrieved successfully');
    }

    /**
     * @param CreateAfbeeldingAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/afbeeldings",
     *      summary="Store a newly created Afbeelding in storage",
     *      tags={"Afbeelding"},
     *      description="Store Afbeelding",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Afbeelding that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Afbeelding")
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
     *                  ref="#/definitions/Afbeelding"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateAfbeeldingAPIRequest $request)
    {
        $input = $request->all();

        $afbeelding = $this->afbeeldingRepository->create($input);

        return $this->sendResponse($afbeelding->toArray(), 'Afbeelding saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/afbeeldings/{id}",
     *      summary="Display the specified Afbeelding",
     *      tags={"Afbeelding"},
     *      description="Get Afbeelding",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Afbeelding",
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
     *                  ref="#/definitions/Afbeelding"
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
        /** @var Afbeelding $afbeelding */
        $afbeelding = $this->afbeeldingRepository->find($id);

        if (empty($afbeelding)) {
            return $this->sendError('Afbeelding not found');
        }

        return $this->sendResponse($afbeelding->toArray(), 'Afbeelding retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateAfbeeldingAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/afbeeldings/{id}",
     *      summary="Update the specified Afbeelding in storage",
     *      tags={"Afbeelding"},
     *      description="Update Afbeelding",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Afbeelding",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Afbeelding that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Afbeelding")
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
     *                  ref="#/definitions/Afbeelding"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateAfbeeldingAPIRequest $request)
    {
        $input = $request->all();

        /** @var Afbeelding $afbeelding */
        $afbeelding = $this->afbeeldingRepository->find($id);

        if (empty($afbeelding)) {
            return $this->sendError('Afbeelding not found');
        }

        $afbeelding = $this->afbeeldingRepository->update($input, $id);

        return $this->sendResponse($afbeelding->toArray(), 'Afbeelding updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/afbeeldings/{id}",
     *      summary="Remove the specified Afbeelding from storage",
     *      tags={"Afbeelding"},
     *      description="Delete Afbeelding",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Afbeelding",
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
        /** @var Afbeelding $afbeelding */
        $afbeelding = $this->afbeeldingRepository->find($id);

        if (empty($afbeelding)) {
            return $this->sendError('Afbeelding not found');
        }

        $afbeelding->delete();

        return $this->sendSuccess('Afbeelding deleted successfully');
    }
}
