<?php
/**
 * @TODO 
 * Las fechas funcionan correctamente pero el texto no toma nota y arreglalo
 */
setlocale(LC_ALL, "es_ES.UTF-8");
function detectUserLocale() {
    $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2); // Detecta el idioma principal
    $supportedLanguages = ['en', 'es', 'fr', 'de']; // Idiomas soportados por la app

    // Verifica si el idioma detectado es compatible con los soportados
    if (in_array($lang, $supportedLanguages)) {
        return $lang;
    } else {
        return 'en'; // Idioma predeterminado
    }
}
$locale = detectUserLocale();


putenv("LC_ALL=es_ES.UTF-8"); // Define el locale a usar
setlocale(LC_ALL, "es_ES.UTF-8");
bindtextdomain("messages", "../locales"); // Carpeta de localización
textdomain("messages"); // Archivo de texto a usar


// Set up a locale, e.g., English (US)
$locale = 'es_ES';

// Define date and time formats
$dateType = IntlDateFormatter::LONG;   // Full date, like "December 31, 2023"
$timeType = IntlDateFormatter::SHORT;  // Short time, like "4:30 PM"

// Optional: Specify a timezone, e.g., "America/New_York"
$timezone = 'America/New_York';

// Create the IntlDateFormatter instance
$dateFormatter = new IntlDateFormatter($locale, $dateType, $timeType, $timezone);

// Define a timestamp or DateTime object to format
$timestamp = time();  // Current timestamp

// Format the timestamp
$formattedDate = $dateFormatter->format($timestamp);

echo $formattedDate;  // Outputs formatted date, e.g., "December 31, 2023, 4:30 PM"

echo _(" Hello, World!"); // Esto buscará la traducción de "Hello, World!" en `messages.po`

//echo $format("%A %d de %B de %Y"); // Formato en español