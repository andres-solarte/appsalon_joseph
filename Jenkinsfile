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

        stage('Instalar PHPUnit y ejecutar pruebas') {
            steps {
                sh '''
                    docker compose run --rm appsalon /usr/bin/composer require phpunit/phpunit --dev
                    docker compose run --rm appsalon ./vendor/bin/phpunit --configuration phpunit.xml
                '''
            }
        }

        stage('Desplegar') {
            steps {
                sh 'echo "MYSQL_DATABASE=appsalon_joseph\nMYSQL_USER=appuser\nMYSQL_PASSWORD=secret\nMYSQL_ROOT_PASSWORD=rootsecret" > .env'
                sh 'docker compose up -d appsalon'
            }
        }
    }
}