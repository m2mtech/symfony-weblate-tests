# Symfony Weblate Tests

[![Author](https://img.shields.io/badge/author-@m2mtech-blue.svg?style=flat-square)](http://www.m2m.at)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

---

This bundle provides functional tests for the [Weblate translation provider](https://github.com/m2mtech/weblate-translation-provider).

It allows testing different php (7.2 to 8.1) and Symfony (5.3 to 6.0) versions against a locally installed Weblate instance

## Installation

Clone the project:

```bash
git clone git@github.com:m2mtech/symfony-weblate-tests.git
```

Change the settings for Weblate:

```dotenv
# .env
WEBLATE_SITE_DOMAIN=weblate:8080
WEBLATE_ADMIN_EMAIL=YOUR@EMAIL.ADDRESS
WEBLATE_ADMIN_PASSWORD=YOURPASSWORD
```

Start Weblate (this might take some time - especially the first setup):

```bash
docker-compose up -d weblate
```

Login to your Weblate instance using the email address and password you have set above @ http://localhost:8080

Create a new project in Weblate @ http://localhost:8080/create/project/ 

Create a new API key for the project @ http://localhost:8080/access/PROJECT_SLUG/#api or alternatively use your personal key which you can find @ http://localhost:8080/accounts/profile/#api

Use this data to set up the test apps:

```dotenv
// app53/.env, app54/.env, app60/.env 

WEBLATE_DSN=weblate://PROJECT_SLUG:API_TOKEN@weblate:8080
```

Because this package is used for the development of the [Weblate-translation-provider bundle](https://github.com/m2mtech/weblate-translation-provider) it expects to find it in the root directory of the package. Clone it into the root directory:

```bash
git clone git@github.com:m2mtech/weblate-translation-provider.git
```

Alternatively, you can delete the repositories section in the composer.json files.

## Usage

Don't forget to start Weblate:

```bash
docker-compose up -d weblate
```

Start the php version you want to test:

```bash
docker-compose run php72 bash
// or
docker-compose run php73 bash
// or
docker-compose run php74 bash
// or
docker-compose run php8 bash
// or
docker-compose run php81 bash
```

Choose the Symfony version you want to test load all packages:

```bash
cd app53
// or
cd app54
// or
cd app60

composer update
```

Start testing (this might take some time):

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information about recent changes.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
