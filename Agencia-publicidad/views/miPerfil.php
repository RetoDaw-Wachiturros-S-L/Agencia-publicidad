<?php 

use AgenciaPublicidad\Models\TipoPersonaEnum;
    require_once __DIR__ . '/../utils/auth_helper.php';
    require_once __DIR__ . '/../models/TipoPersonaEnum.php';
     


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/perfil.css"/>

    <title>Document</title>

</head>
<body>
    <header>

    </header>




     <main>
        
        

        <div class="contenido">
            <aside>
                
                <ul>
                    <li><b>Nombre: <?=$perfil["nombre"]?></b></li>
                    <li><b>Apellido: <?=$perfil["apellido"]?></b></li>
                    <li><b>Email: <?=$perfil["email"]?></b></li>
                    
                    
                    <?php if($_SESSION["usuario"]["tipo"]=="COMERCIANTE"):?>
                      
                      
                      

                        <li><b>Nombre empresa: </b> <?=$perfil["nombre_empresa"]?></li>
                        <li><b>Nif empresa: </b><?=$perfil["nif_empresa"]?></li>
                        <li><b>Detalles de la empresa: </b><?=$perfil["comentario_empresa"]?></li>
                        <li><b>Telefonno de la empresa: </b><?=$perfil["num_telefono"]?></li>
                        <li><b>Comerciante desde: </b><?=$perfil["comerciante_desde"]?></li>
                    <?php endif?>






            
                </ul>

            </aside>
            <div id="perfil">
             <h2><img src="" alt="foto de perfil">Pako</h2>
            </div>
            <section>
                <a href="">Editar perfil</a>
                <a href="">Mis anuncios</a>
                <a href="" class="cerrar">Cerrar sesion</a>


            </section>


        </div>
        
       
        
    

        



    </main>







    
</body>
</html>