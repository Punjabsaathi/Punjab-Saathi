<div class="py-2 top">
    <div class="container">
        <div class="row">
            <div class="col-sm text-center text-md-left mb-md-0 mb-2 pr-md-4 d-flex topper align-items-center">
                <p class="mb-0 w-100">
                    <span class="fa fa-paper-plane"></span>
                    <span class="text">{{ config('site.email', 'info@punjabsaathi.in') }}</span>
                </p>
            </div>
            <div class="col-sm justify-content-center d-flex mb-md-0 mb-2">
                <div class="social-media">
                    <p class="mb-0 d-flex">
                        @if(config('site.social.facebook'))
                            <a href="{{ config('site.social.facebook') }}" class="d-flex align-items-center justify-content-center" target="_blank" rel="noopener"><span class="fa fa-facebook"></span></a>
                        @endif
                        @if(config('site.social.instagram'))
                            <a href="{{ config('site.social.instagram') }}" class="d-flex align-items-center justify-content-center" target="_blank" rel="noopener"><span class="fa fa-instagram"></span></a>
                        @endif
                        @if(config('site.social.linkedin'))
                            <a href="{{ config('site.social.linkedin') }}" class="d-flex align-items-center justify-content-center" target="_blank" rel="noopener"><span class="fa fa-linkedin"></span></a>
                        @endif
                        @if(config('site.social.telegram'))
                            <a href="{{ config('site.social.telegram') }}" class="d-flex align-items-center justify-content-center" target="_blank" rel="noopener"><span class="fa fa-telegram"></span></a>
                        @endif
                        @if(config('site.social.google'))
                            <a href="{{ config('site.social.google') }}" class="d-flex align-items-center justify-content-center" target="_blank" rel="noopener"><span class="fa fa-map-marker"></span></a>
                        @endif
                        @if(config('site.social.twitter'))
                            <a href="{{ config('site.social.twitter') }}" class="d-flex align-items-center justify-content-center" target="_blank" rel="noopener"><span class="fa fa-twitter"></span></a>
                        @endif
                    </p>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-7 d-flex topper align-items-center text-lg-right justify-content-end">
                <p class="mb-0 register-link">
                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">Inquire Now</a>
                </p>
            </div>
        </div>
    </div>
</div>

