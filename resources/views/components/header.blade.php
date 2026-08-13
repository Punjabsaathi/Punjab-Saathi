<div class="pt-4 pb-5">
    <div class="container">
        <div class="row d-flex align-items-center">
            <div class="col-md-4 d-flex">
                <a href="{{ url('/') }}" class="d-inline-flex align-items-center">
                    <img src="{{ asset('images/punjab_seva_kendra.png') }}"
                         alt="Punjab Seva Kendra Logo"
                         style="height:100px; width:auto; object-fit:contain;">
                </a>
            </div>
            <div class="col-md-4 d-flex topper mb-md-0 mb-2 align-items-center">
                <div class="icon d-flex justify-content-center align-items-center">
                    <span class="fa fa-phone"></span>
                </div>
                <div class="pr-md-4 pl-md-3 pl-3 text">
                    <p class="con"><span>Free Call </span> <span>{{ config('site.phone', '+91 7710556330') }}</span></p>
                    <p class="con">Call Us Now 24/7 Customer Support</p>
                </div>
            </div>
            <div class="col-md-4 d-flex topper mb-md-0 align-items-center">
                <div class="icon d-flex justify-content-center align-items-center">
                    <span class="fa fa-map-marker"></span>
                </div>
                <div class="text pl-3 pl-md-3">
                    <p class="hr"><span>Our Location</span></p> 
                    <p class="con">{{ config('site.address', 'Shop No : 1, Lal Market, Near Guru Nanake dev Universty, 143001') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>