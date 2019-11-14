<?php


namespace App\Service;


use App\Base\BaseGenerator;
use App\Entity\Order;
use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use SplFixedArray;

class OrderGenerator extends BaseGenerator
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * UserGenerator constructor.
     * @param EntityManagerInterface $em
     * @param DateTime|null $start_data
     * @param DateTime|null $end_data
     * @throws Exception
     */
    public function __construct(EntityManagerInterface $em,DateTime $start_data = null, DateTime $end_data = null)
    {
        $this->em = $em;
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

        $UserRepository = $this->em->getRepository(User::class);

        for ($i = 0; $i < $count; $i++){
            $rand_user = $UserRepository->findOneRandom();
            $order = new Order();

            $order->setUser($rand_user);
            $order->setTotal((float)(mt_rand($this->min_num,$this->max_num) / 10));
            $order->setDate($this->getRandData());
            $order->setStatus(rand(1,3));

            $result[$i] = $order;
        }

        return $result;
    }
}