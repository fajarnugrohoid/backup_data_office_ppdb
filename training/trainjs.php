

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
</head>
<body>
	<form action="#" method="get" accept-charset="utf-8">
		<input type="text" name="" id="username" value="" placeholder="">
	</form>
</body>
</html>

<script type="text/javascript" charset="utf-8">
	function checkusername(e. minLength){
		var target = e.trget;
		console.log("target", target);
	}

	var el = document.getElementById('username');
	el.addEventListener('blur', function(e){
		checkusername(e,5);
	});
</script>