<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'create_product')]
    public function createProduct(ProductRepository $products): Response
    {
        #add a field to the database#
        // $product = new Product();
        // $product->setName('Keyboard');
        // $product->setPrice('1999');
        // $product->setDescription('Ergonomic and stylish!');
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        // $entityManager->persist($product);
        // actually executes the queries (i.e. the INSERT query)
        // $entityManager->flush(); //This persist and flush() methods are dont while EntityManagerInterface $entityManager are the arguments
        // $products->save($product, true);

        #ProductRepository $products were used as the arguments to use below#
        #edit field in the database#
        // $product = $products->find('5');
        // $product->setName('Mouse');
        // $product->setPrice('200');
        // $product->setDescription('modern and  large');
        // $products->save($product, true);

        $product = $products->find(12);
        $products->remove($product, true);

        
        return new Response(('Saved new product with id: '.$product->getId()));
    }

    #[Route('/product/{id<\d+>}', name: 'show_product')]
    public function showProduct(EntityMAnagerInterface $entityManager, int $id): Response
    {
        $product = $entityManager->getRepository(Product::class)->find($id);
            if(!$product){
                throw $this->createNotFoundException('No product found for ID: '.$id);
                
            }
        return new Response('Checkout this product: '.$product->getName());
    }
}
