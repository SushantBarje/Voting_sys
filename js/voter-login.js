$(document).ready(function(){
	processLogin();
	processSignUp();
});


function processLogin(){

	$('#voter-login').submit(function(){
		data = {};
		$('#voter-login input').each(function(k,v){
			data[$(v).attr('name')] = $(v).val();
		});
		
		console.log(data);
		$.ajax({
			url : 'voter/login-process.php',
			type : 'post',
			data : data,
			dataType : 'json',
			success : function(res){
				console.log(res);
				switch(res.error){
						case 'empty':
							$('.message').html('Please fill all Information');
							break;
						case 'Invalid':
							$('.message').empty();
							$('.message').html('Invalid valid email or Password');
							break;
						case 'none':
							window.location = "";
				}
			}
		});
		return false;
	});

}

function processSignUp(){
	$('#signup').submit(function(){
		data = {};
		$('#signup input').each(function(k,v){
		if(!$(v).val().length) {
        	return false;
  		}			
      		data[$(v).attr('name')] = $(v).val();
		});
		console.log(data); 
		$.ajax({
			url : 'voter/signup-process.php',
			type : 'post',
			data : data,
			dataType : 'json',
			success : function(res){
				switch(res.error){
					case 'empty':
						$('.message').html('Please fill all details');
						break;
					case 'server':
						$('.message').html('Problem with Server');
						break;
					case 'SQL':
						$('.message').html('Problem while submitting details. Please check while filling');
						break;
					case 'already':
						$('.message').html('Voter ID already exists');
						break;
					case 'incorrect':
						$('.message').html('Incorrect');
						break;
					case 'none':
						$('.message').html('Registration Success. Please Log In');
						break;
				}
			}
		});
		return false;
	});
}