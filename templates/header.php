<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <?php foreach ($cssFiles as $css) : //load css files from config
    ?>
        <link rel="stylesheet" <?php if (is_string($css)) : ?> href="<?php echo $css ?>" <?php elseif (is_array($css)) : ?> <?php foreach ($css as $property => $value) : ?> <?php echo $property ?>="<?php echo $value ?>" <?php endforeach; ?> <?php endif; ?> />
    <?php endforeach; ?>
    <?php foreach ($jsFiles as $js) : //load javascript files from config
    ?>
        <script <?php if (is_string($js)) : ?> src="<?php echo $js ?>" <?php elseif (is_array($js)) : ?> <?php foreach ($js as $property => $value) : ?> <?php echo $property ?>="<?php echo $value ?>" <?php endforeach; ?> <?php endif; ?> >
        </script>
    <?php endforeach; ?>
    <title><?php echo $title ?></title>
</head>

<body>
    