<?php
    $dbConfig=require CONFIG_PATH.'/config.db.php';
    $setting=require CONFIG_PATH.'/config.setting.php';
    return array_merge($dbConfig,$setting);