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

docker run -td -p 8080:8080 -p 50000:50000 --name jenkins jenkins/jenkins:lts-jdk11 # Running in background

docker logs jenkins -f # See logs to obtain credentials

docker exec -it jenkins bash # Bash shell inside container

cat /var/jenkins_home/secrets/initialAdminPassword # Print initial admin password for jenkins

docker rm -f jenkins # Force deletion

# NOTE: Avoid using a bind mount from a folder on the host machine into /var/jenkins_home, as this might result in file permission issues (the user used inside the container might not have rights to the folder on the host machine). If you really need to bind mount jenkins_home, ensure that the directory on the host is accessible by the jenkins user inside the container (jenkins user - uid 1000)

docker run -td -p 8080:8080 -p 50000:50000 \
    --name jenkins \
    -v jenkins_home:/var/jenkins_home \
    jenkins/jenkins:lts-jdk11 # Running in background with persistent data

# NOTE: if you want to use a directory as a persisnten data, you should pass the absolute path and confirm the permissions.

docker volume ls # List volumes created

## Setup jenkins before continue

docker rm -f jenkins # Force deletion

# Run again a new container to show persistency 

docker run -td -p 8080:8080 -p 50000:50000 \
    --name jenkins \
    -v jenkins_home:/var/jenkins_home \
    jenkins/jenkins:lts-jdk11 # Running in background with persistent data




```