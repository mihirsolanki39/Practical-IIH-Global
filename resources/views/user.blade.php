<!DOCTYPE html>
<html lang="en">

<head>
	<title> Users </title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
	<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
	<meta name="csrf-token" content="{{ csrf_token() }}" />

	<style type="text/css">
		#showUsers{
			width: 50%;
			margin: 0 auto;
			background: #000000;
			color: #ffffff;
			padding: 25px;
			margin-bottom: 25px;
		}
	</style>

</head>

<body>

	<div class="container">
		
		<h2> User Form </h2>
		
		<form method="POST" class="userForm" id="userForm">
			
			<div class="form-group">
				<label for="name"> Name :</label>
				<input type="name" class="form-control" id="name" placeholder="Enter name" name="name">
			</div>
			
			<div class="form-group">
				<label for="email"> Email :</label>
				<input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
			</div>

			<div class="form-group">
				<label for="email"> Officer :</label>
				<select name="officer" id="officer" class="form-control">
					<option value=""> Select Officer </option>
				</select>

			</div>
			
			<div class="form-group">
				<label for="pwd"> Date of birth :</label>
				<input type="date" class="form-control" id="dateOfBirth" name="dateOfBirth" placeholder="Enter date of birth">
			</div>
			
			<div class="form-group form-check">
				
				<label class="form-check-label">	
					<input class="form-check-input" type="checkbox" value="php" name="skills[]"> PHP 
				</label>

				<label class="form-check-label">
					<input class="form-check-input" type="checkbox" value="jQuery" name="skills[]"> jQuery 
				</label>

				<label class="form-check-label">
					<input class="form-check-input" type="checkbox" value="JavaScript" name="skills[]"> JavaScript 
				</label>

			</div>
			
			<button type="submit" class="btn btn-primary btn-submit">Submit</button>
		</form>
	</div>

	<div id="showUsers">
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


	<script type="text/javascript">

		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});

	    $(".btn-submit").click(function(e){
	        e.preventDefault();
			var form = $('#userForm').serialize();
			var url = '{{ url('store') }}';

	        $.ajax({
				url:url,
				method:'POST',
				data: form,
				dataType : 'json', 
	           	success:function(response) {
	              	if(response.statusCode == 200) {
						$('#userForm')[0].reset();
						getAllUsers();
						$('#showUsers').html('');
						getChild(0,'showUsers');
						// alert(response.message) //Message come from controller
	              	}else{
						alert("Error");
	              	}
	           	},
	           	error:function(error){
					console.log(error)
	           	}
	        });
		});

		// Fetch all records
		// AJAX GET request
		
		getAllUsers();
		// setTimeout(function() {
		function getAllUsers() {
			var len = 0;
			tr_str = '';
			$.ajax({
				url: '{{ url('users') }}',
				type: 'get',
				dataType: 'json',
				success : function(list) { 
					var showUsers = '<option value="-1">Please Select Users</option>';
	                $.each(list, function (i) {
						showUsers += '<option value="' + list[i].id + '">' + list[i].name + '</option>';  
	                    // $("#officer").html("<option value='"+ list[i].id +"'>" + list[i].name + "</option>");
	                });
					$("#officer").html(showUsers);
	            }//Fermeture Success
	        });
		}

		function getChild(id,divId) {
			$.ajax({
				url: '{{ url('childUsers') }}/'+id,
				type: 'get',
				dataType: 'json',
				success : function(list) { 
	                $.each(list, function (i) {
	                	$.ajax({
							url: '{{ url('childUsersCount') }}/'+id,
							type: 'get',
							dataType: 'json',
							success : function(listCount) { 
								console.log(listCount);
			                	if (listCount == 0) {
			                		$('#'+divId).append('<p>'+ list[i].name +'</p>');
			                		return 0;
			                	} else{
			                		$('#'+divId).append('<p>'+ list[i].name +'</p>');
									$('#'+divId).append('<div id="showUsers'+list[i].id+'" style="margin-left:25px;"></div>');
									getChild(list[i].id,'showUsers'+list[i].id);
									return 0;
								}
							}//Fermeture Success
				        });

	                });
	            }//Fermeture Success
	        });
		}


		// getChildCount();
		// console.log(getChild('0','showUsers'));
		// console.log(getChildCount('0'));

		$(document).ready(function(e) {
			getChild('0','showUsers');
		});
	</script>


</body>
</html>
