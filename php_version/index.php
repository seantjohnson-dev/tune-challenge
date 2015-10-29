<?php include ('cache.php'); ?>
<!Doctype html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="dist/styles/main.css"/>
    <link rel="shortcut icon" sizes="16x16 24x24 32x32" href="//www.tune.com/favicon.ico?v=3">
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="//www.tune.com/favicon-152.png">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="//www.tune.com/favicon-144.png">
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="//www.tune.com/favicon-120.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="//www.tune.com/favicon-114.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="//www.tune.com/favicon-72.png">
    <link rel="apple-touch-icon-precomposed" href="//www.tune.com/favicon-57.png"> 
  </head>
<body>
  <div class="body-region" id="body-region"></div>
  <script src="dist/scripts/modernizr.js"></script>
  <script src="dist/scripts/main.js"></script>
  <?php
    // This isn't the prettiest template loading method either. See if you can improve this later.
    $templates = array();
    foreach(glob('templates/*.hbs') as $filename) {
      if (is_file($filename)) {
        $contents = file_get_contents($filename);
        $propName = str_replace(' ', '', ucwords(str_replace('_', ' ', str_replace('.hbs', '', basename($filename)))));
        $templates[$propName] = $contents;
      }
    }
  ?>
  <script id="templates">
    if (App && !App.Templates) {
      App.Templates = <?php echo json_encode($templates); ?>;
    }
  </script>
</body>
</html>