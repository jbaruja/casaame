<?php

/**
 * @package dompdf
 * @link    https://github.com/dompdf/dompdf
 * @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 */
namespace IAWP_SCOPED\Dompdf\Positioner;

use IAWP_SCOPED\Dompdf\FrameDecorator\AbstractFrameDecorator;
/**
 * Dummy positioner
 *
 * @package dompdf
 */
class NullPositioner extends AbstractPositioner
{
    /**
     * @param AbstractFrameDecorator $frame
     */
    function position(AbstractFrameDecorator $frame) : void
    {
        return;
    }
}
