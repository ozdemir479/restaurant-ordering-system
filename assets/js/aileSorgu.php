<?php include("../inc/controller.php");
use rhantaweq\RhantaFunctions;
?>

<script>
$(document).ready(function(){
  
  function showAlert(message, type, duration) {
    
    $('.alert').alert('close');
    
    var alertDiv = $('<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' + message + '</div>');
    $('#alert-container').append(alertDiv);
    if (duration) {
      setTimeout(function(){
        alertDiv.alert('close');
      }, duration);
    }
    if (duration !== 0) {
      setTimeout(function(){
        alertDiv.alert('close');
      }, 3000);
    }
  }

  $('#sorgula').click(function(e){
    e.preventDefault();

    var button = $(this);
    button.prop('disabled', true);

    var countDown = 5;
    button.html("Bir sonraki işlem: " + countDown + " saniye");

    var timer = setInterval(function() {
        countDown--;
        button.html("Bir sonraki işlem: " + countDown + " saniye");
        if (countDown <= 0) {
            clearInterval(timer);
            button.prop('disabled', false);
            button.html("Sorgula");
        }
    }, 1000);

    var tc = $("#tc").val();
    var validationToken = $("#validationToken").val();
    
    showAlert("Sorgulanıyor...", "info", 0);
    
    $.ajax({
      url: "../server/api/queries/api",
      type: "POST",
      data: {
        tc: tc,
        cmd: "aileSorgu",
        validationToken: "<?= RhantaFunctions::encrypt("rhanta_".RhantaFunctions::randomStr(32)."@".date("d-m-y H:i:s")) ?>",
      },
      dataType: "json",
      success: function(response) {
        if (response) {
          showAlert("Sonuç bulundu!", "success", 3000);
          $("#sonuclar").empty();

          $.each(response, function(index, item) {
            var row = $("<tr>");
            row.append($("<th>").text(item.Yakinlik || "Bulunamadı"));
            row.append($("<th>").text(item.TC || "Bulunamadı"));
            row.append($("<th>").text(item.ADI || "Bulunamadı"));
            row.append($("<th>").text(item.SOYADI || "Bulunamadı"));
            row.append($("<th>").text(item.DOGUMTARIHI || "Bulunamadı"));
            row.append($("<th>").text(item.NUFUSIL || "Bulunamadı"));
            row.append($("<th>").text(item.NUFUSILCE || "Bulunamadı"));
            row.append($("<th>").text(item.ANNEADI || "Bulunamadı"));
            row.append($("<th>").text(item.ANNETC || "Bulunamadı"));
            row.append($("<th>").text(item.BABAADI || "Bulunamadı"));
            row.append($("<th>").text(item.BABATC || "Bulunamadı"));
            row.append($("<th>").text(item.UYRUK || "Bulunamadı"));

            $("#sonuclar").append(row);
          });
        } else {
          showAlert("Bir sonuç bulunamadı!", "danger", 3000);
        }
      },
      error: function(xhr, status, error) {
        showAlert("Bir hata oluştu!", "danger", 3000);
      }
    });
  });
});

</script>