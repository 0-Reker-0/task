<?php
/**
 * Класс создания комментариев
 * @public init() инициализирует запрос
 */
class Comment
{
    use main_sender;
    /**
     * Инициализирует запрос к серверу
     * @var Href_sevices::$last__task_id используется как индентификатор для записи
     * @param string $mess сообщение для комментария
     * @return null при ошибке запроса
     * @return array обработанный JSON запрос
     */
    public static function init(string $mess):string|array|null
    {
        $request = [
            'method' => 'M4AddTaskComment',
            'params' => [
                'taskId' => Href_sevices::$last__task_id,
                'comment' => $mess,
                'isPublic' => false
            ],
            'jsonrpc' => '2.0'
        ];

        $send = self::send($request, Href_sevices::$sd_href, Href_sevices::$token);
        if($send == false)
            return null;

        return $send;
    }
}