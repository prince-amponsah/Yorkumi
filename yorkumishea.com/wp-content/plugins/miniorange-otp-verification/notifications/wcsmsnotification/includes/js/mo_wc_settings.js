
jQuery(document).ready(function () {
$mo = jQuery;

    $mo("#mo_custom_order_send_message").click(function () {
        $mo("#custom_order_sms_meta_box").block({ message: null, overlayCSS: { background: "#fff", opacity: 0.6 } });
        $mo.ajax({
            url: mocustommsg.siteURL + "/?mo_send_custome_msg_option=mo_send_order_custom_msg",
            type: "POST",
            data: { numbers: $mo("#custom_order_sms_meta_box #billing_phone").val(), msg: $mo("#custom_order_sms_meta_box #mo_wc_custom_order_msg").val() },
            crossDomain: !0,
            dataType: "json",
                success: function (a) {
                    $mo("#custom_order_sms_meta_box").unblock();
                    $mo("#jsonMsg").empty();
                    if (a.result == "success") {
                        $mo("#jsonMsg").removeClass("red");
                        $mo("#jsonMsg").addClass("green");
                    } else {
                        $mo("#jsonMsg").removeClass("green");
                        $mo("#jsonMsg").addClass("red");
                    }
                    $mo("#jsonMsg").prepend(a.message);
                    $mo("#jsonMsg").show();
                },
                error: function (b, a, c) {},
        });
    });
});