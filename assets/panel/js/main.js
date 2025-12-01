function toast(msg,type){
    if (type == "success"){
        iziToast.success({
            title: "Success",
            message: msg,
            position: 'topRight',
        });
    }else {
        iziToast.error({
            title: "Error",
            message: msg,
            position: 'topRight',
        });
    }
}

$('.account').click(function (e) {
    e.preventDefault();

    var copy_data = $(this).data('account');

    document.addEventListener('copy', function(e) {
        e.clipboardData.setData('text/plain', copy_data);
        e.preventDefault();
    }, true);

    document.execCommand('copy');
    toast('Account number copied : ' + copy_data,"success");
});

$("#bank").change(function () {
    var bank_code = $(this).find("option:selected").attr('data-bank-code');

    $("#account_number").removeAttr('disabled');
    $("#account_number").val("");


    $("#account_number").blur(function () {

        var account_number = $(this).val();

        $(".verify-msg").text("Verifying Recipient...");
        $(".verify-msg").addClass('text-danger');

        $.ajax({
            url: url+'/verifyBank',
            type: "POST",
            data: {
                _token: $("#csrf").val(),
                'account_number' : account_number,
                'bank_code': bank_code
            },
            dataType : 'json',
            cache: false,
            timeout : 45000,
            success: function(data){

                if (data.error == 1){
                    $("#proceed-bank").removeAttr('disabled');
                    $(".verify-msg").html(data.message);
                    $(".verify-msg").removeClass('text-danger');
                    $(".verify-msg").addClass('text-success');
                    $("#account_name").val(data.account_name);
                    return;
                }

                $("#proceed-bank").prop('disabled',true);
                $(".verify-msg").html(data.message);
            },
            error : function (er) {
                $(".verify-msg").html("Error network");
                $("#proceed-bank").prop('disabled',true);
                $(".verify-msg").addClass('text-danger');
            }
        });

    });
});


$("#recipient").blur(function (e) {

    if ($(this).val()  == "" || $(this).val() == undefined){
        return;
    }

    $(".verify-msg").text("Verifying Recipient...");
    $(".verify-msg").removeClass('text-success');
    $(".verify-msg").removeClass('text-danger');

    $.ajax({
        url: url+'/validateRecipient',
        type: "POST",
        data: {
            _token: $("#csrf").val(),
            'provider_code' : $("#provider_code").val(),
            'recipient': $("#recipient").val()
        },
        dataType : 'json',
        cache: false,
        timeout : 45000,
        success: function(data){
            if (data.error == 1){
                $("#proceed").removeAttr('disabled');
                $(".verify-msg").html(data.message);
                $(".verify-msg").addClass('text-success');
                return;
            }

            $("#proceed").prop('disabled',true);
            $(".verify-msg").html(data.message);
            $(".verify-msg").addClass('text-danger');
        },
        error : function (er) {
            $(".verify-msg").html("Error network");
            $("#proceed").prop('disabled',true);
            $(".verify-msg").addClass('text-danger');
        }
    });

});

$("#amount").blur(function () {
    var amount = parseFloat($("#amount").val());
    if(amount >= 0) {
        var commission = parseFloat($("#cashback").val());
        var total = amount / 100 * commission;
        $("#commission").val(total.toFixed(2));
    }
});

$("#package").change(function () {
    var $option = $(this).find(':selected');
    var commission = parseFloat($option.data('cashback'));
    var price = parseFloat($option.data('price'));
    var total = price / 100 * commission;
    $("#commission").val(total.toFixed(2));
});


$(".hide-balance").on("click",function (e) {
    $(".total").removeClass('text-blur');
});

$("#save_beneficiary").change(function (e) {
    if ($(this).is(':checked')){
        $(".beneficiary").removeClass('hide');
        return;
    }
    $(".beneficiary").addClass('hide');
    $("#beneficiary_name").val("");
});
