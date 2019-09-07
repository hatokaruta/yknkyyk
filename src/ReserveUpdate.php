<?php

class ReserveUpdate {
    private $pdo;
    private $server;
    private $request;

    private $action;

    public function __construct($pdo, $server, $request) {
        $this->pdo = $pdo;
        $this->server = $server;
        $this->request = $request;
        $this->action = new ActionInfo($server, $request);
    }

    public function __destruct() {
        $this->pdo = null;
    }

    public function preprocess() {
        echo "<pre>" + print_r($this->request) + "</pre>";

        //TODO 入力チェック
        //TODO 入力の正規化
    }

    public function process() {
        if ($this->is_reserve_cmd()) {
            $this->insert_reserve();
        }elseif ($this->is_edit_cmd()) {
            $this->update_reserve();
        }elseif ($this->is_cancel_cmd()) {
            $this->delete_reserve();
        }
    }

    public function postprocess() {
    }

    private function insert_reserve() {
        $reserve_id = get_reserve_id($this->pdo);
        $reserve_seat_id = get_reserve_seat_id($this->pdo);
        $customer_id = get_customer_id($this->pdo);

        //TODO データ型にあわせてちゃんと変換
        $reserve_date_from = sprintf("%s %s", $this->request['reserve_date'], $this->request['reserve_time_from']);
        $reserve_date_to = sprintf("%s %s", $this->request['reserve_date'], $this->request['reserve_time_to']);

        //TODO 更新件数チェック

        $this->pdo->beginTransaction();
        try {
            $cnt = insert_m_customer(
                $this->pdo,
                $customer_id,
                $this->request['phone_no'],
                $this->request['client_name']
            );

            $cnt = insert_reserve_info(
                $this->pdo,
                $reserve_id,
                $customer_id,
                $this->request['client_name'],
                $this->request['phone_no'],
                $reserve_date_from,
                $reserve_date_to,
                $this->request['reserve_quantity'],
                $this->request['seat_type'],
                $this->request['seat_smoke'],
                $reserve_seat_id,
                $this->request['reserve_notes']
            );

            foreach ($this->request['seat_id_list'] as $seat_id) {
                $cnt = insert_reserve_seat_info(
                    $this->pdo,
                    $reserve_seat_id,
                    $reserve_id,
                    $seat_id
                );
            }
            $this->pdo->commit();    
        } catch (PDOException $e) {
            $this->pdo->rollback();
            throw $e;
        }
    }

    private function update_reserve() {
        $reserve_id = $this->request['reserve_id'];

        $stmt = select_reserve_info($this->pdo, $reserve_id);
        $data = $stmt->fetch();
        if ($data) {
            $reserve_seat_id = $data['reserve_seat_id'];
            $customer_id = $data['customer_id'];
        } else {
            //TODO エラー
        }

        //TODO データ型にあわせてちゃんと変換
        $reserve_date_from = sprintf("%s %s", $this->request['reserve_date'], $this->request['reserve_time_from']);
        $reserve_date_to = sprintf("%s %s", $this->request['reserve_date'], $this->request['reserve_time_to']);

        //TODO 更新件数チェック

        $this->pdo->beginTransaction();
        try {
            $cnt = update_m_customer(
                $this->pdo,
                $customer_id,
                $this->request['phone_no'],
                $this->request['client_name']
            );

            $cnt = update_reserve_info(
                $this->pdo,
                $reserve_id,
                $customer_id,
                $this->request['client_name'],
                $this->request['phone_no'],
                $reserve_date_from,
                $reserve_date_to,
                $this->request['reserve_quantity'],
                $this->request['seat_type'],
                $this->request['seat_smoke'],
                $reserve_seat_id,
                $this->request['reserve_notes']
            );

            $cnt = delete_reserve_seat_info(
                $this->pdo,
                $reserve_seat_id
            );
            foreach ($this->request['seat_id_list'] as $seat_id) {
                $cnt = insert_reserve_seat_info(
                    $this->pdo,
                    $reserve_seat_id,
                    $reserve_id,
                    $seat_id
                );
            }
            $this->pdo->commit();    
        } catch (PDOException $e) {
            $this->pdo->rollback();
            throw $e;
        }
    }

    private function delete_reserve() {
        $reserve_id = $this->request['reserve_id'];

        //TODO 更新件数チェック

        $this->pdo->beginTransaction();
        try {
            $cnt = update_reserve_info_cancel(
                $this->pdo,
                $reserve_id,
                $this->request['cancel_reason']
            );

            $this->pdo->commit();    
        } catch (PDOException $e) {
            $this->pdo->rollback();
            throw $e;
        }
    }

    private function is_reserve_cmd() {
        return $this->action->cmd === "reserve";
    }

    private function is_edit_cmd() {
        return $this->action->cmd === "edit";
    }

    private function is_cancel_cmd() {
        return $this->action->cmd === "cancel";
    }

}
