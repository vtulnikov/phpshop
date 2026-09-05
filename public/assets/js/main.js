$(function() {
	//CART
	const productIds = [];
	const links = document.querySelectorAll('.add-to-cart');

	function showCart(cart) {
		$('#cart-modal .modal-cart-content').html(cart);
		const modalElement = document.getElementById('cart-modal');
		const modal = bootstrap.Modal.getOrCreateInstance(modalElement);

		const cartCount = $('.cart-qty').text().trim();
		// cartCount ? $('.count-items').text(cartCount) : $('.count-items').text(0);
		const cartQty = parseInt(cartCount, 10) || 0; 
		$('.count-items').text(cartQty)
		
		modal.show();
	}
	function changeCartIcon(id) {
		links.forEach(link => {
			if (link.dataset.id == id) {
				link.querySelector('i').classList.replace('fa-cart-arrow-down','fa-shopping-cart');
			}
		})
	}
	function changeCartIcons() {
		links.forEach(link => {
			if (productIds.includes(link.dataset.id)) {
				link.querySelector('i').classList.replace('fa-cart-arrow-down','fa-shopping-cart');
			}
		})
	}
	//удаляем товар из корзины
	$('#cart-modal .modal-cart-content').on('click', '.del-item', function (e) {
		e.preventDefault();
		const id = $(this).data('id');
		$.ajax('cart/delete', {
			data: {id},
			success(res) {
				showCart(res);
				changeCartIcon(id);

				const index = productIds.indexOf(id);
				if (index != -1) {
					productIds.splice(index, 1);
				}
			},
			error() {
				console.log('Ошибка получения данных');
			}
		})
	})
	//очищаем корзину
	$('#cart-modal .modal-cart-content').on('click', '#cart-clear', () => {
		$.ajax('cart/clear', {
			success(res) {
				showCart(res);
				changeCartIcons()
				productIds.length = 0;
			},
			error() {
				console.log('Ошибка получения данных');
			}
		})
	})
	//показыавем корзину по клику на иконку в шапке
	$('#cart-top').on('click', (e) => {
		e.preventDefault();
		$.ajax('cart/show',{
			success(res) {
				showCart(res);
			},
			error() {
				console.log('Ошибка получения данных');
			}
		})
	})
	//добавляем товар в корзину по клике на кнопку корзины/купить
	$('.add-to-cart').on('click', function (e) {
		e.preventDefault();
		const id = $(this).data('id');
		const quantity = $('#input-quantity').val() ? $('#input-quantity').val() : 1;
		const $this = $(this);

		$.ajax('cart/add', {
			data: {
				id,
				quantity
			},
			success(res) {
				showCart(res);
				productIds.push(String(id));
				
				$this.css('color', '#eb494f');
				$this.find('i')[0].classList.replace('fa-shopping-cart', 'fa-cart-arrow-down');
			},
			error() {
				alert("Error");
			}
		})
	})
	//CART
	$('.open-search').click(function(e) {
		e.preventDefault();
		$('#search').addClass('active');
	});
	$('.close-search').click(function() {
		$('#search').removeClass('active');
	});

	$(window).scroll(function() {
		if ($(this).scrollTop() > 200) {
			$('#top').fadeIn();
		} else {
			$('#top').fadeOut();
		}
	});

	$('#top').click(function() {
		$('body, html').animate({scrollTop:0}, 700);
	});

	$('.sidebar-toggler .btn').click(function() {
		$('.sidebar-toggle').slideToggle();
	});

	$('.thumbnails').magnificPopup({
		type:'image',
		delegate: 'a',
		gallery: {
			enabled: true
		},
		removalDelay: 500,
		callbacks: {
			beforeOpen: function() {
				this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
				this.st.mainClass = this.st.el.attr('data-effect');
			}
		}
	});
	$('#languages button').on('click', function () {
		const lang = $(this).data('langcode');
		window.location = PATH + "/language/change?lang=" + lang;
	});
});