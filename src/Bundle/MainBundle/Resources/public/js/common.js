// Init empty links
$(document).ready(function () {
    $(document).on('click', 'a[href="#"]', function (event) {
        event.preventDefault();
    });
});


$(document).ready(function () {
    $('a.api').on('click', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: $(this).attr('href'),
            type: "POST",
            dataType: "json",
            beforeSend: function() {
            },
            complete: function() {
            },
            success: function(response, status) {
                console.log(status);
                if (response && response.error) {
                    alert(response.error);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown);
                if (jqXHR.responseJSON && jqXHR.responseJSON.error) {
                    alert(jqXHR.responseJSON.error);
                } else {
                    alert(jqXHR.statusText);
                }
            }
        });
    });
});