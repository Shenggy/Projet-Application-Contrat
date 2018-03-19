<?php
/**
 * Created by PhpStorm.
 * User: Shenggy
 * Date: 08/03/2018
 * Time: 18:47
 */
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ClientController extends Controller
{
    public function registerAction()
    {//TODO
        return $this->container
            ->get('pugx_multi_user.registration_manager')
            ->register('AppBundle\Entity\Client');
    }
}