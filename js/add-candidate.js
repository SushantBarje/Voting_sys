$(document).ready(function(){
	processAdd();
	
});

function processAdd(){

	$('#add-cd').submit(function(){

		data = {};
		$('#add-cd input').each(function(){
			data[$(this).attr('name')] = $(this).val();
		});
		
		data[$('#add-cd select').attr('name')] = $('#add-cd select').val();
	
		$.ajax({
			url: 'admin/candidates/addCandidate.php',
			type: 'post',
			data: data,
			dataType: 'json',
			cache: false,
			success: function(res){
				switch(res.error){
					case 'server':
						$('#alert').css('visibility','visible');
						$('#alert').removeAttr('class');
						$('#alert').addClass('alert alert-danger');
						$('.message').html("SERVER ERROR");
						break;
					case 'already':
						$('#alert').css('visibility','visible');
						$('#alert').removeAttr('class');
						$('#alert').addClass('alert alert-danger');
						$('.message').html('The Candidate is already Added');
						break;
					case 'empty':
						$('#alert').css('visibility','visible');
						$('#alert').removeAttr('class');
						$('#alert').addClass('alert alert-danger');
						$(".message").html('Field is empty');
						break;
					case 'SQL':
						$('#alert').css('visibility','visible');
						$('#alert').removeAttr('class');
						$('#alert').addClass('alert alert-danger');
						$('.message').html('SERVER ERROR: SQL');
						break;
					case 'insert':
						$('#alert').css('visibility','visible');
						$('#alert').removeAttr('class');
						$('#alert').addClass('alert alert-danger');
						$('.message').html('Data is Not Processed.Try Again');
						break;
					case 'none':
						$('#alert').css('visibility','visible');
						$('#alert').removeAttr('class');
						$('#alert').addClass('alert alert-success');
						$('.message').html('Candidate Registration Success...');
						$('#no').remove();
						var trow = "<tr><td>"+res.id+"<td>"+res.vote_id+"</td><td>"+res.name+"</td><td>"+res.p_name+"</td><td>"+res.position+"</td><td><button type='button' data-control='"+res.id+"' name="+'remove_c'+"  id='target' class='btn btn-danger' data-toggle='modal' data-target='#exampleModalCenter'>Remove</button></td></tr>";
						$('#tbody').append(trow);
						$('#candidate_id').html('Candidate ID :'+res.id);
						break;
				}
			},
			error: function(){
				console.log('ajax error');
			}
		});
		return false;
	});
}


