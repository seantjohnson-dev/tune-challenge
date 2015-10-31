<?php 
  include ('api.php');
  if ( !defined('DS') ) {
    define('DS', DIRECTORY_SEPARATOR);
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
  <header id="site-header" class="header">
    
  </header>
  <main role="document" class="region" id="main-region">
    <section class="user-collection-region" id="user-collection-region"></section>
  </main>
  <footer id="site-footer" class="footer">
    
  </footer>
  <div id="site-loader" class="page-loader"></div>
  <div id="body-scripts">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="/dist/scripts/modernizr.js"></script>
    <script src="/dist/scripts/main.js"></script>
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
      <script id="json-templates">
        AppData = {};
        AppData.Templates = <?php echo json_encode($templates); ?>;
      </script>
      <script id="json-users">
        AppData.Users = <?php echo file_get_contents(__DIR__ . DS . 'data' . DS . 'users' . DS . 'index.min.json'); ?>;
      </script>
      <script id="json-logs">
        AppData.Logs = <?php echo file_get_contents(__DIR__ . DS . 'data' . DS . 'logs' . DS . 'index.min.json'); ?>;
      </script>
  </div>
</body>
</html>