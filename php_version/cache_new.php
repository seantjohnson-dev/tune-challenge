<?php 
  global $data;
  global $conv_id;
  global $imp_id;
  global $data_users_file;
  global $data_logs_file;
  global $data_dir;

  if ( !defined('DS') ) {
    define('DS', DIRECTORY_SEPARATOR);
  }

  $conv_id = 0;
  $imp_id = 0;
  $data_dir = __DIR__ . DS . 'data' . DS;
  $data_users_file = $data_dir . 'users.json';
  $data_logs_file = $data_dir . 'logs.json';

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

  function sort_log_by_time($a, $b) {
    $atime = strtotime($a->time);
    $btime = strtotime($b->time);
    if ($atime == $btime) {
      return 0;
    }
    return ($atime < $btime) ? -1 : 1;
  }

  function build_cache() {
    global $data;
    global $data_dir;
    global $data_users_file;
    global $data_logs_file;
    
    $data = array(
      'logs' => array(),
      'impressions' => array(),
      'conversions' => array(),
      'users' => array()
    );

    $log_array = json_decode(file_get_contents($data_logs_file));
    foreach($log_array as $l=>$log) {
      switch(strtolower($log->type)) {
        case 'impression':
        $log->id = get_impression_id();
        if (!isset($data['impressions'][$log->user_id])) {
          $data['impressions'][$log->user_id] = array();
        }
        $data['impressions'][$log->user_id][] = $log;
        break;
        case 'conversion':
        $log->id = get_conversion_id();
        if (!isset($data['conversions'][$log->user_id])) {
          $data['conversions'][$log->user_id] = array();
        }
        $data['conversions'][$log->user_id][] = $log;
        break;
      }
      if (!isset($data['logs'][$log->user_id])) {
        $data['logs'][$log->user_id] = array();
      }
      $data['logs'][$log->user_id][] = $log;
    }
    unset($log_array);
    foreach($data['conversions'] as $uc_key=>$uc_val) {
      usort($data['conversions'][$uc_key], 'sort_log_by_time');
    }
    foreach($data['impressions'] as $ui_key=>$ui_val) {
      usort($data['impressions'][$ui_key], 'sort_log_by_time');
    }
    $users = json_decode(file_get_contents($data_users_file));
    foreach($users as $u=>$user) {
      $user->logs = array(
        'impressions' => $data['impressions'][$user->id],
        'conversions' => $data['conversions'][$user->id]
      );
      $data['users'][$u] = $users;
    }
    file_put_contents($data_dir . 'all.json', json_encode($data));
  }

  build_cache();
?>