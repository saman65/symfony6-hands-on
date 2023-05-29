<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController //AbstractController has useful methods like render() to render twig templates
{
    private array $messages = [
        ['message' => 'Hello!', 'created' => '2022/06/12'],
        ['message' => 'Hi', 'created' => '2022/04/12'],
        ['message' => 'Bye!', 'created' => '2023/05/12'],
    ];
    #[Route('/{limit<\d+>?3}', name: 'app_index')] //Route is a class and needs to be imported
    public function index(int $limit): Response
    {
        // return new Response(
        //     implode(', ', array_slice($this->messages, 0, $limit))
        // );
        return $this->render('hello/index.html.twig', //render() is a method that comes with the AbstractController class which 
        //renders the twig templates and accepts two arguments. The first one is the twig template address which
        //is obligatory and the second one is the data to be passed to the template which is optional.
            [
                'messages' => $this->messages,
                'limit' => $limit
            ]
            );
    }
    #[Route('/messages/{id<\d+>}', name: 'app_show_one')]
    public function showOne(int $id): Response
    {
        return $this->render(// The render method is inherited from the AbstractController
            'hello/show_one.html.twig', //The second parameter which is optionl comes below
            [
                'message' => $this->messages[$id]
            ]
        );
        // return new Response($this->messages[$id]);
    }
}
//If two route pathes are very similar we can make one of them default by setting a priority more than 0.