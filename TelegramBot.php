<?php
/**
 * @author Самсонов Владимир <samsonov.sem@gmail.com>
 * @copyright Copyright &copy; S.E.M. 2017-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

namespace sem\telegram;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Url;
use Longman\TelegramBot\Telegram;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request as TelegramRequest;

/**
 * Обертка для использования Telegram Bot API
 * 
 * @link https://github.com/php-telegram-bot
 * 
 * @property-read Telegram $client
 */
class TelegramBot extends \yii\base\Component
{
    /**
     * @var string уникальный ключ для использования Telegram API
     */
    public $apiKey;

    /*
     * @var string имя бота
     */
    public $botName;
    
    /**
     * @var string URL-адрес для webhook-а бота. Может быть задан в виде маршрута
     */
    public $webhook;

    /**
     * @var Telegram клиента для раоты с API
     */
    protected $_client;

    /**
     * {@inheritdoc}
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        if (!$this->apiKey) {
            throw new InvalidConfigException("Необходимо указать ключ `apiKey` для Telegram API");
        }
        
        if (!$this->botName) {
            throw new InvalidConfigException("Необходимо указать имя Telegram-бота");
        }
    }
    
    /**
     * Подготавливает и возвращает клиента
     * @return Telegram
     */
    public function getClient()
    {
        if (is_null($this->_client)) {
            $this->_client = new Telegram($this->apiKey, $this->botName);
        }
        
        return $this->_client;
    }
    
    /**
     * Возвращает сообщение, которое передал бот
     * @return \Longman\TelegramBot\Entities\Message|null
     */
    public function receiveMessage()
    {
        try {
            
            if ($this->client->handle()) {

                if ($command = $this->client->getCommandObject('genericmessage')) {
                    
                    return $command->getMessage();

                }

            }
            
        } catch (TelegramException $e) {
            Yii::error($e->getMessage());
        }
        
        return null;
    }
    
    /**
     * Отправляет сообщение пользователю в чат
     * @param array $data
     * @return \Longman\TelegramBot\Entities\ServerResponse|null
     */
    public function sendMessage(array $data)
    {
        try {

            if ($this->client) {
                return TelegramRequest::sendMessage($data);
            }
        
        } catch (TelegramException $e) {
            Yii::error($e->getMessage());
        }
        
        return null;
    }

    /**
     * Устанавлвиает Webhook для бота
     * @param string $url HTTPS-адрес на страницу действия хука
     * @return boolean
     */
    public function setWebhook($url = '')
    {
        try {
            
            if ($url == '') {
                $url = $this->webhook;
            }
            
            if (!$url) {
                throw new InvalidConfigException("Webhook URL-адрес не задан");
            }
            
            $result = $this->client->setWebhook($url);
            
            if ($result->isOk()) {
                return true;
            }
            
        } catch (TelegramException $e) {
            Yii::error($e->getMessage());
        }
        
        return false;
    }
    
    /**
     * Удаляет привязку бота к Webhook-у
     * @return boolean
     */
    public function unsetWebhook()
    {
        try {
            
            $result = $this->client->deleteWebhook();
            
            if ($result->isOk()) {
                return true;
            }
            
        } catch (TelegramException $e) {
            Yii::error($e->getMessage());
        }
        
        return false;
    }
}
