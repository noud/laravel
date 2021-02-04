<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePolymorphicNounAPIRequest;
use App\Http\Requests\API\UpdatePolymorphicNounAPIRequest;
use App\Models\PolymorphicNoun;
use App\Repositories\PolymorphicNounRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class PolymorphicNounController
 * @package App\Http\Controllers\API
 */

class PolymorphicNounAPIController extends AppBaseController
{
    /** @var  PolymorphicNounRepository */
    private $polymorphicNounRepository;

    public function __construct(PolymorphicNounRepository $polymorphicNounRepo)
    {
        $this->polymorphicNounRepository = $polymorphicNounRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/polymorphicNouns",
     *      summary="Get a listing of the PolymorphicNouns.",
     *      tags={"PolymorphicNoun"},
     *      description="Get all PolymorphicNouns",
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
     *                  @SWG\Items(ref="#/definitions/PolymorphicNoun")
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
        $polymorphicNouns = $this->polymorphicNounRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($polymorphicNouns->toArray(), 'Polymorphic Nouns retrieved successfully');
    }

    /**
     * @param CreatePolymorphicNounAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/polymorphicNouns",
     *      summary="Store a newly created PolymorphicNoun in storage",
     *      tags={"PolymorphicNoun"},
     *      description="Store PolymorphicNoun",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="PolymorphicNoun that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/PolymorphicNoun")
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
     *                  ref="#/definitions/PolymorphicNoun"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreatePolymorphicNounAPIRequest $request)
    {
        $input = $request->all();

        $polymorphicNoun = $this->polymorphicNounRepository->create($input);

        return $this->sendResponse($polymorphicNoun->toArray(), 'Polymorphic Noun saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/polymorphicNouns/{id}",
     *      summary="Display the specified PolymorphicNoun",
     *      tags={"PolymorphicNoun"},
     *      description="Get PolymorphicNoun",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of PolymorphicNoun",
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
     *                  ref="#/definitions/PolymorphicNoun"
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
        /** @var PolymorphicNoun $polymorphicNoun */
        $polymorphicNoun = $this->polymorphicNounRepository->find($id);

        if (empty($polymorphicNoun)) {
            return $this->sendError('Polymorphic Noun not found');
        }

        return $this->sendResponse($polymorphicNoun->toArray(), 'Polymorphic Noun retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdatePolymorphicNounAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/polymorphicNouns/{id}",
     *      summary="Update the specified PolymorphicNoun in storage",
     *      tags={"PolymorphicNoun"},
     *      description="Update PolymorphicNoun",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of PolymorphicNoun",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="PolymorphicNoun that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/PolymorphicNoun")
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
     *                  ref="#/definitions/PolymorphicNoun"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdatePolymorphicNounAPIRequest $request)
    {
        $input = $request->all();

        /** @var PolymorphicNoun $polymorphicNoun */
        $polymorphicNoun = $this->polymorphicNounRepository->find($id);

        if (empty($polymorphicNoun)) {
            return $this->sendError('Polymorphic Noun not found');
        }

        $polymorphicNoun = $this->polymorphicNounRepository->update($input, $id);

        return $this->sendResponse($polymorphicNoun->toArray(), 'PolymorphicNoun updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/polymorphicNouns/{id}",
     *      summary="Remove the specified PolymorphicNoun from storage",
     *      tags={"PolymorphicNoun"},
     *      description="Delete PolymorphicNoun",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of PolymorphicNoun",
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
        /** @var PolymorphicNoun $polymorphicNoun */
        $polymorphicNoun = $this->polymorphicNounRepository->find($id);

        if (empty($polymorphicNoun)) {
            return $this->sendError('Polymorphic Noun not found');
        }

        $polymorphicNoun->delete();

        return $this->sendSuccess('Polymorphic Noun deleted successfully');
    }
}
