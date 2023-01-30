<div class="section-carrousel">

    <h2>Trusted by Customers of All Shapes and Sizes<h2>

    <div class="customers-carousel">
        <div><img src="/wp-content/uploads/2021/01/logo1.png" alt="Logo1"></div>
        <div><img src="/wp-content/uploads/2021/01/logo2.png" alt="Logo2"></div>
        <div><img src="/wp-content/uploads/2021/01/logo3.png" alt="Logo3"></div>
        <div><img src="/wp-content/uploads/2021/01/logo4.png" alt="Logo4"></div>
        <div><img src="/wp-content/uploads/2021/01/logo5.png" alt="Logo5"></div>
        <div><img src="/wp-content/uploads/2021/01/logo6.png" alt="Logo6"></div>
        <div><img src="/wp-content/uploads/2021/01/logo1.png" alt="Logo1"></div>
        <div><img src="/wp-content/uploads/2021/01/logo2.png" alt="Logo2"></div>
        <div><img src="/wp-content/uploads/2021/01/logo3.png" alt="Logo3"></div>
        <div><img src="/wp-content/uploads/2021/01/logo4.png" alt="Logo4"></div>
        <div><img src="/wp-content/uploads/2021/01/logo5.png" alt="Logo5"></div>
        <div><img src="/wp-content/uploads/2021/01/logo6.png" alt="Logo6"></div>
    </div>
</div>

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css"/>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>

<script type="text/javascript">
	
jQuery(document).ready(function( $ ){
    $('.customers-carousel').slick({
        infinite: true,
        slidesToShow: 6,
        slidesToScroll: 1,
        arrows: true,
        autoplay: true,
        autoplaySpeed: 2000,
        prevArrow:"<button type='button' class='slick-prev pull-left'><img src='/wp-content/uploads/2021/01/c-leftarrow.svg'></button>",
        nextArrow:"<button type='button' class='slick-next pull-right'><img src='/wp-content/uploads/2021/01/c-rightarrow.svg'></button>",
        responsive: [
            {
            breakpoint: 1024,
            settings: {
                slidesToShow: 4,
            }
            },
            {
            breakpoint: 600,
            settings: {
                slidesToShow: 2,
            }
            },
            {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
            }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
    });
});
      
</script>