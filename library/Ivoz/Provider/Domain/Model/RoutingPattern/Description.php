<?php

namespace Ivoz\Provider\Domain\Model\RoutingPattern;

use Assert\Assertion;
use Ivoz\Core\Domain\Model\EntityInterface;

/**
 * Description
 * @codeCoverageIgnore
 */
class Description
{
    /**
     * column: description_en
     * @var string
     */
    protected $en;

    /**
     * column: description_es
     * @var string
     */
    protected $es;


    /**
     * Constructor
     */
    public function __construct($en, $es)
    {
        $this->setEn($en);
        $this->setEs($es);
    }

    // @codeCoverageIgnoreStart

    /**
     * @deprecated
     * Set en
     *
     * @param string $en
     *
     * @return self
     */
    protected function setEn($en = null)
    {
        if (!is_null($en)) {
            Assertion::maxLength($en, 55, 'en value "%s" is too long, it should have no more than %d characters, but has %d characters.');
        }

        $this->en = $en;

        return $this;
    }

    /**
     * Get en
     *
     * @return string
     */
    public function getEn()
    {
        return $this->en;
    }

    /**
     * @deprecated
     * Set es
     *
     * @param string $es
     *
     * @return self
     */
    protected function setEs($es = null)
    {
        if (!is_null($es)) {
            Assertion::maxLength($es, 55, 'es value "%s" is too long, it should have no more than %d characters, but has %d characters.');
        }

        $this->es = $es;

        return $this;
    }

    /**
     * Get es
     *
     * @return string
     */
    public function getEs()
    {
        return $this->es;
    }

    // @codeCoverageIgnoreEnd
}
