<?php
/**
 * Класс вывода данных определённого запроса
 * @public init() инициализирует запрос
 */
class Info
{
    use main_sender;
    /**
     * Инициализирует запрос к серверу
     * @var Href_sevices::$last__task_id используется как индентификатор для записи
     * @return null при ошибке запроса
     * @return array обработанный JSON запрос
     */
    public static function init():array|null
    {
        $request = [
            'method' => 'M4GetTaskDetails',
            'params' => [
                'taskId' => Href_sevices::$last__task_id,
            ],
            'jsonrpc' => '2.0'
        ];
        $send = self::send($request, Href_sevices::$sd_href, Href_sevices::$token);
        if($send == false)
            return null;

        return $send;
    }
}