<?php
/**
 * This file is part of the Imbo package
 *
 * (c) Christer Edvartsen <cogo@starzinger.net>
 *
 * For the full copyright and license information, please view the LICENSE file that was
 * distributed with this source code.
 */

namespace Imbo\IntegrationTest\Image\Transformation;

use Imbo\Image\Transformation\Border;

/**
 * @author Christer Edvartsen <cogo@starzinger.net>
 * @package Test suite\Integration tests
 * @covers Imbo\Image\Transformation\Border
 */
class BorderTest extends TransformationTests {
    /**
     * {@inheritdoc}
     */
    protected function getTransformation() {
        return new Border();
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultParams() {
        return array(
            'color' => 'ffffff',
            'width' => 3,
            'height' => 4,
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getImageMock() {
        $image = $this->getMock('Imbo\Model\Image');
        $image->expects($this->once())->method('getBlob')->will($this->returnValue(file_get_contents(FIXTURES_DIR . '/image.png')));
        $image->expects($this->once())->method('setBlob')->with($this->isType('string'))->will($this->returnValue($image));
        $image->expects($this->once())->method('setWidth')->with(671)->will($this->returnValue($image));
        $image->expects($this->once())->method('setHeight')->with(471)->will($this->returnValue($image));

        return $image;
    }

    public function testTransformationSupportsDifferentModes() {
        $imagePath = FIXTURES_DIR . '/image.png';

        $size = getimagesize($imagePath);

        $image = $this->getMock('Imbo\Model\Image');
        $image->expects($this->once())->method('getBlob')->will($this->returnValue(file_get_contents($imagePath)));
        $image->expects($this->once())->method('setBlob')->with($this->isType('string'))->will($this->returnValue($image));
        $image->expects($this->once())->method('setWidth')->with($size[0])->will($this->returnValue($image));
        $image->expects($this->once())->method('setHeight')->with($size[1])->will($this->returnValue($image));

        $this->getTransformation()->applyToImage($image, array('color' => 'white', 'width' => 3, 'height' => 4, 'mode' => 'inline'));
    }
}
