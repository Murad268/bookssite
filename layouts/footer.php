<footer <?php echo isset($_GET["page"]) ? 'style="position: absolute; width: 100%; user-select: none; bottom: 0; left: 0"':''?> class="py-3 bg-dark">
	<p class="text-center text-muted">&copy; 2022 Company, Inc</p>
</footer>

<!-- End of .container -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<script>
	var swiper = new Swiper('.mySwiper', {})
	const active = (triggerSel, hoverSel, activeClass) => {
		document.querySelector(triggerSel).addEventListener('mouseover', () => {
			document.querySelector(hoverSel).classList.add(activeClass)
		})
		document
			.querySelector(triggerSel)
			.addEventListener('mouseleave', () => {
				document.querySelector(hoverSel).classList.remove(activeClass)
			})
	}
	active(
		'.header__top__left__lang',
		'.header__top__left__lang__hover',
		'header__top__left__lang__hover__active'
	)
	active(
		'.header__top__left__currency',
		'.header__top__left__currency__hover',
		'header__top__left__currency__hover__active'
	)

	const navbarPosition = (navbarSel, activeClass) => {
		const navbar = document.querySelector(navbarSel),
			navbarFirtsPos = navbar.getBoundingClientRect().top
		window.addEventListener('scroll', () => {
			if (navbar.getBoundingClientRect().top <= 0) {
				navbar.classList.add(activeClass)
			}
			if (document.documentElement.scrollTop <= navbarFirtsPos) {
				navbar.classList.remove(activeClass)
			}
		})
	}

	navbarPosition('.navbar', 'navbar__active')

	document.querySelectorAll(".stars i").forEach(item => {
		item.addEventListener("click", () => {
			const url = new URL(window.location.href);
			const id = url.searchParams.get("book_id");
			document.querySelector('.get_url').setAttribute('href', "./server/process.php?compross=addraiting&raiting="+item.getAttribute("data-val")+"&id="+id);
		})
	})

	
	document.querySelectorAll(".manstars i").forEach(item => {
		item.addEventListener("click", () => {
			const url = new URL(window.location.href);
			const id = url.searchParams.get("manual_id");
			document.querySelector('.get_url').setAttribute('href', "./server/process.php?manpros=addraiting&raiting="+item.getAttribute("data-val")+"&id="+id);
		})
	})


	const stars = document.querySelectorAll('.stars i')
	const starsNone = document.querySelector('.rating-box')

	// ---- ---- Stars ---- ---- //
	stars.forEach((star, index1) => {
		star.addEventListener('click', () => {
			stars.forEach((star, index2) => {
				// ---- ---- Active Star ---- ---- //
				index1 >= index2 ?
					star.classList.add('active') :
					star.classList.remove('active')
			})
		})
	})


	function scrollToElement(element) {
		element.scrollIntoView({
			behavior: 'smooth'
		});
	}

	const myElement = document.querySelector('.interesting__title');

	document.querySelector(".change_raiting").addEventListener("click", () => {
		document.querySelector(".raiting-not").classList.add("raiting-not-active");
		document.querySelector(".reaiting-have").classList.add('reaiting-have-passive');
	})
</script>
<?php
if (isset($_GET["q"])) {
	if ($_GET["q"]) {
		echo '<script>scrollToElement(myElement);</script>';
	}
}
?>
</body>

</html>