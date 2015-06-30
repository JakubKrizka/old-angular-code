<?php
//PDO is a extension which  defines a lightweight, consistent interface for accessing databases in PHP.
$db=new PDO('mysql:dbname=test;host=127.0.0.1;','show','heslonetreba');
$db->exec("set names utf8");
//here prepare the query for analyzing, prepared statements use less resources and thus run faster
$CATEGORY=$db->prepare('SELECT * FROM obchod_CATEGORY');
$DELIVERY=$db->prepare('SELECT * FROM obchod_DELIVERY');
//execute the query
$CATEGORY->execute();
$DELIVERY->execute();
//create the array
$json_CATEGORY=array();
$json_DELIVERY=array();
//foreach loop
foreach($CATEGORY as $rec1)
{
  // send CATEGORY info
  $json_array['CATEGORY_ID']=$rec1['CATEGORY_ID'];
  $json_array['CATEGORY_NAME']=$rec1['CATEGORY_NAME'];
  $json_array['CATEGORY_FULLNAME']=$rec1['CATEGORY_FULLNAME'];
  array_push($json_CATEGORY,$json_array);
}
foreach($DELIVERY as $rec2)
{
  // send CATEGORY info
  $json_array['DELIVERY_ID']=$rec2['DELIVERY_ID'];
  $json_array['DELIVERY_NAME']=$rec2['DELIVERY_NAME'];
  $json_array['DELIVERY_PRICE']=$rec2['DELIVERY_PRICE'];
  $json_array['DELIVERY_PRICE_COD']=$rec2['DELIVERY_PRICE_COD'];
  array_push($json_DELIVERY,$json_array);
}
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Nový záznam</title>
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
    <script src="app.php" type="application/javascript"></script>
    <script>
    function notOrder() {
      alert('Řadit data je možné pouze u sloupce:\nID, datumu, stavu objednávky a produktu...\n(na rozšířeném vyhledávání usilovně pracujeme)');
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
  	  hr {                                                                                                                                                     
         border-color: #428bca;
  	  }
      .green {
        color: green;
      }
   	  #table {
  		  margin: 0 auto;
        width: 100%;
  	  }
  	  .center {
  	    text-align: center;
        margin: 0 auto;
  	  }
  	  .left {
  	    text-align: left;
  	  }
  	  .right {
  	    text-align: right;
        		margin: 0;
		padding: 0;
  	  }
  	  .form-control {
  	    font-size: 1.2em;
  	    text-align: center;
  	  }
      th, a {
        color: #428bca;
        text-decoration: none;
      }
       	#form {
		margin: 0 auto;
	}
	.send {
		border-radius: 10px 0 0 0;
		background-color: #C3C3C3;
		font-size: 23px;
		margin: 0;
		padding: 3px 11px 3px 11px;
	}
	h1 {
		color: #428bca;
		font-weight: bold;
	}
	.send:not([disabled]):hover {
		background-color: green;
		color: white;
	}
    </style>
    <script>
  angular
  	.module('myApp', ['ngMaterial'])
    .controller('TableCtrl', function($timeout, $scope, $http) {
      // reset variables
      $scope.customerAdd = {};          
      $scope.productAdd = {};
      // customer send AJAX data
      $scope.productDATA = function (product, resultVarName) {
        var config = {
          params: {
            product: product
          }
        };
        // send data
        $http.post("server.php", null, config)
          .success(function (data, status, headers, config)
          {
            $scope[resultVarName] = data;
          })
          .error(function (data, status, headers, config)
          {
            $scope[resultVarName] = "SUBMIT ERROR";
          });
      };
      // product send AJAX data
      $scope.customerDATA = function (customer, resultVarName)
      {
        var config = {
          params: {
            customer: customer
          }
        };
        // send data
        $http.post("server.php", null, config)
          .success(function (data, status, headers, config)
          {
            $scope[resultVarName] = data;
          })
          .error(function (data, status, headers, config)
          {
            $scope[resultVarName] = "SUBMIT ERROR";
          });
      };
      // select element
      $scope.loadCategory = function() {
        // Use timeout to simulate a 999ms request.
        $scope.categorys = [];
        return $timeout(function() {
          $scope.categorys = <?php echo json_encode($json_CATEGORY);?>;
        }, 3);
      }
      $scope.loadType = function() {
        // Use timeout to simulate a 999ms request.
        $scope.types = [];
        return $timeout(function() {
          $scope.types = 
          
          
          <?php echo json_encode($json_DELIVERY);?>
          ;
        }, 3); 
      }  
    })
  	.config( function($mdThemingProvider){
  		// Configure a theme
  		$mdThemingProvider.theme('red', 'default')
  			.primaryPalette('red')
  		$mdThemingProvider.theme('purple', 'default')
  			.primaryPalette('purple')
  		$mdThemingProvider.theme('blue', 'default')
  			.primaryPalette('blue')
      $mdThemingProvider.theme('green', 'default')
  			.primaryPalette('green')
  	});
</script>
  </head>
  <body ng-app="myApp" ng-controller="TableCtrl as ctrl">




    <md-toolbar style="background-color:black;">
      <div class="md-toolbar-tools" layout="row">
        <div id="tool-icons" flex="50">
          <md-button class="md-icon-button md-primary selected" onClick="window.location.href='/nove/'" aria-label="Nové">
            <md-icon md-svg-icon="/assets/svg/add.svg"></md-icon>
          </md-button>
          <md-button class="md-icon-button md-primary" onClick="window.location.href='/zakaznici/'" aria-label="Zákazníci">
            <md-icon md-svg-icon="/assets/svg/person.svg"></md-icon>
          </md-button>
          <md-button class="md-icon-button md-primary" onClick="window.location.href='/produkty/'" aria-label="Produkty">
            <md-icon md-svg-icon="/assets/svg/menu.svg"></md-icon>
          </md-button>
          <md-button class="md-icon-button md-primary" onClick="window.location.href='/objednavky/'" aria-label="Objednávky">
            <md-icon md-svg-icon="/assets/svg/shop.svg"></md-icon>
          </md-button>
        </div>
      </div>
    </md-toolbar>

       <div layout="row">
      <div flex="50"> 
  <md-content id="form" class="md-padding">
    <md-card class="md-whiteframe-z4">
      <div class="left input-icon">
			  <md-button class="md-primary selected" aria-label="Produkt">
          <md-icon md-svg-icon="/assets/svg/person.svg"></md-icon>Zákazník
        </md-button>
      </div>
      <form class="md-title" name="customerForm" ng-submit="customerDATA(customerAdd, 'ajaxSubmitResult2')" novalidate>
					<md-content id="first" md-theme="red" layout-padding="" layout="" layout-sm="column">
						
            <md-input-container id="customerDegree">
							<label>Titul</label>
							<input type="text" ng-model="customerAdd.customerDegree"/>
						</md-input-container>
						<md-input-container id="customerFirstName">
							<label>Jméno</label>
							<input type="text" ng-model="customerAdd.customerFirstName"/>
						</md-input-container>
            <md-input-container id="customerLastName">
							<label>Přijmení</label>
							<input type="text" ng-model="customerAdd.customerLastName"/>
						</md-input-container>
          </md-content>
          
          <md-content id="second" md-theme="purple" layout-padding="" layout="" layout-sm="column">
             
               <md-input-container id="customerAddressStreet">
							<label>Ulice č.p.</label>
							<input type="text" ng-model="customerAdd.customerAddressStreet"/>
						</md-input-container>
            <md-input-container id="customerAddressCity">
							<label>Město</label>
							<input type="text" ng-model="customerAdd.customerAddressCity"/>
						</md-input-container>
            <md-input-container id="customerAddressZIP">
							<label>PSČ</label>
							<input type="text" ng-model="customerAdd.customerAddressZIP"/>
						</md-input-container>

					</md-content>
					     	<md-content id="third" md-theme="blue" layout-padding="" layout="" layout-sm="column">


            <md-input-container id="customerEmail">
							<label>Email</label>
							<input type="text" ng-model="customerAdd.customerEmail"/>
						</md-input-container>

                      <md-input-container id="customerPhone">
							<label>Telefon</label>
							<input type="text" ng-model="customerAdd.customerPhone"/>
						</md-input-container>

                                   
              <md-input-container id="customerBirthday">
                <label>Datum Narození</label>
                <input type="date" ng-model="customerAdd.customerBirthday">
              </md-input-container>
  
					</md-content>
				<div class="right">
          <button type="submit" class="send" ng-disabled="customerForm.$invalid">Submit</button> 
        </div>
      </form>
      <hr>      
      <h1 class="center green">{{ajaxSubmitResult2 | json}}</h1><br />
    </md-card>
  </md-content>

          </div>

         <div flex="50">



<md-content id="form" class="md-padding">
  <md-card class="md-whiteframe-z4" layout-padding="">
    <div class="left input-icon">
		  <md-button class="md-primary selected" aria-label="Produkt">
        <md-icon md-svg-icon="/assets/svg/menu.svg"></md-icon>Produkt
      </md-button>
    </div>
    <form name="productForm" ng-submit="productDATA(productAdd, 'ajaxSubmitResult1')" novalidate class="md-title">
      <md-content id="first" layout="row" md-theme="red" >     
      
        <md-select ng-model="productAdd.CATEGORY_FULLNAME" md-on-open="loadCategory()" style="margin:0;padding-top:12px;" placeholder="Kategorie" flex="35">
          <md-option ng-value="category.CATEGORY_FULLNAME" ng-repeat="category in categorys">{{category.CATEGORY_NAME}}</md-option>
        </md-select>  
        <md-input-container flex="65">
					<label>Název</label>
          <input type="text" name="PRODUCTNAME" ng-model="productAdd.PRODUCTNAME" />
				</md-input-container>
   
      </md-content> 
      <md-content id="second" md-theme="blue" layout="row">  
        <md-select multiple ng-model="productAdd.DELIVERY_ID" md-on-open="loadType()" style="margin:0;padding-top:12px;" placeholder="Dodání" flex="30">
          <md-option ng-value="type.DELIVERY_ID" ng-repeat="type in types">{{type.DELIVERY_NAME + ' (' + type.DELIVERY_PRICE + ' | ' + type.DELIVERY_PRICE_COD + ' )'}}</md-option>
        </md-select> 
        <md-input-container id="PRICE_VAT" flex="35">
					<label>Cena (v Kč.)</label>
					<input type="text" name="PRICE_VAT" ng-model="productAdd.PRICE_VAT"/>
				</md-input-container>
        <md-input-container id="HEUREKA_CPC" flex="35">
					<label>Heureka PPC (v Kč.)</label>
					<input type="text" name="HEUREKA_CPC" ng-model="productAdd.HEUREKA_CPC"/>
				</md-input-container>
        </md-content>
      <md-content id="third" md-theme="purple" style="height: 130px"  layout="row">
        <md-radio-group ng-model="data.group1" flex="30">
          <md-radio-button value="skladem" class="md-primary">Skladem</md-radio-button>
          <md-radio-button value="objednane" class="md-primary"> Objednané </md-radio-button>
        </md-radio-group>
        <md-input-container ng-show="data.group1 == 'skladem'" flex="70">
					<label>Doba dodání (dny)</label>
					<input type="text" name="DELIVERY_DATE_number" ng-model="productAdd.DELIVERY_DATE_number"/>
				</md-input-container> 
        <md-input-container ng-show="data.group1 == 'objednane'" flex="70">
          <label>Datum naskladnění</label>
          <input type="date" name="DELIVERY_DATE_date" ng-model="productAdd.DELIVERY_DATE_date">
        </md-input-container>
      </md-content>
			<md-content id="four" md-theme="green" layout="column">
        <md-input-container md-no-float>
          <input ng-model="productAdd.IMGURL" name="IMGURL" placeholder="Odkaz na obrázek">
        </md-input-container>    
        <md-input-container md-no-float>
          <input ng-model="productAdd.IMGURL_ALTERNATIVE" name="IMGURL_ALTERNATIVE" placeholder="Odkaz na druhý obrázek">
        </md-input-container> 
        <md-input-container md-no-float>
          <input ng-model="productAdd.VIDEO_URL" name="VIDEO_URL" placeholder="Odkaz na video">
        </md-input-container>    
      </md-content>
      <md-content id="five" md-theme="purple" layout="row">
        <md-input-container flex>
          <label>Popis</label>
          <textarea name="DESCRIPTION"  ng-model="productAdd.DESCRIPTION"></textarea>
        </md-input-container>
			</md-content>  
		  <div class="right">
        <button type="submit" class="send" ng-disabled="productForm.$invalid">Submit</button> 
      </div>
    </form>
    <hr>      
    <h1 class="center green">{{ajaxSubmitResult1 | json}}</h1><br />
  </md-card>
</md-content>



           </div>



</div>

         

  </body>

  </html>
