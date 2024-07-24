<?php
/**
 * Клас выполняющий авторизацию и записывающий использованные данные в глобальные переменные
 * @var array $request данные для авторизации
 * @public init() инициализирует запрос
 * @private search() ищет url
 */
class Login
{
    use main_sender;
    private static array $request = ['username' => 'dev1', 'password' => 'jkUhZk2Vpc'];
    /**
     * Инициализация запроса авторизации и сохранение данных
     * @return string ошибку запроса
     * @return array обработанный JSON запрос
     * 
     * Прим. сохраняемые глобальные данные:
     * @global Href_sevices::$sd_href ссылка на сервис в готорый отправляется запрос
     * @global Href_sevices::$token токен авторизированного пользователя
     */
    public static function init():string|array|null
    {
        $send = self::send(self::$request, Href_sevices::$URL_AUTH.'/login_check');
        if($send == false)
            return null;

        $data = $send['data'];
        $refr_token = $send['refreshToken'];
        $token = $send['token'];

        Href_sevices::$token = $token;
        Href_sevices::$sd_href = self::search($send['services'], 'SD');
        Href_sevices::$file_href = self::search($send['services'], 'STORAGE');
        Href_sevices::$refresh = $refr_token;
        return $send;
    }
    /**
     * Функция search ихет в массиве параметров необходимый URL
     * @param array $data
     * @param string $param
     * @return string|false
     */
    private static function search(
        array $data,
        string $param
    ):string|false
    {
        $services = '';
        foreach ($data as $record){
            if($record['code'] == $param){
                return $record['apiUrl'];
            }
        }
        echo 'Код сервиса неверен';
        return false;
    }
}