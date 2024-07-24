<?php
/**
 * Класс Logout предназначен для выхода пользователя из API системы
 * @public init() функция вызываемая для инициализации запроса
 */
class Logout
{
    use main_sender;
    /**
     * init инициализирует запрос
     * @return string ошибку запроса
     * @return array обработанный JSON запрос
     */
    public static function init():string|array|null
    {
        $request = [
            'method' => 'logout',
            'jsonrpc' => '2.0'
        ];
        $send = self::send($request, Href_sevices::$URL_AUTH);
        if($send == false)
            return null;

        return $send;
    }
}