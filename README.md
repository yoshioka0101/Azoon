
## 作成した経緯

2021年3月から新型コロナの影響で所属していた学生団体（あしなが学生募金）もオンラインの活動がメインになった。
しかし、会議やボランティア募集などはスムーズにオンラインに移行できたものの、研修についてはかなり課題が多く残った。

## 抱える課題とその原因

・局員が動画を視聴していない

　　原因①：無料版slackでの送信なので過去の動画の内容がアーカイブとして残らない
  
  　　原因②：見るべき動画と見る必要のない動画がわかりづらい

・動画は視聴したけどアンケート答えてない

　　原因③：動画視聴の後にチャットに戻ってアンケートページに飛ばないといけない

・アップデートした内容がわかりにくい

　　原因④：URLが複数増えることになるので最新版が分かりにくい

・自分が見ている動画や見忘れている動画が確認できない

　　原因⑤：繁忙期になると動画が増えるので視聴済か未視聴かがわかりにくい


## 改善するための策

①ログインすれば動画が一覧ででてくる

②フォロー機能によって自分が所属する部署に必要な動画のみ出力される

③動画がページにアンケート機能を一緒に載せる

④更新時間が表示されるのでアップデートしたこともわかる

④新規投稿で必要な情報を簡単に動画を入力できるので動画の投稿、更新、削除がスムーズ

⑤チェックリストの作成をすることで自分の視聴済と未視聴が一覧でわかる

※原因の番号と策の番号を照らし合わせて改善案としています

## アプリの内容
**管理者画面**
- 動画の投稿、更新、削除
- ユーザー状況の把握(✅の有無)
- 管理者の権限付与と権限削除

**ユーザー画面**
- 動画の視聴
- 1つの動画に対する動画視聴者数が確認できる
- 自分が所属する部署の代表をフォローすることでその動画のみ出力できる
- 動画の検索機能


### DB情報
**Userテーブル**


|Column|Type|Options|comment|
|------|----|-------|------|
|id|integer|||
|name|string|||
|email|string|null:false||
|role|integer|default=0|1=管理者　0=一般ユーザー|

**memosテーブル**

|Column|Type|Options|comment|
|------|----|-------|------|
|id|integer|||
|content|string|default:null||
|title|string|null:false||
|user_id|integer|||
|image|string|null:false||
|url|integer|||
|status|integer|default=1|論理削除機能|


**memo_userテーブル**

|Column|Type|Options|comment|
|------|----|-------|------|
|id|integer|||
|user_id|integer|null:false||
|memo_id|integer|null:false||


**follow_userテーブル**

|Column|Type|Options|comment|
|------|----|-------|------|
|id|integer|||
|followed_user_id|integer|null:false|フォローされているユーザ||
|following_user_id|string|null:false|フォローしているユーザ||



**ユーザーページ**

| URL | method |user| メソッド名 | 内容 |
| --- | --- | --- | --- | --- |
| / | get | user |index | welcomeページ　 |
| /home | get | user | timeline | ホーム画面(ログイン後)　|
| /search | get | user | search | titleの検索機能 |
| /content/{id} | get | user |content | 投稿された動画の詳細ページ |
| /userlist | get | user | userlist | ユーザ一覧ページ |
| /content/{id}/favorite | post | user | store | 完了機能　|
| /content/{id}/unfavorite | post | user | destroy | 完了の取り消し機能　|
| /users/{user}/follow | post | user | follow | フォロー機能　|
| /users/{user}/unfollow | post | user | follow | フォロー取り消し機能　|
| /newpost | get | admin | newpost | 新規投稿ページ |
| /store | get | admin | store |  |
| /edit/{id} | get | admin | edit | 投稿したものを編集する |
| /update/{id} | post | admin | update |  |
| /delete/{id} | post | admin | delete | 投稿したものを削除する |
| /userdetail/{id} | get | admin | userdetail | 一般ユーザ(user)の詳細情報を表示する |
| /account/{id} | post | admin | account | 一般ユーザ(user)を管理者(admin)にする |
| /accountdelete/{id} | post | admin | accountdelete | 管理者(admin)を一般ユーザ(user)にする |

※userの欄にある”user”は一般ユーザで"admin"は管理者です


## 画面遷移

#### 管理者と一般ユーザの見分け方

管理者の場合

![スクリーンショット (220)](https://user-images.githubusercontent.com/88573934/155081532-2e080781-eac1-41e1-b343-d3ad963d55f9.png)

一般ユーザの場合

![スクリーンショット (221)](https://user-images.githubusercontent.com/88573934/155081564-cdb427b3-4bea-426d-bd2f-4a6d2df2cf51.png)

### 管理者のできること
#### ①ログイン画面

最初のログイン画面です

![ホーム画面](https://user-images.githubusercontent.com/88573934/155075900-95737082-8832-42c9-9555-fcddd085655b.png)

#### ②新規登録画面

メールアドレスなどを登録してないユーザが新規に情報を登録するための画面

![スクリーンショット (207)](https://user-images.githubusercontent.com/88573934/155076138-0e5b5e9e-fd79-4882-acb7-a528d3f22c78.png)


#### ③ログイン画面

既に登録してあるユーザのメールアドレスとパスワードの入力をするための画面

![スクリーンショット (208)](https://user-images.githubusercontent.com/88573934/155076096-44716400-d634-4b79-9949-294adbfa5cba.png)

#### ④ログイン後ホーム画面

ログインした後に最初にくる画面

**フォローなし**

user：test1

status:管理者

フォローなしのため動画なし

![フォローなしホーム](https://user-images.githubusercontent.com/88573934/155076353-01b0be28-73fb-4c61-ba40-e9598b1980c2.png)

**フォローあり**

user:test1

status:管理者

フォロー：test2

![スクリーンショット (211)](https://user-images.githubusercontent.com/88573934/155078478-6813893d-5945-4560-b74d-1ebcab5d1086.png)


#### ⑤動画の詳細画面

④のにあるタイトルのURLをクリックすると表示される動画の詳細画面



test1がtest2の投稿した動画を見るための画面（画面の全体が見える状態にしています）

![スクリーンショット (213)](https://user-images.githubusercontent.com/88573934/155078527-dc6bc85c-e5e9-42cd-8a96-ebb30162a8f8.png)

**完了ボタン実行後**

"完了"を実行すると視聴済みに☑がつきます

![スクリーンショット (219)](https://user-images.githubusercontent.com/88573934/155080577-ab017fa9-5477-45d6-9142-2d1b30d669b1.png)



#### ⑥動画の編集画面

投稿した動画のタイトル、コンテンツ、動画の内容、URLを変更できる画面

![スクリーンショット (214)](https://user-images.githubusercontent.com/88573934/155078697-a3f07acf-7bdc-4f4a-a54a-92e14fb184be.png)


#### ⑦新規動画の投稿画面

投稿する新規の動画投稿画面

![スクリーンショット (210)](https://user-images.githubusercontent.com/88573934/155076891-b772d750-8e81-4c1a-8374-f667be1e29e2.png)

#### ⑧ユーザ情報一覧

登録してあるユーザの情報を一覧で表示した画面

![スクリーンショット (215)](https://user-images.githubusercontent.com/88573934/155078931-b80d6af0-f4c9-41df-883d-a9c849ed02dc.png)


#### ⑨ユーザ情報詳細一覧

⑧から各ユーザーの名前をクリックすると対象のユーザ詳細情報が出力される画面

**指定されたユーザ詳細が管理者である場合**

test2の詳細情報を出力

test2のステータスは管理者

管理者の場合は"管理者削除する"が出力される

![スクリーンショット (218)](https://user-images.githubusercontent.com/88573934/155079608-3a128acb-4b0f-45df-8582-791aa857effb.png)

**指定されたユーザ詳細が一般ユーザである場合**

test2の"管理者削除する"を実行すると以下の画面になる

![スクリーンショット (217)](https://user-images.githubusercontent.com/88573934/155079621-33087386-7d3e-451d-a662-aa313fc0b5e5.png)

#### ⑩検索機能

コンテンツがいくつかある場合に名前を検索すればそれのみ出てくるようになります

**検索しないで情報が多い画面**

![スクリーンショット (224)](https://user-images.githubusercontent.com/88573934/155084288-a228411d-da19-42eb-869a-b2992a50638d.png)


**検索する**

![スクリーンショット (225)](https://user-images.githubusercontent.com/88573934/155084461-2f65f033-e39d-441e-abda-aa295a74b784.png)


**※一般ユーザは動画の投稿、編集、削除、できないようになっています**

画面のように編集、削除に関するボタンが消えています

![スクリーンショット (226)](https://user-images.githubusercontent.com/88573934/155084836-0434ab6d-f248-4cea-b79a-cbb320e8f7e3.png)

