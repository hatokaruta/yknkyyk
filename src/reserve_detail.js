'use strict';

$(function(){
    const init_func_list = {
        reserve: init_reserve,
        edit: init_edit,
        cancel: init_cancel
    };

    const init_func = init_func_list[$("#mode").val()];

    if (init_func) {
        init_func();
    } else {
        alert("error:action invalid")
    }

    function init_reserve() {
        enable_group("group_id", false, false);
        enable_group("group_reserve_input", true, true);
        enable_group("group_search_button", true, true);
        enable_group("group_search_table", true, true);
        enable_group("group_search_result", true, true);
        enable_group("group_reserve_button", true, true);
        enable_group("group_edit_button", false, false);
        enable_group("group_cancel_input", false, false);
        enable_group("group_cancel_button", false, false);

        //TODO 日時項目の初期値（現在日時を設定）
        restore_value("phone_no", "");
        restore_value("client_name", "");
        restore_value("reserve_date", "");
        restore_value("reserve_time_from", "17:00");
        restore_value("reserve_time_to", "17:00");
        restore_value("reserve_quantity", "1");
        restore_radio("seat_type", "none");
        restore_radio("seat_smoke", "-1");
        restore_value("reserve_notes", "");
        restore_check("seat_id_list", "");

        $(".datepicker").datepicker({
            dateFormat: "yy-mm-dd"
        });

        $('#group_search_table tr').click(function(e) {
            if (e.target.type !== 'checkbox') {
                $(':checkbox', this).trigger('click');
            }
        });

        $("#search_button").click(function() {
            submit_form(this);
        });

        $("#reserve_button").click(function() {
            let chk = $(":input[type=checkbox]");

            if (chk.length > 0) {
                chk[0].setCustomValidity("");

                let frm = $(this).parents('form');
                if (!frm.get(0).checkValidity()) {
                    frm.get(0).reportValidity();
                    return;
                }

                if ($("#seat_check :checked").length <= 0) {
                    chk[0].setCustomValidity("席を選択してください。");
                    frm.get(0).reportValidity();
                    return;
                }

                submit_form(this);
            }else {
                let frm = $(this).parents('form');
                if (!frm.get(0).checkValidity()) {
                    frm.get(0).reportValidity();
                    return;
                }
            }
        });
    };

    function init_edit() {
        enable_group("group_id", true, true);
        enable_group("group_reserve_input", true, true);
        enable_group("group_search_button", true, true);
        enable_group("group_search_table", true, true);
        enable_group("group_search_result", true, true);
        enable_group("group_reserve_button", false, false);
        enable_group("group_edit_button", true, true);
        enable_group("group_cancel_input", false, false);
        enable_group("group_cancel_button", false, false);

        //TODO 日時項目の初期値（現在日時を設定）
        restore_value("reserve_id", "");
        restore_value("phone_no", "");
        restore_value("client_name", "");
        restore_value("reserve_date", "");
        restore_value("reserve_time_from", "");
        restore_value("reserve_time_to", "");
        restore_value("reserve_quantity", "");
        restore_radio("seat_type", "");
        restore_radio("seat_smoke", "");
        restore_value("reserve_notes", "");
        restore_check("seat_id_list", "");

        $(".datepicker").datepicker({
            dateFormat: "yy-mm-dd"
        });

        $('#group_search_table tr').click(function(e) {
            if (e.target.type !== 'checkbox') {
                $(':checkbox', this).trigger('click');
            }
        });

        $("#search_button").click(function() {
            submit_form(this);
        });

        $("#edit_button").click(function() {
            let chk = $(":input[type=checkbox]");

            if (chk.length > 0) {
                chk[0].setCustomValidity("");

                let frm = $(this).parents('form');
                if (!frm.get(0).checkValidity()) {
                    frm.get(0).reportValidity();
                    return;
                }

                if ($("#seat_check :checked").length <= 0) {
                    chk[0].setCustomValidity("席を選択してください。");
                    frm.get(0).reportValidity();
                    return;
                }

                submit_form(this);
            }else {
                let frm = $(this).parents('form');
                if (!frm.get(0).checkValidity()) {
                    frm.get(0).reportValidity();
                    return;
                }
            }
        });
    }

    function init_cancel() {
        enable_group("group_id", true, true);
        enable_group("group_reserve_input", true, false);
        enable_group("group_search_button", false, false);
        enable_group("group_search_table", true, false);
        enable_group("group_search_result", true, false);
        enable_group("group_reserve_button", false, false);
        enable_group("group_edit_button", false, false);
        enable_group("group_cancel_input", true, true);
        enable_group("group_cancel_button", true, true);
        restore_check("seat_id_list", "");

        //TODO 日時項目の初期値（現在日時を設定）
        restore_value("reserve_id", "");
        restore_value("phone_no", "");
        restore_value("client_name", "");
        restore_value("reserve_date", "");
        restore_value("reserve_time_from", "17:00");
        restore_value("reserve_time_to", "17:00");
        restore_value("reserve_quantity", "1");
        restore_radio("seat_type", "none");
        restore_radio("seat_smoke", "-1");
        restore_value("reserve_notes", "");
        restore_value("cancel_reason", "");

        $("#cancel_button").click(function() {
            submit_form(this);
        });
    }

}());
