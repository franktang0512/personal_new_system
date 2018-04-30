<?php
    $item_content = '

	<div class="w3-content w3-section" style="width:100%;max-height:500px;max-width:700px;justify-content:center;align-items:center;padding-top: 80px;">
		<img class="mySlides" src="css/img/slideshow1.jpg" style="width:100%;height:500px;">
		<img class="mySlides" src="css/img/slideshow2.jpg" style="width:100%;height:500px;">
		<img class="mySlides" src="css/img/slideshow3.jpg" style="width:100%;height:500px;">
	</div>
	<script>
		var myIndex = 0;
		carousel();

		function carousel() {
			var i;
			var x = document.getElementsByClassName("mySlides");
			for (i = 0; i < x.length; i++) {
			   x[i].style.display = "none";  
			}
			myIndex++;
			if (myIndex > x.length) {myIndex = 1}    
			x[myIndex-1].style.display = "block";  
			setTimeout(carousel, 2500); // Change image every 2.5 seconds
		}
	</script>
	';

?>