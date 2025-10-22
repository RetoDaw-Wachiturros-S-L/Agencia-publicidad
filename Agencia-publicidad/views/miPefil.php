<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>
<body>
    <header>

        <img src="" alt="flecha">


        <div>
            <h1><img src="" alt="">omercio Vitoria</h1>
        </div>

        <h2>
            <?php  $perfil["nombre"]?>

        </h2>
        <img src="" alt="lampara">


    </header>
    <hr>




    <main>
        <?php if(!empty($perfil)):?>
            <h2><img src="" alt="foto de perfil"></h2>

            <a href="">Editar perfil</a>
            <a href="">Mis anuncios</a>
            <a href="">Cerrar sesion</a>
        
        <?php else:?>

            <h1>No iniciaste sesion XD</h1>
        
        <?php endif; ?>



    </main>


    <aside>
        <h3>Nombre:</h3>
        <h3>Apellido:</h3>
        <h3>Email:</h3>
        <h3></h3>


    </aside>







    
</body>
</html>