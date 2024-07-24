<?php
/**
 * Класс File_send предназначен для отправки файлов на сервер и добавления их в записи
 * @abstract __construct основная функция загружающая изображение
 * @public input() вызывется после инициализации загрузки и добавляет изображение в пост
 */
class File_send
{
    use main_sender;
    /**
     * __construct - Принимает путь файла и инициализирует запрос для сохранеия файла на сервере
     * @param string $patch путь к файлу
     * @return void
     */
    public function __construct(
        string $patch
    )
    {
        $send = self::file_send($patch, Href_sevices::$href_upload);
        if($send == false)
            return;

        $guid = $send['result']['guid'];

        Href_sevices::$last_guid = $guid;
        return;
    }
    /**
     * input() - функция отправляющая запрос на добавление файла в пост
     * @return array в случае успешного выполнения заппроса
     * @return null в случае ошибки
     */
    public function input():array|null
    {
        $request = [
            'method' => 'M4AddTaskAttach',
            'params' => [
                'taskId' => Href_sevices::$last__task_id,
                'files' => [
                    'guid' => Href_sevices::$last_guid,
                    'typeAttachId' => 5
                ]
            ],
            'jsonrpc' => '2.0'
        ];

        $send = self::send($request, Href_sevices::$sd_href, Href_sevices::$token);
        if($send == false)
            return null;

        return $send;
    }
}