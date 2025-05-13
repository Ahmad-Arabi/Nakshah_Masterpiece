<x-app-layout>
<div class="page-heading about-heading header-text nav-color-change">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="text-content">
              <h4>about us</h4>
              <h2>our story</h2>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="best-features about-features">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="section-heading">
              <h2>Our Vision</h2>
            </div>
          </div>          <div class="col-md-6">
            <div class="right-image">
              <img src="https://images.unsplash.com/photo-1581291518857-4e27b48ff24e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80" alt="Custom clothing design workspace">
            </div>
          </div>
          <div class="col-md-6">
            <div class="left-content">
              <h4>Express Your Unique Style</h4>
              <p>At Nakshah, we believe that fashion should be as individual as you are. Founded with a passion for self-expression through clothing, we've created a platform where you can design and customize your own unique garments and accessories that truly represent your personality.</p>
              <p>Our mission is to empower customers to break free from mass-produced fashion by offering intuitive design tools, high-quality materials, and expert craftsmanship that brings your creative vision to life.</p>
              <ul class="social-icons">
                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Vision & Mission Section -->
    <div class="vision-mission">
      <div class="container">
        <div class="row">
          <div class="col-md-6 mb-4 mb-md-0">
            <div class="card">
              <div class="card-header">
                Our Vision
              </div>
              <div class="card-body">
                <p>To revolutionize the fashion industry by making personalized clothing accessible to everyone. We envision a world where mass production gives way to individual expression, where each garment tells a unique story, and where sustainability meets style.</p>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                Our Mission
              </div>
              <div class="card-body">
                <p>To provide an intuitive platform where customers can design their dream wardrobe, supported by cutting-edge technology and skilled artisans. We're committed to ethical production practices, quality craftsmanship, and delivering a seamless experience from design to doorstep.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    {{-- <div class="team-members">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="section-heading">
              <h2>Meet The Developer</h2>
            </div>
          </div>          <div class="col-md-4 mx-auto">
            <div class="team-member">
              <div class="thumb-container">
                <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80" alt="Ahmad Arabi">
                <div class="hover-effect">
                  <div class="hover-content">
                    <ul class="social-icons">
                      <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                      <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                      <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                      <li><a href="#"><i class="fa fa-github"></i></a></li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="down-content">
                <h4>Ahmad Arabi</h4>
                <span>Founder & Full Stack Developer</span>
                <p>Combining a passion for coding with a love for fashion, Ahmad created Nakshah to bridge the gap between technology and personal style. His vision has brought custom clothing to the digital age.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> --}}


    <div class="services">
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <div class="service-item">
              <div class="icon">
                <i class="fa fa-paint-brush"></i>
              </div>
              <div class="down-content">
                <h4>Custom Design Tools</h4>
                <p>Our intuitive design interface allows you to unleash your creativity. Choose from thousands of patterns, colors, and styles to create clothing that's uniquely yours.</p>
                <a href="{{ route('shop') }}" class="filled-button">Start Designing</a>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="service-item">
              <div class="icon">
                <i class="fa fa-scissors"></i>
              </div>
              <div class="down-content">
                <h4>Expert Craftsmanship</h4>
                <p>Each of your designs is carefully crafted by our skilled artisans, ensuring the highest quality materials and attention to every detail.</p>
                <a href="{{ route('user.contactUs') }}" class="filled-button">Contact Us</a>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            {{-- <div class="service-item">
              <div class="icon">
                <i class="fa fa-globe"></i>
              </div>
              <div class="down-content">
                <h4>Worldwide Shipping</h4>
                <p>We deliver your custom creations straight to your doorstep, anywhere in the world. Your personalized fashion journey is just a click away.</p>
                <a href="{{ route('about') }}" class="filled-button">Learn More</a>
              </div>
            </div> --}}
          </div>
        </div>
      </div>
    </div>


    {{-- <div class="happy-clients">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="section-heading">
              <h2>Our Partners</h2>
            </div>
          </div>          <div class="col-md-12">
            <div class="owl-clients owl-carousel">
              <div class="client-item">
                <img src="https://cdn-icons-png.flaticon.com/512/5968/5968672.png" alt="Fabric Supplier">
              </div>
              
              <div class="client-item">
                <img src="https://cdn-icons-png.flaticon.com/512/3800/3800024.png" alt="Sustainable Materials">
              </div>
              
              <div class="client-item">
                <img src="https://cdn-icons-png.flaticon.com/512/5968/5968853.png" alt="Shipping Partner">
              </div>
              
              <div class="client-item">
                <img src="https://cdn-icons-png.flaticon.com/512/6124/6124991.png" alt="Design Software">
              </div>
              
              <div class="client-item">
                <img src="https://cdn-icons-png.flaticon.com/512/5968/5968705.png" alt="Quality Control">
              </div>
              
              <div class="client-item">
                <img src="https://cdn-icons-png.flaticon.com/512/196/196566.png" alt="Payment Processing">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> --}}

</x-app-layout>