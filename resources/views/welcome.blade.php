<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>ISI BURGER - Restaurant</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">

        <!-- Favicon -->
        <link href="{{ asset('template/img/favicon.ico') }}" rel="icon">

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Font Awesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

        <!-- Libraries Stylesheet -->
        <link href="{{ asset('template/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
        <link href="{{ asset('template/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />

        <!-- Customized Bootstrap Stylesheet -->
        <link href="{{ asset('template/css/style.css') }}" rel="stylesheet">

        <!-- Bootstrap CSS -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">

        <style>
            :root {
                --primary: #FF6B35;     /* Orange vif */
                --secondary: #2D3436;   /* Noir soft moderne */
                --light: #FFFFFF;
                --dark: #1E272E;
            }

            .bg-primary { background-color: var(--primary) !important; }
            .text-primary { color: var(--primary) !important; }
            .btn-primary {
                background-color: var(--primary);
                border-color: var(--primary);
                color: var(--light);
                transition: all 0.3s ease;
            }
            .btn-primary:hover {
                background-color: var(--secondary);
                border-color: var(--primary);
                color: var(--primary);
                transform: translateY(-2px);
            }
            
            .navbar {
                background-color: var(--light) !important;
                box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            }

            .section-overlay {
                background-color: var(--light);
                padding: 40px 0;
            }

            .section-overlay:nth-child(even) {
                background-color: #f8f9fa;
            }

            .team-item, .testimonial-text {
                background-color: var(--light) !important;
                transition: all 0.3s;
                box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            }

            .team-item:hover {
                transform: translateY(-10px);
                box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            }

            body {
                background-color: var(--light);
                color: var(--secondary);
            }

            /* Hero section avec background sombre */
            #header-carousel {
                background: linear-gradient(rgba(30, 39, 46, 0.8), rgba(30, 39, 46, 0.8)),
                            url('{{ asset('template/img/OIP.jpg') }}') center/cover no-repeat;
                height: 100vh;
                margin-bottom: 0;
            }

            .carousel-caption {
                background-color: rgba(0, 0, 0, 0.5);
                padding: 2rem;
                border-radius: 10px;
                max-width: 800px;
                margin: 0 auto;
            }

            .about-text {
                background-color: var(--light) !important;
                border-radius: 15px;
                box-shadow: 0 5px 20px rgba(0,0,0,0.05);
                margin-top: 1rem !important;
            }

            /* Styles modernes pour les sections */
            .section-title h6 {
                color: var(--primary);
                font-weight: 600;
                text-transform: uppercase;
                margin-bottom: 1rem;
            }

            .section-title h1 {
                color: var(--secondary);
                font-weight: 700;
                margin-bottom: 2rem;
            }

            /* Style moderne pour le formulaire de contact */
            .contact-form {
                background: rgba(255, 255, 255, 0.95);
                border-radius: 15px;
                box-shadow: 0 5px 20px rgba(0,0,0,0.2);
                padding: 30px;
            }

            .form-control {
                border: 1px solid rgba(0,0,0,0.1);
                padding: 1rem;
                border-radius: 8px;
            }

            .form-control:focus {
                border-color: var(--primary);
                box-shadow: 0 0 0 0.2rem rgba(255, 107, 53, 0.25);
            }

            /* Footer moderne */
            .footer {
                background-color: var(--secondary);
                color: var(--light);
                padding-top: 40px;
            }

            /* Responsive adjustments */
            @media (max-width: 768px) {
                #header-carousel {
                    height: 70vh;
                }
                
                .carousel-caption h1 {
                    font-size: 2rem;
                }
                .section-overlay {
                    padding: 30px 0;
                }
                
                .about-text {
                    margin-top: 1rem !important;
                }
            }

            /* Ajustement des marges pour les titres de section */
            .section-title {
                margin-bottom: 2rem;
            }

            /* Réduction de l'espace dans les cartes testimonials */
            .testimonial-text {
                padding: 20px !important;
            }

            /* Ajustement de l'espacement du footer */
            .footer {
                padding-top: 40px;
            }

            .container-fluid {
                padding-top: 0;
                padding-bottom: 0;
            }

            /* Modification des liens de la navbar */
            .navbar-nav .nav-link {
                color: var(--secondary) !important;
                transition: color 0.3s ease;
            }

            .navbar-nav .nav-link:hover,
            .navbar-nav .nav-link.active {
                color: var(--primary) !important;
            }

            /* Modification des éléments du footer */
            .footer .btn.btn-social {
                color: var(--light);
                border: 1px solid var(--light);
                transition: all 0.3s ease;
            }

            .footer .btn.btn-social:hover {
                color: var(--primary);
                border-color: var(--primary);
                transform: translateY(-3px);
            }

            /* Style pour le titre "SUIVEZ-NOUS" */
            .footer h5.text-white {
                color: var(--primary) !important;
                font-weight: 600;
            }

            /* Style pour le copyright */
            .footer .copyright {
                border-top: 1px solid rgba(255, 255, 255, 0.1);
            }

            .footer .copyright a {
                color: var(--primary);
                transition: color 0.3s ease;
            }

            .footer .copyright a:hover {
                color: var(--light);
                text-decoration: none;
            }

            /* Style pour les liens sociaux dans le footer */
            .footer .btn-outline-primary {
                border-color: var(--primary);
                color: var(--primary);
            }

            .footer .btn-outline-primary:hover {
                background-color: var(--primary);
                color: var(--light);
            }
        </style>
    </head>

    <body>
        <!-- Topbar Start -->
        <div class="container-fluid bg-light pt-3 d-none d-lg-block">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 text-center text-lg-left mb-2 mb-lg-0">
                        <div class="d-inline-flex align-items-center">
                            <p><i class="fa fa-envelope mr-2"></i>info@isiburger.com</p>
                            <p class="text-body px-3">|</p>
                            <p><i class="fa fa-phone-alt mr-2"></i>+221 77 123 45 67</p>
                        </div>
                    </div>
                    <div class="col-lg-6 text-center text-lg-right">
                        <div class="d-inline-flex align-items-center">
                            @guest
                                <a class="text-primary px-3" href="{{ route('login') }}">
                                    <i class="fa fa-user"></i> Connexion
                                </a>
                                <a class="text-primary px-3" href="{{ route('register') }}">
                                    <i class="fa fa-user-plus"></i> Inscription
                                </a>
                            @else
                                @if(auth()->user()->role === 'gestionnaire')
                                    <a class="text-primary px-3" href="{{ route('gestionnaire.dashboard') }}">
                                        <i class="fa fa-tachometer-alt"></i> Administration
                                    </a>
                                @else
                                    <a class="text-primary px-3" href="{{ route('client.dashboard') }}">
                                        <i class="fa fa-tachometer-alt"></i> Mon Compte
                                    </a>
                                @endif
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Topbar End -->

        <!-- Navbar Start -->
        <div class="container-fluid position-relative nav-bar p-0">
            <div class="container-lg position-relative p-0 px-lg-3" style="z-index: 9;">
                <nav class="navbar navbar-expand-lg navbar-light shadow-lg py-3 py-lg-0 pl-3 pl-lg-5">
                    <a href="" class="navbar-brand">
                        <h1 class="m-0"><span class="text-primary">ISI</span><span class="text-dark">BURGER</span></h1>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between px-3" id="navbarCollapse">
                        <div class="navbar-nav ml-auto py-0">
                            <a href="#" class="nav-item nav-link active">Accueil</a>
                            <a href="#about" class="nav-item nav-link">À propos</a>
                            <a href="#contact" class="nav-item nav-link">Contact</a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <!-- Navbar End -->

        <!-- Carousel Start -->
        <div class="container-fluid p-0">
            <div id="header-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="w-100" src="{{ asset('template/img/OIP.jpg') }}" alt="Image" style="height: 80vh; object-fit: cover; object-position: center;">
                        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                            <div class="p-3" style="max-width: 900px; background-color: rgba(0, 0, 0, 0.5); border-radius: 15px;">
                                <h4 class="text-white text-uppercase mb-md-3">Délicieux & Savoureux</h4>
                                <h1 class="display-3 text-white mb-md-4">Des Burgers Artisanaux</h1>
                                <a href="{{ route('catalogue.index') }}" class="btn btn-primary py-md-3 px-md-5 mt-2">Commander Maintenant</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Carousel End -->

        <!-- À propos Start -->
        <div class="container-fluid section-overlay" id="about">
            <div class="container pt-5">
                <div class="row">
                    <div class="col-lg-6" style="min-height: 500px;">
                        <div class="position-relative h-100">
                            <img class="position-absolute w-100 h-100" src="{{ asset('template/img/OIP.jpg') }}" 
                                 style="object-fit: contain; object-position: center; border-radius: 15px; background-color: #f8f9fa;">
                        </div>
                    </div>
                    <div class="col-lg-6 pt-5 pb-lg-5">
                        <div class="about-text bg-white p-4 p-lg-5 my-lg-5">
                            <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">À propos de nous</h6>
                            <h1 class="mb-3">Nous Servons Des Burgers Frais Et Délicieux</h1>
                            <p>Notre passion est de créer des burgers uniques avec des ingrédients frais et locaux.</p>
                            <div class="row mb-4">
                                <div class="col-6">
                                    <div style="height: 200px; overflow: hidden; border-radius: 15px;">
                                        <img class="img-fluid" src="{{ asset('template/img/OIP.jpg') }}" alt="" 
                                             style="width: 100%; height: 100%; object-fit: contain; background-color: #f8f9fa;">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div style="height: 200px; overflow: hidden; border-radius: 15px;">
                                        <img class="img-fluid" src="{{ asset('template/img/OIP.jpg') }}" alt="" 
                                             style="width: 100%; height: 100%; object-fit: contain; background-color: #f8f9fa;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- À propos End -->

        <!-- Team Start -->
        <div class="container-fluid section-overlay">
            <div class="container pt-5 pb-3">
                <div class="text-center mb-3 pb-3">
                    <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Notre Équipe</h6>
                    <h1>Rencontrez Notre Équipe</h1>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="team-item bg-white rounded overflow-hidden">
                            <div class="team-img position-relative overflow-hidden" style="height: 250px;">
                                <img class="img-fluid" src="{{ asset('template/img/OIP.jpg') }}" alt="" 
                                     style="width: 100%; height: 100%; object-fit: contain; background-color: #f8f9fa;">
                            </div>
                            <div class="text-center py-4">
                                <h5 class="text-truncate">John Doe</h5>
                                <p class="m-0">Chef Cuisinier</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="team-item bg-white rounded overflow-hidden">
                            <div class="team-img position-relative overflow-hidden" style="height: 250px;">
                                <img class="img-fluid" src="{{ asset('template/img/OIP.jpg') }}" alt="" 
                                     style="width: 100%; height: 100%; object-fit: contain; background-color: #f8f9fa;">
                            </div>
                            <div class="text-center py-4">
                                <h5 class="text-truncate">Jane Smith</h5>
                                <p class="m-0">Manager</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="team-item bg-white rounded overflow-hidden">
                            <div class="team-img position-relative overflow-hidden" style="height: 250px;">
                                <img class="img-fluid" src="{{ asset('template/img/OIP.jpg') }}" alt="" 
                                     style="width: 100%; height: 100%; object-fit: contain; background-color: #f8f9fa;">
                            </div>
                            <div class="text-center py-4">
                                <h5 class="text-truncate">Michel Faye</h5>
                                <p class="m-0">Chef de Service</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="team-item bg-white rounded overflow-hidden">
                            <div class="team-img position-relative overflow-hidden" style="height: 250px;">
                                <img class="img-fluid" src="{{ asset('template/img/OIP.jpg') }}" alt="" 
                                     style="width: 100%; height: 100%; object-fit: contain; background-color: #f8f9fa;">
                            </div>
                            <div class="text-center py-4">
                                <h5 class="text-truncate">Fatou Diallo</h5>
                                <p class="m-0">Responsable Qualité</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Team End -->

        <!-- Testimonial Start -->
        <div class="container-fluid section-overlay">
            <div class="container py-5">
                <div class="text-center mb-3 pb-3">
                    <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Témoignages</h6>
                    <h1>Ce Que Disent Nos Clients</h1>
                </div>
                <div class="owl-carousel testimonial-carousel">
                    <div class="text-center pb-4">
                        <img class="img-fluid mx-auto rounded-circle" src="{{ asset('template/img/testimonial-1.jpg') }}" style="width: 100px; height: 100px;">
                        <div class="testimonial-text bg-white p-4 mt-n5">
                            <p class="mt-5">Les meilleurs burgers que j'ai jamais mangés ! Le service est excellent et l'ambiance est parfaite.
                            </p>
                            <h5 class="text-truncate">Marie Diop</h5>
                            <span>Cliente Régulière</span>
                        </div>
                    </div>
                    <div class="text-center pb-4">
                        <img class="img-fluid mx-auto rounded-circle" src="{{ asset('template/img/testimonial-2.jpg') }}" style="width: 100px; height: 100px;">
                        <div class="testimonial-text bg-white p-4 mt-n5">
                            <p class="mt-5">La qualité des ingrédients est exceptionnelle. Je recommande vivement !
                            </p>
                            <h5 class="text-truncate">Omar Sall</h5>
                            <span>Client Fidèle</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Testimonial End -->

        <!-- Contact Start -->
        <div class="container-fluid section-overlay" id="contact">
            <div class="container py-5">
                <div class="text-center mb-3 pb-3">
                    <h6 class="text-primary text-uppercase" style="letter-spacing: 5px;">Contact</h6>
                    <h1>Contactez-nous</h1>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="contact-form bg-white" style="padding: 30px;">
                            <div id="success"></div>
                            <form name="sentMessage" id="contactForm" novalidate="novalidate">
                                <div class="form-row">
                                    <div class="control-group col-sm-6">
                                        <input type="text" class="form-control p-4" id="name" placeholder="Votre Nom"
                                            required="required" />
                                    </div>
                                    <div class="control-group col-sm-6">
                                        <input type="email" class="form-control p-4" id="email" placeholder="Votre Email"
                                            required="required" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <input type="text" class="form-control p-4" id="subject" placeholder="Sujet"
                                        required="required" />
                                </div>
                                <div class="control-group">
                                    <textarea class="form-control py-3 px-4" rows="5" id="message" placeholder="Message"
                                        required="required"></textarea>
                                </div>
                                <div class="text-center">
                                    <button class="btn btn-primary py-3 px-4" type="submit" id="sendMessageButton">Envoyer Message</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Contact End -->

        <!-- Footer Start -->
        <div class="container-fluid text-white-50 py-5 px-sm-3 px-lg-5" style="background-color: rgba(33, 37, 41, 0.9);">
            <div class="row pt-5">
                <div class="col-lg-4 col-md-6 mb-5">
                    <a href="" class="navbar-brand">
                        <h1 class="text-primary"><span class="text-white">ISI</span>BURGER</h1>
                    </a>
                    <p>Le meilleur burger de la ville</p>
                </div>
                <div class="col-lg-4 col-md-6 mb-5">
                    <h5 class="text-white text-uppercase mb-4" style="letter-spacing: 5px;">Nos Contacts</h5>
                    <p><i class="fa fa-map-marker-alt mr-2"></i>Dakar, Sénégal</p>
                    <p><i class="fa fa-phone-alt mr-2"></i>+221 77 123 45 67</p>
                    <p><i class="fa fa-envelope mr-2"></i>info@isiburger.com</p>
                </div>
                <div class="col-lg-4 col-md-6 mb-5">
                    <h5 class="text-white text-uppercase mb-4" style="letter-spacing: 5px;">Suivez-nous</h5>
                    <div class="d-flex justify-content-start">
                        <a class="btn btn-outline-primary btn-square mr-2" href="#"><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-primary btn-square mr-2" href="#"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-primary btn-square mr-2" href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a class="btn btn-outline-primary btn-square" href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid bg-dark text-white border-top py-4 px-sm-3 px-md-5" style="border-color: rgba(256, 256, 256, .1) !important;">
            <div class="row">
                <div class="col-lg-6 text-center text-md-left mb-3 mb-md-0">
                    <p class="m-0 text-white-50">Copyright &copy; <a href="#">ISI BURGER</a>. Tous droits réservés.</p>
                </div>
            </div>
        </div>
        <!-- Footer End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="fa fa-angle-double-up"></i></a>

        <!-- JavaScript Libraries -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
        <script src="{{ asset('template/lib/easing/easing.min.js') }}"></script>
        <script src="{{ asset('template/lib/owlcarousel/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('template/lib/tempusdominus/js/moment.min.js') }}"></script>
        <script src="{{ asset('template/lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
        <script src="{{ asset('template/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>

        <!-- Contact Javascript File -->
        <script src="{{ asset('template/mail/jqBootstrapValidation.min.js') }}"></script>
        <script src="{{ asset('template/mail/contact.js') }}"></script>

        <!-- Template Javascript -->
        <script src="{{ asset('template/js/main.js') }}"></script>

        <script>
            $(document).ready(function() {
                $(".testimonial-carousel").owlCarousel({
                    autoplay: true,
                    smartSpeed: 1500,
                    dots: true,
                    loop: true,
                    items: 1
                });
            });
        </script>
    </body>
</html>
