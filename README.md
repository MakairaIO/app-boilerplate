# Makaira App Boilerplate / Starterkit

[Symfony 6.1.2](https://symfony.com/) webapp as a starting point for creating makaira applications.
Contains custom authenticator for authorizing requests based on an HMAC as query parameter, as well as some basic makaira-like styling.


### Requirements

- PHP 8+
- Composer 2+
- [Symfony CLI](https://symfony.com/download)

### Local Setup

1. Run `composer install`

### Local Development

1. Run `symfony server:start --port=8000`
2. To start the local server with https, use ngrok: `ngrok http 8000`

### Use database for multi-tenant

1. Update docker-compose database local username/passwor and name of database
2. Update .env.local file database connection string (copy from .env file)
3. Run ```docker-compose up -d```
4. Access to docker container with command ```docker exec -it <container-name> bash
5. Login Mysql with command: ```mysql -u <username> <database> -p<password>
6. Run below command to add local test tenant: 
```
insert into app_info(makaira_domain, makaira_instance, app_slug, app_secret, app_config) value("demo.makaira.io", "storefront", "app-boilerplate", "e8d4e7defffc2055ab5646b0ad724960", NULL);
```
7. Start Local development
8. You can access with url: http://localhost:8000/?hmac=a6cb894d51b1d33bf8376d2d9455436ec9739acaa79ccf94c720decd9c47c217&nonce=123456&domain=demo.makaira.io&instance=storefront

### Additional Resources
- https://docs.makaira.io/docs/apps
- https://docs.makaira.io/docs/content-widgets
