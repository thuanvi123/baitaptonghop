<?php
session_start();
include_once("config.php");
?>
<html>
<header>
    <link href="style.css" rel="stylesheet">
</header>
<body>
<div class="container"><h1>Thanh Toán</h1>
    <div id="products-wrapper">
        <div class="view-cart">
            <?php
            if(isset($_SESSION["products"]))
            {
                $current_url = base64_encode($_SERVER['REQUEST_URI']);
                $total = 0;
                echo '<form method="post" action="PAYMENT-GATEWAY">';
                echo '<ul>';
                $cart_items = 0;
                foreach ($_SESSION["products"] as $cart_itm)
                {
                    $product_id = $cart_itm["id"];
                    $results = $mysqli->query("SELECT name, description, price FROM product WHERE product_id ='$product_id' LIMIT 1");
                    $obj = $results->fetch_object();

                    echo '<li class="cart-itm">';
                    echo '<span class="remove-itm"><a href="cart_update.php?removep='.$cart_itm["id"].'&return_url='.$current_url.'">&times;</a></span>';
                    echo '<div class="p-price">'.$currency.$obj->price.'</div>';
                    echo '<div class="product-info">';
                    echo '<h3>'.$obj->name.' (Mã sản phẩm :'.$product_id.')</h3> ';
                    echo '<div class="p-qty">Số lượng : '.$cart_itm["qty"].'</div>';
                    echo '<div>'.$obj->description.'</div>';
                    echo '</div>';
                    echo '</li>';
                    $subtotal = ($cart_itm["price"]*$cart_itm["qty"]);
                    $total = ($total + $subtotal);

                    echo '<input type="hidden" name="item_name['.$cart_items.']" value="'.$obj->name.'" />';
                    echo '<input type="hidden" name="item_code['.$cart_items.']" value="'.$product_id.'" />';
                    echo '<input type="hidden" name="item_desc['.$cart_items.']" value="'.$obj->description.'" />';
                    echo '<input type="hidden" name="item_qty['.$cart_items.']" value="'.$cart_itm["qty"].'" />';
                    $cart_items ++;

                }
                echo '</ul>';
                echo '<span class="check-out-txt">';
                echo '<strong>Tổng : '.$currency.$total.'</strong>  ';
                echo '</span>';
                echo '</form>';

            }else{
                echo 'Giỏ hàng trống';
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>