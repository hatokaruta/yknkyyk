<?php
ini_set('display_errors', "On");

include_once 'env.php';
include_once 'common.php';
?>

<pre><?php //print_r($_POST); ?></pre>

<?php

switch ($_POST['cmd']) {
    case "insert":
        insert_reserve();
        break;
}

function insert_reserve() {
    //TODO POSTデータの入力チェック未

    try {
        $pdo = connectdb();
    
        $reserve_id = get_reserve_id($pdo);
        $reserve_seat_id = get_reserve_seat_id($pdo);
        $customer_id = get_customer_id($pdo);

        //TODO データ型にあわせてちゃんと変換
        $reserve_date_from = sprintf("%s %s", $_POST['reserve_date'], $_POST['reserve_time_from']);
        $reserve_date_to = sprintf("%s %s", $_POST['reserve_date'], $_POST['reserve_time_to']);
    
        $pdo->beginTransaction();
        try {
            $cnt = insert_m_customer($pdo, $customer_id, $_POST['phone_no'], $_POST['client_name']);
            $cnt = insert_reserve_info($pdo, $reserve_id, $customer_id, $_POST['client_name'], $_POST['phone_no'], $reserve_date_from, $reserve_date_to, $_POST['reserve_quantity'], $_POST['seat_type'], $_POST['seat_smoke'], $reserve_seat_id, $_POST['reserve_notes']);
            
            foreach ($_POST['seat'] as $seat_id) {
                $cnt = insert_reserve_seat_info($pdo, $reserve_seat_id, $reserve_id, $seat_id);
            }
            $pdo->commit();    
        } catch (PDOException $e) {
            $pdo->rollback();
            throw $e;
        }
    } catch (PDOException $e) {
        header('Content-Type: text/plain; charset=UTF-8', true, 500);
        exit($e->getMessage());
    } finally {
        //TODO コネクションの解放不要？ブロック内のスコープがきもい
        $pdo = null;
    }
}

//echo "cnt: ${cnt}"
?>

<!--
<body onload="document.forms[0].submit();">
<form method="post" action="reserve.php">
    <input type="hidden" name="key" value="value" />
</form>
</body>
-->

<body onload="document.forms[0].submit();">
<form method="post" action="reserve.php">
<?php // TODO 更新結果のメッセージか何か返却 ?>
</form>
</body>
