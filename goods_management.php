<?php
// 変数の初期化
$goods_name = '';
$stock_quantity = '';
$year = '';
$month = '';
$day = '';
$caution_message = '';
$errors = [];
$form_type = '';
$success_message = [];
$select_data = [];
$goods_id = '';
$change_goods_name = '';
$change_stock_quantity = '';
$change_year = '';
$change_month = '';
$change_day = '';
$change_caution_message = '';

// データベース接続に必要な情報をセット
$host = 'localhost';
$user_name = 'root';
$passwd = 'Gyoran-0613';
$dbname = 'adachi';

// UPDATE文多いためユーザー定義関数で1まとまりにできるところは1まとまり
function sqlUpdate ($db, $column, $value, $id) {
    $sql_u = 'UPDATE goods_management SET ' . $column . ' = \'' . $value . '\' WHERE goods_id = ' . $id;
    //var_dump($sql_u);
    return mysqli_query($db, $sql_u);
}

// html側でphpの処理出力時無害化
function h ($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// データベースに接続
$link = mysqli_connect($host, $user_name, $passwd, $dbname);
mysqli_set_charset($link, 'utf8');

// ユーザーがinsert update deleteいずれかの操作をしデータを飛ばして来た際の処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['form_type']) === TRUE) {
        $form_type = $_POST['form_type'];
    }

// ユーザーがinsertのデータを飛ばして来たら
    if ($form_type === 'insert') {

// insert時の入力値チェック
        if (isset($_POST['goods_name']) === TRUE) {
            $goods_name = trim($_POST['goods_name']);
        }

        //var_dump($goods_name);
    
        if ($goods_name === '') {
            $errors[] = '物品名を入力してください';
        }
    
        if (isset($_POST['stock_quantity']) === TRUE) {
            $stock_quantity = trim($_POST['stock_quantity']);
        }
    
        if ($stock_quantity === '') {
            $errors[] = '個数を入力してください';
        } else if (preg_match("/^[0-9]+$/",$stock_quantity) !== 1) {
            $errors[] = '個数は半角数字のみで入力してください';
        }
    
        if (isset($_POST['year']) === TRUE) {
            $year = trim($_POST['year']);
        }
    
        if ($year === '') {
            $errors[] = '年を入力してください';
        } else if (preg_match("/^[0-9]+$/",$year) !== 1) {
            $errors[] = '年は半角数字のみで入力してください';
        }
    
        if (isset($_POST['month']) === TRUE) {
            $month = trim($_POST['month']);
        }
    
        if ($month === '') {
            $errors[] = '月を入力してください';
        } else if (preg_match("/^[0-9]+$/",$month) !== 1) {
            $errors[] = '月は半角数字のみで入力してください';
        }
    
        if (isset($_POST['day']) === TRUE) {
            $day = trim($_POST['day']);
        }
    
        if ($day === '') {
            $errors[] = '日を入力してください';
        } else if (preg_match("/^[0-9]+$/",$day) !== 1) {
            $errors[] = '日は半角数字のみで入力してください';
        }
    
        if (isset($_POST['caution_message']) === TRUE) {
            $caution_message = trim($_POST['caution_message']);
        }
    
        if ($caution_message !== '0' && $caution_message !== '1') {
            $errors[] = '注意メッセージは期限迫るか期限に余裕ありのみを選択してください';
        }
 
// insert時の入力値が全て正しい形式ならばデータベースに物品情報を登録
        if (count($errors) === 0) {

            $sql_i = 'INSERT INTO goods_management 
                   (goods_name, stock_quantity, year, month, day, caution_message)
                   VALUES (\'' . $goods_name . '\', \'' . $stock_quantity .
                   '\', \'' . $year . '\', \'' . $month . '\', \'' . $day . '\', \'' . $caution_message . '\')';
                    // var_dump($sql_i);
            if (mysqli_query($link, $sql_i) === TRUE) {
                $success_message[] = '新規物品追加成功';
            } else {
                $errors[] = '新規物品追加失敗。プログラム作成者に問い合わせてください';
            }
        }

// 一覧から物品名の変更が行われたら
    } else if ($form_type === 'update_goods_name') {

// 物品名変更時の入力値チェック
        if (isset($_POST['goods_id']) === TRUE) {
            $goods_id = $_POST['goods_id'];
        }

        if (isset($_POST['change_goods_name']) === TRUE) {
            $change_goods_name  = trim($_POST['change_goods_name']);
        }

        if ($change_goods_name === '') {
            $errors[] = '更新物品名を入力してください';
        }

// 物品名変更のデータが全て正しい形式で送られていたらデータベースに更新処理
        if (count($errors) === 0) {
            $column = 'goods_name';

            $result = sqlUpdate($link, $column, $change_goods_name, $goods_id);

            if ($result === TRUE) {
                $success_message[] = '物品名を変更しました';
            } else {
                $errors[] = 'goods_management: updateエラー: goods_name プログラム作成者に問い合わせてください';
            }
        }

// 一覧から在庫数の変更が行われたら
    } else if ($form_type === 'update_stock_quantity') {

// 在庫数変更時の入力値チェック
        if (isset($_POST['goods_id']) === TRUE) {
            $goods_id = $_POST['goods_id'];
        }

        if (isset($_POST['change_stock_quantity']) === TRUE) {
            $change_stock_quantity = trim($_POST['change_stock_quantity']);
        }

        if ($change_stock_quantity === '') {
            $errors[] = '更新在庫数を入力してください';
        } else if (preg_match("/^[0-9]+$/",$change_stock_quantity) !== 1) {
            $errors[] = '更新在庫数は半角数字のみで入力してください';
        }

// 在庫数変更のデータが全て正しい形式で送られていたらデータベースに更新処理
        if (count($errors) === 0) {
            $column = 'stock_quantity';

            $result = sqlUpdate($link, $column, $change_stock_quantity, $goods_id);

            if ($result === TRUE) {
                $success_message[] = '在庫数を更新しました';
            } else {
                $errors[] = 'goods_management: updateエラー: stock_quantity プログラム作成者に問い合わせてください';
            }
        }

// 一覧から期限の年月日の変更が行われたら
    } else if  ($form_type === 'update_year_month_day') {

// 期限変更時の入力値チェック
        if (isset($_POST['goods_id']) === TRUE) {
            $goods_id = $_POST['goods_id'];
        }

        if (isset($_POST['change_year']) === TRUE) {
            $change_year  = trim($_POST['change_year']);
        }

        if ($change_year === '') {
            $errors[] = '更新年を入力してください';
        } else if (preg_match("/^[0-9]+$/",$change_year) !== 1) { 
            $errors[] = '更新年は半角数字のみで入力してください';
        }

        if (isset($_POST['change_month']) === TRUE) {
            $change_month = trim($_POST['change_month']);
        }

        if ($change_month === '') {
            $errors[] = '更新月を入力してください';
        } else if (preg_match("/^[0-9]+$/",$change_month) !== 1) {
            $errors[] = '更新月は半角数字のみで入力してください';
        }

        if (isset($_POST['change_day']) === TRUE) {
            $change_day = trim($_POST['change_day']);
        }

        if ($change_day === '') {
            $errors[] = '更新日を入力してください';
        } else if (preg_match("/^[0-9]+$/",$change_day) !== 1) {
            $errors[] = '更新日は半角数字のみで入力してください';
        }

// 期限変更のデータが全て正しい形式で送られていたらデータベースに更新処理
        if (count($errors) === 0) {

// 期限変更のデータは年月日まとめて整合性を持たせるためトランザクションを使用
            mysqli_autocommit($link, false);
            $column = 'year';

            $result = sqlUpdate($link, $column, $change_year, $goods_id);

            if ($result === FALSE) {
                $errors[] = 'goods_management: updateエラー: year';
            } else if ($result === TRUE) {
                $column = 'month';

                $result = sqlUpdate($link, $column, $change_month, $goods_id);

                if ($result === FALSE) {
                    $errors[] = 'goods_mangement: updateエラー: month';
                } else if ($result === TRUE) {
                    $column = 'day';

                    $result = sqlUpdate($link, $column, $change_day, $goods_id);

                    if ($result === FALSE) {
                        $errors[] = 'goods_management: updateエラー: day';
                    } 
                }
            }

        }

// 期限の年月日まとめてエラーなく更新処理できればコミット
        if (count($errors) === 0) {

            mysqli_commit($link);
            $success_message[] = '賞味期限 使用期限を更新しました。';
        } else {

// 期限の年月日、更新処理時エラーが発生したらロールバック
            mysqli_rollback($link);
            $errors[] = '賞味期限 使用期限を正常に更新できませんでした。';
        } 

// 一覧から注意メッセージの変更が行われたら
    } else if ($form_type === 'update_caution_message') {

// 注意メッセージ変更時の入力値チェック
        if (isset($_POST['goods_id']) === TRUE) {
            $goods_id = $_POST['goods_id'];
        }

        if (isset($_POST['change_caution_message']) === TRUE) {
            $change_caution_message = trim($_POST['change_caution_message']);
        }
        // var_dump($change_caution_message);

        if ($change_caution_message !== '0' && $change_caution_message !== '1') {
            $errors[] = '注意メッセージは期限迫るか期限に余裕ありのみを選択してください';
        }

//　注意メッセージ変更のデータが全て正しい形式で送られていたらデータベースに更新処理
        if (count($errors) === 0) {
            $column = 'caution_message';

            $result = sqlUpdate($link, $column, $change_caution_message, $goods_id);

            if ($result === TRUE) {
                $success_message[] = '注意メッセージを更新しました';
            } else {
                $errors[] = 'goods_management: updateエラー: caution_message プログラム作成者に問い合わせてください';
            }
        }

// 一覧表からユーザーが削除したい行のデータを送ってきたら
    } else if ($form_type === 'delete') {

        if (isset($_POST['goods_id']) === TRUE) {
            $goods_id = $_POST['goods_id'];
        }

        $sql_d = 'DELETE FROM goods_management WHERE goods_id = ' . $goods_id;

        if (mysqli_query($link, $sql_d) === TRUE) { 
            $success_message[] = '指定された行を削除しました';
        } else {
            $errors[] = '指定された行が削除できませんでした。プログラム作成者に問い合わせてください';
        }
    }
}

// データベースに保持している物品情報を取得
if ($link) {

    $sql_s = 'SELECT goods_id, goods_name, stock_quantity, year, month, day, caution_message FROM goods_management';

    if ($result = mysqli_query($link, $sql_s)) {

    while($row = mysqli_fetch_assoc($result)) {
        $select_data[] = $row;
    }

    } else {
        $errors[] = 'SQL失敗 ' . $sql_s;
    }

}

// メモリ開放
mysqli_free_result($result);

// データベース切断
mysqli_close($link);
?>

<!--html開始-->
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>非常事態用 物品管理リスト</title>
        <style type="text/css">
        /*css適用*/
        /*<h1>新規物品追加</h1>の下部に1本線 下部に余白を設ける */
            .new_insert {
                border-bottom: solid black 1px;
                padding-bottom: 10px;
            }

        /*<h2>物品情報変更</h2>の上部に1本線 上部に余白を設ける*/
            .update_goods {
                border-top: solid black 1px;
                padding-top: 10px;
            }
        /*table内、重なる線に関して1本化*/
            table {
                border-collapse: collapse;
            }

        /*tr, th, tdの四方向に一本線 このとき線が2本重なる部分はborder-collapseが適用され1本化される
          tr, th, tdの上部、下部に余白を設ける*/
            tr, th, td {
                border: solid black 1px;
                padding-top: 10px;
                padding-bottom: 10px;
            }

        /*trの偶数行に黄色を塗り見やすくする*/
            table tr:nth-child(2n) {
                background-color: yellow;
            }
        </style>
    </head>
    <body>

<!-- 物品データの追加、更新、削除が正常に完了した際のメッセージ -->
        <ul>
<?php foreach ($success_message as $success) { ?>
            <li><?php echo h($success); ?></li>
<?php } ?>
        </ul>

<!-- 物品データの追加、更新、削除処理の際、エラーが起きた場合のメッセージ -->
        <ul>
<?php foreach ($errors as $error) { ?>
            <li><?php echo h($error); ?></li>
<?php } ?>
<?php// var_dump($errors);?>
        </ul>

        <h1 class="new_insert">新規物品追加</h1>

<!-- 新規物品追加のフォーム -->
        <form method="post">
            <input type="hidden" name="form_type" value="insert">
            <label>物品名: <input type="text" name="goods_name"></label><br>
            <label>個数: <input type="text" name="stock_quantity"></label><br>
            <label>賞味期限:使用期限: <input type="text" name="year"> 年 
                                     <input type="number" name="month"> 月 
                                     <input type="text" name="day"> 日 
            </label><br>

            <select name="caution_message">
                <option value="0">期限迫る</option>
                <option value="1">期限に余裕あり</option>
            </select><br>

            <input type="submit" value="物品追加"><br>
         </form>

<!-- データベースに一覧で表示するデータが1行以上ある場合に以降の処理を実施 -->
<?php if (count($select_data) > 0) { ?>

         <h2 class="update_goods">物品情報変更</h2>
         <p>物品一覧</p>

<!-- table開始 -->
         <table>
             <tr>
                 <th>物品名</th>
                 <th>在庫数</th>
                 <th>賞味期限 使用期限</th>
                 <th>注意メッセージ</th>
             </tr>
<?php foreach ($select_data as $data) { ?>
    <?php //var_dump($select_data); ?>

<!-- 物品名表示並びに物品名変更のフォーム -->
             <tr>
                 <td>
                     <form method="post">
                         <input type="hidden" name="form_type" value="update_goods_name">
                         <input type="hidden" name="goods_id" value="<?php echo h($data['goods_id']); ?>">
                         <input type="text" name="change_goods_name" value="<?php echo h($data['goods_name']); ?>">
                         <input type="submit" value="変更">
                    </form>
                </td>
<!-- 在庫数表示並びに在庫数変更のフォーム -->
                 <td>
                     <form method="post">
                         <input type="hidden" name="form_type" value="update_stock_quantity">
                         <input type="hidden" name="goods_id" value="<?php echo h($data['goods_id']); ?>">
                         <input type="text" name="change_stock_quantity" value="<?php echo h($data['stock_quantity']); ?>">
                         <input type="submit" value="変更">
                    </form>
                </td>

<!-- 期限の表示並びに期限変更のフォーム -->
                 <td>
                     <form method="post">
                         <input type="hidden" name="form_type" value="update_year_month_day">
                         <input type="hidden" name="goods_id" value="<?php echo h($data['goods_id']); ?>">
                         <input type="text" name="change_year" value="<?php echo h($data['year']); ?>">年
                         <input type="number" name="change_month" value="<?php echo h($data['month']); ?>">月
                         <input type="text" name="change_day" value="<?php echo h($data['day']); ?>">日
                         <input type="submit" value="変更">
                     </form>
                 </td>

<!-- 注意メッセージの表示並びに注意メッセージ変更のフォーム -->
                 <td>
                     <form method="post">
                         <input type="hidden" name="form_type" value="update_caution_message">
                         <input type="hidden" name="goods_id" value="<?php echo h($data['goods_id']); ?>">
                         <select name="change_caution_message">
                                <option value="0" <?php if ($data['caution_message'] === '0') { ?> selected <?php } ?>>期限迫る</option>
                                <option value="1" <?php if ($data['caution_message'] === '1') { ?> selected <?php } ?>>期限に余裕あり</option>  
                         </select>
                         <input type="submit" value="変更">
                     </form>
                 </td>
<!-- 各行の削除ボタン配置 -->
                 <td>
                     <form method="post">
                         <input type="hidden" name="form_type" value="delete">
                         <input type="hidden" name="goods_id" value="<?php echo h($data['goods_id']); ?>">
                         <label>この1行を <input type="submit" value="削除"></label>
                     </form>
                 </td>
             </tr>
<?php } ?>
         </table>
<?php } ?>
    </body>
</html>