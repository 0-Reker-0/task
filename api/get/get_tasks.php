<?php
/**
 * Класс обработки запросов за N дней.
 * Дни меняются в переменной:
 */
class Tasks
{
    use main_sender;
    /**
     * @var int $day_before  по умолчанию 3
     */
    private static int $day_before = 3;
    /**
     * Содержит масив для формирования JSON.
     * Инициализирует запрос.
     * @return null при ошибке запроса
     * @return array обработанный JSON запрос
     * @var Href_sevices::$last__task_id для использования в дальнейшем
     * Прим. Если $save получил значение, то элемент массива указаный в нём будет вынесен в глобольную переменную
     */
    public static function init(int $save = null):array|null
    {
        $request = [
            'method' => 'M4GetTasks',
            'params' => [
                'status' => [0, 1, 4, 5, 6],
                'lastUpdate'=> self::_date()
            ],
            'jsonrpc' => '2.0'
        ];

        $send = self::send($request, Href_sevices::$sd_href, Href_sevices::$token);
        if($send == false)
            return null;

        $res = $send['result'];
        
        if($save !== null)
            Href_sevices::$last__task_id = $res[$save]['taskId'];

        return $send;
    }

    /**
     * Обрабатывает дату вывода данных.
     * @return string
     */
    private static function _date():string
    {
        $date_now = date('Y.m.d');
        $exploded = explode('.', $date_now);

        $day = $exploded[2]-self::$day_before;
        $returned = $exploded[0].'.'.$exploded[1].'.'.$day.' 00:00:00';
        return $returned;
    }
}