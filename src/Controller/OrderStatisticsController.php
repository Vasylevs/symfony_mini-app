<?php


namespace App\Controller;


use App\Entity\Order;
use DateInterval;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{JsonResponse, Request};
use Symfony\Component\Routing\Annotation\Route;

class OrderStatisticsController extends AbstractController
{
    /**
     * @Route(
     *     "/api/order",
     *     name="order_statistics",
     *     methods={"POST"},
     *     format="json"
     *     )
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function getOrder(Request $request){
        $action = $request->get('action');
        $orderRepository =  $this->getDoctrine()->getRepository(Order::class);

        switch ($action){
            case 'top_order_work_day':
                $date_end = new DateTime();
                $date_start = new DateTime();
                $date_start->modify('-3 months');

                return $this->json($orderRepository->findOrderByPeriod($date_start,$date_end,500,[2,3,4,5,6]));
            default:
                return $this->json('no action',400);
        }
    }
}