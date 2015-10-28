<?php 
  global $data;
  if ( !defined('DS') ) {
    define('DS', DIRECTORY_SEPARATOR);
  }
  $conv_id = 0;
  $imp_id = 0;
  function get_conversion_id() {
    return $conv_id++;
  }
  function get_impression_id() {
    return $imp_id++;
  }

  $data_dir = __DIR__ . DS . 'data';
  $data_user_file = $data_dir . DS . 'users.json';
  $data_log_file = $data_dir . DS . 'logs.json';

  $cache_dir = __DIR__ . DS . 'cache';
  $users_dir = $cache_dir . DS . 'users';
  $log_dir = $cache_dir . DS . 'logs';
  $conv_dir = $log_dir . DS . 'conversions';
  $imp_dir = $log_dir . DS . 'impressions';
  
  $cache_file = $cache_dir . DS . 'cache.json';
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

  if (!file_exists($cache_dir) || !file_exists($cache_file)) {
    if (!file_exists($cache_dir)) {
      mkdir($cache_dir, 0755, true);
    }
    build_cache();
  } else {
    $data = file_get_contents($cache_file);
  }

  function build_cache() {
    global $data;
    $data = array(
      'impressions' => array(),
      'conversions' => array(),
      'users' => array()
    );
    if (!file_exists($log_dir)) {
      mkdir($log_dir, 0755, true);
    }
    $log_array = json_decode(file_get_contents($data_log_file));
    foreach($log_array as $l=>$log) {
      switch(strtolower($log->type)) {
        case 'impression':
        $usr_imp_dir = $imp_dir . DS . 'user_' . $log->user_id;
        if (!file_exists($usr_imp_dir)) {
          mkdir($usr_imp_dir, 0755, true);
        }
        if (!isset($data['impressions'][$log->user_id])) {
          $data['impressions'][$log->user_id] = array();
        }
        $data['impressions'][$log->user_id][] = $log;
        $log->cache_id = uniqid();
        $filename = $log->type . '-' . $log->cache_id . '.json';
        $usr_imp_dir = $imp_dir . DS . 'user_' . $log->user_id;
        if (!file_exists($usr_imp_dir)) {
          mkdir($usr_imp_dir, 0755, true);
        }
        file_put_contents($usr_imp_dir . DS . $filename, json_encode($log));
        break;
        case 'conversion':
        if (!isset($data['conversions'][$log->user_id])) {
          $data['conversions'][$log->user_id] = array();
        }
        $data['conversions'][$log->user_id][] = $log;
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
    foreach($data['impressions'] as $ui_key=>$ui_val) {
      usort($data['impressions'][$ui_key], 'sort_log_by_time');
    }
    file_put_contents($imp_dir . DS . 'impressions.json', json_encode($data['impressions']));
    foreach($data['conversions'] as $uc_key=>$uc_val) {
      usort($data['conversions'][$uc_key], 'sort_log_by_time');
    }
    file_put_contents($conv_dir . DS . 'conversions.json', json_encode($data['conversions']));

    $user_contents = file_get_contents($data_user_file);
    $users = json_decode($user_contents);
    foreach($users as $u=>$user) {
      $user->logs = array(
        'impressions' => $data['impressions'][$user->id],
        'conversions' => $data['conversions'][$user->id]
      );
      $usr_dir = $users_dir . DS . 'user_' . $user->id;
      if (!file_exists($usr_dir)) {
        mkdir($usr_dir, 0755, true);
        file_put_contents($usr_dir, json_encode($user));
      }
      $data['users'][$u] = $user;
    }
    file_put_contents($users_dir . DS . 'users.json', json_encode($data['users']));
    file_put_contents($cache_dir . DS . 'logs.json', json_encode($data));
  }

?>