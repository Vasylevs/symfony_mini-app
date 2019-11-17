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
                $period = (int)$request->get('period');
                $wek_days = explode(',',$request->get('wek_days'));

                return $this->json($orderRepository->findOrderByPeriod($period,$wek_days,500));
            default:
                return $this->json('no action',400);
        }
    }
}