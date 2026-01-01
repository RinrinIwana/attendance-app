Dockerビルド

git clone [git@github.com](mailto:git@github.com):Estra-Coachtech/laravel-docker-template.git
docker compose up -d --build
※MacのM1・M2チップのPCの場合、no matching manifest for linux/arm64/v8 in the manifest list entriesのメッセージが表示されビルドができないことがあります。 エラーが発生する場合は、docker-compose.ymlファイルの「mysql」内に「platform」の項目を追加で記載してください。
mysql: platform: linux/x86_64(この文追加) image: mysql:8.0.26 environment:


Laravel環境構築

docker compose exec php bash
composer install
cp .env.example .env
.env.exampleファイルから .envを作成し、環境変数を変更
.envに以下の環境変数を追加
DB_CONNECTION=mysql DB_HOST=mysql DB_PORT=3306 DB_DATABASE=laravel_db DB_USERNAME=laravel_user DB_PASSWORD=laravel_pass
アプリケーションキーの作成 php artisan key:generate
マイグレーションの実行 php artisan migrate
シーディングの実行 php artisan db:seed
ランダムダミーデータ作成　php artisan migrate:fresh --seed


使用技術(実行環境) 
PHP8.3.0 
Laravel8.83.27 
MySQL8.0.26

ER図
![名称未設定ファイル](https://github.com/user-attachments/assets/be28404c-33c1-4894-9c30-9148bb9590da)


URL
開発環境：http://localhost/
phpMyAdmin:：http://localhost:8080/
