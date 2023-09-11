<?php

namespace App\Controller;

use DateTime;
use App\Entity\MicroPost;
use App\Form\MicroPostType;
use App\Repository\MicroPostRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class MicroPostController extends AbstractController
{
    #[Route('/micro-post', name: 'app_micro_post')]
    public function index(MicroPostRepository $posts): Response #Here we put $posts as an optional argument for the class MicroPostRepository#
    {
        //dd($posts->findAll()); #To show all records in the table of micro-post#
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
        ]); #findAll() is Repository method#
    }

    #[Route('/micro-post/{post}', name: 'app-micro-post-show')]
    public function showOne(MicroPost $post): Response
    {/* No matter what is inside {post} but must be same as $post and param converter does the rest and looks for the primary key which is id.
    It is possible to use the other columns like title inside the {} .But the normal way is using repository instead of the entity */

        /*dd($post); <= This is to fetch data from the database. This simple code is managed by sensio/framework-extra-bundle which has been installed.
        It made the arguments simple too. We also could fetch the data using {title} for example instead of {post}
         By default, no matter how you call the argument, the param convertor will look for the ID field of the micro post.
         if you want to fetch more or you want to filter data somehow, then you would still use the repository and its methods.*/

         return $this->render('micro_post/show_one.html.twig', [ /* <= rendering a template for the showone action*/
            'post' => $post, /* <= this is the kind of passing data to the template */
        ]);
    }

    #[Route('micro-post/add', name: 'app_micro_post_add', priority:2)]
    public function add(Request $request, MicroPostRepository $posts): Response{
        // $microPost = new MicroPost(); //These lines were used before creating the form using make:form and that was time consuming
        // $form = $this->createFormBuilder($microPost)
            // ->add('title')
            // ->add('text')
            // //->add('Submit', SubmitType::class, ['label' => 'Save']) //It is prettier to add button inside twig using html
            // ->getForm(); /* up to here (creating the form), Request $request were not needed as the arguments but needed for after submision */

            $form = $this->createForm(MicroPostType::class, new MicroPost);
            $form->handleRequest($request); /* Request $request arguments are needed to handle here */
            if($form->isSubmitted() && $form->isValid()){
                $post = $form->getData();
                //dd($post);
                $post->setCreated(new DateTime());
                $posts->save($post, true); /* This is why we added the second argument i.e Repository class */
                
                //adding a flash
                $this->addFlash('success', 'Your micro post has been added'); /* addFlash is a method of AbstractController. 
                addFlash() saves the key and the value in the session. The key can be any word but here success describe the message well
                Then we can retrive the value using app.flaashes in the twig file.
                We set its rendering in base.html.twig */
                
                //redirecting
                return $this->redirectToRoute('app_micro_post'); 
                /* It cab be redirected to any url using redirect() method. But redirectToRoute() redirects to the predefined routes */
            }

        return $this->renderForm(
            'micro_post/add.html.twig',
            [
                'form' => $form
        ]);
    }

    #[Route('micro-post/{post}/edit', name: 'app_micro_post_edit')]
    public function edit(MicroPost $post, Request $request, MicroPostRepository $posts): Response{
            //$form = $this->createFormBuilder($post)
            //->add('title')
            //->add('text')
            //->add('Submit', SubmitType::class, ['label' => 'Save']) //It is prettier to add button inside twig using html
            //->getForm(); /* up to here (creating the form), Request $request were not needed as the arguments but needed for after submision */
            
            $form = $this->createForm(MicroPostType::class, $post);
            $form->handleRequest($request); /* Request $request arguments are needed to handle here */
            if($form->isSubmitted() && $form->isValid()){
                $post = $form->getData();
                //dd($post);
                $posts->save($post, true); /* This is why we added the second argument i.e Repository class */
                
                //adding a flash
                $this->addFlash('success', 'Your micro post has been updated'); /* addFlash is a method of AbstractController. 
                addFlash() saves the key and the value in the session. The key can be any word but here success describe the message well
                Then we can retrive the value using app.flaashes in the twig file.
                We set its rendering in base.html.twig */
                
                //redirecting
                return $this->redirectToRoute('app_micro_post'); 
                /* It cab be redirected to any url using redirect() method. But redirectToRoute() redirects to the predefined routes */
            }

        return $this->renderForm(
            'micro_post/edit.html.twig',
            [
                'form' => $form
        ]);
    }
}
