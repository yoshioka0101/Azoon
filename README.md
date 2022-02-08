
## 作成した経緯

2021年3月から新型コロナの影響で所属していた学生団体（あしなが学生募金）もオンラインの活動がメインになった。
しかし、会議やボランティア募集などはスムーズにオンラインに移行できたものの、研修についてはかなり課題が多く残った。

## 抱える課題

・局員が動画を視聴していない→仕組み化できていない
・動画は視聴したけどアンケート答えてない→管理者がアンケートを流してない場合もある
・アップデートした内容がわかりにくい→URLが複数増えることになるので最新版が分かりにくい
・無料版slackでの送信なので過去の動画の内容がアーカイブとして残らない
・自分が見ている動画や見忘れている動画が確認できない


## 改善できる課題

・ログインすれば動画が一覧ででてくる
・動画がページにアンケート機能を一緒に載せる
・更新時間が表示されるのでアップデートしたこともわかる
・新規投稿で必要な情報を簡単に動画を入力できるので動画の投稿、更新、削除がスムーズ
・チェックリストの作成をすることで自分の視聴済と未視聴が一覧でわかる
・フォロー機能によって自分が所属する部署に必要な動画のみ出力される

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

|Column|Type|Options|
|------|----|-------|
|id|integer|null:false|
|name|string|null:false|
|email|string|null:false|
|role|integer|default=0|

**memosテーブル**

|Column|Type|Options|
|------|----|-------|
|id|integer|null:false|
|content|string|default:null|
|title|string|null:false|
|user_id|integer|default=0|
|image|string|null:false|
|url|integer|default=0|
|status|integer|default=1|


**memo_userテーブル**

|Column|Type|Options|
|------|----|-------|
|id|integer|null:false|
|user_id|integer|null:false|
|memo_id|integer|null:false|


**follow_userテーブル**

|Column|Type|Options|
|------|----|-------|
|id|integer|null:false|
|name|string|null:false|
|email|string|null:false|
|role|integer|default=0|



