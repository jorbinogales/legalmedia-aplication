<?php 
    require './layouts/header.php';

    if(!isset($_GET['page'])){
		require 'pages/index.php';
	} else {
		switch ($_GET['page']) {

			case 'products':
				require 'pages/index.php';
			break;
			default:
				require 'pages/index.php';
			break;
		}
	}

    require './layouts/footer.php';
?>