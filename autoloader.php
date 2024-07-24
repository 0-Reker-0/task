<?php
/**
 * Автолоудер классов для удобства
 */
function autolad(){
    include_once('api/global/href.php');
    include_once('api/global/sender.php');
    include_once('api/login.php');
    include_once('api/logout.php');
    include_once('api/get/get_info.php');
    include_once('api/get/get_tasks.php');
    include_once('api/set/comment.php');
    include_once('api/set/file_send.php');
}
spl_autoload_register('autolad');