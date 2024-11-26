<?php
// src/Controller/HomeController.php
namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class HomeController
{
    private $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader('../templates');
        $this->twig = new Environment($loader);
    }

    public function index(): void
{
    $loader = new FilesystemLoader(__DIR__ . '/../../templates');
    $twig = new Environment($loader);

    echo $twig->render('home.twig', ['data' => []]); // No debe repetirse
}

}
