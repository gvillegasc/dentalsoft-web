<!-- 
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif -->

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DentalSoft</title>
  <meta name="description" content="Free Bootstrap Theme by BootstrapMade.com">
  <meta name="keywords" content="free website templates, free bootstrap themes, free template, free bootstrap, free website template">

  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans|Raleway|Candal">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/lpage/css/font-awesome.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/lpage/css/bootstrap.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/lpage/css/style.css') }}">
  <!-- =======================================================
    Theme Name: Medilab
    Theme URL: https://bootstrapmade.com/medilab-free-medical-bootstrap-theme/
    Author: BootstrapMade.com
    Author URL: https://bootstrapmade.com
  ======================================================= -->
</head>

<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">
  <!--banner-->
  <section id="banner" class="banner">
    <div class="bg-color">
      <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
          <div class="col-md-12">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                      </button>
              <a class="navbar-brand" href="#"><img src="assets/lpage/img/logoodontosoft200x80.png" class="img-responsive" style="width: 140px; margin-top: -16px;"></a>
            </div>
            <div class="collapse navbar-collapse navbar-right" id="myNavbar">
              <ul class="nav navbar-nav">
                <li class="active"><a href="#banner">Nosotros</a></li>
                <li class=""><a href="#service">Servicios</a></li>
                <li class=""><a href="#about">Acerca</a></li>
                <!-- <li class=""><a href="#testimonial">Testimonios</a></li> -->
                <li class=""><a href="#contact">Contacto</a></li>
                @if (Route::has('login'))
                    @auth
                        <li class=""><a href="{{ url('/home') }}">App</a></li>
                    @else
                        <li class=""><a href="{{ route('login') }}"><u>INICIAR SESIÓN</u></a></li>

                       <!--  @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif -->
                    @endauth
                @endif
              </ul>
            </div>
          </div>
        </div>
      </nav>
      <div class="container">
        <div class="row">
          <div class="banner-info">
            <div class="banner-logo text-center">
              <img src="assets/lpage/img/logoodontosoft200X80.png" class="img-responsive">
            </div>
            <div class="banner-text text-center">
              <h1 class="white">Software de Administración Dental</h1>
              <p>Ayuda a las centros dentales a optimizar cada aspecto de sus tareas administrativas y clínicas diarias, desde la agenda hasta el procesamiento de los tratamientos dentales, ahorrando tiempo y esfuerzo en tareas administrativas.</p>
              <a href="#contact" class="btn btn-appoint">Contáctenos</a>
            </div>
            <div class="overlay-detail text-center">
              <a href="#service"><i class="fa fa-angle-down"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--/ banner-->
  <!--service-->
  <section id="service" class="section-padding">
    <div class="container">
      <div class="row">
        <div class="col-md-4 col-sm-4">
          <h2 class="ser-title">Nuestros Servicios</h2>
          <hr class="botm-line">
          <p>Te ofrecemos un conjunto de herramientas que te ayuda a gestionar fácilmente tu consultorio en tiempo real, para que puedas enfocarte en lo que más te importa.</p>
        </div>
        <div class="col-md-4 col-sm-4">
          <div class="service-info">
            <div class="icon">
              <i class="fa fa-calendar"></i>
            </div>
            <div class="icon-info">
              <h4>Agenda</h4>
              <p>Consulta tu agenda en cualquier momento y lugar, escoge la vista y funcionalidad que más te acomoda, en una una vista conoce el estado de cita y financiero de cada uno de tus pacientes.</p>
            </div>
          </div>
          <div class="service-info">
            <div class="icon">
              <i class="fa fa-stethoscope"></i>
            </div>
            <div class="icon-info">
              <h4>Odontograma</h4>
              <p>Completo y fáciles de utilizar de una forma sencilla por los colores y símbolos que indican el estado de la pieza dental. Podrás visualmente identificar la evolución de tu paciente.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-4">
          <div class="service-info">
            <div class="icon">
              <i class="fa fa-dollar"></i>
            </div>
            <div class="icon-info">
              <h4>Presupuestos</h4>
              <p>Cómodo generador de presupuestos directamente desde el diagnóstico en el Odontograma. Puedes modificar y ajustar lo que el paciente necesite en su tratamiento.</p>
            </div>
          </div>
          <div class="service-info">
            <div class="icon">
              <i class="fa fa-list"></i>
            </div>
            <div class="icon-info">
              <h4>Reportes</h4>
              <p>Descarga tus propios reportes y realiza cálculos en excel, de forma ilimitada. Reportes de tratamientos, agenda, laboratorios , pacientes, finanzas, entre otros. Toda tu información, en tus manos.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--/ service-->
  <!--cta-->
  <!--<section id="cta-1" class="section-padding">
    <div class="container">
      <div class="row">
        <div class="schedule-tab">
          <div class="col-md-4 col-sm-4 bor-left">
            <div class="mt-boxy-color"></div>
            <div class="medi-info">
              <h3>Emergency Case</h3>
              <p>I am text block. Edit this text from Appearance / Customize / Homepage header columns. Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
              <a href="#" class="medi-info-btn">READ MORE</a>
            </div>
          </div>
          <div class="col-md-4 col-sm-4">
            <div class="medi-info">
              <h3>Emergency Case</h3>
              <p>I am text block. Edit this text from Appearance / Customize / Homepage header columns. Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
              <a href="#" class="medi-info-btn">READ MORE</a>
            </div>
          </div>
          <div class="col-md-4 col-sm-4 mt-boxy-3">
            <div class="mt-boxy-color"></div>
            <div class="time-info">
              <h3>Opening Hours</h3>
              <table style="margin: 8px 0px 0px;" border="1">
                <tbody>
                  <tr>
                    <td>Monday - Friday</td>
                    <td>8.00 - 17.00</td>
                  </tr>
                  <tr>
                    <td>Saturday</td>
                    <td>9.30 - 17.30</td>
                  </tr>
                  <tr>
                    <td>Sunday</td>
                    <td>9.30 - 15.00</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>-->
  <!--cta-->
  <!--about-->
  <section id="about" class="section-padding">
    <div class="container">
      <div class="row">
        <div class="col-md-3 col-sm-4 col-xs-12">
          <div class="section-title">
            <h2 class="head-title lg-line">ODONTO-SOFT</h2>
            <hr class="botm-line">
            <p class="sec-para">Soporte permanente y de verdad</p>
          </div>
        </div>
        <div class="col-md-9 col-sm-8 col-xs-12">
          <div style="visibility: visible;" class="col-sm-9 more-features-box">
            <div class="more-features-box-text">
              <div class="more-features-box-text-icon"> <i class="fa fa-angle-right" aria-hidden="true"></i> </div>
              <div class="more-features-box-text-description">
                <h3>Servicio Post-Venta.</h3>
                <p>Equipo de Postventa, que realizará seguimiento de forma proactiva, acompañándote en todo momento.</p>
              </div>
            </div>
            <div class="more-features-box-text">
              <div class="more-features-box-text-icon"> <i class="fa fa-angle-right" aria-hidden="true"></i> </div>
              <div class="more-features-box-text-description">
                <h3>Nuestro desempeño.</h3>
                <p>Contamos con un equipo de expertos que atenderán para siempre tus dudas a través de teléfono, correo o chat.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--/ about-->
  <!--doctor team-->
  <!-- <section id="doctor-team" class="section-padding">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h2 class="ser-title">Meet Our Doctors!</h2>
          <hr class="botm-line">
        </div>
        <div class="col-md-3 col-sm-3 col-xs-6">
          <div class="thumbnail">
            <img src="img/doctor1.jpg" alt="..." class="team-img">
            <div class="caption">
              <h3>Jessica Wally</h3>
              <p>Doctor</p>
              <ul class="list-inline">
                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-6">
          <div class="thumbnail">
            <img src="img/doctor2.jpg" alt="..." class="team-img">
            <div class="caption">
              <h3>Iai Donas</h3>
              <p>Doctor</p>
              <ul class="list-inline">
                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-6">
          <div class="thumbnail">
            <img src="img/doctor3.jpg" alt="..." class="team-img">
            <div class="caption">
              <h3>Amanda Denyl</h3>
              <p>Doctor</p>
              <ul class="list-inline">
                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-6">
          <div class="thumbnail">
            <img src="img/doctor4.jpg" alt="..." class="team-img">
            <div class="caption">
              <h3>Jason Davis</h3>
              <p>Doctor</p>
              <ul class="list-inline">
                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section> -->
  <!--/ doctor team-->
  <!--testimonial-->
  <!-- <section id="testimonial" class="section-padding">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h2 class="ser-title">see what patients are saying?</h2>
          <hr class="botm-line">
        </div>
        <div class="col-md-4 col-sm-4">
          <div class="testi-details">
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
          </div>
          <div class="testi-info">
            <a href="#"><img src="img/thumb.png" alt="" class="img-responsive"></a>
            <h3>Alex<span>Texas</span></h3>
          </div>
        </div>
        <div class="col-md-4 col-sm-4">
          <div class="testi-details">
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
          </div>
          <div class="testi-info">
            <a href="#"><img src="img/thumb.png" alt="" class="img-responsive"></a>
            <h3>Alex<span>Texas</span></h3>
          </div>
        </div>
        <div class="col-md-4 col-sm-4">
          <div class="testi-details">
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
          </div>
          <div class="testi-info">
            <a href="#"><img src="img/thumb.png" alt="" class="img-responsive"></a>
            <h3>Alex<span>Texas</span></h3>
          </div>
        </div>
      </div>
    </div>
  </section> -->
  <!--/ testimonial-->
  <!--cta 2-->
  <section id="cta-2" class="section-padding">
    <div class="container">
      <div class=" row">
        <div class="col-md-2"></div>
        <div class="text-right-md col-md-12 col-sm-4">
          <h2 class="section-title white lg-line">« "Somos el único software de odontología que cubre todas tus necesidades sin importar el tamaño de tu consultorio dental, sigue creciendo y sé el mejor en tu especialidad."»</h2>
        </div>
      </div>
    </div>
  </section>
  <!--cta-->
  <!--contact-->
  <section id="contact" class="section-padding">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h2 class="ser-title">Contáctenos</h2>
          <hr class="botm-line">
        </div>
        <div class="col-md-4 col-sm-4">
          <h3>Información de Contacto</h3>
          <div class="space"></div>
          <p><i class="fa fa-map-marker fa-fw pull-left fa-2x"></i>Calle Pumacahua<br> Miraflores</p>
          <div class="space"></div>
          <p><i class="fa fa-envelope-o fa-fw pull-left fa-2x"></i>shellsoluciones@gmail.com</p>
          <div class="space"></div>
          <p><i class="fa fa-phone fa-fw pull-left fa-2x"></i>963406983 - 955650476</p>
        </div>
        <div class="col-md-8 col-sm-8 marb20">
          <div class="contact-info">
            <h3 class="cnt-ttl">¡DÉJANOS TUS DATOS!</h3>
            <div class="space"></div>
            <div id="sendmessage">Your message has been sent. Thank you!</div>
            <div id="errormessage"></div>
            <form method="post" action="{{ url('/contacto') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="form-group">
                <input type="text" name="name" class="form-control br-radius-zero" id="name" placeholder="Tu Nombre" data-rule="minlen:4" data-msg="Por favor ingrese su nombre" />
                <div class="validation"></div>
              </div>
              <div class="form-group">
                <input type="email" class="form-control br-radius-zero" name="contacto_correo" id="email" placeholder="Tu Correo" data-rule="email" data-msg="Por favor ingrese un correo valido" />
                <div class="validation"></div>
              </div>
              <div class="form-group">
                <input type="text" class="form-control br-radius-zero" name="contacto_subject" id="subject" placeholder="Asunto" data-rule="minlen:4" data-msg="Por favor ingrese el asunto - mínimo 8 carácteres" />
                <div class="validation"></div>
              </div>
              <div class="form-group">
                <textarea class="form-control br-radius-zero" name="contacto_mensaje" rows="5" data-rule="required" data-msg="Por favor escriba su mensaje" placeholder="Message"></textarea>
                <div class="validation"></div>
              </div>

              <div class="form-action">
                <button type="submit" class="btn btn-form">Enviar Mensaje</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--/ contact-->
  <!--footer-->
  <footer id="footer">
    <div class="top-footer">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-sm-4 marb20">
            <div class="ftr-tle">
              <h4 class="white no-padding">Acerca de nosotros</h4>
            </div>
            <div class="info-sec">
              <p>Odonto-Soft es el software dental, que permite llevar la administración de clínicas/consultas dentales en cualquier momento y lugar.</p>
            </div>
          </div>
          <div class="col-md-6 col-sm-4 marb20">
            <div class="ftr-tle">
              <h4 class="white no-padding">Follow us</h4>
            </div>
            <div class="info-sec">
              <ul class="social-icon">
                <li class="bglight-blue"><i class="fa fa-facebook"></i></li>
                <li class="bgred"><i class="fa fa-google-plus"></i></li>
                <li class="bgdark-blue"><i class="fa fa-linkedin"></i></li>
                <li class="bglight-blue"><i class="fa fa-twitter"></i></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-line">
      <div class="container">
        <div class="row">
        </div>
      </div>
    </div>
  </footer>
  <!--/ footer-->

  <script src="{{ asset('assets/lpage/js/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/lpage/js/jquery.easing.min.js') }}"></script>
  <script src="{{ asset('assets/lpage/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/lpage/js/custom.js') }}"></script>
  <script src="{{ asset('assets/lpage/contactform/contactform.js') }}"></script>

</body>

</html>

