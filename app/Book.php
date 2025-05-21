<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title', 'author', 'isbn', 'publisher', 'publication_year', 
        'description', 'student_id', 'status'
    ];
}