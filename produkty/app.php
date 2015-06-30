<?php
  // set header (Content-type) as javascript
  header("Content-type: application/javascript");
  //PDO is a extension which  defines a lightweight, consistent interface for accessing databases in PHP.
  $db=new PDO('mysql:dbname=test;host=127.0.0.1;','show','heslonetreba');
  $db->exec("set names utf8");
  // prepare the query for analyzing, prepared statements use less resources and run faster
  if (isset($_GET["search"])) {
    $searchID = $_GET['search'];
    $row=$db->prepare('SELECT * FROM obchod_ITEMS WHERE product_ITEM_ID == $searchID');            
  } else {
    $row=$db->prepare('SELECT * FROM obchod_ITEMS');
  }
  // execute the query
  $row->execute();
  //create the array
  $json_data=array();
  //foreach loop
  foreach($row as $rec)
  {
    // send product info      
    $json_array['product_ITEM_ID']=$rec['product_ITEM_ID'];
    $json_array['product_PRODUCTNAME']=$rec['product_PRODUCTNAME'];
    $json_array['product_DESCRIPTION']=$rec['product_DESCRIPTION'];
    $json_array['product_IMGURL']=$rec['product_IMGURL'];
    $json_array['product_IMGURL_ALTERNATIVE']=$rec['product_IMGURL_ALTERNATIVE'];
    $json_array['product_VIDEO_URL']=$rec['product_VIDEO_URL'];
    $json_array['product_PRICE_VAT']=$rec['product_PRICE_VAT'];
    $json_array['product_HEUREKA_CPC']=$rec['product_HEUREKA_CPC'];
    $json_array['product_DELIVERY_ID']=$rec['product_DELIVERY_ID'];
    $json_array['product_CATEGORYTEXT']=$rec['product_CATEGORYTEXT'];
    $json_array['product_DELIVERY_DATE']=$rec['product_DELIVERY_DATE'];
    //here pushing the values in to an array
    array_push($json_data,$json_array);
  }
?>
// Demo of Searching Sorting and Pagination of Table with AngularJS - Advance Example
// setup angular app
var myApp = angular.module('myApp', ['ngMaterial']);
//Not Necessary to Create Service, Same can be done in COntroller also as method like add() method
myApp.service('filteredListService', function () {
  this.searched = function (valLists,toSearch) {
    return _.filter(valLists, function (i) {
      // Search Text in all fields */
      return searchUtil(i, toSearch);
    });
  };
  this.paged = function (valLists,pageSize) {
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
// Controller
var TableCtrl = myApp.controller('TableCtrl', function ($scope, $timeout, $filter, filteredListService) {
  // Get JSON Data
  function getDummyData() {
    return <?php echo json_encode($json_data);?>;
  }
  // set variables for change in plceholder, INPUT file
  $scope.quotes = [
    'ID',
    'výrobce',
    'typu',
    'ceny',
    'popisu',
    'stavu produktu',
    'čehokoliv',
    'libosti'
  ];
  $scope.podle = '';
  // first text
  $scope.counter = 'cokoliv, jakkoliv, kdekoliv';
  // onTimeout change text filed
  $scope.onTimeout = function(){
    $scope.podle = 'podle ';
    $scope.counter = $scope.quotes[Math.floor(Math.random() * $scope.quotes.length)];
    mytimeout  = $timeout($scope.onTimeout,3000);
  }
  // set first change
  var mytimeout  = $timeout($scope.onTimeout,5000);
  // number of data per page
  $scope.pageSize = 6;
  $scope.allItems = getDummyData();
  // default reverse sort by...
  $scope.reverse = true;
  // reset data
  $scope.resetAll = function () {
    $scope.filteredList = $scope.allItems;
    $scope.searchText = '';
    $scope.currentPage = 0;
    $scope.Header = ['','',''];
  }
  // Search Result
  $scope.search = function () {
    $scope.filteredList = filteredListService.searched($scope.allItems, $scope.searchText);
    if ($scope.searchText == '') {
      $scope.filteredList = $scope.allItems;
    }
    $scope.pagination();
  }
  // Calculate Total Number of Pages based on Search Result
  $scope.pagination = function () {
    $scope.ItemsByPage = filteredListService.paged( $scope.filteredList, $scope.pageSize );
  };
  // set number of page, first and last
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
  // sort function
  $scope.sort = function(sortBy){
    $scope.resetAll();
    $scope.columnToOrder = sortBy;
    // $Filter - Standard Service
    $scope.filteredList = $filter('orderBy')($scope.filteredList, $scope.columnToOrder, $scope.reverse);
    if($scope.reverse)
      iconName = 'glyphicon glyphicon-chevron-up';
    else
      iconName = 'glyphicon glyphicon-chevron-down';
    // sort by...
    if(sortBy === 'product_ITEM_ID') {
      $scope.Header[0] = iconName;
    } else if(sortBy === 'product_PRODUCTNAME') {
      $scope.Header[1] = iconName;
    } else if(sortBy === 'productName') {
      $scope.Header[3] = iconName;
    } else if(sortBy === 'productCategory') {
      $scope.Header[4] = iconName;
    } else if(sortBy === 'productPrice') {
      $scope.Header[5] = iconName;
    } else if(sortBy === 'productStatus') {
      $scope.Header[6] = iconName;
    } else if(sortBy === 'productDescription') {
      $scope.Header[7] = iconName;
    } 
    $scope.reverse = !$scope.reverse;
    $scope.pagination();
  };
  //By Default sort ny Name
  $scope.sort ('productId');
});
//Inject Services for DI
//$scope is standard service provided by framework
//If we want to use standard $Filter, It also needs to be injected
//filteredService - custom created by me
TableCtrl.$inject = ['$scope', '$filter','filteredListService'];
function searchUtil(item, toSearch) {
    // Search Text in all fields
    return (
    item.product_PRODUCTNAME.toLowerCase().indexOf(toSearch.toLowerCase()) > -1 || 
    item.productDescription.toLowerCase().indexOf(toSearch.toLowerCase()) > -1 || 
    item.productName.toLowerCase().indexOf(toSearch.toLowerCase()) > -1 || 
    item.productCategory.toLowerCase().indexOf(toSearch.toLowerCase()) > -1 || 
    item.productPrice.toLowerCase().indexOf(toSearch.toLowerCase()) > -1 || 
    item.productStatus.indexOf(toSearch) > -1 ||
    item.product_ITEM_ID == toSearch) ? true : false;
}