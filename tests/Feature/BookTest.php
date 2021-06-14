<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_created()
    {
        $this->withoutExceptionHandling();
        $author = Author::factory()->create();
        $book = Book::factory()->create(['author_id' => $author->id])->toArray();

        $response = $this->post('/api/v1/authors/' . $author->id . '/books', $book);

        $this->assertDatabaseHas('books', $book);
        $response->assertStatus(201);
    }

    /** @test */
    public function a_book_cannot_be_created_without_title()
    {
        $author = Author::factory()->create();

        $book = [
            'title' => '',
            'page_count' => 123,
        ];

        $this->post('/api/v1/authors/' . $author->id . '/books', $book);

        $this->assertDatabaseMissing('books', $book);
    }

    /** @test */
    public function a_book_can_be_created_without_page_count()
    {
        $author = Author::factory()->create();

        $book = [
            'title' => 'Hello World Book!',
        ];

        $response = $this->post('/api/v1/authors/' . $author->id . '/books', $book);

        $this->assertDatabaseHas('books', $book);
        $response->assertStatus(201);
    }

    /** @test */
    public function book_can_be_updated()
    {
        $book = Book::factory()->create();

        $data = [
            'title' => 'Changed title',
            'page_count' => 9999,
        ];

        $response = $this->patch('/api/v1/authors/' . $book->author_id . '/books/' . $book->id, $data);

        $this->assertDatabaseHas('books', $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function author_of_the_book_cannot_be_changed()
    {
        $author = Author::factory()->create();
        $author2 = Author::factory()->create();

        $book = [
            'title' => '',
            'page_count' => 123,
        ];

        $this->post('/api/v1/authors/' . $author->id . '/books', $book);

        $book = [
            'author_id' => $author2->id,
        ];
        $this->patch('/api/v1/authors/' . $author->id . '/books', $book);
        // $this->patch()
        $book['author_id'] = $author2->id;

        $this->assertDatabaseMissing('books', $book);
    }

    /** @test */
    public function a_book_can_be_shown_without_stating_author()
    {
        $book = Book::factory()->create();

        $response = $this->get('/api/v1/books/' . $book->id);

        $response->assertStatus(200);
    }

    /** @test */
    public function a_book_cannot_be_shown_with_wrong_author()
    {
        $author = Author::factory()->create();
        $author2 = Author::factory()->create();
    
        $data = [
            'title' => '',
            'page_count' => 123,
        ];

        $book = $author->books()->create($data);
    
        $response = $this->get('/api/v1/authors/' . $author2->id . '/books/' . $book->id, $data);

        $response->assertStatus(403);
    }
}
