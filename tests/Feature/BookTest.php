<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_book_can_be_created()
    {
        $this->withoutExceptionHandling();
        
        $book = [
            'title' => 'Hello World Book!',
            'page_count' => 123,
        ];

        $response = $this->post('/api/v1/books', $book);

        $this->assertDatabaseHas('books', $book);
        $response->assertStatus(201);
    }

    public function test_a_book_cannot_be_created_without_title()
    {        
        $book = [
            'title' => '',
            'page_count' => 123,
        ];

        $this->post('/api/v1/books', $book);

        $this->assertDatabaseMissing('books', $book);
    }

    public function test_a_book_can_be_created_without_page_count()
    {
        $this->withoutExceptionHandling();
        
        $book = [
            'title' => 'Hello World Book!',
        ];

        $response = $this->post('/api/v1/books', $book);

        $this->assertDatabaseHas('books', $book);
        $response->assertStatus(201);
    }

    
}
