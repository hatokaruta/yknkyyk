<?php

class ReserveDetail {
    private $pdo;
    private $stmt;
    private $server;
    private $request;

    private $action;
    private $mode;
    private $detail;

    public function __construct($pdo, $server, $request) {
        $this->pdo = $pdo;
        $this->server = $server;
        $this->request = $request;
        $this->action = new ActionInfo($server, $request);
    }

    public function __destruct() {
        $this->stmt = null;
        $this->pdo = null;
    }

    public function preprocess() {
        $this->mode = $this->init_mode($this->request);
        $this->detail = $this->get_detail_row();

        //TODO 入力チェック
        //TODO 入力の正規化

    }

    public function process() {
    }

    public function postprocess() {
    }

    private function get_detail_row() {
        if ($this->is_reserve_mode()) {
            $row = new DetailRow();
            $row = $this->merge_request_detail($row);

        } elseif ($this->is_edit_mode()) {
            $this->select_detail();
            $row = $this->fetch_detail();
            $row = $this->merge_request_detail($row);

        } elseif ($this->is_cancel_mode()) {
            $this->select_detail();
            $row = $this->fetch_detail();
        }
   
        return $row;
    }

    private function select_detail() {
        $this->stmt = select_reserve_detail($this->pdo, $this->request['reserve_id']);
    }

    private function fetch_detail() {
        if ($data = $this->stmt->fetch()) {
            $row = new DetailRow();
            $row->reserve_id = $data['reserve_id'];
            $row->phone_no = $data['customer_tel'];
            $row->client_name = $data['customer_name'];
            $row->reserve_date = split_date($data['reserve_date_from']);
            $row->reserve_time_from = split_time($data['reserve_date_from']);
            $row->reserve_time_to = split_time($data['reserve_date_to']);
            $row->reserve_quantity = $data['reserve_quantity'];
            $row->seat_type = $data['seat_type'];
            $row->seat_smoke = $data['smoking_flg'];
            $row->reserve_notes = $data['reserve_notes'];
            $row->seat_id_list = to_array($data['seat_id_list']);
            $row->cancel_reason = $data['cancel_reason'];
        } else {
            $row = null;
        }
        return $row;
    }

    private function merge_request_detail(&$row) {
        $row->reserve_id = get_request($this->request, 'reserve_id', $row->reserve_id);
        $row->phone_no = get_request($this->request, 'phone_no', $row->phone_no);
        $row->client_name = get_request($this->request, 'client_name', $row->client_name);
        $row->reserve_date = get_request($this->request, 'reserve_date', $row->reserve_date);
        $row->reserve_time_from = get_request($this->request, 'reserve_time_from', $row->reserve_time_from);
        $row->reserve_time_to = get_request($this->request, 'reserve_time_to', $row->reserve_time_to);
        $row->reserve_quantity = get_request($this->request, 'reserve_quantity', $row->reserve_quantity);
        $row->seat_type = get_request($this->request, 'seat_type', $row->seat_type);
        $row->seat_smoke = get_request($this->request, 'seat_smoke', $row->seat_smoke);
        $row->reserve_notes = get_request($this->request, 'reserve_notes', $row->reserve_notes);
        if ($this->is_search_cmd()) {
            $row->seat_id_list = array();
        }else{
            $row->seat_id_list = get_request($this->request, 'seat_id_list', $row->seat_id_list);
        }
        $row->cancel_reason = get_request($this->request, 'cancel_reason', $row->cancel_reason);
        return $row;
    }

    public function select_seat() {
        $this->stmt = select_m_seat($this->pdo, $this->detail->seat_type, $this->detail->seat_smoke);
    }

    public function fetch_seat() {
        static $no = 1;

        if ($data = $this->stmt->fetch()) {
            $row = new SeatRow();
            $row->no = $no++;
            $row->seat_name = $data['seat_name'];
            $row->seat_type = get_seat_name($data['seat_type']);
            $row->seat_quantity = $data['seat_quantity'];
            $row->smoking_flg = get_smoke_name($data['smoking_flg']);
            $row->seat_id = $data['seat_id'];
        } else {
            $row = null;
        }
        return $row;
    }

    private function init_mode($req) {
        $tmp = "";
        if (get_request($req, "mode") !== "") {
            $tmp = get_request($req, "mode");
        } else {
            $tmp = get_request($req, "cmd");
        }
        switch ($tmp) {
            case "reserve":
            case "edit":
            case "cancel":
                break;
            default:
                $tmp = "reserve";
                break;
        }
        return $tmp;
    }

    private function is_reserve_mode() {
        return $this->mode === "reserve";
    }

    private function is_edit_mode() {
        return $this->mode === "edit";
    }

    private function is_cancel_mode() {
        return $this->mode === "cancel";
    }

    private function is_search_cmd() {
        return $this->action->cmd === "search";
    }

    public function do_search() {
        return ($this->is_reserve_mode() && $this->is_search_cmd()) || $this->is_edit_mode() || $this->is_cancel_mode();
    }

    public function get_mode() {
        return $this->mode;
    }

    public function get_detail() {
        return $this->detail;
    }
}

class DetailRow {
    public $reserve_id = "";
    public $phone_no = "";
    public $client_name = "";
    public $reserve_date = "";
    public $reserve_time_from = "";
    public $reserve_time_to = "";
    public $reserve_quantity = "";
    public $seat_quantity = "";
    public $seat_type = "";
    public $seat_smoke = "";
    public $reserve_notes = "";
    public $seat_id_list = array();
    public $cancel_reason = "";
}

class SeatRow {
    public $no = 0;
    public $seat_name = "";
    public $seat_type = "";
    public $seat_quantity = 0;
    public $smoking_flg = 0;
    public $seat_id = "";
}

//TODO 暫定 クライアント側のtimepickerにおきかえ
function output_time() {
    for($h=17;$h<24;$h++) {
        for($m=0;$m<60;$m+=30) {
            printf("<option value=\"%02d:%02d\">%02d時%02d分</option>\n", $h, $m, $h, $m);
        }
    }
}
