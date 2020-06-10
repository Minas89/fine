var addToCart = function(id){
    $.post("/en/cart/add",{id : id},
        function(res){
            if(res.returnCode == 101){
                location.reload();
            }
        },"json");

    return false;
};

var removeFromCart = function(id){
    $.post("/en/cart/remove",{id : id},
        function(res){
            if(res.returnCode == 101){
                $('#cartProduct' + id).fadeOut(500);
                location.reload();
            }
        },"json");

    return false;
};

var savePhoneNumber = function(){
    var phone = $('#phoneNumber').val();
    $.post("/en/my/profile/deliveryInfo",{phone : phone},
        function(res){
            if(res.returnCode == 101){
                if($('#successMessage').css('display') === 'none')
                {
                    $('#successMessage').css('display','block').text(res.msg).delay(5000).fadeOut();
                }
                else
                {
                    $('#successMessage').text(res.msg).delay(5000).fadeOut();
                }
            }
        },"json");

    return false;
};


var saveFio = function(){
    var firstname = $('#accountFirstName').val();
    var lastname =  $('#accountLastName').val();
    var email = $('#accountEmail').val();
    var title = document.querySelector('input[name="title"]:checked').value;

    $.post("/en/my/profile/save",{first : firstname,last: lastname, email : email, title: title},
        function(res){
            if(res.returnCode == 101){
                if($('#successMessage').css('display') === 'none')
                {
                    $('#successMessage').css('display','block').text(res.msg).delay(5000).fadeOut();
                }
                else
                {
                    $('#successMessage').text(res.msg).delay(5000).fadeOut();
                }
                $('#emailDiv').removeClass('has-error');
                $('#accountEmail').addClass('goldInput');
                $("#validateEmailSpan").removeClass("glyphicon-remove form-control-feedback");
                $(".fioDiv .help-block").empty();
            }
            if(res.returnCode == 102){
                $('#emailDiv').addClass('has-error');
                $('#accountEmail').removeClass('goldInput');
                $("#validateEmailSpan").addClass("glyphicon-remove form-control-feedback");
                $('.fioDiv .help-block').text(res.msg);
            }
        },"json");

    return false;

};

$('#accountEmail').keyup(function (e) {
    e.preventDefault();
    if($('#emailDiv').hasClass('has-error')){
        $('#emailDiv').removeClass('has-error');
        $("#validateEmailSpan").removeClass("glyphicon-remove form-control-feedback");
        $(".fioDiv .help-block").empty();
    }
});

var addWish = function(id) {
    $.post("/en/wishlist/add",{id : id},
        function(res){
            if(res.returnCode == 101){
                $('#wish' + id).toggleClass('fa-heart-o');
                $('#wish' + id).toggleClass('fa-heart');
                document.getElementById( "awish" + id ).setAttribute( "onClick", "removeWish(" + id + ")" );
                str = document.getElementById("wishCount").innerHTML;
                str = str.substr(1);
                str = str.substring(0, str.length - 1); // "12345.0"
                count = parseInt(str);

                if(isNaN(count)){
                    count = 0;
                }

                count = count + 1;
                $("#wishCount").html("(" + count +")").css('display','inline-block');
            }
        },"json");

    return false;
};

var removeWish = function(id,from) {
    $.post("/en/wishlist/remove",{id : id},
        function(res){
            if(res.returnCode == 101){
                if(from != "wish"){
                    $('#wish' + id).toggleClass('fa-heart-o');
                    $('#wish' + id).toggleClass('fa-heart');
                }

                document.getElementById( "awish" + id ).setAttribute( "onClick", "addWish(" + id + ")" );
                str = document.getElementById("wishCount").innerHTML;
                str = str.substr(1);
                str = str.substring(0, str.length - 1); // "12345.0"
                count = parseInt(str);
                count = count - 1;

                $("#wishCount").html("(" + count +")").css('display','inline-block');



                if(from == "wish"){
                    location.reload();
                }
            }
        },"json");

    return false;
};

$("#searchBtn").click(function () {
    var myval = $("#inputSearch").val();

    if(myval.length === 0){
        return false;
    }
});

$('ul.nav li.dropdown').hover(function() {
    $(this).find('.dropdown-menu').stop(true, true).delay(1).fadeIn(1);
    $(this).find('.dropdown-menu').css('display','flex');
}, function() {
    $(this).find('.dropdown-menu').stop(true, true).delay(1).fadeOut(1);
});


$('.phone').click(function () {
    var phone = $('.phone').val();
    if(phone.length == 0){
        $(this).val('+');
    }

}).keyup(function (e) {
    var phone = $('.phone').val();
    if(e.keyCode == 8){
        if(phone.length == 0){
            $(this).val('+');
        }
    }
});


