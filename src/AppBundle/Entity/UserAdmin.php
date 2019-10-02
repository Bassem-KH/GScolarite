<?php
/**
 * Created by PhpStorm.
 * User: seif eddine salah
 * Date: 3/2/2019
 * Time: 3:55 PM
 */

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
/**

 * @ORM\Entity
 * @ORM\Table(name="user_admin")
 */
class UserAdmin extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;



    public function __construct()
    {

        parent::__construct();
    }


}