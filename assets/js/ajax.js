$(document).ready(function() {
    $(".menu-link").click(function(e) {
        e.preventDefault();

        var url = $(this).attr("href");

        $.ajax({
            url: url,
            type: "GET",
            success: function(response) {

                var htmlContent = $(response);
                var containerContent = htmlContent.find("#content").html();
                
                $("#content").html(containerContent);
                history.pushState(null, "", url);
                evalScripts(htmlContent);
            }
        });
    });

    window.onpopstate = function(event) {
        var newUrl = location.pathname;

        $.ajax({
            url: newUrl,
            type: "GET",
            success: function(response) {
                $("#content").html(response);
            }
        });
    };

    function evalScripts(content) {
        content.filter("script").each(function() {
            $.globalEval(this.text || this.textContent || this.innerHTML || "");
        });
    }
});
