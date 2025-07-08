<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'AD Task Meeting Calendar'; ?></title>
    <?php
    $cssPath = isset($isHandler) && $isHandler ? '../assets/css/main.css' : 'assets/css/main.css';
    ?>
    <link rel="stylesheet" href="<?php echo $cssPath; ?>">
</head>

<body>
    <div class="container">
        <h1>AD Task Meeting Calendar</h1>
        <?php if (isset($content))
            echo $content; ?>
    </div>
</body>

</html>