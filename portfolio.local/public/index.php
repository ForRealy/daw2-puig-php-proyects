<?php
require_once '../vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

$currentFile = basename($_SERVER['PHP_SELF']);

$navItems = [
    ['name' => 'Sobre Mí', 'link' => 'index.php', 'active' => $currentFile == 'index.php', 'disabled' => false],
    ['name' => 'Proyectos', 'link' => 'page1.php', 'active' => $currentFile == 'page1.php', 'disabled' => false],
    ['name' => 'Tecnologías', 'link' => 'page2.php', 'active' => $currentFile == 'page2.php', 'disabled' => false],
];

$imageSrc = "./assets/img/pexels-manei-11360307.jpg";
$imageAlt = "Profile Photo";
$imageWidth = "350";
$mainHeading = "Alejandro Tomé Valle";
$mainText = "El pasado es historia, susurrando lecciones en la brisa. El futuro es un misterio, un horizonte lleno de promesas. Pero el presente es un regalo, un instante único que brilla con la luz de nuestras decisiones.";
$additionalText = "Desarrollador junior apasionado por la creación web. Habilidades en Java, React, Spring Boot y tecnologías similares. Comprometido con la excelencia y el crecimiento en el desarrollo frontend y backend";

echo $twig->render('index.html', [
    'navItems' => $navItems,
    'imageSrc' => $imageSrc,
    'imageAlt' => $imageAlt,
    'imageWidth' => $imageWidth,
    'mainHeading' => $mainHeading,
    'mainText' => $mainText,
    'additionalText' => $additionalText
]);
