<html ng-app="restapi">
    <head>
        <title>Tutorial API</title>  
        <script type="text/javascript" src="angular.min.js"></script>
    </head>
    <style>
        .border{
            border: solid 1px black;
        }
    </style>

    <body> 
        <div ng-controller="ps_product">   
            <table class="border">
                <thead>
                <tr>    
                    <td class="border">ID</td>
                    <td class="border">Nama Product</td>
                    <td class="border">Harga</td>
                    <td class="border">Jumlah</td>
                </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="item in apis">
                        <td class="border">{{item.id_product}}</td>
                        <td class="border">{{item.reference}}</td>
                        <td class="border">{{item.price}}</td>
                        <td class="border">{{item.quantity}}</td>
                    </tr>
                </tbody>
            </table>
        </div> 
        
        <script>  
            var app = angular.module('ps_product', []);

            app.controller('ps_product', function($scope, $http){  
                $http.get("http://aging.theexecutive.co.id/restapi.php/data").success(function(resp){
                    $scope.ps_products = resp; 
                });
            }); 
        </script>
    </body>
</html>