<?php 
  if ( !defined('DS') ) {
    define('DS', DIRECTORY_SEPARATOR);
  }

  // This should all be done with Gulp instead of PHP.

  $data_dir = __DIR__ . DS . 'assets' . DS . 'data';
  $data_user_file = $data_dir . DS . 'users.json';
  $data_log_file = $data_dir . DS . 'logs.json';

  $js_data_dir = __DIR__ . DS . 'assets' . DS . 'scripts' . DS . 'data';
  $js_user_file = $js_data_dir . DS . 'users.js';
  $js_log_file = $js_data_dir . DS . 'logs.js';

  if (!file_exists($js_user_file)) {
    $user_contents = file_get_contents($data_user_file);
    $users_file = file_put_contents($js_user_file, "/* jshint ignore:start */\n(function() {\n\tApp.Data.Users = " . $user_contents . ";\n})();\n/* jshint ignore:end */");
  }
  if (!file_exists($js_log_file)) {
    $log_contents = file_get_contents($data_log_file);
    $logs_file = file_put_contents($js_log_file, "/* jshint ignore:start */\n(function() {\n\tApp.Data.Logs = " . $log_contents . ";\n})();\n/* jshint ignore:end */");
  }
?>
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