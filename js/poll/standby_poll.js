$(document).ready(function(){
	processPoll();
});

function processPoll(){

	$('#form-poll').on('submit',function(){
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
			'candidate' : arr,
		};
		 
 		console.log(data);
 		$.ajax({
 			url : 'admin/poll/poll_process.php',
 			type : 'post',
 			data : data,
 			dataType : 'json',
 			success : function(res){
 				console.log(res.error);
 				switch(res.error){
 					case 'server':
 						$('#message').html('Server Error. Please Try Again.');
 						break;
 					case 'empty':
 						$('#message').html('Please Fill All Fields.');
 						break;
					case 'current':
						$('#message').html('Please Start Date is Expired.');
						break;
					case 'current_time':
						$('#message').html('Start Time is Expired.');
						break;
					case 'date':
						$('#message').html('Choose Correct Start Date and End Date.');
						break;
					case 'same':
						$('#message').html('Choose Correct Start And End Time.');
						break;
					case 'already':
						$('#message').html('Only One Poll is Allowed to Queue.');
						break;
					case 'not_insert':
						$('#message').html('Something Went Wrong. Please Check The Fields Entered.');
						break;
					case 'none':
						$('#message').html('Poll is been Successfully Queued.');
						$("#poll-queue tr:has(td)").remove();
						if(res.status == 0){
							var s = "Standby";
						}
						else if(res.status == 1){
							var s = "Active";
						}
						else{
							var s = "Poll Expired";
						}			
						standby(res.id,1);
						break;
 				}
 			},
 			error : function(){
 				console.log('Ajax Error');
 			}
 		});
 		return false;
	});
}