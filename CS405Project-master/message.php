<?php
if (isset($_SESSION['message'])) {
	echo "<div class=\"success\"><b>";
	echo strval($_SESSION['message']);
	echo "</b></div>";
	unset($_SESSION['message']);
}
if (isset($_SESSION['error'])) {
	echo "<div class=\"error\"><b>";
	echo strval($_SESSION['error']);
	echo "</b></div>";
	unset($_SESSION['error']);
}
?>