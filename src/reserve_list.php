<?php
ini_set('display_errors', "On");

require_once 'env.php';
require_once 'common.php';
require_once 'ReserveList.php';

try {
    process_view(process_model(connectdb()));
} catch (Exception $e) {
    header('Content-Type: text/plain; charset=UTF-8', true, 500);
    exit($e->getMessage());
}

function process_model($pdo) {
    $model = new ReserveList($pdo, $_SERVER, $_REQUEST);
    $model->preprocess();
    $model->process();
    return $model;
}

function process_view($model) {
    require 'reserve_list_view.php';
    $model->postprocess();
}
