<?php


namespace App\Service;


use App\Base\BaseGenerator;
use App\Entity\User;
use DateTime;
use Exception;
use SplFixedArray;

class UserGenerator extends BaseGenerator
{

    /**
     * UserGenerator constructor.
     * @param DateTime|null $start_data
     * @param DateTime|null $end_data
     * @throws Exception
     */
    public function __construct(DateTime $start_data = null, DateTime $end_data = null)
    {
        parent::__construct($start_data,$end_data);
    }

    /**
     * @param int $count
     * @return SplFixedArray
     * @throws Exception
     */
    public function generate(int $count = 20): SplFixedArray
    {
        $result = new SplFixedArray($count);

        for ($i = 0; $i < $count; $i++){
            $user = new User();

            $user->setFirstname($this->getRandStr());
            $user->setLastname($this->getRandStr(6));
            $user->setEmail($this->getRandEmail());
            $user->setRegistrationDate($this->getRandData());

            $result[$i] = $user;
        }

        return $result;
    }
}