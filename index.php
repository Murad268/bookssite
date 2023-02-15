		<?php
			include "./layouts/header.php";
		?>

		<?php
			if(!isset($_GET["page"])) {
				require "./home/index.php";
			} elseif($_GET["page"]=="books") {
				require "./books/index.php";
			}
		?>

		<?php
			include "./layouts/footer.php";
		?>