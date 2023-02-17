<section class="interesting">
	<h1 class="interesting__title">ƏN MARAQLI</h1>
	<div class="interesting__subtitle">
		Ən maraqlı məhsullarımızın kolleksiyasını nəzərdən keçirin. mütləq
		axtardığınızı tapacaqsınız..
	</div>
	<ul class="interesting__links">
		<?php
		$last = false;
		$new = false;
		$popular = false;
		$liked = false;
		if (!isset($_GET["q"])) {
			$last = true;
		} elseif ($_GET["q"] == 'last__books') {
			$last = true;
		} elseif ($_GET["q"] == 'new__books') {
			$new = true;
		} elseif ($_GET["q"] == 'most__popular') {
			$popular = true;
		} elseif ($_GET["q"] == 'more__liked') {
			$liked = true;
		}
		?>
		<li class="interesting__link <?php echo $last ? 'interesting__link__active' : '' ?>">
			<a href=".?q=last__books ">Ən son satışa əlavə edilənlər</a>
		</li>
		<li class="interesting__link <?php echo $new ? 'interesting__link__active' : '' ?>"><a href=".?q=new__books">Ən yeni əsərlər</a></li>
		<li class="interesting__link <?php echo $popular ? 'interesting__link__active' : '' ?>"><a href=".?q=most__popular">Ən populyar əsərlər</a></li>
		<li class="interesting__link <?php echo $liked ? 'interesting__link__active' : '' ?>">
			<a href=".?q=more__liked">Ən çox bəyənilən əsərlər</a>
		</li>
	</ul>
	<?php
	if (count($books) < 1) { ?>
		<div class="no__book">
			<div class="alert alert-warning" role="alert">
				Axtarılan tipdə kitab yoxdur və ya bölmə düzənlənir
			</div>
		</div>
	<?php
	}
	?>
	<div class="interesting__wrapper container">
		<div title="mövcud kateqoriyaya uyğun bütün kitablar" class="inseresting__arrow">
			<a href=""><i class="fa fa-angle-right" aria-hidden="true"></i></a>
		</div>
		<?php
		foreach ($books as $book) {
			$getAuthor = $dbh->prepare("SELECT * FROM authors WHERE id = ?");
			$getAuthor->execute([$book["author_id"]]);
			$author = $getAuthor->fetch(PDO::FETCH_ASSOC);
			$star;
			$text;
			if ($book["countofb"] == 0) {
				$star = "<div class='no-star'>Hələ ki, heç bir istifadəçi bu kitaba qiymət verməyib</div>";
				$text = $star;
			} else {
				$star = $book["stars"] / $book["countofb"];
				if ($star <= 1) {
					$text = '
                        <div class="interesting__book__raiting">
                           <i class="fa fa-star" aria-hidden="true"></i>
                        </div>
                        ';
				} elseif ($star <= 2) {
					$text = '
                        <div class="interesting__book__raiting">
                           <i class="fa fa-star" aria-hidden="true"></i>
                           <i class="fa fa-star" aria-hidden="true"></i>
                        </div>
                        ';
				} elseif ($star <= 3) {
					$text = '
                        <div class="interesting__book__raiting">
                           <i class="fa fa-star" aria-hidden="true"></i>
                           <i class="fa fa-star" aria-hidden="true"></i>
                           <i class="fa fa-star" aria-hidden="true"></i>
                        </div>
                        ';
				} elseif ($star <= 4) {
					$text = '
                        <div class="interesting__book__raiting">
                           <i class="fa fa-star" aria-hidden="true"></i>
                           <i class="fa fa-star" aria-hidden="true"></i>
                           <i class="fa fa-star" aria-hidden="true"></i>
                           <i class="fa fa-star" aria-hidden="true"></i>
                 
                        </div>
                        ';
				} elseif ($star <= 5) {
					$text = '
                        <div class="interesting__book__raiting">
                           <i class="fa fa-star" aria-hidden="true"></i>
                           <i class="fa fa-star" aria-hidden="true"></i>
                           <i class="fa fa-star" aria-hidden="true"></i>
                           <i class="fa fa-star" aria-hidden="true"></i>
                           <i class="fa fa-star" aria-hidden="true"></i>
                        </div>
                        ';
				}
			}
		?>
			<a href=".?page=book&book_id=<?php echo $book["id"]?>" class="interesting__book">
				<div class="interesting__book__img">
					<img src="admin/assets/img/books/<?php echo $book["src"] ?>" alt="" />
				</div>
				<?php
				echo $text;
				?>
				<div class="interesting__book__author"><?php echo $author["author_name"] ?></div>
				<div class="interesting__book__name"><?php echo $book["book_name"] ?></div>
			</a>
		<?php
		}
		?>

	</div>
</section>

<section class="blogs">
	<h2 class="blogs__title">Son bloqlar</h2>
	<div class="container blogs__wrapper">
		<a title="Bütün bloqlar" class="all__blogs__trigger">
			<i class="fa fa-angle-right" aria-hidden="true"></i>
		</a>
		<div class="blog">
			<div class="blog__img">
				<img src="assets/images/3.png" alt="" />
			</div>
			<div class="blog__title">Title</div>
			<div class="blog__subtitle">Subtitle</div>
			<div class="blog__desc">
				Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi magni
				tempora eaque enim voluptates vitae consectetur quae qui harum
				ipsum.e...
			</div>
		</div>
		<div class="blog">
			<div class="blog__img">
				<img src="assets/images/3.png" alt="" />
			</div>
			<div class="blog__title">Title</div>
			<div class="blog__subtitle">Subtitle</div>
			<div class="blog__desc">
				Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi magni
				tempora eaque enim voluptates vitae consectetur quae qui harum
				ipsum.e...
			</div>
		</div>
		<div class="blog">
			<div class="blog__img">
				<img src="assets/images/3.png" alt="" />
			</div>
			<div class="blog__title">Title</div>
			<div class="blog__subtitle">Subtitle</div>
			<div class="blog__desc">
				Lorem ipsum dolor sit amet consectetur adipisicing elit. Nisi magni
				tempora eaque enim voluptates vitae consectetur quae qui harum
				ipsum.e...
			</div>
		</div>
	</div>
</section>

<section class="contact">
	<div class="contact__wrapper container">
		<div class="contact__top">
			<div class="contact__top__left">SON POSTLAR</div>
			<div class="contact__top__right">BİZİMLƏ QALIN</div>
		</div>
		<div class="contact__footer">
			<div class="contact__footer__fb">
				<a href="">
					<img src="assets/icons/fbicon.png" alt="" />
				</a>
			</div>
			<div class="contact__footer__desc">
				Səma baxışı həm də oxucuların dəyişən vərdişlərini izləyən dinamik
				bir prosesdir. Necə olduğunu qeyd etmək heyrətamizdir
			</div>
			<ul class="contact__footer__links">
				<li class="contact__footer__link">
					<a href="">
						<img src="assets/icons/fb_icon-icons.com_65434.png" alt="" />
					</a>
				</li>
				<li class="contact__footer__link">
					<a href="">
						<img src="assets/icons/instagram_f_icon-icons.com_65485.png" alt="" />
					</a>
				</li>
				<li class="contact__footer__link">
					<a href="">
						<img src="assets/icons/YOUTUBE_icon-icons.com_65487.png" alt="" />
					</a>
				</li>
				<li class="contact__footer__link">
					<a href="">
						<img src="assets/icons/vkvkontaktedrawlogo_114772.png" alt="" />
					</a>
				</li>
			</ul>
		</div>
	</div>
</section>
<section class="contact__sign">
	<div class="contact__sign__title">
		Yeniliklərdən xəbərdar olmaq üçün emailinizi qeyd edin
	</div>
	<div class="contact__sign__input">
		<form action="">
			<input type="text" />
			<button>Göndər</button>
		</form>
	</div>
</section>