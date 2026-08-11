<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close d-flex align-items-center justify-content-center" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fa fa-close"></span>
                </button>
            </div>
            <div class="modal-body p-4 p-md-5">
                <form action="{{ route('inquiry.store') }}" method="POST" class="appointment-form ftco-animate">
                    @csrf
                    <h3>Request Quote</h3>
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="form-group">
                        <input type="text" name="first_name" class="form-control" placeholder="First Name" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="last_name" class="form-control" placeholder="Last Name">
                    </div>
                    <div class="form-group">
                        <input type="text" name="phone" class="form-control" placeholder="Phone" required>
                    </div>
                    <div class="form-group">
                        <div class="select-wrap">
                            <div class="icon"><span class="fa fa-chevron-down"></span></div>
                            <select name="service" class="form-control">
                                <option value="">Select Your Service</option>
                                <option value="architecture">Architecture</option>
                                <option value="renovation">Renovation</option>
                                <option value="construction">Construction</option>
                                <option value="interior">Interior &amp; Exterior</option>
                                <option value="other">Other Services</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <textarea name="message" class="form-control" cols="30" rows="4" placeholder="Message"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary py-3 px-4">Request A Quote</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('#exampleModalCenter').modal('show');
            setTimeout(function () {
                $('.alert-success').fadeOut('slow');
            }, 2000);
            setTimeout(function () {
                $('#exampleModalCenter').modal('hide');
            }, 3000);
        });
    </script>
    @endif