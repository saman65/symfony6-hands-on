<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Entity\Comment;
use App\Entity\MicroPost;
use App\Entity\UserProfile;
use App\Repository\CommentRepository;
use App\Repository\MicroPostRepository;
use App\Repository\UserProfileRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HelloController extends AbstractController //AbstractController has useful methods like render() to render twig templates
{
    private array $messages = [
        ['message' => 'Hello!', 'created' => '2022/06/12'],
        ['message' => 'Hi', 'created' => '2022/04/12'],
        ['message' => 'Bye!', 'created' => '2023/05/12'],
    ];
    #[Route('/', name: 'app_index', priority: 2)] //Route is a class and needs to be imported
    public function index(MicroPostRepository $posts, CommentRepository $comments): Response
    {
        // $post = new MicroPost();
        // $post->setTitle('Hello');
        // $post->setText('Hello Man!');
        // $post->setCreated(new DateTime());
/* if the field specifying the post ID is in comment, this means that the micro post is the owning side of this relationship. 
So we can say that MicroPost has comments, not that a comment has a micropost. */

//fetch a post data and then save the comment:
        $post = $posts->find(13);
        // $post->getComments()->count();
        // $comment = $post->getComments()[0];
        // $post->removeComment($comment);
        // $posts->save($post, true);

        // $comment = new Comment();
        // $comment->setText('Hello Admin!');
        // $comment->setPost($post);
        // // $post->addComment($comment);
        // // $posts->save($post, true);
        // $comments->save($comment, true);
        // dd($post);
        // return new Response(
        //     implode(', ', array_slice($this->messages, 0, $limit))
        // );
//         $user = new User();
//         $user->setEmail('dlaho@dalaho.ku');
//         $user->setPassword('131313');
// /* Since the profile is associated with its user, the user should be created first */
//         $profile = new UserProfile();
//         $profile->setUser($user);
//         $profiles->save($profile, true);

            // $profile = $profiles->find(1);
            // $profiles->remove($profile, true);

        return $this->render('hello/index.html.twig', //render() is a method that comes with the AbstractController class which 
        //renders the twig templates and accepts two arguments. The first one is the twig template address which
        //is obligatory and the second one is the data to be passed to the template which is optional.
            [
                'messages' => $this->messages,
                'limit' => 3
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