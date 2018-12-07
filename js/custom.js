var promenljiva = "Neka Vrednost";

console.log("Hello World");


var mac_search = document.getElementById("mac_search");


var assign_contract =   document.getElementById("assign-contract");
var contract_id; 

assign_contract.addEventListener("click", function(){
    contract_id = document.getElementById("contract_search").value;
    
});

    var elementsArray = document.querySelectorAll(".input-filter");

elementsArray.forEach(function(elem) {
    elem.addEventListener("keyup", function(){
    
        
    var div_list = this.parentNode.querySelector(".list-item");
    var input_search = this;
     div_list.innerHTML = "";

    if(this.value){
        
     var xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange = function() {
     if (this.readyState == 4 && this.status == 200) {
         var mac_addresses = JSON.parse(this.responseText);
         
         mac_addresses.forEach(function(element) {
             var list_item = document.createElement("div");

            
              if(div_list.dataset.field=="mac"){
                list_item.dataset.destination_value = element.contract_id;
                list_item.innerHTML = element.mac;
              }else if(div_list.dataset.field=="contract_id"){
                list_item.dataset.destination_value = element.mac;
                list_item.innerHTML = element.contract_id;
              }
             
           
             list_item.addEventListener("click", function(){
 
                 
             
                 document.getElementById("mac_search").value = this.innerHTML;
                 document.getElementById(div_list.dataset.destinationId).value =  this.dataset.destination_value;
                 div_list.innerHTML = "";
             
             });
          
             div_list.append(list_item);
                 
             });
         
         }
     };
 
 
     xhttp.open("GET", "odgovor.php?input_search="+input_search.value+"&field="+div_list.dataset.field, true);
     xhttp.send();
    }
 
 });
});


window.addEventListener('click', function(e){   
  if ( !(document.getElementById('mac-list').contains(e.target))){
      
    document.getElementById('mac-list').innerHTML = "";
  } else{
    // Clicked outside the box

    console.log("opcija else");
  }
});
   
        var arr;
        var arr_1;
        var arr_3;
        var arr_4;

        var categories;




var app = angular.module('myApp', []);
app.controller('myCtrl', function($scope, $http) {
    $scope.table ;
    $scope.load_gif = true;
    $scope.tables_view = true;
    $scope.matrica;
    $scope.contracrt_id = null;
    $scope.matrica_grafics = [];
    $scope.matrica_tabele = [];
    
   
    $scope.contract_view ;

    $scope.assignContracrtIdView = function(){
     //   $scope.contract_view =   $scope.contracrt_id ;
        $scope.contracrt_id = $scope.contract_view =  document.getElementById("contract_search").value;
        
    }

    $scope.searchContract = function(){
        $scope.contracrt_id =$scope.contract_view = null;
        document.getElementById("contract_search").value = null;
        document.getElementById("mac_search").value = null;
        console.log("Retur to Search Contract");
    }

    $scope.getTable = function(){
        $http.get("./odgovor.php?contract_id=1&start=2018-12-07&end=2018-12-01&table=true").then(function(response){
            
            
            $scope.table =response.data ;
            console.log($scope.table);
        });
    
    }

    $scope.loadDataDays = function(days, end=null){
        
        
        if(days==0){
            days = document.getElementById("start_date").value;
            end = document.getElementById("end_date").value;
            if(days>end){
                alert("nedozvoljeni ospeg");
                return 1;
            }
        }
        
        
        

        $http.get("./odgovor.php?contract_id="+ $scope.contracrt_id  +"&start=" + days + "&end=" + end ).then(function(response){
        
                

            $scope.matrica_tabele = response.data;
            var matrica = response.data;
            $scope.matrica_grafics ;

            for (let [key, valuee] of Object.entries(response.data[0])) {
                $scope.matrica_grafics[key] =matrica.map(function(value,index) { return value[key]; });
                
            
            }

            
            
            areaBasicFunctuon($scope.matrica_grafics["value_1"]);
            hightcharts($scope.matrica_grafics["value_2"]);
            splineSymbols($scope.matrica_grafics["value_3"], $scope.matrica_grafics["value_5"]);
            splinePlotBands($scope.matrica_grafics["value_4"]);

        });

        
        
    }

    $scope.login = function(){
        $http.get("./odgovor.php?"+ $scope.contracrt_id  +"&start=" + days + "&end=" + end ).then(function(response){
                console.log(response.data); 
        });
    }

    $scope.rotateTable = function(){

    }

});