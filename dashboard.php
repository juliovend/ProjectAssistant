<?php
session_start();

// Vérifiez que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirige vers la page de connexion si l'utilisateur n'est pas connecté
    exit();
}

// Récupérez le nom de l'utilisateur depuis la session
$userName = $_SESSION['user_name'];
$userEmail = $_SESSION['user_email'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <base href="/" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Assistant | Mon projet</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.2/axios.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --primary-dark: #1a1a2e;
            --secondary-dark: #2d4059;
            --success-dark: #1b8c4a;
            --warning-dark: #c49c0f;
            --danger-dark: #b83227;
            --background-dark: #0f0f1a;
            --card-dark: #1f1f2f;
            --text-dark: #ecf0f1;
            --border-dark: #2d2d3f;
            --input-dark: #2d2d3f;
        }

        body {
            background-color: var(--background-dark);
            color: var(--text-dark);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            background-color: var(--primary-dark);
            padding: 1rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            z-index: 100;
        }

        .app-logo {
            animation: pulse 2s infinite ease-in-out;
            width: 50px;
            height: 50px;
        }

        .header-content {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
        }

        .left-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .right-section {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            flex: 1;
            min-width: 250px;
        }

        .right-section-up {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-settings {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.2em;
            color: var(--text-dark);
            transition: color 0.3s;
        }

        .btn-settings:hover {
            color: var(--secondary-dark);
        }

        .welcome-message {
            color: var(--text-dark);
            font-size: 1em;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .project-selector {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .app-logo:hover {
            animation: rotate 1s infinite linear;
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        header {
            position: relative;
            z-index: 100;
        }

        .page-overlay {
            position: fixed;
            top: 80px;
            left: 0;
            width: 100%;
            height: calc(100% - 80px);
            background: rgba(0, 0, 0, 0.8);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 999;
        }

        #overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            z-index: 1000;
            display: none;
        }

        .overlay-message {
            text-align: center;
            font-size: 1.5em;
            color: var(--text-dark);
        }

        .card {
            background: var(--card-dark);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            border: 1px solid var(--border-dark);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .stat-section {
            padding: 15px;
            margin-bottom: 0px;
        }

        .stat-section h3 {
            text-align: center;
            margin-bottom: 20px;
            color: var(--text-dark);
        }

        .stat-card {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .stat-card i {
            font-size: 2em;
            margin-right: 15px;
            color: var(--secondary-dark);
        }

        .stat-card h4 {
            margin: 0;
            font-size: 1.2em;
            color: var(--text-dark);
            font-weight: normal;
        }

        .stat-value {
            margin-left: auto;
            font-size: 1.5em;
            font-weight: normal;
            color: var(--text-dark);
        }

        .success-message {
            color: #28a745; /* Vert vif */
        }

        .warning-message {
            color: #ff9800; /* Orange vif */
        }

        .task-list {
            list-style: none;
            padding: 0;
        }

        .task-list-header {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .budget-text {
            font-size: 0.7em;
            font-weight: normal;
        }

        .view-toggle {
            display: flex;
            align-items: center;
            color: var(--text-dark);
        }

        .view-toggle label {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .view-toggle input[type="checkbox"] {
            margin-right: 5px;
        }

        .task-list-header-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .task-list-header-right {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 10px;
        }

        .task-item {
            position: relative;
            border-left: 4px solid;
            margin-bottom: 10px;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid var(--border-dark);
        }

        .task-item[data-priority="high"] {
            border-left-color: var(--danger-dark);
        }

        .task-item[data-priority="medium"] {
            border-left-color: var(--warning-dark);
        }

        .task-item[data-priority="low"] {
            border-left-color: var(--success-dark);
        }

        .task-header {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .task-header-left {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 10px;
            flex: 1;
            min-width: 0;
        }

        .task-header input[type="text"] {
            background: transparent;
            border: none;
            color: var(--text-dark);
            font-size: 1em;
            font-weight: bold;
            padding: 2px 5px;
            width: 100%;
            box-sizing: border-box;
        }

        .task-header input[type="text"]:hover:not([disabled]),
        .task-header input[type="text"]:focus:not([disabled]) {
            background: var(--input-dark);
            border: 1px solid var(--border-dark);
            border-radius: 4px;
            outline: none;
        }

        .task-header input[type="text"][disabled] {
            cursor: not-allowed;
        }

        .task-details {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
            padding: 15px;
            background: rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            margin-top: 10px;
        }

        .btn-validate-task {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.2em;
            transition: color 0.3s;
        }

        .btn-validate-task .fa-check-circle {
            color: var(--success-dark);
        }

        .btn-validate-task .fa-circle {
            color: var(--border-dark);
        }

        .completed-task {
            text-decoration: line-through;
            color: #888;
            width: 100%;
        }

        .effort-budget-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 15px;
        }

        .classification-section {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
            margin-bottom: 15px;
        }

        .task-effort {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .task-effort label {
            min-width: 150px;
        }

        .task-effort input {
            width: 80px;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: var(--secondary-dark);
            color: var(--text-dark);
        }

        .btn-danger {
            background-color: var(--danger-dark);
            width: 40px;
            height: 40px;
            padding: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-danger:hover {
            background-color: #d44;
        }

        .btn-success {
            background-color: var(--success-dark);
        }

        .btn-success:hover {
            background-color: #239d57;
        }

        input[type="number"],
        input[type="text"] {
            padding: 8px;
            border-radius: 4px;
            border: 1px solid var(--border-dark);
            background: var(--input-dark);
            color: var(--text-dark);
            width: 80px;
        }

        .progress-container {
            width: 100%;
            background-color: var(--border-dark);
            border-radius: 10px;
            margin: 10px 0;
        }

        .progress-bar {
            height: 20px;
            border-radius: 10px;
            transition: width 0.3s ease, background-color 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .progress-text {
            color: var(--text-dark);
            font-weight: bold;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        .modal {
            display: none;
            position: fixed;
            top: 100px;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            overflow: auto; /* Permet le scroll si nécessaire */
        }

        .add-task-btn {
            position: relative;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: var(--success-dark);
            color: var(--text-dark);
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 0;
        }

        .modal-content {
            background-color: var(--card-dark);
            margin: 10% auto;
            padding: 20px;
            border-radius: 5px;
            width: 90%;
            max-width: 500px;
            position: relative;
            box-sizing: border-box;
            /*top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);*/
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: var(--text-dark);
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid var(--border-dark);
            background: var(--input-dark);
            color: var(--text-dark);
        }

        .project-details {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 20px;
        }

        .project-details .form-group {
            display: flex;
            flex-direction: column;
            flex: 1 1 200px;
        }

        .project-details-inline {
            padding: 15px;
            margin-top: 20px;
        }

        .project-details-inline h3 {
            margin-bottom: 15px;
        }

        .project-fields-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .project-field {
            display: flex;
            flex-direction: column;
            flex: 1 1 200px;
        }

        .project-field label {
            color: var(--text-dark);
            margin-bottom: 5px;
        }

        .project-field input {
            padding: 8px;
            border-radius: 4px;
            border: 1px solid var(--border-dark);
            background: var(--input-dark);
            color: var(--text-dark);
            width: 100%;
        }

        .btn-primary {
            background-color: var(--secondary-dark);
            color: var(--text-dark);
        }

        .btn-primary:hover {
            background-color: #3d5079;
        }

        .btn-toggle-details {
            background: transparent;
            border: none;
            cursor: pointer;
            transition: transform 0.3s ease, background-color 0.3s ease;
            color: var(--text-dark);
            font-size: 1.2em;
            margin-right: 10px;
            outline: none;
        }

        .btn-toggle-details:hover {
            color: var(--primary-dark);
            transform: scale(1.2);
        }

        .modal-buttons {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        .modal .btn {
            padding: 8px 16px;
            min-width: 100px;
        }

        .modal .btn-cancel {
            background-color: var(--danger-dark);
        }

        .modal .btn-create {
            background-color: var(--success-dark);
        }

        .task-list h3 {
            margin: 20px 0 10px 0;
            padding-bottom: 5px;
            border-bottom: 1px solid var(--border-dark);
            color: var(--text-dark);
        }

        .group-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
            cursor: pointer;
        }

        .group-header-content {
            flex: 1;
        }

        .group-header.collapsed i {
            transform: rotate(-90deg);
        }

        .group-tasks {
            max-height: none;
            overflow: visible;
            transition: max-height 0.3s ease-in-out;
        }

        .group-tasks.collapsed {
            max-height: 0;
            overflow: hidden;
        }

        .btn-toggle-mode {
            background-color: var(--secondary-dark);
            color: var(--text-dark);
            padding: 8px 16px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-right: 0px;
        }

        .btn-toggle-mode:hover {
            background-color: #3d5079;
        }

        .task-comment {
            grid-column: 1 / -1;
            margin-top: 10px;
        }

        .task-name {
    flex: 1;
    min-width: 0; /* Empêche le débordement du contenu */
}

        .task-comment textarea {
            width: 100%;
            min-height: 80px;
            padding: 10px;
            resize: vertical;
        }

        .task-comment textarea:focus {
            outline: none;
            border-color: var(--secondary-dark);
        }

        .btn-comment-toggle {
            background-color: var(--secondary-dark);
            color: var(--text-dark);
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-comment-toggle:hover {
            background-color: #3d5079;
        }

        .comment-section {
            margin-top: 10px;
        }

        .comment-box {
            background-color: var(--input-dark);
            padding: 10px;
            border-radius: 4px;
            min-height: 80px;
            border: 1px solid var(--border-dark);
            color: var(--text-dark);
            transition: border-color 0.3s;
        }

        .comment-box:focus {
            outline: none;
            border-color: var(--secondary-dark);
        }

        .comment-box::before {
            content: attr(placeholder);
            color: #777;
        }

        .comment-box:not(:empty)::before {
            content: '';
        }

        .group-progress-container {
            width: 100%;
            background-color: var(--border-dark);
            border-radius: 8px;
            margin: 5px 0;
        }

        .group-progress-bar {
            height: 16px;
            border-radius: 8px;
            transition: width 0.3s ease, background-color 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .group-progress-text {
            color: var(--text-dark);
            font-weight: bold;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
            font-size: 0.8em;
        }

        .project-selector select {
            padding: 8px;
            border-radius: 4px;
            background: var(--input-dark);
            color: var(--text-dark);
            border: 1px solid var(--border-dark);
        }

        .task-category {
            margin-top: 10px;
        }

        .category-select {
            padding: 8px;
            border-radius: 4px;
            border: 1px solid var(--border-dark);
            background: var(--input-dark);
            color: var(--text-dark);
            width: 200px;
        }

        .task-effort {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .task-effort label {
            min-width: 150px;
        }

        .task-effort input {
            width: 100px;
        }

        .classification-section {
            margin-bottom: 15px;
        }

        .category-select {
            width: 100%;
            margin-top: 5px;
        }

        .task-details {
            padding: 15px;
            background: rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            margin-top: 10px;
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .task-details {
                grid-template-columns: 1fr;
            }

            .right-section {
                align-items: flex-start;
            }

            .project-fields-container {
                flex-direction: column;
                gap: 10px; /* Réduction de l'espace vertical */
            }

            .left-section h1 {
                font-size: 1.5em;
            }

            .app-logo {
                width: 40px;
                height: 40px;
            }
        }

        @media (max-width: 480px) {
            .header-content {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .left-section,
            .right-section {
                width: 100%;
            }

            .left-section {
                display: flex;
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            /* Ajuster la taille de la police du titre */
            .left-section h1 {
                font-size: 24px; /* Ajustez cette valeur selon vos préférences */
                margin: 10px 0;
            }

            .app-logo {
                width: 50px;
                height: 50px;
            }

            /* Ajuster la disposition de la section droite */
    .right-section {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    /* Ajuster le message de bienvenue et le bouton des paramètres */
    .right-section-up {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        margin-bottom: 10px;
    }

    .welcome-message {
        font-size: 16px;
    }

    .btn-settings {
        font-size: 20px;
        margin-left: auto;
    }

    /* Ajuster la disposition du project-selector */
    .project-selector {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
        gap: 10px;
    }

    .project-selector select,
    .project-selector .btn {
        font-size: 16px;
        padding: 10px;
        width: 100%;
        box-sizing: border-box;
    }

    /* Ajouter le style pour la button-group */
    .project-selector .button-group {
        display: flex;
        justify-content: space-between;
        width: 100%;
        gap: 4%;
    }

    .project-selector .button-group .btn {
        width: 48%;
        padding: 10px;
        font-size: 16px;
        box-sizing: border-box;
    }

    .project-selector .btn {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .project-selector select {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }

    .project-selector .btn i {
        margin-right: 5px;
    }

    header {
        padding: 10px;
    }

            .task-header-left {
                flex-direction: column;
                align-items: flex-start;
            }

            .task-header-left .task-name {
                width: 100%;
            }

            .task-list-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .task-list-header-right {
                width: 100%;
                justify-content: flex-start;
            }

            /* Remove width: auto for .add-task-btn to maintain its circular shape */
            .btn-toggle-mode {
                width: auto;
            }

            /* Styles pour les champs du bloc "Fiche Projet" */
    .project-field label,
    .project-field input {
        margin: 0;
        padding: 0;
        font-size: 16px;
    }

    .project-field input {
        padding: 10px;
        box-sizing: border-box;
    }

    .project-field {
        flex: 1 1 auto; /* Ajouté pour corriger l'espace vertical */
        margin: 0;
        padding: 0;
    }

    /* Ajouter un léger espace vertical entre chaque champ du bloc "Fiche Projet" */
    .project-fields-container .project-field {
        margin-bottom: 10px;
    }

    /* Retirer le margin-bottom du dernier champ pour un espacement cohérent */
    .project-fields-container .project-field:last-child {
        margin-bottom: 0;
    }

    .card.project-details-inline {
        margin-bottom: 15px;
    }

    /* Ajuster la taille et l'espacement du titre "Fiche Projet" */
    .card.project-details-inline h3 {
        font-size: 18px;
        margin-bottom: 20px;
    }

            .task-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .task-header-left {
                width: 100%;
            }

            .task-header-left .task-name {
                width: 100%;
            }

            .effort-budget-section {
                grid-template-columns: 1fr; /* Stack on mobile */
            }

            .task-effort {
                flex-direction: column; /* Stack labels and inputs */
                align-items: flex-start;
            }

            .task-effort label,
            .task-effort input {
                width: 100%;
            }

            /* Assurer un padding gauche cohérent pour tous les conteneurs .card */
    .card {
        padding-left: 15px; /* Ajustez cette valeur si nécessaire */
        padding-right: 15px;
    }

    /* Supprimer les marges par défaut des titres h3 */
    .card h3 {
        margin-left: 0;
        margin-right: 0;
    }

    /* S'assurer que les titres n'ont pas de padding gauche supplémentaire */
    .card h3 {
        padding-left: 0;
        padding-right: 0;
    }

            /* Diminuer la taille de la police pour les blocs "Suivi Charge" et "Suivi Budget" */
            .card.stat-section {
                font-size: 16px; /* Ajustez cette valeur pour correspondre à "Fiche Projet" */
                padding-left: 15px; /* Même valeur pour tous les conteneurs */
                padding-right: 15px;
            }

            .card.stat-section h3 {
                font-size: 18px; /* Taille des titres des sections */
                margin-bottom: 20px; /* Ajuster l'espacement si nécessaire */
                text-align: left;
            }

            .card.stat-section .stat-card h4,
            .card.stat-section .stat-card .stat-value {
                font-size: 16px; /* Taille de la police pour les sous-titres et valeurs */
            }

            .card.stat-section .stat-card i {
                font-size: 1.2em; /* Taille des icônes ajustée */
                margin-right: 10px; /* Espacement à droite des icônes */
            }
        }

        .logout-btn {
            position: absolute;
            bottom: 20px;
            left: 20px;
            display: flex;
            align-items: center;
            gap: 5px;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

</head>

<body>

    <header>
        <div class="container">
            <div class="header-content">

                <div class="left-section">
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
                    <h1>Project Assistant</h1>
                </div>

                <div class="right-section">
                    <div class="right-section-up">
                        <div class="welcome-message">
                            Bienvenue, <span id="user-name"><?php echo htmlspecialchars($userName); ?></span>
                        </div>
                        <button class="btn-settings" onclick="showUserUpdateModal()" title="Paramètres du compte">
                            <i class="fas fa-cog"></i>
                        </button>
                    </div>
                    <div class="project-selector">
                        <select id="projectSelect" onchange="switchProject(this.value)">
                            <option value="">Sélectionner un projet</option>
                        </select>
                        <button class="btn" onclick="showNewProjectModal()">
                            <i class="fas fa-plus"></i> Nouveau projet
                        </button>
                        <div class="button-group">
                            <button class="btn btn-primary" onclick="duplicateCurrentProject()" id="duplicateProjectBtn" style="display: none;">
                                <i class="fas fa-copy"></i>
                            </button>
                            <button class="btn btn-danger" onclick="deleteCurrentProject()" id="deleteProjectBtn" style="display: none;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Superposition pour bloquer la page tant qu'aucun projet n'est sélectionné -->
    <div id="overlay" class="overlay">
        <p style="color: white; text-align: center; margin-top: 20%;">Veuillez sélectionner un projet pour continuer</p>
    </div>

    <div class="card project-details-inline">
        <h3>Fiche Projet</h3>
        <div class="project-fields-container">
            <div class="project-field">
                <label for="projectTitle">Nom du projet</label>
                <input type="text" id="projectTitle" value="">
            </div>
            <div class="project-field">
                <label for="projectStart">Date de début</label>
                <input type="date" id="projectStart" value="">
            </div>
            <div class="project-field">
                <label for="projectEnd">Date de fin</label>
                <input type="date" id="projectEnd" value="">
            </div>
            <div class="project-field">
                <label for="projectBudget">Budget alloué (€)</label>
                <input type="number" id="projectBudget" value="0" min="0" onchange="updateProjectBudget(this.value)">
            </div>
        </div>
    </div>

    <div class="card">
        <h3>Avancement Global</h3>
        <div class="progress-container">
            <div class="progress-bar" id="global-progress-bar" style="width: 0%">
                <span class="progress-text">0%</span>
            </div>
        </div>
    </div>

    <div class="stats-grid">
        <!-- Section Charge du Projet -->
        <div class="card stat-section">
            <h3>Suivi Charge</h3>
            <div class="stat-card">
                <i class="fas fa-clock"></i>
                <h4>Charge Consommée</h4>
                <div class="stat-value" id="consumed-effort">0h</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-hourglass-half"></i>
                <h4>Charge Restante</h4>
                <div class="stat-value" id="remaining-effort">0h</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-tasks"></i>
                <h4>Charge Totale</h4>
                <div class="stat-value" id="total-effort">0h</div>
            </div>
            <div class="stat-card">
                <p id="progress-analysis" class="h4">Calcul en cours...</p>
            </div>
        </div>

        <!-- Section Budget du Projet -->
        <div class="card stat-section">
            <h3>Suivi Budget</h3>
            <div class="stat-card">
                <i class="fas fa-euro-sign"></i>
                <h4>Budget Dépensé</h4>
                <div class="stat-value" id="spent-budget">0€</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-wallet"></i>
                <h4>Budget Restant</h4>
                <div class="stat-value" id="remaining-budget">0€</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-coins"></i>
                <h4>Budget Totale</h4>
                <div class="stat-value" id="total-budget">0€</div>
            </div>
            <div class="stat-card">
                <p id="budget-analysis" class="h4">Calcul en cours...</p>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="task-list-header">
            <div class="task-list-header-left">
                <h3>Liste des Tâches</h3>
            </div>
            <div class="task-list-header-right">
                <button class="add-task-btn" onclick="showNewTaskModal()">
                    <i class="fas fa-plus"></i>
                </button>
                <button class="btn btn-toggle-mode" onclick="toggleGroupBy()" id="groupByToggleBtn">
                    par Priorité
                </button>
                <button class="btn btn-success" onclick="exportTasksToExcel()">
                    <i class="fas fa-file-excel"></i>
                </button>
            </div>
        </div>
        <div id="task-list" class="task-list">
            <!-- Les tâches seront ajoutées ici dynamiquement -->
        </div>
    </div>

    <div id="taskModal" class="modal">
        <div class="modal-content">
            <h3>Nouvelle Tâche</h3>
            <form id="taskForm" onsubmit="createTask(event)">
                <!-- Champ Catégorie -->
                <div class="form-group">
                    <label for="taskCategory">Catégorie</label>
                    <select id="taskCategory" required>
                        <option value="">Sélectionner une catégorie</option>
                        <!-- Les options de catégorie seront ajoutées dynamiquement -->
                    </select>
                </div>
                <!-- Champ Nom de la tâche -->
                <div class="form-group">
                    <label for="taskName">Nom de la tâche</label>
                    <input type="text" id="taskName" required>
                </div>
                <!-- Champ Priorité -->
                <div class="form-group">
                    <label for="taskPriority">Priorité (0-100)</label>
                    <input type="number" id="taskPriority" min="0" max="100" required>
                </div>
                <!-- Champ Charge estimée -->
                <div class="form-group">
                    <label for="estimatedEffort">Charge estimée (heures)</label>
                    <input type="number" id="estimatedEffort" min="0" required>
                </div>
                <!-- Champ Budget estimé -->
                <div class="form-group">
                    <label for="estimatedBudget">Budget estimé (€)</label>
                    <input type="number" id="estimatedBudget" min="0" required>
                </div>
                <div class="modal-buttons">
                    <button type="button" class="btn btn-cancel" onclick="closeModal()">Annuler</button>
                    <button type="submit" class="btn btn-create">Créer</button>
                </div>
            </form>
        </div>
    </div>

    <div id="userUpdateModal" class="modal">
        <div class="modal-content">
            <h3>Mise à jour des informations du compte</h3>
            <form id="userUpdateForm" onsubmit="updateUserInfo(event)">
                <div class="form-group">
                    <label for="userName">Nom d'utilisateur</label>
                    <input type="text" id="userName" name="userName" value="<?php echo htmlspecialchars($userName); ?>" required>
                </div>
                <div class="form-group">
                    <label for="userEmail">Email</label>
                    <input type="email" id="userEmail" name="userEmail" value="<?php echo htmlspecialchars($userEmail); ?>" required>
                </div>
                <div class="form-group">
                    <label for="userPassword">Nouveau mot de passe</label>
                    <input type="password" id="userPassword" name="userPassword">
                </div>
                <div class="modal-buttons">
                    <button type="button" class="btn btn-cancel" onclick="closeUserUpdateModal()">Annuler</button>
                    <button type="submit" class="btn btn-create">Mettre à jour</button>
                    <button type="button" class="btn btn-danger logout-btn" onclick="logout()" title="Déconnexion">
                        <i class="fas fa-power-off"></i> Se déconnecter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div id="newProjectModal" class="modal">
        <div class="modal-content">
            <h3>Nouveau Projet</h3>
            <form id="newProjectForm" onsubmit="createProject(event)">
                <div class="form-group">
                    <label for="newProjectName">Nom du projet</label>
                    <input type="text" id="newProjectName" name="name" required>
                </div>
                <div class="form-group">
                    <label for="newProjectStart">Date de début</label>
                    <input type="date" id="newProjectStart" name="start_date" required>
                </div>
                <div class="form-group">
                    <label for="newProjectEnd">Date de fin</label>
                    <input type="date" id="newProjectEnd" name="end_date" required>
                </div>
                <div class="form-group">
                    <label for="newProjectBudget">Budget (€)</label>
                    <input type="number" id="newProjectBudget" name="budget" required min="0">
                </div>
                <div class="modal-buttons">
                    <button type="button" class="btn btn-cancel">Annuler</button>
                    <button type="submit" class="btn btn-create">Créer</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Déclarations globales
        const projects = new Map();
        let currentProjectId = null;
        let tasks = [];
        let taskCategories = new Set();
        let groupByCategory = false; // Par défaut, on groupe par priorité
        let expandedTasks = {}; // Stocke l'état d'expansion par tâche

        const attributeToPropertyMap = {
            'libelle': 'name',
            'priorite': 'priority',
            'categorie': 'category',
            'charge_consommee': 'consumedEffort',
            'charge_restante_estimee': 'remainingEffort',
            'budget_consomme': 'consumedBudget',
            'budget_restant_estime': 'remainingBudget',
            'commentaire': 'comment'
        };

        class Project {
            constructor(id, name, startDate, endDate, budget) {
                this.id = id;
                this.name = name;
                this.startDate = startDate;
                this.endDate = endDate;
                this.budget = budget;
                this.tasks = [];
            }
        }

        class Task {
            constructor(id, name, priority, category, consumedEffort, remainingEffort, totalEffort, consumedBudget, remainingBudget, totalBudget, comment) {
                this.id = id;
                this.name = name || "Sans nom";
                this.priority = priority || 0;
                this.category = category || '';
                this.consumedEffort = consumedEffort || 0;
                this.remainingEffort = remainingEffort || 0;
                this.totalEffort = totalEffort || 0;
                this.consumedBudget = consumedBudget || 0;
                this.remainingBudget = remainingBudget || 0;
                this.totalBudget = totalBudget || 0;
                this.comment = comment || '';
            }
        }

        // Fonctions globales

        function showUserUpdateModal() {
            document.getElementById('userUpdateModal').style.display = 'block';
        }

        function closeUserUpdateModal() {
            document.getElementById('userUpdateModal').style.display = 'none';
            document.getElementById('userUpdateForm').reset();
        }

        function updateUserInfo(event) {
            event.preventDefault();

            const formData = new FormData(document.getElementById('userUpdateForm'));

            fetch('update_user_info.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        //alert('Informations mises à jour avec succès');
                        closeUserUpdateModal();
                    } else {
                        alert(`Erreur : ${data.message}`);
                    }
                })
                .catch(error => console.error('Erreur lors de la mise à jour des informations utilisateur:', error));
        }

        function fetchProjects() {
            return fetch('get_projects.php')
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    if (data.success) {
                        // Vider la Map avant de la remplir à nouveau
                        projects.clear();
                        // Remplir la Map avec les projets reçus
                        data.projects.forEach(projectData => {
                            const project = new Project(
                                projectData.id,
                                projectData.nom,
                                projectData.date_debut,
                                projectData.date_fin,
                                projectData.budget
                            );
                            projects.set(projectData.id, project);
                        });

                        // Récupérer le projet contenant la tâche la plus récemment modifiée
                        fetch('get_last_modified_project.php')
                            .then(response => response.json())
                            .then(lastProjectData => {
                                if (lastProjectData.success) {
                                    currentProjectId = lastProjectData.project_id;
                                } else {
                                    // Si aucune tâche n'est trouvée, vous pouvez choisir un projet par défaut ou laisser currentProjectId à null
                                    currentProjectId = null;
                                }

                                // Mettre à jour le sélecteur après avoir défini currentProjectId
                                updateProjectSelector();

                                // Si un projet est sélectionné, charger les détails du projet
                                if (currentProjectId) {
                                    selectProject(currentProjectId);
                                    document.getElementById('overlay').style.display = 'none';
                                } else {
                                    document.getElementById('overlay').style.display = 'block';
                                }
                            })
                            .catch(error => console.error('Erreur lors de la récupération du projet le plus récent:', error));
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => console.error('Erreur lors de la récupération des projets:', error));
        }

        function populateProjectSelector(projects) {
            const projectSelect = document.getElementById('projectSelect');
            projectSelect.innerHTML = '<option value="">Sélectionner un projet</option>';

            projects.forEach(project => {
                const option = document.createElement('option');
                option.value = project.id;
                option.textContent = project.nom;
                projectSelect.appendChild(option);
                console.log("Projet chargé dans la liste:", project.nom);
            });
        }

        function createProject(event) {
            event.preventDefault();
            const formData = new FormData(document.getElementById('newProjectForm'));

            fetch('create_project.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    console.log("Réponse de create_project.php :", data);
                    if (data.success) {
                        const newProjectId = data.project_id;
                        // Créer un nouvel objet Project et l'ajouter à la Map
                        const newProject = new Project(
                            newProjectId,
                            formData.get('name'),
                            formData.get('start_date'),
                            formData.get('end_date'),
                            formData.get('budget')
                        );
                        projects.set(newProjectId, newProject);
                        currentProjectId = newProjectId;
                        updateProjectSelector();
                        selectProject(newProjectId);
                        // Afficher directement les détails du projet
                        displayProjectDetails(newProject);
                        // Initialiser les tâches pour le nouveau projet
                        tasks = [];
                        renderTasks();
                        updateStats();
                        closeNewProjectModal();
                        // S'assurer que l'overlay est cachée
                        document.getElementById('overlay').style.display = 'none';
                    } else {
                        alert(`Erreur : ${data.message}`);
                    }
                })
                .catch(error => console.error('Erreur:', error));
        }

        function switchProject(projectId) {
            console.log("switchProject appelé avec projectId:", projectId);

            // Vérifiez si l'utilisateur a sélectionné "Sélectionner un projet" ou rien du tout
            if (!projectId || projectId === "") {

                // Si aucun projet n'est sélectionné, affichez l'overlay
                document.getElementById('overlay').style.display = 'block';
                clearProjectDetails();
                tasks = [];
                renderTasks();
                updateStats();

                // Masquer les boutons de suppression et de duplication
                deleteProjectBtn.style.display = 'none';
                duplicateProjectBtn.style.display = 'none';

            } else {

                // Si un projet est sélectionné, masquez l'overlay
                document.getElementById('overlay').style.display = 'none';
                currentProjectId = projectId;

                // Afficher les boutons de suppression et de duplication
                deleteProjectBtn.style.display = 'inline-block';
                duplicateProjectBtn.style.display = 'inline-block';

                // Chargez les détails et les tâches du projet
                loadProjectDetails(currentProjectId);
                fetchTasksForProject(currentProjectId)

            }
        }

        function updateProjectSelector() {
            const select = document.getElementById('projectSelect');
            select.innerHTML = '<option value="">Sélectionner un projet</option>';
            for (const [id, project] of projects) {
                const option = document.createElement('option');
                option.value = id;
                option.textContent = project.name;
                select.appendChild(option);
            }
            select.value = currentProjectId; // Définir explicitement la valeur du sélecteur
        }

        function loadProjectDetails(projectId) {
            console.log("loadProjectDetails appelé avec projectId:", projectId);
            if (!projectId) {
                // Efface les champs si aucun projet n'est sélectionné
                clearProjectDetails();
                return;
            }

            // Récupère les détails du projet via une requête AJAX
            fetch(`get_project_details.php?project_id=${projectId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayProjectDetails(data.project);
                        updateAssistantAnalysis();
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => console.error('Erreur lors de la récupération des détails du projet:', error));
        }

        function displayProjectDetails(project) {
            document.getElementById('projectTitle').value = project.nom || '';
            document.getElementById('projectStart').value = project.date_debut || '';
            document.getElementById('projectEnd').value = project.date_fin || '';
            document.getElementById('projectBudget').value = project.budget || 0;
        }

        function clearProjectDetails() {
            document.getElementById('projectTitle').value = '';
            document.getElementById('projectStart').value = '';
            document.getElementById('projectEnd').value = '';
            document.getElementById('projectBudget').value = '';
        }

        function showNewProjectModal() {
            document.getElementById('newProjectModal').style.display = 'block';
        }

        function closeNewProjectModal() {
            document.getElementById('newProjectModal').style.display = 'none';
            document.getElementById('newProjectForm').reset(); // Réinitialise le formulaire si nécessaire
            const projectSelect = document.getElementById("projectSelect");
            const overlay = document.getElementById("overlay");
            if (!projectSelect.value || projectSelect.value === "") {
                overlay.style.display = "block";
            } else {
                overlay.style.display = "none"; // Ajoutez cette ligne pour cacher l'overlay
            }
        }

        function duplicateCurrentProject() {
            if (!currentProjectId) {
                alert("Aucun projet sélectionné.");
                return;
            }

            const newProjectName = prompt("Entrez le nom pour le nouveau projet dupliqué :");
            if (!newProjectName || newProjectName.trim() === "") {
                alert("Le nom du projet est requis pour la duplication.");
                return;
            }

            // Préparer les données à envoyer au serveur
            const data = {
                project_id: currentProjectId,
                new_project_name: newProjectName.trim()
            };

            // Envoyer une requête au serveur pour dupliquer le projet
            fetch('duplicate_project.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        //alert("Projet dupliqué avec succès.");
                        // Ajouter le nouveau projet à la liste locale des projets
                        const newProject = new Project(
                            data.new_project.id,
                            data.new_project.nom,
                            data.new_project.date_debut,
                            data.new_project.date_fin,
                            data.new_project.budget
                        );
                        projects.set(newProject.id, newProject);
                        updateProjectSelector();
                        // Sélectionner le nouveau projet dupliqué
                        selectProject(newProject.id);
                    } else {
                        alert(`Erreur lors de la duplication du projet : ${data.message}`);
                    }
                })
                .catch(error => console.error('Erreur lors de la duplication du projet :', error));
        }

        function deleteCurrentProject() {
            if (!currentProjectId) {
                alert("Aucun projet sélectionné.");
                return;
            }

            const confirmation = confirm("Êtes-vous sûr de vouloir supprimer ce projet ?");
            if (confirmation) {
                // Envoyer une requête au serveur pour supprimer le projet
                fetch('delete_project.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ project_id: currentProjectId })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            //alert("Projet supprimé avec succès.");
                            // Recharger la liste des projets depuis le serveur
                            fetchProjects().then(() => {
                                // Mettre à jour l'interface utilisateur
                                currentProjectId = null;
                                clearProjectDetails();
                                tasks = [];
                                renderTasks();
                                updateStats();
                                document.getElementById('overlay').style.display = 'block';
                                // Masquer les boutons de suppression et de duplication
                                document.getElementById('deleteProjectBtn').style.display = 'none';
                                document.getElementById('duplicateProjectBtn').style.display = 'none';
                            });
                        } else {
                            alert(`Erreur lors de la suppression du projet : ${data.message}`);
                        }
                    })
                    .catch(error => console.error('Erreur lors de la suppression du projet :', error));
            }
        }

        function formatNumber(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        }

        function getProgressColor(progress) {
            if (progress <= 33) {
                return 'var(--danger-dark)';
            } else if (progress <= 66) {
                return 'var(--warning-dark)';
            } else {
                return 'var(--success-dark)';
            }
        }

        function calculateLotProgress(tasks, lotPriority) {
            const lotTasks = tasks.filter(t => t.priority === lotPriority);
            if (lotTasks.length === 0) return 0;
            const totalEffort = lotTasks.reduce((sum, task) => sum + (task.consumedEffort + task.remainingEffort), 0);
            const consumedEffort = lotTasks.reduce((sum, task) => sum + task.consumedEffort, 0);
            return totalEffort > 0 ? Math.round((consumedEffort / totalEffort) * 100) : 0;
        }

        function calculateLotBudget(tasks, lotPriority) {
            const lotTasks = tasks.filter(t => t.priority === lotPriority);
            return lotTasks.reduce((sum, task) => sum + (task.consumedBudget + task.remainingBudget), 0);
        }

        function updateAssistantAnalysis() {
            const projectStart = new Date(document.getElementById("projectStart").value);
            const projectEnd = new Date(document.getElementById("projectEnd").value);
            const today = new Date();

            // Calcul de l'avancement temporel
            const totalDays = (projectEnd - projectStart) / (1000 * 60 * 60 * 24);
            const elapsedDays = (today - projectStart) / (1000 * 60 * 60 * 24);
            const timeProgress = Math.min(Math.max(elapsedDays / totalDays, 0), 1) * 100; // En pourcentage

            // Calcul de l'avancement global du projet
            const totalEffort = tasks.reduce((sum, task) => sum + (task.consumedEffort || 0) + (task.remainingEffort || 0), 0);
            const consumedEffort = tasks.reduce((sum, task) => sum + (task.consumedEffort || 0), 0);
            const globalProgress = totalEffort > 0 ? (consumedEffort / totalEffort) * 100 : 0;

           // Sélection des éléments DOM pour les messages
    const progressAnalysisElement = document.getElementById("progress-analysis");
    const budgetAnalysisElement = document.getElementById("budget-analysis");

    // Réinitialisation des classes
    progressAnalysisElement.classList.remove('success-message', 'warning-message');
    budgetAnalysisElement.classList.remove('success-message', 'warning-message');

    // Analyse de l'avancement
    let progressAnalysis;
    if (globalProgress >= timeProgress) {
        progressAnalysis = "Félicitations : votre projet est on-time.";
        progressAnalysisElement.classList.add('success-message');
    } else {
        progressAnalysis = `Attention, votre projet prend du retard : l’avancement devrait être de ${Math.round(timeProgress)}% aujourd’hui.`;
        progressAnalysisElement.classList.add('warning-message');
    }
    progressAnalysisElement.innerHTML = progressAnalysis;

    // Analyse du budget
    const totalBudget = tasks.reduce((sum, task) => sum + ((task.consumedBudget || 0) + (task.remainingBudget || 0)), 0);
    const allottedBudget = parseFloat(document.getElementById("projectBudget").value) || 0;

    let budgetAnalysis;
    if (totalBudget > allottedBudget) {
        budgetAnalysis = `Attention : votre projet dépassera le budget initialement prévu de ${(totalBudget / allottedBudget * 100 - 100).toFixed(0)}%.`;
        budgetAnalysisElement.classList.add('warning-message');
    } else {
        budgetAnalysis = "Félicitations : votre projet est on-budget.";
        budgetAnalysisElement.classList.add('success-message');
    }
    budgetAnalysisElement.innerHTML = budgetAnalysis;

            // Conseiller la prochaine tâche à traiter
            const sortedTasks = tasks
                .filter(task => task.remainingEffort > 0)  // Filtrer les tâches non terminées
                .sort((a, b) => a.priority - b.priority || b.remainingEffort - a.remainingEffort);  // Trier par priorité et charge restante
            const topTasks = sortedTasks.slice(0, 1);
            const taskRecommendations = topTasks.map(task => `${task.category} - ${task.name}`).join('<br>');

            document.getElementById("progress-analysis").innerHTML +=
                topTasks.length > 0 ? `<br>Pour avancer, vous devriez traiter la tâche suivante : ${taskRecommendations}.` : "<br>Aucune tâche restante à traiter.";
        }

        function showNewTaskModal() {
            populateCategoryOptions();
            document.getElementById('taskModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('taskModal').style.display = 'none';
            document.getElementById('taskForm').reset();
        }

        function createTask(event) {
            event.preventDefault();

            if (!currentProjectId) {
                alert("Veuillez sélectionner un projet avant d'ajouter une tâche.");
                return;
            }

            const categorySelect = document.getElementById('taskCategory');
            const categoryValue = categorySelect.value;

            const formData = new FormData();
            formData.append('project_id', currentProjectId);
            formData.append('category', categoryValue);
            formData.append('name', document.getElementById('taskName').value);
            formData.append('priority', parseInt(document.getElementById('taskPriority').value) || 0);
            formData.append('effort', parseFloat(document.getElementById('estimatedEffort').value) || 0);
            formData.append('budget', parseFloat(document.getElementById('estimatedBudget').value) || 0);

            fetch('create_task.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Ajouter la catégorie au set si elle n'y est pas déjà
                        if (categoryValue && categoryValue !== 'new') {
                            taskCategories.add(categoryValue);
                        }

                        // Fermer la modale et rafraîchir la liste des tâches
                        closeModal();
                        fetchTasksForProject(currentProjectId);
                    } else {
                        alert(`Erreur : ${data.message}`);
                    }
                })
                .catch(error => console.error('Erreur lors de la création de la tâche:', error));
        }

        // Lors du chargement des tâches, remplir le set des catégories
        function fetchTasksForProject(projectId) {
            fetch(`get_tasks.php?project_id=${projectId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        taskCategories.clear(); // Réinitialiser les catégories
                        tasks = data.tasks.map(taskData => {
                            const task = new Task(
                                taskData.id,
                                taskData.libelle,
                                taskData.priorite,
                                taskData.categorie,
                                taskData.charge_consommee,
                                taskData.charge_restante_estimee,
                                taskData.charge_totale_estimee,
                                taskData.budget_consomme,
                                taskData.budget_restant_estime,
                                taskData.budget_total_estime,
                                taskData.commentaire,
                                taskData.IsCompleted
                            );
                            task.completed = taskData.IsCompleted === 1;
                            // Ajouter la catégorie au set
                            if (task.category) {
                                taskCategories.add(task.category);
                            }
                            return task;
                        });
                        renderTasks();
                        updateStats();
                        // Appel pour mettre à jour les conseils de l'assistant
                        updateAssistantAnalysis();
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => console.error('Erreur lors de la récupération des tâches:', error));
        }

        function populateCategoryOptions() {
            const categorySelect = document.getElementById('taskCategory');
            categorySelect.innerHTML = '<option value="">Sélectionner une catégorie</option>';

            // Utiliser taskCategories pour les catégories
            const categories = Array.from(taskCategories).sort();
            categories.forEach(cat => {
                const option = document.createElement('option');
                option.value = cat;
                option.textContent = cat;
                categorySelect.appendChild(option);
            });

            // Ajouter l'option pour créer une nouvelle catégorie
            const newOption = document.createElement('option');
            newOption.value = 'new';
            newOption.textContent = '+ Nouvelle catégorie';
            categorySelect.appendChild(newOption);
        }

        function toggleGroupBy() {
            groupByCategory = !groupByCategory; // Inverser le mode

            // Mettre à jour le libellé du bouton
            const toggleBtn = document.getElementById('groupByToggleBtn');
            if (groupByCategory) {
                toggleBtn.textContent = 'suivi par Catégorie';
            } else {
                toggleBtn.textContent = 'suivi par Priorité';
            }

            // Rendre les tâches avec le nouveau mode
            renderTasks();
        }

        function toggleTaskValidation(taskId) {
            const task = tasks.find(t => t.id === taskId);
            if (task) {
                task.completed = !task.completed;

                // Mettre la charge restante à 0 si la tâche est complétée
                if (task.completed) {
                    task.remainingEffort = 0;
                }

                // Mettre à jour le statut de la tâche dans la base de données
                updateTaskAttribute(taskId, 'IsCompleted', task.completed ? 'true' : 'false');
                updateTaskAttribute(taskId, 'charge_restante_estimee', task.remainingEffort);

                // Mettre à jour l'affichage de la charge restante
                const remainingEffortElement = document.getElementById(`remaining-${taskId}`);
                if (remainingEffortElement) {
                    remainingEffortElement.value = task.remainingEffort; // Actualiser l'affichage de la charge restante
                }

                // Mettre à jour le nom de la tâche (texte barré ou non)
                const taskNameContainer = document.getElementById(`task-name-container-${taskId}`);
                if (taskNameContainer) {
                    const width = taskNameContainer.offsetWidth;
                    if (task.completed) {
                        const spanElement = document.createElement('span');
                        spanElement.textContent = task.name;
                        spanElement.style.textDecoration = 'line-through';
                        spanElement.style.color = '#888';
                        spanElement.classList.add('completed-task');
                        spanElement.style.width = '100%';

                        taskNameContainer.innerHTML = '';
                        taskNameContainer.appendChild(spanElement);
                    } else {
                        const inputElement = document.createElement('input');
                        inputElement.type = 'text';
                        inputElement.value = task.name;
                        inputElement.classList.add('task-field');
                        inputElement.setAttribute('data-task-id', taskId);
                        inputElement.setAttribute('data-attribute', 'libelle');
                        inputElement.style.width = '100%';

                        taskNameContainer.innerHTML = '';
                        taskNameContainer.appendChild(inputElement);
                    }
                }

                // Mise à jour de l'icône de validation
                const taskElement = document.getElementById(`task-${taskId}`);
                const validateIcon = taskElement ? taskElement.querySelector('.btn-validate-task i') : null;
                if (validateIcon) {
                    validateIcon.classList.toggle('fas');
                    validateIcon.classList.toggle('far');
                    validateIcon.classList.toggle('fa-check-circle', task.completed);
                    validateIcon.classList.toggle('fa-circle', !task.completed);
                }

                // Mise à jour des statistiques
                updateStats();
                updateAssistantAnalysis();
            }
        }

        function deleteTask(taskId) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cette tâche ?')) {
                // Envoyer une requête au serveur pour supprimer la tâche
                fetch('delete_task.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ task_id: taskId })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Retirer la tâche du tableau local
                            tasks = tasks.filter(t => t.id !== taskId);
                            // Mettre à jour l'interface
                            renderTasks();
                            updateStats();
                        } else {
                            alert(`Erreur lors de la suppression de la tâche : ${data.message}`);
                        }
                    })
                    .catch(error => console.error('Erreur lors de la suppression de la tâche :', error));
            }
        }

        function duplicateTask(taskId) {
            const originalTask = tasks.find(t => t.id === taskId);
            if (originalTask) {
                // Préparer les données à envoyer au serveur
                const taskData = {
                    task_id: taskId
                };

                // Envoyer une requête POST au serveur pour dupliquer la tâche
                fetch('duplicate_task.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(taskData)
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Ajouter la nouvelle tâche à la liste des tâches
                            const newTaskData = data.task;
                            const newTask = new Task(
                                newTaskData.id,
                                newTaskData.libelle,
                                newTaskData.priorite,
                                newTaskData.categorie,
                                newTaskData.charge_consommee,
                                newTaskData.charge_restante_estimee,
                                newTaskData.charge_totale_estimee,
                                newTaskData.budget_consomme,
                                newTaskData.budget_restant_estime,
                                newTaskData.budget_total_estime,
                                newTaskData.commentaire
                            );
                            tasks.push(newTask);
                            renderTasks();
                            updateStats();
                        } else {
                            alert(`Erreur lors de la duplication de la tâche : ${data.message}`);
                        }
                    })
                    .catch(error => console.error('Erreur lors de la duplication de la tâche :', error));
            }
        }

        function renderTasks() {
                // Mettre à jour expandedTasks à partir du DOM actuel avant de re-rendre
    document.querySelectorAll('.task-details').forEach(detail => {
        const taskId = detail.id.replace('task-details-', '');
        if (detail.style.display !== 'none') {
            expandedTasks[taskId] = true;
        } else {
            expandedTasks[taskId] = false;
        }
    });

    const taskList = document.getElementById('task-list');
    const expandedGroups = new Set();

    document.querySelectorAll('.group-header').forEach(header => {
        if (!header.classList.contains('collapsed')) {
            expandedGroups.add(header.getAttribute('data-key'));
        }
    });

    taskList.innerHTML = '';

            let tasksGrouped = {};
            let groupKeys = [];

            if (groupByCategory) {
                // Regroupement par catégorie
                tasks.forEach(task => {
                    const category = task.category || 'Sans catégorie';
                    if (!tasksGrouped[category]) {
                        tasksGrouped[category] = [];
                        groupKeys.push(category);
                    }
                    tasksGrouped[category].push(task);
                });
                // Tri des catégories par ordre alphabétique
                groupKeys.sort();
            } else {
                // Regroupement par priorité
                tasks.forEach(task => {
                    const priority = task.priority || 0;
                    if (!tasksGrouped[priority]) {
                        tasksGrouped[priority] = [];
                        groupKeys.push(priority);
                    }
                    tasksGrouped[priority].push(task);
                });
                // Tri des priorités numériques
                groupKeys = groupKeys.map(Number).sort((a, b) => a - b);
            }

            groupKeys.forEach(key => {
                const groupDiv = document.createElement('div');
                const groupTasks = tasksGrouped[key];

                let groupProgress = calculateGroupProgress(groupTasks);
                let groupBudget = calculateGroupBudget(groupTasks);

                const groupHeader = document.createElement('div');
                groupHeader.setAttribute('data-key', key.toString());

                const wasExpanded = expandedGroups.has(key.toString());
                groupHeader.className = `group-header${wasExpanded ? '' : ' collapsed'}`;
                const tasksContainer = document.createElement('div');
                tasksContainer.className = `group-tasks${wasExpanded ? '' : ' collapsed'}`;

                groupHeader.innerHTML = `
                    <i class="fas fa-chevron-down"></i>
                    <div class="group-header-content">
                        <h3>${groupByCategory ? key : 'Phase ' + key} <span class="budget-text">${formatNumber(groupBudget)} €</span></h3>
                        <div class="progress-container group-progress-container">
                            <div class="progress-bar group-progress-bar" style="width: ${groupProgress}%; background-color: ${getProgressColor(groupProgress)}">
                                <span class="progress-text">${groupProgress}%</span>
                            </div>
                        </div>
                    </div>`;

                groupHeader.addEventListener('click', () => {
                    groupHeader.classList.toggle('collapsed');
                    tasksContainer.classList.toggle('collapsed');
                });

                groupDiv.appendChild(groupHeader);
                groupDiv.appendChild(tasksContainer);
                taskList.appendChild(groupDiv);

                groupTasks.forEach(task => {
                    const taskElement = renderTaskItem(task);

                    // Utiliser expandedTasks pour appliquer l'état d'expansion
                    const taskDetails = taskElement.querySelector(`#task-details-${task.id}`);
                    if (taskDetails) {
                        taskDetails.style.display = expandedTasks[task.id] ? 'block' : 'none';
                    }

                    // Ajouter un écouteur pour mettre à jour expandedTasks lorsque l'utilisateur clique sur le bouton de détails
                    const toggleButton = taskElement.querySelector('.btn-toggle-details');
                    if (toggleButton) {
                        toggleButton.addEventListener('click', () => {
                            expandedTasks[task.id] = !expandedTasks[task.id];
                        });
                    }

                    tasksContainer.appendChild(taskElement);
                });
            });
        }

        function calculateGroupProgress(groupTasks) {
            if (groupTasks.length === 0) return 0;
            const totalEffort = groupTasks.reduce((sum, task) => sum + (task.consumedEffort + task.remainingEffort), 0);
            const consumedEffort = groupTasks.reduce((sum, task) => sum + task.consumedEffort, 0);
            return totalEffort > 0 ? Math.round((consumedEffort / totalEffort) * 100) : 0;
        }

        function calculateGroupBudget(groupTasks) {
            return groupTasks.reduce((sum, task) => sum + (task.consumedBudget + task.remainingBudget), 0);
        }

        function renderTaskItem(task) {
            const taskElement = document.createElement('div');
            taskElement.className = 'task-item';
            taskElement.id = `task-${task.id}`;

            const validationIconClass = task.completed ? 'fas fa-check-circle validated' : 'far fa-circle';

            taskElement.innerHTML = `
                <div class="task-header">
                    <div class="task-header-left">
                        <!-- Bouton d'expansion avec orientation dynamique -->
                        <button class="btn-toggle-details" onclick="toggleTaskDetails(${task.id})" title="Afficher/Masquer les détails">
                            <i id="toggle-icon-${task.id}" class="fas ${expandedTasks[task.id] ? 'fa-chevron-down' : 'fa-chevron-right'}"></i>
                        </button>

                        <!-- Libellé de la tâche -->
                        <div class="task-name" id="task-name-container-${task.id}">
                            ${task.completed
                    ? `<span class="completed-task">${task.name}</span>`
                    : `<input type="text" value="${task.name}" class="task-field" data-task-id="${task.id}" data-attribute="libelle">`
                }
                        </div>
                    </div>
                    <div style="display: flex; gap: 10px;">
                        <button class="btn-validate-task" onclick="toggleTaskValidation(${task.id})" title="Valider/Annuler validation">
                            <i class="${validationIconClass}"></i>
                        </button>
                        <button class="btn btn-success" onclick="duplicateTask(${task.id})" title="Dupliquer la tâche">
                            <i class="fas fa-copy"></i>
                        </button>
                        <button class="btn btn-danger" onclick="deleteTask(${task.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="task-details" id="task-details-${task.id}" style="display: none;">
                    <div class="classification-section">
                        <div class="priority-section">
                            <h5 style="margin: 0 0 10px 0; color: var(--text-dark);">Classification</h5>
                            <div class="task-effort">
                                <label>Priorité (0-100):</label>
                                <input type="number" value="${task.priority}" min="0" max="100" class="task-field" data-task-id="${task.id}" data-attribute="priorite">
                            </div>
                            <div class="task-category">
                                <label>Catégorie:</label>
                                <select class="category-select task-field" data-task-id="${task.id}" data-attribute="categorie">
                                    <option value="">Sélectionner une catégorie</option>
                                    ${getTaskCategories().map(cat => `
                                    <option value="${cat}" ${task.category === cat ? 'selected' : ''}>${cat}</option>`).join('')}
                                    <option value="new">+ Nouvelle catégorie</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="effort-budget-section">
                        <div class="effort-section">
                            <h5 style="margin: 0 0 10px 0; color: var(--text-dark);">Charge de travail</h5>
                            <div class="task-effort">
                                <label>Charge consommée (h):</label>
                                <input type="number" id="consumed-${task.id}" value="${task.consumedEffort}" min="0" class="task-field" data-task-id="${task.id}" data-attribute="charge_consommee">
                            </div>
                            <div class="task-effort">
                                <label>Charge restante (h):</label>
                                <input type="number" id="remaining-${task.id}" value="${task.remainingEffort}" min="0" class="task-field" data-task-id="${task.id}" data-attribute="charge_restante_estimee">
                            </div>
                            <div style="margin-top: 5px; color: var(--text-dark);">Total: ${formatNumber(task.consumedEffort + task.remainingEffort)} h</div>
                        </div>
                        <div class="budget-section">
                            <h5 style="margin: 0 0 10px 0; color: var(--text-dark);">Budget</h5>
                            <div class="task-effort">
                                <label>Budget dépensé (€):</label>
                                <input type="number" id="spent-${task.id}" value="${task.consumedBudget}" min="0" class="task-field" data-task-id="${task.id}" data-attribute="budget_consomme">
                            </div>
                            <div class="task-effort">
                                <label>Budget restant (€):</label>
                                <input type="number" id="remaining-budget-${task.id}" value="${task.remainingBudget}" min="0" class="task-field" data-task-id="${task.id}" data-attribute="budget_restant_estime">
                            </div>
                            <div style="margin-top: 5px; color: var(--text-dark);">Total: ${formatNumber(task.consumedBudget + task.remainingBudget)} €</div>
                        </div>
                    </div>
                    <div class="task-comment">
                        <button class="btn btn-comment-toggle" onclick="toggleComment(${task.id})">
                            <i class="fas fa-comment"></i>
                        </button>
                        <div id="comment-section-${task.id}" class="comment-section" style="display: none;">
                            <div class="comment-box task-field" data-task-id="${task.id}" data-attribute="commentaire" contenteditable="true" placeholder="Ajouter un commentaire...">${task.comment || ''}</div>
                        </div>
                    </div>
                </div>`;

            // Ajouter l'écouteur d'événement ici
            const commentBox = taskElement.querySelector('.comment-box');
            commentBox.addEventListener('input', function (event) {
                const value = event.target.innerHTML;
                const taskId = event.target.getAttribute('data-task-id');
                updateTaskAttribute(taskId, 'commentaire', value);
                const task = tasks.find(t => t.id == taskId);
                if (task) {
                    task.comment = value;
                }
            });

            return taskElement;
        }

        function toggleComment(taskId) {
            const commentSection = document.getElementById(`comment-section-${taskId}`);
            if (commentSection.style.display === 'none') {
                commentSection.style.display = 'block';
            } else {
                commentSection.style.display = 'none';
            }
        }

        function toggleTaskDetails(taskId) {
            const detailsElement = document.getElementById(`task-details-${taskId}`);
            const iconElement = document.getElementById(`toggle-icon-${taskId}`);

            if (detailsElement && iconElement) {
                const isExpanded = detailsElement.style.display === 'block';
                detailsElement.style.display = isExpanded ? 'none' : 'block';

                // Met à jour l'icône d'expansion
                iconElement.classList.toggle('fa-chevron-right', isExpanded);
                iconElement.classList.toggle('fa-chevron-down', !isExpanded);

                // Mémorise l'état d'expansion
                expandedTasks[taskId] = !isExpanded;
            }
        }

        function updateStats() {
            const consumedEffort = tasks.reduce((sum, task) => sum + task.consumedEffort, 0);
            const remainingEffort = tasks.reduce((sum, task) => sum + task.remainingEffort, 0);
            const totalEffort = consumedEffort + remainingEffort;
            const progress = totalEffort > 0 ? Math.round((consumedEffort / totalEffort) * 100) : 0;
            const spentBudget = tasks.reduce((sum, task) => sum + task.consumedBudget, 0);
            const remainingBudget = tasks.reduce((sum, task) => sum + task.remainingBudget, 0);
            const totalBudget = spentBudget + remainingBudget;

            const consumedEffortElement = document.getElementById('consumed-effort');
            if (consumedEffortElement) {
                consumedEffortElement.textContent = `${formatNumber(consumedEffort)} h`;
            }

            const remainingEffortElement = document.getElementById('remaining-effort');
            if (remainingEffortElement) {
                remainingEffortElement.textContent = `${formatNumber(remainingEffort)} h`;
            }

            const totalEffortElement = document.getElementById('total-effort');
            if (totalEffortElement) {
                totalEffortElement.textContent = `${formatNumber(totalEffort)} h`;
            }

            const progressElement = document.getElementById('progress-percentage');
            if (progressElement) {
                progressElement.textContent = `${formatNumber(progress)}%`;
            }

            const spentBudgetElement = document.getElementById('spent-budget');
            if (spentBudgetElement) {
                spentBudgetElement.textContent = `${formatNumber(spentBudget)} €`;
            }

            const remainingBudgetElement = document.getElementById('remaining-budget');
            if (remainingBudgetElement) {
                remainingBudgetElement.textContent = `${formatNumber(remainingBudget)} €`;
            }

            const totalBudgetElement = document.getElementById('total-budget');
            if (totalBudgetElement) {
                totalBudgetElement.textContent = `${formatNumber(totalBudget)} €`;
            }

            const globalProgressBar = document.getElementById('global-progress-bar');
            if (globalProgressBar) {
                globalProgressBar.style.width = `${progress}%`;
                globalProgressBar.style.backgroundColor = getProgressColor(progress);
                globalProgressBar.innerHTML = `
                    <span class="progress-text">${progress}%</span>`;
            }
        }

        function updateProjectBudget(value) {
            const budget = Math.max(0, parseInt(value) || 0);
            document.getElementById('projectBudget').value = budget;
        }

        function getTaskCategories() {
            const categories = new Set();
            tasks.forEach(task => {
                if (task.category) categories.add(task.category);
            });
            return Array.from(categories).sort();
        }

        function exportTasksToExcel() {
            const headers = ['Nom', 'Priorité', 'Catégorie', 'Charge consommée (h)', 'Charge restante (h)', 'Charge totale (h)', 'Budget dépensé (€)', 'Budget restant (€)', 'Budget total (€)', 'Commentaire'];

            // Préparer les données
            const data = tasks.map(task => {
                const totalEffort = task.consumedEffort + task.remainingEffort;
                const totalBudget = task.consumedBudget + task.remainingBudget;
                return [
                    task.name,
                    task.priority,
                    task.category || '',
                    task.consumedEffort || 0,
                    task.remainingEffort || 0,
                    totalEffort,
                    task.consumedBudget || 0,
                    task.remainingBudget || 0,
                    totalBudget,
                    task.comment || ''
                ];
            });

            data.unshift(headers);

            const worksheet = XLSX.utils.aoa_to_sheet(data);

            // Définir la largeur des colonnes (optionnel)
            const columnWidths = [
                { wch: 30 }, // Nom
                { wch: 10 }, // Priorité
                { wch: 20 }, // Catégorie
                { wch: 20 }, // Charge consommée
                { wch: 20 }, // Charge restante
                { wch: 15 }, // Charge totale
                { wch: 20 }, // Budget dépensé
                { wch: 20 }, // Budget restant
                { wch: 15 }, // Budget total
                { wch: 40 }  // Commentaire
            ];

            worksheet['!cols'] = columnWidths;

            const workbook = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(workbook, worksheet, 'Tâches');

            const excelBuffer = XLSX.write(workbook, { bookType: 'xlsx', type: 'array' });

            // Obtenir le nom du projet
            let projectName = 'MonProjet'; // Valeur par défaut au cas où
            if (projects.has(currentProjectId)) {
                projectName = projects.get(currentProjectId).name || 'MonProjet';
            }

            // Nettoyer le nom du projet pour l'utiliser dans le nom du fichier
            projectName = sanitizeFilename(projectName);

            // Générer le nom du fichier
            const date = new Date().toISOString().split('T')[0];
            const filename = `${projectName}_export_${date}.xlsx`;

            // Enregistrer le fichier
            const blob = new Blob([excelBuffer], { type: 'application/octet-stream' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = filename;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        // Fonction pour nettoyer le nom du fichier
        function sanitizeFilename(filename) {
            return filename.replace(/[\\/:*?"<>|]/g, '');
        }

        function selectProject(projectId) {
            const projectSelect = document.getElementById("projectSelect");
            projectSelect.value = projectId;
            switchProject(projectId); // Appelle la fonction pour charger les détails du projet sélectionné
        }

        function updateProjectAttribute(attribute, value) {
            if (!currentProjectId) return; // S'assurer qu'un projet est bien sélectionné

            fetch('update_project_attribute.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    project_id: currentProjectId,
                    attribute: attribute,
                    value: value
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log(`${attribute} mis à jour avec succès`);
                    } else {
                        console.error(`Erreur lors de la mise à jour de ${attribute} : ${data.message}`);
                    }
                })
                .catch(error => console.error('Erreur de réseau:', error));
        }

        function updateTaskAttribute(taskId, attribute, value) {
            if (!taskId) return; // S'assurer qu'une tâche est bien sélectionnée

            fetch('update_task_attribute.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    task_id: taskId,
                    attribute: attribute,
                    value: value
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log(`${attribute} mis à jour avec succès`);
                    } else {
                        console.error(`Erreur lors de la mise à jour de ${attribute} : ${data.message}`);
                    }
                })
                .catch(error => console.error('Erreur de réseau:', error));
        }

        function validateTask(taskId) {
            const task = tasks.find(t => t.id === taskId);
            if (task) {
                task.completed = true;
                task.remainingEffort = 0; // Mettre à jour pour indiquer que la tâche est terminée

                // Désactiver le bouton de validation
                const validateButton = document.querySelector(`#task-${taskId} .btn-validate-task`);
                if (validateButton) {
                    validateButton.disabled = true;
                }

                // Rafraîchir les statistiques
                updateStats();
                renderTasks();
            }
        }

        function logout() {
            fetch('logout.php') // Fichier PHP pour fermer la session
                .then(() => {
                    window.location.href = 'index.php'; // Redirige vers la page d'accueil
                })
                .catch(error => console.error('Erreur lors de la déconnexion:', error));
        }

        // Écouteur d'événement principal

        document.addEventListener('DOMContentLoaded', function () {
            // Appel des fonctions initiales
            fetchProjects();

            // Écouteurs d'événements pour les boutons et les champs
            const cancelButton = document.querySelector("#newProjectModal .btn-cancel");
            if (cancelButton) {
                cancelButton.addEventListener("click", closeNewProjectModal);
            }

            document.getElementById("projectTitle").addEventListener("change", function () {
                updateProjectAttribute('nom', this.value);
            });

            document.getElementById("projectStart").addEventListener("change", function () {
                updateProjectAttribute('date_debut', this.value);
                updateAssistantAnalysis();
            });

            document.getElementById("projectEnd").addEventListener("change", function () {
                updateProjectAttribute('date_fin', this.value);
                updateAssistantAnalysis();
            });

            document.getElementById("projectBudget").addEventListener("change", function () {
                updateProjectAttribute('budget', this.value);
                updateAssistantAnalysis();
            });

            // Écouteur sur le sélecteur de catégorie dans la modale de création de tâche
            const taskCategorySelect = document.getElementById('taskCategory');
            taskCategorySelect.addEventListener('change', function (event) {
                const selectedValue = this.value;

                if (selectedValue === 'new') {
                    const newCategory = prompt('Entrez le nom de la nouvelle catégorie:');
                    if (newCategory && newCategory.trim()) {
                        // Ajouter la nouvelle catégorie au set
                        taskCategories.add(newCategory.trim());

                        // Repeupler les options de catégorie pour inclure la nouvelle catégorie
                        populateCategoryOptions();

                        // Sélectionner la nouvelle catégorie
                        this.value = newCategory.trim();
                    } else {
                        // Si l'utilisateur n'a pas entré de nom, revenir à la valeur précédente
                        this.value = '';
                    }
                }
            });

            // Écouteur sur la liste des tâches
            const taskList = document.getElementById("task-list");
            taskList.addEventListener("change", function (event) {
                const target = event.target;

                if (target.classList.contains("category-select")) {
                    // Gestion des sélecteurs de catégorie
                    const selectedValue = target.value;
                    const taskId = target.getAttribute("data-task-id");

                    if (selectedValue === 'new') {
                        const newCategory = prompt('Entrez le nom de la nouvelle catégorie:');
                        if (newCategory && newCategory.trim()) {
                            const option = document.createElement('option');
                            option.value = newCategory.trim();
                            option.textContent = newCategory.trim();
                            target.add(option, target.options.length - 1);
                            target.value = newCategory.trim();
                            updateTaskAttribute(taskId, 'categorie', newCategory.trim());

                            const task = tasks.find(t => t.id == taskId);
                            if (task) {
                                task.category = newCategory.trim();
                                renderTasks();
                            }
                        } else {
                            target.value = '';
                        }
                    } else {
                        updateTaskAttribute(taskId, 'categorie', selectedValue);

                        const task = tasks.find(t => t.id == taskId);
                        if (task) {
                            task.category = selectedValue;
                            renderTasks();
                        }
                    }
                } else if (target.classList.contains("task-field")) {
                    // Gestion des champs de tâche
                    const attribute = target.getAttribute("data-attribute");
                    const taskId = target.getAttribute("data-task-id");
                    let value = target.value;

                    if (['charge_consommee', 'charge_restante_estimee', 'budget_consomme', 'budget_restant_estime', 'priorite'].includes(attribute)) {
                        value = parseFloat(value) || 0;
                        value = Math.max(0, value);
                    }

                    updateTaskAttribute(taskId, attribute, value);

                    const task = tasks.find(t => t.id == taskId);
                    if (task) {
                        const taskProperty = attributeToPropertyMap[attribute] || attribute;
                        task[taskProperty] = value;
                        renderTasks();
                        updateStats();
                        updateAssistantAnalysis();
                    }
                }
            });

            // Initialiser le libellé du bouton de mode d'affichage
            const toggleBtn = document.getElementById('groupByToggleBtn');
            if (groupByCategory) {
                toggleBtn.textContent = 'suivi par Catégorie';
            } else {
                toggleBtn.textContent = 'suivi par Priorité';
            }

        });
    </script>
</body>
</html>
