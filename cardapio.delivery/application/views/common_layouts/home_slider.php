<style>
    .sliderWapper,
    .homeSlider {
        position: relative;
    }

    .sliderWapper .imagesBox {
        width: 100%;
        height: 450px;
    }

    .sliderWapper .imagesBox img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 1rem;
    }

    .sliderContainer .slick-prev:before,
    .slick-next:before {
        color: #080808 !important;
    }

    .homeSlider .slick-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 99;
        width: 40px !important;
        height: 40px !important;
        display: flex !important;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        opacity: 0;
        transition: all 0.5s ease-in-out;
    }

    .homeSlider:hover .slick-arrow {
        opacity: 1;
        transition: all 0.5s ease-in-out;
    }

    .sliderContainer .slick-prev {
        left: 15px;
    }

    .sliderContainer .slick-next {
        right: 15px;
    }

    .slick-dots li button:before {
        font-family: 'slick';
        font-size: 0 !important;
        top: -26px !important;
        width: 18px !important;
        height: 7px !important;
        content: '' !important;
        background: #ff1313 !important;
    }

    .sliderSectionArea {
        margin-top: 2rem;
        margin-bottom: 1.2rem;
    }
</style>
<section class="sliderSectionArea">
    <div class="restaurant-container">
        <div class="sliderContainer slider-nav homeSlider">
            <?php foreach ($slider_list as  $key => $slider) : ?>
                <div class="sliderWapper">
                    <div class="imagesBox">
                        <img src="<?= base_url($slider->images); ?>" onclick="window.location.href='<?= !empty($slider->external_url) ? prep_url($slider->external_url) : "javascript:;"; ?>';">
                    </div><!-- imagesBox -->
                </div><!-- sliderWapper -->
            <?php endforeach; ?>

        </div><!-- sliderContainer -->
    </div><!-- container -->
</section><!-- sliderSectionArea -->