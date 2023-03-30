<!DOCTYPE html>
<html>
<head>
	<title>Compressão LZW</title>
	<style>
		body {
			background-color: #E6F1F1;
		}
		form {
			text-align: center;
		}
		input[type=text], input[type=submit] {
			background-color: #B6E5B6;
			color: #000;
			padding: 5px;
			border-radius: 5px;
			border: none;
			margin-bottom: 10px;
		}
		input[type=submit]:hover {
			cursor: pointer;
		}
	</style>
</head>
<body>
	<form method="post">
		<label for="word">Palavra:</label>
		<input type="text" name="word" id="word">
		<br>
		<input type="submit" name="submit" value="Comprimir">
	</form>
	<?php
		
		function openYoutubeVideo() {
			$videoId = "https://youtu.be/sFjBz5Kdinw"; 
			$url = "https://www.youtube.com/watch?v=" . $videoId;
			echo "<script>window.open('$url')</script>";
		}

		if(isset($_POST['submit'])) {
			$word = $_POST['word'];

			
			$dictionary = array_flip(range("\0", "\xFF"));
			$current_code = 256;
			$current_sequence = "";
			$compressed = array();
			for($i = 0; $i < strlen($word); $i++) {
				$char = $word[$i];
				$sequence = $current_sequence . $char;
				if(array_key_exists($sequence, $dictionary)) {
					$current_sequence = $sequence;
				} else {
					$compressed[] = $dictionary[$current_sequence];
					$dictionary[$sequence] = $current_code++;
					$current_sequence = $char;
				}
			}
			if(!empty($current_sequence)) {
				$compressed[] = $dictionary[$current_sequence];
			}

			
			echo "<p>Palavra comprimida: " . implode(" ", $compressed) . "</p>";

			
			$current_code = 256;
			$dictionary = range("\0", "\xFF");
			$current_sequence = "";
			$decompressed = "";
			foreach($compressed as $code) {
				if(array_key_exists($code, $dictionary)) {
					$sequence = $dictionary[$code];
				} else {
					$sequence = $current_sequence . substr($current_sequence, 0, 1);
				}
				$decompressed .= $sequence;
				if(!empty($current_sequence)) {
					$dictionary[] = $current_sequence . $sequence[0];
					$current_code++;
				}
				$current_sequence = $sequence;
			}

			
			echo "<p>Palavra descomprimida: " . $decompressed . "</p>";

		
			if($word == "sonia") {
				openYoutubeVideo();
			}
		}
	?>
</body>
</html>
