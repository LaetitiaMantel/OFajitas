<?php

use App\Repository\BrandRepository;

class Brand 
{
    private $brandRepository;
    
    public function __construct(BrandRepository $brandRepository)
    {
        
    }

    public function BrandFindAll()
    {
        $brands = $this->brandRepository->findAll();
        return $brands;
    }
}