$(document).ready(function(){
    listcan();
});


function listcan(){
    $.ajax({
        url: 'voter/voter_home.php',
        type : 'post',
        dataType : 'json',
        success : function(res){
            console.log(res);
            console.log(res.candidate.length());
            var trow = "";
        },
        error : function(){
            console.log('AJAX error');
        }
    })
}