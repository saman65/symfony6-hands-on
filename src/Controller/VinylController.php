<?php
namespace App\Controller;
use Twig\Environment;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Loader\Configurator\twig;

class VinylController extends AbstractController
{
    #[Route('/', name: 'app_homepage', priority: 2)]
    public function homepage(Environment $twig): Response
    {
        $tracks = [
            ['song' => 'Gangsta\'s Paradise', 'artist' => 'Coolio'],
            ['song' => 'Waterfalls', 'artist' => 'TLC'],
            ['song' => 'Creep', 'artist' => 'Radiohead'],
            ['song' => 'Kiss from a Rose', 'artist' => 'Seal'],
            ['song' => 'On Bended Knee', 'artist' => 'Boyz II Men'],
            ['song' => 'Fantasy', 'artist' => 'Mariah Carey'],
        ];
        //dd($tracks); {This is a Debug function similar to dump(). Both are useful to test. Dump() performs hiddenly but can be revealed}
        $html = $twig->render('vinyl/homepage.html.twig', [
            'title' => 'PB & Jams',
            'tracks' => $tracks,
        ]);
        return new Response($html);
        #$this->render() is working inside the controllers. But $twig->render is working also outside the controllers#
    }

    #[Route('/browse/{slug}', name: 'app_browse')]
    public function browse(string $slug = null): Response
    {
        if ($slug) {
            $title = 'Genre: '.str_replace('-', ' ', $slug);
        } else {
            $title = 'All Genres';
        }
        return $this->render('vinyl/browse.html.twig', [
            'genre' => $title
            ]);
    }
}