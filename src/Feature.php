<?php

namespace TaylorNetwork\Feature;

use Jenssegers\Agent\Agent;

class Feature
{
    /**
     * User agent class
     *
     * @var Agent
     */
    public $agent;

    /**
     * Feature constructor.
     */
    public function __construct()
    {
        $this->agent = new Agent();
    }

    /**
     * Determine if device is capable of a feature
     *
     * @param string $of
     * @return bool
     */
    public function isCapable($of)
    {
        $capable = true;
        switch($of)
        {
            case 'sweetalert':
                if($this->agent->is('iPhone') && $this->agent->version('Safari') < 8)
                {
                    $capable = false;
                }
                break;
        }
        return $capable;
    }

    /**
     * Use Sweet Alert features.
     *
     * @param string|null $appendTrue Append if true.
     * @param string|null $appendFalse Append if false.
     * @return string|null
     */
    public function useSweetAlert($appendTrue = null, $appendFalse = null)
    {
        if(!$this->isCapable('sweetalert'))
        {
            return $appendFalse;
        }
        return $appendTrue;
    }
}