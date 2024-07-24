<?php 
/**
 * Класс main_sender выполняет запрос по API
 * @public send выполняет обычные запросы
 * @public
 * @private responser выполняет проверку на ошибки в запросах
 */
trait main_sender
{
    /**
     * Функция отправляющая запрос по API
     * @param array $data массив который будет преобразован в JSON
     * @param string $href ссылка по которой будет выполнен запрос
     * @param string $token по умолчанию #null, но принимает аунтификатор пользователя.
     * Используется для подтверждения на сервере что пользователь существует
     * @return false в случае наличия ошибок
     */
    protected static function send(
        array $data,
        string $href,
        string $token = null
    ):bool|array
    {
        $inti_data = json_encode($data);

        /*Массив cURL опций*/
        $options = array(
            CURLOPT_URL => $href,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $inti_data,
            CURLOPT_FAILONERROR => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_VERBOSE => true,

            CURLOPT_SSL_VERIFYSTATUS => false,
            CURLOPT_SSL_VERIFYPEER => false,
            //CURLOPT_SSL_VERIFYHOST => false,
            //CURLOPT_PROXY_SSL_VERIFYPEER => false,
        );

        /*инициализация и доп. настройка запроса*/
        $init = curl_init();
        curl_setopt_array($init, $options);
        if($token != null)
            curl_setopt($init, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: Bearer '.$token
            ]);

        /*выполнение запроса*/
        $resp = curl_exec($init);
        return self::responser($resp, $init);
    }
    /**
     * Общие описание аналогично обычной функции send
     * @param string $file_patch Ссылка на фаил
     * @param string $href ссылка по которой будет выполнен запрос
     * Используется для подтверждения на сервере что пользователь существует
     * @return false в случае наличия ошибок
     */
    public static function file_send(
        string $file_patch,
        string $href
    ):bool|array
    {
        $file = new CURLFile($file_patch);
        $options = array(
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer '.Href_sevices::$token
            ],
            CURLOPT_URL => $href,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => ['file' => $file],
            CURLOPT_FAILONERROR => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_VERBOSE => true,

            CURLOPT_SSL_VERIFYSTATUS => false,
            CURLOPT_SSL_VERIFYPEER => false,
            //CURLOPT_SSL_VERIFYHOST => false,
            //CURLOPT_PROXY_SSL_VERIFYPEER => false,
        );

        /*инициализация и доп. настройка запроса*/
        $init = curl_init();
        curl_setopt_array($init, $options);
        $resp = curl_exec($init);
        return self::responser($resp, $init);
    }
    /**
     * Проверка на наличие ошибок
     * @param string $resp строка JSON
     * @param object $init инициализатор cURL
     */
    private static function responser(
        string $resp, 
        object $init
    ):bool|array
    {
        $error_mess = '';
        if (curl_error($init) != '') {
            $error_mess = "Ошибка: " .curl_error($init).'<br>Номер ошибки: '.curl_errno($init).'<hr>';
            curl_close($init);
            echo $error_mess;
            return false;
        } 
        else {
            $http_code = curl_getinfo($init, CURLINFO_HTTP_CODE);
            if ($http_code != 200) {
                curl_close($init);
                $error_mess = "HTTP ошибка: " . $http_code . " - " . $resp.'<hr>';
                echo $error_mess;
                return false;
            }
            curl_close($init);
            return json_decode($resp, true);
        }
    }
}