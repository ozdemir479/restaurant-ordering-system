window.addEventListener('DOMContentLoaded', function() {
  handleFilter();
});

function viewMessage(message) {
  var messageBox = document.getElementById("messageBox");
  var messageContent = messageBox.querySelector("p");
  messageContent.textContent = message;
  messageBox.style.display = "block";
  fadeIn(messageBox);
}

document.getElementById("closeButton").addEventListener("click", function() {
  var messageBox = document.getElementById("messageBox");
  fadeOut(messageBox);
});

function fadeInOut(element, type) {
  var opacity = type === "in" ? 0 : 1;
  var increment = type === "in" ? 0.8 : -0.8;
  var timer = setInterval(function() {
      if (type === "in" && opacity >= 1 || type === "out" && opacity <= 0) {
          clearInterval(timer);
          if (type === "out") {
              element.style.display = "none";
          }
      }
      element.style.opacity = opacity;
      opacity += increment;
  }, 3);
}

function fadeIn(element) {
  fadeInOut(element, "in");
}

function fadeOut(element) {
  fadeInOut(element, "out");
}

function updateOrderCount() {
  const divs = document.querySelectorAll('.pos-order');
  const divCount = divs.length;
  const badge = document.querySelector('.badge');
  badge.textContent = divCount;
}

function updateTotalPrice(price, operation) {
  const total = document.getElementById('totalPrice');
  const defaultPrice = parseInt(total.innerText);
  total.textContent = operation === "add" ? defaultPrice + price : defaultPrice - price;
}


document.getElementById("garson").addEventListener("click", function() {
  var button = this;
  button.classList.add("disabled");
  button.disabled = true;
  var countDown = 60;
  var interval = setInterval(function() {
      if (countDown <= 0) {
          clearInterval(interval);
          button.innerHTML = `
              <span>
                  <i class="fa fa-bell fa-lg my-10px d-block"></i>
                  <span class="small fw-semibold">Garson Çağır</span>
              </span>
          `;
          button.classList.remove("disabled");
          button.disabled = false;
      } else {
          button.innerHTML = `
              <span>
                  <i class="fa fa-bell fa-lg my-10px d-block"></i>
                  <span class="small fw-semibold">Garson Çağır</span>
                  <span class="small fw-semibold"> - ${countDown}</span>
              </span>
          `;
          countDown--;
      }
  }, 1000);
});


function removeProduct(id, price) {
  var productCount = parseInt(document.getElementById("productCount_" + id).value);
  var product = document.getElementById("productOrder_" + id);
  product.parentNode.removeChild(product);
  for (i = 0; i < productCount; i++) {
      updateTotalPrice(price, "sub");
  }
}

function updateProductCount(id, price, operation) {
  const input = document.getElementById('productCount_' + id);
  const value = parseInt(input.value);
  const operator = operation === "add" ? 1 : -1;
  input.value = value + operator;
  updateTotalPrice(price, operation);
}

function addToCart(id, price, name, image, desc) {
  $('#product_' + id).modal('hide');
  updateTotalPrice(price, "add");
  updateOrderCount();
  viewMessage(name + " Adlı Ürün Sipariş Listesine Eklendi.");
  const newDiv = document.createElement('div');
  newDiv.className = "pos-order";
  newDiv.setAttribute("id", "productOrder_" + id);
  newDiv.innerHTML = `
      <div class="pos-order-product">
          <div class="img" style="background-image: url(` + image + `)"></div>
          <input type="hidden" name="productId" value="` + id + `">
          <div class="flex-1">
              <div class="h6 mb-1">` + name + `</div>
              <div class="small">` + desc + `</div>
              <div class="d-flex">
                  <a href="#" onclick="updateProductCount(` + id + `, ` + price + `, 'sub')" class="btn btn-secondary btn-sm"><i class="fa fa-minus"></i></a>
                  <input type="text" id="productCount_` + id + `" name="productCount" disabled class="form-control w-50px form-control-sm mx-2 bg-white bg-opacity-25 bg-white bg-opacity-25 text-center" value="1">
                  <a href="#" onclick="updateProductCount(` + id + `, ` + price + `, 'add')" class="btn btn-secondary btn-sm"><i class="fa fa-plus"></i></a>
              </div>
          </div>
      </div>
      <div class="pos-order-price d-flex flex-column">
          <div class="flex-1">` + price + ` TL</div>
          <div class="text-end">
              <a href="#" onclick="removeProduct(` + id + `, ` + price + `)" class="btn btn-default btn-sm"><i class="fa fa-trash"></i></a>
          </div>
      </div>
  `;
  const newOrderTab = document.getElementById('newOrderTab');
  newOrderTab.appendChild(newDiv);
}

function handleFilter() {
  $(document).on('click', '.pos-menu [data-filter]', function(e) {
      e.preventDefault();
      var targetType = $(this).attr('data-filter');
      $(this).addClass('active');
      $('.pos-menu [data-filter]').not(this).removeClass('active');
      if (targetType == 'all') {
          $('.pos-content [data-type]').removeClass('d-none');
      } else {
          $('.pos-content [data-type="' + targetType + '"]').removeClass('d-none');
          $('.pos-content [data-type]').not('.pos-content [data-type="' + targetType + '"]').addClass('d-none');
      }
  });
}
