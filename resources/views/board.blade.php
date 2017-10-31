<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
	<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css" href="style.css">

	<title>Laravel Connect Four</title>
</head>

<body class="text-center container">

	<h1 class="mt-5">Laravel Connect Four</h1>

	<div class="row justify-content-center mt-5">
			<div class="drop"><button class="btn btn-light">Drop!</button></div>
			<div class="drop"><button class="btn btn-light">Drop!</button></div>
			<div class="drop"><button class="btn btn-light">Drop!</button></div>
			<div class="drop"><button class="btn btn-light">Drop!</button></div>
			<div class="drop"><button class="btn btn-light">Drop!</button></div>
			<div class="drop"><button class="btn btn-light">Drop!</button></div>
			<div class="drop"><button class="btn btn-light">Drop!</button></div>
	</div>

	<div class="mt-2 mb-3 board">

		@for ($i = $rows-1; $i >= 0; $i--)

			<div class="row">
			
				@for ($j=0; $j< $columns; $j++)

					<div class="spot {{ $board[$i][$j]['color'] }}"> {{ $i }}, {{ $j }}</div>

				@endfor

			</div>

		@endfor
	</div>

	<div class="mt-4 mb-3">
		Current Player : {{ $currentPlayer }}
	</div>

	<div class="mt-3 mb-3">
		<button class="btn btn-light">Restart Game</button>
	</div>

</body>
</html>