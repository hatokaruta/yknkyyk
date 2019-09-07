'use strict';

function submit_form(this_) {
    const frm = $(this_).parents('form');

    $("#cmd").val($(this_).data('cmd'));
    frm.attr('action', $(this_).data('action'));
    frm.attr('method', $(this_).data('method'));
    frm.submit();
}

function enable_group(id, is_show, is_enabled) {
    const elm = $("#" + id);

    if (is_show) {
        elm.removeClass("d-none");
    } else {
        elm.addClass("d-none");
    }

    elm.prop("disabled", !is_enabled);
}

function restore_value(name, default_value) {
    $("#" + name).val(get_value(name, default_value));
}

function restore_radio(name, default_value) {
    $("input[name='" + name + "']").val([get_value(name, default_value)]);
}

function restore_check(name, default_value) {
    const value_list = get_value(name, default_value).split(",");

    value_list.forEach(value => {
        const elm = $("input[id='" + name + "'][value='" + value + "']");
        if (elm.length > 0) {
            elm.prop("checked", true);
        }
    });
}

function get_value(name, default_value) {
    let value = $("#hdn_" + name).val();
    value = value != '' ? value : default_value;
    return value;
}
