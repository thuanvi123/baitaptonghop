<?php
session_start();
include_once("config.php");
?>
<html>
<header>
    <link href="style.css" rel="stylesheet">
</header>
<body>
<div class="container"><h1>Tất cả sản phẩm</h1>
    <div id="products-wrapper">
        <div class="products">
            <?php
            //URL hiện tại của trang. cart_update.php sẽ chuyển lại trang này.
            $current_url = base64_encode($_SERVER['REQUEST_URI']);

            $results = $mysqli->query("SELECT * FROM product ORDER BY product_id ASC");
            if ($results) {
                //output results from database
                while($obj = $results->fetch_object())
                {

                    echo '<div class="product">';
                    echo '<form method="post" action="cart_update.php">';
                    echo '<div class="product-thumb"><img src="images/'.$obj->image.'" width="100px"></div>';
                    echo '<div class="product-content"><h3>'.$obj->name.'</h3>';
                    echo '<div class="product-desc">'.$obj->description.'</div>';
                    echo '<div class="product-info">Giá '.$currency.$obj->price.' <input type="text" size="5" name="product_qty" value="1"><button class="add_to_cart">Thêm vào giỏ hàng</button></div>';
                    echo '</div>';
                    echo '<input type="hidden" name="product_id" value="'.$obj->product_id.'" />';
                    echo '<input type="hidden" name="type" value="add" />';
                    echo '<input type="hidden" name="return_url" value="'.$current_url.'" />';
                    echo '</form>';
                    echo '</div>';
                }

            }
            ?>
        </div>

        <div class="shopping-cart">
            <h2>Giỏ Hàng</h2>
            <?php
            if(isset($_SESSION["products"]))
            {
                $total = 0;
                echo '<ol>';
                foreach ($_SESSION["products"] as $cart_itm)
                {
                    echo '<li class="cart-itm">';
                    echo '<span class="remove-itm"><a href="cart_update.php?removep='.$cart_itm["id"].'&return_url='.$current_url.'">&times;</a></span>';
                    echo '<h3>'.$cart_itm["name"].'</h3>';
                    echo '<div class="p-code">Mã sản phẩm : '.$cart_itm["id"].'</div>';
                    echo '<div class="p-qty">Số lượng : '.$cart_itm["qty"].'</div>';
                    echo '<div class="p-price">Giá :'.$currency.$cart_itm["price"].'</div>';
                    echo '</li>';
                    $subtotal = ($cart_itm["price"]*$cart_itm["qty"]);
                    $total = ($total + $subtotal);
                }
                echo '</ol>';
                echo '<span class="check-out-txt"><strong>Tổng : '.$currency.$total.'</strong> <a href="view_cart.php">Thanh toán!</a></span>';
                echo '<span class="empty-cart"><a href="cart_update.php?emptycart=1&return_url='.$current_url.'">Xóa tất cả</a></span>';
            }else{
                echo 'Giỏ hàng trống';
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>