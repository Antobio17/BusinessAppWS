<?php

namespace App\Service\Interfaces;


use Doctrine\Persistence\ObjectManager;

interface AppServiceInterface
{

    /************************************************** ROUTING ***************************************************/

    /******************************************** GETTERS AND SETTERS *********************************************/

    /**
     * Gets the Test Mode property.
     *
     * @return bool bool
     */
    public function getTestMode(): bool;

    /**
     * Sets the Test Mode property.
     *
     * @param bool $testMode The value of test mode to set.
     *
     * @return $this $this
     */
    public function setTestMode(bool $testMode): self;

    /**
     * Gets the Entity Manager property.
     *
     * @return ObjectManager ObjectManager
     */
    public function getEntityManager(): ObjectManager;

    /**
     * Sets the Entity Manager property.
     *
     * @param ObjectManager $entityManager The entity manager to set.
     *
     * @return $this $this
     */
    public function setEntityManager(ObjectManager $entityManager): self;

    /*********************************************** PUBLIC METHODS ***********************************************/

    /*********************************************** STATIC METHODS ***********************************************/

}