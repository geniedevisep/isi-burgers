pipeline {
    agent any

    environment {
        DOCKER_REGISTRY = 'localhost:5000'  // Registry local pour dev
        DOCKER_IMAGE = 'isi-burger'
        DOCKER_TAG = "${BUILD_NUMBER}"
        DOCKER_CREDENTIALS = 'docker-credentials-id'
        SONAR_CREDENTIALS = 'sonar-credentials-id'
    }

    stages {
        stage('Checkout') {
            steps {
                checkout scm
            }
        }

        stage('Build Project') {
            steps {
                // Copie du fichier .env.example vers .env
                bat 'copy .env.example .env'
                // Installation des dépendances PHP
                bat 'composer install --no-interaction'
                // Installation des dépendances Node.js
                bat 'npm install'
                // Build des assets
                bat 'npm run build'
                // Génération de la clé Laravel
                bat 'php artisan key:generate'
            }
        }

        stage('Unit Tests') {
            steps {
                script {
                    try {
                        bat 'php artisan test'
                    } catch (Exception e) {
                        echo 'Les tests ont échoué mais on continue le pipeline'
                    }
                }
            }
        }

        stage('Code Quality') {
            steps {
                script {
                    try {
                        withSonarQubeEnv('SonarQube') {
                            bat 'sonar-scanner.bat -Dsonar.projectKey=isi-burger -Dsonar.sources=.'
                        }
                    } catch (Exception e) {
                        echo 'Analyse SonarQube a échoué mais on continue le pipeline'
                    }
                }
            }
        }

        stage('Package Artifact') {
            steps {
                script {
                    // Création d'une archive du projet
                    bat 'tar -czf isi-burger.tar.gz --exclude=node_modules --exclude=vendor .'
                }
            }
        }

        stage('Build Docker Image') {
            steps {
                script {
                    try {
                        bat "docker build -t %DOCKER_REGISTRY%/%DOCKER_IMAGE%:%DOCKER_TAG% ."
                    } catch (Exception e) {
                        error "Échec de la construction de l'image Docker"
                    }
                }
            }
        }

        stage('Push to Registry') {
            steps {
                script {
                    try {
                        // Pour un registry local, pas besoin de credentials
                        bat "docker push %DOCKER_REGISTRY%/%DOCKER_IMAGE%:%DOCKER_TAG%"
                    } catch (Exception e) {
                        error "Échec du push vers le registry"
                    }
                }
            }
        }

        stage('Deploy to Dev') {
            when {
                branch 'aissatou_niass_burger'
            }
            steps {
                script {
                    try {
                        // Mise à jour des variables d'environnement dans docker-compose
                        bat """
                            set DOCKER_REGISTRY=%DOCKER_REGISTRY%
                            set DOCKER_IMAGE=%DOCKER_IMAGE%
                            set DOCKER_TAG=%DOCKER_TAG%
                            docker-compose -f docker-compose.dev.yml down
                            docker-compose -f docker-compose.dev.yml up -d
                        """
                    } catch (Exception e) {
                        error "Échec du déploiement"
                    }
                }
            }
        }
    }

    post {
        always {
            cleanWs()
        }
        success {
            echo 'Pipeline exécuté avec succès!'
        }
        failure {
            echo 'Le pipeline a échoué'
        }
    }
} 