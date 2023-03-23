<div class="banner">
    <div class="slider-for">
        <div class="slide" data-img-url="{{ asset('build/images/banners/full/forbes.jpg') }}">
            <picture>
              <source 
                media="(min-width: 650px)"
                srcset="{{ asset('build/images/banners/full/forbes.jpg') }}">
              <source 
                media="(max-width: 649px)"
                srcset="build/images/banner1_res.jpg">
              <img src="{{ asset('build/images/banners/full/forbes.jpg') }}" alt="">
            </picture>
        </div>
    </div>
</div>
<!-- banner module ends here -->