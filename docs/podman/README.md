# Podman Quadlet

To learn more about Podman Quadlet, consider reading the following resources:

- <https://docs.podman.io/en/latest/markdown/podman-systemd.unit.5.html>
- <https://www.redhat.com/sysadmin/quadlet-podman>
- <https://mo8it.com/blog/quadlet/>

## Prerequisites

- Linux (Fedora, CentOS Stream, Debian, Ubuntu, Arch).
- [Podman 5.2 or higher](https://podman.io/), with Quadlet (systemd) and SELinux support.

It's recommend running a rootless setup:

- <https://github.com/containers/podman/blob/main/docs/tutorials/rootless_tutorial.md>
- <https://wiki.archlinux.org/title/Podman#Rootless_Podman>

## Installation

### Build containers

Build the Docker images (this may take some time):

```bash
cd ~/projects/foxws
./docs/podman/make
```

To rebuild with no-cache (or any other args):

```bash
cd ~/projects/foxws
./docs/podman/make --no-cache
```

### Systemd units

Copy the `systemd` directory to `~/.config/containers`, verify the path `~/.config/containers/systemd/foxws` exists:

```bash
cd ~/projects/foxws
cp -r docs/podman/containers/systemd ~/.config/containers/
```

Adjust environment files in `~/.config/containers/systemd/foxws/config`, update `~/projects/foxws/.env` to reflect any systemd unit changes:

```bash
cd ~/.config/containers/systemd/foxws/config
vi app.env dev.env ..
```

### Configure Proxy

[Traefik](https://doc.traefik.io/traefik/) is used as proxy. However you are free to use something else, or not even proxy at all.

It is possible to use [Let's Encrypt](https://doc.traefik.io/traefik/https/acme/), or use your [own certificate](https://doc.traefik.io/traefik/https/tls/).

The given configuration assumes you use a TLS with Let's Encrypt.

Adjust the environment files in `~/.config/containers/systemd/traefik/config`, and make sure `podman.socket` is enabled:

```bash
systemctl --user enable podman.socket --now`
```

To import a custom certificate, prefer the usage of [secrets](https://www.redhat.com/sysadmin/new-podman-secrets-command):

```bash
podman secret create tlscert ~/.config/containers/systemd/traefik/certs/cert.pem
podman secret create tlskey ~/.config/containers/systemd/traefik/certs/key.pem
```

To import auth tokens for DNS-challenges:

```bash
printf "dop_v1_TOKENSTRING" | podman secret create do_auth_token
```

To passport protect the Traefik dashboard, generate an [user:password pair](https://doc.traefik.io/traefik/middlewares/http/basicauth/#usersfile):

```bash
sudo dnf install httpd-tools
echo -n $(htpasswd -nB user) > ./usersfile
podman secret create usersfile ./usersfile
```

Finally restart Traefik:

```bash
systemctl --user restart traefik.service
```

You will now able to access <https://traefik.foxws.nl/> with the generated `user:password`, and the Foxws-instance on <https://foxws.nl/>.

## Usage

Make sure to reload systemd on configuration changes:

```bash
systemctl --user daemon-reload
systemctl --user restart foxws
```

To start Foxws:

```bash
systemctl --user start foxws
```

To stop Foxws:

```bash
systemctl --user stop foxws
```

## Shell utility

Foxws provides the shell utility named `foxws`, and is based on [Laravel Sail](https://github.com/laravel/sail/blob/1.x/bin/sail) with adjustments made for Podman Quadlet.

To install, create a shell `alias`, e.g. using [fish-shell](https://fishshell.com/docs/current/cmds/alias.html):

```fish
alias --save foxws '~/projects/foxws/bin/quadlet'
```

This allows to interact with the `systemd-foxws-app` container using the same syntax like Laravel Sail:

```fish
foxws help
foxws shell
foxws a scout:sync
```
