<?php
/**
*查询指定用户的购物车内容
*请求参数：
  uid-用户ID，必需
*输出结果：
  {
    "uid": 1,
    "products":[
      {"pid":1,"title1":"xxx","pic":"xxx","price":1599.00,"count":3},
      {"pid":3,"title1":"xxx","pic":"xxx","price":1599.00,"count":3},
      ...
      {"pid":5,"title1":"xxx","pic":"xxx","price":1599.00,"count":3}
    ]
  }
*/
@$uid = $_REQUEST['uid'] or die('uid required');


require('init.php');
$output['uid'] = $uid;

$sql = "SELECT pid,title1,pic,price,count,did FROM wm_product,wm_cart_detail WHERE wm_cart_detail.productId=wm_product.pid AND pid IN (SELECT productId FROM wm_cart_detail WHERE cartId=(SELECT cid FROM wm_cart WHERE userId=$uid)) AND wm_cart_detail.cartId=(SELECT cid FROM wm_cart WHERE userId=$uid)";
$result = mysqli_query($conn,$sql);
$output['products'] = mysqli_fetch_all($result, MYSQLI_ASSOC);


echo json_encode($output);