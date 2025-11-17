pipeline {
    agent any

    environment {
        DOCKER_HOST = 'unix:///var/run/docker.sock'
    }

    stages {

        stage('Verificar version de Docker') {
            steps {
                echo 'docker version'
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