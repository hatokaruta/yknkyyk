'use strict';

$(function () {
    $(":button[name=edit_button], :button[name=cancel_button]").click(function() {
         $("#reserve_id").val($(this).data('param'));
         submit_form(this);
    });

    $("#reserve_button").click(function() {
        submit_form(this);
    });
});
