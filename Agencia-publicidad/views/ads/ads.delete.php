<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <form action="index.php?controller=AdsController&accion=delete" method="post">
        <h3>Selecciona el anuncio que quieres borrar:</h3>
        <?php foreach ($anunciosPorIdComerciante as $anuncio): ?>
            <label>
                <input type="radio" name="idAnuncio" value="<?= $anuncio['id'] ?>">
                <?= htmlspecialchars($anuncio['titulo']) ?>
            </label><br>
        <?php endforeach; ?>
    <button type="submit">Borrar anuncio</button>
</form>
</body>
</html>