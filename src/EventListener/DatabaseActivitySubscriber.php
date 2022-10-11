<?php
namespace App\EventListener;

use App\Entity\Stock;
use App\Service\StockService;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class DatabaseActivitySubscriber implements EventSubscriberInterface
{
    public function __construct(private StockService $stockserve)
    {
        
    }
    // this method can only return the event names; you cannot define a
    // custom method name to execute when each event triggers
    public function getSubscribedEvents(): array
    {
        return [
            Events::postPersist,
            Events::postRemove,
            Events::postUpdate,
        ];
    }

    // callback methods must be called exactly like the events they listen to;
    // they receive an argument of type LifecycleEventArgs, which gives you access
    // to both the entity object of the event and the entity manager itself
    public function postPersist(LifecycleEventArgs $args): void
    {
        $this->logActivity('Ajout', $args);
    }

    public function postRemove(LifecycleEventArgs $args): void
    {
        $this->logActivity('Supression', $args);
    }

    public function postUpdate(LifecycleEventArgs $args): void
    {
        $this->logActivity('Modification', $args);
    }

    private function logActivity(string $action, LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        // if this subscriber only applies to certain entity types,
        // add some code to check the entity type as early as possible
        if ($entity instanceof Stock) {
             $this->stockserve->hitorifierStock($entity);
            return;
        }
       // dd($entity);

        // ... get the entity information and log it somehow
    }
}
?>