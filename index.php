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
        /* Style CSS ici */
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
        }

        .container {
          display: flex;
          justify-content: space-between;
          align-items: center;
          padding: 2rem;
          max-width: 1400px;
          margin: 0 auto;
          min-height: 100vh;
        }

        .content {
          flex: 1;
          max-width: 600px;
        }

        .illustration {
          flex: 1;
          display: flex;
          justify-content: center;
          align-items: center;
        }

        h1 {
          font-size: 3.5rem;
          margin-bottom: 1rem;
          background: linear-gradient(135deg, var(--primary), var(--accent));
          -webkit-background-clip: text;
          -webkit-text-fill-color: transparent;
        }

        p {
          font-size: 1.2rem;
          margin-bottom: 2rem;
          line-height: 1.6;
        }

        .buttons {
          display: flex;
          gap: 1rem;
        }

        .btn {
          padding: 1rem 2rem;
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

        .floating {
          animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
          0% { transform: translateY(0px); }
          50% { transform: translateY(-20px); }
          100% { transform: translateY(0px); }
        }

        .particles {
          position: absolute;
          width: 100%;
          height: 100%;
          z-index: -1;
        }

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

        .login-form {
          background: var(--secondary);
          padding: 2rem;
          border-radius: 20px;
          width: 100%;
          max-width: 400px;
          position: relative;
          box-shadow: 0 0 40px rgba(108, 99, 255, 0.2);
        }

        .login-form h2 {
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
        
        .signup-form {
        background: var(--secondary);
        padding: 2rem;
        border-radius: 20px;
        width: 100%;
        max-width: 400px;
        position: relative;
        box-shadow: 0 0 40px rgba(108, 99, 255, 0.2);
        }

        .signup-form h2 {
        margin-bottom: 1.5rem;
        color: var(--light);
        text-align: center;
        }

        @media (max-width: 768px) {
          .container {
            flex-direction: column;
            text-align: center;
            padding: 1rem;
          }
          
          .buttons {
            justify-content: center;
          }
          
          .illustration {
            margin-top: 2rem;
          }
          
          h1 {
            font-size: 2.5rem;
          }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Section principale -->
    <div id="particles" class="particles"></div>
    <div class="container">
      <div class="content">
        <h1>Project Assistant</h1>
        <p>Project Assistant est une plateforme gratuite, en ligne, pensée pour simplifier la gestion de projet et maximiser votre efficacité. Profitez d'une interface intuitive et d'analyses avancées pour transformer toutes vos idées en réalité.</p>
        <p>Créez votre compte en quelques secondes et commencez à optimiser votre travail dès aujourd'hui !</p>
        <div class="buttons">
          <button class="btn btn-primary">Créer un compte gratuit</button>
          <button class="btn btn-secondary" id="loginBtn">Se connecter</button>
        </div>
      </div>
      <div class="illustration">
        <svg class="floating" width="400" height="400" viewBox="0 0 400 400">
          <defs>
            <linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="100%">
              <stop offset="0%" style="stop-color:var(--primary)" />
              <stop offset="100%" style="stop-color:var(--accent)" />
            </linearGradient>
          </defs>
          <circle cx="200" cy="200" r="180" fill="none" stroke="url(#grad1)" stroke-width="4"/>
          <path d="M150,150 L250,150 L250,250 L150,250 Z" fill="url(#grad1)" opacity="0.5"/>
          <circle cx="200" cy="200" r="50" fill="url(#grad1)"/>
        </svg>
      </div>
      <!-- Section pour des avantages supplémentaires -->
    <div class="container" style="flex-direction: column; text-align: center; padding: 2rem 0;">
      <h2 style="color: var(--accent);">Pourquoi choisir Project Assistant ?</h2>
      <ul style="list-style-type: none; padding: 0; color: var(--light); font-size: 1.2rem; line-height: 1.8;">
        <li><strong>100% gratuit :</strong> Accédez à toutes les fonctionnalités sans frais cachés.</li>
        <li><strong>Confiance :</strong> Rejoignez plus de 10 000 utilisateurs !</li>
        <li><strong>Analyses intelligentes :</strong> Suivez votre avancement avec des analyses automatiques avancées.</li>
        <li><strong>Accessible partout :</strong> Gérez vos projets depuis n’importe quel appareil, à tout moment.</li>
      </ul>
    </div>
    </div>

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
        // JavaScript ici
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

        document.getElementById('loginBtn').addEventListener('click', () => {
  document.getElementById('loginModal').classList.add('active');
});

document.querySelector('.btn-primary').addEventListener('click', () => {
  document.getElementById('signupModal').classList.add('active');
});

document.getElementById('closeModal').addEventListener('click', () => {
  document.getElementById('loginModal').classList.remove('active');
});

document.getElementById('closeSignupModal').addEventListener('click', () => {
  document.getElementById('signupModal').classList.remove('active');
});

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
    console.log("Réponse brute : ", response);
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`); // Lance une erreur si le code n'est pas 200
    }
    return response.json();
  })
  .then(data => {
    console.log("Données JSON reçues : ", data);
    if (data.success) {
      //alert("Connexion réussie !");
      window.location.href = data.redirect; // Redirige vers dashboard.php
    } else {
      alert("Échec de la connexion : " + data.message);
    }
  })
  .catch(error => {
    console.error('Erreur lors de la connexion:', error);
    alert('Une erreur est survenue lors de la connexion');
  });
});

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
      console.log("Réponse brute : ", response);
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

        // Close modal when clicking outside
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
