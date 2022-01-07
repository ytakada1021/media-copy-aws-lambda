<?php

declare(strict_types=1);

require_once('Assert.php');

/**
 * @param array $event
 * @return void
 */
function index(array $event): void
{
    Assert::notNull($event, '$event cannot be null.');

    /** @var array $records */
    $records = $event['Records'];

    foreach ($records as $record) {
        // オブジェクト名, バケット名取得
        // S3クライアント作成
        // コピー実行
        // ログ出力
    }
}
