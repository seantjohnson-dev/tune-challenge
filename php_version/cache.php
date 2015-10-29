<?php 
  global $data;
  global $conv_id;
  global $imp_id;
  global $cache_paths;

  if ( !defined('DS') ) {
    define('DS', DIRECTORY_SEPARATOR);
  }

  $conv_id = 0;
  $imp_id = 0;

  function get_conversion_id() {
    global $conv_id;
    $conv_id = $conv_id + 1;
    return $conv_id;
  }
  function get_impression_id() {
    global $imp_id;
    $imp_id = $imp_id + 1;
    return $imp_id;
  }
  
  function create_cache_paths_global() {
    global $cache_paths;
    $cache_paths = array(
      'dirs' => array(),
      'files' => array()
    );
    $cache_paths['dirs']['data_dir'] = __DIR__ . DS . 'data' . DS;
    $cache_paths['dirs']['cache_dir'] = __DIR__ . DS . 'cache' . DS;
    $cache_paths['dirs']['users_dir'] = $cache_paths['dirs']['cache_dir'] . 'users' . DS;
    $cache_paths['dirs']['logs_dir'] = $cache_paths['dirs']['cache_dir'] . 'logs' . DS;
    $cache_paths['dirs']['conversions_dir'] =$cache_paths['dirs']['logs_dir'] . 'conversions' . DS;
    $cache_paths['dirs']['impressions_dir'] = $cache_paths['dirs']['logs_dir'] . 'impressions' . DS;

    $cache_paths['files']['data_user_file'] = $cache_paths['dirs']['data_dir'] . 'users.json';
    $cache_paths['files']['data_log_file'] = $cache_paths['dirs']['data_dir'] . 'logs.json';
    $cache_paths['files']['users_file'] = $cache_paths['dirs']['users_dir'] . 'users.json';
    $cache_paths['files']['logs_file'] = $cache_paths['dirs']['logs_dir'] . 'logs.json';
    $cache_paths['files']['conversions_file'] = $cache_paths['dirs']['conversions_dir'] . 'conversions.json';
    $cache_paths['files']['impressions_file'] = $cache_paths['dirs']['impressions_dir'] . 'impressions.json';
  }

  function sort_log_by_time($a, $b) {
    $atime = strtotime($a->time);
    $btime = strtotime($b->time);
    if ($atime == $btime) {
      return 0;
    }
    return ($atime < $btime) ? -1 : 1;
  }

  function create_impression_file(&$log) {
    global $cache_paths;
    $usr_imp_dir = $cache_paths['dirs']['impressions_dir'] . DS . 'user_' . $log->user_id;
    if (!file_exists($usr_imp_dir)) {
      mkdir($usr_imp_dir, 0755, true);
    }
    $usr_imp_file = $usr_imp_dir . DS . $log->type . '_' . $log->id . '.json';
    if (!file_exists($usr_imp_file)) {
      file_put_contents($usr_imp_file, json_encode($log));
    }
  }

  function create_impressions_file() {
    global $data;
    global $cache_paths;
    foreach($data['impressions'] as $ui_key=>$ui_val) {
      usort($data['impressions'][$ui_key], 'sort_log_by_time');
    }
    if (!file_exists($cache_paths['files']['impressions_file'])) {
      file_put_contents($cache_paths['files']['impressions_file'], json_encode($data['impressions']));
    }
  }

  function create_conversion_file(&$log) {
    global $cache_paths;
    $usr_conv_dir = $cache_paths['dirs']['conversions_dir'] . DS . 'user_' . $log->user_id;
    if (!file_exists($usr_conv_dir)) {
      mkdir($usr_conv_dir, 0755, true);
    }
    $usr_conv_file = $usr_conv_dir . DS . $log->type . '_' . $log->id . '.json';
    if (!file_exists($usr_conv_file)) {
      file_put_contents($usr_conv_file, json_encode($log));
    }
  }

  function create_conversions_file() {
    global $data;
    global $cache_paths;
    foreach($data['conversions'] as $uc_key=>$uc_val) {
      usort($data['conversions'][$uc_key], 'sort_log_by_time');
    }
    if (!file_exists($cache_paths['files']['conversions_file'])) {
      file_put_contents($cache_paths['files']['conversions_file'], json_encode($data['conversions']));
    }
    
  }

  function create_user_file($user) {
    global $data;
    global $cache_paths;
    $user->logs = array(
      'impressions' => $data['impressions'][$user->id],
      'conversions' => $data['conversions'][$user->id]
    );
    $usr_filename = $cache_paths['dirs']['users_dir'] . DS . 'user_' . $user->id . '.json';
    if (!file_exists($usr_filename)) {
      file_put_contents($usr_filename, json_encode($user));
    }
  }

  function create_users_files() {
    global $data;
    global $cache_paths;
    if (!file_exists($cache_paths['dirs']['users_dir'])) {
      mkdir($cache_paths['dirs']['users_dir'], 0755, true);
    }
    create_logs_files();
    $users = json_decode(file_get_contents($cache_paths['files']['data_user_file']));
    foreach($users as $u=>$user) {
      create_user_file($user);
      $data['users'][$u] = $users;
    }
    if (!file_exists($cache_paths['files']['users_file'])) {
      file_put_contents($cache_paths['files']['users_file'], json_encode($data['users']));
    }
  }

  function split_logs_by_type() {
    global $cache_paths;
    global $data;
    $log_array = json_decode(file_get_contents($cache_paths['files']['data_log_file']));
    if (!file_exists($cache_paths['dirs']['logs_dir'])) {
      mkdir($cache_paths['dirs']['logs_dir'], 0755, true);
    }
    if (!file_exists($cache_paths['dirs']['conversions_dir'])) {
      mkdir($cache_paths['dirs']['conversions_dir'], 0755, true);
    }
    if (!file_exists($cache_paths['dirs']['impressions_dir'])) {
      mkdir($cache_paths['dirs']['impressions_dir'], 0755, true);
    }
    foreach($log_array as $l=>$log) {
      switch(strtolower($log->type)) {
        case 'impression':
        $log->id = get_impression_id();
        create_impression_file($log);
        if (!isset($data['impressions'][$log->user_id])) {
          $data['impressions'][$log->user_id] = array();
        }
        $data['impressions'][$log->user_id][] = $log;
        break;
        case 'conversion':
        $log->id = get_conversion_id();
        create_conversion_file($log);
        if (!isset($data['conversions'][$log->user_id])) {
          $data['conversions'][$log->user_id] = array();
        }
        $data['conversions'][$log->user_id][] = $log;
        break;
      }
      $data['logs'][] = $log;
    }
    unset($log_array);
    create_impressions_file();
    create_conversions_file();
  }

  function create_logs_files() {
    global $data;
    global $cache_paths;
    split_logs_by_type();
    if (!file_exists($cache_paths['files']['logs_file'])) {
      file_put_contents($cache_paths['files']['logs_file'], json_encode($data['logs']));
    }
  }

  function build_cache() {
    global $data;
    global $cache_paths;
    
    create_cache_paths_global();
    if (!file_exists($cache_paths['dirs']['cache_dir'])) {
      mkdir($cache_paths['dirs']['cache_dir'], 0755, true);
    }
    $data = array(
      'logs' => array(),
      'impressions' => array(),
      'conversions' => array(),
      'users' => array()
    );

    if (!file_exists($cache_paths['files']['users_file']) || !file_get_contents($cache_paths['files']['users_file'])) {
      create_users_files();
    }
  }

  build_cache();
?>