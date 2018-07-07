<?php
include "final_connection.php";

	function getdistance($lati1,$long1,$lati2,$long2){
			$earthRadius=6371;
			$latfrom=deg2rad($lati1);
			$longfrom=deg2rad($long1);
			$latto=deg2rad($lati2);
			$longto=deg2rad($long2);
		
			$latDelta = $latto - $latfrom;
			$longDelta = $longto - $longfrom;
			$angle = 2* asin(sqrt(pow(sin($latDelta / 2), 2) +
			cos($latfrom) * cos($latto) * pow(sin($longDelta / 2), 2)));
				return $angle * $earthRadius;
	}

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<!--<meta charset="UTF-8" http-equiv="refresh" content="6">-->
	    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

	<title>Data between two Tables</title>
	<style>

	h3,h5{
			display: inline;
		}

	#map {
        width:100%;
        height: 500px;
      	}

    img{
      	padding-right: 30px;
      	padding-left: 30px;
      	padding-top: 5px;
      	padding-bottom: 5px;
      }

     #left_side_padding{
			padding-left: 50px;
			padding-top: 20px;
		}

		#footer{
			width: 100%;
			height: 100px;
			color: #00000;
			content: "© 2008-2012 Runaway Horses. All rights reserved.";
			position: absolute;
		
			

     } 
	</style>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
  
</head>

<body>





		<!--Navigation-->
		<nav style="background-color:#ffaa80	;" sticky-top">
			<div class="cont">
				<span class="navbar-brand mb-0 h1" href="#">
					<img src="Emergency+ (4).png"><h3>Emergency Alert System</h3>
				</span>
			</div>
		</nav>


<div id="left_side_padding">



	<?php 
		$client_value=mysqli_num_rows($result);
		echo "<b>Number of clients: "."<u>".$client_value."</u>"."<br></b>";
		$ambulance_value=mysqli_num_rows($result1);
		echo "<b>Number of available Ambulance: "."<u>".$ambulance_value."</u>"."</b> <br>";


		if($client_value>0){

			while($row=mysqli_fetch_assoc($result)){
				//var_dump($row);
				$client_latitude[]=$row['client_latitude'];
				$client_longitude[]=$row['client_longitude'];
				//echo $client_latitude."<br>";
				//echo $client_longitude;
				//echo "<hr/>";

			}

			while($row1=mysqli_fetch_assoc($result1)){
				//var_dump($row1);
				$ambulance_id[]=$row1['id'];
				$ambulance_latitude[]=$row1['ambulance_latitude'];
				$ambulance_longitude[]=$row1['ambulance_longitude'];
				echo"<hr/>";
			}
		
			for($j=0; $j<$client_value; $j++){
			for( $i=0; $i<$ambulance_value;$i++){
			$results[]=getdistance($client_latitude[$j],$client_longitude[$j],$ambulance_latitude[$i],$ambulance_longitude[$i]);
		
				echo "The Distance between Client and Ambulance " .$ambulance_id[$i]. " is: "."<b><u>".round($results[$i],2)."km</b></u><br><hr/><br>";
			
			}
		
				$real_min_distance=min($results);
				$minimum_distance=round(min($results),2);
				echo "<h5>Minimum Distance between Client and Ambulance : "."<b><u>".$minimum_distance."km</u></b><br><br></h5>";
				$Ambulance_id_number_to_notify=array_search($real_min_distance, $results)+1;
				echo "<h5>Assigning the Ambulance whose id no. "."<u><b>[".$Ambulance_id_number_to_notify."]</u></b>"." for immediate Response.</h5><br><br><hr/>";

			}
			}
			else{
				while($row1=mysqli_fetch_assoc($result1)){
				//var_dump($row1);
				$ambulance_id[]=$row1['id'];
				$ambulance_latitude[]=$row1['ambulance_latitude'];
				$ambulance_longitude[]=$row1['ambulance_longitude'];
				echo"<hr/>";
			}
				echo " There is no client request in the current moment<br> <b>Ambulance are currently on standby condition</b>.";
			}

			
			//$deletequery="DELETE FROM client_location";
			//$del_result=mysqli_query($conn,$deletequery);
	 ?>
	
	<h3>Avaliable Ambulance:</h3><br><br>

</div>
	 <?php 
	 			 for ($g=0;$g<$ambulance_value;$g++){
        		
        		$getting_Amb_lati[]=$ambulance_latitude[$g];
        		$getting_Amb_long[]=$ambulance_longitude[$g];
        			//	echo $getting_Amb_lati[$g]."<br>"; 
        			//	echo $getting_Amb_long[$g]."<br>";
        }
        	 for ($h=0;$h<$client_value;$h++){
        		
        		$getting_clie_lati[]=$client_latitude[$h];
        		$getting_clie_long[]=$client_longitude[$h];
        			//	echo $getting_Amb_lati[$g]."<br>"; 
        			//	echo $getting_Amb_long[$g]."<br>";
        }

 ?>

	 <div id="map"></div>
    <script>
    	var ambu_value=parseInt(<?php echo $ambulance_value;?>);
    	var clie_value=parseInt(<?php echo $client_value;?>);
    	//alert(ambu_value);
    	console.log(ambu_value);
    	console.log(typeof ambu_value);

    	var ambu_lati=JSON.parse('<?php echo json_encode($getting_Amb_lati); ?>');


    	for (var i = 0; i <ambu_value ; i++) {
    			var latitude_data =ambu_lati[i];
    	           console.log(latitude_data);
    	           console.log(typeof latitude_data);
    	            var var1=parseFloat(latitude_data);
    	           console.log(var1);
    	           console.log(typeof var1);
    	}


    	var ambu_long=JSON.parse('<?php echo json_encode($getting_Amb_long); ?>');

    	for (var i = 0; i <ambu_value ; i++) {
    			var longitude_data =ambu_long[i];
    	           console.log(longitude_data);

    	}

    	var clie_lati=JSON.parse('<?php echo json_encode($getting_clie_lati); ?>');

		for (var i = 0; i <clie_value ; i++) {
    			var clie_latitude_data =clie_lati[i];
    	           //console.log(latitude_data);
    	           //console.log(typeof latitude_data);
    	            var var1=parseFloat(latitude_data);
    	           console.log(var1);
    	           console.log(typeof var1);
    	}



    	var clie_long=JSON.parse('<?php echo json_encode($getting_clie_long); ?>');

    	for (var i = 0; i <clie_value ; i++) {
    			var clie_data =clie_long[i];
    	           //console.log(longitude_data);

    	}





     function initMap() {

     	var web_inc=1;
     	

        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 13,
          center: {lat: 27.6853, lng: 85.3317}
        });
        
        	get_clie_marker({lat: parseFloat(clie_lati[0]),lng: parseFloat(clie_long[0])});

      	for(var j=0;j<ambu_value;j++){

    		getmarker({lat: parseFloat(ambu_lati[j]),lng: parseFloat(ambu_long[j])});
    	}
    		
        //	getmarker({lat: 27.6695, lng: 85.3408});
        //	getmarker({lat: 27.6679, lng: 85.3143});
        //	getmarker({lat: 27.6844, lng: 85.3059});
        function get_clie_marker(chords){

        var image = 'https://png.icons8.com/metro/50/000000/street-view.png';
        	//web_inc=web_inc+1;


        var mark = new google.maps.Marker({
          position: chords,
          map: map,
          icon: image
        });
    }


        function getmarker(chords){

        var image = 'http://maps.google.com/mapfiles/kml/paddle/'+web_inc+'.png';
        	web_inc=web_inc+1;


        var beachMarker = new google.maps.Marker({
          position: chords,
          map: map,
          icon: image
        });
    }
    
      }
    </script>


    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyApoFxQHpVkEwptCF9AI8Zzoj7DnIWPJB4&callback=initMap">
    </script>



<!-- Footer -->
<!--<footer class="page-footer font-small stylish-color-dark pt-4 mt-4">

  <!-- Footer Links -->
<!--  <div class="container text-center text-md-left">

    Grid row 
    <div class="row">

       Grid column
      <div class="col-md-4 mx-auto">

         Content
        <h5 class="font-weight-bold text-uppercase mt-3 mb-4">Footer Content</h5>
        <p>Here you can use rows and columns here to organize your footer content. Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>

      </div>
       Grid column 
-->
  <!-- Footer Links -->

  <hr>

 <!-- Call to action -->
  <!-- <ul class="list-unstyled list-inline text-center py-2">
    <li class="list-inline-item">
      <h5 class="mb-1">Register for free</h5>
    </li>
    <li class="list-inline-item">
      <a href="#!" class="btn btn-danger btn-rounded">Sign up!</a>
    </li>
  </ul>-->
  <!-- Call to action -->


  <!-- Copyright -->
  <div class="footer-copyright text-center py-3">© 2018 Copyright:
    <a href="https://mdbootstrap.com/bootstrap-tutorial/">NEPSIAN</a>
  </div>
  <!-- Copyright -->

</footer>
<!-- Footer -->






</body>
</html>