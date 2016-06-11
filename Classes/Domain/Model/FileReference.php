<?php

namespace Sonority\BootstrapComponents\Domain\Model;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * File Reference
 *
 */
class FileReference extends \TYPO3\CMS\Extbase\Domain\Model\FileReference
{

    /**
     * @var bool
     */
    protected $displayMode;

    /**
     * Set displayMode
     *
     * @param bool $displayMode
     * @return void
     */
    public function setDisplayMode($displayMode)
    {
        $this->displayMode = $displayMode;
    }

    /**
     * Get displayMode
     *
     * @return bool
     */
    public function getDisplayMode()
    {
        return $this->displayMode;
    }

}
