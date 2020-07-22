
$(document).ready(function () {
    $('.accordion-toggle').on('click', function(event){
        event.preventDefault();
        // create accordion variables
        var accordion = $(this);
        var accordionContent = accordion.next('.accordion-content');

        var icon = accordion.find('span > i');

        icon.toggleClass('fa-angle-down');
        icon.toggleClass('fa-angle-up');
        // toggle accordion link open class
        accordion.toggleClass("open");
        // toggle accordion content
        accordionContent.slideToggle(250);
    });
});

$(document).on('click','.filterValue',function () {
    var a = $(this);
    var filterName = a.attr('name');
    var id = a.attr('data-id');
    removeFilterValue(filterName,id);

    return true;
});

$(document).ready(function() {
    $('.addFilterValue').click(function () {
        var filterName = $(this).attr("name");
        var filterValue = $(this).val();
        var locale = $(this).attr('data-locale');
        var tagName = $(this).prop("tagName");
        var key;
        switch (tagName) {
            case "INPUT":
                if ($(this).is(':checked')) {
                    if (!$(this).hasClass("sizeType")) {
                        addFilterValue(filterName, filterValue, locale);
                    } else {
                         key = $(this).attr('data-id');
                        removeFilterValue(filterName, key);
                    }
                } else {
                     key = $(this).attr('data-id');
                    if (!$(this).hasClass("sizeType")) {
                        removeFilterValue(filterName, key);
                    } else {
                        addFilterValue(filterName, filterValue, locale);
                    }

                }
                break;
            case "A":

                filterValue = $(this).attr('data-id');
                var attr = $(this).attr('style');
                 key = $(this).attr('data-id');

                if (filterName === "amount") {
                    filterValue = $('#minPrice').val() + " " +  $('#maxPrice').val();
                }

                if (filterName === "height") {
                    filterValue = $('#minHeight').val() + " " +  $('#maxHeight').val();
                }

                if (filterName === "width") {
                    filterValue = $('#minWidth').val() + " " +  $('#maxWidth').val();
                }

                if (typeof attr !== typeof undefined && attr !== false) {
                    // alert('aa');return false;
                    removeFilterValue(filterName, key);
                } else {
                    //alert('ab');return false;
                    addFilterValue(filterName, filterValue, locale);
                }

                break;
        }
    });


});




function addFilterValue(filterName, filterValue,locale) {
    $.post("/api/addFilter",{ filterName : filterName, filterValue : filterValue, locale: locale },function (res) {
        if(res.code == 101){
            location.reload();
            return true;
        }
    },"json");

    return false;
}

function removeFilterValue(filterName, key) {
    $.post("/api/removeFilter",{ filterName : filterName, key: key },function (res) {
        if(res.code == 101){
            location.reload();
            return true;
        }
    },"json");

    return false;
}
