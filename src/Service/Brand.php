<?php
namespace App\Service;

use App\Repository\BrandRepository;

class Brand 
{
    private $brandRepository;
    
    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function BrandFindAll()
    {
        $brands = $this->brandRepository->findAll();
        //dd($brands);
        return $brands;
    }
}