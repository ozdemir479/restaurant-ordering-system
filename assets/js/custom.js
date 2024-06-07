window.addEventListener('DOMContentLoaded', function() {
  if (window.matchMedia("(max-width: 768px)").matches) {
    var messageBox = document.getElementById('messageBox');
    var initialX = null;
    var currentX = null;

    messageBox.addEventListener('touchstart', function(event) {
      initialX = event.touches[0].clientX;
      currentX = initialX;
      messageBox.style.transition = 'none';
    });

    messageBox.addEventListener('touchmove', function(event) {
      if (initialX !== null) {
        currentX = event.touches[0].clientX;
        var deltaX = currentX - initialX;
        messageBox.style.transform = 'translateX(' + deltaX + 'px)';
      }
    });

    messageBox.addEventListener('touchend', function(event) {
      if (initialX !== null) {
        var deltaX = currentX - initialX;
        if (deltaX > 50) {
          messageBox.style.transform = 'translateX(200px)';
        } else {
          messageBox.style.transform = 'translateX(0)';
        }
        messageBox.style.transition = 'transform 0.3s ease-out';
        initialX = null;
        currentX = null;
      }
    });

    var closeButton = document.getElementById('closeButton');
    closeButton.addEventListener('click', function() {
      messageBox.style.transform = 'translateX(200px)';
    });
  }
});

  function viewMessage(message){
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
  
  function fadeIn(element) {
    var opacity = 0;
    var timer = setInterval(function() {
      if (opacity >= 1) {
        clearInterval(timer);
      }
      element.style.opacity = opacity;
      opacity += 0.8;
    }, 3); 
  }
  
  function fadeOut(element) {
    var opacity = 1;
    var timer = setInterval(function() {
      if (opacity <= 0) {
        clearInterval(timer);
        element.style.display = "none";
      }
      element.style.opacity = opacity;
      opacity -= 0.8;
    }, 3);
  }
  
  function updateOrderCount(){
    const divs = document.querySelectorAll('.pos-order');
    const divCount = divs.length;
    const badge = document.querySelector('.badge');
    badge.textContent = divCount;
 }
 
 function updatePrice(price){
    const total = document.getElementById('totalPrice');
    const defaultPrice = parseInt(total.innerText);
    total.textContent = (defaultPrice + price);
 }
 function downgradePrice(price){
    const total = document.getElementById('totalPrice');
    const defaultPrice = parseInt(total.innerText);
    total.textContent = (defaultPrice - price);
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
  
  function removeProduct(id, price){
    var productCount = document.getElementById("productCount_" + id);
    var productCount = parseInt(productCount.value);
    var product = document.getElementById("productOrder_"+ id);
    product.parentNode.removeChild(product);
    for (i=0; i<productCount; i++) {
        downgradePrice(price);
    }
 }

 function upCount(id, price){
    updatePrice(price);
    const input = document.getElementById('productCount_' + id);
    const value = parseInt(input.value);
    input.value = value + 1;
 }

 function downCount(id, price){
    const input = document.getElementById('productCount_' + id);
    const value = parseInt(input.value);
    if(value > 1){
       input.value = value - 1;
       downgradePrice(price);
    }
 }

 function addToCart(id, price, name, image, desc) {
    $('#product_' + id).modal('hide');
    updatePrice(price);
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
               <a href="#" onclick="downCount(` + id + `, ` + price + `)" class="btn btn-secondary btn-sm"><i class="fa fa-minus"></i></a>
               <input type="text" id="productCount_` + id + `" name="productCount" class="form-control w-50px form-control-sm mx-2 bg-white bg-opacity-25 bg-white bg-opacity-25 text-center" value="1">
               <a href="#" onclick="upCount(` + id + `, ` + price + `)" class="btn btn-secondary btn-sm"><i class="fa fa-plus"></i></a>
            </div>
         </div>
      </div>
      <div class="pos-order-price d-flex flex-column">
         <div class="flex-1">` + price + ` TL</div>
         <div class="text-end">
            <a href="#" onclick="removeProduct(` + id + `, ` + price + `)" class="btn btn-default btn-sm"><i class="fa fa-trash"></i></a>
         </div>
      </div>
    `
    
    const newOrderTab = document.getElementById('newOrderTab');
    newOrderTab.appendChild(newDiv);
   }