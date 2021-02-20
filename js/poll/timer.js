//This are the GLOBAL Variables

var startdate;
var enddate;
var starttime;
var endtime;
var s;
var i;
var x;
var id;

$(document).ready(function(){

	id = $('#myTable #pollid').html();
	console.log(id);
	
	if(!id){
		$.ajax({
			url : 'admin/poll/stand_poll.php',
			type : 'post',
			dataType : 'json',
			success : function(res){
				console.log(res.id);
				id = res.id;
				check_poll(id);
			}
		});
	}else{
		check_poll(id);
	}
});


//method for check if there in poll when the page loads.
//This method will set all the Global variables.
function check_poll(id){

	$.ajax({
		url : 'admin/poll/checkPoll.php',
		type : 'post',
		data : {id : id},
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

//This will kept poll in standby status.
//This accept two variables 1st = id.
//2nd = the mode;
/*
	1)when the page load.
	if set == 1 it means the function call is from server so set my global variable.
	else
*/ 
function standby(val,set){

	if(set == 1){
		console.log("set1");	
		$.when(
			$.ajax({
				url : "admin/poll/standby.php",
				type : "post",
				data : {data : val},
				dataType : "json",
				success : function(res){
					console.log("sushant");
					console.log(res.start_date);
					startdate = res.start_date;
					enddate = res.end_date;
					starttime = res.start_time;
					endtime = res.end_time;
					i = res.id;
					s = res.status;
					$('#poll-queue').append('<tr><th>Poll ID:</th><td id="pollid">'+res.id+'</td></tr><tr><th>Poll Type:</th><td id="ptype">'+res.type+'</td></tr><tr><th>Start Date:</th><td id="sdate">'+res.start_date+'</td></tr><tr><th>Start Time:</th><td id="stime">'+res.start_time+'</td></tr><tr><th>End Date:</th><td id="edate">'+res.end_date+'</td></tr><tr><th>End Time:</th><td id="endtime">'+res.end_time+'</td></tr><tr><th>Status</th><td id="status">'+s+'</td></tr><tr><th>Action</th><td id="action"><button type="button" class="btn-remove btn btn-danger btn-sm" id="'+res.id+'">Remove</button><button type="button" class="btn-edit btn btn-success btn-sm" id="'+res.id+'">Edit</button></td></tr><tr><th>Result</th><td id="result">--</td></tr><tr id="timestatus"></tr>');
				},
				error : function(){
					console.log("Ajax Error");
				}
			})).then(timer);
		
	}else{
		timer();
	}
	function timer(){
		$('#status').html('Stand By');
		var countDownDate = new Date(startdate+" "+starttime).getTime();
		x = setInterval(function() {
	
			var now = new Date().getTime();
	  
			var distance = countDownDate - now;
	  
			var days = Math.floor(distance / (1000 * 60 * 60 * 24));
			var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			var seconds = Math.floor((distance % (1000 * 60)) / 1000);
	
			$('#timestatus').html("<td>Time Remaining: "+days + "d " + hours + "h "
			+ minutes + "m " + seconds + "s </td>");
			$('#vote-table').html("<td colspan='4'>Poll Starts in : "+days + "d " + hours + "h "
			+ minutes + "m " + seconds + "s </td>");

			if (distance < 0) {
				clearInterval(x);
				$('#timestatus td').html(' ');
				$('.result-btn').attr('disabled','disabled');
				$('#demo').html("");
				$('#status').html("Active");
				$('.btn-edit').remove();
				start(val,1);
				listcan();
			}	
		}, 1000);
	}
	
	console.log('standby');
	return false;
}

function start(val,set){

	console.log(val);
	if(set == 1){
		console.log("Set2");
		$.when(
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
			})
		).then(timer);
	}else{
		timer();
	}
	
	function timer(){
		var countDownDate = new Date(enddate+" "+endtime).getTime();
		x = setInterval(function() {
	
			var now = new Date().getTime();
	  
			var distance = countDownDate - now;
	  
			var days = Math.floor(distance / (1000 * 60 * 60 * 24));
			var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			var seconds = Math.floor((distance % (1000 * 60)) / 1000);
	
			$('#timestatus').html("<td>"+days + "d " + hours + "h "
			+ minutes + "m " + seconds + "s </td>");
			$('#vote-table').html("<td colspan='4'>Poll End in : "+days + "d " + hours + "h "
			+ minutes + "m " + seconds + "s </td>");
	  
			if (distance < 0) {
				clearInterval(x);
				$('#timestatus td').html(' ');
				 $('.result-btn').attr('disabled','disabled');
				 $('#demo').html("");
				 $('#status').html("Poll Expired");
				 $('#result').html('<button type="button" id="'+i+'" class="result-btn btn btn-success btn-sm">Result</button>')
				 stop(val,1);
			}
		}, 1000);
	}
	console.log('start');
	return false;
}



function stop(val,set){

	console.log('stop');

	if(set == 1){
		console.log("Set2");
		$.when(
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
			})
		).then(timer);
	}else{
		timer();
	}
	function timer(){
		var countDownDate = new Date(new Date(enddate+" "+endtime).getTime()+(1*60*1000));
		x = setInterval(function(){
			var now = new Date().getTime();
			var distance = countDownDate - now;
			var days = Math.floor(distance / (1000 * 60 * 60 * 24));
			var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			var seconds = Math.floor((distance % (1000 * 60)) / 1000);
	
			$('#timestatus').html("<td>"+days + "d " + hours + "h "
			+ minutes + "m " + seconds + "s </td>");
			$('#vote-table').html('');
			if (distance < 0) {
				clearInterval(x);
				$('#timestatus td').html(' ');
				$('.result-btn').attr('disabled','disabled');
				$('#demo').html("");
				$('#status').html("Poll Expired");
				autoDelete(i,1);
			}
		}, 1000);
	}
	

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
			$('#timestatus td').html(' ');
			$('#poll-queue').remove();
			$('#myTable').append('<tbody id="poll-queue"><tr><td>No Poll</td></tr></tbody>')
		},
		error : function(){
			console.log('Ajax Error');
		}

	});
}