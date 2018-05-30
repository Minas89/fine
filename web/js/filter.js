
$(document).ready(function () {
    $('.accordion-toggle').on('click', function(event){
        event.preventDefault();
        // create accordion variables
        var accordion = $(this);
        var accordionContent = accordion.next('.accordion-content');

        var icon = accordion.find('span > i');

        icon.toggleClass('fa-angle-down');
        icon.toggleClass('fa-angle-right');
        // toggle accordion link open class
        accordion.toggleClass("open");
        // toggle accordion content
        accordionContent.slideToggle(250);
    });
});

function addColorFilter(color){
    var url = document.URL;

    /*window.location.href = url;
     return false;*/
    var urlParams = new URLSearchParams(window.location.search);

    if(urlParams.has('color')){
        url += ',' + color;
        $('#color'+color).css("border","2px solid #000");
    }else{
        if (url.indexOf('?') > -1){
            url += '&color='+ color
        }else{
            url += '?color=' + color
        }
    }
    window.location.href = url;
    return false;
}

$(".filter_button").click(function(){
    var minPrice = $('#minPrice').val();
    var maxPrice = $('#maxPrice').val();
    var minWidth = $('#minWidth').val();
    var maxWidth = $('#maxWidth').val();
    var minHeight = $('#minHeight').val();
    var maxHeight = $('#maxHeight').val();

    var l = '?';

    if(minPrice){
        l = l + "minPrice=" + minPrice;
    }

    if(maxPrice){
        l = l + "&maxPrice=" + maxPrice;
    }

    if(minWidth){
        l = l + "&minWidth=" + minWidth;
    }

    if(maxWidth){
        l = l + "&maxWidth=" + maxWidth;
    }

    if(minHeight){
        l = l + "&minHeight=" + minHeight;
    }

    if(maxHeight){
        l = l + "&maxHeight=" + maxHeight;
    }

    window.document.location = l;
});

function addSort(selectObject){
    var value = selectObject.value;

    var url = document.URL;

    url = url + "&sort=" + value;

    window.document.location = url;
}