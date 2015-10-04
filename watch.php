<?php
	 // function check_data_for_changes($filename = "") {
  //   if (!empty($filename) && file_exists($filename)) {
  //     $fd = inotify_init();
  //     $watch_descriptor = inotify_add_watch($fd, __FILE__, IN_ATTRIB);
  //     touch(__FILE__);
  //     $events = inotify_read($fd);
  //     var_dump($events);
  //     $read = array($fd);
  //     $write = null;
  //     $except = null;
  //     stream_select($read,$write,$except,0);
  //     stream_set_blocking($fd, 0);
  //     inotify_read($fd);
  //     $queue_len = inotify_queue_len($fd);
  //     inotify_rm_watch($fd, $watch_descriptor);
  //     fclose($fd);
  //   }
  // }
?>