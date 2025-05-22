<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Reservation;
use App\Entity\User;
use App\Form\ReservationForm;
use App\Form\SearchForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{   
    #[Route('/account', name: 'app_account')]
    public function index(EntityManagerInterface $em, Request $request): Response
    {
        $user = $this->getUser();
        if(!$user)
            return $this->redirectToRoute('app_login');
        $searchForm=$this->createForm(SearchForm::class);
        $searchForm->handleRequest($request);
        if($searchForm->isSubmitted() && $searchForm->isValid()){
            $brand=$searchForm->get('brand')->getData();
            $model=$searchForm->get('model')->getData();
            if($brand && $model)
                $Cars=$em->getRepository(Car::class)->findBy(['brand' => $brand, 'model' => $model]);
            else if($brand)
                $Cars=$em->getRepository(Car::class)->findBy(['brand' => $brand]);
            else if($model)
                $Cars=$em->getRepository(Car::class)->findBy(['model' => $model]);
        } else{
            $Cars=$em->getRepository(Car::class)->findAll();
        }
        return $this->render('user/index.html.twig', [
            'cars' => $Cars,
            'user' => $user,
            'searchForm' => $searchForm->createView(),
        ]);
    }

    #[Route('/car/{id}', name: 'app_car')]
    public function bookCar($id, Request $request, EntityManagerInterface $em): Response
    {
        $connectedUser=$this->getUser();
        if(!$connectedUser)
            return $this->redirectToRoute('app_login');
        $book=new Reservation();
        $form = $this->createForm(ReservationForm::class, $book);
        $form->handleRequest($request);
        $user=$em->getRepository(User::class)->findBy(['id' => $connectedUser->getId()])[0];
        $car=$em->getRepository(Car::class)->findBy(['id' => $id])[0];
        if($form->isSubmitted() && $form->isValid()){
            //dd($form->getData());
            $book->setCustomerName($user->getName());
            $book->setCustomerEmail($user->getEmail());
            $book->setCar($car);
            $book->setUser($user);
            $car->setAvailable(false);
            $car->addReservation($book);
            $user->addReservation($book);
            $em->persist($book);
            $em->flush();
            return $this->redirectToRoute('app_account');
        }
        return $this->render('car/details.html.twig', [
            'form' => $form->createView(),
            'car' => $car,
            'user' => $user,
        ]);
    }
}
