<footer class="ftco-footer">
    <div class="container mb-5 pb-4">
        <div class="row">
            <div class="col-lg col-md-6">
                <div class="ftco-footer-widget">
                    <h2 class="ftco-heading-2">About</h2>
                    <p>{{ config('site.footer_about', 'Punjab Saathi helps you get government certificates, ID cards, and applications processed online — fast, correctly, and affordably, without standing in long queues.') }}</p>
                    <ul class="ftco-footer-social list-unstyled mt-4">
                        @if(config('site.social.facebook'))
                            <li><a href="{{ config('site.social.facebook') }}" target="_blank" rel="noopener"><span class="fa fa-facebook"></span></a></li>
                        @endif
                        @if(config('site.social.instagram'))
                            <li><a href="{{ config('site.social.instagram') }}" target="_blank" rel="noopener"><span class="fa fa-instagram"></span></a></li>
                        @endif
                        @if(config('site.social.linkedin'))
                            <li><a href="{{ config('site.social.linkedin') }}" target="_blank" rel="noopener"><span class="fa fa-linkedin"></span></a></li>
                        @endif
                        @if(config('site.social.telegram'))
                            <li><a href="{{ config('site.social.telegram') }}" target="_blank" rel="noopener"><span class="fa fa-telegram"></span></a></li>
                        @endif
                        @if(config('site.social.google'))
                            <li><a href="{{ config('site.social.google') }}" target="_blank" rel="noopener"><span class="fa fa-map-marker"></span></a></li>
                        @endif
                        @if(config('site.social.twitter'))
                            <li><a href="{{ config('site.social.twitter') }}" target="_blank" rel="noopener"><span class="fa fa-twitter"></span></a></li>
                        @endif
                    </ul>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="ftco-footer-widget">
                    <h2 class="ftco-heading-2">Quick Links</h2>
                    <ul class="list-unstyled">
                        <li><a href="{{ url('/') }}"><span class="fa fa-chevron-right mr-2"></span>Home</a></li>
                        <li><a href="{{ url('/about') }}"><span class="fa fa-chevron-right mr-2"></span>About Us</a></li>
                        <li><a href="{{ url('/services') }}"><span class="fa fa-chevron-right mr-2"></span>All Services</a></li>
                        <li><a href="{{ url('/jobs') }}"><span class="fa fa-chevron-right mr-2"></span>Jobs Alerts</a></li>
                        <li><a href="{{ url('/blog') }}"><span class="fa fa-chevron-right mr-2"></span>Blog</a></li>
                        <li><a href="{{ url('/forms') }}"><span class="fa fa-chevron-right mr-2"></span>Download Forms</a></li>
                        <li><a href="{{ url('/track-application') }}"><span class="fa fa-chevron-right mr-2"></span>Track Application</a></li>
                        <li><a href="{{ url('/contact') }}"><span class="fa fa-chevron-right mr-2"></span>Contact</a></li>
                    </ul>
                </div>
            </div>

           <div class="col-lg-3 col-md-6">
    <div class="ftco-footer-widget">
        <h2 class="ftco-heading-2">Popular Services</h2>
        <ul class="list-unstyled">
            @forelse(($megaServices ?? collect())->flatten()->take(7) as $service)
                <li>
                    <a href="{{ url('/services/' . $service->slug) }}">
                        <span class="fa fa-chevron-right mr-2"></span>{{ $service->title }}
                    </a>
                </li>
            @empty
                <li><a href="{{ url('/services') }}"><span class="fa fa-chevron-right mr-2"></span>View Services</a></li>
            @endforelse
            <li>
                <a href="{{ url('/services') }}" class="font-weight-bold">
                    <span class="fa fa-chevron-right mr-2"></span>View All Services
                </a>
            </li>
        </ul>
    </div>
</div>

            <div class="col-lg col-md-6">
                <div class="ftco-footer-widget">
                    <h2 class="ftco-heading-2">Have a Question?</h2>
                    <div class="block-23 mb-3">
                        <ul>
                            <li>
                                <span class="fa fa-map-marker mr-3"></span>
                                <span class="text">{{ config('site.address', 'Shop No: 1, Lal Market, Near OHM Omjee Cinema, Grand Trunk Rd, 143001, Amritsar.') }}</span>
                            </li>
                            <li>
                                <a href="tel:{{ config('site.phone', '+917710556330') }}">
                                    <span class="fa fa-phone mr-3"></span>
                                    <span class="text">{{ config('site.phone', '+91 7710556330') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="mailto:{{ config('site.email', 'info@punjabsaathi.in') }}">
                                    <span class="fa fa-paper-plane mr-3"></span>
                                    <span class="text">{{ config('site.email', 'info@punjabsaathi.in') }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid bg-primary">
        <div class="container">
            <div class="row">
                <div class="col-md-12 aside-stretch py-3">
                    <p class="mb-0">Copyright &copy; {{ date('Y') }} {{ config('site.name', 'Punjab Saathi') }}. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>
</footer>

