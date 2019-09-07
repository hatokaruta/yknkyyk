<?php
ini_set('display_errors', "On");

// TODO バグ：席検索の条件を変更した状態で検索せずに予約確定すると条件と実際に選んだ席が不一致となる

require_once 'env.php';
require_once 'common.php';
require_once 'ReserveDetail.php';

try {
    process_view(process_model(connectdb()));
} catch (Exception $e) {
    header('Content-Type: text/plain; charset=UTF-8', true, 500);
    exit($e->getMessage());
}

function process_model($pdo) {
    $model = new ReserveDetail($pdo, $_SERVER, $_REQUEST);
    $model->preprocess();
    $model->process();
    return $model;
}

function process_view($model) {
    require 'reserve_detail_view.php';
    $model->postprocess();
}
