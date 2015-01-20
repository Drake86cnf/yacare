<?php
namespace Tapir\BaseBundle\Model\Auditable;

/**
 * Agrega a una entidad la capacidad de registrar modificaciones en una tabla de auditoria.
 *
 * @author Ernesto Carrea <equistango@gmail.com>
 */
trait Auditable
{
    /**
     * @return string some log informations
     */
    public function getUpdateLogMessage(array $changeSets = [])
    {
        $message = [];
        foreach ($changeSets as $property => $changeSet) {
            for($i = 0 , $s = sizeof($changeSet); $i < $s ; $i++) {
                if ($changeSet[$i] instanceof \DateTime) {
                    $changeSet[$i] = $changeSet[$i]->format("Y-m-d H:M:S");
                }
            }
            
            $message[] = sprintf(
                '%s #%d : property "%s" changed from "%s" to "%s"',
                __CLASS__,
                $this->getId(),
                $property,
                $changeSet[0],
                $changeSet[1]
            );
        }

        return implode("\n", $message);
    }

    public function getCreateLogMessage()
    {
        return sprintf('%s #%d created', __CLASS__, $this->getId());
    }

    public function getRemoveLogMessage()
    {
        return sprintf('%s #%d removed', __CLASS__, $this->getId());
    }
}
