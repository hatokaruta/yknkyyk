<?php

class ReserveList {
    private $pdo;
    private $stmt;
    private $server;
    private $request;

    public function __construct($pdo, $server, $request) {
        $this->pdo = $pdo;
        $this->server = $server;
        $this->request = $request;
    }

    public function __destruct() {
        $this->stmt = null;
        $this->pdo = null;
    }

    public function preprocess() {
    }

    public function process() {
    }

    public function postprocess() {
    }

    public function select_list() {
        $this->stmt = select_reserve_list($this->pdo);
    }

    public function fetch_list() {
        static $no = 1;

        if ($data = $this->stmt->fetch()) {
            $row = new ListRow();
            $row->no = $no++;
            $row->customer_name = $data['customer_name'];
            $row->customer_tel = $data['customer_tel'];
            $row->reserve_date_time = format_reserve_date($data['reserve_date_from'], $data['reserve_date_to']);
            $row->reserve_quantity = $data['reserve_quantity'];
            $row->seat_name = $data['seat_name'];
            $row->reserve_id = $data['reserve_id'];
        } else {
            $row = null;
        }
        return $row;
    }
}

class ListRow {
    public $no = 0;
    public $customer_name = "";
    public $customer_tel = "";
    public $reserve_date_time = "";
    public $reserve_quantity = 0;
    public $seat_name = "";
    public $reserve_id = "";
}
