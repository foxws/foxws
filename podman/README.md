# Podman Quadlet

The given instructions are tested on Fedora 40 with Podman 5.0.2 (rootless).

We recommend running containers rootless:

- <https://github.com/containers/podman/blob/main/docs/tutorials/rootless_tutorial.md>
- <https://wiki.archlinux.org/title/Podman#Rootless_Podman>
- <<https://doc.traefik.io/traefik/middlewares/http/basicauth/>

## Installation

Build the custom images:

```bash
./make
```

Copy the `systemd` directory to `~/.config/containers`, verify `~/.config/containers/systemd/foxws.container` exists.

Adjust environment files in `~/.config/containers/systemd/foxws`. Values should reflect the settings used in the foxws-project `.env`.

### Configure Proxy (optional)

[Traefik](https://doc.traefik.io/traefik/) is used as proxy. However you are free to use something else, or not even proxy at all.

It is also possible to use [Let's Encrypt](https://doc.traefik.io/traefik/https/acme/), or use your [own certificates](https://doc.traefik.io/traefik/https/tls/) for local development.

Adjust the configuration files in `~/.config/containers/systemd/traefik`, and make sure `podman.socket` is enabled (`systemctl --user enable podman.socket --now`).

To import certificates, it is recommended to use [secrets](https://www.redhat.com/sysadmin/new-podman-secrets-command):

```bash
podman secret create tlscert ~/.config/containers/systemd/traefik/certs/cert.pem
podman secret create tlskey ~/.config/containers/systemd/traefik/certs/key.pem
```

> **TIP:** Checkout [mkcert](https://github.com/FiloSottile/mkcert) for using TLS locally.

### Networking

```bash
podman network create systemd-internal
podman network create systemd-foxws
```

## Usage

To apply container changes:

```bash
systemctl --user daemon-reload
```

To start Foxws:

```bash
systemctl --user start foxws.service
```

To learn more about Podman Quadlet, the following resources may be useful:

- <https://docs.podman.io/en/latest/markdown/podman-systemd.unit.5.html>
- <https://www.redhat.com/sysadmin/quadlet-podman>
- <https://mo8it.com/blog/quadlet/>
