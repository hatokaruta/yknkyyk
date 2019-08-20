function restore_value(name, default_value) {
    let value = $("#hdn_" + name).val();
    value = value != '' ? value : default_value;
    $("#" + name).val(value);
}

function restore_radio(name, default_value) {
    let value = $("#hdn_" + name).val();
    value = value != '' ? value : default_value;
    $("input[name=" + name + "]").val([value]);
}
