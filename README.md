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