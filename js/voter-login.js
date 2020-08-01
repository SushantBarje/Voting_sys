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
							$('#alert').css('visibility','visible');
							$('.message').html('Please fill all Information');
							
							break;
						case 'Invalid':
							$('#alert').css('visibility','visible');
							$('.message').empty();
							$('.message').html('Invalid valid Voter ID or Password');
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
      		data[$(v).attr('name')] = $(v).val();
		});
		console.log(data); 
		$.ajax({
			url : 'voter/signup-process.php',
			type : 'post',
			data : data,
			dataType : 'json',
			success : function(res){
				console.log(res.error)
				switch(res.error){
					case 'empty':
						$('#alert').css('visibility','visible');
						$('#alert').removeAttr('class');
						$('#alert').addClass('alert alert-danger');
						$('.message').html('Please fill all details');
						break;
					case 'server':
						$('.message').html('Problem with Server');
						('#alert').removeAttr('class');
						$('#alert').addClass('alert alert-danger');
						$('#alert').css('visibility','visible');
						break;
					case 'SQL':
						$('.message').html('Problem while submitting details. Please check while filling');
						$('#alert').removeAttr('class');
						$('#alert').addClass('alert alert-danger');
						$('#alert').css('visibility','visible');
						break;
					case 'already':
						$('.message').html('Voter ID already exists');
						$('#alert').removeAttr('class');
						$('#alert').addClass('alert alert-danger');
						$('#alert').css('visibility','visible');
						break;
					case 'incorrect':
						$('.message').html('Incorrect');
						$('#alert').removeAttr('class');
						$('#alert').addClass('alert alert-danger');
						$('#alert').css('visibility','visible');
						break;
					case 'none':
						$('.message').html('Registration Success. Please Log In');
						$('#alert').css('visibility','visible');
						$('#alert').removeAttr('class');
						$('#alert').addClass('alert alert-success')
						break;
				}
			}
		});
		return false;
	});
}