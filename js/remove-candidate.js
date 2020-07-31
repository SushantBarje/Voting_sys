$(document).ready(function(){
	processDelete();
});

function processDelete(){

	$('.target').on('click',function(){
		var id = $(this).attr('id');
		console.log(id)
		$('#confirm-btn').attr('data-control',id);
		var c = $('#confirm-btn').attr('data-control');
		console.log(c);
	});
	

	data = {};

	$('#confirm-id').on('click',function(){
		console.log('susahant');
	})

	$('.delete').on('click',function(){
		console.log('sushant')
		data[$(this).attr('name')] = $(this).attr('data-control');
		console.log(data);

		$.ajax({
			url : 'admin/remove-candidate.php',
			type : 'post',
			data : data,
			dataType : 'json',
			success : function(res){
				console.log(res.length);
				switch(res.error){	
					case 'server':
						$('#message').html('Server Error');
						break;
					case 'empty':
						$('#message').html('Data Field is Empty. Reload the Page');
						break;
					case 'SQL':
						$('message').html('Something went Wrong.');
						break;
					default:
						$('#message').empty();
						$('#message').html('Candidate Removed...');
						var trow = "";
						for(var i = 0;i < res.length;i++){
							trow = trow + "<tr><td>"+res[i].id+"<td>"+res[i].vot_id+"</td><td>"+res[i].name+"</td><td>"+res[i].p_name+"</td><td>"+res[i].position+"</td><td><button type='button' name="+'remove_c'+" class='remove-btn' id='"+res[i].id+"'>Remove</button></td></tr>"
						}

						$('#tbody').html(trow);
						break;
					case 'no_c':
						$('#tbody').html("<tr><td colspan='6'>No Candidate</td></tr>")
				}
			},
			error : function(){
				console.log('error Ajax');
			}
		});
		return false;
	})	
}