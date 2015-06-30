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
    #customerDegree {
    width: 66px;
    }
    #customerAddressZIP {
    width: 66px;
    }
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
  
  
    $scope.person1 = {};
    $scope.person2 = {};
    $scope.person3 = {};

    $scope.submitData = function (person, resultVarName)
    {
      var config = {
        params: {
          person: person
        }
      };

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

  

  $scope.predvyplneno = {
      ks: ' ks',
      kc: ' Kč',
    };
  $scope.loadUsers = function() {
    // Use timeout to simulate a 650ms request.
    $scope.users = [];
    return $timeout(function() {
      $scope.users = [
        { id: 1, name: 'Mobilní telefony' },
        { id: 2, name: 'Kategorie 2' },
        { id: 3, name: 'Kategorie 3' },
      ];
    }, 999);
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

    <h3>2. AJAX form submission with ng-submit</h3>
    <form name="personForm2" ng-submit="submitData(person2, 'ajaxSubmitResult1')" novalidate>
      <label for="firstNameEdit2">First name:</label>
      <input id="firstNameEdit2" type="text" name="productFrom" ng-model="person2.productFrom" required /><br />
      <label for="lastNameEdit2">Last name:</label>
      <input id="lastNameEdit2" type="text" name="productName" ng-model="person2.productName" required /><br />
      <br />
            <md-select ng-model="person2.productCategory" md-on-open="loadUsers()" style="min-width: 190px;margin-top:12px;" placeholder="Kategorie">
              <md-option ng-value="user.name" ng-repeat="user in users">{{user.name}}</md-option>
            </md-select> 
           <br>
      <button type="submit" ng-disabled="personForm2.$invalid">Submit</button>
    </form>
         <strong><label for="submitDebugText1">Submit result:</label></strong><br />
    <textarea id="submitDebugText1">{{ajaxSubmitResult1 | json}}</textarea><br />
    <br />
  </div>



</md-card>
</md-content>
      </div>



<div flex="50">
<md-content id="form" class="md-padding">
<md-card class="md-whiteframe-z4">



			<div class="left input-icon">
			<md-button class="md-primary selected" aria-label="Produkt">
            <md-icon md-svg-icon="/assets/svg/menu.svg"></md-icon>
            Produkt
          </md-button>
          
			</div>
				<form action="" method="post" class="md-title">
          					
				

          
					<md-content id="first" md-theme="red" layout-padding="" layout="" layout-sm="column">
						
            <md-input-container id="productFrom">
							<label>Značka</label>
							<input type="text" name="productFrom"/>
						</md-input-container>
						<md-input-container id="productName">
							<label>Typ</label>
							<input type="text" name="productName"/>
						</md-input-container>
            <md-input-container id="productPrice">
							<label>Cena</label>
							<input type="text" name="productPrice" ng-model="predvyplneno.kc"/>
						</md-input-container>
          </md-content>
          
          <md-content id="second" md-theme="purple" layout-padding="" layout="" layout-sm="column">
            <md-select name="productCategory" ng-model="user" md-on-open="loadUsers()" style="min-width: 190px;margin-top:12px;" placeholder="Kategorie">
              <md-option ng-value="user" ng-repeat="user in users">{{user.name}}</md-option>
            </md-select> 
               <md-input-container id="productStatus">
							<label>Skladové zásoby</label>
							<input type="text" name="productStatus" ng-model="predvyplneno.ks"/>
						</md-input-container>
            <md-input-container id="productImg">
							<label>Odkaz na obrázek</label>
							<input type="text" name="productImg"/>
						</md-input-container>

					</md-content>
					     	<md-content id="third" md-theme="blue" layout-padding="" layout="" layout-sm="column">


				
		<md-input-container flex>
        <label>Popis</label>
        <textarea name="productDescription" columns="1"></textarea>
      </md-input-container>
					</md-content>
					<div class="right">
						<md-button class="send" type="submit">Zapsat >>></md-button>
					</div>
				</form>
	
</md-card>
</md-content>
      </div>






</div>



  </body>

  </html>
