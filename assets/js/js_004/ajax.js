document.addEventListener('DOMContentLoaded', function() {
    var links = document.querySelectorAll('.nav-link');
    var loader = document.getElementById('loader');
    
    links.forEach(function(link) {
      link.addEventListener('click', function(event) {
        event.preventDefault();
        var url = this.getAttribute('href');
        
        // Yükleme göstergesini göster
        loader.style.display = 'block';
        
        loadPage(url);
        
        // URL'yi değiştirme
        history.pushState(null, '', url);
      });
    });
    
    function loadPage(url) {
      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            var container = document.createElement('div');
            container.innerHTML = xhr.responseText;
            
            var newContent = container.querySelector('.container').innerHTML;
            document.querySelector('.container').innerHTML = newContent;
            
            // Yükleme göstergesini gizle
            loader.style.display = 'none';
          } else {
            console.error('Error: ' + xhr.status);
            
            // Hata durumunda yükleme göstergesini gizle
            loader.style.display = 'none';
          }
        }
      };
      xhr.open('GET', url, true);
      xhr.send();
    }
  });
  