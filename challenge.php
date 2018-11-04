<?php
	session_start();
 
	if(!isset($_SESSION['user_id']) || !isset($_SESSION['logged_in'])){

	    header('Location: login.php');
	    exit;
	}

	if (isset($_POST['Logout'])) { 

		session_destroy();
		header('location: login.php');
	}

	$idm = $_SESSION['user_id'] ;

	require 'conn.php' ;

	$sql =("SELECT what_about, how_it_works, when_it_works FROM idea WHERE '$idm' = member_id ORDER BY id DESC"); 
?>

<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<style type="text/css">
			label {
			    padding: 12px 12px 12px 0;
			    display: inline-block;
			}

			input[type=submit] {
			    padding: 12px 20px;
			    border-radius: 4px;
			    cursor: pointer;
			}

			input[type=reset] {
			    padding: 12px 20px;
			    border-radius: 4px;
			    cursor: pointer;
			    background-color: yellow;
			    border: none;
			}

			input[type=submit]:hover {
			    background-color: #45a049;
			}

			.container {
			    border-radius: 10px;
			    background-color: white;
			    padding: 30px;
			    margin: 2%;
			}

			.col-25 {
			    float: left;
			    width: 25%;
			    margin-top: 6px;
			}

			.col-75 {
			    float: left;
			    width: 75%;
			    margin-top: 6px;
			}

			/* Clear floats after the columns */
			.row:after {
			    content: "";
			    display: table;
			    clear: both;
			}

			input[type=text] {
			    width: 70%;
			    padding: 12px;
			    border: 1px solid #ccc;
			    border-radius: 4px;
			    resize: vertical;
			}

			.vl {
			    border-left: 1px solid #E6E6FA;
			    height: 600px;
			    position: absolute;
			    left: 58%;
			    top: 40%;
 			    margin-left: -3px;
			}

			.left {
				float:left; 
				width:55%; 
				background-color: #E6E6FA;
			    padding: 10px;
			    box-shadow: 5px 10px 8px #888888;
			}

			.right {
				float:left; 
				width:40%;
				height:600px
			}

			.idea {
				border-radius: 2px;
			    background-color: 	#87CEFA;
			    padding: 20px;
			    margin: 2%;
			    width: 55%

			}
			button {
				padding: 5px 10px;
			    border-radius: 2px;
			    cursor: pointer;
			    float: right;
			    background-color: white; 
			    color: #008CBA;
			    border: 2px solid #008CBA; 
			}
		</style>
		
	</head>
	<body>
		<div>
			<form method="post" action="">
				<button type='submit' name="Logout"  onclick="resetValues()">Logout</button>
			</form>
		    <p>
		        Your task is to come up with many ideas as you can to address the problem below. Be as specific as possible in your responses.
		    </p>

		    <p style="font-size:12px;">
		        P.S: if you have any issues with the system, try refreching the page : it will maintain your ideas and the timer in the same place as before.
		    </p>
		</div>
		<div>
			<h1>Challenge</h1>
			<p style="font-size:24px;">We are searching for innovative (technical) solution for the security of city building. In the first step think of possible dangerous events, wich might occur (e.g. fire). Then brainstorm innovative solutions, how people in the bulding could be protected from such a danger or rescued from the building.</p>

			<p id="clockdiv">
			Time left: <span class="minutes"></span>:<span class="seconds"></span>
        	</p>
		</div>

		<div class="left" >
			<h3>
			    Submit a new idea
			</h3>
		 	<div class="container" >
			    <p>
			        please describe your ideas as follows :
			    </p>
				<form method="post" action="insertion.php" id="myform">
					<input type="hidden" name="idm" value="<?php echo $idm; ?>">
				    <div class="row">
				     	<div class="col-25">
				    		<label for="fname">What is it about :</label>
				      	</div>
				    	<div class="col-75">
				        	<input type="text" name="what" id="what" required onkeyup='saveValue(this);'>
				      	</div>
				    </div>
				    <div class="row">
				      	<div class="col-25">
				        	<label for="lname">How it works :</label>
				      	</div>
				      	<div class="col-75">
				        	<input type="text" name="how" id="how" required onkeyup='saveValue(this);'>
				      	</div>
				    </div>
				    <div class="row">
				      	<div class="col-25">
				        	<label for="country">When it works :</label>
				      	</div>
				      	<div class="col-75">
				        	<input type="text" name="when" id="when" required onkeyup='saveValue(this);'>
				      	</div>
				    </div>
					</div>

					<input type="hidden" name="duration" id="duration" onkeyup='saveValue(this);'>

					<div class="row">
				    	<input type="reset" value="Reset">
				        <input type="submit" value="Submit" style="background-color: #008CBA; color: white; border: none; " onclick="getTime()">
				    </div>
				</form>
			<hr width="700px">
			<p>
				Your previous ideas
			</p>
			<p>
				<?php foreach($conn->query($sql) as $row) { ?>
    				<div class="idea">
    					<?php 
    					echo "{$row['what_about']}";
    					echo " ";
    					echo "{$row['how_it_works']}";
    					echo " ";
    					echo "{$row['when_it_works']}";
    					?>
    				</div>	
    			<?php } ?>
			</p>					
		</div>
		<div class="vl"></div>
		<div class="right">
    		<center>
    			<form>
        			<input type="submit" value="NEED INSPIRATION ?" style="background-color: white; color: #008CBA; border: 2px solid #008CBA; ">
    			</form>
    			<p style="margin-left : 20px;">
    				Click the button above and you will be presented with a set of others'ideas.
    			</p>
    			<p style="margin-left : 20px;">
    				Feel free to use them as inspiration: remix them with your own ideas, expand on them, or use them in any way you'd like!
    			</p>
    		</center>
      		<hr width="400px">
      		<form>
      		</form>

		</div>

<script type="text/javascript">

// timer 
var timeInMinutes = 10;
var currentTime = Date.parse(new Date());
var deadline;

if(localStorage.getItem("deadline") != 0) {
    deadline = new Date(localStorage.getItem("deadline"));
} else {
	deadline = new Date(currentTime + timeInMinutes*60*1000);
}

function getTimeRemaining(endtime){
    var t = Date.parse(endtime) - Date.parse(new Date());
    var seconds = Math.floor( (t/1000) % 60 );
    var minutes = Math.floor( (t/1000/60) % 60 );
    return {
        'total': t,
        'minutes': minutes,
        'seconds': seconds
    };
}

function initializeClock(id, endtime){
    var clock = document.getElementById(id);
    function updateClock(){
        var t = getTimeRemaining(endtime);
        var minutesSpan = clock.querySelector('.minutes');
        var secondsSpan = clock.querySelector('.seconds');
        minutesSpan.innerHTML = t.minutes;
        secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);
        if(t.total<=0){
            window.location.href="challenge.php";
            resetValues();
        }else{

			localStorage.setItem("deadline", deadline);
        }
    }
    updateClock(); 
    var timeinterval = setInterval(updateClock,1000);
}

initializeClock('clockdiv', deadline);

// to calculate duration between ideas and reset the form 
function getTime(){
    var t = Date.parse(deadline) - Date.parse(new Date());
    var t2 = 10*60*1000 - t ;
    var seconds = Math.floor( (t2/1000) % 60 );
    var minutes = Math.floor( (t2/1000/60) % 60 );

    if (minutes < 10) {
        minutes = "0" + minutes;
    }
    if (seconds < 10) {
        seconds = "0" + seconds;
    }    
    alert("you have spent : " + minutes + ":" + seconds);
    document.getElementById("duration").value = minutes + ":" + seconds ;
    //reset form after submission
    document.getElementById("myform").submit();
    resetValues();
}
 

// keeping inputs values after refresh 
     function saveValue(e){
        var id = e.id;  
        var val = e.value;  
        localStorage.setItem(id, val);  }

    function getSavedValue  (v){
        if (localStorage.getItem(v) == null) {
            return "";
        }
        return localStorage.getItem(v);
    }

    function resetValues(){

    	document.getElementById("what").value = "";  
	    document.getElementById("how").value = "";  
	    document.getElementById("when").value = "";

	    localStorage.setItem('what', '');
	    localStorage.setItem('how', '');
	    localStorage.setItem('when', '');
	    deadline = 0 ;
	    localStorage.setItem("deadline", deadline);


    }

    document.getElementById("what").value = getSavedValue("what");   
    document.getElementById("how").value = getSavedValue("how");  
    document.getElementById("when").value = getSavedValue("when");  

</script>
</script>
	</body>
</html>