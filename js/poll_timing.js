$(document).ready(function(){

	timehandler();
});

function timehandler(){
	
  	$.ajax({
    	url: "admin/poll_time.php",
    	type : "get",
    	dataType : 'json',
    	success : function(res){
      		console.log("success");
      		console.log(res.start_date);
     		console.log(res.start_time);
     		console.log(res.end_date);
     		console.log(res.end_time);
	  		var countDownDate = new Date(res.start_date+" "+res.start_time).getTime();
	  		var x = setInterval(function() {

	   		var now = new Date().getTime();
	      
	    	var distance = countDownDate - now;
	      
	    	var days = Math.floor(distance / (1000 * 60 * 60 * 24));
	    	var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
	    	var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
	    	var seconds = Math.floor((distance % (1000 * 60)) / 1000);

	    	$('#demo').html(days + "d " + hours + "h "
	    	+ minutes + "m " + seconds + "s ");
	      
	    	if (distance < 0) {
	      		clearInterval(x);
	     		$('.result-btn').attr('disabled','disabled');
	     		$('#demo').html("Poll Started");
	     		status(1);
	    	}
	  		}, 1000);


  			var countDate = new Date(res.end_date+" "+res.end_time).getTime();
	  		var y = setInterval(function() {

	   		var now = new Date().getTime();
	      
	   	 	var distance = countDate - now;
	      
	    	var days = Math.floor(distance / (1000 * 60 * 60 * 24));
	    	var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
	    	var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
	   		var seconds = Math.floor((distance % (1000 * 60)) / 1000);

	     	$('#demo2').html(days + "d " + hours + "h "
	    	+ minutes + "m " + seconds + "s ");
	      
	    	if (distance < 0) {
	      		clearInterval(y);
	     		$('.result-btn').removeAttr('disabled');
	     		$('#demo2').html("EXPIRED");
	     		status(2);
    		}	
	  		}, 1000);
		}
	});
  return false;
}

function status(a){
	$.ajax({
		url:'admin/controller.php',
		type : 'post',
		data : {data : a},
		dataType : 'json',
		success : function(res){
			console.log("success");
			console.log(res.status);
			var flag = res.status;
			if(flag == 1){
				var trow = "Active";
			}
			if(flag == 2){
				var trow = "Poll Expired";
				$('#vote-meter').html('Poll is Expired');
			}
			$("#status").html(trow);
		}
	});

	return false;
}

