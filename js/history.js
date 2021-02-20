$(document).ready(function(){
    processHistory();
});


function processHistory(){
    $.ajax({
        url : "admin/history.php",
        type: "get",
        dataType : "json",
        success : function(res){
            console.log(res);
            var trow = "";
            for(var i = 0; i < res.length; i++){
                trow = trow + '<tr><td>'+res[i].poll_id+'</td><td>'+res[i].poll_type+'</td><td><button class="btn btn-primary btn-sm candidate" id="can_'+res[i].poll_id+'">See Candidates</button></td><td>'+res[i].start_date+'</td><td>'+res[i].end_date+'</td><td><button class="btn btn-success btn-sm more" id="det_'+res[i].poll_id+'">See More</button></td></tr>';
            }
            $('tbody').html(trow);
        } 
    });
}