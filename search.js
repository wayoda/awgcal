$(document).ready(function() {

    // Standard Formsubmit verhindern
    $("input#search").keydown(function(event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });

    var jsonData;
    var selectedElement = -1;

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
                success: function(response) {
                    jsonData = JSON.parse(response);
                    var htmlResult = "";

                    var i;
                    for (i = 0; i < jsonData.length; i++) {
                        htmlResult += "<li class=\"dropdown-item\"><a href=\"" + jsonData[i].url + "\"><p>" + jsonData[i].name + "</p></li>";
                    };

                    selectedElement = 0;
                    $("ul#results").html(htmlResult);
                }
            });
        }
        return false;
    }

    $("input#search").on("keyup", function(e) {



        // Zu ausgewaehltem Element gehen
        if ((e.keyCode == 13)) {
            if (selectedElement != -1) {
                location = jsonData[selectedElement].url;
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