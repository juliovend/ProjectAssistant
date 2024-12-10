<?php
header("Content-Type: text/html; charset=UTF-8");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <base href="." />
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Rejoignez des milliers d'utilisateurs qui optimisent leurs projets avec Project Assistant, l'outil gratuit de gestion de projet en ligne." />
    <meta name="keywords" content="gestion de projet, collaboratif, gratuit, en ligne, productivité, Project Assistant" />
    <title>Project Assistant - L'outil gratuit de gestion de projet</title>
    <style>
        :root {
          --primary: #6C63FF;
          --secondary: #2A2D3E;
          --accent: #00F5FF;
          --dark: #1A1C2C;
          --light: #F5F5F7;
        }

        * {
          margin: 0;
          padding: 0;
          box-sizing: border-box;
          font-family: 'Inter', sans-serif;
        }

        body {
          background: var(--dark);
          color: var(--light);
          min-height: 100vh;
          overflow-x: hidden;
          position: relative;
        }

        /* Header */
        header {
          width: 100%;
          background: var(--dark);
          padding: 1rem 2rem;
          display: flex;
          align-items: center;
          justify-content: space-between;
          position: relative;
          z-index: 10;
        }

        header .logo {
          display: flex;
          align-items: center;
          gap: 1rem;
        }

        header nav a {
          color: var(--light);
          text-decoration: none;
          font-weight: 600;
        }

        header nav {
          display: flex;
          gap: 2rem;
          align-items: center;
        }

        /* Buttons */
        .btn {
          padding: 0.8rem 1.5rem;
          border-radius: 50px;
          border: none;
          font-size: 1rem;
          font-weight: 600;
          cursor: pointer;
          transition: all 0.3s ease;
        }

        .btn-primary {
          background: var(--primary);
          color: white;
          box-shadow: 0 0 20px rgba(108, 99, 255, 0.3);
        }

        .btn-primary:hover {
          transform: translateY(-2px);
          box-shadow: 0 0 30px rgba(108, 99, 255, 0.5);
        }

        .btn-secondary {
          background: transparent;
          border: 2px solid var(--primary);
          color: var(--primary);
        }

        .btn-secondary:hover {
          background: var(--primary);
          color: white;
        }

        /* Hero Section */
        #hero {
          display: flex;
          align-items: center;
          justify-content: space-between;
          padding: 4rem 2rem;
          max-width: 1400px;
          margin: 0 auto;
          min-height: 100vh;
        }

        #hero h1 {
          font-size: 3rem;
          background: linear-gradient(135deg, var(--primary), var(--accent));
          -webkit-background-clip: text;
          -webkit-text-fill-color: transparent;
          margin-bottom: 1rem;
        }

        #hero p {
          font-size: 1.2rem;
          line-height: 1.6;
          margin-bottom: 2rem;
        }

        .illustration {
          flex: 1;
          display: flex;
          justify-content: center;
          align-items: center;
          border-radius: 20px;       /* Bords arrondis */
          overflow: hidden;          /* Coupe la vidéo pour suivre la forme arrondie */
          box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3); /* Ombre douce pour donner de la profondeur */
        }

        .illustration video {
          width: 100%;
          height: auto;
        }

        .app-logo {
          animation: pulse 2s infinite ease-in-out;
          width: 50px;
          height: 50px;
        }

        .app-logo:hover {
            animation: rotate 1s infinite linear;
        }

        @keyframes pulse {
          0% { transform: scale(1); }
          50% { transform: scale(1.05); }
          100% { transform: scale(1); }
        }

        @keyframes rotate {
          0% { transform: rotate(0deg); }
          100% { transform: rotate(360deg); }
        }

        .floating {
          animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
          0% { transform: translateY(0px); }
          50% { transform: translateY(-20px); }
          100% { transform: translateY(0px); }
        }

        /* Features Section */
        #features {
          padding: 4rem 2rem;
          max-width: 1400px;
          margin: 0 auto;
          text-align: center;
        }

        #features h2 {
          font-size: 2rem;
          margin-bottom: 2rem;
        }

        #features .feature-container {
          display: flex;
          flex-wrap: wrap;
          gap: 2rem;
          justify-content: center;
        }

        #features .feature-box {
          background: var(--secondary);
          padding: 2rem;
          border-radius: 10px;
          max-width: 300px;
          text-align: center;
        }

        #features .feature-box h3 {
          margin-bottom: 1rem;
          font-size: 1.5rem;
        }

        #features .feature-box p {
          font-size: 1rem;
          line-height: 1.4;
        }

        /* How it works Section */
        #how-it-works {
          padding: 4rem 2rem;
          max-width: 1400px;
          margin: 0 auto;
          text-align: center;
        }

        #how-it-works h2 {
          font-size: 2rem;
          margin-bottom: 2rem;
        }

        #how-it-works .steps {
          display: flex;
          flex-wrap: wrap;
          gap: 2rem;
          justify-content: center;
        }

        #how-it-works .step {
          max-width: 300px;
        }

        #how-it-works .step h3 {
          margin-bottom: 1rem;
          font-size: 1.4rem;
        }

        #how-it-works .step p {
          font-size: 1rem;
          line-height: 1.4;
        }

        /* Pricing Section */
        #pricing {
          padding: 4rem 2rem;
          max-width: 1400px;
          margin: 0 auto;
          text-align: center;
        }

        #pricing h2 {
          font-size: 2rem;
          margin-bottom: 2rem;
        }

        #pricing p {
          font-size: 1.2rem;
          line-height: 1.6;
          max-width: 600px;
          margin: 0 auto 2rem auto;
        }

        /* CTA Final */
        #cta-final {
          padding: 4rem 2rem;
          max-width: 1400px;
          margin: 0 auto;
          text-align: center;
        }

        #cta-final h2 {
          font-size: 2rem;
          margin-bottom: 2rem;
        }

        #cta-final p {
          font-size: 1.2rem;
          line-height: 1.6;
          max-width: 600px;
          margin: 0 auto 2rem auto;
        }

        /* Footer */
        footer {
          background: var(--secondary);
          color: var(--light);
          padding: 2rem;
          text-align: center;
        }

        footer a {
          color: var(--light);
          text-decoration: none;
        }

        footer a:hover {
          text-decoration: underline;
        }

        /* Modals */
        .modal {
          display: none;
          position: fixed;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          background: rgba(26, 28, 44, 0.9);
          z-index: 1000;
          justify-content: center;
          align-items: center;
        }

        .modal.active {
          display: flex;
        }

        .login-form, .signup-form {
          background: var(--secondary);
          padding: 2rem;
          border-radius: 20px;
          width: 100%;
          max-width: 400px;
          position: relative;
          box-shadow: 0 0 40px rgba(108, 99, 255, 0.2);
        }

        .login-form h2, .signup-form h2 {
          margin-bottom: 1.5rem;
          color: var(--light);
          text-align: center;
        }

        .form-group {
          margin-bottom: 1.5rem;
        }

        .form-group label {
          display: block;
          margin-bottom: 0.5rem;
          color: var(--light);
        }

        .form-group input {
          width: 100%;
          padding: 0.8rem;
          border: 2px solid var(--primary);
          background: var(--dark);
          border-radius: 10px;
          color: var(--light);
          font-size: 1rem;
        }

        .form-group input:focus {
          outline: none;
          border-color: var(--accent);
        }

        .close-btn {
          position: absolute;
          top: 1rem;
          right: 1rem;
          background: none;
          border: none;
          color: var(--light);
          font-size: 1.5rem;
          cursor: pointer;
        }

        .close-btn:hover {
          color: var(--accent);
        }

        /* Responsivité */
        @media (max-width: 768px) {
          #hero {
            flex-direction: column;
            text-align: center;
          }

          .illustration {
            margin-top: 2rem;
          }

          #hero h1 {
            font-size: 2.5rem;
          }

          header nav {
            gap:1rem;
          }
        }

        @media (max-width: 480px) {
          #hero h1 {
            font-size: 2rem;
          }

          #hero p {
            font-size: 1rem;
          }

          .btn {
            font-size: 0.9rem;
            padding: 0.8rem 1.5rem;
          }
        }

        .particles {
          position: fixed;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          z-index: -1;
        }

    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Fond de particules -->
    <div id="particles" class="particles"></div>

    <!-- Header -->
    <header>
        <div class="logo">
            <svg class="app-logo" viewBox="0 0 100 100">
                <defs>
                    <linearGradient id="logoGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:#1a75ff" />
                        <stop offset="100%" style="stop-color:#0044cc" />
                    </linearGradient>
                </defs>
                <circle cx="50" cy="50" r="45" fill="none" stroke="url(#logoGradient)" stroke-width="2" />
                <circle cx="30" cy="30" r="8" fill="url(#logoGradient)" />
                <circle cx="70" cy="30" r="8" fill="url(#logoGradient)" />
                <circle cx="50" cy="50" r="8" fill="url(#logoGradient)" />
                <circle cx="30" cy="70" r="8" fill="url(#logoGradient)" />
                <circle cx="70" cy="70" r="8" fill="url(#logoGradient)" />
                <path d="M30 30 L70 30 L50 50 L70 70 L30 70" fill="none" stroke="#4d94ff" stroke-width="3" stroke-dasharray="4,2" />
                <animate attributeName="stroke-width" values="2;3;2" dur="2s" repeatCount="indefinite" />
            </svg>
            <span style="font-weight:700; font-size:1.2rem; color:var(--light);">Project Assistant</span>
        </div>
        <nav>
            <a href="#features">Fonctionnalités</a>
            <a href="#how-it-works">Comment ça marche</a>
            <a href="#pricing">Tarifs</a>
            <button class="btn btn-secondary" id="loginBtn">Se connecter</button>
            <button class="btn btn-primary" id="signupBtn">Créer un compte</button>
        </nav>
    </header>

    <!-- Hero Section -->
    <section id="hero">
        <div style="flex:1;max-width:600px;">
            <h1>Pilotez vos projets, maîtrisez votre budget, sans complexité.</h1>
            <p>Project Assistant est un outil intuitif qui vous aide à organiser vos tâches, suivre votre charge de travail et garder un œil sur vos dépenses. Transformez vos idées en projets aboutis, facilement.</p>
            <button class="btn btn-primary" onclick="document.getElementById('signupModal').classList.add('active')">Essayer gratuitement</button>
        </div>
        <div class="illustration" style="flex:1;display:flex;justify-content:center;align-items:center;">
          <video width="600" autoplay loop muted playsinline>
            <source src="/data/Video_Accueil.mp4" type="video/mp4" />
            Votre navigateur ne supporte pas la vidéo HTML5.
          </video>
        </div>
    </section>

    <!-- Fonctionnalités Clés -->
    <section id="features">
        <h2>Fonctionnalités Clés</h2>
        <div class="feature-container">
            <div class="feature-box">
                <h3>Organisation Simplifiée</h3>
                <p>Définissez des lots de travail, des priorités, et suivez l'avancement en un coup d'œil.</p>
            </div>
            <div class="feature-box">
                <h3>Suivi du Budget</h3>
                <p>Gardez le contrôle sur vos dépenses et ajustez vos prévisions en temps réel.</p>
            </div>
            <div class="feature-box">
                <h3>Visualisation de la Charge</h3>
                <p>Anticipez la charge à venir et priorisez les tâches intelligemment.</p>
            </div>
            <div class="feature-box">
                <h3>Interface Intuitive</h3>
                <p>Aucune formation compliquée. Prenez en main l'outil en quelques minutes.</p>
            </div>
        </div>
    </section>

    <!-- Comment ça marche ? -->
    <section id="how-it-works">
        <h2>Comment ça marche ?</h2>
        <div class="steps">
            <div class="step">
                <h3>1. Créez votre projet</h3>
                <p>Ajoutez vos tâches, estimez la charge et définissez un budget.</p>
            </div>
            <div class="step">
                <h3>2. Suivez l'avancement</h3>
                <p>Consultez l'état de chaque lot de travail, les dépenses et le temps investi.</p>
            </div>
            <div class="step">
                <h3>3. Ajustez et finalisez</h3>
                <p>Modifiez, optimisez, et menez votre projet à son terme, en toute simplicité.</p>
            </div>
        </div>
    </section>

    <!-- Tarifs -->
    <section id="pricing">
        <h2>Tarification</h2>
        <p>Project Assistant est 100% gratuit, sans frais cachés. Créez votre compte et commencez dès maintenant !</p>
        <button class="btn btn-primary" onclick="document.getElementById('signupModal').classList.add('active')">Créer un compte gratuit</button>
    </section>

    <!-- CTA Final -->
    <section id="cta-final">
        <h2>Prêt à optimiser vos projets ?</h2>
        <p>Rejoignez dès maintenant une communauté d'utilisateurs qui simplifient leur gestion de projet avec Project Assistant.</p>
        <button class="btn btn-primary" onclick="document.getElementById('signupModal').classList.add('active')">Commencer gratuitement</button>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Project Assistant - Tous droits réservés.</p>
        <p>
            <a href="#">A propos</a> | 
            <a href="#">Contact</a> | 
            <a href="#">Conditions</a> | 
            <a href="#">Politique de confidentialité</a>
        </p>
    </footer>

    <!-- Modal Connexion -->
    <div class="modal" id="loginModal">
      <div class="login-form">
        <button class="close-btn" id="closeModal">&times;</button>
        <h2>Connexion</h2>
        <form id="loginForm">
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" required>
          </div>
          <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" required>
          </div>
          <button type="submit" class="btn btn-primary" style="width: 100%">Se connecter</button>
        </form>
      </div>
    </div>

    <!-- Modal Inscription -->
    <div class="modal" id="signupModal">
      <div class="signup-form">
        <button class="close-btn" id="closeSignupModal">&times;</button>
        <h2>Créer un compte</h2>
        <form id="signupForm">
          <div class="form-group">
            <label for="fullName">Nom complet</label>
            <input type="text" id="fullName" required>
          </div>
          <div class="form-group">
            <label for="signupEmail">Email</label>
            <input type="email" id="signupEmail" required>
          </div>
          <div class="form-group">
            <label for="signupPassword">Mot de passe</label>
            <input type="password" id="signupPassword" required>
          </div>
          <div class="form-group">
            <label for="confirmPassword">Confirmer le mot de passe</label>
            <input type="password" id="confirmPassword" required>
          </div>
          <button type="submit" class="btn btn-primary" style="width: 100%">Créer mon compte</button>
        </form>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
        particlesJS('particles', {
          particles: {
            number: {
              value: 80,
              density: {
                enable: true,
                value_area: 800
              }
            },
            color: { value: '#6C63FF' },
            shape: { type: 'circle' },
            opacity: { value: 0.5, random: false },
            size: { value: 3, random: true },
            line_linked: {
              enable: true,
              distance: 150,
              color: '#6C63FF',
              opacity: 0.4,
              width: 1
            },
            move: {
              enable: true,
              speed: 2,
              direction: 'none',
              random: false,
              straight: false,
              out_mode: 'out',
              bounce: false
            }
          },
          interactivity: {
            detect_on: 'canvas',
            events: {
              onhover: { enable: true, mode: 'repulse' },
              resize: true
            }
          },
          retina_detect: true
        });

        // Ouverture modale login
        document.getElementById('loginBtn').addEventListener('click', () => {
          document.getElementById('loginModal').classList.add('active');
        });

        // Ouverture modale signup via bouton header
        document.getElementById('signupBtn').addEventListener('click', () => {
          document.getElementById('signupModal').classList.add('active');
        });

        // Fermeture modales
        document.getElementById('closeModal').addEventListener('click', () => {
          document.getElementById('loginModal').classList.remove('active');
        });

        document.getElementById('closeSignupModal').addEventListener('click', () => {
          document.getElementById('signupModal').classList.remove('active');
        });

        // Connexion
        document.getElementById('loginForm').addEventListener('submit', (e) => {
          e.preventDefault();
          const email = document.getElementById('email').value;
          const password = document.getElementById('password').value;

          fetch('connexion.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify({ email, password }),
          })
            .then(response => {
              if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
              }
              return response.json();
            })
            .then(data => {
              if (data.success) {
                window.location.href = data.redirect;
              } else {
                alert("Échec de la connexion : " + data.message);
              }
            })
            .catch(error => {
              console.error('Erreur lors de la connexion:', error);
              alert('Une erreur est survenue lors de la connexion');
            });
        });

        // Inscription
        document.getElementById('signupForm').addEventListener('submit', (e) => {
          e.preventDefault();
          const fullName = document.getElementById('fullName').value;
          const email = document.getElementById('signupEmail').value;
          const password = document.getElementById('signupPassword').value;
          const confirmPassword = document.getElementById('confirmPassword').value;

          if (password !== confirmPassword) {
            alert('Les mots de passe ne correspondent pas');
            return;
          }

          fetch('signup.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify({ fullName, email, password }),
          })
            .then(response => {
              if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
              }
              return response.json();
            })
            .then(data => {
              if (data.success) {
                alert("Compte créé avec succès ! Vérifiez votre email pour confirmer votre inscription.");
                document.getElementById('signupModal').classList.remove('active');
              } else {
                alert("Échec de la création du compte : " + data.message);
              }
            })
            .catch(error => {
              console.error('Erreur lors de la création du compte:', error);
              alert('Une erreur est survenue lors de la création du compte');
            });
        });

        // Fermer modale quand on clique en dehors
        document.getElementById('loginModal').addEventListener('click', (e) => {
          if (e.target.classList.contains('modal')) {
            document.getElementById('loginModal').classList.remove('active');
          }
        });

        document.getElementById('signupModal').addEventListener('click', (e) => {
          if (e.target.classList.contains('modal')) {
            document.getElementById('signupModal').classList.remove('active');
          }
        });
    </script>
</body>
</html>
