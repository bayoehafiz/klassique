<?php 
function product_list(){
    echo'
    <li class="product">
        <div class="product-container">
            <figure>
                <div class="product-wrap">
                    <div class="product-images">
                        <div class="product-badge">
                            <span class="pb-best">Best</span>
                        </div><!-- .product-bage -->
                        <div class="shop-loop-thumbnail">
                            <a href="product-detail.php"><img width="300" height="350" src="/web/images/klassique/product/thumb1.png" alt="Product-1"/></a>
                        </div>
                    </div>
                </div>
                <figcaption>
                    <div class="shop-loop-product-info">
                        <div class="info-title">
                            <h3 class="product_title"><a href="#">White Chef Coat Standard</a></h3>
                        </div>
                        <div class="info-meta">
                            <div class="info-price">
                                <span class="price">
                                    <span class="amount">IDR 260.000</span>
                                </span>
                            </div>
                            <div class="loop-add-to-cart">
                                <a href="product-detail.php">View Details</a>
                            </div>
                        </div>
                        <div class="prod-raty" data-score="4.5"></div>
                    </div>
                </figcaption>
            </figure>
        </div>
    </li>
    ';
}
?>