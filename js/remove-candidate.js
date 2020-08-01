$(document).ready(function(){
	processDelete();
});

function processDelete(){

	var id;
	$('#candidate_table').on('click','#target',function(){
		id = $(this).attr('data-control');
		console.log(id);
	});
	
	data = {};

	$('#confirm-btn').on('click',function(){
		data[$(this).attr('name')] = id;
		console.log(data);
		$('.modal').modal("hide")
		$.ajax({
			url : 'admin/remove-candidate.php',
			type : 'post',
			data : data,
			dataType : 'json',
			success : function(res){
				console.log(res.length) 	
				switch(res.error){	
					case 'server':
						$('#alert2').css('visibility','visible');
						$('#alert2').removeAttr('class');
						$('#alert2').addClass('alert alert-danger');
						$('.message2').html("SERVER ERROR");
						break;
					case 'empty':
						$('#alert2').css('visibility','visible');
						$('#alert2').removeAttr('class');
						$('#alert2').addClass('alert alert-danger');
						$(".message2").html('Field is empty');
						break;
					case 'SQL':
						$('#alert2').css('visibility','visible');
						$('#alert2').removeAttr('class');
						$('#alert2').addClass('alert alert-danger');
						$('.message2').html('SERVER ERROR: SQL');
						break;
					default:
						$('#alert2').removeAttr('class');
						$('#alert2').addClass('alert alert-success');
						$('#alert2').css('visibility','visible');
						$('.message2').empty();
						$('.message2').html('Candidate Removed...');
						var trow = "";
						
						for(var i = 0;i < res.length;i++){
							trow = trow + "<tr><td>"+res[i].candidate_id+"<td>"+res[i].vote_id+"</td><td>"+res[i].candidate_name+"</td><td>"+res[i].party_name+"</td><td>"+res[i].position+"</td><td><button type='button' data-control='"+res[i].candidate_id+"' name="+'remove_c'+"  id='target' class='btn btn-danger' data-toggle='modal' data-target='#exampleModalCenter'>Remove</button></td></tr>"
						}

						$('#tbody').html(trow);
						break;
					case 'no_c':
						$('#alert2').removeAttr('class');
						$('#alert2').addClass('alert alert-success');
						$('#alert2').css('visibility','visible');
						$('.message2').empty();
						$('.message2').html('Candidate Removed...');
						$('#tbody').html("<tr id='no'><td colspan='6'>No Candidate</td></tr>")
				}
			},
			error : function(){
				console.log('error Ajax');
			}
		});
		return false;
	})	
}