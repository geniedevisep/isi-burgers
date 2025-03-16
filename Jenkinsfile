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
                sh 'composer install --no-interaction --no-progress'
                sh 'npm install'
                sh 'npm run build'
            }
        }

        stage('Tests') {
            parallel {
                stage('Unit Tests') {
                    steps {
                        sh 'php artisan test'
                    }
                }
                stage('Frontend Tests') {
                    steps {
                        sh 'npm run test'
                    }
                }
            }
        }

        stage('Code Quality') {
            steps {
                withSonarQubeEnv('SonarQube') {
                    sh 'sonar-scanner \
                        -Dsonar.projectKey=isi-burger \
                        -Dsonar.sources=. \
                        -Dsonar.host.url=http://localhost:9000'
                }
            }
        }

        stage('Build Docker Image') {
            steps {
                script {
                    docker.build("${DOCKER_REGISTRY}/${DOCKER_IMAGE}:${DOCKER_TAG}")
                }
            }
        }

        stage('Push to Registry') {
            steps {
                script {
                    docker.withRegistry("https://${DOCKER_REGISTRY}", DOCKER_CREDENTIALS) {
                        docker.image("${DOCKER_REGISTRY}/${DOCKER_IMAGE}:${DOCKER_TAG}").push()
                    }
                }
            }
        }

        stage('Deploy to Dev') {
            when {
                branch 'fatou_diop_burger'
            }
            steps {
                sh """
                    docker-compose -f docker-compose.dev.yml down
                    docker-compose -f docker-compose.dev.yml up -d
                """
            }
        }
    }

    post {
        always {
            cleanWs()
        }
    }
} 