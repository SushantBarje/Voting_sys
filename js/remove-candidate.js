$(document).ready(function(){
	processDelete();
});

function processDelete(){

	data = {};

	$('#candidate_table').on('click','.remove-btn',function(){

		data[$(this).attr('name')] = $(this).attr('id');
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