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

### Additional Resources
- https://docs.makaira.io/docs/apps
- https://docs.makaira.io/docs/content-widgets
