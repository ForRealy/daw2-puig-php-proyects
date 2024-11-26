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
        <h1 class="text-center">Link OneUse</h1>
        <form action="" method="post">
            <div class="row mb-3">
                <div class="col text-center">
                    <input type="submit" class="btn btn-primary" name="request_link" value="Request for a download link" id="requestLinkButton">
                </div>
            </div>
        </form>
        
        <div class="mt-3">
        {{ message|raw }}
        </div>
    </div>
    
    <script src="./assets/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
