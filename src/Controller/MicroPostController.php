<?php

namespace App\Controller;

use DateTime;
use App\Entity\MicroPost;
use App\Repository\MicroPostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MicroPostController extends AbstractController
{
    #[Route('/micro-post', name: 'app_micro_post')]
    public function index(MicroPostRepository $posts): Response #Here we put $posts as an optional argument for the class MicroPostRepository#
    {
        dd($posts->findAll()); #To show all records in the table of micro-post#
        // dd($posts->find(3)); #To show a specific record in the table of micro-post using the id as the argument#
        // dd($posts->findOneBy(['title'=>'Welcome to US!'])); #To show a specific record in the table of micro-post using a column=>value as the argument#
        // dd($posts->findBy(['title'=>'Welcome to US!'])); #To show all of the records with a soecific column=>value in the table of micro-post using a column=>value as the argument#
        
        /* beloww is to add records to the databse */
        // $microPost = new MicroPost();
        // $microPost->setTitle('It comes from controller!');
        // $microPost->setText('Hi!');
        // $microPost->setCreated(new DateTime()); #DateTime() class should be imported#
        // $posts->save($microPost, true);

         /* below is to update a record in the databse */
        // $microPost = $posts->find(3);
        // $microPost->setTitle("Welcome in general!");
        // $posts->save($microPost, true);

        /* below is to remove a record from the database */
        // $microPost = $posts->find(4);
        // $posts->remove($microPost, true); /* This inserts the values above to the database */
        /*The MicroPostRepository had add() method in older version that changed to save() method in new versions,
        so let's go posts and then pass the $micropost object and make sure that we
        specify the second parameter as being true so it will actually run the SQL query.*/

        return $this->render('micro_post/index.html.twig', [
            'posts' => $posts->findAll(), /* <= this is the kind of passing data to the template */
        ]);
    }

    #[Route('/micro-post/{post}', name: 'app-micro-post-show')]
    public function showOne(MicroPost $post): Response
    {
        /*dd($post); <= This is to fetch data from the database. This simple code is managed by sensio/framework-extra-bundle which has been installed.
        It made the arguments simple too. We also could fetch the data using {title} for example instead of {post}
         By default, no matter how you call the argument, the param convertor will look for the ID field of the micro post.
         if you want to fetch more or you want to filter data somehow, then you would still use the repository and its methods.*/

         return $this->render('micro_post/show.html.twig', [ /* <= rendering a template for the showone action*/
            'post' => $post, /* <= this is the kind of passing data to the template */
        ]);
    }
}
