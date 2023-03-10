<?php
session_start();
include './server/connect.php';
if (isset($_GET["q"])) {
	$querry = $_GET["q"];
	if ($querry == "last__books") {
		$q = $q = "ORDER BY id desc";
	} elseif ($querry == "new__books") {
		$q = $q = "WHERE new = 1 ORDER BY id desc";
	} elseif ($querry == "most__popular") {
		$q = $q = "ORDER BY views desc";
	} elseif ($querry == "more__liked") {
		$q = $q = "ORDER BY stars/countofb desc";
	}
} else {
	$q = "ORDER BY id desc";
}

$fetchBooks = $dbh->prepare("SELECT * FROM books $q");
$fetchBooks->execute();
$books = $fetchBooks->fetchAll(PDO::FETCH_ASSOC);

$getCategories = $dbh->prepare("SELECT * FROM categories");
$getCategories->execute();
$categories = $getCategories->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET["category"])) {
	$cat = $_GET["category"];

	$getBooks = $dbh->prepare("SELECT * FROM $cat");
	$getBooks->execute();
	$gettedBooks = $getBooks->fetchAll(PDO::FETCH_ASSOC);
}


$getGenres = $dbh->prepare("SELECT * FROM genres");
$getGenres->execute();
$genres = $getGenres->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="preconnect" href="https://fonts.googleapis.com" />
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
	<link rel="preconnect" href="https://fonts.googleapis.com" />
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
	<link rel="preconnect" href="https://fonts.googleapis.com" />
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
	<link rel="preconnect" href="https://fonts.googleapis.com" />
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
	<link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Babylonica&family=Bangers&family=Bebas+Neue&family=Kaushan+Script&family=Montserrat:wght@100;200;300;400;500;600;700;800;900&family=Mukta:wght@200;300;400;500;600;700;800&family=Open+Sans:wght@300;400;500;600;700;800&family=Pacifico&family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Raleway:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@400;700&family=Rubik+Burned&family=Russo+One&display=swap" rel="stylesheet" />
	<link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Babylonica&family=Bangers&family=Bebas+Neue&family=Kaushan+Script&family=Montserrat:wght@100;200;300;400;500;600;700;800;900&family=Mukta:wght@200;300;400;500;600;700;800&family=Open+Sans:wght@300;400;500;600;700;800&family=Pacifico&family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Raleway:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@400;700&family=Rubik+Burned&family=Russo+One&display=swap" rel="stylesheet" />
	<link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Babylonica&family=Bebas+Neue&family=Kaushan+Script&family=Montserrat:wght@100;200;300;400;500;600;700;800;900&family=Mukta:wght@200;300;400;500;600;700;800&family=Open+Sans:wght@300;400;500;600;700;800&family=Pacifico&family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Raleway:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@400;700&family=Rubik+Burned&family=Russo+One&display=swap" rel="stylesheet" />
	<link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Babylonica&family=Bebas+Neue&family=Montserrat:wght@100;200;300;400;500;600;700;800;900&family=Mukta:wght@200;300;400;500;600;700;800&family=Open+Sans:wght@300;400;500;600;700;800&family=Pacifico&family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Raleway:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@400;700&family=Rubik+Burned&family=Russo+One&display=swap" rel="stylesheet" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
	<link rel="stylesheet" href="./style/style.css" />
	<title>Document</title>
</head>

<body>
	<?php
	if (!isset($_GET["page"])) { ?>
		<header class="header">
			<?php
			include "./layouts/top.php";
			?>
			<div class="header__center container">
				<div class="header__center__left">
					<div class="main-search-input-wrap">
						<div class="main-search-input fl-wrap">
							<div class="main-search-input-item">
								<input type="text" value="" placeholder="Kitab v?? ya m??????lif ad??..." />
							</div>
							<button class="main-search-button">Axtar</button>
						</div>
					</div>
				</div>
				<div class="header__center__logo">
					<img src="assets/images/5.png" alt="" />
				</div>
				<div class="header__center__right">
					<a title="Sevimlil??r">
						<span><i class="fa fa-book" aria-hidden="true"></i></span>
					</a>
				</div>
			</div>

			<?php
			include "./layouts/navbar.php"
			?>
			<div class="header__body">
				<div class="swiper mySwiper">
					<div class="swiper-wrapper">
						<div class="swiper-slide">
							<img src="assets/images/bookbg1.png" alt="" />
							<div class="carusel__box">
								<div class="carusel__title">
									Oxuma??a kitab se???? bilmirs??n? Ya ist??diyin kitab?? tapa
									bilmirs??n?
								</div>
								<div class="carusel__desc">
									O zaman bazas??nda 50 mind??n ??ox kitab olan
									<span>S??MA</span> kitabxanas?? s??nin xidm??tind??dir
								</div>
							</div>
						</div>
						<div class="swiper-slide">
							<img src="assets/images/bookbg2.png" alt="" />
							<div class="carusel__box">
								<div class="carusel__title sectit">
									Kitabxanada vaxt itirm??kd??n bezmis??n, ya kitab ma??azalar??nda
									b??dc??n?? uy??un olmayan kitablara pul x??rcl??m??kd??n yorulmusan?
								</div>
								<div class="carusel__desc seccas">
									<span>S??MA</span> kitabxanas?? h??r zaman yan??ndad??r!
								</div>
							</div>
						</div>
						<div class="swiper-slide">
							<img src="assets/images/bookbg4.jpg" alt="" />
							<div class="carusel__box">
								<div class="carusel__title sectit">
									T??l??b??s??n? Dissertasiya, S??rb??st i??, Kurs i??l??ri aras??nda itib
									batm??san v?? ba??lamaq ??????n ip ucu tapa bilmirs??n?
								</div>
								<div class="carusel__desc seccas">
									<span>S??MA</span> kitabxanas??na bir g??z g??zdir
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</header>
	<?php
	} else {
		include "./layouts/top.php";
		include "./layouts/navbar.php";
	}
	?>