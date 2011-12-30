<?php

namespace EdpUser\Authentication\Adapter;

use Zend\Authentication\Storage,
    EdpUser\Authentication\Adapter;

abstract class AbstractAdapter implements Adapter
{
    /**
     * @var Storage
     */
    protected $storage;

    /**
     * Returns the persistent storage handler
     *
     * Session storage is used by default unless a different storage adapter has been set.
     *
     * @return Storage
     */
    public function getStorage()
    {
        if (null === $this->storage) {
            $this->setStorage(new Storage\Session(Storage\Session::NAMESPACE_DEFAULT), __CLASS__);
        }

        return $this->storage;
    }

    /**
     * Sets the persistent storage handler
     *
     * @param  Storage $storage
     * @return AbstractAdapter Provides a fluent interface
     */
    public function setStorage(Storage $storage)
    {
        $this->storage = $storage;
        return $this;
    }

    /**
     * Check if this adapter is satsified or not 
     * 
     * @return bool
     */
    public function isSatisfied()
    {
        $storage = $this->getStorage()->read();
        return (isset($storage['is_satisfied']) && true === $storage['is_satisfied']);
    }

    /**
     * Set if this adapter is satisfied or not 
     * 
     * @param bool $bool 
     * @return AbstractAdapter
     */
    public function setSatisfied($bool = true)
    {
        $storage = $this->getStorage()->read() ?: array();
        $storage['is_satisfied'] = $bool;
        $this->getStorage()->write($storage);
        return $this;
    }
}
