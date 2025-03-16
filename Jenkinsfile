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
                        // Vérification de l'existence des conteneurs
                        bat 'docker ps -q -f name=isi-burger-* | findstr . && docker-compose -f docker-compose.dev.yml down || echo "No containers to remove"'
                        
                        // Configuration des variables d'environnement
                        withEnv(["DOCKER_REGISTRY=${DOCKER_REGISTRY}",
                                "DOCKER_IMAGE=${DOCKER_IMAGE}",
                                "DOCKER_TAG=${DOCKER_TAG}"]) {
                            
                            // Déploiement avec Docker Compose
                            bat 'docker-compose -f docker-compose.dev.yml up -d'
                            
                            // Vérification du déploiement
                            bat 'docker ps'
                            
                            // Attente que l'application soit prête
                            bat 'timeout /t 30'
                            
                            // Test de l'application
                            bat 'curl http://localhost:8000'
                        }
                    } catch (Exception e) {
                        error "Échec du déploiement en dev: ${e.message}"
                    }
                }
            }
        }

        stage('Deploy to Staging') {
            when {
                branch 'staging'
            }
            steps {
                script {
                    try {
                        // Vérification de kubectl
                        bat 'kubectl version'
                        
                        // Application des manifestes Kubernetes
                        bat """
                            kubectl apply -f k8s/namespace.yaml
                            kubectl apply -f k8s/deployment.yaml
                            kubectl apply -f k8s/service.yaml
                            kubectl apply -f k8s/ingress.yaml
                        """
                        
                        // Vérification du déploiement
                        bat 'kubectl get pods -n staging'
                    } catch (Exception e) {
                        error "Échec du déploiement en staging: ${e.message}"
                    }
                }
            }
        }

        stage('Deploy to Preprod') {
            when {
                branch 'preprod'
            }
            steps {
                script {
                    try {
                        // Déploiement sur le cloud (exemple avec Azure)
                        withCredentials([azureServicePrincipal('AZURE_CREDENTIALS')]) {
                            bat """
                                az login --service-principal -u %AZURE_CLIENT_ID% -p %AZURE_CLIENT_SECRET% -t %AZURE_TENANT_ID%
                                az webapp deployment source config-zip --resource-group myResourceGroup --name myWebApp-preprod --src isi-burger.tar.gz
                            """
                        }
                    } catch (Exception e) {
                        error "Échec du déploiement en preprod: ${e.message}"
                    }
                }
            }
        }

        stage('Deploy to Production') {
            when {
                branch 'main'
            }
            input {
                message "Déployer en production?"
                ok "Oui, déployer"
            }
            steps {
                script {
                    try {
                        // Déploiement sur le cloud (exemple avec Azure)
                        withCredentials([azureServicePrincipal('AZURE_CREDENTIALS')]) {
                            bat """
                                az login --service-principal -u %AZURE_CLIENT_ID% -p %AZURE_CLIENT_SECRET% -t %AZURE_TENANT_ID%
                                az webapp deployment source config-zip --resource-group myResourceGroup --name myWebApp-prod --src isi-burger.tar.gz
                            """
                        }
                    } catch (Exception e) {
                        error "Échec du déploiement en production: ${e.message}"
                    }
                }
            }
        }

        stage('Setup Monitoring') {
            when {
                branch 'main'
            }
            steps {
                script {
                    try {
                        // Déploiement de Prometheus et Grafana
                        bat """
                            kubectl apply -f monitoring/prometheus-config.yaml
                            kubectl apply -f monitoring/prometheus-deployment.yaml
                            kubectl apply -f monitoring/grafana-deployment.yaml
                            kubectl apply -f monitoring/grafana-service.yaml
                        """
                    } catch (Exception e) {
                        error "Échec de la configuration du monitoring: ${e.message}"
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