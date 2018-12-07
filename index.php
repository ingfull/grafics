<!DOCTYPE html>
<?php
    $username ;
    session_start();
    if(isset($_SESSION["username"])){
        $username =  $_SESSION["username"];
    }else{
        echo "nema sesije ";
        header("Location: http://localhost:8080/Ibis-Instruments/login.php");
        die();
    }
//    require_once($_SERVER['DOCUMENT_ROOT'] ."/Ibis-Instruments/PDOp.php");

?>

<html>
    <head>
        <link rel="stylesheet" href="./js/jquery-ui-1.12.1/jquery-ui.css" type="text/css" />
        <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css" type="text/css" />
        <link rel="stylesheet" href="./css/custom.css" type="text/css" />
        <script src="./node_modules/bootstrap/dist/js/bootstrap.min.js" > </script>
     
    </head> 
    <body >
        <script src="./code/highcharts.js"></script>
        <script src="./code/modules/series-label.js"></script>
        <script src="./code/modules/exporting.js"></script>
        <script src="./code/modules/export-data.js"></script>  

      
        
        
        <div id="charts" class="bg-light" ng-app="myApp" ng-controller="myCtrl" >
            <div class="top-menu ">
                <form method="get" action="./login.php">
                    <button class="btn btn-default float-right" ng-click="getTable();" ng-click="login();" name="logout">Logout</button>
                </form>
            </div>
<!-- Apply Contract -->
            <div ng-hide="contract_view">
                <div class="row">
                    
                    <div id="div_mac" class="col-md-2" style="position: relative;">
                        <input name="mac_search" id="mac_search" type="text" class="input-filter bg-default" placeholder="mac adress">
                        <div class="mac-list list-item" id="mac-list" data-field="mac" data-destination-id="contract_search">
                        </div>
                    </div>

                    <div class="col-md-2"  style="position: relative;">
                        <input name="contract_search" id="contract_search" type="text" class="input-filter bg-default" placeholder="contract ID" ng-model="contracrt_id">
                        <div class="contract-list list-item" id="contract_id-list" data-field="contract_id" data-destination-id="mac_search">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="row">
                            
                                 
                            <div class="col-md-2">
                               <img ng-show="load_gif" src="./img/giphy.webp" width="30" heigh="30" style="border: 1px solid red; "  />
                            </div>
                            <div class="col-md-10" style="padding: 0px">
                               <button id="assign-contract" class="input-filter input-apply btn btn-default" ng-click="assignContracrtIdView();"> Apply </button>
                            </div>
                        </div>
                    </div>
                 </div>
            </div>
<!-- END Apply Contract -->
<!-- Apply Date -->
          
            <div  ng-show="contract_view" >
                <div class="row">
                    
                    <div id="group-btn" class="offset-md-4 col-md-4"  >
                        <button class="btn group-btn" style="width: 50%; float: left; border-top-left-radius: 25px; border-bottom-left-radius: 25px;" onclick="loadDoc(1);" ng-click="loadDataDays(1);">1 Day</button>
                        <button class="btn group-btn" style="width: 50%; float: right;border-top-right-radius: 25px; border-bottom-right-radius: 25px;" onclick="loadDoc(7);"  ng-click="loadDataDays(7);"  >7 Days</button>
                        
                        <input id="start_date" class="date" type="text" style="width: 50%; folat: left;" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" name="date_start" placeholder="Start Date">
                        <input id="end_date"  class="date" type="text" style="width: 50%; float: right;" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" name="date_end" placeholder="End Date" >
                        <button style="width:100%; float: right; border-radius: 25px;" class="btn btn-primary" onclick="loadDoc(document.getElementById('end_date').value, document.getElementById('start_date').value)" ng-click="loadDataDays(0);" >Apply Choosen Date</button>
                        
                    </div> 
                    <div class="offset-md-3 col-md-1">
                        <button class="btn btn-primary" ng-click="searchContract();">Serach Contract</button>
                    </div>
                </div>                                                                         
            </div>
<!-- END Apply Date -->


        <div >    
            <div class="row"  >
                    
                   <div class="col-md-1" >
                    <button ng-click="tables_view=true;"  class="btn btn-defalut"  >Tables</button>
                    </div>
                    <div class="col-md-1"  >
                    <button ng-click="tables_view=false;"  class="btn btn-defalut"    >Grafic</button>
                   </div>
           </div> 
                <div style="border: 1px solid grey;">    
                <div ng-show="tables_view"  style="margin: 0px;">
<!-- TABLE VIEW -->
                  <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Value 1</th>
                        <th>Value 2</th>
                        <th>Value 3</th>
                        <th>Value 4</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr  ng-repeat="row in matrica_tabele">
                        <td>{{ row.value_5 }}</td>
                        <td>{{ row.value_1 }} </td>
                        <td>{{ row.value_2 }} </td>
                        <td>{{ row.value_3 }}</td>
                        <td>{{ row.value_4 }}</td>
                    </tr>
                    
                    </tbody>
                </table>

<!--END TABLE VIEW -->    
                </div>

                <div ng-hide="tables_view"  style="margin: 0px;"> 
<!-- GRAFIC VIEW -->       

            <div class="row">
                <div  class="col-md-6 col-sm-12 col-xs-12">
                    <div class="grafic-margin" >
                        <div id="container"></div> 
                    </div>
                </div>
                <div  class="col-md-6 col-sm-12 col-xs-12">
                <div class="grafic-margin">
                    <div id="area-basic"></div> 
                    </div>
                </div>
            </div>
            <div class="row">
                <div  class="col-md-6 col-sm-12 col-xs-12">
                    <div class="grafic-margin">
                        <div id="spline-symbols"></div> 
                    </div>
                </div>
                <div  class="col-md-6 col-sm-12 col-xs-12">
                    <div class="grafic-margin">
                        <div id="spline-plot-bands"></div> 
                    </div>
                </div>
            
            </div>
<!--END GRAFIC VIEW --> 




                </div>
                </div>
            </div>
            
        
    </div>


<script src="./node_modules/angular/angular.min.js"></script>



<script src="./js/custom.js"> </script>
        
        <script src="./node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
        
        <script src="./js/area-basic.js"></script>
        <script src="./js/highcharts.js"  ></script> 
        <script src="./js/spline-plot-bands.js"   ></script>
        <script src="./js/spline-symbols.js"   ></script>
        
        
        <script src="./node_modules/jquery/dist/jquery.js"></script>
        <script src="./js/jquery-ui-1.12.1/jquery-ui.js"></script>
        <script>
            $(document).ready(function(){
                $(".date").datepicker({  
                    dateFormat: 'yy-mm-dd'
                });
            });
        </script> 
        

                                                                 
    </body>
</html>