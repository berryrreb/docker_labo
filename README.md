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