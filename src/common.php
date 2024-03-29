<?php
//TODO テストコード
//TODO DBコードのDAO化

class ActionInfo {
    public $cmd;

    public function __construct($server, $request) {
        $this->cmd = get_request($request, "cmd");
    }
}

function get_request($req, $key, $def = '') {
    return array_key_exists($key, $req) ? $req[$key] : $def;
}

function connectdb() {
    global $dbuser;
    global $dbpass;

    try {

        $pdo = new PDO(
            "mysql:dbname=reserve_db;host=localhost;charset=utf8mb4",
            $dbuser,
            $dbpass, 
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );
    } catch (PDOException $e) {
        header('Content-Type: text/plain; charset=UTF-8', true, 500);
        exit($e->getMessage()); 
    }

    return $pdo;
}

function get_reserve_id($pdo) {
    return sprintf("R%06d", get_seq($pdo, "reserve_seq"));
}

function get_reserve_seat_id($pdo) {
    return sprintf("RS%05d", get_seq($pdo, "reserve_seat_seq"));
}

function get_customer_id($pdo) {
    return sprintf("C%04d", get_seq($pdo, "customer_seq"));
}

function get_seq($pdo, $column) {
    $count = $pdo->exec("update seq set ${column} = last_insert_id(${column} + 1);");
    $stmt = $pdo->query("select last_insert_id()");
    return $stmt->fetchAll(PDO::FETCH_COLUMN)[0];
}

function insert_reserve_info($pdo, $reserve_id, $customer_id, $customer_name, $customer_tel, $reserve_date_from, $reserve_date_to, $reserve_quantity, $seat_type, $smoking_flg, $reserve_seat_id, $reserve_notes) {
    $sql = <<< EOM
insert into reserve_info
(
  reserve_id
 ,customer_id
 ,customer_name
 ,customer_tel
 ,reserve_date_from
 ,reserve_date_to
 ,reserve_quantity
 ,seat_type
 ,smoking_flg
 ,reserve_seat_id
 ,reserve_notes
 ,insert_date
 ,update_date
) values(
  :reserve_id
 ,:customer_id
 ,:customer_name
 ,:customer_tel
 ,:reserve_date_from
 ,:reserve_date_to
 ,:reserve_quantity
 ,:seat_type
 ,:smoking_flg
 ,:reserve_seat_id
 ,:reserve_notes
 ,current_timestamp
 ,current_timestamp
)
EOM;
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':reserve_id', $reserve_id);
    $stmt->bindValue(':customer_id', $customer_id);
    $stmt->bindValue(':customer_name', $customer_name);
    $stmt->bindValue(':customer_tel', $customer_tel);
    $stmt->bindValue(':reserve_date_from', $reserve_date_from);
    $stmt->bindValue(':reserve_date_to', $reserve_date_to);
    $stmt->bindValue(':reserve_quantity', (int)$reserve_quantity, PDO::PARAM_INT);
    $stmt->bindValue(':seat_type', $seat_type);
    $stmt->bindValue(':smoking_flg', (int)$smoking_flg, PDO::PARAM_INT);
    $stmt->bindValue(':reserve_seat_id', $reserve_seat_id);
    $stmt->bindValue(':reserve_notes', $reserve_notes);
    $stmt->execute();
    return $stmt->rowCount();
}

function update_reserve_info($pdo, $reserve_id, $customer_id, $customer_name, $customer_tel, $reserve_date_from, $reserve_date_to, $reserve_quantity, $seat_type, $smoking_flg, $reserve_seat_id, $reserve_notes) {
    $sql = <<< EOM
update reserve_info
set
  customer_name = :customer_name
 ,customer_tel = :customer_tel
 ,reserve_date_from = :reserve_date_from
 ,reserve_date_to = :reserve_date_to
 ,reserve_quantity = :reserve_quantity
 ,seat_type = :seat_type
 ,smoking_flg = :smoking_flg
 ,reserve_notes = :reserve_notes
 ,update_date = current_timestamp
where
  reserve_id = :reserve_id
EOM;
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':reserve_id', $reserve_id);
    $stmt->bindValue(':customer_name', $customer_name);
    $stmt->bindValue(':customer_tel', $customer_tel);
    $stmt->bindValue(':reserve_date_from', $reserve_date_from);
    $stmt->bindValue(':reserve_date_to', $reserve_date_to);
    $stmt->bindValue(':reserve_quantity', (int)$reserve_quantity, PDO::PARAM_INT);
    $stmt->bindValue(':seat_type', $seat_type);
    $stmt->bindValue(':smoking_flg', (int)$smoking_flg, PDO::PARAM_INT);
    $stmt->bindValue(':reserve_notes', $reserve_notes);
    $stmt->execute();
    return $stmt->rowCount();
}

function update_reserve_info_cancel($pdo, $reserve_id, $cancel_reason) {
    $sql = <<< EOM
update reserve_info
set
  cancel_reason = :cancel_reason
 ,cancel_date = current_timestamp
 ,update_date = current_timestamp
where
  reserve_id = :reserve_id
EOM;
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':reserve_id', $reserve_id);
    $stmt->bindValue(':cancel_reason', $cancel_reason);
    $stmt->execute();
    return $stmt->rowCount();
}

function insert_reserve_seat_info($pdo, $reserve_seat_id, $reserve_id, $seat_id) {
    $sql = <<< EOM
insert into reserve_seat_info
(
  reserve_seat_id
 ,reserve_id
 ,seat_id
 ,insert_date
 ,update_date
) values(
  :reserve_seat_id
 ,:reserve_id
 ,:seat_id
 ,current_timestamp
 ,current_timestamp
)
EOM;
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':reserve_seat_id', $reserve_seat_id);
    $stmt->bindValue(':reserve_id', $reserve_id);
    $stmt->bindValue(':seat_id', $seat_id);
    $stmt->execute();
    return $stmt->rowCount();
}

function delete_reserve_seat_info($pdo, $reserve_seat_id) {
    $sql = <<< EOM
delete from reserve_seat_info
where
  reserve_seat_id = :reserve_seat_id
EOM;
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':reserve_seat_id', $reserve_seat_id);
    $stmt->execute();
    return $stmt->rowCount();
}

function insert_m_customer($pdo, $customer_id, $customer_tel, $customer_name) {
    $sql = <<< EOM
insert into m_customer (
  customer_id
 ,customer_tel
 ,customer_name
 ,insert_date
 ,update_date
) values(
  :customer_id
 ,:customer_tel
 ,:customer_name
 ,current_timestamp
 ,current_timestamp
)
EOM;
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':customer_id', $customer_id);
    $stmt->bindValue(':customer_tel', $customer_tel);
    $stmt->bindValue(':customer_name', $customer_name);
    $stmt->execute();
    return $stmt->rowCount();
}

function update_m_customer($pdo, $customer_id, $customer_tel, $customer_name) {
    $sql = <<< EOM
update m_customer
set
  customer_tel = :customer_tel
 ,customer_name = :customer_name
 ,update_date = current_timestamp
where
  customer_id = :customer_id
EOM;
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':customer_id', $customer_id);
    $stmt->bindValue(':customer_tel', $customer_tel);
    $stmt->bindValue(':customer_name', $customer_name);
    $stmt->execute();
    return $stmt->rowCount();
}

function select_reserve_list($pdo) {
    $sql = <<< EOM
select
  ri.reserve_id
 ,ri.customer_name
 ,ri.customer_tel
 ,ri.reserve_date_from
 ,ri.reserve_date_to
 ,ri.reserve_quantity
 ,group_concat(ms.seat_name order by ms.seat_id separator '/') as seat_name
from
  reserve_info ri
  inner join reserve_seat_info rsi
    on ri.reserve_seat_id = rsi.reserve_seat_id
  inner join m_seat ms
    on rsi.seat_id = ms.seat_id
group by
  ri.reserve_id
order by
  ri.reserve_date_from
 ,ri.reserve_id
EOM;
//    $sql = "SELECT * FROM reserve_info";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt;
}

function select_reserve_detail($pdo, $reserve_id) {
    //$sql = "select ms.* from m_seat ms inner join reserve_seat_info rsi on rsi.seat_id = ms.seat_id inner join reserve_info ri on ri.reserve_seat_id = rsi.reserve_seat_id where ri.reserve_id = :reserve_id";
    $sql = <<< EOM
select
  ri.reserve_id
 ,ri.customer_name
 ,ri.customer_tel
 ,ri.reserve_date_from
 ,ri.reserve_date_to
 ,ri.reserve_quantity
 ,ri.seat_type
 ,ri.smoking_flg
 ,ri.reserve_notes
 ,ri.cancel_reason
 ,group_concat(rsi.seat_id order by rsi.seat_id separator ',') as seat_id_list
from
  reserve_info ri
  inner join reserve_seat_info rsi
    on ri.reserve_seat_id = rsi.reserve_seat_id
where
  ri.reserve_id = :reserve_id
group by
  ri.reserve_id
order by
  ri.reserve_date_from
 ,ri.reserve_id
EOM;
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':reserve_id', $reserve_id);
    $stmt->execute();
    return $stmt;
}

function select_m_seat($pdo, $seat_type, $smoking_flg) {
    $sql = <<< EOM
select
  *
from
  m_seat
where
  (seat_type = :seat_type or :seat_type = 'none')
  and (smoking_flg = :seat_smoke or :seat_smoke = -1)
EOM;
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':seat_type', $seat_type);
    $stmt->bindValue(':seat_smoke', (int)$smoking_flg, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt;
}

function select_reserve_info($pdo, $reserve_id) {
    $sql = <<< EOM
select
  *
from
  reserve_info
where
  reserve_id = :reserve_id
EOM;
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':reserve_id', $reserve_id);
    $stmt->execute();
    return $stmt;
}

function get_seat_name($seat_type) {
    switch ($seat_type) {
        case "box":
            return "ボックス席";
            break;
        case "counter":
            return "カウンター席";
            break;
        case "table":
            return "テーブル席";
            break;
    }
    return "";
}

function get_smoke_name($smoking_flg) {
    switch ($smoking_flg) {
        case "0":
            return "×";
            break;
        case "1":
            return "◯";
            break;
    }
    return "";
}

//TODO データ型にあわせてちゃんと変換
function format_reserve_date($date_from, $date_to) {
    return sprintf("%s - %s", mb_substr($date_from, 0, 16), mb_substr($date_to, 11, 5));
}

//TODO データ型にあわせてちゃんと抽出
function split_date($datetime) {
    return mb_substr($datetime, 0, 10);
}

//TODO データ型にあわせてちゃんと抽出
function split_time($datetime) {
    return mb_substr($datetime, 11, 5);
}

function to_array($str) {
    return explode(",", $str);
}

// if ($env === "develop") {
//     echo "<pre>";
//     print_r($_REQUEST);
//     echo "</pre>";
// }
