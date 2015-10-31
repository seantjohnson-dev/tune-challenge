<?php 

  phpinfo();
  exit;

  if ( !defined('DS') ) {
    define('DS', DIRECTORY_SEPARATOR);
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

  // class workerApiThread extends Thread {

  //   public $index_basename = 'index';

  //   public $extension = '.json';

  //   public $min_dir_name = 'min';

  //   public $user_dirname = 'users';

  //   public $log_dirname = 'logs';

  //   public $impression_dirname = 'impressions';

  //   public $conversion_dirname = 'conversions';

  //   public $model_dirname = 'models';

  //   public $page_dirname = 'pages';

  //   public $api_dirname = 'api';

  //   public $data_dirname = 'data';

  //   public $file_paths = array();

  //   public $dir_paths = array();

  //   public $options = array();

  //   public $data = array(
  //     'logs' => array(
  //       'impressions' => array(
  //         'models' => array(),
  //         'all' => array()
  //       ),
  //       'conversions' => array(
  //         'models' => array(),
  //         'all' => array()
  //       ),
  //     ),
  //     'impressions' => array(),
  //     'conversions' => array(),
  //     'users' => array()
  //   );

  //   private function _add_ds_to_dirnames() {
  //     $this->data_dirname  .= DS;
  //     $this->api_dirname  .= DS;
  //     $this->min_dirname  .= DS;

  //     $this->user_dirname  .= DS;
  //     $this->log_dirname  .= DS;

  //     $this->impression_dirname  .= DS;
  //     $this->conversion_dirname  .= DS;

  //     $this->model_dirname  .= DS;
  //     $this->page_dirname  .= DS;

  //     $this->data_base = __DIR__ . DS . $this->data_dirname;
  //     $this->api_base = __DIR__ . DS . $this->api_dirname;

  //     return $this;
  //   }

  //   public function __construct($options = array()) {
  //     $this->options = array_merge($this->options, (is_array($options) ? $options : array()));
  //     $this->_add_ds_to_dirnames();
  //     $this->create_dir_paths();
  //     $this->create_file_paths();
  //   }

  //   protected function create_dir_paths() {
  //     $this->dir_paths = new stdClass;

  //     $this->dir_paths->data = $this->data_base;
  //     $this->dir_paths->data_min = $this->dir_paths->data . $this->min_dir_name;

  //     $this->dir_paths->api = $this->api_base;
  //     $this->dir_paths->api_min = $this->dir_paths->api . $this->min_dir_name;

  //     $this->dir_paths->user = $this->dir_paths->api . $this->user_dirname;
  //     $this->dir_paths->user_min = $this->dir_paths->api_min . $this->user_dirname;

  //     $this->dir_paths->user_model = $this->dir_paths->user . $this->model_dirname;
  //     $this->dir_paths->user_model_min = $this->dir_paths->user_min . $this->model_dirname;

  //     $this->dir_paths->user_page = $this->dir_paths->user . $this->page_dirname;
  //     $this->dir_paths->user_page_min = $this->dir_paths->user_min . $this->page_dirname;

  //     $this->dir_paths->log = $this->dir_paths->api . $this->log_dirname;
  //     $this->dir_paths->log_min = $this->dir_paths->api_min . $this->log_dirname;

  //     $this->dir_paths->impression = $this->dir_paths->log . $this->impression_dirname;
  //     $this->dir_paths->impression_min = $this->dir_paths->log_min . $this->impression_dirname;

  //     $this->dir_paths->impression_model = $this->dir_paths->impression . $this->model_dirname;
  //     $this->dir_paths->impression_model_min = $this->dir_paths->impression_min . $this->model_dirname;

  //     $this->dir_paths->conversion = $this->dir_paths->log . $this->conversion_dirname;
  //     $this->dir_paths->conversion_min = $this->dir_paths->log_min . $this->conversion_dirname;

  //     $this->dir_paths->conversion_model = $this->dir_paths->conversion . $this->model_dirname;
  //     $this->dir_paths->conversion_model_min = $this->dir_paths->conversion_min . $this->model_dirname;

  //   }

  //   protected function create_file_paths() {
  //     $this->file_paths = new stdClass;

  //     $filename = $this->index_basename . $this->extension;

  //     $this->file_paths->data_user = $this->dir_paths->data . $user_path;
  //     $this->file_paths->data_user_min = $this->dir_paths->data_min . $user_path;

  //     $this->file_paths->data_log = $this->dir_paths->data . $log_path;
  //     $this->file_paths->data_log_min = $this->dir_paths->data_min . $log_path;

  //     $log_path = $this->user_dirname . $filename;
  //     $this->file_paths->log = $this->dir_paths->log . $log_path;
  //     $this->file_paths->log_min = $this->dir_paths->log_min . $log_path;

  //     $user_path = $this->user_dirname . $filename;
  //     $this->file_paths->user = $this->dir_paths->api . $user_path;
  //     $this->file_paths->user_min = $this->dir_paths->api_min . $user_path;

  //     $imp_path = $this->impression_dirname . $filename;
  //     $this->file_paths->impression = $this->dir_paths->impression . $imp_path;
  //     $this->file_paths->impression_min = $this->dir_paths->impression_min . $imp_path;

  //     $conv_path = $this->conversion_dirname . $filename;
  //     $this->file_paths->conversion = $this->dir_paths->conversion . $conv_path;
  //     $this->file_paths->conversion_min = $this->dir_paths->conversion_min . $conv_path;

  //   }

  //   protected function create_api_user_files() {
  //     if (!file_exists($this->file_paths['dirs']['api_user_path'])) {
  //       mkdir($this->file_paths['dirs']['api_user_path'], 0755, true);
  //     }
  //     if (!file_exists($this->file_paths['dirs']['api_user_min_path'])) {
  //       mkdir($this->file_paths['dirs']['api_user_min_path'], 0755, true);
  //     }
  //     $users = json_decode(file_get_contents($this->file_paths['files']['data_user_min_file']));
  //     usort($users, 'sort_users_by_name');
  //     $user_string = json_encode($users);
  //     file_put_contents($this->file_paths['files']['api_user_min_file'], $user_string);
  //     $user_string = pretty_user_json($user_string);
  //     file_put_contents($this->file_paths['files']['api_user_file'], $user_string);
  //     unset($user_string);
  //     $this->create_api_user_page_files($users);
  //     $this->create_api_user_model_files($users);
  //     unset($users);
  //   }

  //   protected function create_api_user_model_files($users = array()) {
  //     if (!file_exists($this->file_paths['dirs']['api_user_model_path'])) {
  //       mkdir($this->file_paths['dirs']['api_user_model_path'], 0755, true);
  //     }
  //     if (!file_exists($this->file_paths['dirs']['api_user_model_min_path'])) {
  //       mkdir($this->file_paths['dirs']['api_user_model_min_path'], 0755, true);
  //     }
  //     foreach($users as $u=>$user) {
  //       $user->occupation = ucwords($user->occupation);
  //       $this->data['users'][$u] = $user;
  //       $user_string = json_encode($user);
  //       file_put_contents($this->file_paths['dirs']['api_user_model_min_path'] . $user->id . '.json', $user_string);
  //       $user_string = pretty_user_json($user_string);
  //       file_put_contents($this->file_paths['dirs']['api_user_model_path'] . $user->id . '.json', $user_string);
  //       unset($user_string);
  //     }
  //     sort($this->data['users']);
  //   }

  //   protected function create_api_user_page_files($users = array()) {
  //     if (!file_exists($this->file_paths['dirs']['api_user_page_path'])) {
  //       mkdir($this->file_paths['dirs']['api_user_page_path'], 0755, true);
  //     }
  //     if (!file_exists($this->file_paths['dirs']['api_user_page_min_path'])) {
  //       mkdir($this->file_paths['dirs']['api_user_page_min_path'], 0755, true);
  //     }
  //     $pages = array_chunk($users, 9);
  //     foreach($pages as $p=>$page) {
  //       $page_string = json_encode($page);
  //       file_put_contents($this->file_paths['dirs']['api_user_page_min_path'] . ($p+1) . '.json', $page_string);
  //       $page_string = pretty_user_json($page_string);
  //       file_put_contents($this->file_paths['dirs']['api_user_page_path'] . ($p+1) . '.json', $page_string);
  //     }
  //   }

  //   protected function create_api_log_type_files($dir, $min, $type) {
  //     if (!file_exists($dir)) {
  //       mkdir($dir, 0755, true);
  //     }
  //     if (!file_exists($min)) {
  //       mkdir($min, 0755, true);
  //     }
  //     sort($this->data[$type]);
  //     $json_string = json_encode($this->data[$type]);
  //     file_put_contents($min . $this->index_basename, $json_string);
  //     $json_string = pretty_log_json($json_string);
  //     file_put_contents($dir . $this->index_basename, $json_string);
  //     unset($json_string);
  //     foreach($this->data[$type] as $s=>$set) {
  //       $this->create_api_log_model_files($this->file_paths['dirs'][$type]['models'], $this->file_paths['dirs']['min'][$type]['models'], $set);
  //     }
  //   }

  //   protected function create_api_conversion_files() {
  //     $dir = $this->file_paths['dirs']['api_conversion_path'];
  //     $min = $this->file_paths['dirs']['api_conversion_min_path'];
  //     $type = 'conversions';
  //     $this->create_api_log_type_files($dir, $min, $type);
  //   }

  //   protected function create_api_impression_files() {
  //     $dir = $this->file_paths['dirs']['api_impression_path'];
  //     $min = $this->file_paths['dirs']['api_impression_min_path'];
  //     $type = 'impressions';
  //     $this->create_api_log_type_files($dir, $min, $type);
  //   }

  //   protected function create_api_model_files($dir, $min, $model_array) {
  //     if (!file_exists($dir)) {
  //       mkdir($dir, 0755, true);
  //     }
  //     if (!file_exists($min)) {
  //       mkdir($min, 0755, true);
  //     }
  //     foreach($model_array as $m=>$model) {
  //       $this->data['users'][$m] = $model;
  //       $json_string = json_encode($model);
  //       // file_put_contents($min . $model->{$this->} . '.json', $json_string);
  //       $json_string = pretty_user_json($json_string);
  //       file_put_contents($dir . $model->id . '.json', $json_string);
  //       unset($json_string);
  //     }
  //     sort($this->data['users']);
  //   }

  //   protected function set_log_by_type($log) {
  //     switch(strtolower($log->type)) {
  //       case 'impression':
  //       if (!isset($this->data['impressions'][$log->user_id])) {
  //         $this->data['impressions'][$log->user_id] = array();
  //       }
  //       $this->data['impressions'][$log->user_id][] = $log;
  //       break;
  //       case 'conversion':
  //       if (!isset($this->data['conversions'][$log->user_id])) {
  //         $this->data['conversions'][$log->user_id] = array();
  //       }
  //       $this->data['conversions'][$log->user_id][] = $log;
  //       break;
  //     }
  //   }

  //   protected function create_api_log_files() {
  //     if (!file_exists($this->file_paths['dirs']['api_log_path'])) {
  //       mkdir($this->file_paths['dirs']['api_log_path'], 0755, true);
  //     }
  //     if (!file_exists($this->file_paths['dirs']['api_log_min_path'])) {
  //       mkdir($this->file_paths['dirs']['api_log_min_path'], 0755, true);
  //     }
  //     $log_array = json_decode(file_get_contents($this->file_paths['files']['data_log_min_file']));
  //     usort($log_array, 'sort_log_by_time');
  //     $log_string = json_encode($log_array);
  //     file_put_contents($this->file_paths['files']['api_log_min_file'], $log_string);
  //     $log_string = pretty_log_json($log_string);
  //     file_put_contents($this->file_paths['files']['api_log_file'], $log_string);
  //     unset($log_string);
  //     for ($i = 0, $l = count($log_array); $i < $l; $i++) {
  //       if (!isset($log_array[$i]->id)) {
  //         $log_array[$i]->id = $i + 1;
  //       }
  //       $this->set_log_by_type($log_array[$i]);
  //       unset($log_array[$i]);
  //     }
  //     unset($log_array);
  //     $this->create_api_conversion_files();
  //     $this->create_api_impression_files();
  //   }

  //   public function run() {
  //     mkdir($this->base_api_path, 0755, true);
  //     mkdir($this->file_paths['dirs']['base_min_path'], 0755, true);
  //     $this->create_api_user_files();
  //     $this->create_api_log_files();
  //     $this->kill();
  //   }
  // }

  // if (!file_exists(__DIR__ . DS . 'data' . DS)) {
  //   $worker = new workerApiThread(__DIR__ . DS . 'data' . DS);
  //   $worker->start();
  // }


  class testClass extends stdClass {

    public $index_basename = 'index';

    public $extension = '.json';

    public $min_dir_name = 'min';

    public $user_dirname = 'users';

    public $log_dirname = 'logs';

    public $impression_dirname = 'impressions';

    public $conversion_dirname = 'conversions';

    public $model_dirname = 'models';

    public $page_dirname = 'pages';

    public $api_dirname = 'api';

    public $data_dirname = 'data';

    public $file_paths = array();

    public $dir_paths = array();

    public $options = array();

    public function __construct($options = array()) {
      $this->options = array_merge($this->options, (is_array($options) ? $options : array()));
      $this->_add_ds_to_dirnames()->create_dir_paths()->create_file_paths();
    }

    private function _add_ds_to_dirnames() {
      $this->data_dirname  .= DS;
      $this->api_dirname  .= DS;
      $this->min_dirname  .= DS;

      $this->user_dirname  .= DS;
      $this->log_dirname  .= DS;

      $this->impression_dirname  .= DS;
      $this->conversion_dirname  .= DS;

      $this->model_dirname  .= DS;
      $this->page_dirname  .= DS;

      $this->data_base = __DIR__ . DS . $this->data_dirname;
      $this->api_base = __DIR__ . DS . $this->api_dirname;

      return $this;
    }

    protected function create_dir_paths() {
      $this->dir_paths = new stdClass;

      $this->dir_paths->data = $this->base_data_path;
      $this->dir_paths->data_min = $this->dir_paths->data . $this->min_dir_name;

      $this->dir_paths->api = $this->base_api_path;
      $this->dir_paths->api_min = $this->dir_paths->api . $this->min_dir_name;

      $this->dir_paths->user = $this->dir_paths->api . $this->user_dirname;
      $this->dir_paths->user_min = $this->dir_paths->api_min . $this->user_dirname;

      $this->dir_paths->user_model = $this->dir_paths->user . $this->model_dirname;
      $this->dir_paths->user_model_min = $this->dir_paths->user_min . $this->model_dirname;

      $this->dir_paths->user_page = $this->dir_paths->user . $this->page_dirname;
      $this->dir_paths->user_page_min = $this->dir_paths->user_min . $this->page_dirname;

      $this->dir_paths->log = $this->dir_paths->api . $this->log_dirname;
      $this->dir_paths->log_min = $this->dir_paths->api_min . $this->log_dirname;

      $this->dir_paths->impression = $this->dir_paths->log . $this->impression_dirname;
      $this->dir_paths->impression_min = $this->dir_paths->log_min . $this->impression_dirname;

      $this->dir_paths->impression_model = $this->dir_paths->impression . $this->model_dirname;
      $this->dir_paths->impression_model_min = $this->dir_paths->impression_min . $this->model_dirname;

      $this->dir_paths->conversion = $this->dir_paths->log . $this->conversion_dirname;
      $this->dir_paths->conversion_min = $this->dir_paths->log_min . $this->conversion_dirname;

      $this->dir_paths->conversion_model = $this->dir_paths->conversion . $this->model_dirname;
      $this->dir_paths->conversion_model_min = $this->dir_paths->conversion_min . $this->model_dirname;

      return $this;
    }

    protected function create_file_paths() {
      $this->file_paths = new stdClass;

      $filename = $this->index_basename . $this->extension;

      $this->file_paths->data_user = $this->dir_paths->data . $user_path;
      $this->file_paths->data_user_min = $this->dir_paths->data_min . $user_path;

      $this->file_paths->data_log = $this->dir_paths->data . $log_path;
      $this->file_paths->data_log_min = $this->dir_paths->data_min . $log_path;

      $log_path = $this->user_dirname . $filename;
      $this->file_paths->log = $this->dir_paths->log . $log_path;
      $this->file_paths->log_min = $this->dir_paths->log_min . $log_path;

      $user_path = $this->user_dirname . $filename;
      $this->file_paths->user = $this->dir_paths->api . $user_path;
      $this->file_paths->user_min = $this->dir_paths->api_min . $user_path;

      $imp_path = $this->impression_dirname . $filename;
      $this->file_paths->impression = $this->dir_paths->impression . $imp_path;
      $this->file_paths->impression_min = $this->dir_paths->impression_min . $imp_path;

      $conv_path = $this->conversion_dirname . $filename;
      $this->file_paths->conversion = $this->dir_paths->conversion . $conv_path;
      $this->file_paths->conversion_min = $this->dir_paths->conversion_min . $conv_path;

      return $this;
    }
  }

  $test = new testClass();

  var_dump($test); exit;
?>