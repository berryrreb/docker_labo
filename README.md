# Docker Workshop

Docker laboratory for the DOU/TechM University class.

## Prerrequisites

+ Docker desktop · [Download](https://hub.docker.com/editions/community/docker-ce-desktop-mac)

## Launch Jenkins Container

```sh
docker pull jenkins/jenkins:lts-jdk11 # To pull the latest jenkins docker image
docker images # To see images list

docker run -p 8080:8080 -p 50000:50000 --name jenkins jenkins/jenkins:lts-jdk11 # Start container

docker rm jenkins # Delete container

docker run -p 8080:8080 -p 50000:50000 --name jenkins jenkins/jenkins:lts-jdk11 # Running in background

docker rm jenkins # Force deletion

docker logs jenkins # See logs to obtain credentials

docker exec -it jenkins bash # Bash shell inside container

cat /var/jenkins_home/secrets/initialAdminPassword # Print initial admin password for jenkins



```