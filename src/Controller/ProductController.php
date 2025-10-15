<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ProductRepository;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class ProductController extends AbstractController
{
   // Création d'un nouveau produit en base de donnée 

            #[Route('/product', name:'create_product')]
                public function createProduct(Request $request, EntityManagerInterface $entityManager):Response{

                    $content = json_decode($request->getContent(),true);
                    $product = new Product();
                    $product -> setName('Serveur');
                    $product -> setUnitPrice(110.50);
                    $product -> setCreatedAt(new \DateTime);
                    $product -> setDescription('Pour jouer à l\'ultimate en ligne');

                    $entityManager->persist($product);
                    $entityManager->flush();

                    return $this->render('product/product.html.twig', [
                    'product' => $product,
                ]);
            }

            #[Route('/product/{id}/edit', name:'edit_product', methods:['PATCH','PUT'])]
                public function updateProduct(Request $request, EntityManagerInterface $entityManager, int $id):Response{
                    $product = $entityManager-> getRepository(Product::class)->find($id);

                    $content = json_decode($request->getContent(),true);

                    if(!$product){
                        throw $this->createNotFoundException('No product for id' .$id);
                    };

                    $product->setName($content['name']);
                    $product->setUnitPrice($content['unitPrice']);
                    $product->setDescription($content['description']);
                     $product -> setName("Serveur");
                     $entityManager->persist($product);
                     $entityManager->flush();

                     return $this->render('product_edit/productEdit.html.twig',[ 'product' => $product]);
                }

                #[Route('/product/remove/{id}', name:'remove_product', methods:['DELETE'])]
                    public function removeProduct(EntityManagerInterface $entityManager, int $id):Response{
                        $product = $entityManager-> getRepository(Product::class)->find($id);

                        if(!$product){
                            throw $this->createNotFoundException('No product for id' .$id);
                        };
                            $entityManager->remove($product);
                            $entityManager->flush();

                     return $this->render('remove_product/removeProduct.html.twig',[ 'product' => $product]);
                }

               /*#[Route('/product/all', name:'all_product')]
                    public function allElementVisibility(EntityManagerInterface $entityManager):Response {
                        $products = $entityManager->getRepository
                    }*/

                #[Route('/product/test', name:'all_products')]
                public function getInfosRequest(
                    Request $request
                ): Response
            {
                $content = json_decode($request-> getContent(),true);
                dd($content);

                return new Response('ok');
            }

             #[Route('/products/filter', name: 'app_products_filter')]
                public function filter(ProductRepository $productRepository): Response
                    {
                        $products = $productRepository->findAllBetweenPrices(80, 120);
                        return $this->render('product_filter/productFilter.html.twig', [
                                'products' => $products,
                            ]);
                    }
            }
?>