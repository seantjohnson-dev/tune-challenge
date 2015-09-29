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
  <link rel="shortcut icon" href="/favicon.ico">
  <script src="dist/scripts/modernizr.js"></script>
  <script src="dist/scripts/main.js"></script>
</head>
<body>
  <main role="document" id="main-body">
    
  </main>
</body>
</html>