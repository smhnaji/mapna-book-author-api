<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\AuthorStoreRequest;
use App\Http\Requests\AuthorUpdateRequest;
use App\Http\Resources\AuthorResource;
use App\Models\Author;

class AuthorsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Author $author = null)
    {
        $authors = $author ? $author->books()->simplePaginate() : Author::simplePaginate();

        return $this->responseSuccess(collect($authors), 'Authors retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AuthorStoreRequest $request)
    {
        $author = Author::create($request->toArray());

        return $this->responseSuccess(new AuthorResource($author), 'Author stored successfully.', 0, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Author $author
     * @return AuthorResource
     */
    public function show(Author $author)
    {
        return $this->responseSuccess(collect(new AuthorResource($author)), 'Author retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AuthorUpdateRequest $request
     * @param Author $author
     * @return void
     */
    public function update(AuthorUpdateRequest $request, Author $author)
    {
        $author->update($request->toArray());

        return $this->responseSuccess(collect($author), 'Author has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Author $author
     * @return void
     */
    public function destroy(Author $author)
    {
        $author->delete();

        return $this->responseSuccess([], 'Author deleted.', 0, 200);
    }
}
