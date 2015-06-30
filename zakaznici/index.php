<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Zákazníci</title>
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
      a {
        text-decoration: none;
      }
      h2 {
        margin-top: 0;
        color: #428bca;
      }
      th {
        color: #428bca;
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
          <md-button class="md-icon-button md-primary selected" onClick="window.location.href='/zakaznici/'" aria-label="Zákazníci">
            <md-icon md-svg-icon="/assets/svg/person.svg"></md-icon>
          </md-button>
          <md-button class="md-icon-button md-primary" onClick="window.location.href='/produkty/'" aria-label="Produkty">
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
      <md-card class="md-whiteframe-z1">
        <div id="table">
          <table class="table table-hover data-table myTable">
            <thead>
              <tr>
                <th class="customerId col-md-1" ng-click="sort('customerId',$event)">
                  ID<span class="{{Header[0]}}"></span>
                </th>
                <th class="customerDegree col-md-1" ng-click="sort('customerDegree')">
                  Titul<span class="{{Header[2]}}"></span>
                </th>
							  <th class="customerFirstName col-md-1" ng-click="sort('customerFirstName')">
                  Jméno<span class="{{Header[3]}}"></span>
								</th>
                <th class="customerLastName col-md-1" ng-click="sort('customerLastName')"> 
                  Přijmení<span class="{{Header[4]}}"></span></a>
                </th>
                <th class="customerAddressStreet col-md-1" ng-click="sort('customerAddressStreet')"> 
                  Ulice č.p.<span class="{{Header[5]}}"></span>
                </th>
                <th class="customerAddressCity col-md-1" ng-click="sort('customerAddressCity')"> 
                  Město<span class="{{Header[6]}}"></span>
                </th>
                <th class="customerAddressZIP col-md-1" ng-click="sort('customerAddressZIP')"> 
                  PSČ<span class="{{Header[7]}}"></span>
                </th>
                <th class="customerEmail col-md-1" ng-click="sort('customerEmail')"> 
                  Email<span class="{{Header[8]}}"></span>
                </th>
                <th class="customerPhone col-md-1" ng-click="sort('customerPhone')"> 
                  Telefon<span class="{{Header[9]}}"></span>
                </th>
                <th class="customerBirthday col-md-1" ng-click="sort('customerBirthday')"> 
                  Datum narození<span class="{{Header[10]}}"></span>
                </th>
							</tr>
            </thead>
            <tbody>
              <tr ng-repeat="item in ItemsByPage[currentPage] | orderBy:columnToOrder:reverse">
                <td>{{item.customerId}}</td>
                <td>{{item.customerDegree}}</td>
					      <td>{{item.customerFirstName}}</td>
                <td>{{item.customerLastName}}</td>
                <td>{{item.customerAddressStreet}}</td>
                <td>{{item.customerAddressCity}}</td>
                <td>{{item.customerAddressZIP}}</td>
                <td>{{item.customerEmail}}</td>  
                <td>{{item.customerPhone}}</td> 
                <td>{{item.customerBirthday}}</td>  
              </tr>
            </tbody>
          </table>
          <div class="center">
            <ul class="pagination pagination-sm">
              <li ng-class="{active:0}">
                <a href="#" ng-click="firstPage()">První</a>
              </li>
              <li ng-repeat="n in range(ItemsByPage.length)">
                <a href="" ng-click="setPage()" ng-bind="n+1">1</a>
              </li>
              <li>
                <a href="#" ng-click="lastPage()">Poslední</a>
              </li>
            </ul>
				  </div>
        </div>
      </md-card>
    </md-content>
    <hr style="clear: both">
    <md-content id="about" class="md-padding" ng-repeat="item in ItemsByPage[currentPage]">
  		<md-card class="md-whiteframe-z4" layout="row"> 
        <div style="width: 50%">
          <h2>{{item.customerDegree + ' ' + item.customerFirstName + ' ' + item.customerLastName}}</h2>
		      <p>
		        <i>{{item.customerAddressStreet}}</i><br>
		        <i>{{item.customerAddressCity + ' ' + item.customerAddressZIP}}</i><br>
		      </p>
  		  </div>
        <div style="width: 50%">
         	<p>
            <b>Telefon:</b> {{item.customerPhone}}
          </p>
		      <p>
            <b>Email:</b> {{item.customerEmail}}
          </p>
          <p>
          <b>Datum Narození:</b> {{item.customerBirthday}}
          </p>
        </div>
		  </md-card>
  </md-content>
  
<!-- NEW......
<div>
<md-content id="form" class="md-padding">
<md-card class="md-whiteframe-z4">

<script>
angular
	.module('myApp')
	.controller('DemoCtrl', function($scope) {})
	.config( function($mdThemingProvider){
		// Configure a theme
		$mdThemingProvider.theme('red', 'default')
			.primaryPalette('red')
		$mdThemingProvider.theme('green', 'default')
			.primaryPalette('purple')
		$mdThemingProvider.theme('blue', 'default')
			.primaryPalette('blue')
	});
</script>
<style>
	#form {
		margin: 0 auto;
		width: 600px;
	}
	#send_degree {
		width: 70px;
	}
	#send_address_psc {
		width: 70px;
	}
	#send_phone {
		width: 120px;
	}
	.send {
		border-radius: 10px 0 0 0;
		background-color: #C3C3C3;
		font-size: 23px;
		margin: 0;
		padding: 3px 11px 3px 11px;
	}
	h1 {
		color: green;
		font-weight: bold;
	}
	.center {
		margin: 0 auto;
		text-align: center;
	}
	.send:not([disabled]):hover {
		background-color: green;
		color: white;
	}
	.right {
		text-align: right;
		margin: 0;
		padding: 0;
	}
</style>
	<?php
	    header("Access-Control-Allow-Origin: *");
		session_start();
		// set up SQL login
		$sql_servername = "127.0.0.1";
		$sql_username = "www-data";
		$sql_password = "heslonetreba";
		$sql_dbname = "test";
		// check POST information
		if (isset($_POST['send_producer'])) {
			echo '<div class="center">';
				// set variables
				$write_producer = $_POST["send_producer"];
				$write_production_code = $_POST["send_production_code"];
				$write_price = $_POST["send_price"];
				$write_in_stock = $_POST["send_in_stock"];
				$write_description = $_POST["send_description"];
				// create connection
				$conn = new mysqli($sql_servername, $sql_username, $sql_password, $sql_dbname);
				// check connection
				if ($conn->connect_error) {
						die("<br>Connection failed: " . $conn->connect_error);
				}
				// set utf8
				if (!$conn->set_charset("utf8")) {
						printf("<br>Error loading character set utf8: %s\n", $conn->error);
				}
				// prepare sql
				$sql_write = "INSERT INTO obchod_products (
					id,
					producer,
					production_code,
					price,
					in_stock,
					description)
				VALUES (
					'NULL',
					'$write_producer',
					'$write_production_code',
					'$write_price',
					'$write_in_stock',
					'$write_description')";
				// write sql to database
				if ($conn->query($sql_write) === TRUE) {
						echo "<h1>Nový záznam přidán</h1><hr>";
						echo '<md-button onClick="window.location.href=\'http://94.112.88.19/test/new/peckadesign/table_costumers.php\'">Přidat další</md-button>';
						echo '</div>';
				} else {
						echo "<hr> Error: " . $sql_write . "<hr>" . $conn->error;
				}
				$conn->close();
		} else {
			?>
			<div class="center">
			<h1>Přidat nový záznam</h1>
			</div>
				<form action="" method="post" class="md-title">

					<md-content id="first" md-theme="red" layout-padding="" layout="" layout-sm="column">
						<md-input-container id="send_producer">
							<label>Značka</label>
							<input type="text" name="send_producer" placeholder="Titul"/>
						</md-input-container>
						<md-input-container id="send_production_code">
							<label>Typ</label>
							<input required type="text" name="send_production_code"/>
						</md-input-container>
					</md-content>
					<md-content id="second" md-theme="green" layout-padding="" layout="" layout-sm="column">
						<md-input-container id="send_price">
							<label>Cena</label>
							<input required type="text" name="send_price" ng-model="predvyplneno.kc"/>
						</md-input-container>
						<md-input-container id="send_in_stock">
							<label>Naskladněno kusů</label>
							<input required type="text" name="send_in_stock" ng-model="predvyplneno.ks"/>
						</md-input-container>
					</md-content>
					<md-content id="third" md-theme="blue" layout-padding="" layout="" layout-sm="column">
		<md-input-container flex>
        <label>Popis</label>
        <textarea name="send_description" columns="1"></textarea>
      </md-input-container>
					</md-content>
					<div class="right">
						<md-button class="send" type="submit">Zapsat >>></md-button>
					</div>
				</form>
		<?php
			}
		?>

</md-card>
</md-content>

</div>
-->


  </body>

  </html>
