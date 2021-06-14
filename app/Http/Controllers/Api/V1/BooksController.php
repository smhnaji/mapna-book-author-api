<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Http\Resources\BookResource;
use App\Models\Author;
use App\Models\Book;

class BooksController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Author $author = null)
    {
        $books = $author ? $author->books()->simplePaginate() : Book::simplePaginate();

        return $this->responseSuccess(collect($books), 'Books retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookStoreRequest $request, Author $author)
    {
        $book = $author->books()->create($request->toArray());

        return $this->responseSuccess(new BookResource($book), 'Book stored successfully.', 0, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Author $author
     * @param Book $book
     * @return BookResource
     */
    public function show(Author $author = null, Book $book)
    {
        return $this->responseSuccess(collect(new BookResource($book)), 'Book retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BookUpdateRequest $request
     * @param Author $author
     * @param Book $book
     * @return void
     */
    public function update(BookUpdateRequest $request, Author $author, Book $book)
    {
        $book->update($request->toArray());

        return $this->responseSuccess(collect($book), 'Book has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Author $author
     * @param Book $book
     * @return void
     */
    public function destroy(Author $author, Book $book)
    {
        $book->delete();

        return $this->responseSuccess([], 'Book deleted.', 0, 200);
    }
}
