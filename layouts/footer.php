<footer class="py-3 bg-dark">
			<ul class="nav justify-content-center border-bottom pb-3 mb-3">
				<li class="nav-item">
					<a href="#" class="nav-link px-2 text-muted">Home</a>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link px-2 text-muted">Features</a>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link px-2 text-muted">Pricing</a>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link px-2 text-muted">FAQs</a>
				</li>
				<li class="nav-item">
					<a href="#" class="nav-link px-2 text-muted">About</a>
				</li>
			</ul>
			<p class="text-center text-muted">&copy; 2022 Company, Inc</p>
		</footer>

		<!-- End of .container -->
		<script
			src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
			integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
			crossorigin="anonymous"
		></script>
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



			function scrollToElement(element) {
				element.scrollIntoView({ behavior: 'smooth' });
			}

				const myElement = document.querySelector('.interesting__title');

				
		</script>
		<?php
			if($_GET["q"]) {
				echo '<script>scrollToElement(myElement);</script>';
			}
		?>
	</body>
</html>