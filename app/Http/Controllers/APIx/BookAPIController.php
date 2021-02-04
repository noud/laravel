<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateBookAPIRequest;
use App\Http\Requests\API\UpdateBookAPIRequest;
use App\Models\Book;
use App\Repositories\BookRepository;
use Illuminate\Http\Request;
// use App\Http\Controllers\AppBaseController;
use API\Platform\Http\Controllers\AppBaseController;
use Response;

/**
 * Class BookController
 * @package App\Http\Controllers\API
 */

class BookAPIController extends AppBaseController
{
    /** @var  BookRepository */
    private $bookRepository;

    public function __construct(BookRepository $bookRepo)
    {
        $this->bookRepository = $bookRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/books",
     *      summary="Get a listing of the Books.",
     *      tags={"Book"},
     *      description="Get all Books",
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
     *                  @SWG\Items(ref="#/definitions/Book")
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
        $total_books = Book::count();
        if ($page) {
            $skip = $limit * $page;
        } else {
            $page = 0;
        }

        $books = $this->bookRepository->all(
            $request->except(['skip', 'limit', 'page']),
            $skip,
            $limit
        );

        return $this->sendPaginatedResponse($books->toArray(), 'Books retrieved successfully', $total_books, $limit, 'books', $page);
    }


    /**
     * @param CreateBookAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/books",
     *      summary="Store a newly created Book in storage",
     *      tags={"Book"},
     *      description="Store Book",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Book that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Book")
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
     *                  ref="#/definitions/Book"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateBookAPIRequest $request)
    {
        $input = $request->all();

        $book = $this->bookRepository->create($input);

        return $this->sendResponse($book->toArray(), 'Book saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/books/{id}",
     *      summary="Display the specified Book",
     *      tags={"Book"},
     *      description="Get Book",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Book",
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
     *                  ref="#/definitions/Book"
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
        /** @var Book $book */
        $book = $this->bookRepository->find($id);

        if (empty($book)) {
            return $this->sendError('Book not found');
        }

        return $this->sendResponse($book->toArray(), 'Book retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateBookAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/books/{id}",
     *      summary="Update the specified Book in storage",
     *      tags={"Book"},
     *      description="Update Book",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Book",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Book that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Book")
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
     *                  ref="#/definitions/Book"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateBookAPIRequest $request)
    {
        $input = $request->all();

        /** @var Book $book */
        $book = $this->bookRepository->find($id);

        if (empty($book)) {
            return $this->sendError('Book not found');
        }

        $book = $this->bookRepository->update($input, $id);

        return $this->sendResponse($book->toArray(), 'Book updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/books/{id}",
     *      summary="Remove the specified Book from storage",
     *      tags={"Book"},
     *      description="Delete Book",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Book",
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
        /** @var Book $book */
        $book = $this->bookRepository->find($id);

        if (empty($book)) {
            return $this->sendError('Book not found');
        }

        $book->delete();

        return $this->sendSuccess('Book deleted successfully');
    }
}
