<?php
namespace Yacare\BaseBundle\Model\Tree;

use Yacare\BaseBundle\Model\Tree\NodeInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Agrega la capacidad de organizar jerárquicamente las entidades.
 *
 * Esta clase está basada en el trabajo de KnpDoctrineBehaviors de KnpLabs <http://knplabs.com/>
 *
 * @author Ernesto Carrea <ernestocarrea@gmail.com>
 */
trait Node
{

    /**
     * Los nodos hijos.
     *
     * @var ArrayCollection $ChildNodes the children in the tree
     */
    private $ChildNodes;

    /**
     * Las clases que implementan esta característica deben implementar la variable $ParentNode;
     * private $ParentNode;
     */
    
    /**
     * La ruta completa de este nodo.
     *
     * @var string $MaterializedPath
     *     
     *      @ORM\Column(type="text")
     */
    protected $MaterializedPath = '';

    /**
     * Returns path separator for entity's materialized path.
     *
     * @return string "/" by default
     */
    public static function getMaterializedPathSeparator()
    {
        return '/';
    }

    /**
     * Returns the column on which construct materialized path.
     *
     * @return string null by default (which means use element's toString())
     */
    public static function getMaterializedPathMaterial()
    {
        return null;
    }

    /**
     *
     * @ignore
     *
     */
    public function getRealMaterializedPath()
    {
        return $this->getMaterializedPath() . self::getMaterializedPathSeparator() . $this->getId();
    }

    /**
     *
     * @ignore
     *
     */
    public function getMaterializedPath()
    {
        return $this->MaterializedPath;
    }

    /**
     *
     * @ignore
     *
     */
    public function setMaterializedPath($path)
    {
        $this->MaterializedPath = $path;
        $this->setParentMaterializedPath($this->getParentMaterializedPath());
        
        return $this;
    }

    /**
     *
     * @ignore
     *
     */
    public function getParentMaterializedPath()
    {
        $path = $this->getExplodedPath();
        array_pop($path);
        
        $parentPath = static::getMaterializedPathSeparator() . implode(static::getMaterializedPathSeparator(), $path);
        
        return $parentPath;
    }

    /**
     *
     * @ignore
     *
     */
    public function setParentMaterializedPath($path)
    {
        $this->ParentNodePath = $path;
    }

    /**
     *
     * @ignore
     *
     */
    public function getRootMaterializedPath()
    {
        $explodedPath = $this->getExplodedPath();
        
        return static::getMaterializedPathSeparator() . array_shift($explodedPath);
    }

    /**
     *
     * @ignore
     *
     */
    public function getNodeLevel()
    {
        $res = count($this->getExplodedPath()) - 2;
        return $res > 0 ? $res : 0;
    }

    /**
     *
     * @ignore
     *
     */
    public function isRootNode()
    {
        return self::getMaterializedPathSeparator() === $this->getParentMaterializedPath();
    }

    /**
     *
     * @ignore
     *
     */
    public function isLeafNode()
    {
        return 0 === $this->getChildNodes()->count();
    }

    /**
     *
     * @ignore
     *
     */
    public function getChildNodes()
    {
        return $this->ChildNodes = $this->ChildNodes ?  : new ArrayCollection();
    }

    /**
     *
     * @ignore
     *
     */
    public function addChildNode(NodeInterface $node)
    {
        $this->getChildNodes()->add($node);
    }

    /**
     *
     * @ignore
     *
     */
    public function isIndirectChildNodeOf(NodeInterface $node)
    {
        return $this->getRealMaterializedPath() !== $node->getRealMaterializedPath() &&
             0 === strpos($this->getRealMaterializedPath(), $node->getRealMaterializedPath());
    }

    /**
     *
     * @ignore
     *
     */
    public function isChildNodeOf(NodeInterface $node)
    {
        return $this->getParentMaterializedPath() === $node->getRealMaterializedPath();
    }

    /**
     *
     * @ignore
     *
     */
    public function setChildNodeOf(NodeInterface $node = null)
    {
        $id = $this->getId();
        if (empty($id)) {
            throw new \LogicException('You must provide an id for this node if you want it to be part of a tree.');
        }
        
        $MatName = static::getMaterializedPathMaterial();
        if ($MatName) {
            $MatFuncName = 'get' . $MatName;
            $MatContent = (string) ($this->$MatFuncName());
        } else {
            $MatContent = (string) $this;
        }
        
        if (null !== $node) {
            $path = $node->getMaterializedPath() . static::getMaterializedPathSeparator() . $MatContent;
        } else {
            $path = static::getMaterializedPathSeparator() . $MatContent;
        }
        $this->setMaterializedPath($path);
        
        if (null !== $this->ParentNode) {
            $this->ParentNode->getChildNodes()->removeElement($this);
        }
        
        $this->ParentNode = $node;
        if (null !== $node) {
            $this->ParentNode->addChildNode($this);
        }
        
        foreach ($this->getChildNodes() as $child) {
            $child->setChildNodeOf($this);
        }
        
        return $this;
    }

    /**
     *
     * @ignore
     *
     */
    public function getParentNode()
    {
        return $this->ParentNode;
    }

    /**
     *
     * @ignore
     *
     */
    public function setParentNode(NodeInterface $node = null)
    {
        $this->ParentNode = $node;
        $this->setChildNodeOf($this->ParentNode);
        
        return $this;
    }

    /**
     *
     * @ignore
     *
     */
    public function getRootNode()
    {
        $parent = $this;
        while (null !== $parent->getParentNode()) {
            $parent = $parent->getParentNode();
        }
        
        return $parent;
    }

    /**
     *
     * @ignore
     *
     */
    public function buildTree(array $results)
    {
        $this->getChildNodes()->clear();
        foreach ($results as $i => $node) {
            if ($node->getMaterializedPath() === $this->getRealMaterializedPath()) {
                $node->setParentNode($this);
                $node->buildTree($results);
            }
        }
    }

    /**
     *
     * @ignore
     *
     * @param \Closure $prepare
     *            a function to prepare the node before putting into the result
     *            
     * @return string the json representation of the hierarchical result
     */
    public function toJson(\Closure $prepare = null)
    {
        $tree = $this->toArray($prepare);
        
        return json_encode($tree);
    }

    /**
     *
     * @ignore
     *
     * @param \Closure $prepare
     *            a function to prepare the node before putting into the result
     * @param array $tree
     *            a reference to an array, used internally for recursion
     *            
     * @return array the hierarchical result
     */
    public function toArray(\Closure $prepare = null, array &$tree = null)
    {
        if (null === $prepare) {
            $prepare = function (NodeInterface $node)
            {
                return (string) $node;
            };
        }
        if (null === $tree) {
            $tree = array(
                $this->getId() => array('node' => $prepare($this),'children' => array()));
        }
        
        foreach ($this->getChildNodes() as $node) {
            $tree[$this->getId()]['children'][$node->getId()] = array('node' => $prepare($node),'children' => array());
            $node->toArray($prepare, $tree[$this->getId()]['children']);
        }
        
        return $tree;
    }

    /**
     *
     * @ignore
     *
     * @param \Closure $prepare
     *            a function to prepare the node before putting into the result
     * @param array $tree
     *            a reference to an array, used internally for recursion
     *            
     * @return array the flatten result
     *        
     */
    public function toFlatArray(\Closure $prepare = null, array &$tree = null)
    {
        if (null === $prepare) {
            $prepare = function (NodeInterface $node)
            {
                $pre = $node->getNodeLevel() > 1 ? implode('', array_fill(0, $node->getNodeLevel(), '--')) : '';
                
                return $pre . (string) $node;
            };
        }
        if (null === $tree) {
            $tree = array($this->getId() => $prepare($this));
        }
        
        foreach ($this->getChildNodes() as $node) {
            $tree[$node->getId()] = $prepare($node);
            $node->toFlatArray($prepare, $tree);
        }
        
        return $tree;
    }

    /**
     *
     * @ignore
     *
     */
    public function offsetSet($offset, $node)
    {
        $node->setChildNodeOf($this);
        
        return $this;
    }

    /**
     *
     * @ignore
     *
     */
    public function offsetExists($offset)
    {
        return isset($this->getChildNodes()[$offset]);
    }

    /**
     *
     * @ignore
     *
     */
    public function offsetUnset($offset)
    {
        unset($this->getChildNodes()[$offset]);
    }

    /**
     *
     * @ignore
     *
     */
    public function offsetGet($offset)
    {
        return $this->getChildNodes()[$offset];
    }

    /**
     *
     * @ignore
     *
     */
    protected function getExplodedPath()
    {
        $path = explode(static::getMaterializedPathSeparator(), $this->getRealMaterializedPath());
        
        return array_filter($path, function ($item)
        {
            return '' !== $item;
        });
    }
}
