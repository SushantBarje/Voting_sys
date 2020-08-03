
var startdate;
var enddate;
var starttime;
var endtime;
var s;
var i;
var x;

$(document).ready(function(){

	check_poll();

});

function check_poll(){

	$.ajax({
		url : 'admin/poll/checkPoll.php',
		type : 'post',
		dataType : 'json',
		success : function(res){
			console.log(res.error);

			startdate = res.start_date;
			enddate = res.end_date;
			starttime = res.start_time;
			endtime = res.end_time;
			i = res.id;
			s = res.status;
			switch(res.error){
				case 'exists':
					$('#message').html('');
					break;

				case 'connect':
					$('#message').html('Connection ERROR');
					break;

				case 'none':
					console.log("sssss"+res.status);
					if(s == 0){
						console.log('0');
						standby(i,0);
					}else if(s == 1){
						console.log('1');
						start(i,0);
					}else if(s == 2){
						stop(i,0);
					}else{
						autoDelete(i,0);
					}
			}
			
		},
		error : function(){
			console.log('Ajax Error');
		}
	})
}

function standby(val,set){

	if(set == 1){
		console.log("set1");
		$.ajax({
			url : "admin/poll/standby.php",
			type : "post",
			data : {data : val},
			dataType : "json",
			success : function(res){
				console.log(res.error);
				startdate = res.start_date;
				enddate = res.end_date;
				starttime = res.start_time;
				endtime = res.end_time;
				i = res.id;
				s = res.status;
			},
			error : function(){
				console.log("Ajax Error");
			}
		});
	}

	$('#status').html('Stand By');
	var countDownDate = new Date(startdate+" "+starttime).getTime();
	x = setInterval(function() {

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
 			$('#demo').html("");
 			$('#status').html("Active");
 			start(val,1);
		}	
	}, 1000);
	console.log('standby');
	return false;
}

function start(val,set){

	console.log(val);
	if(set == 1){
		console.log("Set2");
		$.ajax({
			url : "admin/poll/start.php",
			data : {data : val},
			type : "post",
			dataType : "json",
			success : function(res){
				console.log(res.error);
				enddate = res.end_date;
				endtime = res.end_time;
				i = res.id;
				s = res.status;
			},
			error : function(res){
				console.log("Ajax error");
			}
		});
	}
	
	var countDownDate = new Date(enddate+" "+endtime).getTime();
	x = setInterval(function() {

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
 			$('#demo').html("");
 			$('#status').html("Poll Expired");
 			stop(val,1);
		}
	}, 1000);

	
	console.log('start');

	return false;
}



function stop(val,set){

	console.log('stop');

	if(set == 1){
		console.log("Set2");
		$.ajax({
			url : "admin/poll/stop.php",
			data : {data : val},
			type : "post",
			dataType : "json",
			success : function(res){
				enddate = res.end_date;
				endtime = res.end_time;
				i = res.id;
				s = res.status;
				$('#status').html('Poll Expired');
			},
			error : function(res){
				console.log("Ajax error");
			}
		});
	}

	var countDownDate = new Date(new Date(enddate+" "+endtime).getTime()+(60*60*1000));
	
	x = setInterval(function(){

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
 			$('#demo').html("");
 			$('#status').html("Poll Expired");
 			autoDelete(i,1);
		}
	}, 1000);

	return false;
}

function autoDelete(val,set){
	console.log(val);
	$.ajax({

		url : "admin/poll/autoDelete.php",
		type : "post",
		data : {data : val},
		dataType : 'json',
		success : function(res){
			console.log(res.error);
		},

		error : function(){
			console.log('Ajax Error');
		}

	});

	console.log("autodelete");
}