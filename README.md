## 目次

- [目次](#目次)
- [参考リンク](#参考リンク)
- [WP環境について](#wp環境について)
  - [WordPress環境タイプの切り替えについて](#wordpress環境タイプの切り替えについて)
  - [動作環境](#動作環境)
- [ローカル環境セットアップ手順](#ローカル環境セットアップ手順)
- [本番環境へのアップロード](#本番環境へのアップロード)
- [ブラウザ同期（Browser Sync）](#ブラウザ同期browser-sync)
- [CSSから画像を参照する方法](#cssから画像を参照する方法)
- [アセットの扱い方](#アセットの扱い方)
- [Lintについて](#lintについて)
- [参考ドキュメント](#参考ドキュメント)
- [トラブルシュート](#トラブルシュート)

## 参考リンク

https://github.com/liginc/wp-starter-theme

## WP環境について

WordPressは常に最新のバージョンを取得する設定になっています。プロジェクト開始時に `.wp-env.json` を編集してWordPressとプラグインのバージョンを固定することを推奨しています。

- WP ver latest
- PHP ver 8.3

### WordPress環境タイプの切り替えについて

WordPressの環境タイプ（ローカル・本番）は、各WordPressインストールの `wp-config.php` で `WP_ENVIRONMENT_TYPE` 定数を設定することで制御できます。

例：

```php
// ローカル環境の場合
define("WP_ENVIRONMENT_TYPE", "local");

// 本番環境の場合
define("WP_ENVIRONMENT_TYPE", "production");
```

この設定により、テーマ内の `vite-config.php` などでアセットの参照先が自動的に切り替わります。
`wp-config.php` はWordPress本体の管理ファイルのため、リポジトリには含めません。
各環境ごとに個別に設定してください。

### 動作環境

- [Docker Desktop](https://hub.docker.com/editions/community/docker-ce-desktop-mac/)
- Node.js >= 18

## ローカル環境セットアップ手順

1. パッケージのインストール

```bash
npm ci or npm install
```

2. WP起動 & DBインポート

```bash
npm run wp:setup
```

3. フロントエンド開発サーバー起動

```bash
npm run dev
```

open <http://localhost:8000/>

wp-login open <http://localhost:8000/wp-admin>

```bash
user : admin
password : password
```

## 本番環境へのアップロード

```bash
npm run build
```

アップロードの際は`/dist`以下をアップロードしてください。

## ブラウザ同期（Browser Sync）

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

## CSSから画像を参照する方法

$base-dir は設定をするとCSSでローカルと本番で異なる参照をすることができます。

```scss
background-image: url($base-dir + "assets/images/icon-blank.svg");
```

## アセットの扱い方

ローカル環境ではVITEの開発サーバー、本番環境ではテーマのルートを参照する必要があるため基本的に`vite-config.php`の関数を使用してAssetsにアクセスしてください。

```php
<img src="<?= vite_src_images('sample-01.jpg') ?>" decoding="async" width="1280" height="800" alt="">
```

```php
<img src="<?= vite_src_images('icon-blank.svg') ?>" decoding="async" width="30" height="30" alt="">
```

## Lintについて

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

## 参考ドキュメント

- [wp-env](https://ja.wordpress.org/team/handbook/block-editor/reference-guides/packages/packages-env/)
- [vite](https://ja.vitejs.dev/)

## トラブルシュート

All-in-One WP Migrationでローカル環境のデータベースをエクスポートしてテストサイトにインポートした際に、テーマファイルが「src」になる

> [!NOTE]
> テーマは通常、Git管理され、CI/CDを通じてデプロイされるため、All-in-One WP Migrationのエクスポートに含めないことを推奨しています。<br>データベースのバックアップや移行が主な目的であれば、All-in-One WP Migrationでデータベースのみをエクスポートし、インポートすることが推奨されます。
