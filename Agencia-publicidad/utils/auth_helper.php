<?php

$logged = false;

    if (!empty($_SESSION['usuario'])) {
        $logged = true;
    }
    echo $logged;

?>