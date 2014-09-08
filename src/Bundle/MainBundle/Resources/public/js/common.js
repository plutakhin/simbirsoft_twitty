// Init empty links
$(document).ready(function () {
    $(document).on('click', 'a[href="#"]', function (event) {
        event.preventDefault();
    });
});

// Init select2
$(document).ready(function() {
    $('.select2').select2({
        tags: [],
        separator: '|',
        multiple: true,
        minimumInputLength: 1,
        maximumInputLength: 50,
        ajax: {
            url: routes.api_find_tag,
            dataType: 'json',
            type: "POST",
            data: function(term, page) {
                return {
                    term: term,
                    page_limit: 50,
                };
            },
            results: function(data, page) {
                return {results: data};
            }
        },
        //Allow manually entered text in drop down.
        createSearchChoice: function(term, data) {
            if ($(data).filter(function() {
                return this.text.localeCompare(term) === 0;
            }).length === 0) {
                return {id: term, text: term};
            }
        },
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