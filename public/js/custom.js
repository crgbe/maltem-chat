$(document).ready(function(){

	$('#message-box').on('keypress', function(e){
		if(e.which == 13){
			$.ajax({
				url: '/chat/newMessage',
				data: {
					'form': {
						'message': $('#message-box').val(),
					},
				},
				method: 'POST',
				success: function(){
					refreshMessages();
				},
			});

			$('#message-box').val('');
			e.preventDefault();
		}
	});

	function refreshMessages(){
		$.ajax({
			url: '/chat/getMessagesViaAjax',
			success: function(response){
				$('#ajax-messages').html(response);
			},
		});
	}

	setInterval(function(){
		refreshMessages();
	}, 5000);
});