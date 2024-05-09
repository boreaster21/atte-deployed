# Atte
![image](https://github.com/boreaster21/fortify/assets/155618258/cfe27972-78fa-49cd-8c8c-a5e5e4392c4b)
どんなアプリか：ある企業の勤怠管理システム

## 目的
なぜ作成したか：人事評価のため

## URL
http://52.195.217.115

## 機能一覧
会員登録機能<br>
ログイン機能<br>
ログアウト機能<br>
メール認証機能<br>
打刻機能（勤務開始/終了、休憩開始/終了）<br>
日跨ぎ自動打刻機能<br>
日付別勤怠情報取得機能<br>
ユーザー検索機能<br>
ページネーション機能<br>

## 使用技術
PHP 8.2.15<br>
Laravel Framework 8.83.27<br>
Docker version 25.0.3,<br>
nginx/1.24.0<br>
mysql  Ver 8.0.37<br>
git version 2.40.1<br>

## ER図
![image](https://github.com/boreaster21/fortify/assets/155618258/5f4f2e26-6102-4900-add8-4098775f1390)

## テーブル設計
#Userテーブル
id | type | 
-|-|-
id	unsigned bigint
name | string
email | string
email_verified_at | timestamp
password | string
rememberToken | rememberToken
two_factor_secret |  	
two_factor_recovery_codes | timestamp
created_at | timestamp
updated_at | timestamp

## 環境構築
実行用コマンド

## 他リポジトリ
特になし
