<?php
namespace Tapir\FormBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Doctrine\Common\Persistence\ManagerRegistry;
use Tapir\FormBundle\Form\AjaxEntityManager;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
class AjaxEntityController
{
    protected $registry;

    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    public function findAction(Request $request)
    {
        if (! $request->isXmlHttpRequest()) {
            //throw new NotFoundHttpException('Must be ajax request');
        }
        $QueryText = $request->request->get('q');
        if($QueryText) {
            $EntityPropertyName = $request->request->get('property');
            $RepoMethodName = $request->request->get('method');
            $EntityClassName = $request->request->get('entity');
            $extra = $request->request->get('extra');
        } else {
            $QueryText = $request->query->get('q');
            $EntityPropertyName = $request->query->get('property');
            $RepoMethodName = $request->query->get('method');
            $EntityClassName = $request->query->get('entity');
            $extra = $request->query->get('extra');
        }
        $results = array();
        if ($QueryText) {
            if ($EntityPropertyName) {
                $sql = "SELECT e.id, e.$EntityPropertyName AS text
                    FROM $EntityClassName e
                    WHERE e.$EntityPropertyName LIKE :query";
                if($extra) {
                    $ExtraFieldNames = explode(',', json_decode($extra));
                    foreach($ExtraFieldNames as $ExtraFieldName) {
                        if($ExtraFieldName) {
                            $sql .= " OR e.$ExtraFieldName LIKE :query";
                        }
                    }
                }
                $em = $this->registry->getManager();
                $dqlQuery = $em->createQuery($sql);
                $dqlQuery->setParameter('query', '%' . $QueryText . '%');
                $dqlQuery->setMaxResults(10);
                $results = $dqlQuery->getResult();

                //$results[] = array('id' => 999, 'text' => $sql);
            } elseif ($RepoMethodName) {
                try {
                    $repo = $this->registry->getRepository($EntityClassName);
                } catch (\ErrorException $e) {
                    throw new \InvalidArgumentException('No existe la entidad.');
                }
                if (! method_exists($repo, $RepoMethodName)) {
                    throw new \InvalidArgumentException(
                        sprintf('No existe el método "%s" para "%s".', $RepoMethodName, get_class($repo)));
                }
                return $repo->$RepoMethodName($QueryText, $extra);
            }
        } else {
            $results = array();
        }
        return new JsonResponse(array('results' => $results));
    }
}
