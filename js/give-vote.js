$(document).ready(function(){
	onLoad();
	processVote();
});


function onLoad(){

	$.ajax({
		url : 'voter/vote.php',
		type : 'get',
		dataType : 'json',
		success : function(res){
			console.log(res[2].error);
			console.log(res.length);
			var trow = "";
			for(var i = 0; i < res.length - 1; i++){
				trow = trow + '<tr><td>'+res[i].id+'</td><td>'+res[i].party+'</td><td>'+res[i].name+'</td><td><input type="radio" name ="check" value="'+res[i].id+'"></td><tr>';
			}

			$('#table-body').html(trow);
			$('#table-body').append('<tr><td colspan="3">None Of the Above</td><td><input type="radio" name ="check" value="0"></td></tr>');
			if(res[i].error == 'none'){
				$('input').attr('disabled','disabled');
				$('button').attr('disabled','disabled');
				$('#message').html('You have Given the Vote. Thankyou')
			}
		},
		error : function(){
			console.log('ajax error');
		}
	});
	return false;
}


function processVote(){

	$('#vote-form').submit(function(){
		console.log('come');
		data = {};
		$('#vote-form input').each(function(){
			if($(this).is(':checked')){
				data[$(this).attr('name')] = $(this).val();
			}
		});
		console.log(data);

		$.ajax({
			url : 'voter/mark-vote.php',
			type : 'post',
			data : data,
			dataType :'json',
			success : function(res){
				console.log('success');
				console.log(res);

			}
		});

		return false;
	});
}