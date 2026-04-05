<?php

namespace App\Http\Controllers;

use App\Interfaces\CategoryInterface;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryRepository;

    public function __construct(CategoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index(){
        return view('category.index');
    }
}
