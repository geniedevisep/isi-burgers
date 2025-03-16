pipeline {
    agent any

    environment {
        DOCKER_REGISTRY = 'your-docker-registry'
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

        stage('Install Dependencies') {
            steps {
                bat 'composer install'
                bat 'npm install'
            }
        }

        stage('Tests') {
            parallel {
                stage('Unit Tests') {
                    steps {
                        bat 'vendor\\bin\\phpunit'
                    }
                }
                stage('Frontend Tests') {
                    steps {
                        bat 'npm test'
                    }
                }
            }
        }

        stage('Code Quality') {
            steps {
                withSonarQubeEnv('SonarQube') {
                    bat 'sonar-scanner.bat -Dsonar.projectKey=isi-burger -Dsonar.sources=.'
                }
            }
        }

        stage('Build Docker Image') {
            steps {
                bat "docker build -t %DOCKER_REGISTRY%/%DOCKER_IMAGE%:%DOCKER_TAG% ."
            }
        }

        stage('Push to Registry') {
            steps {
                withCredentials([usernamePassword(credentialsId: "${DOCKER_CREDENTIALS}", usernameVariable: 'DOCKER_USER', passwordVariable: 'DOCKER_PASS')]) {
                    bat 'docker login -u %DOCKER_USER% -p %DOCKER_PASS% %DOCKER_REGISTRY%'
                    bat 'docker push %DOCKER_REGISTRY%/%DOCKER_IMAGE%:%DOCKER_TAG%'
                }
            }
        }

        stage('Deploy to Dev') {
            when {
                branch 'aissatou_niass_burger'
            }
            steps {
                bat 'docker-compose -f docker-compose.dev.yml down'
                bat 'docker-compose -f docker-compose.dev.yml up -d'
            }
        }
    }

    post {
        always {
            cleanWs()
        }
        failure {
            echo 'Le pipeline a échoué'
        }
        success {
            echo 'Le pipeline a réussi'
        }
    }
} 