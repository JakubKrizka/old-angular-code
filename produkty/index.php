<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Produkty</title>
    <link rel="stylesheet" type="text/css" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="http://netdsna.bootstrapcdn.com/font-awesome/2.0/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="https://ajax.googleapis.com/ajax/libs/angular_material/0.9.4/angular-material.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular-animate.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular-route.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular-aria.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.15/angular-messages.min.js"></script>
    <script src="http://cdn.rawgit.com/angular/bower-material/v0.10.0/angular-material.js"></script>
    <script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/t-114/assets-cache.js"></script>
    <script src="http://underscorejs.org/underscore.js"></script>
   
    <script>
    
    <?php
  //PDO is a extension which  defines a lightweight, consistent interface for accessing databases in PHP.
  $db=new PDO('mysql:dbname=test;host=127.0.0.1;','show','heslonetreba');
  $db->exec("set names utf8");
  // prepare the query for analyzing, prepared statements use less resources and run faster
  if (isset($_GET["search"])) {
    $searchID = $_GET['search'];
    $row=$db->prepare("SELECT * FROM obchod_ITEMS WHERE product_ITEM_ID='$searchID'");            
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
    'názvu',
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
  $scope.pageSize = 3;
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
    } else if(sortBy === 'product_PRICE_VAT') {
      $scope.Header[2] = iconName;
    } else if(sortBy === 'product_HEUREKA_CPC') {
      $scope.Header[3] = iconName;
    } else if(sortBy === 'product_DELIVERY_ID') {
      $scope.Header[4] = iconName;
    } else if(sortBy === 'product_DELIVERY_DATE') {
      $scope.Header[5] = iconName;
    } else if(sortBy === 'product_CATEGORYTEXT') {
      $scope.Header[6] = iconName;
    }  else if(sortBy === 'product_DESCRIPTION') {
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
    item.product_DESCRIPTION.toLowerCase().indexOf(toSearch.toLowerCase()) > -1 || 
    item.product_CATEGORYTEXT.toLowerCase().indexOf(toSearch.toLowerCase()) > -1 || 
    item.product_HEUREKA_CPC.toLowerCase().indexOf(toSearch.toLowerCase()) > -1 || 
    item.product_PRICE_VAT.toLowerCase().indexOf(toSearch.toLowerCase()) > -1 || 
    item.product_DELIVERY_ID.indexOf(toSearch) > -1 ||
    item.product_ITEM_ID == toSearch) ? true : false;
}
    function notOrder() {
      alert('Řadit podle obrázku? Vážně... XD');
    }
    </script>
    <style>
          .md-icon-button:hover svg,
      .md-icon-button:active svg {
        fill: #428bca;
      }
      .selected svg {
        fill: #428bca;
      }
  	  md-icon {
  	    height: 48px;
  	    width: 48px;
  	  }
  	  md-card {
        padding: 15px;
  	  }
  	  hr {                                                                                                                                                     
        border-color: #428bca;
  	  }
   	  #table {
  		  margin: 0 auto;
        width: 100%;
  	  }
  	  .center {
  	    text-align: center;
  	  }
  	  .left {
  	    text-align: left;
  	  }
  	  .right {
  	    text-align: right;
  	  }
  	  .form-control {
  	    font-size: 1.2em;
  	    text-align: center;
        color: #428bca;
  	  }
      h1 {
        color: #428bca;
      }
      th, a {
        color: #428bca;
        text-decoration: none;
      }
    </style>
  </head>
  <body ng-app="myApp" ng-controller="TableCtrl">
    <md-toolbar style="background-color:black;">
      <div class="md-toolbar-tools" layout="row">
        <div flex="50">
          <md-button class="md-icon-button md-primary" onClick="window.location.href='/nove/'" aria-label="Nové">
            <md-icon md-svg-icon="/assets/svg/add.svg"></md-icon>
          </md-button>
          <md-button class="md-icon-button md-primary" onClick="window.location.href='/zakaznici/'" aria-label="Zákazníci">
            <md-icon md-svg-icon="/assets/svg/person.svg"></md-icon>
          </md-button>
          <md-button class="md-icon-button md-primary selected" onClick="window.location.href='/produkty/'" aria-label="Produkty">
            <md-icon md-svg-icon="/assets/svg/menu.svg"></md-icon>
          </md-button>
          <md-button class="md-icon-button md-primary" onClick="window.location.href='/objednavky/'" aria-label="Objednávky">
            <md-icon md-svg-icon="/assets/svg/shop.svg"></md-icon>
          </md-button>
        </div>
        <input class="form-control" ng-model="searchText" placeholder="{{'Hledat ' + podle + counter + '...'}}" type="search" ng-change="search()" ></input>
      </div>
    </md-toolbar>
    

    
    <md-content class="md-padding">
        
        <div id="table">
          <table class="table table-hover data-table myTable">
          <div class="center">
            <?php
            if (isset($_GET["search"])) {
               echo "<button onClick=\"window.location.href='/produkty/'\">Zobrazit vše</button>";
               }
               ?>
          </div>
            <thead>
              <tr>
                <th class="product_ITEM_ID col-md-1" ng-click="sort('product_ITEM_ID',$event)">
                    ITEM_ID<span class="{{Header[0]}}"></span>
                </th>
                <th class="product_PRODUCTNAME col-md-1" ng-click="sort('product_PRODUCTNAME')">
                    PRODUCTNAME<span class="{{Header[1]}}"></span>
                </th>
                <th class="product_IMGURL col-md-1" onclick="notOrder()">
                    IMGURL 
                </th>
                <th class="product_IMGURL_ALTERNATIVE col-md-1" onclick="notOrder()">
                   IMGURL_ALTERNATIVE
                </th>
							  <th class="product_VIDEO_URL col-md-1" onclick="notOrder()">
                   VIDEO_URL
								</th>
                <th class="product_PRICE_VAT col-md-1" ng-click="sort('product_PRICE_VAT')"> 
                  PRICE_VAT<span class="{{Header[2]}}"></span></a>
                </th>
                <th class="product_HEUREKA_CPC col-md-1" ng-click="sort('product_HEUREKA_CPC')"> 
                  HEUREKA_CPC<span class="{{Header[3]}}"></span>
                </th>
                <th class="product_DELIVERY_ID col-md-1" ng-click="sort('product_DELIVERY_ID')"> 
                  DELIVERY_ID<span class="{{Header[4]}}"></span>
                </th>
                <th class="product_DELIVERY_DATE col-md-1" ng-click="sort('product_DELIVERY_DATE')"> 
                  DELIVERY_DATE<span class="{{Header[5]}}"></span>
                </th>
                <th class="product_CATEGORYTEXT col-md-1" ng-click="sort('product_CATEGORYTEXT')"> 
                  CATEGORYTEXT<span class="{{Header[6]}}"></span>
                </th>
                <th class="product_DESCRIPTION col-md-2" ng-click="sort('product_DESCRIPTION')"> 
                  DESCRIPTION<span class="{{Header[7]}}"></span>
                </th>
              </tr>
            </thead>
            <tbody>
            
            
              <tr ng-repeat="item in ItemsByPage[currentPage] | orderBy:columnToOrder:reverse">
               
                <td>{{item.product_ITEM_ID}}<br><a ng-href="?search={{item.product_ITEM_ID}}">Vyber</a></td>
                <td>{{item.product_PRODUCTNAME}}</td>
                <td><img ng-src="{{item.product_IMGURL}}" class="center" style="width: 70px"/></td>
                <td><img ng-src="{{item.product_IMGURL_ALTERNATIVE}}" class="center" style="width: 70px"/></td>
					      <td><a ng-href="{{item.product_VIDEO_URL}}">Odkaz na Youtube</a></td>
                <td>{{item.product_PRICE_VAT}}</td>
                <td>{{item.product_HEUREKA_CPC}}</td>
                <td>{{item.product_DELIVERY_ID}}</td>
                <td>{{item.product_DELIVERY_DATE}}</td>
                <td>{{item.product_CATEGORYTEXT}}</td>
                <td>
                    <p ng-hide="show">
                      {{ item.product_DESCRIPTION | limitTo: 30 }}... | <a ng-click="show = true">Pokračovat</a>
                    </p>
                    <p ng-show="show">
                      <a ng-click="show = false">Zavřít</a> | {{ item.product_DESCRIPTION }} | <a ng-click="show = false">Zavřít</a>
                    </p>
                </td>
                 
              </tr>
            </tbody>
          </table>
          <div class="center">
            <ul class="pagination pagination-sm">
              <li ng-class="{active:0}"><a href="#" ng-click="firstPage()">První</a></li>
              <li ng-repeat="n in range(ItemsByPage.length)"> <a href="" ng-click="setPage()" ng-bind="n+1">1</a></li>
              <li><a href="#" ng-click="lastPage()">Poslední</a></li>
            </ul>
				  </div>
        </div>
     
  

    </md-content>
    
 
    <md-content id="about" class="md-padding" ng-repeat="item in ItemsByPage[currentPage]">
  		<md-card class="md-whiteframe-z4" layout="row"> 
        <div style="width: 50%" class="center">
  			  <img ng-src="{{item.product_IMGURL}}" style="width: 200px"/><br>
          <img ng-src="{{item.product_IMGURL_ALTERNATIVE}}" style="width: 200px"/>
  		  </div>
        <div style="width: 50%">
          <h1 class="center">{{item.product_PRODUCTNAME}}</h1>
          <h2>{{item.product_PRICE_VAT}}</h2>
    		  <p>
    			  <b>Kategorie: </b><i>{{item.product_CATEGORYTEXT}}</i>
    		  </p>
          
          
          <div ng-show="item.product_DESCRIPTION.length < 300">
            {{item.product_DESCRIPTION}}
          </div>
          <div ng-show="item.product_DESCRIPTION.length > 301">
            <p ng-hide="show">
              {{ item.product_DESCRIPTION | limitTo: 301 }}... | <a ng-click="show = true">Pokračovat</a>
            </p>
            <p ng-show="show">
              <a ng-click="show = false">Zavřít</a> | {{ item.product_DESCRIPTION }} | <a ng-click="show = false">Zavřít</a>
            </p>
          </div>
        </div>
		  </md-card>
    </md-content>


  </body>

  </html>
