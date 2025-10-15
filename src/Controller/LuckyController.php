<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class LuckyController extends AbstractController
{
    #[Route('/lucky/number', name:'random_number')]
    public function number(): Response
    {
         $number = random_int(0, 100);

        return $this->render('lucky/number.html.twig', [
            'number' => $number,
        ]);
    }

    #[Route('/lucky/redirect', name:'redirect_to_random_number')]
    public function redirectToRandomNumber() : RedirectResponse
        {
            return $this-> redirectTo('random_number');
        }

    #[Route('/notations/notations','marks')]
    public function notation(): Response
    {
         $notation1 = random_int(0, 20);
         $notation2 = random_int(0, 20);
         $notation3 = random_int(0, 20);
         $notation4 = random_int(0, 20);

        return $this->render('notations/notations.html.twig', [
            'notation1' => $notation1,
            'notation2' => $notation2,
            'notation3' => $notation3,
            'notation4' => $notation4,
        ]);
    }

    #[Route('/notations_id/notations_id/{id1}/{id2}/{id3}/{id4}', name:'marksId', /*requirement:['note1' => '\d+','note2' => '\d+','note3' => '\d+','note4' => '\d+']*/)]
    public function show(int $id1, int $id2, int $id3, int $id4): Response
    {
       return $this->render('notations_id/notation_id.html.twig', [
            'noteId_1' => $id1,
            'noteId_2' => $id2,
            'noteId_3' => $id3,
            'noteId_4' => $id4,
    ]);
    }
}
?>