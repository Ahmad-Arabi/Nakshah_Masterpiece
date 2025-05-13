<x-app-layout>
    <!-- Page Content -->
    <div class="page-heading contact-heading header-text nav-color-change">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="text-content">
              <h4>contact us</h4>
              <h2>we'd love to hear from you</h2>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="find-us">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="section-heading">
              <h2>Visit Our Store</h2>
            </div>
          </div>
          <div class="col-md-8">
            <div id="map">
              <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d5251.313689844205!2d35.89000945274391!3d31.90206917166119!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x151ca73bd1c37863%3A0xcd814b7f8a5f8a1a!2zQWxIdXJyaXlhaCBNYWxsINin2YTYrdix2YrYqSDZhdmI2YQ!5e1!3m2!1sen!2sjo!4v1746964986298!5m2!1sen!2sjo" width="100%" height="330px" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
          </div>
          <div class="col-md-4">
            <div class="left-content">
              <h4>About Our Store</h4>
              <p>Visit our store at Al-Hurriyah Mall, where you can explore our complete collection of contemporary and classic clothing for all occasions.</p>
              
              <div class="store-info">
                <p><i class="fa fa-clock-o"></i> <strong>Opening Hours:</strong> 10:00 AM - 10:00 PM, Daily</p>
                <p><i class="fa fa-phone"></i> <strong>Call Us:</strong> +962-78-757-9985</p>
                <p><i class="fa fa-envelope"></i> <strong>Email:</strong> contact@nakshah.com</p>
              </div>
              
              <p>Connect with us on social media for the latest trends, promotions, and fashion inspiration.</p>
              
              <ul class="social-icons">
                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="send-message mb-5">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="section-heading">
              <h2>Get in Touch</h2>
            </div>
          </div>
          <div class="col-md-8">
            @if (session('success'))
              <div class="alert alert-success">
                {{ session('success') }}
              </div>
            @endif
            <div class="contact-form">
              <form id="contact" action="{{ route('user.contactUs.store') }}" method="post">
                @csrf
                <div class="row">
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <fieldset>
                      <input name="name" type="text" class="form-control" id="name" placeholder="Full Name" required="">
                    </fieldset>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <fieldset>
                      <input name="email" type="text" class="form-control" id="email" placeholder="E-Mail Address" required="">
                    </fieldset>
                  </div>
                  <div class="col-lg-12 col-md-12 col-sm-12">
                    <fieldset>
                      <input name="subject" type="text" class="form-control" id="subject" placeholder="Subject" required="">
                    </fieldset>
                  </div>
                  <div class="col-lg-12">
                    <fieldset>
                      <textarea name="message" rows="6" class="form-control" id="message" placeholder="Your Message" required=""></textarea>
                    </fieldset>
                  </div>
                  <div class="col-lg-12">
                    <fieldset>
                      <button type="submit" id="form-submit" class="filled-button mb-5">Send Message</button>
                    </fieldset>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="col-md-4">
            <ul class="accordion">
              <li>
                  <a>Shipping & Delivery</a>
                  <div class="content">
                      <p>We offer fast, reliable shipping across Jordan with delivery in 3-5 business days. For orders over 50 JOD, shipping is free.</p>
                  </div>
              </li>
              <li>
                  <a>Returns & Exchanges</a>
                  <div class="content">
                      <p>We accept returns only within 14 days of purchase for unworn items with original tags attached. Returns can be processed in-store. Please note that customized items cannot be returned unless defective.</p>
                  </div>
              </li>
              <li>
                  <a>Sizing & Measurements</a>
                  <div class="content">
                      <p>Not sure about your size? Visit our sizing guide for detailed measurements for all our products. Our clothing is designed with standard Middle Eastern sizing, but we recommend checking the specific measurements for each item as styles may vary.</p>
                  </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
</x-app-layout>