<?php

namespace UserBundle\Repository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use \Doctrine\ORM\EntityRepository;
/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{
    public function findusersbyrole($roles)
    {

        $qb = $this->_em->createQueryBuilder();
        $qb->select('u')
            ->from('UserBundle:User', 'u')
            ->where('u.roles LIKE :roles')
            ->setParameter('roles', '%"'.$roles.'"%');

        return $qb->getQuery()->getResult();

    }



    public function getuserdatabyUsername2()
    {
        $q = $this->getEntityManager()->createQuery("SELECT u from UserBundle:User u where u.roles='ROLE_FAMILLE' " );
        return $query = $q->getResult();
    }

    public function findusrF()
    {
        $q = $this->getEntityManager()->createQuery("SELECT u from UserBundle:User u where  u.roles='a:1:{i:0;s:12:\"ROLE_FAMILLE\";}'" );
        return $query = $q->getResult();
    }
    public function findA($login,$mdp)
    {
        $q = $this->getEntityManager()->createQuery("SELECT u.id ,u.nom,u.username,u.email,u.password,u.roles,u.tel,u.pays, u.add,u.etat,u.code from UserBundle:User u where  u.username=:username and u.password =:mdp " )
            ->setParameter('mdp', $mdp)
            ->setParameter('username', $login);
        return $query = $q->getResult();
    }
    public function findAl($username)
    {
        $q = $this->getEntityManager()->createQuery("SELECT u.id ,u.nom,u.username,u.email,u.password,u.roles,u.tel,u.pays, u.add,u.etat,u.code from UserBundle:User u where  u.username=:username " )
            ->setParameter('username', $username);
        return $query = $q->getResult();
    }



    public function findUser($login,$mdp)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('u')
            ->from('UserBundle:User', 'u')
            ->where('u.login_db=:username' and 'u.mdp_db =:mdp')
            ->setParameter('mdp', $mdp)
        ->setParameter('username', $login);
        return $qb->getQuery()->getResult();

    }

    public function getuserdatabyUsername($user_name)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('u')
            ->from('UserBundle:User', 'u')
            ->where('u.username LIKE :username')
            ->setParameter('username', $user_name);
        return $qb->getQuery()->getResult();

    }

    public function findref($username)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('u')
            ->from('UserBundle:User', 'u')
            ->where('u.username =:username')
            ->setParameter('username', $username);
        return $qb->getQuery()->getResult();

    }


    public function getUsersbySexe($sexe)
    {
        $q=$this->getEntityManager()->createQuery("SELECT p.sexe from UserBundle:User p where p.sexe=:sexe")
            ->setParameter('sexe',$sexe);
        return $query=$q->getResult();
    }
    public function findEntitiesByString($str){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p from UserBundle:User p  where p.username LIKE :str'
            )
            ->setParameter('str', '%'.$str.'%')
            ->getResult();
    }

    public function findEntitiesByString1Asso($str){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p from UserBundle:User p where p.roles LIKE :roles and p.username LIKE :str'
            )
            ->setParameter('str', '%'.$str.'%')
            ->setParameter('roles', '%"'."Role_FAMILLE".'"%')
            ->getResult();
    }

    public function findEntitiesByString1($str){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p from UserBundle:User p where p.roles LIKE :roles and p.username LIKE :str'
            )
            ->setParameter('str', '%'.$str.'%')
            ->setParameter('roles', '%"'."Role_ASSOCIATION".'"%')
            ->getResult();
    }


    public function findEntitiesByString11($str){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p from UserBundle:User p where p.roles LIKE :roles and p.username LIKE :str'
            )
            ->setParameter('str', '%'.$str.'%')
            ->setParameter('roles', '%"'."Role_REFUGEE".'"%')
            ->getResult();
    }

    public function finduserdatabyusername($code)
    {
        $q = $this->getEntityManager()->createQuery("SELECT count(u.code) from UserBundle:User u where u.code=:code" )
            ->setParameter('code',$code);
        return $query = $q->getResult();
    }

}
