<?php

namespace App\Controller;

use App\Entity\User;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{JsonResponse, Request};
use Symfony\Component\Routing\Annotation\Route;

class UserStatisticsController extends AbstractController
{

    /**
     * @Route(
     *     "/api/user",
     *     name="user_statistics",
     *     methods={"POST"},
     *     format="json"
     *     )
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function index(Request $request)
    {
        $action = $request->get('action');
        $userRepository =  $this->getDoctrine()->getRepository(User::class);

        switch ($action){
            case 'top_user_sum_order':
                return $this->json($userRepository->getTopUserForTotal());
            case 'no_success_order':
                $now_data = new DateTime();
                $last_year = (int)$now_data->format('Y') - 1;

                return $this->json($userRepository->getUserNotSuccessOrder($last_year));
            default:
                return $this->json('no action',400);
        }
    }
}
