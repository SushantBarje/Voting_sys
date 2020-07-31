$(document).ready(function(){
	processLogin();
});

function processLogin(){
	
		$('#admin-login').submit(function(){
		var data = {};
		$('#admin-login input').each(function(){
			data[$(this).attr('name')] = $(this).val();
		});

		console.log(data);
		$.ajax({
			url :'admin/process-login.php',
			type : 'post',
			data : data,
			dataType : 'json',
			success : function(res){
				console.log(res);
				switch(res.error){
					case 'empty':
						$('#alert .message').html('Please fill all Information');
						break;
					case 'Invalid':
						$('#alert').css('visibility','visible');
						$('.message').empty();
						$('.message').html('Invalid valid ID or Password');
						break;
					case 'none':
						window.location = "";
				}
			},
			erorr: function() {
				console.log('problem');
			}
		});
			return false;
		});
}