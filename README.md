#### 非常事態用 物品管理リスト 要件定義
1. 物品名 在庫数 賞味期限・使用期限 注意メッセージを入力し追加できる

2. 過去の物品名 在庫数　賞味期限・使用期限 注意メッセージをデータベースで管理する

3. 全ての物品の過去履歴を一覧で見ることができ、物品名 在庫数 賞味期限・使用期限 注意メッセージの最低限4つを1行ずつ表示する テーブルタグを使用すること

4. 物品名 在庫数 賞味期限・使用期限 注意メッセージは全て未入力だった場合、いずれかを指定していない場合はエラーメッセージを表示して新規追加できないようにする

5. 新規追加の場合、在庫数 賞味期限・使用期限 は0以上の整数のみ可能とする 0以上の整数以外はエラーメッセージを表示して、商品を追加できない

6. 新規追加の場合、注意メッセージは期限迫る 期限に余裕ありのみ可能とする それ以外はエラーメッセージを表示して、物品を追加できない

7. 物品一覧から物品名の変更ができる

8. 物品一覧から賞味期限・使用期限の変更ができる 数値入力で

9. 物品一覧から指定在庫の在庫数を入力し在庫数の変更ができる

10. 物品一覧から注意メッセージの変更ができる 変更は期限迫る 期限に余裕ありのみ可能とする

11. 物品の追加あるいは変更が正常に完了したら完了メッセージを表示する

12. 物品一覧から在庫数 賞味期限・使用期限を変更する場合0以上の整数のみ可能とする 0以上の整数以外はエラーメッセージを表示して変更できない

13. 物品一覧から注意メッセージを変更する場合は期限迫る 期限に余裕ありのみ選択可能とする それ以外は選択できない
 
14. 物品のレコードが不要になった場合はレコード右端に配置してある削除ボタンを押して不要レコードを削除できる

初回アクセス時
![ポートフォリオgoods_management 初回アクセス](https://user-images.githubusercontent.com/92624621/142195845-bf135ab7-55e0-449d-a32f-784590b32b39.png)

物品インサート
![ポートフォリオgoods_management insert](https://user-images.githubusercontent.com/92624621/142195912-6c4e4259-3882-4694-93f9-429cc07e9700.png)

物品アップデート物品名
![ポートフォリオgoods_management update物品名](https://user-images.githubusercontent.com/92624621/142195985-83d92127-387e-4ca1-8b21-e73f3fef2ae0.png)

物品アップデート使用期限
![ポートフォリオgoods_management update使用期限](https://user-images.githubusercontent.com/92624621/142196139-c093db4b-5f38-49b3-8799-0db002d9f897.png)

物品デリート
![ポートフォリオgoods_management delete](https://user-images.githubusercontent.com/92624621/142196215-0d6264c3-90a2-41eb-8487-2eb154dc11a6.png)

データベース構造
![ポートフォリオデータベース構造](https://user-images.githubusercontent.com/92624621/142196280-9e34fb9a-9980-4ac1-9bc0-7f00287c4cbd.png)

データベース値入り
![ポートフォリオデータベース値入り](https://user-images.githubusercontent.com/92624621/142196341-6ab13c97-8a8b-487e-be52-45a5adfa7c0b.png)
