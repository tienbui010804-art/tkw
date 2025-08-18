<?php
session_start();
require_once '../model/productModel.php';
require_once '../model/userModel.php';
$userObj = new User();
$type = isset($_GET['type']) ? $_GET['type'] : 'all'; 
$searchTerm = isset($_GET['search']) ? $_GET['search'] : ''; 
$productObj = new Product();
// $userCur= $userObj->userCurrent($_SESSION['user'].username);
if (!empty($searchTerm)) {
    $products = $productObj->searchProducts($searchTerm);
} else {
    $products = $productObj->getProduct($type);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $account = $_POST['account'];
    $password = $_POST['password'];

    $userInfo = $userObj->getUser ($account, $password);

    if ($userInfo) {
        $_SESSION['user'] = $userInfo;
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['error_message'] = 'Tài khoản hoặc mật khẩu không đúng!';
        header("Location: index.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/doan/public/css/style.css">
    <link rel="stylesheet" href="/doan/public/css/toast-message.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <title>Document</title>
</head>
<body>
    <header>
        <div class="head">
            <div class="logo">
                <img src="/doan/public/img/logo.png" alt="">
            </div>
            <form action="" method="GET" class="form">
                <button type="submit">
                    <svg width="17" height="16" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="search">
                        <path d="M7.667 12.667A5.333 5.333 0 107.667 2a5.333 5.333 0 000 10.667zM14.334 14l-2.9-2.9" stroke="currentColor" stroke-width="1.333" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </button>
                <input class="input" name="search" placeholder="Type your text" required type="text" value="<?= htmlspecialchars($searchTerm) ?>">
                <button class="reset" type="reset">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </form>
                <?php 
                    if (isset($_SESSION['user']) && !empty($_SESSION['user'])) : 
                        $user = $_SESSION['user']; 
                    ?>
                    <div class="cart" onclick="openCart()">
                        <div class="info-cart">
                        <span class="material-symbols-outlined" >shopping_cart <span id="amount">0</span></span>
                        <span >Giỏ hàng</span>
                        </div>
                    </div>
                    <?php else : ?>
                        <div class="cart" >
                            <div class="info-cart">
                            <span class="material-symbols-outlined" >shopping_cart</span>
                            <span >Giỏ hàng</span>
                            </div>
                        </div>
                    <?php endif; ?>

            <div class="user">
                <?php 
                if (isset($_SESSION['user']) && !empty($_SESSION['user'])) : 
                    $user = $_SESSION['user']; 
                ?>
                    <span class="material-symbols-outlined">account_circle</span>
                    <span><?= htmlspecialchars($user[0]['username']) ?></span> 
                    <form action="" method="post" style="width:0; margin-top:6%">
                        <input type="hidden" name="logout" value="1">
                        <button type="submit" onclick=clearOrder()><span class="material-symbols-outlined">logout</span></button>
                    </form>
                <?php else : ?>
                    <span class="material-symbols-outlined">account_circle</span>
                    <span id="login">Đăng nhập</span>
                <?php endif; ?>
            </div>
        </div>
        <nav>
            <div class="list">
                <ul class="list">
                    <li class="item <?= $type == 'all' ? 'active' : '' ?>" data-id="all" onclick="filterProducts('all')">Tất cả</li>
                    <li class="item <?= $type == 'Apple' ? 'active' : '' ?>" data-id="Apple" onclick="filterProducts('Apple')">Iphone</li>
                    <li class="item <?= $type == 'Samsung' ? 'active' : '' ?>" data-id="Samsung" onclick="filterProducts('Samsung')">SamSung</li>
                    <li class="item <?= $type == 'Oppo' ? 'active' : '' ?>" data-id="Oppo" onclick="filterProducts('Oppo')">Oppo</li>
                    <li class="item <?= $type == 'Xiaomi' ? 'active' : '' ?>" data-id="Xiaomi" onclick="filterProducts('Xiaomi')">Xiaomi</li>
                </ul>
            </div>
        </nav>
    </header>
    <div class="content">
        <div class="main">
        <div class="slider">
            <div class="slides">
                <div class="item-slide fade">
                    <img src="/doan/public/img/slide1.gif" alt="Ảnh 1">
                </div>
                <div class="item-slide fade">
                <img src="/doan/public/img/slide2.gif" alt="Ảnh 2">
                </div>
            </div>
        <button class="prev btn" onclick="changeSlide(-1)">&#10094;</button>
        <button class="next btn" onclick="changeSlide(1)">&#10095;</button>
        </div>
            <h1> Sản phẩm </h1>
            <div class="slide">
            <?php if (empty($products)): ?>
                    <h2>Không có sản phẩm nào</h2>
                <?php else: ?>
                    <?php foreach($products as $product): ?>
                        <div class="card" id="<?= $product['id'] ?>" >
                            <div class="box-card" onclick="detailProduct(<?= $product['id'] ?>)">
                                <div class="card-img">
                                    <img src="<?= $product['img'] ?>" alt="">
                                </div>
                                <div class="card-info">
                                    <div class="info-name"><?= htmlspecialchars($product['name']) ?></div>
                                    <div class="info-price"><?= htmlspecialchars($product['gia']) ?> USD</div>
                                    <div class="text">Không phí chuyển đổi khi trả góp 0% qua thẻ tín dụng kì hạn 3-6 tháng </div>
                                </div>
                            </div>
                            <div class="gr-btn" onclick="buy(<?= $product['id'] ?>)">
                                <span class="material-symbols-outlined">add_shopping_cart</span>
                                <button >Đặt Hàng</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
            <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="modal-cart">
        <div class="cart-container">
            <div class="cart-header">
                <h3 class="cart-header-title"><span class="material-symbols-outlined">shopping_cart</span>Giỏ hàng</h3>
                <button class="cart-close" onclick="closeCart()"><span class="material-symbols-outlined">close</span></button>
            </div>
            <div class="cart-body">
                <div class="gio-hang-trong">
                    <i class="fa-thin fa-cart-xmark"></i>
                    <p>Không có sản phẩm nào trong giỏ hàng của bạn</p>
                </div>
                <ul class="cart-list">
                </ul>

            </div>
            <div class="cart-footer">
                <div class="cart-total-price">
                    <p class="text-tt">Tổng tiền:</p>
                    <p class="text-price">0đ</p>
                </div>
                <div class="cart-footer-payment">
                    <button class="add-product"><span class="material-symbols-outlined">add_shopping_cart</span> Thêm Sản phẩm</button>
                    <button class="pay disabled" onclick="pay()"><span class="material-symbols-outlined">payments</span>Thanh toán</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-sign">
        <button class="form-close"><span class="material-symbols-outlined">close</span></button>
        <div class="modal-login">
            <h3 class="form-title">Đăng nhập tài khoản</h3>
            <form class="login-form" action="" method="POST">
                <div class="form-group">
                    <label for="phone" class="form-label">Tài khoản</label>
                    <input id="account" name="account" type="text" placeholder="Nhập tài khoản" require class="form-control">
                    <span class="form-message phonelog"></span>
                </div>
                <div class="form-group">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <input id="password" name="password" type="password" placeholder="Nhập mật khẩu" class="form-control" require >
                    <span class="form-message-check-login form-message"></span>
                </div>
                <button class="form-submit" id="login-button">Đăng nhập</button>
            </form>
            <div class="text-tran" id="sign-in">Đăng ký tài khoản ?</div>
        </div>
        <div class="modal-register">
            <h3 class="form-title">Đăng ký tài khoản</h3>
            <form class="login-form" >
                <div class="form-group">
                    <label for="phone" class="form-label">Tên hiển thị</label>
                    <input id="username" name="username" type="text" placeholder="Nhập tên hiển thị" require class="form-control">
                    <span class="form-message phonelog"></span>
                </div>
                <div class="form-group">
                    <label for="phone" class="form-label">Tài khoản</label>
                    <input id="acc-new" name="acc-new" type="text" placeholder="Nhập tài khoản" require class="form-control">
                    <span class="form-message phonelog"></span>
                </div>
                <div class="form-group">
                    <label for="password" class="form-label">Mật khẩu</label>
                    <input id="pass-new" name="pass-new" type="password" placeholder="Nhập mật khẩu" class="form-control" require>
                    <span class="form-message-check-login form-message"></span>
                </div>
                <button class="form-submit" id="register-button" onclick="Sign_up()">Đăng ký</button>
            </form>
            <div class="text-tran" id="sign-up">Đăng nhập ngay ?</div>
        </div>
    </div>
    <div class="modal-pay">
        <div class="pay-content">
            <p style="font-size:28px; font-weight:600; margin-bottom:15px; display:flex; justify-content: space-between;">Thông tin người nhận <span class="material-symbols-outlined" onclick="closeModal()" style="cursor:pointer;">close</span></p>
            <div class="bill">
                <div class="form-group">
                    <input id="tennguoinhan" name="tennguoinhan" type="text"
                        placeholder="Tên người nhận" class="form-control">
                    <span class="form-message"></span>
                </div>
                <div class="form-group">
                    <input id="sdtnhan" name="sdtnhan" type="text" placeholder="Số điện thoại nhận hàng"
                        class="form-control">
                    <span class="form-message"></span>
                </div>
                <div class="form-group">
                    <input id="diachinhan" name="diachinhan" type="text" placeholder="Địa chỉ nhận hàng"
                        class="form-control chk-ship">
                    <span class="form-message"></span>
                </div>
            </div>
            <div class="bill-pay">
                <span>Tổng tiền :</span> <span id="total"></span>
            </div>
            <button onclick="sendDataToServer()">Xác nhận</button>
        </div>
    </div>
    <div class="modal-detail ">
    </div>
    <div id="toast"></div>
    <footer>

    </footer>
    <script>
        window.userId= <?=  isset($_SESSION['user']) ?>;
        window.products = <?= json_encode($products) ?>;
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="/doan/public/js/index.js"></script>
    <script src="/doan/public/js/toast-message.js"></script>

</body>
</html>