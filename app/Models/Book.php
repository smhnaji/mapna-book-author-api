<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'title',
        'page_count',
    ];

    /**
     * author
     *
     * @return relation
     */
    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
