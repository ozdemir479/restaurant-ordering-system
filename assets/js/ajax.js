$(document).ready(function() {
    // Sayfa yüklendiğinde, her bir sayfa bağlantısına click event listener ekleyin
    $(".menu-link").click(function(e) {
        e.preventDefault(); // Sayfa yenilenmesini engellemek için

        var url = $(this).attr("href"); // Tıklanan bağlantının URL'sini al

        // Loader'ı göster
        showLoader();

        // AJAX isteği yap
        $.ajax({
            url: url, // Sayfanın URL'si
            type: "GET",
            success: function(response) {
                // Gelen içeriği bir DOM nesnesine dönüştür
                var htmlContent = $(response);
                
                // "container" div'inin içeriğini al
                var containerContent = htmlContent.find("#content").html();
                
                // "container" div'inin içeriğini mevcut sayfaya yerleştir
                $("#content").html(containerContent);
                history.pushState(null, "", url);

                // Yeni sayfanın JavaScript kodlarını çalıştır
                evalScripts(htmlContent);

                // Loader'ı gizle
                hideLoader();
            }
        });
    });

    // Geri ve ileri butonlarını dinleme
    window.onpopstate = function(event) {
        // Yeni URL'yi al
        var newUrl = location.pathname;
        
        // Loader'ı göster
        showLoader();

        // AJAX isteği yap
        $.ajax({
            url: newUrl, // Yeni URL
            type: "GET",
            success: function(response) {
                // Sayfa içeriğini "#content" div'inin içine yerleştir
                $("#content").html(response);

                // Loader'ı gizle
                hideLoader();
            }
        });
    };

    // Loader'ı gösteren fonksiyon
    function showLoader() {
        $(".loader").show(); // Loader'ı göster
    }

    // Loader'ı gizleyen fonksiyon
    function hideLoader() {
        $(".loader").hide(); // Loader'ı gizle
    }

    // Yeni sayfanın JavaScript kodlarını çalıştıran fonksiyon
    function evalScripts(content) {
        // Yeni içerikteki her bir script etiketini al ve içeriğini çalıştır
        content.filter("script").each(function() {
            $.globalEval(this.text || this.textContent || this.innerHTML || "");
        });
    }
});
