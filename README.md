# Foxws

## Introduction

This is the [Foxws.nl](https://foxws.nl/) source-code.

## Installation

Run installer:

```bash
foxws a app:install
```

Update site-index `extra` field with:

```json
{"meilisearch":{"url":"http:\/\/systemd-foxws-meilisearch:7700","apiKey":"MELISEARCH_API_KEY"}}
```

## Deploy

```bash
php vendor/bin/envoy run deploy
```

## Stack

- Based on [Laravel Beyond CRUD](https://laravel-beyond-crud.com/) (DDD)
- [Livewire V3](https://livewire.laravel.com/)
- [WireUse](https://github.com/foxws/wireuse)
- [Traefik](https://traefik.io/traefik/)
