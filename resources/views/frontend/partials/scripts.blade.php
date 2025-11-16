<script src="{{ asset('assets/frontend/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('assets/frontend/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/frontend/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/frontend/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/frontend/js/aos.js') }}"></script>
<script src="{{ asset('assets/frontend/js/swiper.min.js') }}"></script>
<script src="https://www.google.com/recaptcha/api.js?render={{ config('custom.recaptcha_site_key') }}"></script>

<script>
    function protect_with_recaptcha_v3(formElement, action) {
        event.preventDefault();

        grecaptcha.ready(function () {
            grecaptcha.execute('{{ config('custom.recaptcha_site_key') }}', { action: action }).then(function (token) {
                // Create or update recaptcha_token input
                let tokenInput = formElement.querySelector('[name="recaptcha_token"]');
                if (!tokenInput) {
                    tokenInput = document.createElement('input');
                    tokenInput.type = 'hidden';
                    tokenInput.name = 'recaptcha_token';
                    formElement.appendChild(tokenInput);
                }
                tokenInput.value = token;

                //alert(token);

                // Create or update recaptcha_action input
                let actionInput = formElement.querySelector('[name="recaptcha_action"]');
                if (!actionInput) {
                    actionInput = document.createElement('input');
                    actionInput.type = 'hidden';
                    actionInput.name = 'recaptcha_action';
                    formElement.appendChild(actionInput);
                }
                actionInput.value = action;

                formElement.submit();
            });
        });
    }
</script>

<script>
  AOS.init({
    duration: 800, // Duration of animations
    once: true,    // Whether animation should happen only once
  });
</script>

<script>
  $(document).ready(function() {
    $(".owl-carousel").owlCarousel({
      items: 5, // Default number of items
      loop: true, // Loop through items
      margin: 45, // Space between items
      nav: true, // Show next/prev buttons
      dots: true, // Show pagination dots
      autoplay: true, // Autoplay the carousel
      autoplayTimeout: 3000, // Autoplay interval in ms
      autoplayHoverPause: true, // Pause on mouse hover
      responsive: {
        0: {
          items: 1 // For mobile view
        },
        768: {
          items: 4 // For tablets
        },
        1024: {
          items: 4 // For desktops
        }
      }
    });
  });
</script>