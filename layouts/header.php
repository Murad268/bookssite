<?php
   session_start();
	include './server/connect.php';
	if(isset($_GET["q"])) {
		$querry = $_GET["q"];
		if($querry == "last__books") {
			$q = $q = "ORDER BY id desc";
		} elseif($querry == "new__books") {
			$q = $q = "WHERE new = 1 ORDER BY id desc";
		} elseif($querry == "most__popular") {
			$q = $q = "ORDER BY views desc";
		} elseif($querry == "more__liked") {
			$q = $q = "ORDER BY views desc";
		}
	} else {
		$q = "ORDER BY id desc";
	}

	$fetchBooks = $dbh->prepare("SELECT * FROM books $q");
	$fetchBooks->execute();
	$books = $fetchBooks->fetchAll(PDO::FETCH_ASSOC);
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
		<link
			href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Babylonica&family=Bangers&family=Bebas+Neue&family=Kaushan+Script&family=Montserrat:wght@100;200;300;400;500;600;700;800;900&family=Mukta:wght@200;300;400;500;600;700;800&family=Open+Sans:wght@300;400;500;600;700;800&family=Pacifico&family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Raleway:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@400;700&family=Rubik+Burned&family=Russo+One&display=swap"
			rel="stylesheet"
		/>
		<link
			href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Babylonica&family=Bangers&family=Bebas+Neue&family=Kaushan+Script&family=Montserrat:wght@100;200;300;400;500;600;700;800;900&family=Mukta:wght@200;300;400;500;600;700;800&family=Open+Sans:wght@300;400;500;600;700;800&family=Pacifico&family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Raleway:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@400;700&family=Rubik+Burned&family=Russo+One&display=swap"
			rel="stylesheet"
		/>
		<link
			href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Babylonica&family=Bebas+Neue&family=Kaushan+Script&family=Montserrat:wght@100;200;300;400;500;600;700;800;900&family=Mukta:wght@200;300;400;500;600;700;800&family=Open+Sans:wght@300;400;500;600;700;800&family=Pacifico&family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Raleway:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@400;700&family=Rubik+Burned&family=Russo+One&display=swap"
			rel="stylesheet"
		/>
		<link
			href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Babylonica&family=Bebas+Neue&family=Montserrat:wght@100;200;300;400;500;600;700;800;900&family=Mukta:wght@200;300;400;500;600;700;800&family=Open+Sans:wght@300;400;500;600;700;800&family=Pacifico&family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Raleway:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@400;700&family=Rubik+Burned&family=Russo+One&display=swap"
			rel="stylesheet"
		/>
		<link
			rel="stylesheet"
			href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"
		/>
		<link
			rel="stylesheet"
			href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
			integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
			crossorigin="anonymous"
			referrerpolicy="no-referrer"
		/>
		<link
			href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
			rel="stylesheet"
			integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
			crossorigin="anonymous"
		/>
		<link rel="stylesheet" href="./style/style.css" />
		<title>Document</title>
	</head>
	<body>
		<header class="header">
			<div class="header__top">
				<div class="container">
					<div class="header__top__left">
						<div class="header__top__left__lang">
							<div class="header__top__left__lang__icon">
								<img src="./assets/icons/az.png" alt="" />
							</div>
							<div class="header__top__left__lang__name">Azərbaycan</div>
							<div class="header__top__left__lang__arrow">
								<i class="fa fa-angle-down" aria-hidden="true"></i>
							</div>
							<div class="header__top__left__lang__hover">
								<div class="header__top__left__lang">
									<div class="header__top__left__lang__icon">
										<img src="./assets/icons/rus.png" alt="" />
									</div>
									<div class="header__top__left__lang__name">Azərbaycan</div>
								</div>
								<div class="header__top__left__lang">
									<div class="header__top__left__lang__icon">
										<img src="./assets/icons/eng.png" alt="" />
									</div>
									<div class="header__top__left__lang__name">Azərbaycan</div>
								</div>
							</div>
						</div>
						<div class="header__top__left__currency">
							<div class="header__top__left__currency__name">AZN</div>
							<div class="header__top__left__currency__icon">₼</div>
							<div class="header__top__left__lang__arrow">
								<i class="fa fa-angle-down" aria-hidden="true"></i>
							</div>
							<div class="header__top__left__currency__hover">
								<div class="header__top__left__currency">
									<div class="header__top__left__currency__name">USD</div>
									<div class="header__top__left__currency__icon">$</div>
								</div>
							</div>
						</div>
					</div>
					<div class="header__top__right">
						<ul class="header__top__right__links">
							<div class="header__top__right__link">
								<a href="">Mənim Hesabım</a>
							</div>
                     <?php
                        if(isset($_SESSION["user_email"])) {?>
                        	<div class="header__top__right__link">
                              <a onclick="return confirm('Çıxış etmək istədiyinizdən əminsiniz?')" href="./server/process.php?pros=exit">Çıxış</a>
                           </div>
                        <?php
                        } else {?>
                        	<div class="header__top__right__link">
                              <a href="./login">Daxil ol</a>
                           </div>
                        <?php
                        }
                     ?>
						
						</ul>
					</div>
				</div>
			</div>
			<div class="header__center container">
				<div class="header__center__left">
					<div class="main-search-input-wrap">
						<div class="main-search-input fl-wrap">
							<div class="main-search-input-item">
								<input
									type="text"
									value=""
									placeholder="Kitab və ya müəəlif adı..."
								/>
							</div>
							<button class="main-search-button">Axtar</button>
						</div>
					</div>
				</div>
				<div class="header__center__logo">
					<img src="assets/images/5.png" alt="" />
				</div>
				<div class="header__center__right">
					<a title="Sevimlilər">
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
									Oxumağa kitab seçə bilmirsən? Ya istədiyin kitabı tapa
									bilmirsən?
								</div>
								<div class="carusel__desc">
									O zaman bazasında 50 mindən çox kitab olan
									<span>SƏMA</span> kitabxanası sənin xidmətindədir
								</div>
							</div>
						</div>
						<div class="swiper-slide">
							<img src="assets/images/bookbg2.png" alt="" />
							<div class="carusel__box">
								<div class="carusel__title sectit">
									Kitabxanada vaxt itirməkdən bezmisən, ya kitab mağazalarında
									büdcənə uyğun olmayan kitablara pul xərcləməkdən yorulmusan?
								</div>
								<div class="carusel__desc seccas">
									<span>SƏMA</span> kitabxanası hər zaman yanındadır!
								</div>
							</div>
						</div>
						<div class="swiper-slide">
							<img src="assets/images/bookbg4.jpg" alt="" />
							<div class="carusel__box">
								<div class="carusel__title sectit">
									Tələbəsən? Dissertasiya, Sərbəst iş, Kurs işləri arasında itib
									batmısan və başlamaq üçün ip ucu tapa bilmirsən?
								</div>
								<div class="carusel__desc seccas">
									<span>SƏMA</span> kitabxanasına bir göz gəzdir
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</header>