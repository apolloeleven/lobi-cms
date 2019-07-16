<?php

namespace console\controllers;

use Imagick;
use yii\console\Controller;
use yii\helpers\Console;
use yii\helpers\FileHelper;

/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
class TestController extends Controller
{

    /**
     *
     *
     * @author Zura Sekhniashvili <zurasekhniashvili@gmail.com>
     * @param $username
     * @param $host
     * @param int $port
     * @throws \yii\base\ErrorException
     */
    public function actionSync($username, $host, $port = 22)
    {
        $connection = ssh2_connect($host, $port, array('hostkey' => 'ssh-rsa'));
        $home = $_SERVER['HOME'];
        if ($home && ssh2_auth_pubkey_file($connection, $username, $home . '/.ssh/id_rsa.pub',
                $home . '/.ssh/id_rsa')) {
            $date = date('YmdHi');
            $filename = "{$username}_{$date}.sql";
            ssh2_exec($connection, "mysqldump $username > " . $filename);
            $storageArchive = "source_$date.tar.gz";
            ssh2_exec($connection, "tar -C public_html/frontend/web/storage/web -cf $storageArchive source");
//            ssh2_exec ( $connection, "tar -czvf $storageArchive public_html/storage/web/source");
            $localSqlFile = \Yii::getAlias('@console/runtime/' . $filename);
            $result = shell_exec("scp $username@$host:$filename " . $localSqlFile);
            Console::output($result);
            $localStorageFile = \Yii::getAlias('@console/runtime/' . $storageArchive);
            $result = shell_exec("scp -r $username@$host:$storageArchive " . $localStorageFile);
            Console::output($result);

            if (file_exists($localStorageFile)) {
//                ssh2_exec ( $connection, "rm $storageArchive");
                $storagePath = \Yii::getAlias('@storage/web/source');
                if (file_exists($storagePath . '.bak')) {
                    FileHelper::removeDirectory($storagePath . '.bak');
                }
                if (file_exists($storagePath)) {
                    rename($storagePath, $storagePath . '.bak');
                }
                $result = shell_exec("tar -xf $localStorageFile -C " . \Yii::getAlias('@storage/web'));
                Console::output("Storage was downloaded and put into the project ", $result);
            }

            if (file_exists($localSqlFile)) {
                $db = \Yii::$app->getDb();
                $dbName = $this->getDsnAttribute('dbname', $db->dsn);
                $result = shell_exec("mysql $dbName < $localSqlFile");
                Console::output("Database was downloaded and restored ", $result);
            }
        }
    }

    private function getDsnAttribute($name, $dsn)
    {
        if (preg_match('/' . $name . '=([^;]*)/', $dsn, $match)) {
            return $match[1];
        } else {
            return null;
        }
    }

    public function log()
    {

    }
}
