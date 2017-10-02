# Yii2 Telegramm Bot API wrapper based on Longman Telegram Bot
## Install by composer
composer require sem-soft/yii2-telegram
## Or add this code into require section of your composer.json and then call composer update in console
"sem-soft/yii2-telegram": "*"
## Usage
In configuration file do
```php
<?php
...
  'components'  =>  [
    ...
    'filestorage'	=>  [
        'telegram' => [
            'class' => \sem\telegram\TelegramBot::className(),
            'apiKey' => '<уникальный_api_ключ>',
            'botName' => '<имя_бота>',
            'webhook' => 'https://<url_адрес_хука>'
        ]
    ]
    ...
  ],
...
 ?>
 ```
 ## Set webhook
 For this action try code, for exaple in console controller:
 ```php
<?php
/**
 * Файл класса-контроллера TelegramController
 * 
 * @copyright Copyright (c) 2017, Oleg Chulakov Studio
 * @link http://chulakov.com/
 */

namespace console\controllers;

use Yii;

/**
 * Реализует настройку Telegram-бота
 */
class TelegramController extends \yii\console\Controller
{
    /**
     * Устанавливает Webhook, по которому будет стучаться бот
     */
    public function actionSet()
    {
        if (Yii::$app->telegram->setWebhook()) {
            $bot = Yii::$app->telegram->botName;
            echo "Webhook привязан к боту '{$bot}'\n";    
        }
    }
    
    /**
     * Удаляет Webhook, установленный ранее
     */
    public function actionUnset()
    {
        if (Yii::$app->telegram->unsetWebhook()) {
            $bot = Yii::$app->telegram->botName;
            echo "Webhook отвязан от бота '{$bot}'\n";
        }
    }
}


 ```
