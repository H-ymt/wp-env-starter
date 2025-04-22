# wp-env Starter

## Reference

https://github.com/liginc/wp-starter-theme

## WP Environment

WordPressは常に最新のバージョンを取得する設定になっています。プロジェクト開始時に `.wp-env.json` を編集してWordPressとプラグインのバージョンを固定することを推奨しています。

- WP ver latest
- PHP ver 8.3

## Usage Environment

- [Docker Desktop](https://hub.docker.com/editions/community/docker-ce-desktop-mac/)
- Node.js >= 18

## Local Environment Setup

1. package install

```bash
npm ci or npm install
```

2. wp start up & db import

```bash
npm run wp:setup
```

3. frontend build start

```bash
npm run dev
```

open <http://localhost:8000/>

wp-login open <http://localhost:8000/wp-admin>

```bash
user : admin
password : password
```

## Production Upload

```bash
npm run build
```

アップロードの際は`/dist`以下をアップロードしてください。

## Browser Sync

このプロジェクトでは、Viteサーバーのネットワークアクセスのために .wp-env.json ファイルで VITE_SERVER を指定しています。

```json
"VITE_SERVER": "http://0.0.0.0:3000"
```

デフォルトでは 0.0.0.0 が指定されており、ローカルネットワーク上の他のデバイスからアクセスすることが可能です。

ネットワーク経由でのアクセスが必要な場合、`npm run dev`を実行した際にNetwork部分に表示されるIPアドレスをVITE_SERVERの値に一時的に変更する必要があります。
例えば、IP アドレスが 100.00.0.000 の場合は以下のように設定します。

```json
"VITE_SERVER": "http://100.00.0.000:3000"
```

※.wp-env.json は Git 管理されているため、ネットワークアクセスのための変更はコミットしないようにしてください。<br />暫定的な変更として行い、変更が不要になったら元に戻すか、変更を破棄してください。

VITE_SERVERの値を反映するために以下のコマンドを実行します。

```bash
npm run wp:restart
```

BrowserSyncを利用して複数デバイス間での同期を実現しています。起動後は3030番でアクセスできます。

open <http://100.00.0.000:3030/>

## How to reference images from Css

$base-dir は設定をするとCSSでローカルと本番で異なる参照をすることができます。

```scss
background-image: url($base-dir + "assets/images/icon-blank.svg");
```

## Assets

ローカル環境ではVITEの開発サーバー、本番環境ではテーマのルートを参照する必要があるため基本的に`vite-config.php`の関数を使用してAssetsにアクセスしてください。

```php
<img src="<?= vite_src_images('sample-01.jpg') ?>" decoding="async" width="1280" height="800" alt="">
```

```php
<img src="<?= vite_src_images('icon-blank.svg') ?>" decoding="async" width="30" height="30" alt="">
```

## Lint

```bash
npm run lint:check
```

```bash
npm run lint:fix
```

Lint はプリコミット時に必ず実行されます。以下の vscode プラグインをインストールすると vscode 保存時にも Lint を実行することができます。

- [prettier](https://marketplace.visualstudio.com/items?itemName=esbenp.prettier-vscode)
- [markuplint](https://marketplace.visualstudio.com/items?itemName=yusukehirao.vscode-markuplint)
- [stylelint](https://marketplace.visualstudio.com/items?itemName=stylelint.vscode-stylelint)
- [eslint](https://marketplace.visualstudio.com/items?itemName=dbaeumer.vscode-eslint)

## Document

- [wp-env](https://ja.wordpress.org/team/handbook/block-editor/reference-guides/packages/packages-env/)
- [vite](https://ja.vitejs.dev/)

## Trouble Shoot

All-in-One WP Migrationでローカル環境のデータベースをエクスポートしてテストサイトにインポートした際に、テーマファイルが「src」になる

> [!NOTE]
> テーマは通常、Git管理され、CI/CDを通じてデプロイされるため、All-in-One WP Migrationのエクスポートに含めないことを推奨しています。<br>データベースのバックアップや移行が主な目的であれば、All-in-One WP Migrationでデータベースのみをエクスポートし、インポートすることが推奨されます。
