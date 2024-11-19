---
title: Hub
summary: A video on demand (VOD) media distribution system.
type: personal
order: 3
github: https://github.com/francoism90/hub
tags:
  - laravel
  - livewire
  - streaming
  - vod
---

## What is Hub?

Hub is a video on demand (VOD) media distribution system that allows users to access to videos, television shows and films.

This is a personal project, please do not expect a production ready product.
It is mainly intended for learning and testing Laravel features.

You can fork the project and make your own adjustments based on my changes.

## What feature stack does Hub use?

It uses the following stack:

- Laravel 11.x with Pulse, Scout, Horizon and Reverb
- Livewire 3.x with latest [WireUse](https://foxws.nl/projects/wireuse)
- TailwindCSS
- AlpineJS
- Meilisearch
- Podman 5.x

For streaming, the [nginx-vod-module](https://github.com/kaltura/nginx-vod-module) is being used.
It is a very flexible nginx module, which can also be used to dynamically retrieve content of videos and streaming them to end-users.

To learn more, please visit the [GitHub repository](https://github.com/francoism90/hub).
