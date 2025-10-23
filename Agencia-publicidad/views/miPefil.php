<?php 

use AgenciaPublicidad\Models\TipoPersonaEnum;
    require_once __DIR__ . '/../utils/auth_helper.php';
    require_once __DIR__ . '/../TipoPersonaEnum.php';


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>
<body>




     <main>
        
        

        <div class="contenido">
            <aside>
                <ul>
                    <li><b>Nombre: <?=$perfil["u.nombre"]?></b></li>
                    <li><b>Apellido: <?=$perfil["u.apellido"]?></b></li>
                    <li><b>Email: <?=$perfil["u.email"]?></b></li>
                    <?php if($currentUser["tipo"]==TipoPersonaEnum::COMERCIANTE):?>

                        <li><b>Nombre empresa:</b> <?=$perfil["c.nombre_empresa"]?></li>
                        <li><b>Nif empresa:</b><?=$perfil["c.nif_empresa"]?></li>
                        <li><b>Detalles de la empresa:</b><?=$perfil["c.comentario_empresa"]?></li>
                        <li><b>Telefonno de la empresa:</b><?=$perfil["c.num_telefono"]?></li>
                        <li><b>Comerciante desde:</b><?=$perfil["c.comerciante_desde"]?></li>
                    <?php endif?>






            
                </ul>

            </aside>
            <div id="perfil">
             <h2><img src="Component 12.png" alt="foto de perfil">Pako</h2>
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