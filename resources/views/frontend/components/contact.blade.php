<section class="contact-section" id="contact">
  <div class="container">
    <div class="contact-info row">
      <div class="logo col-md-2">
        <img src="{{ asset($settings['logo'] ?? 'images/logo/logo-black.png') }}" alt="{{ $settings['site_title'] ?? 'JADOO' }}" class="img-fluid">
      </div>
      <div class="col-md-1"></div>
      <div class="text-content col-md-9">
        <h3>We Listen, design your vision and bring it to life...</h3>
        <h2>Let's Talk</h2>
      </div>
    </div>
    <div class="contact-details row">
      <div class="contact-address_1 col-md-3">
        <p><span>Saudi Arabia</span>
        {!! $settings['contact_address_sa'] ?? 'Level 7, Building 4.07, Zone 4<br>King Abdullah Financial District (KAFD)<br>Riyadh 13519, Saudi Arabia.' !!}<br><br>
        <span>Tel:</span> {{ $settings['contact_phone'] ?? '+966 123456789' }}<br>
        <span>Email:</span> {{ $settings['contact_email'] ?? 'jad@jadco.co' }}</p>
      </div>
      <div class="contact-address_2 col-md-3">
        <p><span>USA</span>
          {!! $settings['contact_address_usa'] ?? '3972 Barranca Parkway,<br>Ste J139, Irvine, CA 92606' !!}</p>
          <br>
        <p><span>UAE</span>
          {!! $settings['contact_address_uae'] ?? 'A1, Dubai Digital Park, Dubai Silicon Oasis,<br>Dubai, United Arab Emirates.' !!}</p>
      </div>
      <div class="contact-form col-md-6">
        <form action="{{ route('home') }}" method="POST">
          @csrf
          <div class="form-group">
            <input type="text" class="form-control" id="firstName" name="firstName" placeholder=" ">
            <label for="firstName" class="form-label">First Name</label>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" id="lastName" name="lastName" placeholder=" ">
            <label for="lastName" class="form-label">Last Name</label>
          </div>
          <div class="form-group">
            <input type="email" class="form-control" id="email" name="email" placeholder=" ">
            <label for="email" class="form-label">Email Address</label>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" id="phone" name="phone" placeholder=" ">
            <label for="phone" class="form-label">Phone Number</label>
          </div>
          <div class="form-group full-width">
            <textarea class="form-control" id="message" name="message" placeholder=" "></textarea>
            <label for="message" class="form-label">Brief message</label>
          </div>
          <button type="submit">SEND MESSAGE <i class="fas fa-arrow-right ml-2"></i></button>
        </form>
      </div>
    </div>
  </div>
</section> 