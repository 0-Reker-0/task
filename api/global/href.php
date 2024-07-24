<?php
/**
 * Класс глобальных переменных задействованных в запросах
 */
class Href_sevices
{
    /**
     * href_upload - ссылка по которой загружаются файлы
     * @var string
     */
    public static string $href_upload = 'https://test.ru/api/putfile.php';
    /**
     * sd_href - ссылка по которой выполняется запрос
     * @var string
     */
    public static string $sd_href = '';
    /**
     * file_href - ссылка для загрузки файлов
     * @var string
     */
    public static string $file_href = '';
    /**
     * token - токен аунтефикации
     * @var string
     */
    public static string $token = '';
    /**
     * last__task_id - последнее полученое id задачи
     * @var string
     */
    public static string $last__task_id ='';
    /**
     * refresh - токен для обновления
     * @var string
     */
    public static string $refresh = '';
    /**
     * URL_AUTH - ссылка авторизации
     * @var string
     */
    public static string $URL_AUTH = 'https://developer-api.m4.systems:4443/api_auth';
    /**
     * last_guid - последний токен сохранёного файла
     * @var string
     */
    public static string $last_guid = '';
}