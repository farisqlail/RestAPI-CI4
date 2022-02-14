<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
</head>

<body>

    <h1>Halo</h1>

    <?php foreach ($blogs as $item) : ?>

        <h3><?= $item['blog_title'] ?></h3>
        <p><?= $item['blog_description'] ?></p>

    <?php endforeach ?>

</body>

</html>