# WordPress + Vite + Docker 開発環境

Docker、Vite、WP-Env を使用して WordPress のローカル開発環境を構築します。

Ref: [https://github.com/Masahiro-web/simple-wp-dev](https://github.com/Masahiro-web/simple-wp-dev)

## 開発環境側でインストールが必要なもの

- Node.js (v22 以上)
- Docker と Docker Compose
- npm または yarn

## セットアップ

環境の起動時に Docker が実行されていることを確認してください。

1. リポジトリをクローン
2. 依存関係のインストール

   ```bash
   npm install
   ```

3. WordPress 環境の起動

   ```bash
   npm run wp-env start
   ```

4. フロントエンド開発サーバーの起動

   ```bash
   npm run dev
   ```

   または、一度に両方を起動

   ```bash
   npm run start
   ```

   phpmyadmin も同時起動する場合

   ```bash
   npm run setup
   ```

## 開発

- WordPress 環境は `http://localhost:8888` でアクセスできます
  - 管理画面: `http://localhost:8888/wp-admin/`
  - ユーザー名: `admin`
  - パスワード: `password`
- フロントエンドの開発には Vite を使用します（`http://localhost:3000`）
- テーマの変更は `./theme` ディレクトリ内で行います
- ソースファイルは `./theme/src` ディレクトリにあります

## 主な npm コマンド

- `npm run start` - WordPress 環境と Vite 開発サーバーを同時に起動
- `npm run setup` - WordPress 環境と Vite 開発サーバーを同時に起動（phpmyadmin のコンテナも構築する）
- `npm run wp-env start` - WordPress の Docker 環境のみを起動
- `npm run dev` - Vite 開発サーバーのみを起動
- `npm run stop` - WordPress 環境を停止
- `npm run destroy` - WordPress 環境を完全に削除（データも削除）
- `phpmyadmin:start` - phpmyadmin を起動する
- `phpmyadmin:stop` - phpmyadmin を停止する

### データベースのバックアップ

SQL ファイルとしてデータベースをエクスポートするには、以下のコマンドを使用します。
バックアップファイルは sql ディレクトリに日付付きのファイル名（例: backup-20250519.sql）で保存されます。

```bash
# Linux/Mac環境の場合
npm run db:export

# Windows環境の場合
npm run db:export:win
```

### データベースのリストア

バックアップからデータベースを復元するには、以下のコマンドを使用します。

```bash
# 特定のファイルを指定して復元
npm run db:import ./sql/バックアップファイル名.sql

# 例
npm run db:import ./sql/backup-20250519.sql
```

## ビルド

本番環境用にビルドするには、以下のコマンドを実行してください。

```bash
npm run build
```

これにより、`/theme/dist` ディレクトリにビルドされたアセットが生成されます。

## フォルダ構造

```plaintext
.
├── theme/                  # WordPressテーマディレクトリ
│   ├── dist/               # ビルドされたアセット（JS, CSS）
│   ├── src/                # ソースファイル
|   |   ├── images/         # 画像ファイル（scss内でbackground-image等で指定されたファイルのみ格納する）
│   │   ├── js/             # JavaScriptファイル
│   │   │   └── main.js     # メインのJavaScriptファイル
│   │   └── scss/           # SCSSファイル
│   │       └── style.scss  # メインのスタイルファイル
│   ├── functions.php       # WordPressテーマ機能
│   ├── index.php           # メインテンプレートファイル
│   └── ...                 # その他のテーマファイル
├── sql/                    # データベースバックアップ
│   └── backup-*.sql        # バックアップファイル
├── package.json            # npm設定とスクリプト
├── vite.config.js          # Vite設定ファイル
├── tailwind.config.js      # Tailwind CSS設定
├── postcss.config.js       # PostCSS設定
└── .wp-env.json            # WordPress環境設定
```

## 環境設定

### 環境タイプの設定

WordPress の `WP_ENVIRONMENT_TYPE` を使用して環境を判定し、アセットの読み込み方法を選択しています。

#### ローカル開発環境

`.wp-env.json` で `WP_ENVIRONMENT_TYPE` を `local` に設定しています：

```json
{
  "config": {
    "WP_ENVIRONMENT_TYPE": "local"
  }
}
```

ローカル環境では、Vite 開発サーバー（`http://localhost:3000`）からアセットをホットリロード対応で読み込みます。

#### 本番・ステージング環境

本番環境およびステージング環境では、`wp-config.php` に以下の設定を追加してください：

```php
define("WP_ENVIRONMENT_TYPE", "production");
```

`production` 環境では、ビルド済みのアセット（`/theme/dist/` ディレクトリ内）を読み込みます。

### アセット読み込みの仕組み

- **local 環境**: Vite 開発サーバーから直接読み込み（HMR対応）
- **production 環境**: ビルド済みファイルを manifest.json を参照して読み込み

この設定により、開発時は高速なホットリロードを利用でき、本番環境では最適化されたアセットを配信できます。

## 注意事項

- ビルド時に Tailwindcss の記述が dist の css に含まれますが不要な場合は`/src/scss/style.scss`の 1 行目を削除してください。
- `/src/scss/style.scss`で指定された背景画像ファイルは`/src/images/`ディレクトリに格納してください。
