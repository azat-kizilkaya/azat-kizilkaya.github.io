<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Azat Kızılkaya | Web Geliştirici & Programcı</title>
    <meta name="description" content="Selçuk Üniversitesi Bilgisayar Programcılığı öğrencisi Azat Kızılkaya'nın kişisel web sayfası ve portföyü.">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Matrix Rain Background -->
    <canvas id="matrix"></canvas>

    <!-- Preloader -->
    <div id="preloader">
        <div class="loader-content">
            <span class="loader-text">Azat.dev</span>
        </div>
    </div>

    <!-- Custom Cursor -->
    <div class="cursor"></div>
    <div class="cursor2"></div>
    <!-- Particles Background -->
    <div id="particles-js"></div>

    <!-- Header / Navbar -->
    <header class="header">
        <a href="#" class="logo">Azat<span>.dev</span></a>
        
        <div class="bx bx-menu" id="menu-icon"><i class="fa-solid fa-bars"></i></div>

        <nav class="navbar">
            <a href="#home" class="active">Ana Sayfa</a>
            <a href="#about">Hakkımda</a>
            <a href="#skills">Yetenekler</a>
            <a href="#portfolio">Portföy</a>
            <a href="#blog">Blog</a>
            <a href="#contact">İletişim</a>

        </nav>
    </header>

    <!-- Home Section -->
    <section class="home" id="home">
        <div class="home-content">
            <h3>Merhaba, Ben</h3>
            <h1 data-text="Azat Kızılkaya">Azat Kızılkaya</h1>
            <h3>Ve Ben Bir <span class="multiple-text"></span></h3>
            <p>Selçuk Üniversitesi Bilgisayar Programcılığı 2. Sınıf Öğrencisi. Modern web teknolojileri ve yazılım geliştirme üzerine kendimi geliştiriyorum.</p>
            <div class="social-media">
                <a href="#"><i class="fa-brands fa-github"></i></a>
                <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                <a href="#"><i class="fa-brands fa-twitter"></i></a>
            </div>
            <a href="#" class="btn">CV İndir</a>
        </div>

        <div class="home-img">
            <!-- User Image will go here -->
            <div class="img-box">
                <img src="assets/img/azat.png" onerror="this.src='https://ui-avatars.com/api/?name=Azat+Kizilkaya&background=0ef&color=1f242d&size=512&font-size=0.35'" alt="Azat Kızılkaya">
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="about">
        <div class="about-img">
             <img src="assets/img/azat.png" alt="Azat Kızılkaya">
        </div>

        <div class="about-content">
            <h2 class="heading">Hakkımda <span>Kimim?</span></h2>
            <h3>Geleceğin Yazılımcısı</h3>
            <p>Merhaba! Ben Azat. <strong>2006 Kasım doğumluyum.</strong> Konya Selçuk Üniversitesi'nde Bilgisayar Programcılığı okuyorum. Teknolojiye olan tutkum beni sürekli yeni şeyler öğrenmeye ve projeler geliştirmeye itiyor. Web geliştirme dünyasında modern ve kullanıcı dostu arayüzler tasarlamaktan keyif alıyorum. Hedefim, sektörde iz bırakan bir Full Stack geliştirici olmak.</p>
            <a href="#contact" class="btn">İletişime Geç</a>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services" id="services">
        <h2 class="heading">Sunduğum <span>Hizmetler</span></h2>
        
        <div class="services-container">
            <div class="services-box">
                <i class="fa-solid fa-code"></i>
                <h3>Web Geliştirme</h3>
                <p>Modern teknolojiler (HTML, CSS, JS, PHP) ile hızlı, güvenli ve responsive web siteleri.</p>
                <a href="#" class="btn">İncele</a>
            </div>

            <div class="services-box">
                <i class="fa-solid fa-paintbrush"></i>
                <h3>UI/UX Tasarım</h3>
                <p>Kullanıcı dostu, estetik ve modern arayüz tasarımları ile benzersiz deneyimler.</p>
                <a href="#" class="btn">İncele</a>
            </div>

            <div class="services-box">
                <i class="fa-solid fa-rocket"></i>
                <h3>SEO & Optimizasyon</h3>
                <p>Web sitenizin arama motorlarında üst sıralarda yer alması için performans çalışması.</p>
                <a href="#" class="btn">İncele</a>
            </div>
        </div>
    </section>

    <!-- Skills Section -->
    <section class="skills" id="skills">
        <h2 class="heading">Yeteneklerim <span>& Becerilerim</span></h2>
        
        <!-- Tech Marquee -->
        <div class="tech-marquee">
            <div class="marquee-content">
                <i class="fa-brands fa-html5"></i>
                <i class="fa-brands fa-css3-alt"></i>
                <i class="fa-brands fa-js"></i>
                <i class="fa-brands fa-php"></i>
                <i class="fa-brands fa-laravel"></i>
                <i class="fa-brands fa-react"></i>
                <i class="fa-brands fa-git-alt"></i>
                <i class="fa-brands fa-github"></i>
                <i class="fa-brands fa-bootstrap"></i>
                <i class="fa-solid fa-database"></i>
                <!-- Duplicate for infinite loop -->
                <i class="fa-brands fa-html5"></i>
                <i class="fa-brands fa-css3-alt"></i>
                <i class="fa-brands fa-js"></i>
                <i class="fa-brands fa-php"></i>
                <i class="fa-brands fa-laravel"></i>
                <i class="fa-brands fa-react"></i>
                <i class="fa-brands fa-git-alt"></i>
                <i class="fa-brands fa-github"></i>
                <i class="fa-brands fa-bootstrap"></i>
                <i class="fa-solid fa-database"></i>
            </div>
        </div>
        
        <div class="skills-row">
            <div class="skills-column">
                <h3 class="title">Yazılım Dilleri</h3>

                <div class="skills-box">
                    <div class="skills-content">
                        <div class="progress">
                            <h3>HTML <span>90%</span></h3>
                            <div class="bar"><span></span></div>
                        </div>

                        <div class="progress">
                            <h3>CSS <span>85%</span></h3>
                            <div class="bar"><span></span></div>
                        </div>

                        <div class="progress">
                            <h3>JavaScript <span>70%</span></h3>
                            <div class="bar"><span></span></div>
                        </div>

                        <div class="progress">
                            <h3>PHP <span>75%</span></h3>
                            <div class="bar"><span></span></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="skills-column">
                <h3 class="title">Profesyonel Yetkinlikler</h3>

                <div class="skills-box">
                    <div class="skills-content">
                        <div class="progress">
                            <h3>Web Tasarım <span>80%</span></h3>
                            <div class="bar"><span></span></div>
                        </div>

                        <div class="progress">
                            <h3>Web Geliştirme <span>85%</span></h3>
                            <div class="bar"><span></span></div>
                        </div>

                        <div class="progress">
                            <h3>Problem Çözme <span>90%</span></h3>
                            <div class="bar"><span></span></div>
                        </div>

                        <div class="progress">
                            <h3>Takım Çalışması <span>95%</span></h3>
                            <div class="bar"><span></span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Experience Timeline Section -->
    <section class="experience" id="experience">
        <h2 class="heading">Eğitim & <span>Deneyim</span></h2>
        
        <div class="timeline">
            <div class="container left-container">
                <div class="text-box">
                    <h2>Selçuk Üniversitesi</h2>
                    <small>2024 - Günümüz</small>
                    <p>Bilgisayar Programcılığı / Ön Lisans<br>Modern web teknolojileri ve yazılım geliştirme üzerine eğitim almaktayım.</p>
                    <span class="left-container-arrow"></span>
                </div>
            </div>
            
            <div class="container right-container">
                <div class="text-box">
                    <h2>Lise Eğitimi</h2>
                    <small>2020 - 2024</small>
                    <p>Bilişim Teknolojileri Alanı<br>Temel programlama ve web tasarım temelleri.</p>
                    <span class="right-container-arrow"></span>
                </div>
            </div>
             <div class="container left-container">
                <div class="text-box">
                    <h2>Freelance Geliştirici</h2>
                    <small>2023 - Günümüz</small>
                    <p>Çeşitli web projeleri ve kişisel portföy çalışmaları.<br>PHP, JS, CSS odaklı geliştirmeler.</p>
                    <span class="left-container-arrow"></span>
                </div>
            </div>
        </div>
    </section>

    </section>

    <!-- Fun Facts / Stats Section -->
    <section class="stats" id="stats">
        <div class="stats-container">
            <div class="stats-box">
                <i class="fa-solid fa-diagram-project"></i>
                <h3 class="counter" data-target="15">0</h3>
                <p>Tamamlanan Proje</p>
            </div>
            <div class="stats-box">
                <i class="fa-solid fa-code"></i>
                <h3 class="counter" data-target="5000">0</h3>
                <p>Satır Kod</p>
            </div>
            <div class="stats-box">
                <i class="fa-solid fa-mug-hot"></i>
                <h3 class="counter" data-target="150">0</h3>
                <p>Bardak Kahve</p>
            </div>
            <div class="stats-box">
                <i class="fa-regular fa-clock"></i>
                <h3 class="counter" data-target="2">0</h3>
                <p>Yıl Deneyim</p>
            </div>
        </div>
    </section>

    <!-- Portfolio Section -->
    <section class="portfolio" id="portfolio">
        <h2 class="heading">Son <span>Projelerim</span></h2>

        <!-- Project Filter -->
        <div class="portfolio-filter">
            <button class="filter-btn active" data-filter="all">Tümü</button>
            <button class="filter-btn" data-filter="web">Web</button>
            <button class="filter-btn" data-filter="app">Uygulama</button>
            <button class="filter-btn" data-filter="design">Tasarım</button>
        </div>

        <div class="portfolio-container">
            <!-- Project 1: Forsy Giyim -->
            <div class="portfolio-box" data-category="web">
                <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?q=80&w=800&auto=format&fit=crop" alt="Forsy Giyim">
                <div class="portfolio-layer">
                    <h4>Forsy Giyim</h4>
                    <p>Kategori bazlı ürün filtreleme ve sepet sistemine sahip dinamik e-ticaret sitesi.</p>
                    <a href="#"><i class="fa-solid fa-store"></i></a>
                </div>
            </div>

            <!-- Project 2: Vonn Cafe -->
            <div class="portfolio-box" data-category="design">
                <img src="https://images.unsplash.com/photo-1554118811-1e0d58224f24?q=80&w=800&auto=format&fit=crop" alt="Vonn Cafe">
                <div class="portfolio-layer">
                    <h4>Vonn Cafe QR</h4>
                    <p>Kafe müşterileri için geliştirilmiş, görsel odaklı interaktif dijital menü sistemi.</p>
                    <a href="#"><i class="fa-solid fa-qrcode"></i></a>
                </div>
            </div>

            <!-- Project 3: Azat.dev -->
            <div class="portfolio-box" data-category="web">
                <img src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?q=80&w=800&auto=format&fit=crop" alt="Kişisel Portföy">
                <div class="portfolio-layer">
                    <h4>Azat.dev</h4>
                    <p>High-End animasyonlar ve modern UI teknikleri ile hazırladığım kişisel portföy.</p>
                    <a href="#"><i class="fa-solid fa-code"></i></a>
                </div>
            </div>
        </div>
    </section>



    <!-- Blog Section -->
    <section class="blog" id="blog">
        <h2 class="heading">Blog <span>Yazılarım</span></h2>
        
        <div class="blog-container">
            <div class="blog-box coming-soon">
                <div class="blog-content" style="text-align: center; padding: 4rem;">
                    <i class="fa-solid fa-hourglass-half" style="font-size: 4rem; color: var(--main-color); margin-bottom: 2rem;"></i>
                    <h3>Çok Yakında!</h3>
                    <p>Teknoloji, yazılım ve deneyimlerimi paylaşacağım blog sayfam hazırlanıyor. Takipte kalın!</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact" id="contact">
        <h2 class="heading">İletişime <span>Geç!</span></h2>

        <form action="#">
            <div class="input-box">
                <input type="text" placeholder="Adınız Soyadınız">
                <input type="email" placeholder="Email Adresiniz">
            </div>
            <div class="input-box">
                <input type="number" placeholder="Telefon Numaranız">
                <input type="text" placeholder="Konu">
            </div>
            <textarea name="" id="" cols="30" rows="10" placeholder="Mesajınız"></textarea>
            <input type="submit" value="Mesaj Gönder" class="btn">
        </form>
    </section>

    <!-- Floating Theme Toggle -->
    <div class="theme-switch-wrapper floating-theme-toggle">
        <label class="theme-switch" for="checkbox">
            <input type="checkbox" id="checkbox" />
            <div class="slider round">
                <i class="fa-solid fa-sun"></i>
                <i class="fa-solid fa-moon"></i>
            </div>
        </label>
    </div>

    <!-- Chatbot Widget -->
    <div class="chatbot-toggler">
        <span class="material-symbols-rounded"><i class="fa-regular fa-comment-dots"></i></span>
        <span class="material-symbols-outlined"><i class="fa-solid fa-xmark"></i></span>
    </div>
    <div class="chatbot">
        <header>
            <h2>Asistan</h2>
            <span class="close-btn material-symbols-outlined"><i class="fa-solid fa-xmark"></i></span>
        </header>
        <ul class="chatbox">
            <li class="chat incoming">
                <span class="material-symbols-outlined"><i class="fa-solid fa-robot"></i></span>
                <p>Merhaba 👋<br>Ben Azat'ın sanal asistanıyım. Size nasıl yardımcı olabilirim?</p>
            </li>
        </ul>
        <div class="chat-input">
            <textarea placeholder="Bir mesaj yazın..." spellcheck="false" required></textarea>
            <span id="send-btn" class="material-symbols-rounded"><i class="fa-solid fa-paper-plane"></i></span>
        </div>
    </div>

    <!-- Scroll Progress Bar -->
    <div class="scroll-progress-container">
        <div class="scroll-progress-bar" id="myBar"></div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-text">
            <p>Copyright &copy; 2026 by Azat Kızılkaya | Tüm Hakları Saklıdır.</p>
        </div>

        <div class="footer-iconTop">
            <a href="#home"><i class="fa-solid fa-angle-up"></i></a>
        </div>
    </footer>

    <!-- Bottom Dock Menu -->
    <div class="dock-container">
        <div class="dock">
            <div class="dock-item" onclick="location.href='#home'">
                <i class="fa-solid fa-house"></i>
                <span class="dock-tooltip">Ana Sayfa</span>
            </div>
            <div class="dock-item" onclick="location.href='#about'">
                <i class="fa-solid fa-user"></i>
                <span class="dock-tooltip">Hakkımda</span>
            </div>
            <div class="dock-item" onclick="location.href='#skills'">
                <i class="fa-solid fa-code"></i>
                <span class="dock-tooltip">Yetenekler</span>
            </div>
            <div class="dock-item" onclick="location.href='#experience'">
                <i class="fa-solid fa-briefcase"></i>
                <span class="dock-tooltip">Deneyim</span>
            </div>
            <div class="dock-item" onclick="location.href='#portfolio'">
                <i class="fa-solid fa-layer-group"></i>
                <span class="dock-tooltip">Portföy</span>
            </div>
            <div class="dock-item" onclick="location.href='#blog'">
                <i class="fa-solid fa-pen-nib"></i>
                <span class="dock-tooltip">Blog</span>
            </div>
             <div class="dock-item" onclick="location.href='#contact'">
                <i class="fa-solid fa-envelope"></i>
                <span class="dock-tooltip">İletişim</span>
            </div>
        </div>
    </div>

    <!-- Particles.js -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>

    <!-- Scroll Reveal -->
    <script src="https://unpkg.com/scrollreveal"></script>
    
    <!-- Typed JS -->
    <script src="https://unpkg.com/typed.js@2.0.16/dist/typed.umd.js"></script>

    <!-- Custom JS -->
    <script src="assets/js/script.js"></script>

    <!-- Vanilla Tilt JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.7.0/vanilla-tilt.min.js"></script>
    <script>
        VanillaTilt.init(document.querySelectorAll(".portfolio-box, .skills-box, .blog-box, .about-img"), {
            max: 15,
            speed: 400,
            glare: true,
            "max-glare": 0.2
        });
    </script>
</body>
</html>
