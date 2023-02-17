		<?php
			include "./layouts/header.php";
		?>

		<?php
			if(!isset($_GET["page"])) {
				require "./home/index.php";
			} elseif($_GET["page"]=="books") {
				require "./books/index.php";
			} elseif($_GET["page"]=="book") {
				require "./book/index.php";
			} elseif($_GET["page"]=="manual") {
				require "./manual/index.php";
			}
		?>

		<?php
			include "./layouts/footer.php";
		?>