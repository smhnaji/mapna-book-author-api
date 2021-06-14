<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Author extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
    ];

    /**
     * books
     *
     * @return relation
     */
    public function books()
    {
        return $this->hasMany(Book::class);
    }

    protected static function booted()
    {
        parent::boot();

        static::deleting(function ($author) {
            $author->books()->delete();
        });
    }
}
