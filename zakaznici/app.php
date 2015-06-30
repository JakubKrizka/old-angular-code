<?php
  // set header (Content-type) as javascript
  header("Content-type: application/javascript");
  // PDO is a extension which defines a lightweight, consistent interface for accessing databases in PHP.
  $db=new PDO('mysql:dbname=test;host=127.0.0.1;','show','heslonetreba');
  $db->exec("set names utf8");
  // prepare the query for analyzing, prepared statements use less resources and run faster
  $row=$db->prepare('SELECT * FROM obchod_customers');
  // execute the query
  $row->execute();
  // create the array
  $json_data=array();
  // foreach loop
  foreach($row as $rec) {
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
    $json_array['customerBirthday']=$rec['customerBirthday'];
    // here pushing the values in to an array
    array_push($json_data,$json_array);
  }
?>
// Demo of Searching Sorting and Pagination of Table with AngularJS - Advance Example
// setup angular app
var myApp = angular.module('myApp', ['ngMaterial']);
// Not Necessary to Create Service, Same can be done in Controller also as method like add() method
myApp.service('filteredListService', function () {
  this.searched = function (valLists,toSearch) {
    return _.filter(valLists, function (i) {
      /* Search Text in all fields */
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
    'titulu',
    'jména',
    'přijmení',
    'ulice a č.p.',
    'města',
    'PSČ',
    'telefonu',
    'emailu',
    'libosti',
    'data narození',
    'data vytvoření',
    'čehokoliv'
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
  $scope.reverse = false;
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
    if(sortBy === 'customerId') {
      $scope.Header[0] = iconName;
    } else if(sortBy === 'customerDegree') {
      $scope.Header[2] = iconName;
    } else if(sortBy === 'customerFirstName') {
      $scope.Header[3] = iconName;
    } else if(sortBy === 'customerLastName') {
      $scope.Header[4] = iconName;
    } else if(sortBy === 'customerAddressStreet') {
      $scope.Header[5] = iconName;
    } else if(sortBy === 'customerAddressCity') {
      $scope.Header[6] = iconName;
    } else if(sortBy === 'customerAddressZIP') {
      $scope.Header[7] = iconName;
    } else if(sortBy === 'customerEmail') {
      $scope.Header[8] = iconName;
    } else if(sortBy === 'customerPhone') {
      $scope.Header[9] = iconName;
    } else if(sortBy === 'customerBirthday') {
      $scope.Header[10] = iconName;
    }
    $scope.reverse = !$scope.reverse;
    $scope.pagination();
  };
  // By Default sort by customerId from new one
  $scope.sort('customerId');
});
//Inject Services for DI
//$scope is standard service provided by framework
//If we want to use standard $Filter, It also needs to be injected
//filteredService - custom created by me
TableCtrl.$inject = ['$scope', '$filter','filteredListService'];
function searchUtil(item, toSearch) {                                                                                                                                                                                                                                                                                            
    // Search Text in all fields
    return (item.customerDegree.toLowerCase().indexOf(toSearch.toLowerCase()) > -1 || 
    item.customerBirthday.toLowerCase().indexOf(toSearch.toLowerCase()) > -1 || 
    item.customerEmail.toLowerCase().indexOf(toSearch.toLowerCase()) > -1 || 
    item.customerFirstName.toLowerCase().indexOf(toSearch.toLowerCase()) > -1 || 
    item.customerLastName.toLowerCase().indexOf(toSearch.toLowerCase()) > -1 || 
    item.customerAddressStreet.toLowerCase().indexOf(toSearch.toLowerCase()) > -1 || 
    item.customerAddressCity.toLowerCase().indexOf(toSearch.toLowerCase()) > -1 || 
    item.customerAddressZIP.indexOf(toSearch) > -1 || 
    item.customerPhone.indexOf(toSearch) > -1 ||
    item.customerId == toSearch) ? true : false;
}