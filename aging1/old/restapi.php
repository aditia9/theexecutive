<?php
require 'config.php'; 
$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
$input = json_decode(file_get_contents('php://input'),true);
 
//$link = mysqli_connect('localhost', 'theexecu_shop', 'Delami@123#', 'theexecu_shop');
mysqli_set_charset($link,'utf8');
 
$data = preg_replace('/[^a-z0-9_]+/i','',array_shift($request));
$id = array_shift($request)+0;

if (strcmp($data, 'data') ==0) {
 switch ($method) {
 case 'GET':
 //$sql = "select * from ps_product ORDER BY id_product DESC".($id?" WHERE id_product=$id":''); break;
$sql = "SELECT p.id_product, pl.name, SUM(pa.quantity) AS quantity, pl.link_rewrite, cl.link_rewrite, 
CONCAT('theexecutive.co.id/en/',cl.link_rewrite,'/',p.id_product,'-',pl.link_rewrite,'.html') as link,
CONCAT('theexecutive.co.id/',p.id_product,'-medium/',pl.link_rewrite,'.jpg') as image
FROM ps_product p 
INNER JOIN (
	select p.* from (
	select id_product, COUNT(reference) AS Jumlah from ps_product_attribute
	where quantity > 0
	group by id_product
)a inner JOIN ps_product_attribute p
on a.id_product = p.id_product 
where a.Jumlah > 3
) pa ON p.id_product=pa.id_product 
LEFT JOIN ps_product_lang pl ON p.id_product=pl.id_product
LEFT JOIN ps_category_lang cl ON p.id_category_default=cl.id_category
WHERE date_add >= '2016-01-01' AND pa.quantity>0 AND p.id_category_default='2' AND cl.id_lang = '1' AND pl.id_lang = '1'
GROUP BY p.id_product, pl.name, pl.link_rewrite, cl.link_rewrite, 
CONCAT('theexecutive.co.id/en/',cl.link_rewrite,'/',p.id_product,'-',pl.link_rewrite,'.html'),
CONCAT('theexecutive.co.id/',p.id_product,'-medium/',pl.link_rewrite,'.jpg')
ORDER BY quantity Desc";
 }
 $result = mysqli_query($db,$sql);
 
 if (!$result) {
 http_response_code(404);
 die(mysqli_error());
 }
 
 if ($method == 'GET') {
 $hasil=array();
 while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
 {
 $hasil[]=$row;
 } 
 $hasil1 = array($hasil);
 echo json_encode($hasil1);
 
 } elseif ($method == 'POST') {
 echo mysqli_insert_id($link);
 } else {
 echo mysqli_affected_rows($link);
 }
}else{
 $hasil1 = array('status' => false, 'message' => 'Access Denied');
 echo json_encode($hasil1);
}

mysqli_close($link);
?>