<?php
namespace App\Service;

use App\Repository\CategoryRepository;

class Category
{
    private $categoryRepository;
    
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function categoriesFindAll()
    {
        $categories = $this->categoryRepository->findAll();
        //dd($brands);
        return $categories;
    }
}