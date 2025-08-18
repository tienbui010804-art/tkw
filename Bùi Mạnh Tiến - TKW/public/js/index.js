const item=document.querySelectorAll('.item')
const body = document.querySelector("body");
item.forEach(e=>{
    e.addEventListener('click',()=>{
        item.forEach(ele=>{
            ele.classList.remove('active')
        })

        e.classList.add('active')
    })
});
if(localStorage.getItem('products')!=null &&document.getElementById('amount')!=null){
    let product=localStorage.getItem('products')
    product=JSON.parse(product).length
    document.getElementById('amount').textContent=product
}
function clearOrder(){
    localStorage.removeItem("products");
}
function buy(productId) {
    const product = window.products.find(p => p.id === productId);

    if (product) {
        const products = JSON.parse(localStorage.getItem('products')) || [];
        let checkloop = products.some(pro => {
            return pro.id == productId;
        })
        if(!checkloop){
            product.soluong=1
            products.push(product);
            localStorage.setItem('products', JSON.stringify(products));
            document.getElementById('amount').textContent=parseInt(document.getElementById('amount').textContent) +1
            toast({ title: 'Success', message: 'Đặt hàng thành công', type: 'success', duration: 3000 });
        }
        else{
            toast({ title: 'Massage', message: 'Đã có trong giỏ hàng', type: 'info', duration: 3000 });
        }
    } else {
        alert('Sản phẩm không tồn tại!');
    }
}

function filterProducts(type) {
    window.location.href = "?type=" + type;
}
function openCart() {
    showCart();
    document.querySelector('.modal-cart').classList.add('open');
    body.style.overflow = "hidden";
}
function closeCart() {
    document.querySelector('.modal-cart').classList.remove('open');
    body.style.overflow = "auto";
}
function showCart() {
    let products=localStorage.getItem('products')
    if(localStorage.getItem('products')!=null){
        if (products.length !== 2) {
            document.querySelector('.gio-hang-trong').style.display = 'none';
            document.querySelector('button.pay').classList.remove('disabled');
            let productcarthtml = '';
            let products=localStorage.getItem('products')
            products = JSON.parse(products);
            products.forEach(product => {
                productcarthtml += `                    <li class="cart-item" data-id="${product.id}">
                            <div class="item-cart">
                                <div class="cart-img">
                                    <img src="${product.img}" alt="">
                                </div>
                                <div class="cart-info">
                                    <p>${product.name}</p>
                                    <p>${product.gia} USD</p>
                                </div>
                            </div>
                            <div class="cart-item-control">
                                <button class="cart-item-delete" onclick="deleteCartItem(${product.id},this)">Xóa <span class="material-symbols-outlined">delete</span></button>
                                <div class="buttons_added">
                                    <input class="minus is-form" type="button" value="-" onclick="decreasingNumber(this)">
                                    <input class="input-qty" max="100" min="1" name="" type="number" value="${product.soluong}">
                                    <input class="plus is-form" type="button" value="+" onclick="increasingNumber(this)">
                                </div>
                            </div>
                        </li>`
            });
            document.querySelector('.cart-list').innerHTML = productcarthtml;
            updateCartTotal();
            saveAmountCart();
        } 
    }
    else {
        document.querySelector('.gio-hang-trong').style.display = 'flex'
    }
    let modalCart = document.querySelector('.modal-cart');
    let containerCart = document.querySelector('.cart-container');
    let addpro = document.querySelector('.add-product');
    modalCart.onclick = function () {
        closeCart();
    }
    addpro.onclick = function () {
        closeCart();
    }
    containerCart.addEventListener('click', (e) => {
        e.stopPropagation();
    })
}
function decreasingNumber(e) {
    let qty = e.parentNode.querySelector('.input-qty');
    if (qty.value > qty.min) {
        qty.value = parseInt(qty.value) - 1;
    } else {
        qty.value = qty.min;
    }
}
function increasingNumber(e) {
    let qty = e.parentNode.querySelector('.input-qty');
    if (parseInt(qty.value) < qty.max) {
        qty.value = parseInt(qty.value) + 1;
    } else {
        qty.value = qty.max;
    }
}
function deleteCartItem(id, el) {
    let cartParent = el.parentNode.parentNode;
    cartParent.remove();
    let products = JSON.parse(localStorage.getItem('products'));
    let vitri = products.findIndex(item => item.id === id)
    if (vitri !== -1) {
        products.splice(vitri, 1);
    }
    document.getElementById('amount').textContent=parseInt(document.getElementById('amount').textContent) -1

    if (products.length == 0) {
        document.querySelector('.gio-hang-trong').style.display = 'flex';
        document.querySelector('button.pay').classList.add('disabled');
    }
    localStorage.setItem('products', JSON.stringify(products));
    updateCartTotal();
}
function updateCartTotal() {
    document.querySelector('.text-price').innerText = USD(getCartTotal());
}
function USD(price) {
    return price.toLocaleString('en-US', { style: 'currency', currency: 'USD' });
}
function getCartTotal() {
    let products = JSON.parse(localStorage.getItem('products'));
    let tongtien = 0;
    if (products != null) {
        products.forEach(product => {
            tongtien += (parseInt(product.soluong) * parseInt(product.gia));
        });
    }
    return tongtien;
}
function saveAmountCart() {
    let cartAmountbtn = document.querySelectorAll(".cart-item-control .is-form");
    let listProduct = document.querySelectorAll('.cart-item');
    let products = JSON.parse(localStorage.getItem('products'));
    cartAmountbtn.forEach((btn, index) => {
        btn.addEventListener('click', () => {
            let id = listProduct[parseInt(index / 2)].getAttribute("data-id");
            let productId = products.find(item => {
                console.log(id)
                return item.id == id;
            });
            productId.soluong = parseInt(listProduct[parseInt(index / 2)].querySelector(".input-qty").value);
            localStorage.setItem('products', JSON.stringify(products));
            updateCartTotal();
        })
    });
}
let slideIndex = 0;
showSlides();

function changeSlide(n) {
    slideIndex += n;
    showSlides();
}

function showSlides() {
    const slides = document.getElementsByClassName("item-slide");
    if (slideIndex >= slides.length) { slideIndex = 0; }
    if (slideIndex < 0) { slideIndex = slides.length - 1; }

    for (let i = 0; i < slides.length; i++) {
        slides[i].classList.remove("active");  
    }
    slides[slideIndex].classList.add("active");  
}

// login
const formsg=document.querySelector('.modal-sign')
const sign_in=document.querySelector('.modal-login')
const sign_up=document.querySelector('.modal-register')
if(document.querySelector('#login')!=null){
    const loginBtn=document.querySelector('#login')
    loginBtn.addEventListener('click',()=>{
        formsg.classList.add('open');
        formsg.style.top="10%"
        body.style.overflow = "hidden";
    })
}
const close_form=document.querySelector(' .form-close')
close_form.addEventListener('click',()=>{
    formsg.style.top="-70%"
    body.style.overflow = "auto";
})
//chuyển đăng nhập đăng ký
const formLogin=document.querySelector('#sign-up')
const formRegis=document.getElementById('sign-in')
formLogin.addEventListener('click',()=>{
    sign_up.style.opacity="0"
    sign_up.style.zIndex="-1"
    sign_in.style.opacity="1"
    sign_in.style.zIndex="1"
})
formRegis.addEventListener('click',()=>{
    sign_up.style.opacity="1"
    sign_up.style.zIndex="1"
    sign_in.style.opacity="0"
    sign_in.style.zIndex="-1"
})
//pay
function pay(){
    const modal_pay=document.querySelector('.modal-pay')
    const total_bill=document.getElementById("total")
    modal_pay.style.left="50%"
    total_bill.textContent=document.querySelector('.text-price').textContent
}
function closeModal(){
    const modal_pay=document.querySelector('.modal-pay')
    modal_pay.style.left="-90%"
}

function detailProduct(id){
    document.querySelector('.modal-detail').style.top="10%"
    body.style.overflow = "hidden";
    const product = window.products.find(p => p.id === id);
    console.log(product)
    const modal_detail=document.querySelector('.modal-detail')
    modal_detail.innerHTML=
    
    `
        <button class="modal-close"><span class="material-symbols-outlined">close</span></button> 
    <div class="card-img" style="height:30%;">
            <img src="${product.img}" alt="">
        </div>
        <div class="modal-body">
            <div class="info-name">
                ${product.name}
            </div>
            <div class="body-control">
                <div class="info-price">
                    ${product.gia}
                </div>
                <div class="buttons_added">
                    <input class="minus is-form" type="button" value="-" onclick="decreasingNumber(this)">
                    <input class="input-qty" max="100" min="1" name="" type="number" value="1">
                    <input class="plus is-form" type="button" value="+" onclick="increasingNumber(this)">
                </div>
            </div>
            <div class="body-des">
                <span>Ram: ${product.ram}</span>
                <span>Rom: ${product.rom}</span>
                <span>Chip: ${product.chip}</span>
                <span>Màn hình: ${product.man_hinh}</span>
                <span>Camera: ${product.camera}</span>
                <span>Pin: ${product.pin}</span>
            </div>
            <div class="modal-footer">
                <div class="price-total">
                    <span class="thanhtien">Thành tiền : </span>
                    <span class="price">${USD(product.gia)}</span>
                </div>
                <div class="modal-footer-control">
                    <button class="button-dat">Đặt hàng ngay</button>
                </div>
            </div>
        </div>`
        let tgbtn = document.querySelectorAll('.is-form');
        let qty = document.querySelector('.input-qty');
        let priceText = document.querySelector('.price');
        tgbtn.forEach(element => {
            element.addEventListener('click', () => {
                let price = product.gia * parseInt(qty.value);
                priceText.innerHTML = USD(price);
            });
        });

        let productbtn = document.querySelector('.button-dat');
        productbtn.addEventListener('click', (e) => {
            const product = window.products.find(p => p.id === id);
            const products = JSON.parse(localStorage.getItem('products')) || [];
            let checkloop = products.some(pro => {
                return pro.id == id;
            })  
            if(!checkloop){
                product.soluong=parseInt(qty.value)
                products.push(product);
                localStorage.setItem('products', JSON.stringify(products));
                document.getElementById('amount').textContent=parseInt(document.getElementById('amount').textContent) +1
                toast({ title: 'Success', message: 'Đặt hàng thành công', type: 'success', duration: 3000 });
            }
            else{
                toast({ title: 'Massage', message: 'Đã có trong giỏ hàng', type: 'info', duration: 3000 });
            }
        })
        let close_modal=document.querySelector('.modal-close')
        close_modal.addEventListener('click',()=>{
            document.querySelector('.modal-detail').style.top="-90%"
            body.style.overflow = "auto";
        })
}

// lưu hoá đơn
function sendDataToServer() {
    let products=JSON.parse(localStorage.getItem('products'))
    payment=[]
    products.forEach(e=>{
        payment.push(e.id)
    })
    $.ajax({
        type: 'POST',
        url: '../model/productModel.php',
        data: { payment: payment,id:userId },
        dataType: 'json',
        success: function(response) {
            console.log('Data saved successfully:', response);
            localStorage.clear('products')
            toast({ title: 'Massage', message: 'Thanh toán thành công', type: 'success', duration: 3000 });
            setTimeout(()=>{
                toast({ title: 'Massage', message: 'Chào mừng bạn', type: 'success', duration: 3000 });
            },3000)
        },
        error: function(xhr, status, error) {
            console.log('Response from server:', error); 
            console.log('Response from server:', xhr); 
            console.log('Response from server:', status); 

        }
    });
}

function Sign_up(){
    let acc=document.querySelector('#acc-new').value
    let name=document.querySelector('#username').value
    let pass=document.querySelector('#pass-new').value
    $.ajax({
        type:'POST',
        url:'../model/userModel.php',
        data:{account:acc,username:name,password:pass},
        success:function(response){
            console.log(response)
        },
        error:function(e){
            console.log(e)
        }
    })
}