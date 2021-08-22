<?php

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new AppBundle\AppBundle(),
            new familleBundle\familleBundle(),
            new AssoBundle\AssoBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new UserBundle\UserBundle(),
            new adminBundle\adminBundle(),
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
            new RefugeeBundle\RefugeeBundle(),
            new LivBundle\LivBundle(),
            new SBC\NotificationsBundle\NotificationsBundle(),
            new Nomaya\SocialBundle\NomayaSocialBundle(),
            new Knp\Bundle\SnappyBundle\KnpSnappyBundle(),
            //new blackknight467\StarRatingBundle\StarRatingBundle(),
           // new Mgilet\NotificationBundle\MgiletNotificationBundle(),
            new sponsBundle\sponsBundle(),
            new stockBundle\stockBundle(),
            new ForumBundle\ForumBundle(),
            new eventBundle\eventBundle(),
            new ActualiteBundle\ActualiteBundle(),
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();

            if ('dev' === $this->getEnvironment()) {
                $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
                $bundles[] = new Symfony\Bundle\WebServerBundle\WebServerBundle();
            }
        }

        return $bundles;
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return dirname(__DIR__).'/var/cache/'.$this->getEnvironment();
    }

    public function getLogDir()
    {
        return dirname(__DIR__).'/var/logs';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(function (ContainerBuilder $container) {
            $container->setParameter('container.autowiring.strict_mode', true);
            $container->setParameter('container.dumper.inline_class_loader', true);

            $container->addObjectResource($this);
        });
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
