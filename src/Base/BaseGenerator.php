<?php


namespace App\Base;

use DateTime;
use Exception;
use SplFixedArray;

/**
 * Base Generator for random data
 * Class BaseGenerator
 * @package App\Base
 */
abstract class BaseGenerator
{
    /**
     * @var array
     */
    protected $mail_services = [
        'mail.ru',
        'google.com',
        'outlook.com',
    ];

    /**
     * @var DateTime
     */
    protected $start_data;
    /**
     * @var DateTime
     */
    protected $end_data;
    /**
     * @var int
     */
    protected $max_num = 10000;
    /**
     * @var int
     */
    protected $min_num = 10;

    /**
     * BaseGenerator constructor.
     * @param DateTime|null $start_data
     * @param DateTime|null $end_data
     * @throws Exception
     */
    public function __construct(DateTime $start_data = null, DateTime $end_data = null)
    {
        if (isset($end_data)){
            $this->end_data = $end_data;
        }else{
            $this->end_data = new DateTime();
        }

        if (isset($start_data)){
            $this->start_data = $start_data;
        }else{
            $now = new DateTime();
            $this->start_data = $now->modify('-10 years');
        }
    }

    /**
     * @return DateTime
     * @throws Exception
     */
    public function getRandData() : DateTime
    {
        $start_data_unix = $this->start_data->getTimestamp();
        $end_data_unix = $this->end_data->getTimestamp();

        $rand_data = rand($start_data_unix,$end_data_unix);

        $rand_data_obj = new DateTime();
        $rand_data_obj->setTimestamp($rand_data);

        return $rand_data_obj;
    }

    /**
     * @param int $length
     * @return string
     * @throws Exception
     */
    public function getRandStr(int $length = 10) : string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * @param int $length
     * @return string
     * @throws Exception
     */
    public function getRandEmail(int $length = 10): string
    {
        $rand_str = self::getRandStr($length);
        $rand_mail_service = $this->mail_services[array_rand($this->mail_services,1)];
        return "{$rand_str}@{$rand_mail_service}";
    }

    /**
     * @return mixed
     */
    public function getStartData(): DateTime
    {
        return $this->start_data;
    }

    /**
     * @param mixed $start_data
     */
    public function setStartData(DateTime $start_data): void
    {
        $this->start_data = $start_data;
    }

    /**
     * @return DateTime
     */
    public function getEndData(): DateTime
    {
        return $this->end_data;
    }

    /**
     * @param DateTime $end_data
     */
    public function setEndData(DateTime $end_data): void
    {
        $this->end_data = $end_data;
    }

    /**
     * @return array
     */
    public function getMailServices(): array
    {
        return $this->mail_services;
    }

    /**
     * @param array $mail_services
     */
    public function setMailServices(array $mail_services): void
    {
        $this->mail_services = $mail_services;
    }

    /**
     * @param int $count
     * @return SplFixedArray
     */
    public abstract function generate(int $count = 20): SplFixedArray;

    /**
     * @return int
     */
    public function getMaxNum(): int
    {
        return $this->max_num;
    }

    /**
     * @param int $max_num
     */
    public function setMaxNum(int $max_num): void
    {
        $this->max_num = $max_num;
    }

    /**
     * @return int
     */
    public function getMinNum(): int
    {
        return $this->min_num;
    }

    /**
     * @param int $min_num
     */
    public function setMinNum(int $min_num): void
    {
        $this->min_num = $min_num;
    }
}