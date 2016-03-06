$(document).ready(function() {

    var jsonData;
    var selectedElement = -1;

    $("input#search").keyup(function(e) {
        // Navigation durch Suchergebnisse
        if (e.keyCode == 13 || e.keyCode == 27 || e.keyCode == 37 || e.keyCode == 38 || e.keyCode == 39 || e.keyCode == 40) {
            if (e.keyCode == 13 || e.keyCode == 38 || e.keyCode == 40) {
                e.preventDefault();
            }

            if (e.keyCode == 13) { // Enter
                if (selectedElement == -1 && jsonData.length < 1) {
                    location = jsonData[0].url;
                } else {
                    location = jsonData[selectedElement].url;
                }
                return false;
            }

            if (selectedElement != -2) { // Nur wenn Suchergebnisse vorhanden sind
                if (e.keyCode == 38 && selectedElement > 0) { // up
                    var element = document.getElementById("el" + selectedElement);
                    element.classList.remove("active");
                    selectedElement--;
                    element = document.getElementById("el" + selectedElement);
                    element.classList.add("active");
                    return false;
                }

                if (e.keyCode == 40 && selectedElement < jsonData.length - 1) { // down
                    if (selectedElement == -1) {
                        var element = document.getElementById("el0");
                        element.classList.add("active");
                        selectedElement = 0;
                    } else {
                        var element = document.getElementById("el" + selectedElement);
                        element.classList.remove("active");
                        selectedElement++;
                        element = document.getElementById("el" + selectedElement);
                        element.classList.add("active");
                    }
                    return false;
                }
            }
        } else { // Suche
            clearTimeout($.data(this, 'timer'));
            var search_string = $(this).val();
            if (search_string == '') {
                $("ul#results").fadeOut();
                $('h4#results-text').fadeOut();
            } else {
                $("ul#results").fadeIn();
                $('h4#results-text').fadeIn();
                $(this).data('timer', setTimeout(search, 100));
            }
        }
    });

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
                    if (response != "") {
                        jsonData = JSON.parse(response);
                        var htmlResult = "";
                        var i;
                        for (i = 0; i < jsonData.length; i++) {
                            htmlResult += "<li class=\"dropdown-item\" id=\"el" + i + "\"><a href=\"" + jsonData[i].url + "\"><p>" + jsonData[i].name + "</p></li>";
                        };
                        $("ul#results").html(htmlResult);
                        selectedElement = -1;
                    } else {
                        $("ul#results").html("<li class=\"dropdown-item\"><a><p>Keine Suchergebnisse</p></li>");
                        selectedElement = -2;
                    }
                }
            });
        }
        return false;
    }

});