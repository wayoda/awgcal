$(document).ready(function() {

    // Standard Formsubmit verhindern
    $(window).keydown(function(event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });

    var selectedElement = "";

    // Livesuche
    function search() {
        var query_value = $('input#search').val();
        $('b#search-string').text(query_value);
        if (query_value !== '') {
            $.ajax({
                type: "POST",
                url: "search.php",
                data: {
                    query: query_value
                },
                cache: false,
                success: function(html) {
                    var indexStart = html.indexOf("href=");
                    if (indexStart != -1) {
                        indexStart += 6;
                        var indexEnd = html.indexOf("\"", indexStart);
                        selectedElement = html.substr(indexStart, indexEnd - indexStart);
                    } else {
                        selectedElement = "";
                    }

                    $("ul#results").html(html);
                }
            });
        }
        return false;
    }

    $("input#search").on("keyup", function(e) {

        // Zu ausgewaehltem Element gehen
        if ((e.keyCode == 13)) {
            if (selectedElement != "") {
                location = selectedElement;
            }
        }

        // Timeout setzen
        clearTimeout($.data(this, 'timer'));

        // Suchstring setzen
        var search_string = $(this).val();

        // Suchen
        if (search_string == '') {
            $("ul#results").fadeOut();
            $('h4#results-text').fadeOut();
        } else {
            $("ul#results").fadeIn();
            $('h4#results-text').fadeIn();
            $(this).data('timer', setTimeout(search, 100));
        };
    });

});