<?php 
  if ( !defined('DS') ) {
    define('DS', DIRECTORY_SEPARATOR);
  }

  $data_dir = __DIR__ . DS . 'assets' . DS . 'data';
  $raw_dir = $data_dir . DS . 'raw';
  $users_dir = $data_dir . DS . 'users';
  $log_dir = $data_dir . DS . 'logs';
  $conv_dir = $log_dir . DS . 'conversions';
  $imp_dir = $log_dir . DS . 'impressions';
  
  $data_user_file = $raw_dir . DS . 'users.json';
  $data_log_file = $raw_dir . DS . 'logs.json';
  $users_file = $users_dir . DS . 'users.json';
  $logs_file = $log_dir . DS . 'logs.json';
  $conv_file = $conv_dir . DS . 'conversions.json';
  $imp_file = $imp_dir . DS . 'impressions.json';

  function sort_log_by_time($a, $b) {
    $atime = strtotime($a->time);
    $btime = strtotime($b->time);
    if ($atime == $btime) {
      return 0;
    }
    return ($atime < $btime) ? -1 : 1;
  }

  function rebuild_cache() {
    $new_data = array(
      'impressions' => array(),
      'conversions' => array(),
      'users' => array()
    );
    if (!file_exists($log_dir)) {
      mkdir($log_dir, 0755, true);
    }
    $log_contents = file_get_contents($data_log_file);
    $log_array = json_decode($log_contents);

    foreach($log_array as $l=>$log) {
      switch(strtolower($log->type)) {
        case 'impression':
        if (!isset($new_data['impressions'][$log->user_id])) {
          $new_data['impressions'][$log->user_id] = array();
        }
        $new_data['impressions'][$log->user_id][] = $log;
        $log->cache_id = uniqid();
        $filename = $log->type . '-' . $log->cache_id . '.json';
        $usr_imp_dir = $imp_dir . DS . 'user_' . $log->user_id;
        if (!file_exists($usr_imp_dir)) {
          mkdir($usr_imp_dir, 0755, true);
        }
        file_put_contents($usr_imp_dir . DS . $filename, json_encode($log));
        break;
        case 'conversion':
        if (!isset($new_data['conversions'][$log->user_id])) {
          $new_data['conversions'][$log->user_id] = array();
        }
        $new_data['conversions'][$log->user_id][] = $log;
        $log->cache_id = uniqid();
        $filename = $log->type . '-' . $log->cache_id . '.json';
        $usr_conv_dir = $conv_dir . DS . 'user_' . $log->user_id;
        if (!file_exists($usr_conv_dir)) {
          mkdir($usr_conv_dir, 0755, true);
        }
        file_put_contents($usr_conv_dir . DS . $filename, json_encode($log));
        break;
      }
    }
    $log_array = null;
    foreach($new_data['impressions'] as $ui_key=>$ui_val) {
      usort($new_data['impressions'][$ui_key], 'sort_log_by_time');
    }
    file_put_contents($imp_dir . DS . 'impressions.json', json_encode($new_data['impressions']));
    foreach($new_data['conversions'] as $uc_key=>$uc_val) {
      usort($new_data['conversions'][$uc_key], 'sort_log_by_time');
    }
    file_put_contents($conv_dir . DS . 'conversions.json', json_encode($new_data['conversions']));

    $user_contents = file_get_contents($data_user_file);
    $users = json_decode($user_contents);
    foreach($users as $u=>$user) {
      $user->logs = array(
        'impressions' => $new_data['impressions'][$user->id],
        'conversions' => $new_data['conversions'][$user->id]
      );
      $usr_dir = $users_dir . DS . 'user_' . $user->id;
      if (!file_exists($usr_dir)) {
        mkdir($usr_dir, 0755, true);
        file_put_contents($usr_dir, json_encode($user));
      }
      $new_data['users'][$u] = $user;
    }
    file_put_contents($users_dir . DS . 'users.json', json_encode($new_data['users']));
    file_put_contents($data_dir . DS . 'logs.json', json_encode($new_data));
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