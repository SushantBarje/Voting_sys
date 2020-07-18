$(document).ready(function(){
	processDelete();
});

function processDelete(){

	$(document).on('click',".btn-remove",function(k,v){

		if(confirm("Are You Sure to Delete Poll?")){
			var data = $(this).attr('id');
			console.log(data);
		
			$.ajax({
				url : "admin/poll/deletePoll.php",
				type : 'get',
				data : {data : data},
				dataType : 'json',
				success : function(res){
					console.log(res);
					if(res.error == 'none'){
						$('#poll-queue').html('<tr><td colspan="9">NO POLL</td></tr>');
						clearInterval(x);
					}
				},
				error : function(){
					console.log('ajax error');
				}
			});
		return false;
		}	
	});
}