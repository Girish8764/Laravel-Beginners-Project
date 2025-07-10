
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>SchoolDiGi</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets1/images/logo-mini.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="index.html" class="logo d-flex align-items-center me-auto">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="assets1/images/logo1.png" alt="">
        <!-- <h1 class="sitename">Arsha</h1> -->


      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero" class="active">Home</a></li>
          <li><a href="#about">About</a></li>
          <li><a href="#services">Services</a></li>
          <!-- <li><a href="#portfolio">Portfolio</a></li> -->
          <li><a href="#team">Team</a></li>
          <li><a href="#pricing">Pricing</a></li>
          <!-- <li><a href="blog.html">Blog</a></li> -->
          <!-- <li class="dropdown"><a href="#"><span>Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="#">Dropdown 1</a></li>
              <li class="dropdown"><a href="#"><span>Deep Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                <ul>
                  <li><a href="#">Deep Dropdown 1</a></li>
                  <li><a href="#">Deep Dropdown 2</a></li>
                  <li><a href="#">Deep Dropdown 3</a></li>
                  <li><a href="#">Deep Dropdown 4</a></li>
                  <li><a href="#">Deep Dropdown 5</a></li>
                </ul>
              </li>
              <li><a href="#">Dropdown 2</a></li>
              <li><a href="#">Dropdown 3</a></li>
              <li><a href="#">Dropdown 4</a></li>
            </ul> -->
          </li>
          <li><a href="#contact">Contact</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="btn-getstarted" href="/login">Login</a>

    </div>
  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">

      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="zoom-out">
            <h1>Better Solutions For Your School</h1>
            <p>We are offering you Best quality CRM portal.</p>
            <div class="d-flex">
              <a href="#about" class="btn-get-started">Get Started</a>
              <!-- <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="glightbox btn-watch-video d-flex align-items-center"><i class="bi bi-play-circle"></i><span>Watch Video</span></a> -->
            </div>
          </div>
          <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out" data-aos-delay="200">
            <img src="assets/img/hero-img.png" class="img-fluid animated" alt="">
          </div>
        </div>
      </div>

    </section><!-- /Hero Section -->

    <!-- Clients Section -->
    <!-- <section id="clients" class="clients section light-background">

      <div class="container" data-aos="zoom-in">

        <div class="swiper init-swiper">
          <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "speed": 600,
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": "auto",
              "pagination": {
                "el": ".swiper-pagination",
                "type": "bullets",
                "clickable": true
              },
              "breakpoints": {
                "320": {
                  "slidesPerView": 2,
                  "spaceBetween": 40
                },
                "480": {
                  "slidesPerView": 3,
                  "spaceBetween": 60
                },
                "640": {
                  "slidesPerView": 4,
                  "spaceBetween": 80
                },
                "992": {
                  "slidesPerView": 5,
                  "spaceBetween": 120
                },
                "1200": {
                  "slidesPerView": 6,
                  "spaceBetween": 120
                }
              }
            }
          </script>
          <div class="swiper-wrapper align-items-center">
            <div class="swiper-slide"><img src="assets/img/clients/clients-1.webp" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/clients-2.webp" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/clients-3.webp" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/clients-4.webp" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/clients-5.webp" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/clients-6.webp" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/clients-7.webp" class="img-fluid" alt=""></div>
            <div class="swiper-slide"><img src="assets/img/clients/clients-8.webp" class="img-fluid" alt=""></div>
          </div>
        </div>

      </div>

    </section> -->
    <!-- /Clients Section -->

    <!-- About Section -->
    <section id="about" class="about section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Why School-DiGi Management Software?</h2>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-4">
            <div class="col-lg-6 pt-4 pt-lg-0">
                <img src="{{ asset('assets/img/school.png') }}" class="img-fluid animated" alt="">
            </div>
            <div class="col-lg-6">
                <p>
                School-digi management systems (SMS) are software platforms designed to simplify and automate the day-to-day functions of educational 
                institutions.expand_more  They act as a central hub, bringing together various aspects of school life into one easy-to-use system.
                </p>
                <ul>
                <li><i class="bi bi-check2-all"></i> Increased Efficiency: SMS automates tasks like attendance tracking, grade management, and fee collection, freeing up valuable time for administrators and teachers.expand_less</li>
                <li><i class="bi bi-check2-all"></i>Improved Communication: The system facilitates communication between teachers, parents, and students through features like online forums, assignment portals, and automated notifications.</li>
                <li><i class="bi bi-check2-all"></i> Enhanced Organization: Student information, class schedules, and curriculum materials are all organized within the SMS, making it easier to access and manage data.</li>
                <li><i class="bi bi-check2-all"></i>Data-Driven Decisions: SMS can generate reports on student performance, attendance, and other metrics, allowing schools to identify areas for improvement and make informed decisions.</li>
                
                <li><i class="bi bi-check2-all"></i>Student Information Management: Enrollment, attendance tracking, academic records, and communication with parents.</li>
                <li><i class="bi bi-check2-all"></i>Staff Management: Teacher schedules, payroll, performance evaluations, and professional development resources.exclamation</li>
                <li><i class="bi bi-check2-all"></i>Curriculum Management: Lesson plans, assignments, online resources, and assessment tools.</li>
                </ul>
            </div>
        </div>

      </div>

    </section><!-- /About Section -->

    <!-- Why Us Section -->
    <section id="why-us" class="section why-us light-background" data-builder="section">

      <div class="container-fluid">

        <div class="row gy-4">

          <div class="col-lg-7 d-flex flex-column justify-content-center order-2 order-lg-1">

            <div class="content px-xl-5" data-aos="fade-up" data-aos-delay="100">
              <h3><span>Core functionalities of an SMS typically include:</strong></h3>
              <!-- <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Duis aute irure dolor in reprehenderit
              </p> -->
            </div>

            <div class="faq-container px-xl-5" data-aos="fade-up" data-aos-delay="200">

              <div class="faq-item faq-active">

                <h3><span>01</span>Student Information Management:</h3>
                <div class="faq-content">
                  <p>Enrollment, attendance tracking, academic records, and communication with parents.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3><span>02</span>Staff Management:</h3>
                <div class="faq-content">
                  <p>Teacher schedules, payroll, performance evaluations, and professional development resources.exclamation.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3><span>03</span>Curriculum Management:</h3>
                <div class="faq-content">
                  <p>Lesson plans, assignments, online resources, and assessment tools.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3><span>04</span>Financial Management:</h3>
                <div class="faq-content">
                  <p>Fee collection, invoicing, expense tracking, and budget reports.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item">
                <h3><span>05</span>Communication Tools:</h3>
                <div class="faq-content">
                  <p>Email, messaging, online forums, and parent portals.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

            </div>
          </div>
          <div class="col-lg-5 order-1 order-lg-2 why-us-img">
            <img src="assets/img/SMS.png" class="img-fluid" alt="" data-aos="zoom-in" data-aos-delay="100">
          </div>
        </div>

      </div>

    </section><!-- /Why Us Section -->

    <!-- ======= Skills Section ======= -->
    <section id="skills" class="skills">
      <div class="container" data-aos="fade-up">

        <div class="row">
          <div class="col-lg-4 d-flex align-items-center" data-aos="fade-right" data-aos-delay="100">
            <img src="assets/img/why-us.png" class="img-fluid" alt="">
          </div>
          <div class="col-lg-8 pt-4 pt-lg-0 content" data-aos="fade-left" data-aos-delay="100">
            <h3>Satisfaction Ratio</h3>
            <p class="fst-italic">
              Satisfaction Ratio measures customer contentment. It compares the number of satisfied customers to the total customer base, indicating overall service quality and effectiveness.
            </p>
            <div class="row" style="margin-top:50px;">
              <div class="col-sm-4">
                <div class="card mb-3 mb-sm-0">
                  <div class="card-body py-3 px-4">
                    <p class="m-0 survey-head text-warning">Total School</p>
                    <div class="d-flex justify-content-between align-items-end flot-bar-wrapper">
                      <div>
                        <h4 class="m-0 survey-value text-primary">{{ number_format($totalSchools + 250) }}+</h4>
                        <p class="text-success m-0">{{ $monthlySchoolAvg + 20 }} avg. PM</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-4">
                <div class="card mb-3 mb-sm-0">
                  <div class="card-body py-3 px-4">
                    <p class="m-0 survey-head text-warning">Total Student</p>
                    <div class="d-flex justify-content-between align-items-end flot-bar-wrapper">
                      <div>
                        <h4 class="m-0 survey-value text-primary">{{ number_format($totalStudents + 25000) }}+</h4>
                        <p class="text-danger m-0">{{ $monthlyStudentAvg + 2000}} avg. PM</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-sm-4">
                <div class="card">
                  <div class="card-body py-3 px-4">
                    <p class="m-0 survey-head text-warning">Total Staff</p>
                    <div class="d-flex justify-content-between align-items-end flot-bar-wrapper">
                      <div>
                        <h4 class="m-0 survey-value text-primary">{{ number_format($totalStaff + 10000) }}+</h4>
                        <p class="text-success m-0">{{ $monthlyStaffAvg + 500}} avg. PM</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
     </div>
    </section><!-- End Skills Section -->

<section id="services" class="services section light-background">

  <div class="container section-title" data-aos="fade-up">
    <h2>Services</h2>
    <p>Streamline your school's operations with our comprehensive online portal. Manage admissions, fees, attendance, and grades efficiently. Enhance parent-teacher communication through real-time updates and messaging. Offer students easy access to assignments, resources, and performance data. Our portal improves administrative tasks, boosts parent engagement, and empowers students for academic success.</p>
  </div>

  <div class="container">

    <!-- Row 1: 3 cards -->
    <div class="row">
      <div class="col-md-4 d-flex align-items-stretch mt-4" data-aos="fade-up" data-aos-delay="100">
        <div class="service-item position-relative">
          <div class="icon"><i class="bi bi-mortarboard icon"></i></div>
          <h4><a href="" class="stretched-link">Student Information Management</a></h4>
          <p>Enrollment, attendance tracking, academic records, and communication with parents.</p>
        </div>
      </div>

      <div class="col-md-4 d-flex align-items-stretch mt-4" data-aos="fade-up" data-aos-delay="200">
        <div class="service-item position-relative">
          <div class="icon"><i class="bi bi-person-workspace icon"></i></div>
          <h4><a href="" class="stretched-link">Staff Management</a></h4>
          <p>Teacher schedules, payroll, performance evaluations, and professional development resources.</p>
        </div>
      </div>

      <div class="col-md-4 d-flex align-items-stretch mt-4" data-aos="fade-up" data-aos-delay="300">
        <div class="service-item position-relative">
          <div class="icon"><i class="bi bi-pencil-square icon"></i></div>
          <h4><a href="" class="stretched-link">Curriculum Management</a></h4>
          <p>Lesson plans, assignments, online resources, and assessment tools.</p>
        </div>
      </div>
    </div>

    <!-- Row 2: 4 cards -->
    <div class="row">
      <div class="col-md-4 d-flex align-items-stretch mt-4" data-aos="fade-up" data-aos-delay="400">
        <div class="service-item position-relative">
          <div class="icon"><i class="bi bi-coin icon"></i></div>
          <h4><a href="" class="stretched-link">Financial Management</a></h4>
          <p>Fee collection, invoicing, expense tracking, and budget reports.</p>
        </div>
      </div>

      <div class="col-md-4 d-flex align-items-stretch mt-4" data-aos="fade-up" data-aos-delay="450">
        <div class="service-item position-relative">
          <div class="icon"><i class="bi bi-people icon"></i></div>
          <h4><a href="" class="stretched-link">Communication Tools</a></h4>
          <p>Email, messaging, online forums, and parent portals.</p>
        </div>
      </div>

      <div class="col-md-4 d-flex align-items-stretch mt-4" data-aos="fade-up" data-aos-delay="500">
        <div class="service-item position-relative">
          <div class="icon"><i class="bi bi-bus-front icon"></i></div>
          <h4><a href="" class="stretched-link">Vehicle Management</a></h4>
          <p>In creating a vehicle management system for school, DiGi incorporated a comprehensive approach to efficiently manage vehicles, drivers, routes and timetables.</p>
        </div>
      </div>

    </div>

  </div>
</section>

    <!-- Call To Action Section -->
    <section id="call-to-action" class="call-to-action section dark-background">

      <img src="assets/img/register.png" alt="">

      <div class="container">

        <div class="row" data-aos="zoom-in" data-aos-delay="100">
          <div class="col-xl-9 text-center text-xl-start">
            <h3>Call To Action</h3>
            <p>लॉगिन और रजिस्टर या अन्य किसी आपातकालीन समस्या हो तो दिए गए बटन पर क्लिक करें.</p>
          </div>
          <div class="col-xl-3 cta-btn-container text-center">
            <a class="cta-btn align-middle" href="tel:+911234567890">Call To Action</a>
          </div>
        </div>

      </div>

    </section><!-- /Call To Action Section -->

    <!-- Team Section -->
    <section id="team" class="team section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Team</h2>
        <p>Our team is the heart of ScoolDiGi. We are a passionate group of individuals dedicated to ScoolDiGi. With a diverse range of expertise and a shared commitment to excellence, we strive to deliver exceptional services that exceed our clients' expectations.
We are committed to building strong relationships with our clients based on trust, transparency, and open communication. We look forward to working with you!</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <div class="team-member d-flex align-items-start">
              <div class="pic"><img src="assets/img/person/team.jpeg" class="img-fluid" alt=""></div>
              <div class="member-info">
                <h4>G. S. Pareek</h4>
                <span>Project Manager</span>
                <p>Oversees project planning, execution, and closure. Ensures goals are met within scope, time, and budget. Leads teams, manages risks, and communicates progress effectively.</p>
                <div class="social">
                  <a href=""><i class="bi bi-twitter-x"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""> <i class="bi bi-linkedin"></i> </a>
                </div>
              </div>
            </div>
          </div><!-- End Team Member -->

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
            <div class="team-member d-flex align-items-start">
              <div class="pic"><img src="assets/img/person/team2.jpeg" class="img-fluid" alt=""></div>
              <div class="member-info">
                <h4>Sandhya Pareek</h4>
                <span>CEO</span>
                <p>The highest-ranking executive of a company, responsible for overall operations and strategic direction.</p>
                <div class="social">
                  <a href=""><i class="bi bi-twitter-x"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""> <i class="bi bi-linkedin"></i> </a>
                </div>
              </div>
            </div>
          </div><!-- End Team Member -->
        </div>

      </div>

    </section><!-- /Team Section -->
    <!-- pricing -->
    <section id="pricing" class="pricing section light-background">

      <div class="container section-title" data-aos="fade-up">
        <h2>Pricing</h2>
        <p>Choose the plan that best suits your needs. Simple, transparent, and affordable.</p>
      </div>

      <div class="container">
        <div class="row gy-4">
          @foreach($plans->where('is_featured', 1) as $index => $plan)
            <div class="col-lg-4" data-aos="zoom-in" data-aos-delay="{{ ($index + 1) * 100 }}">
              <div class="pricing-item featured">
                <h2>{{ $plan->title }}<span></span></h2>
                <h4><sup>₹</sup>{{ $plan->price }}<span></span></h4>
                <ul>
                  <li><i class="bi bi-check"></i> <span>{{ $plan->duration }}</span></li>
                  @foreach($plan->features as $feature)
                    <li><i class="bi bi-check"></i> <span>{{ $feature }}</span></li>
                  @endforeach
                </ul>
                <a href="#" class="buy-btn">Get Started</a>
              </div>
            </div>
          @endforeach
        </div>
      </div>

    </section>
    <!-- /pricing -->
    <!-- Faq 2 Section -->
    <section id="faq-2" class="faq-2 section light-background">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Frequently Asked Questions</h2>
        <!-- <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p> -->
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row justify-content-center">

          <div class="col-lg-10">

            <div class="faq-container">

              <div class="faq-item faq-active" data-aos="fade-up" data-aos-delay="200">
                <i class="faq-icon bi bi-question-circle"></i>
                <h3>क्या इसमे छात्र लॉगिन कर सकते हैं?</h3>
                <div class="faq-content">
                  <p> हा इसमे छात्र लॉगिन कर सकते हैं|</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item" data-aos="fade-up" data-aos-delay="300">
                <i class="faq-icon bi bi-question-circle"></i>
                <h3>क्या इसमें माता-पिता लॉगिन कर सकते हैं?</h3>
                <div class="faq-content">
                  <p> हा इसमें माता-पिता लॉगिन कर सकते हैं|</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item" data-aos="fade-up" data-aos-delay="400">
                <i class="faq-icon bi bi-question-circle"></i>
                <h3>क्या इसमे शिक्षक छात्र की उपस्थिति लगाई जा सकती है?</h3>
                <div class="faq-content">
                  <p>हा शिक्षक छात्र की उपस्थिति लगा सकते हैं|</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item" data-aos="fade-up" data-aos-delay="500">
                <i class="faq-icon bi bi-question-circle"></i>
                <h3>क्या इसमे माता-पिता छात्र की उपस्थिति देख सकते हैं?</h3>
                <div class="faq-content">
                  <p>  हा पेरेंट्स स्टूडेंट की अटेंडेंस देख सकते हैं|</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

            </div>

          </div>

        </div>

      </div>

    </section><!-- /Faq 2 Section -->

    <!-- Contact Section -->
    <section id="contact" class="contact section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Contact</h2>
        <!-- <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p> -->
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <div class="col-lg-5">

            <div class="info-wrap">
              <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
                <i class="bi bi-geo-alt flex-shrink-0"></i>
                <div>
                  <h3>Address</h3>
                  <p>Anupgarh,Rajasthan</p>
                </div>
              </div><!-- End Info Item -->

              <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                <i class="bi bi-telephone flex-shrink-0"></i>
                <div>
                  <h3>Call Us</h3>
                  <p>+91 94602 05006</p>
                </div>
              </div><!-- End Info Item -->

              <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                <i class="bi bi-envelope flex-shrink-0"></i>
                <div>
                  <h3>Email Us</h3>
                  <p>helpschooldigi@gmail.com</p>
                </div>
              </div><!-- End Info Item -->

              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d27866.871802811394!2d73.18814977663322!3d29.1835565418527!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x393de46c27c25fc5%3A0x53f44bfc7dc7c8c0!2z4KSF4KSo4KWB4KSq4KSX4KSiLCDgpLDgpL7gpJzgpLjgpY3gpKXgpL7gpKggMzM1NzAx!5e0!3m2!1shi!2sin!4v1721988170665!5m2!1shi!2sin" frameborder="0" style="border:0; width: 100%; height: 270px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
          </div>

          <div class="col-lg-7">
            <form action="{{ url('/contact') }}" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
              @csrf
              <div class="row gy-4">

                <div class="col-md-6">
                  <label for="name-field" class="pb-2">Your Name</label>
                  <input type="text" name="name" id="name-field" class="form-control" required="">
                </div>

                <div class="col-md-6">
                  <label for="email-field" class="pb-2">Your Email</label>
                  <input type="email" class="form-control" name="email" id="email-field" required="">
                </div>

                <div class="col-md-12">
                  <label for="subject-field" class="pb-2">Subject</label>
                  <input type="text" class="form-control" name="subject" id="subject-field" required="">
                </div>

                <div class="col-md-12">
                  <label for="message-field" class="pb-2">Message</label>
                  <textarea class="form-control" name="message" rows="10" id="message-field" required=""></textarea>
                </div>

                <div class="col-md-12 text-center">
                  <div class="loading">Loading</div>
                  <div class="error-message"></div>
                  <div class="sent-message">Your message has been sent. Thank you!</div>

                  <button type="submit">Send Message</button>
                </div>

              </div>
            </form>
          </div><!-- End Contact Form -->
          <script>
          document.addEventListener("DOMContentLoaded", function () {
            const form = document.querySelector(".php-email-form");

            // Prevent other scripts from also submitting the form
            form.addEventListener("submit", async function (e) {
              e.preventDefault();

              const loading = form.querySelector(".loading");
              const errorMessage = form.querySelector(".error-message");
              const sentMessage = form.querySelector(".sent-message");

              // Clear all previous messages
              loading.style.display = "block";
              errorMessage.style.display = "none";
              sentMessage.style.display = "none";

              const formData = new FormData(form);

              try {
                const response = await fetch(form.action, {
                  method: "POST",
                  headers: {
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                  },
                  body: formData,
                });

                const data = await response.json();
                loading.style.display = "none";

                if (response.ok && data.success) {
                  sentMessage.textContent = data.success;
                  sentMessage.style.display = "block";
                  form.reset();
                } else {
                  errorMessage.textContent = "Something went wrong.";
                  errorMessage.style.display = "block";
                }
              } catch (error) {
                loading.style.display = "none";
                errorMessage.textContent = "There was an error sending the message.";
                errorMessage.style.display = "block";
              }
            });
          });
          </script>


        </div>

      </div>

    </section><!-- /Contact Section -->

  </main>

  <footer id="footer" class="footer">
<style>
  .footer-newsletter {
    background: #f9f9f9;
    padding: 50px 0;
    border-top: 1px solid #eaeaea;
  }

  .footer-newsletter h4 {
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 10px;
    color: #333;
  }

  .footer-newsletter p {
    font-size: 16px;
    color: #555;
    margin-bottom: 25px;
  }

  .newsletter-form {
    display: flex;
    justify-content: center;
  }

  .newsletter-form .btn {
    font-size: 16px;
    padding: 10px 30px;
    border-radius: 50px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: background-color 0.3s ease;
  }

  .newsletter-form .btn:hover {
    background-color: #128c7e;
  }
</style>

<div class="footer-newsletter">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8 text-center">
        <h4>Join Our WhatsApp Channel</h4>
        <p>Stay updated! Subscribe to our WhatsApp channel and receive the latest news directly on WhatsApp.</p>

        <div class="newsletter-form">
          <a href="https://whatsapp.com/channel/your_channel_id" target="_blank" class="btn btn-success rounded-pill">
            <i class="bi bi-whatsapp"></i> Join Now
          </a>
        </div>
      </div>
    </div>
  </div>
</div>




    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="/" class="d-flex align-items-center">
            <span class="sitename">School DiGi</span>
            <!-- <img src="assets1/images/logo1.png" alt=""> -->
          </a>
          <div class="footer-contact pt-3">
            <p>Anupgarh, Rajasthan</p>
            <p class="mt-3"><strong>Phone:</strong> <span>+91 94602 05006</span></p>
            <p><strong>Email:</strong> <span> helpschooldigi@gmail.com</span></p>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Useful Links</h4>
          <ul>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Home</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">About us</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Services</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Terms of service</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <!-- <h4>Our Services</h4>
          <ul>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Web Design</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Web Development</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Product Management</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Marketing</a></li>
          </ul> -->
        </div>

        <div class="col-lg-4 col-md-12">
          <h4>Follow Us</h4>
          <p>Stay Connected, Stay Updated – Follow SchoolDigi for Smarter Schooling!</p>
          <div class="social-links d-flex">
            <a href=""><i class="bi bi-twitter-x"></i></a>
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">SchoolDiGi</strong> <span>All Rights Reserved</span></p>
      <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Made by: Tejas IT Solutions with <i class="bi bi-heart text-danger"></i>
</span>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you've purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
        <!-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> -->
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- <script src="assets/vendor/php-email-form/validate.js"></script> -->
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>