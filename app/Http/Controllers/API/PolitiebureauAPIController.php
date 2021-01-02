<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePolitiebureauAPIRequest;
use App\Http\Requests\API\UpdatePolitiebureauAPIRequest;
use App\Models\Politiebureau;
use App\Repositories\PolitiebureauRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class PolitiebureauController
 * @package App\Http\Controllers\API
 */

class PolitiebureauAPIController extends AppBaseController
{
    /** @var  PolitiebureauRepository */
    private $politiebureauRepository;

    public function __construct(PolitiebureauRepository $politiebureauRepo)
    {
        $this->politiebureauRepository = $politiebureauRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/politiebureaus",
     *      summary="Get a listing of the Politiebureaus.",
     *      tags={"Politiebureau"},
     *      description="Get all Politiebureaus",
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
     *                  @SWG\Items(ref="#/definitions/Politiebureau")
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
        $skip = $request->get('skip');
        $limit = $request->get('limit');
        $page = $request->get('page');

        $limit = 2; // @todo middleware add configuration limit
        $total_politiebureaus = Politiebureau::count();
        if ($page) {
            $skip = $limit * $page;
        } else {
            $page = 1;
        }

        $politiebureaus = $this->politiebureauRepository->all(
            $request->except(['skip', 'limit', 'page']),
            $skip,
            $limit
        );

        return $this->sendPaginatedResponse($politiebureaus->toArray(), 'Politibureauses retrieved successfully', $total_politiebureaus, $limit, 'politiebureaus', $page);
    }

    /**
     * @param CreatePolitiebureauAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/politiebureaus",
     *      summary="Store a newly created Politiebureau in storage",
     *      tags={"Politiebureau"},
     *      description="Store Politiebureau",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Politiebureau that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Politiebureau")
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
     *                  ref="#/definitions/Politiebureau"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreatePolitiebureauAPIRequest $request)
    {
        $input = $request->all();

        $politiebureau = $this->politiebureauRepository->create($input);

        return $this->sendResponse($politiebureau->toArray(), 'Politiebureau saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/politiebureaus/{id}",
     *      summary="Display the specified Politiebureau",
     *      tags={"Politiebureau"},
     *      description="Get Politiebureau",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Politiebureau",
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
     *                  ref="#/definitions/Politiebureau"
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
        /** @var Politiebureau $politiebureau */
        $politiebureau = $this->politiebureauRepository->find($id);

        if (empty($politiebureau)) {
            return $this->sendError('Politiebureau not found');
        }

        return $this->sendResponse($politiebureau->toArray(), 'Politiebureau retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdatePolitiebureauAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/politiebureaus/{id}",
     *      summary="Update the specified Politiebureau in storage",
     *      tags={"Politiebureau"},
     *      description="Update Politiebureau",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Politiebureau",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Politiebureau that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Politiebureau")
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
     *                  ref="#/definitions/Politiebureau"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdatePolitiebureauAPIRequest $request)
    {
        $input = $request->all();

        /** @var Politiebureau $politiebureau */
        $politiebureau = $this->politiebureauRepository->find($id);

        if (empty($politiebureau)) {
            return $this->sendError('Politiebureau not found');
        }

        $politiebureau = $this->politiebureauRepository->update($input, $id);

        return $this->sendResponse($politiebureau->toArray(), 'Politiebureau updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/politiebureaus/{id}",
     *      summary="Remove the specified Politiebureau from storage",
     *      tags={"Politiebureau"},
     *      description="Delete Politiebureau",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Politiebureau",
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
        /** @var Politiebureau $politiebureau */
        $politiebureau = $this->politiebureauRepository->find($id);

        if (empty($politiebureau)) {
            return $this->sendError('Politiebureau not found');
        }

        $politiebureau->delete();

        return $this->sendSuccess('Politiebureau deleted successfully');
    }
}
