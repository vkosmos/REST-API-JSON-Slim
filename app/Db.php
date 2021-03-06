<?php

namespace App;

use App\Errors\ExceptionDb;

class Db
{
    const DBHOST = 'localhost';
    const DBNAME = 'maximaster';
    const DBUSER = 'root';
    const DBPASSWORD = '';

    protected $dbh;

    public function __construct()
    {

        try{
            $this->dbh = new \PDO(
                'mysql:host='.static::DBHOST.';dbname='.static::DBNAME,
                static::DBUSER,
                static::DBPASSWORD
            );

        }catch(\PDOException $e){
            $dbError = new ExceptionDb('Ошибка соединения с базой данных.');
            $dbError->time = time();
            throw $dbError;
        }

    }

    /**
     * Выполняет запрос к БД, возвращает полученные данные в виде массивы объектов
     * @param $sql sql-запрос к БД
     * @param array $params массив подстановок
     * @param string|null $class имя класса, массив объектов которого должен быть возвращен
     * @return array
     */
    public function query(string $sql, $params = [], $class = null)
    {

        $sth = $this->dbh->prepare($sql);
        if (!$sth) {
            $dbError = new ExceptionDb('Ошибка при подговке запроса.');
            $dbError->time = time();
            throw $dbError;
        }

        $sth->execute($params);

        if (null === $class) {
            $sth->setFetchMode(\PDO::FETCH_ASSOC);
        } else {
            $sth->setFetchMode(\PDO::FETCH_CLASS, $class);
        }
        return $sth->fetchAll();
    }

    /**
     * Выполняет запрос к БД, не связанный с получением данных
     * @param string $sql sql-запрос к БД
     * @param array $params массив подстановок
     * @return bool
     */
    public function execute(string $sql, $params = [])
    {
        $sth = $this->dbh->prepare($sql);
        if (!$sth) {
            $dbError = new ExceptionDb('Ошибка при подговке запроса.');
            $dbError->time = time();
            throw $dbError;
        }
        return $sth->execute($params);
    }

    /**
     * Возвращает последний вставленный id
     * @return string
     */
    public function lastInsertId()
    {
        return $this->dbh->lastInsertId();
    }

}
