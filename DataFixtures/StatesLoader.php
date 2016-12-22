<?php
namespace Lthrt\CCSBundle\DataFixtures;

use Lthrt\CCSBundle\DataFixtures\StatesTrait;
use Lthrt\CCSBundle\Entity\State;

class StatesLoader
{
    use StatesTrait;

    private $em;

    public function __construct($em)
    {
        $this->em     = $em;
        $this->states = $this->getStates();
    }

    public function loadStates($overwrite = false)
    {
        $dbStates = $this->em->getRepository('LthrtCCSBundle:State')
            ->createQueryBuilder('state', 'state.abbr')->getQuery()->getResult();

        ksort($this->states);

        $updatedStates = [];
        $newStates     = [];

        foreach ($this->states as $abbr => $name) {
            if ('header' == $abbr) {
                continue;
            }
            if (in_array($abbr, array_keys($dbStates))) {
                $state                = $dbStates[$abbr];
                $updatedStates[$abbr] = $state->abbr;
            } else {
                $state            = new State();
                $newStates[$abbr] = $state->abbr;
            }
            $state->abbr = $abbr;
            $state->name = $name;
            $this->em->persist($state);
            $this->em->flush();
        }

        if ($updatedStates) {
            ksort($updatedStates);
        }
        if ($newStates) {
            ksort($newStates);
        }

        return ['updatedStates' => $updatedStates, 'newStates' => $newStates];
    }
}
