// Init empty links
$(document).ready(function () {
    $(document).on('click', 'a[href="#"]', function (event) {
        event.preventDefault();
    });
});


$(document).ready(function () {
    $('a.api').on('click', function(e) {
        e.preventDefault();
        var $self = $(this);

        $.ajax({
            url: $(this).attr('href'),
            type: "POST",
            dataType: "json",
            beforeSend: function() {
            },
            complete: function() {
            },
            success: function(response, status) {
                if (response && response.error) {
                    alert(response.error);
                } else if (response && response.action) {
                    switch (response.action) {
                        case 'toggleClass':
                            $self.closest('.toggle-class').find('a.api').toggleClass('hidden');
                            break;
                    }
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                if (jqXHR.responseJSON && jqXHR.responseJSON.error) {
                    alert(jqXHR.responseJSON.error);
                } else {
                    alert(jqXHR.statusText);
                }
            }
        });
    });
});