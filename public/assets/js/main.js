$(function () {
	//CART
	function showCart(cart) {
		$('#cart-modal .modal-cart-content').html(cart);
		
		/**Наличие атрибутов data-bs-toggle="modal" и data-bs-target="#cart-modal" дает команду 
		 * JavaScript-ядру Bootstrap: "При клике на этот элемент немедленно открой модальное окно 
		 * с указанным ID". Поэтому нам не нужно создавать это окно вручную и запускать его
		 * через  modal.show().*/

		// const modalElement = document.getElementById('cart-modal');
		// const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
		
		//получаем из модалки кол-во товаров и обновляем его в шапке
		const cartItems = $('.cart-qty').text().trim();
		cartItems ? $('.count-items').text(cartItems) : $('.count-items').text(0);
		
		// modal.show();
	}
	function changeCartIcon(id) {
		// Находим кнопку и меняем класс у иконки внутри неё
		$(`.add-to-cart[data-id="${id}"]`).find('i')
			.removeClass('fa-cart-arrow-down')
			.addClass('fa-shopping-cart');
	}
	function resetAllCartIcons() {
		$('.add-to-cart').find('i')
			.removeClass('fa-cart-arrow-down')
			.addClass('fa-shopping-cart');
	}
	
	//удаляем товар по клику на иконку удаления
	$('#cart-modal .modal-cart-content').on('click', '.del-item', function (e) {
		e.preventDefault();
		const id = $(this).data('id');

		$.ajax({
			url: 'cart/delete',
			data: {id},
			success: function (res) {
				showCart(res);
				changeCartIcon(id);
			},
			error: function () {
				alert("Error");
			}
		})
	})
	//очищаем корзину по клику на кнопку "Очистить корзину"
	$('#cart-modal .modal-cart-content').on('click', '#clear-cart', function (e) {
		$.ajax({
			url: 'cart/clear',
			success: function (res) {
				showCart(res);
				resetAllCartIcons();
			},
			error: function () {
				alert("Error");
			}
		})
	})
	//показ корзины по клику на иконку в шапке
	$('#top-cart').on('click', function (e) {
		e.preventDefault();
		$.ajax({
			url: 'cart/show',
			success: function (res) {
				showCart(res);
			},
			error: function () {
				alert("Error");
			}
		})
	})
	//добавление товара по клику на кнопку корзины (купить типа)
	$('.add-to-cart').on('click', function (e) {
		e.preventDefault();
		const id = $(this).data('id');
		const qauntity = $('#input-quantity').val() ? $('#input-quantity').val() : 1;
		const $this = $(this);

		$.ajax({
			url: 'cart/add',
			data: {
				id,
				qauntity
			},
			success: function (res) {
				showCart(res);
				$this.css('color', '#eb494f');
				$this.find('i').removeClass('fa-shopping-cart').addClass('fa-cart-arrow-down');
			},
			error: function () {
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
		const langCode = $(this).data('langcode');
		window.location = PATH + "/language/change?lang=" + langCode;
	})
});