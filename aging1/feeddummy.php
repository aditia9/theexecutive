<?php
    $server     = "localhost";
    $username   = "theexecu_shop";
    $password   = "Delami@123#";
    $database   = "theexecu_magentoback";

    $db = mysqli_connect($server, $username, $password, $database);
    if(mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
?>
<html>
<head>
    <title>Data Awaiting Bank Transfer</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="../buttons/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
</head>
<body>

    <a href="/admin/index.php" class="btn btn-success btn-xs">Back</a>
    <table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Availability</th>
                <th>Condition</th>
                <th>Title</th>
                <th>Title English</th>
                <th>Title Translate</th>
                <th>Description</th>
                <th>Link</th>
                <th>Image Link</th>
                <th>Price</th>
                <th>Gtin</th>
                <th>MPN</th>
                <th>Brand</th>
                <th>Item Group Id</th>
                <th>Item Group Id Translate</th>
                <th>Google Product Category</th>
                <th>size</th>
                <th>color</th>
                <th>color Translate</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>Availability</th>
                <th>Condition</th>
                <th>Title</th>
                <th>Title English</th>
                <th>Title Translate</th>
                <th>Description</th>
                <th>Link</th>
                <th>Image Link</th>
                <th>Price</th>
                <th>Gtin</th>
                <th>MPN</th>
                <th>Brand</th>              
		<th>Item Group Id</th>
                <th>Item Group Id Translate</th>
                <th>Google Product Category</th>
                <th>size</th>
                <th>color</th>
                <th>color Translate</th>
            </tr>
        </tfoot>
        <tbody>
        <?php
       $sql = $db->query("SELECT a.entity_id, a.sku, b.product_id, b.is_in_stock, c.value as name, f.value as warna, g.value as deskripsi 
        FROM catalog_product_entity a 
        LEFT JOIN cataloginventory_stock_item b ON b.product_id = a.entity_id 
        LEFT JOIN catalog_product_entity_varchar c ON c.entity_id = a.entity_id 
        LEFT JOIN catalog_product_entity_int e ON e.entity_id = a.entity_id 
        LEFT JOIN eav_attribute_option_value f ON f.option_id = e.value 
        LEFT JOIN catalog_product_entity_text g ON g.entity_id = a.entity_id 
        WHERE a.type_id = 'configurable' AND b.product_id != 'NULL' AND b.qty_increments != 0.0000 AND c.attribute_id = 84 AND c.store_id = 0 
        AND e.attribute_id = 97 AND f.store_id = 0 AND g.attribute_id = 76 AND g.store_id = 0 ORDER BY a.entity_id DESC");
       
        while ($row = mysqli_fetch_array($sql)){
            $sku = $row['sku'];
            $tambahan = 1;
            $gabungan = $sku.$tambahan;
            $id = $row['entity_id'];
            $skup = substr($row['sku'], 0, -1);
            $explode = explode("-", $row['name']);
            $product = ucwords(strtolower($explode[0]));
            
            if(strlen($row['sku']) <= 11){

                $sql2 = $db->query("SELECT b.value FROM catalog_product_entity a 
                    LEFT JOIN catalog_product_entity_varchar b ON b.entity_id = a.entity_id WHERE b.attribute_id = 119 AND a.sku = $sku");
                $row2 = mysqli_fetch_array($sql2);

                $sql3 = $db->query("SELECT b.value FROM catalog_product_entity a 
                    LEFT JOIN catalog_product_entity_varchar b ON b.entity_id = a.entity_id WHERE b.attribute_id = 87 AND a.sku = $sku");
                $row3 = mysqli_fetch_array($sql3);

                $sql4 = $db->query("SELECT b.rule_price FROM catalog_product_entity a
                    LEFT JOIN catalogrule_product_price b ON b.product_id = a.entity_id WHERE a.sku = $gabungan");
                $row4 = mysqli_fetch_array($sql4);

                $sql5 = $db->query("SELECT value FROM catalog_product_entity_varchar WHERE attribute_id = 84 AND entity_id = $id");
                $row5 = mysqli_fetch_array($sql5);

                $sql6 = $db->query("SELECT b.value FROM catalog_product_entity_int a 
                    LEFT JOIN eav_attribute_option_value b ON b.option_id = a.value WHERE a.attribute_id = 136 AND a.entity_id = $id");
                $row6 = mysqli_fetch_array($sql6);
            }else{
//		var_dump($skup);
                $sql2 = $db->query("SELECT b.value FROM catalog_product_entity a 
                    LEFT JOIN catalog_product_entity_varchar b ON b.entity_id = a.entity_id WHERE b.attribute_id = 119 AND a.sku = $skup");
                $row2 = mysqli_fetch_array($sql2);

                $sql3 = $db->query("SELECT b.value FROM catalog_product_entity a 
                    LEFT JOIN catalog_product_entity_varchar b ON b.entity_id = a.entity_id WHERE b.attribute_id = 87 AND a.sku = $skup");
                $row3 = mysqli_fetch_array($sql3);
                
                $sql4 = $db->query("SELECT b.rule_price FROM catalog_product_entity a
                    LEFT JOIN catalogrule_product_price b ON b.product_id = a.entity_id WHERE a.sku = $sku");
                $row4 = mysqli_fetch_array($sql4);

                $sql5 = $db->query("SELECT value FROM catalog_product_entity_varchar WHERE attribute_id = 84 AND entity_id = $id");
                $row5 = mysqli_fetch_array($sql5);

                $sql6 = $db->query("SELECT b.value FROM catalog_product_entity_int a 
                    LEFT JOIN eav_attribute_option_value b ON b.option_id = a.value WHERE a.attribute_id = 136 AND a.entity_id = $id");
                $row6 = mysqli_fetch_array($sql6);
            }

            if($row['deskripsi'] == '' && $row['deskripsi'] == NULL){
                $desc = $explode[0];
            }else{
                $desc = htmlspecialchars($row['deskripsi']);
            }

            if($row['is_in_stock'] == 0){
                $available = 'out of stock';
            }else{
                $available = 'in stock';
            }


            if(ucwords(strtolower($explode[0])) == 'Long Sleeve Shirt'){
                $googletranslate='Kemeja lengan panjang';
            }else if(ucwords(strtolower($explode[0])) == 'Long Sleeve Blouse'){
                $googletranslate='Blouse lengan panjang';
            }else if(ucwords(strtolower($explode[0])) == 'Chinos Pants'){
                $googletranslate='Celana Chinos';
            }else if(ucwords(strtolower($explode[0])) == 'Short Sleeve Shirt'){
                $googletranslate='Kemeja lengan pendek';
            }else if(ucwords(strtolower($explode[0])) == 'The Executive X Jenahara'){
                $googletranslate='The Executive X Jenahara';
            }else if(ucwords(strtolower($explode[0])) == 'Short Sleeve Blouse'){
                $googletranslate='Blouse lengan pendek';
            }else if(ucwords(strtolower($explode[0])) == 'Polyester Long Sleeves Blouse'){
                $googletranslate='Blouse lengan pendek polyester';
            }else if(ucwords(strtolower($explode[0])) == 'Short Sleeves T'){
                $googletranslate='T-shirt lengan pendek';
            }else if(ucwords(strtolower($explode[0])) == 'Short Sleeve T'){
                $googletranslate='Kaos lengan pendek';
            }else if(ucwords(strtolower($explode[0])) == 'Mix Cotton Long Sleeves Shirt'){
                $googletranslate='Kemeja katun lengan panjang';
            }else if(ucwords(strtolower($explode[0])) == 'Long Sleeves Blouse 5'){
                $googletranslate='Blouse lengan panjang';
            }else if(ucwords(strtolower($explode[0])) == 'Long Pants'){
                $googletranslate='Celana panjang';
            }else if(ucwords(strtolower($explode[0])) == 'Black Belt'){
                $googletranslate='Ikat pinggang hitam';
            }else if(ucwords(strtolower($explode[0])) == 'Long Pants In Black'){
                $googletranslate='Celana panjang hitam';
            }else if(ucwords(strtolower($explode[0])) == 'Long Pants 1'){
                $googletranslate='Celana panjang';
            }else if(ucwords(strtolower($explode[0])) == 'Long Sleeve Tunic'){
                $googletranslate='Tunik lengan panjang';
            }else if(ucwords(strtolower($explode[0])) == 'Mix Polyester Long Pants'){
                $googletranslate='Celana panjang polyester';
            }else if(ucwords(strtolower($explode[0])) == 'Long Sleeve Jacket'){
                $googletranslate='Jaket lengan panjang';
            }else if(ucwords(strtolower($explode[0])) == 'Stretch Ankle High Rise'){
                $googletranslate='Celana stretch ankle';
            }else if(ucwords(strtolower($explode[0])) == 'Long Sleeve Koko Shirt'){
                $googletranslate='Kemeja koko lengan panjang';
            }else if(ucwords(strtolower($explode[0])) == 'Polyester Sleeveless Blouse'){
                $googletranslate='Blouse tanpa lengan polyester';
            }else if(ucwords(strtolower($explode[0])) == 'Cotton Chinos Pants'){
                $googletranslate='Celana katun chinos';
            }else if(ucwords(strtolower($explode[0])) == 'Mix Cotton Short Sleeves Shirt'){
                $googletranslate='Kemeja katun lengan pendek';
            }else if(ucwords(strtolower($explode[0])) == 'Basic Long Sleeve Blouse'){
                $googletranslate='Blouse Basic lengan panjang';
            }else if(ucwords(strtolower($explode[0])) == 'Long Sleeve T'){
                $googletranslate='Kaos lengan panjang';
            }else if(ucwords(strtolower($explode[0])) == 'Short Sleeve Koko Shirt'){
                $googletranslate='Kemeja koko lengan pendek';
            }else if(ucwords(strtolower($explode[0])) == 'Long Sleeves Shirt 1'){
                $googletranslate='Kemeja lengan panjang';
            }else if(ucwords(strtolower($explode[0])) == 'Tied Sleeve Blouse'){
                $googletranslate='Tied Sleeve Blouse';
            }else if(ucwords(strtolower($explode[0])) == 'Cotton Short Sleeves Blouse'){
                $googletranslate='Blouse katun lengan pendek';
            }else if(ucwords(strtolower($explode[0])) == 'Fine Gauge Short Sleeve Sweater'){
                $googletranslate='Sweater fine gauge lengan pendek';
            }else if(ucwords(strtolower($explode[0])) == 'Mix Polyester Short Sleeves Blouse'){
                $googletranslate='Blouse polyester lengan pendek';
            }else if(ucwords(strtolower($explode[0])) == 'Polyester Short Sleeves Blouse'){
                $googletranslate='Blouse polyester lengan pendek';
            }else if(ucwords(strtolower($explode[0])) == 'Long Sleeves Blouse '){
                $googletranslate='Blouse lengan panjang';
            }else if(ucwords(strtolower($explode[0])) == 'Sportwear Tee'){
                $googletranslate='Sportwear T-shirt';
            }else if(ucwords(strtolower($explode[0])) == 'Cotton Long Sleeves Blouse'){
                $googletranslate='Blouse katun lengan panjang';
            }else if(ucwords(strtolower($explode[0])) == 'Polyester Long Pants'){
                $googletranslate='Celana panjang polyester';
            }else if(ucwords(strtolower($explode[0])) == 'Long Sleeve Gamis'){
                $googletranslate='Gamis lengan panjang';
            }else if(ucwords(strtolower($explode[0])) == 'Sleeveless Blouse'){
                $googletranslate='Blouse tanpa lengan';
            }else if(ucwords(strtolower($explode[0])) == 'Long Sleeves T'){
                $googletranslate='T-shirt lengan panjang';
            }else if(ucwords(strtolower($explode[0])) == 'Formal Pants'){
                $googletranslate='Celana Formal';
            }else if(ucwords(strtolower($explode[0])) == 'Rayon Long Sleeves Blouse'){
                $googletranslate='Blouse rayon lengan panjang';
            }else if(ucwords(strtolower($explode[0])) == 'Fine Gauge Blouse'){
                $googletranslate='Fine Gauge Blouse';
            }else if(ucwords(strtolower($explode[0])) == 'Short Sleeve Blouse With Bow Belt'){
                $googletranslate='Blouse lengan pendek dengan bow belt';
            }else if(ucwords(strtolower($explode[0])) == 'Blouse 3/4 Sleeve'){
                $googletranslate='blouse lengan 3/4';
            }else if(ucwords(strtolower($explode[0])) == 'Short Sleeves Shirt 1'){
                $googletranslate='Kemeja lengan pendek';
            }else if(ucwords(strtolower($explode[0])) == 'Long Sleeves Blouse In Navy'){
                $googletranslate='kemeja lengan panjang navy';
            }else if(ucwords(strtolower($explode[0])) == 'Hoodie Sweatshirt'){
                $googletranslate='Hoodie Sweatshirt';
            }else if(ucwords(strtolower($explode[0])) == 'Ankle Fit Mid Rise Pants'){
                $googletranslate='Celana ankle mid rise';
            }else if(ucwords(strtolower($explode[0])) == 'Long Sleeve Sweater With Zip'){
                $googletranslate='sweater lengan panjang dengan resleting';
            }else if(ucwords(strtolower($explode[0])) == 'Mix Cotton Dress'){
                $googletranslate='dress katun';
            }else if(ucwords(strtolower($explode[0])) == 'Ankle Length Jogger'){
                $googletranslate='Ankle Length Jogger';
            }else if(ucwords(strtolower($explode[0])) == 'Joger Pants'){
                $googletranslate='celana jogger';
            }else if(ucwords(strtolower($explode[0])) == 'Stretch Skinny Fit'){
                $googletranslate='Stretch Skinny Fit';
            }else if(ucwords(strtolower($explode[0])) == 'Slim Fit Formal Pants'){
                $googletranslate='Celana Formal Slim Fit';
            }else if(ucwords(strtolower($explode[0])) == 'Short Sleeve Dress'){
                $googletranslate='Dress lengan pendek';
            }else if(ucwords(strtolower($explode[0])) == 'High Neck Short Sleeve Blouse'){
                $googletranslate='Blouse high neck lengan pendek';
            }else if(ucwords(strtolower($explode[0])) == 'Stripe Short Sleeve Blouse'){
                $googletranslate='Blouse lengan pendek motif garis';
            }else if(ucwords(strtolower($explode[0])) == 'Long Blazer'){
                $googletranslate='Blazer panjang';
            }else if(ucwords(strtolower($explode[0])) == 'Polyester Dress'){
                $googletranslate='Polyester Dress';
            }else if(ucwords(strtolower($explode[0])) == 'Mix Cotton Long Sleeves Blouse'){
                $googletranslate='Blouse katun lengan panjang';
            }else if(ucwords(strtolower($explode[0])) == 'Basic Short Sleeve T'){
                $googletranslate='Kaos basic lengan pendek';
            }else if(ucwords(strtolower($explode[0])) == 'Long Sleeves Blouse In Off White'){
                $googletranslate='blouse putih lengan panjang';
            }else if(ucwords(strtolower($explode[0])) == 'Long Sleeves Shirt In Dark Blue'){
                $googletranslate='kemeja biru lengan panjang';
            }else if(ucwords(strtolower($explode[0])) == 'Short Sleeves Shirt In Blue'){
                $googletranslate='kemeja biru lengan pendek';
            }else if(ucwords(strtolower($explode[0])) == 'Sweat Tee With Ribbon'){
                $googletranslate='Sweat Tee With Ribbon';
            }else if(ucwords(strtolower($explode[0])) == 'Blouse With Front Tied Detail'){
                $googletranslate='Blouse With Front Tied Detail';
            }else if(ucwords(strtolower($explode[0])) == 'Short Sleeves Blouse 5'){
                $googletranslate='blouse lengan pendek';
            }else if(ucwords(strtolower($explode[0])) == 'Ankle Long Pants'){
                $googletranslate='celana panjang ankle';
            }else if(ucwords(strtolower($explode[0])) == 'Long Sleeve Blazer'){
                $googletranslate='blazer lengan panjang';
            }else if(ucwords(strtolower($explode[0])) == 'Long Sleeves Blouse In Red'){
                $googletranslate='blouse merah lengan panjang';
            }else if(ucwords(strtolower($explode[0])) == 'Long Sleeve Sweatshirt'){
                $googletranslate='sweatshirt lengan panjang';
            }else if(ucwords(strtolower($explode[0])) == 'Midi Skirt'){
                $googletranslate='Rok midi';
            }else if(ucwords(strtolower($explode[0])) == 'Long Sleeves Blouse In Black'){
                $googletranslate='Blouse hitam lengan panjang';
            }else if(ucwords(strtolower($explode[0])) == 'Long Pants 5'){
                $googletranslate='celana panjang';
            }else if(ucwords(strtolower($explode[0])) == 'Mix Rayon Short Sleeves Blouse'){
                $googletranslate='blouse rayon lengan pendek';
            }else if(ucwords(strtolower($explode[0])) == 'Ankle Buttoned Pants'){
                $googletranslate='celana ankle dengan kancing';
            }else if(ucwords(strtolower($explode[0])) == 'Short Sleeve Polo'){
                $googletranslate='polo lengan pendek';
            }else if(ucwords(strtolower($explode[0])) == 'Midi Skirt In Black'){
                $googletranslate='rok hitam midi';
            }else{
                $googletranslate=ucwords(strtolower($explode[0]));
            }

            //warna translate
            if(ucwords(strtolower($row['warna'])) == 'Black'){
                $colortranslate='Hitam';
            }else if(ucwords(strtolower($row['warna'])) == 'Navy'){
                $colortranslate='Navy';
            }else if(ucwords(strtolower($row['warna'])) == 'White'){
                $colortranslate='Putih';
            }else if(ucwords(strtolower($row['warna'])) == 'Off White'){
                $colortranslate='Putih';
            }else if(ucwords(strtolower($row['warna'])) == 'Grey '){
                $colortranslate='Abu-Abu';
            }else if(ucwords(strtolower($row['warna'])) == 'Khaki'){
                $colortranslate='Khaki';
            }else if(ucwords(strtolower($row['warna'])) == 'Blue'){
                $colortranslate='Biru';
            }else if(ucwords(strtolower($row['warna'])) == 'Red'){
                $colortranslate='Merah';
            }else if(ucwords(strtolower($row['warna'])) == 'Light Blue'){
                $colortranslate='Biru Muda';
            }else if(ucwords(strtolower($row['warna'])) == 'Dark Blue'){
                $colortranslate='Biru Tua';
            }else if(ucwords(strtolower($row['warna'])) == 'Dusty Blue'){
                $colortranslate='Dusty Blue';
            }else if(ucwords(strtolower($row['warna'])) == 'Taupe'){
                $colortranslate='Taupe';
            }else if(ucwords(strtolower($row['warna'])) == 'Dusty Pink'){
                $colortranslate='Dusty Pink';
            }else if(ucwords(strtolower($row['warna'])) == 'Olive'){
                $colortranslate='Olive';
            }else if(ucwords(strtolower($row['warna'])) == 'Mauve'){
                $colortranslate='Mauve';
            }else if(ucwords(strtolower($row['warna'])) == 'Lilac'){
                $colortranslate='Lilac';
            }else if(ucwords(strtolower($row['warna'])) == 'Pink'){
                $colortranslate='Pink';
            }else if(ucwords(strtolower($row['warna'])) == 'Green'){
                $colortranslate='Hijau';
            }else if(ucwords(strtolower($row['warna'])) == 'Light Grey'){
                $colortranslate='Abu Abu Muda';
            }else if(ucwords(strtolower($row['warna'])) == 'Maroon'){
                $colortranslate='Marun';
            }else if(ucwords(strtolower($row['warna'])) == 'Acru'){
                $colortranslate='Acru';
            }else if(ucwords(strtolower($row['warna'])) == 'Cream'){
                $colortranslate='Krem';
            }else if(ucwords(strtolower($row['warna'])) == 'Dark Grey'){
                $colortranslate='Abu Abu Tua';
            }else if(ucwords(strtolower($row['warna'])) == 'Teal'){
                $colortranslate='Teal';
            }else if(ucwords(strtolower($row['warna'])) == 'Yellow'){
                $colortranslate='Kuning';
            }else if(ucwords(strtolower($row['warna'])) == 'Soft Pink'){
                $colortranslate='Pink Muda';
            }else if(ucwords(strtolower($row['warna'])) == 'Charcoal'){
                $colortranslate='Charcoal';
            }else if(ucwords(strtolower($row['warna'])) == 'Wine'){
                $colortranslate='Wine';
            }else if(ucwords(strtolower($row['warna'])) == 'Denim Blue'){
                $colortranslate='Biru Denim';
            }else if(ucwords(strtolower($row['warna'])) == 'Misty Grey'){
                $colortranslate='Misty Grey';
            }else if(ucwords(strtolower($row['warna'])) == 'Multicolor'){
                $colortranslate='Multicolor';
            }else if(ucwords(strtolower($row['warna'])) == 'Orange'){
                $colortranslate='Oranye';
            }else if(ucwords(strtolower($row['warna'])) == 'Brown'){
                $colortranslate='Coklat';
            }else if(ucwords(strtolower($row['warna'])) == 'Dark Navy'){
                $colortranslate='Dark Navy';
            }else if(ucwords(strtolower($row['warna'])) == 'Mustard'){
                $colortranslate='Mustard';
            }else if(ucwords(strtolower($row['warna'])) == 'Md Blue'){
                $colortranslate='Medium Blue';
            }else if(ucwords(strtolower($row['warna'])) == 'Camel'){
                $colortranslate='Camel';
            }else if(ucwords(strtolower($row['warna'])) == 'Cranberry'){
                $colortranslate='Cranberry';
            }else if(ucwords(strtolower($row['warna'])) == 'Jet Black'){
                $colortranslate='Jet Black';
            }else if(ucwords(strtolower($row['warna'])) == 'Peach'){
                $colortranslate='Peach';
            }else if(ucwords(strtolower($row['warna'])) == 'Light Khaki'){
                $colortranslate='Light Khaki';
            }else if(ucwords(strtolower($row['warna'])) == 'Rose'){
                $colortranslate='Rose';
            }else if(ucwords(strtolower($row['warna'])) == 'Dark Brown'){
                $colortranslate='Coklat Tua';
            }else if(ucwords(strtolower($row['warna'])) == 'Almond'){
                $colortranslate='Almond';
            }else if(ucwords(strtolower($row['warna'])) == 'Purple'){
                $colortranslate='Ungu';
            }else if(ucwords(strtolower($row['warna'])) == 'Watergreen'){
                $colortranslate='Watergreen';
            }else if(ucwords(strtolower($row['warna'])) == 'Ink Blue'){
                $colortranslate='Ink Blue';
            }else if(ucwords(strtolower($row['warna'])) == 'Sand'){
                $colortranslate='Sand';
            }else if(ucwords(strtolower($row['warna'])) == 'Blued'){
                $colortranslate='Blued';
            }else if(ucwords(strtolower($row['warna'])) == 'Bronze'){
                $colortranslate='Bronze';
            }else if(ucwords(strtolower($row['warna'])) == 'Dark Green'){
                $colortranslate='Hijau Tua';
            }else if(ucwords(strtolower($row['warna'])) == 'Burgundi'){
                $colortranslate='Burgundi';
            }else if(ucwords(strtolower($row['warna'])) == 'Plum'){
                $colortranslate='Plum';
            }else{
                $colortranslate=ucwords(strtolower($row['warna']));
            }


            if($product == 'Long Pants 1'){
                $link  = 'http://theexecutive.co.id/catalog/product/view/id/153706/s/long-pants-1-lprbsc516o005-black/';
                $image = 'http://theexecutive.co.id/pub/media/catalog/product/2/1/21635_4.jpg';
            }else if($product == 'Pants With Seatbelt Tape'){
                $link  = 'http://theexecutive.co.id/pants-with-seatbelt-tape-5-lpwsig119g056-black.html';
                $image = 'http://theexecutive.co.id/pub/media/catalog/product/5/-/5-lpwsig119g056_1_.jpg';
            }else if($product == 'Khaki Sandals'){
                $link  = 'http://theexecutive.co.id/khaki-sandals-5-flpcfo119e006-khaki.html';
                $image = 'http://theexecutive.co.id/pub/media/catalog/product/5/-/5-flpcfo119e006_2_.jpg';
            }else if($product == 'Cream Sandals'){
                $link  = 'http://theexecutive.co.id/cream-sandals-5-flpcfo119e005-cream.html';
                $image = 'http://theexecutive.co.id/pub/media/catalog/product/5/-/5-flpcfo119e005_2_.jpg';
            }else if($product == 'Basic Shirt In Black'){
                $link  = 'http://theexecutive.co.id/basic-shirt-in-black-5-bswbsc518o002-black.html';
                $image = 'http://theexecutive.co.id/pub/media/catalog/product/5/-/5-bswbsc518o002_1_.jpg';
            }else if($sku == 910005400020){
                $link  = 'http://theexecutive.co.id/long-pants-1-lpibsc519o033-khaki.html';
                $image = 'http://theexecutive.co.id/pub/media/catalog/product/1/-/1-lpibsc519o033_khaki_1__1.jpg';
            }else if($sku == 910005400019){
                $link  = 'http://theexecutive.co.id/long-pants-1-lpibsc519o033-khaki.html';
                $image = 'http://theexecutive.co.id/pub/media/catalog/product/1/-/1-lpibsc519o033_khaki_1__1.jpg';
            }else if($sku == 910005119024){
                $link  = 'http://theexecutive.co.id/long-sleeve-shirt-1-lsrbsc518o030-lt-grey.html';
                $image = 'http://theexecutive.co.id/pub/media/catalog/product/1/-/1-lsrbsc518o030_lt_grey_1_.jpg';
            }else if($sku == 910005119023){
                $link  = 'http://theexecutive.co.id/long-sleeve-shirt-1-lsrbsc518o030-lt-grey.html';
                $image = 'http://theexecutive.co.id/pub/media/catalog/product/1/-/1-lsrbsc518o030_lt_grey_1_.jpg';
            }else if($sku == 910005119022){
                $link  = 'http://theexecutive.co.id/long-sleeve-shirt-1-lsrbsc518o030-lt-grey.html';
                $image = 'http://theexecutive.co.id/pub/media/catalog/product/1/-/1-lsrbsc518o030_lt_grey_1_.jpg';
            }else if($sku == 910005119021){
                $link  = 'http://theexecutive.co.id/long-sleeve-shirt-1-lsrbsc518o030-lt-grey.html';
                $image = 'http://theexecutive.co.id/pub/media/catalog/product/1/-/1-lsrbsc518o030_lt_grey_1_.jpg';
            }else if($sku == 910005466026){
                $link  = 'http://theexecutive.co.id/chinos-pants-1-lcilbf319d204-navy.html';
                $image = 'http://theexecutive.co.id/pub/media/catalog/product/1/-/1-lcilbf319d204_navy_1_.jpg';
            }else if($sku == 910005466022){
                $link  = 'http://theexecutive.co.id/chinos-pants-1-lcilbf319d204-navy.html';
                $image = 'http://theexecutive.co.id/pub/media/catalog/product/1/-/1-lcilbf319d204_navy_1_.jpg';
            }else if($sku == 910005429009){
                $link  = 'http://theexecutive.co.id/chinos-pants-1-lcicrt119c201-black.html';
                $image = 'http://theexecutive.co.id/pub/media/catalog/product/1/-/1-lcicrt119c201_black_1_.jpg';
            }else if($sku == 910005429008){
                $link  = 'http://theexecutive.co.id/chinos-pants-1-lcicrt119c201-black.html';
                $image = 'http://theexecutive.co.id/pub/media/catalog/product/1/-/1-lcicrt119c201_black_1_.jpg';
            }else if($sku == 910005429006){
                $link  = 'http://theexecutive.co.id/chinos-pants-1-lcicrt119c201-black.html';
                $image = 'http://theexecutive.co.id/pub/media/catalog/product/1/-/1-lcicrt119c201_black_1_.jpg';
            }else if($sku == 910005429005){
                $link  = 'http://theexecutive.co.id/chinos-pants-1-lcicrt119c201-black.html';
                $image = 'http://theexecutive.co.id/pub/media/catalog/product/1/-/1-lcicrt119c201_black_1_.jpg';
            }else if($sku == 910005429010){
                $link  = 'http://theexecutive.co.id/chinos-pants-1-lcicrt119c201-black.html';
                $image = 'http://theexecutive.co.id/pub/media/catalog/product/1/-/1-lcicrt119c201_black_1_.jpg';
            }else if($sku == 950011677009){
                $link  = 'http://theexecutive.co.id/basic-blouse-5-blwkey119h002-rust.html';
                $image = 'http://theexecutive.co.id/pub/media/catalog/product/5/-/5-blwkey119h002_2_.jpg';
            }else if($sku == 950011677010){
                $link  = 'http://theexecutive.co.id/basic-blouse-5-blwkey119h002-rust.html';
                $image = 'http://theexecutive.co.id/pub/media/catalog/product/5/-/5-blwkey119h002_2_.jpg';
            }else if($sku == 950011677011){
                $link  = 'http://theexecutive.co.id/basic-blouse-5-blwkey119h002-rust.html';
                $image = 'http://theexecutive.co.id/pub/media/catalog/product/5/-/5-blwkey119h002_2_.jpg';
            }else if($sku == 950011677012){
                $link  = 'http://theexecutive.co.id/basic-blouse-5-blwkey119h002-rust.html';
                $image = 'http://theexecutive.co.id/pub/media/catalog/product/5/-/5-blwkey119h002_2_.jpg';
            }else if($sku == 95001196800){
                $link  = 'http://theexecutive.co.id/basic-blouse-5-blwkey119h002-rust.html';
                $image = 'http://theexecutive.co.id/pub/media/catalog/product/5/-/5-blwkey119h002_2_.jpg';
            }else if($sku == ''){
                $link  = 'http://theexecutive.co.id/basic-blouse-5-blwkey119h002-rust.html';
                $image = 'http://theexecutive.co.id/pub/media/catalog/product/5/-/5-blwkey119h002_2_.jpg';
            }else {
                $link  = 'http://theexecutive.co.id/'.$row2['value'].'.html';
                $image = 'http://theexecutive.co.id/pub/media/catalog/product'.$row3['value'];
            }
            

            if($row5['value'] == ''){
                $sql51   = $db->query("SELECT value FROM catalog_product_entity_varchar WHERE attribute_id = 73 AND entity_id = $id");
                $row51   = mysqli_fetch_array($sql51);
                $explode = explode(",", $row51['value']);
                $name    = $explode[0];
            }else{
                $name    = $row5['value'];
            }

           if(substr($row4['rule_price'], 0, -2) == ''){
                $sql7 = $db->query("SELECT b.price FROM catalog_product_entity a 
                    LEFT JOIN catalog_product_flat_1 b ON b.entity_id = a.entity_id WHERE a.sku  = $gabungan");
                $row7 = mysqli_fetch_array($sql7);

                $harga = substr($row7['price'], 0, -2);
            }else{
                $harga = substr($row4['rule_price'], 0, -2);
            }

            if(ucwords(strtolower($desc)) == ''){
                $desc = ucwords(strtolower($explode[0]));
            }else{
                $desc = ucwords(strtolower($desc));
            }

      ?>
            <tr>
                <td><?php echo $row['sku']; ?></td>
                <td><?php echo $available; ?></td>
                <td><?php echo 'new'; ?></td>
                <td><?php echo ucwords($name); ?></td>
                <td><?php echo 'The Executive '.ucwords(strtolower($row5['value'])); ?></td>
                <td><?php echo 'The Executive '.$googletranslate; ?></td>
                <td><?php echo $desc; ?></td>
                <td><?php echo $link; ?></td>
                <td><?php echo $image;?></td>
                <td><?php echo $harga.' IDR'; ?></td>
                <td></td>
                <td></td>
                <td><?php echo 'Executive Online'; ?></td>
                <td><?php echo ucwords($name); ?></td>
                <td><?php echo $googletranslate; ?></td>
                <td><?php echo 1604 ?></td>
                <td><?php echo $row6['value']; ?></td>
                <td><?php echo ucwords($row['warna']); ?></td>
                <td><?php echo $colortranslate; ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <script type="text/javascript" src="../assets/js/jquery-3.0.0.min.js"></script>
    <script type="text/javascript" src="../assets/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../buttons/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.13/filtering/row-based/range_dates.js"></script>
    <script type="text/javascript" src="../buttons/js/buttons.html5.min.js"></script>        
    <script type="text/javascript" src="../js/bootstrap.js"></script>
    <script>

    $(document).ready(function() {
       $('#example').DataTable(
      {
        'iDisplayLength': 1000,
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]});
        
 
      // Add event listeners to the two range filtering inputs
      $('#min').keyup( function() { table.draw(); } );
      $('#max').keyup( function() { table.draw(); } );
    });
    </script>

</body>
</html>
