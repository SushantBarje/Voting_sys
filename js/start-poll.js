
$(document).ready(function(){

	processPoll();
	
});

function processPoll(){

	$("#form-poll").submit(function(e){

		var arr = [];
			$('#form-poll input[type=checkbox]').each(function(){
		
 			if($(this).is(':checked')){
 				arr.push($(this).val());
 			}
 		});

		console.log(arr);
		data = {
			'poll_type' : $('#poll-type').val(),
			'start' : $('#start-date').val(),
			'stime' : $('#start-time').val(),
			'end' : $('#end-date').val(),
			'etime' : $('#end-time').val(),
			'candidate[]' : arr,
 		};
		
		console.log(data);

		$.ajax({
			url : 'admin/start-poll-process.php',
			type : 'post',
			data : data,
			dataType : 'json',
			success :  function(res){
				console.log(res);
				console.log(res.error);	
				switch(res.error){
					case 'server':
						$('#message').html("SERVER ERROR");
						break;
					case 'empty':
						$("#message").html('Field is empty');
						break;
					case 'SQL':
						$('#message').html('SERVER ERROR: SQL');
						break;
					case 'max':
						$('#message').html('Maximum Poll Allowed is only 1');
						break;
					case 'none':
						$("#poll-queue tr:has(td)").remove();
						$('#poll-queue').append("<tr><td>"+res.id+"<td>"+res.poll_type+"</td><td>NOt SELECTED</td><td>"+res.start_date+"</td><td>"+res.start_time+"</td><td>"+res.end_date+"</td><td>"+res.end_time+"</td><td id='stauts'>"+res.status+"</td><td><a href='poll_result"+res.id+"'><button type='button' id="+res.id+" class="+'result-btn'+"Result</button></a></td><td><button type='button' name="+'remove_c'+" class='remove-btn' id='"+res.id+"'>Remove</button></td></tr>");					
						window.location="";
						break;
				}
			},
			error : function(){
				console.log('AJAX error');
			}
		});
		return false;
	});
}

