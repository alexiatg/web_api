$(document).ready(function(){
 setInterval(function(){
	 $.get('ajax_request.php', {},function(data) {
				$('#ajax-request').empty();
				$('#ajax-request').append(data);	
			}
		);
 }, 5000);
});