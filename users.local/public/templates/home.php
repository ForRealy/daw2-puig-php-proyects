<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/twbs/bootstrap/dist/css/bootstrap.css">
    <title>Proyectos</title>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">User Form</h1>
        
        {# templates/form/contact.html.twig #}

{% extends 'base.html.twig' %}

{% block body %}
    <h1>Contact Form</h1>

    {# Render the form using Twig form helpers #}
    {{ form_start(form) }}
        {{ form_row(form.name) }}
        {{ form_row(form.email) }}
        {{ form_row(form.message) }}
        {{ form_row(form.submit) }}
    {{ form_end(form) }}
{% endblock %}

        
    </div>

    <script src="./assets/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
