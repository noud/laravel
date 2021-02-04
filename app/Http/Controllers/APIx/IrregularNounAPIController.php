<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateIrregularNounAPIRequest;
use App\Http\Requests\API\UpdateIrregularNounAPIRequest;
use App\Models\IrregularNoun;
use App\Repositories\IrregularNounRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class IrregularNounController
 * @package App\Http\Controllers\API
 */

class IrregularNounAPIController extends AppBaseController
{
    /** @var  IrregularNounRepository */
    private $irregularNounRepository;

    public function __construct(IrregularNounRepository $irregularNounRepo)
    {
        $this->irregularNounRepository = $irregularNounRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/irregularNouns",
     *      summary="Get a listing of the IrregularNouns.",
     *      tags={"IrregularNoun"},
     *      description="Get all IrregularNouns",
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
     *                  @SWG\Items(ref="#/definitions/IrregularNoun")
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
        $irregularNouns = $this->irregularNounRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($irregularNouns->toArray(), 'Irregular Nouns retrieved successfully');
    }

    /**
     * @param CreateIrregularNounAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/irregularNouns",
     *      summary="Store a newly created IrregularNoun in storage",
     *      tags={"IrregularNoun"},
     *      description="Store IrregularNoun",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="IrregularNoun that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/IrregularNoun")
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
     *                  ref="#/definitions/IrregularNoun"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateIrregularNounAPIRequest $request)
    {
        $input = $request->all();

        $irregularNoun = $this->irregularNounRepository->create($input);

        return $this->sendResponse($irregularNoun->toArray(), 'Irregular Noun saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/irregularNouns/{id}",
     *      summary="Display the specified IrregularNoun",
     *      tags={"IrregularNoun"},
     *      description="Get IrregularNoun",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of IrregularNoun",
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
     *                  ref="#/definitions/IrregularNoun"
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
        /** @var IrregularNoun $irregularNoun */
        $irregularNoun = $this->irregularNounRepository->find($id);

        if (empty($irregularNoun)) {
            return $this->sendError('Irregular Noun not found');
        }

        return $this->sendResponse($irregularNoun->toArray(), 'Irregular Noun retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateIrregularNounAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/irregularNouns/{id}",
     *      summary="Update the specified IrregularNoun in storage",
     *      tags={"IrregularNoun"},
     *      description="Update IrregularNoun",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of IrregularNoun",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="IrregularNoun that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/IrregularNoun")
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
     *                  ref="#/definitions/IrregularNoun"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateIrregularNounAPIRequest $request)
    {
        $input = $request->all();

        /** @var IrregularNoun $irregularNoun */
        $irregularNoun = $this->irregularNounRepository->find($id);

        if (empty($irregularNoun)) {
            return $this->sendError('Irregular Noun not found');
        }

        $irregularNoun = $this->irregularNounRepository->update($input, $id);

        return $this->sendResponse($irregularNoun->toArray(), 'IrregularNoun updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/irregularNouns/{id}",
     *      summary="Remove the specified IrregularNoun from storage",
     *      tags={"IrregularNoun"},
     *      description="Delete IrregularNoun",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of IrregularNoun",
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
        /** @var IrregularNoun $irregularNoun */
        $irregularNoun = $this->irregularNounRepository->find($id);

        if (empty($irregularNoun)) {
            return $this->sendError('Irregular Noun not found');
        }

        $irregularNoun->delete();

        return $this->sendSuccess('Irregular Noun deleted successfully');
    }
}
