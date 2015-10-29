<?php 

  if ( !defined('DS') ) {
    define('DS', DIRECTORY_SEPARATOR);
  }

  global $data;
  global $conv_id;
  global $imp_id;
  global $api_paths;

  $api_paths = array(
    'dirs' => array(),
    'files' => array()
  );
  $api_paths['dirs']['data_dir'] = __DIR__ . DS . 'data' . DS;
  $api_paths['files']['data_user_file'] = $api_paths['dirs']['data_dir'] . 'users.json';
  $api_paths['files']['data_user_min_file'] = $api_paths['dirs']['data_dir'] . 'users.min.json';
  $api_paths['files']['data_log_file'] = $api_paths['dirs']['data_dir'] . 'logs.json';
  $api_paths['files']['data_log_min_file'] = $api_paths['dirs']['data_dir'] . 'logs.min.json';

  $api_paths['dirs']['api_base_dir'] = __DIR__ . DS . 'api' . DS;
  $api_paths['dirs']['api_base_min_dir'] = $api_paths['dirs']['api_base_dir'] . 'min' . DS;
  $api_paths['dirs']['api_user_dir'] = $api_paths['dirs']['api_base_dir'] . 'users' . DS;
  $api_paths['dirs']['api_user_min_dir'] = $api_paths['dirs']['api_base_min_dir'] . 'users' . DS;
  $api_paths['dirs']['api_user_model_dir'] = $api_paths['dirs']['api_user_dir'] . DS . 'models' . DS;
  $api_paths['dirs']['api_user_model_min_dir'] = $api_paths['dirs']['api_user_min_dir'] . DS . 'models' . DS;
  $api_paths['dirs']['api_user_page_dir'] = $api_paths['dirs']['api_user_dir'] . DS . 'pages' . DS;
  $api_paths['dirs']['api_user_page_min_dir'] = $api_paths['dirs']['api_user_min_dir'] . DS . 'pages' . DS;

  $api_paths['dirs']['api_log_dir'] = $api_paths['dirs']['api_base_dir'] . 'logs' . DS;
  $api_paths['dirs']['api_log_min_dir'] = $api_paths['dirs']['api_base_min_dir'] . 'logs' . DS;

  $api_paths['dirs']['api_conversion_dir'] =$api_paths['dirs']['api_log_dir'] . 'conversions' . DS;
  $api_paths['dirs']['api_conversion_min_dir'] =$api_paths['dirs']['api_log_min_dir'] . 'conversions' . DS;
  $api_paths['dirs']['api_conversion_model_dir'] =$api_paths['dirs']['api_conversion_dir'] . 'models' . DS;
  $api_paths['dirs']['api_conversion_model_min_dir'] =$api_paths['dirs']['api_conversion_min_dir'] . 'models' . DS;

  $api_paths['dirs']['api_impression_dir'] = $api_paths['dirs']['api_log_dir'] . 'impressions' . DS;
  $api_paths['dirs']['api_impression_min_dir'] = $api_paths['dirs']['api_log_min_dir'] . 'impressions' . DS;
  $api_paths['dirs']['api_impression_model_dir'] = $api_paths['dirs']['api_impression_dir'] . 'models' . DS;
  $api_paths['dirs']['api_impression_model_min_dir'] = $api_paths['dirs']['api_impression_min_dir'] . 'models' . DS;

  $api_paths['files']['api_user_file'] = $api_paths['dirs']['api_user_dir'] . 'index.json';
  $api_paths['files']['api_user_min_file'] = $api_paths['dirs']['api_user_min_dir'] . 'index.json';
  $api_paths['files']['api_conversion_file'] = $api_paths['dirs']['api_conversion_dir'] . 'index.json';
  $api_paths['files']['api_conversion_min_file'] = $api_paths['dirs']['api_conversion_min_dir'] . 'index.json';
  $api_paths['files']['api_impression_file'] = $api_paths['dirs']['api_impression_dir'] . 'index.json';
  $api_paths['files']['api_impression_min_file'] = $api_paths['dirs']['api_impression_min_dir'] . 'index.json';
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

  function sort_users_by_name($a, $b) {
    return strcmp($a->name, $b->name);
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

  function pretty_log_json($string = "") {
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

  function create_api_impression_file() {
    global $data;
    global $api_paths;
    if (!file_exists($api_paths['dirs']['api_impression_dir'])) {
      mkdir($api_paths['dirs']['api_impression_dir'], 0755, true);
      mkdir($api_paths['dirs']['api_impression_model_dir'], 0755, true);
    }
    if (!file_exists($api_paths['dirs']['api_impression_min_dir'])) {
      mkdir($api_paths['dirs']['api_impression_min_dir'], 0755, true);
      mkdir($api_paths['dirs']['api_impression_model_min_dir'], 0755, true);
    }
    foreach($data['impressions'] as $ui_key=>$ui_val) {
      usort($data['impressions'][$ui_key], 'sort_log_by_time');
      $ui_string = json_encode($data['impressions'][$ui_key]);
      file_put_contents($api_paths['dirs']['api_impression_model_min_dir'] . $ui_key . '.json', $ui_string);
      $ui_string = pretty_log_json($ui_string);
      file_put_contents($api_paths['dirs']['api_impression_model_dir'] . $ui_key . '.json', $ui_string);
    }
    sort($data['impressions']);
    $imp_string = json_encode($data['impressions']);
    file_put_contents($api_paths['files']['api_impression_min_file'], $imp_string);
    $imp_string = pretty_log_json($imp_string);
    file_put_contents($api_paths['files']['api_impression_file'], $imp_string);
  }

  function create_api_conversion_file() {
    global $data;
    global $api_paths;
    if (!file_exists($api_paths['dirs']['api_conversion_dir'])) {
      mkdir($api_paths['dirs']['api_conversion_dir'], 0755, true);
      mkdir($api_paths['dirs']['api_conversion_model_dir'], 0755, true);
    }
    if (!file_exists($api_paths['dirs']['api_conversion_min_dir'])) {
      mkdir($api_paths['dirs']['api_conversion_min_dir'], 0755, true);
      mkdir($api_paths['dirs']['api_conversion_model_min_dir'], 0755, true);
    }
    foreach($data['conversions'] as $uc_key=>$uc_val) {
      usort($data['conversions'][$uc_key], 'sort_log_by_time');
      $uc_string = json_encode($data['conversions'][$uc_key]);
      file_put_contents($api_paths['dirs']['api_conversion_model_min_dir'] . $uc_key . '.json', $uc_string);
      $uc_string = pretty_log_json($uc_string);
      file_put_contents($api_paths['dirs']['api_conversion_model_dir'] . $uc_key . '.json', $uc_string);
    }
    sort($data['conversions']);
    $conv_string = json_encode($data['conversions']);
    file_put_contents($api_paths['files']['api_conversion_min_file'], $conv_string);
    $conv_string = pretty_log_json($conv_string);
    file_put_contents($api_paths['files']['api_conversion_file'], $conv_string);
  }

  function create_user_page_files($users = array()) {
    global $data;
    global $api_paths;
    $pages = array_chunk($users, 9);
    foreach($pages as $p=>$page) {
      $page_string = json_encode($page);
      file_put_contents($api_paths['dirs']['api_user_page_min_dir'] . ($p+1) . '.json', $page_string);
      $page_string = pretty_user_json($page_string);
      file_put_contents($api_paths['dirs']['api_user_page_dir'] . ($p+1) . '.json', $page_string);
    }
  }

  function create_api_user_files() {
    global $data;
    global $api_paths;
    if (!file_exists($api_paths['dirs']['api_user_dir'])) {
      mkdir($api_paths['dirs']['api_user_dir'], 0755, true);
      mkdir($api_paths['dirs']['api_user_page_dir'], 0755, true);
      mkdir($api_paths['dirs']['api_user_model_dir'], 0755, true);
      mkdir($api_paths['dirs']['api_user_min_dir'], 0755, true);
      mkdir($api_paths['dirs']['api_user_page_min_dir'], 0755, true);
      mkdir($api_paths['dirs']['api_user_model_min_dir'], 0755, true);
    }
    $users = json_decode(file_get_contents($api_paths['files']['data_user_min_file']));
    usort($users, 'sort_users_by_name');
    $user_string = json_encode($users);
    file_put_contents($api_paths['files']['api_user_min_file'], $user_string);
    $user_string = pretty_user_json($user_string);
    file_put_contents($api_paths['files']['api_user_file'], $user_string);
    usort($users, 'sort_users_by_name');
    create_user_page_files($users);
    create_log_files();
    foreach($users as $u=>$user) {
      $user->occupation = ucwords($user->occupation);
      $data['users'][$u] = $user;
      $user_string = json_encode($user);
      file_put_contents($api_paths['dirs']['api_user_model_min_dir'] . $user->id . '.json', $user_string);
      $user_string = pretty_user_json($user_string);
      file_put_contents($api_paths['dirs']['api_user_model_dir'] . $user->id . '.json', $user_string);
    }
  }

  function create_log_files() {
    global $api_paths;
    global $data;
    $log_array = json_decode(file_get_contents($api_paths['files']['data_log_min_file']));
    for ($i = 0, $l = count($log_array); $i < $l; $i++) {
      $log = $log_array[$i];
      if (!isset($log->id)) {
        $log->id = $i + 1;
      }
      switch(strtolower($log->type)) {
        case 'impression':
        if (!isset($data['impressions'][$log->user_id])) {
          $data['impressions'][$log->user_id] = array();
        }
        $data['impressions'][$log->user_id][] = $log;
        break;
        case 'conversion':
        if (!isset($data['conversions'][$log->user_id])) {
          $data['conversions'][$log->user_id] = array();
        }
        $data['conversions'][$log->user_id][] = $log;
        break;
      }
      unset($log_array[$i]);
    }
    unset($log_array);
    create_api_conversion_file();
    create_api_impression_file();
  }

  function build_cache() {
    global $data;
    global $api_paths;
    $data = array(
      'impressions' => array(),
      'conversions' => array(),
      'users' => array()
    );
    if (!file_exists($api_paths['dirs']['api_base_dir'])) {
      mkdir($api_paths['dirs']['api_base_dir'], 0755, true);
      mkdir($api_paths['dirs']['api_base_min_dir'], 0755, true);
      mkdir($api_paths['dirs']['api_log_dir'], 0755, true);
      mkdir($api_paths['dirs']['api_log_min_dir'], 0755, true);
      create_api_user_files();
    } else {
      $data['conversions'] = json_decode(file_get_contents($api_paths['files']['api_conversion_min_file']));
      $data['impressions'] = json_decode(file_get_contents($api_paths['files']['api_impression_min_file']));
      $data['users'] = json_decode(file_get_contents($api_paths['files']['api_user_min_file']));
    }
  }

  build_cache();
?>