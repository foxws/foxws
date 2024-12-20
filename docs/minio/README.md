# MinIO

To learn more about MinIO, consider reading the following resources:

- <https://min.io/>
- <https://min.io/docs/minio/linux/reference/minio-mc.html>

## Prerequisites

- Foxws up-and-running
- MinIO Client `mcli` (included in app container)

## Usage

1. Create an access key (<https://mc.foxws.nl/access-keys>).

2. Update `AWS_ACCESS_KEY_ID` and `AWS_SECRET_ACCESS_KEY` environment keys.

3. Enter the app container:

```bash
foxws shell
```

4. Setup connection:

```bash
mcli alias set myminio http://systemd-foxws-minio:9000 AWS_ACCESS_KEY_ID
mcli admin info myminio
```

5. Create buckets:

```bash
mcli mb myminio/assets
mcli mb myminio/conversions
mcli mb myminio/local
```

6. Set anonymous permissions:

```bash
mcli anonymous set download myminio/assets
mcli anonymous set download myminio/conversions
```

## Disable bucket listing

The following steps are optional, but highly recommended on production.

1. Export current bucket permissions:

```bash
cd /tmp
mcli anonymous get-json myminio/assets > assets.json
mcli anonymous get-json myminio/conversions > conversions.json
```

2. Remove the `"s3:ListBucket"` from the `Action` array in each `<bucket>.json` file:

```bash
vi assets.json
vi conversions.json
```

3. Update the bucket policy:

```bash
mcli anonymous set-json assets.json myminio/assets
mcli anonymous set-json conversions.json myminio/conversions
rm -rf assets.json conversions.json
```

## Migrate data

To copy any local stored generated conversions to a backup:

```bash
mcli cp --recursive conversions/ myminio/conversions/
```
