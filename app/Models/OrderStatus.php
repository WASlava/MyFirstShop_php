<?php

namespace App\Models;

class OrderStatus
{
    const NEW = 0;
    const IN_PROGRESS = 1;
    const COMPLETED = 2;
    const CANCELED = 3;
    const NOTPAIDED = 4;
    const PAIDED = 5;
    const SHIPPED = 6;


    public static function getConstants()
    {
        return (new \ReflectionClass(__CLASS__))->getConstants();
    }

    public static function statusLabels()
    {
        return [
//            self::NEW => 'Нове',
            self::IN_PROGRESS => 'Готується до відправлення',
            self::COMPLETED => 'Завершено',
            self::CANCELED => 'Скасовано',
            self::NOTPAIDED => 'Очікується оплата',
            self::PAIDED => 'Оплачено',
            self::SHIPPED => 'Відправлено',
        ];
    }
}
