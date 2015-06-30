<?php
header("Content-type: application/javascript");
//PDO is a extension which  defines a lightweight, consistent interface for accessing databases in PHP.
$db=new PDO('mysql:dbname=test;host=127.0.0.1;','show','heslonetreba');
$db->exec("set names utf8");
//here prepare the query for analyzing, prepared statements use less resources and thus run faster
$row=$db->prepare('SELECT * FROM obchod_orders JOIN obchod_customers ON obchod_orders.orderCustomerId = obchod_customers.customerId JOIN obchod_products ON obchod_orders.orderProductId = obchod_products.productId');
// INNER JOIN obchod_customers ON obchod_orders.orderCustomerId = obchod_customers.customerId '



$row->execute();//execute the query
$json_data=array();//create the array
foreach($row as $rec)//foreach loop
{
  // send order info
  $json_array['orderId']=$rec['orderId'];
  $json_array['orderCustomerId']=$rec['orderCustomerId'];
  $json_array['orderProductId']=$rec['orderProductId'];
  $json_array['orderStatus']=$rec['orderStatus'];
  $json_array['orderDescription']=$rec['orderDescription'];
  $json_array['orderCreated']=$rec['orderCreated'];
  // send customer info
  $json_array['customerId']=$rec['customerId'];
  $json_array['customerDegree']=$rec['customerDegree'];
  $json_array['customerFirstName']=$rec['customerFirstName'];
  $json_array['customerLastName']=$rec['customerLastName'];
  $json_array['customerAddressStreet']=$rec['customerAddressStreet'];
  $json_array['customerAddressCity']=$rec['customerAddressCity'];
  $json_array['customerAddressZIP']=$rec['customerAddressZIP'];
  $json_array['customerEmail']=$rec['customerEmail'];
  $json_array['customerPhone']=$rec['customerPhone'];
  $json_array['customerCreated']=$rec['customerCreated'];
  // send product info
  $json_array['productId']=$rec['productId'];
  $json_array['productImg']=$rec['productImg'];
  $json_array['productFrom']=$rec['productFrom'];
  $json_array['productName']=$rec['productName'];
  $json_array['productCategory']=$rec['productCategory'];
  $json_array['productPrice']=$rec['productPrice'];
  $json_array['productStatus']=$rec['productStatus'];
  $json_array['productDescription']=$rec['productDescription'];
  //here pushing the values in to an array

  array_push($json_data,$json_array);
}
?>
//Demo of Searching Sorting and Pagination of Table with AngularJS - Advance Example
var myApp = angular.module('myApp', ['ngMaterial']);
//Not Necessary to Create Service, Same can be done in COntroller also as method like add() method



myApp.service('filteredListService', function () {



    this.searched = function (valLists,toSearch) {
        return _.filter(valLists,
        function (i) {
            /* Search Text in all 3 fields */
            return searchUtil(i, toSearch);
        });
    };
    this.paged = function (valLists,pageSize)
    {
        retVal = [];
        for (var i = 0; i < valLists.length; i++) {
            if (i % pageSize === 0) {
                retVal[Math.floor(i / pageSize)] = [valLists[i]];
            } else {
                retVal[Math.floor(i / pageSize)].push(valLists[i]);
            }
        }
        return retVal;
    };
});
var TableCtrl = myApp.controller('TableCtrl', function ($scope, $timeout, $filter, filteredListService) {


$scope.predvyplneno = {
      ks: ' ks',
      kc: ' Kč',
    };

    /*Get Dummy Data for Example*/
    function getDummyData() {
      return <?php echo json_encode($json_data);?>;
    }

    $scope.quotes = [
      'ID',
      'výrobce',
      'typu produktu',
      'jména',
      'popisu',
      'přijmení',
      'titulu',
      'libosti',
      'data vytvoření objednávky',
      'stavu objednávky',
      'stavu zboží'
    ];
    $scope.podle = '';
    $scope.counter = 'cokoliv, jakkoliv, kdekoliv';
    $scope.onTimeout = function(){
      $scope.podle = 'podle ';
      $scope.counter = $scope.quotes[Math.floor(Math.random() * $scope.quotes.length)];
      mytimeout  = $timeout($scope.onTimeout,3000);
    }
    var mytimeout  = $timeout($scope.onTimeout,5000);
    $scope.pageSize = 6;
    $scope.allItems = getDummyData();
    $scope.reverse = false;
    $scope.resetAll = function () {
        $scope.filteredList = $scope.allItems;
        $scope.searchText = '';
        $scope.currentPage = 0;
        $scope.Header = ['','',''];
    }
    $scope.search = function () {
        $scope.filteredList =
       filteredListService.searched($scope.allItems, $scope.searchText);
        if ($scope.searchText == '') {
            $scope.filteredList = $scope.allItems;
        }
        $scope.pagination();
    }
    // Calculate Total Number of Pages based on Search Result
    $scope.pagination = function () {
        $scope.ItemsByPage = filteredListService.paged( $scope.filteredList, $scope.pageSize );
    };
    $scope.setPage = function () {
        $scope.currentPage = this.n;
    };
    $scope.firstPage = function () {
        $scope.currentPage = 0;
    };
    $scope.lastPage = function () {
        $scope.currentPage = $scope.ItemsByPage.length - 1;
    };
    $scope.range = function (input, total) {
        var ret = [];
        if (!total) {
            total = input;
            input = 0;
        }
        for (var i = input; i < total; i++) {
            if (i != 0 && i != total - 1) {
                ret.push(i);
            }
        }
        return ret;
    };
    $scope.sort = function(sortBy){
        $scope.resetAll();
        $scope.columnToOrder = sortBy;
        //$Filter - Standard Service
        $scope.filteredList = $filter('orderBy')($scope.filteredList, $scope.columnToOrder, $scope.reverse);
        if($scope.reverse)
             iconName = 'glyphicon glyphicon-chevron-up';
         else
             iconName = 'glyphicon glyphicon-chevron-down';
        if(sortBy === 'orderId') {
            $scope.Header[0] = iconName;
        } else if(sortBy === 'customerPhone') {
            $scope.Header[2] = iconName;
        } else if(sortBy === 'orderCreated') {
            $scope.Header[3] = iconName;
        } else if(sortBy === 'orderStatus') {
            $scope.Header[4] = iconName;
        } else if(sortBy === 'productStatus') {
            $scope.Header[5] = iconName;
        }

        $scope.reverse = !$scope.reverse;
        $scope.pagination();
    };
    //By Default sort ny Name
     $scope.sort ('name');
});

//Inject Services for DI
//$scope is standard service provided by framework
//If we want to use standard $Filter, It also needs to be injected
//filteredService - custom created by me
TableCtrl.$inject = ['$scope', '$filter','filteredListService'];
function searchUtil(item, toSearch) {
    /* Search Text in all 3 fields */

    return (item.orderStatus.toLowerCase().indexOf(toSearch.toLowerCase()) > -1 || 
    item.customerFirstName.toLowerCase().indexOf(toSearch.toLowerCase()) > -1 || 
    item.customerLastName.toLowerCase().indexOf(toSearch.toLowerCase()) > -1 || 
    item.customerDegree.toLowerCase().indexOf(toSearch.toLowerCase()) > -1 || 
    item.productFrom.toLowerCase().indexOf(toSearch.toLowerCase()) > -1 || 
    item.productDescription.toLowerCase().indexOf(toSearch.toLowerCase()) > -1 || 
    item.productName.toLowerCase().indexOf(toSearch.toLowerCase()) > -1 || 
    item.productCategory.toLowerCase().indexOf(toSearch.toLowerCase()) > -1 || 
    item.productStatus.indexOf(toSearch) > -1 || 
    item.customerPhone == toSearch ||
    item.orderCreated.indexOf(toSearch) > -1 ||
    item.orderId == toSearch) ? true : false;
}