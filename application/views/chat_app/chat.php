<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="row">
	<div class="col-md-12">
		<div class="x_panel">
			<div class="x_content">
				<div class="col-md-3 col-sm-12 col-xs-12">
					<div>
						<div class="x_title">
							<h2>List Contact</h2>
							<div class="clearfix"></div>
						</div>
						<ul id="listUser" class="list-unstyled top_profiles scroll-view" style="overflow-y: scroll;">
							<?php foreach($users as $user): ?>
							<li class="media event" style="cursor: pointer;" onclick="doChat(<?php echo $user['id_user_app'].",'".$user['nama']."'"; ?>)">
								<a class="pull-left border-green profile_thumb">
									<i class="fa fa-user green"></i>
								</a>
								<div class="media-body">
									<p><a class="title"><?php echo $user['nama']; ?></a> <?php echo "[ ".$user['tipe']." ]"; ?></p>
									<p><?php echo $user['pesan']; ?><br />
									<small><?php echo $user['waktu']; ?></small></p>
								</div>
							</li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
				<div class="col-md-9 col-sm-12 col-xs-12">
					<div>
						<div class="x_title">
							<h2>Chat <span id="namaStranger"></span></h2>
							<div class="clearfix"></div>
						</div>
						<ul id="bagianChat" class="list-unstyled top_profiles" style="overflow-y: scroll;">
						</ul>
						<div class="x_content">
	                        <div class="input-group">
							    <textarea id="pesanChat" class="form-control custom-control" placeholder="Type Here..." rows="3" style="resize:none"></textarea>     
							    <span class="input-group-addon btn btn-primary" onclick="sendMessage()"><i style="margin-right: 10px; margin-left: 10px;" class="fa fa-paper-plane"></i></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var strangerID = null;
	var chatInterval = 5000;

	function searchUser(){
		var keyword = $('#searchUser').val();
		$.ajax({
			url: '<?php echo base_url('chat/search_user/?keyword='); ?>'+keyword,
			type: 'GET',
			dataType: 'html',
			success: function (data) {
				$('#listUser').empty();
				$('#listUser').append(data);
			}
        });
	}

	function doChat(id, nama){
		strangerID = id;
		$.ajax({
			url: '<?php echo base_url('chat_app/get_chats/?user='); ?>'+strangerID,
			type: 'GET',
			dataType: 'html',
			success: function (data) {
				$('#namaStranger').empty();
				$('#namaStranger').append(nama);
				$('#bagianChat').empty();
				$('#bagianChat').append(data);
			}
        });
	}

	function retrieveMessages() {
		if(strangerID != null){
	        $.get("<?php echo base_url('chat_app/get_chat/?user='); ?>"+strangerID, function (data) {
	        	if(data != ''){
		            $('#bagianChat').append(data);
		            $("#bagianChat").scrollTop($("#bagianChat").height() + 10000);
	        	}
	        });
		}
    }

	function sendMessage(){
		var dateNow = new Date();
		var pesan = $('#pesanChat').val();

		if(pesan != ''){
			$.post("<?php echo base_url('chat_app/send_message/?user='); ?>"+strangerID,
				{
		          pesan: pesan,
		        },
		        function () {
					var html = '<li class="pull-right" style="margin-top: 5px; margin-right: 5px; width: 80%; background-color: #D9EDF7;">';
					html += '<span class="pull-left">';
					html += '<span><i class="fa fa-clock-o"></i></span>';
					html += '<span class="time"> '+dateNow.toLocaleString()+'</span>';
					html += '</span>';
					html += '<span class="pull-right">';
					html += '<span class="profile_thumb">';
					html += '<i class="fa fa-user blue"></i>';
					html += '</span>';
					html += '<span> You</span>';
					html += '</span><br />';
					html += '<span class="message">'+pesan+'</span>';
					html += '</li>';

					$('#bagianChat').append(html);
					$('#pesanChat').val('');
					$("#bagianChat").scrollTop($("#bagianChat").height() + 10000);
		        });
		}
	}

	$(document).ready(function () {
		$('#pesanChat').on('keydown', function(e) {
			if (e.which == 13) {
				sendMessage();
			}
		});

		setInterval(function () {
	        retrieveMessages();
	    }, chatInterval);
	});
</script>