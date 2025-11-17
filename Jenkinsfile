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
                sh 'docker compose build appsalon'
            }
        }

        stage('Ejecutar pruebas') {
            steps {
                echo 'Ejecutando pruebas...'
            }
        }

        stage('Desplegar') {
            steps {
                sh "echo '
                MYSQL_DATABASE=appsalon_joseph
                MYSQL_USER=appuser
                MYSQL_PASSWORD=secret
                MYSQL_ROOT_PASSWORD=rootsecret
                ' > .env"
                sh 'docker compose up -d appsalon'
            }
        }
    }
}