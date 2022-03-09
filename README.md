# Docker Workshop

Docker laboratory for the DOU/TechM University class.

## Prerequisites

+ Docker desktop · [Download](https://hub.docker.com/editions/community/docker-ce-desktop-mac)
+ Visual Studio Code (Recommended) · [Download](https://code.visualstudio.com/download)

## Launch Jenkins Container

Pull the latest jenkins docker image
```bash
docker pull jenkins/jenkins:lts-jdk11
```

To see images list
```bash
docker images
```

Start container
```bash
docker run -p 8080:8080 -p 50000:50000 --name jenkins jenkins/jenkins:lts-jdk11
```

Delete container
```bash
docker rm jenkins
```

Running in background
```bash
docker run -td -p 8080:8080 -p 50000:50000 --name jenkins jenkins/jenkins:lts-jdk11
```

See logs to obtain credentials
```bash
docker logs jenkins -f
```

Bash shell inside container
```bash
docker exec -it jenkins bash
```

Print initial admin password for jenkins
```bash
cat /var/jenkins_home/secrets/initialAdminPassword
```

Force deletion
```bash
docker rm -f jenkins
```

> NOTE: Avoid using a bind mount from a folder on the host machine into /var/jenkins_home, as this might result in file permission issues (the user used inside the container might not have rights to the folder on the host machine). If you really need to bind mount jenkins_home, ensure that the directory on the host is accessible by the jenkins user inside the container (jenkins user - uid 1000)

Running in background with persistent data
```bash
docker run -td --name jenkins \
    -p 8080:8080 \
    -p 50000:50000 \
    -v jenkins_home:/var/jenkins_home \
    jenkins/jenkins:lts-jdk11
```

> NOTE: If you want to use a directory as a persisnten data, you should pass the absolute path and confirm the permissions.

> NOTE: The volume is automatically created by the docker run command.

List volumes created
```bash
docker volume ls
```

> **⚠ Setup jenkins before continue**

Force deletion
```bash
docker rm -f jenkins
```

Run again a new container to show persistency 
```bash
docker run -td -p 8080:8080 -p 50000:50000 \
    --name jenkins \
    -v jenkins_home:/var/jenkins_home \
    jenkins/jenkins:lts-jdk11
```

## Expose Jenkins behind Nginx

Run nginx container
```bash
docker run -td --name nginx \
    -p 1080:80 \
    --link jenkins:jenkins \
    -v nginx_conf.d:/etc/nginx/conf.d \
    nginx
```

Bash shell inside nginx container
```bash
docker exec -it nginx bash
```

### Inside the container

Install vim
```bash
apt update && apt install -y vim
```

Create configuration file to expose jenkins behind nginx
```bash
vim /etc/nginx/conf.d/jenkins.conf
```
> Add jenkins.conf content

Reload nginx
```bash
nginx -s reload
```

> **⚠ Don't forget to add jenkins entry to hosts file**

Append line to /ets/host file to point the hostame to the ip address
```bash
echo '127.0.0.1 jenkins.dou_university.com' | sudo tee -a /etc/hosts
```
> **Open the URL in your browser**

[jenkins.dou_university.com:1080](http://jenkins.dou_university.com:1080)

## Run the complete environment with Docker Compose

Start full compose application
```bash
docker-compose -f docker-labo-compose/jenkinsNginxCompose.yaml up -d
```

Stop and remove resources for compose
```bash
docker-compose -f docker-labo-compose/jenkinsNginxCompose.yaml down
```

### docker-compose available commands
```bash
Commands:
  build              Build or rebuild services
  config             Validate and view the Compose file
  create             Create services
  down               Stop and remove resources
  events             Receive real time events from containers
  exec               Execute a command in a running container
  help               Get help on a command
  images             List images
  kill               Kill containers
  logs               View output from containers
  pause              Pause services
  port               Print the public port for a port binding
  ps                 List containers
  pull               Pull service images
  push               Push service images
  restart            Restart services
  rm                 Remove stopped containers
  run                Run a one-off command
  scale              Set number of containers for a service
  start              Start services
  stop               Stop services
  top                Display the running processes
  unpause            Unpause services
  up                 Create and start containers
  version            Show version information and quit
```

## Docker build example

Creation of a Dockerfile

```docker
FROM php:7.4-apache

WORKDIR /var/www/html
COPY php/index.php ./
EXPOSE 80
```

Build image
```bash
docker build -t university/php-app .
```

List images
```bash
docker images
```

Run container from new custom image
```bash
docker run -it --name university-php -p 2080:80 university/php-app
```

### Helpful commands for cleanup
```bash
docker system prune

docker system prune -a
```