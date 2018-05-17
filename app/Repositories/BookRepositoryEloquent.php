<?php

namespace App\Repositories;

use App\Models\Book;

class BookRepositoryEloquent implements BookRepository
{
    /**
     * @var Book
     */
    private $model;


    /**
     * BookRepositoryEloquent constructor.
     * @param Book $model
     */
    public function __construct(Book $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model;
    }
}