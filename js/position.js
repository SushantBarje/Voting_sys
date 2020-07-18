$(document).ready(function(){
	processPosition();
});

function processPosition(){

	$('#pos-form').submit(function(){
		data = {};

		if($('#manage_pos').val().length > 0){
			$('#pos-msg').empty();
			data[$('#manage_pos').attr('name')] = $('#manage_pos').val();
		
		}else{
			$('#pos-msg').html('Empty field');
			return false;
		}

		$.ajax({
			url:'admin/position.php',
			type : 'post',
			data : data,
			dataType : 'json',
			success : function(res){
				switch(res.error){
					case 'SQL':
						$('#pos-msg').html('Fail to Process. Please fill Correct Details');
						break;
					case 'empty':
						$('#pos-msg').html('Field Is Empty');
						break;
					case 'server':
						$('#pos-msg').html('Server Error');
						break;
					case 'already':
						$('#pos-msg').html('Position already exists');
						break;
					case 'none':
						$('#pos-msg').html('Position Added');
						$('#manage_pos').attr('type','button');
						$('#manage_pos').attr('value','Manage Position');
						$('#add-btn').attr('hidden','hidden');
						$('#manage_pos').removeAttr('required');
						$('#manage_pos').removeAttr('name');
						$('#position_select').append("<option value='"+ res.dat +"''>"+ res.dat +"</option>");
						break;
				}
			},
			error : function(){
				console.log('ajax err');
			}
		});
		return false;
	});
}