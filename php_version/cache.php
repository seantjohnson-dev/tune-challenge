<?php 

  if ( !defined('DS') ) {
    define('DS', DIRECTORY_SEPARATOR);
  }

  global $data;
  global $conv_id;
  global $imp_id;
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
  $cache_paths['files']['users_file'] = $cache_paths['dirs']['cache_dir'] . 'users.json';
  $cache_paths['files']['conversions_file'] = $cache_paths['dirs']['conversions_dir'] . 'conversions.json';
  $cache_paths['files']['impressions_file'] = $cache_paths['dirs']['impressions_dir'] . 'impressions.json';

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

  function sort_log_by_time($a, $b) {
    $atime = strtotime($a->time);
    $btime = strtotime($b->time);
    if ($atime == $btime) {
      return 0;
    }
    return ($atime < $btime) ? -1 : 1;
  }

  function pretty_user_json($string = "") {
    $string = str_replace(",", ",\n", $string);
    $string = str_replace("{\"name\":", "{\n\t\"name\" : ", $string);
    $string = str_replace("\"avatar\":", "\t\"avatar\" : ", $string);
    $string = str_replace("\"occupation\":", "\t\"occupation\" : ", $string);
    $string = str_replace("\"logs\":", "\t\"logs\" : ", $string);
    $string = str_replace("\"impressions\":", "\n\t\t\"impressions\" : ", $string);
    $string = str_replace("\"conversions\":", "\t\t\"conversions\" : ", $string);
    $string = str_replace("\"time\":", "\n\t\t\t\t\"time\" : ", $string);
    $string = str_replace("\"type\":", "\t\t\t\t\"type\" : ", $string);
    $string = str_replace("\"user_id\":", "\t\t\t\t\"user_id\" : ", $string);
    $string = str_replace("\"revenue\":", "\t\t\t\t\"revenue\" : ", $string);
    $string = str_replace("[{", "[\n{", $string);
    $string = preg_replace('/"id":(\d*,)/', "\t\"id\" : $1", $string);
    $string = preg_replace('/"id":(\d*)},/', "\t\t\t\t\"id\" : $1\n},", $string);
    $string = preg_replace('/"id":(\d*)}]}}/', "\t\t\t\t\"id\" : $1\n\t\t\t}\n\t\t]\n\t}\n}", $string);
    $string = preg_replace('/"id":(\d*)}],/', "\t\t\t\t\"id\" : $1\n\t\t\t}\n\t\t],", $string);
    $string = preg_replace('/"id":(\d*)}],/', "\t\t\t\t\"id\" : $1\n\t\t\t}\n\t\t],", $string);
    $string = preg_replace("/([,\[])\n{/", "$1\n\t\t\t{", $string);
    $string = str_replace("},", "\n\t\t\t},", $string);
    return $string;
  }

  function pretty_logs_json($string = "") {
    $string = str_replace('"time":', '"time" : ', $string);
    $string = str_replace('"type":', '"type" : ', $string);
    $string = str_replace('"user_id":', '"user_id" : ', $string);
    $string = str_replace('"revenue":', '"revenue" : ', $string);
    $string = str_replace('"id":', '"id" : ', $string);
    $string = str_replace("[[", "[\t[", $string);
    $string = str_replace("[{", "\n\t[\n\t\t{", $string);
    $string = str_replace(",{", ",\n\t\t{", $string);
    $string = str_replace(",\"", ",\n\t\t\t\"", $string);
    $string = str_replace("{\"", "{\n\t\t\t\"", $string);
    $string = str_replace("},", "\n\t\t},", $string);
    $string = str_replace("}]", "\n\t\t}\n\t]", $string);
    $string = str_replace("]]", "]\n]", $string);
    return $string;
  }

  function create_impressions_file() {
    global $data;
    global $cache_paths;
    foreach($data['impressions'] as $ui_key=>$ui_val) {
      usort($data['impressions'][$ui_key], 'sort_log_by_time');
    }
    sort($data['impressions']);
    $imp_string = json_encode($data['impressions']);
    $imp_string = pretty_logs_json($imp_string);
    file_put_contents($cache_paths['files']['impressions_file'], $imp_string);
  }

  function create_conversions_file() {
    global $data;
    global $cache_paths;
    foreach($data['conversions'] as $uc_key=>$uc_val) {
      usort($data['conversions'][$uc_key], 'sort_log_by_time');
    }
    sort($data['conversions']);
    $conv_string = json_encode($data['conversions']);
    $conv_string = pretty_logs_json($conv_string);
    file_put_contents($cache_paths['files']['conversions_file'], $conv_string);
  }

  function create_users_files() {
    global $data;
    global $cache_paths;
    create_logs_files();
    $users = json_decode(file_get_contents($cache_paths['files']['data_user_file']));
    if (!file_exists($cache_paths['dirs']['users_dir'])) {
      mkdir($cache_paths['dirs']['users_dir'], 0755, true);
    }
    foreach($users as $u=>$user) {
      $user->occupation = ucwords($user->occupation);
      $user->logs = array(
        'impressions' => $data['impressions'][$user->id - 1],
        'conversions' => $data['conversions'][$user->id - 1]
      );
      $data['users'][$u] = $user;
      $user_string = json_encode($user);
      $user_string = pretty_user_json($user_string);
      file_put_contents($cache_paths['dirs']['users_dir'] . 'user_' . $user->id . '.json', $user_string);
    }
    sort($data['users']);
    $user_string = json_encode($data['users']);
    $user_string = pretty_user_json($user_string);
    file_put_contents($cache_paths['files']['users_file'], $user_string);
  }

  function create_logs_files() {
    global $cache_paths;
    global $data;
    $log_array = json_decode(file_get_contents($cache_paths['files']['data_log_file']));
    for ($i = 0, $l = count($log_array); $i < $l; $i++) {
      $log = $log_array[$i];
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
      unset($log_array[$i]);
    }
    unset($log_array);
    create_conversions_file();
    create_impressions_file();
  }

  function build_cache() {
    global $data;
    global $cache_paths;
    $data = array(
      'impressions' => array(),
      'conversions' => array(),
      'users' => array()
    );
    if (!file_exists($cache_paths['dirs']['cache_dir'])) {
      mkdir($cache_paths['dirs']['cache_dir'], 0755, true);
      mkdir($cache_paths['dirs']['logs_dir'], 0755, true);
      mkdir($cache_paths['dirs']['conversions_dir'], 0755, true);
      mkdir($cache_paths['dirs']['impressions_dir'], 0755, true);
      create_users_files();
    } else {
      $data['conversions'] = json_decode(file_get_contents($cache_paths['files']['conversions_file']));
      $data['impressions'] = json_decode(file_get_contents($cache_paths['files']['impressions_file']));
      $data['users'] = json_decode(file_get_contents($cache_paths['files']['users_file']));
    }
  }

  build_cache();
?>