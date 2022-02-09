
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
