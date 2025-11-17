pipeline {
    agent any

    environment {
        DOCKER_HOST = 'unix:///var/run/docker.sock'
    }

    stages {

        stage('Verificar version de Docker y Docker Compose') {
            steps {
                sh 'docker version'
                sh 'docker compose version'
            }
        }

        stage('Construir contenedor de la aplicación') {
            steps {
                echo 'Building...'
            }
        }

        stage('Desplegar') {
            steps {
                echo 'docker compose up -d'
            }
        }
    }
}