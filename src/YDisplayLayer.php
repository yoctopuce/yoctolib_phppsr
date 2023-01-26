<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YDisplayLayer Class: Interface for drawing into display layers, obtained by calling display.get_displayLayer.
 *
 * Each DisplayLayer represents an image layer containing objects
 * to display (bitmaps, text, etc.). The content is displayed only when
 * the layer is active on the screen (and not masked by other
 * overlapping layers).
 */
class YDisplayLayer
{
    const ALIGN_TOP_LEFT                 = 0;
    const ALIGN_CENTER_LEFT              = 1;
    const ALIGN_BASELINE_LEFT            = 2;
    const ALIGN_BOTTOM_LEFT              = 3;
    const ALIGN_TOP_CENTER               = 4;
    const ALIGN_CENTER                   = 5;
    const ALIGN_BASELINE_CENTER          = 6;
    const ALIGN_BOTTOM_CENTER            = 7;
    const ALIGN_TOP_DECIMAL              = 8;
    const ALIGN_CENTER_DECIMAL           = 9;
    const ALIGN_BASELINE_DECIMAL         = 10;
    const ALIGN_BOTTOM_DECIMAL           = 11;
    const ALIGN_TOP_RIGHT                = 12;
    const ALIGN_CENTER_RIGHT             = 13;
    const ALIGN_BASELINE_RIGHT           = 14;
    const ALIGN_BOTTOM_RIGHT             = 15;
    //--- (end of generated code: YDisplayLayer declaration)

    //--- (generated code: YDisplayLayer attributes)

    //--- (end of generated code: YDisplayLayer attributes)
    protected $_display;
    protected $_id;
    protected $_cmdbuff;
    protected $_hidden;

    function __construct($parent, $id)
    {
        //--- (generated code: YDisplayLayer constructor)
        //--- (end of generated code: YDisplayLayer constructor)
        $this->_display    = $parent;
        $this->_id         = $id;
        $this->_cmdbuff    = '';
        $this->_hidden     = FALSE;
    }

    // internal function to flush any pending command for this layer
    public function flush_now()
    {
        $res = YAPI::SUCCESS;
        if($this->_cmdbuff != '') {
            $res = $this->_display->sendCommand($this->_cmdbuff);
            $this->_cmdbuff = '';
        }
        return $res;
    }

    // internal function to send a state command for this layer
    private function command_push($str_cmd)
    {
        $res = YAPI::SUCCESS;

        if(strlen($this->_cmdbuff)+strlen($str_cmd) >= 100) {
            // force flush before, to prevent overflow
            $res = $this->flush_now();
        }
        if($this->_cmdbuff=='') {
            // always prepend layer ID first
            $this->_cmdbuff = $this->_id;
        }
        $this->_cmdbuff .= $str_cmd;
        return $res;
    }

    // internal function to send a command for this layer
    private function command_flush($str_cmd)
    {
        $res = $this->command_push($str_cmd);
        if($this->_hidden) {
            return $res;
        }
        return $this->flush_now();
    }

    //--- (generated code: YDisplayLayer implementation)

    /**
     * Reverts the layer to its initial state (fully transparent, default settings).
     * Reinitializes the drawing pointer to the upper left position,
     * and selects the most visible pen color. If you only want to erase the layer
     * content, use the method clear() instead.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function reset(): int
    {
        $this->_hidden = false;
        return $this->command_flush('X');
    }

    /**
     * Erases the whole content of the layer (makes it fully transparent).
     * This method does not change any other attribute of the layer.
     * To reinitialize the layer attributes to defaults settings, use the method
     * reset() instead.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function clear(): int
    {
        return $this->command_flush('x');
    }

    /**
     * Selects the pen color for all subsequent drawing functions,
     * including text drawing. The pen color is provided as an RGB value.
     * For grayscale or monochrome displays, the value is
     * automatically converted to the proper range.
     *
     * @param int $color : the desired pen color, as a 24-bit RGB value
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function selectColorPen(int $color): int
    {
        return $this->command_push(sprintf('c%06x',$color));
    }

    /**
     * Selects the pen gray level for all subsequent drawing functions,
     * including text drawing. The gray level is provided as a number between
     * 0 (black) and 255 (white, or whichever the lightest color is).
     * For monochrome displays (without gray levels), any value
     * lower than 128 is rendered as black, and any value equal
     * or above to 128 is non-black.
     *
     * @param int $graylevel : the desired gray level, from 0 to 255
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function selectGrayPen(int $graylevel): int
    {
        return $this->command_push(sprintf('g%d',$graylevel));
    }

    /**
     * Selects an eraser instead of a pen for all subsequent drawing functions,
     * except for bitmap copy functions. Any point drawn using the eraser
     * becomes transparent (as when the layer is empty), showing the other
     * layers beneath it.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function selectEraser(): int
    {
        return $this->command_push('e');
    }

    /**
     * Enables or disables anti-aliasing for drawing oblique lines and circles.
     * Anti-aliasing provides a smoother aspect when looked from far enough,
     * but it can add fuzziness when the display is looked from very close.
     * At the end of the day, it is your personal choice.
     * Anti-aliasing is enabled by default on grayscale and color displays,
     * but you can disable it if you prefer. This setting has no effect
     * on monochrome displays.
     *
     * @param boolean $mode : true to enable anti-aliasing, false to
     *         disable it.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function setAntialiasingMode(bool $mode): int
    {
        return $this->command_push(sprintf('a%d',$mode));
    }

    /**
     * Draws a single pixel at the specified position.
     *
     * @param int $x : the distance from left of layer, in pixels
     * @param int $y : the distance from top of layer, in pixels
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function drawPixel(int $x, int $y): int
    {
        return $this->command_flush(sprintf('P%d,%d',$x,$y));
    }

    /**
     * Draws an empty rectangle at a specified position.
     *
     * @param int $x1 : the distance from left of layer to the left border of the rectangle, in pixels
     * @param int $y1 : the distance from top of layer to the top border of the rectangle, in pixels
     * @param int $x2 : the distance from left of layer to the right border of the rectangle, in pixels
     * @param int $y2 : the distance from top of layer to the bottom border of the rectangle, in pixels
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function drawRect(int $x1, int $y1, int $x2, int $y2): int
    {
        return $this->command_flush(sprintf('R%d,%d,%d,%d',$x1,$y1,$x2,$y2));
    }

    /**
     * Draws a filled rectangular bar at a specified position.
     *
     * @param int $x1 : the distance from left of layer to the left border of the rectangle, in pixels
     * @param int $y1 : the distance from top of layer to the top border of the rectangle, in pixels
     * @param int $x2 : the distance from left of layer to the right border of the rectangle, in pixels
     * @param int $y2 : the distance from top of layer to the bottom border of the rectangle, in pixels
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function drawBar(int $x1, int $y1, int $x2, int $y2): int
    {
        return $this->command_flush(sprintf('B%d,%d,%d,%d',$x1,$y1,$x2,$y2));
    }

    /**
     * Draws an empty circle at a specified position.
     *
     * @param int $x : the distance from left of layer to the center of the circle, in pixels
     * @param int $y : the distance from top of layer to the center of the circle, in pixels
     * @param int $r : the radius of the circle, in pixels
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function drawCircle(int $x, int $y, int $r): int
    {
        return $this->command_flush(sprintf('C%d,%d,%d',$x,$y,$r));
    }

    /**
     * Draws a filled disc at a given position.
     *
     * @param int $x : the distance from left of layer to the center of the disc, in pixels
     * @param int $y : the distance from top of layer to the center of the disc, in pixels
     * @param int $r : the radius of the disc, in pixels
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function drawDisc(int $x, int $y, int $r): int
    {
        return $this->command_flush(sprintf('D%d,%d,%d',$x,$y,$r));
    }

    /**
     * Selects a font to use for the next text drawing functions, by providing the name of the
     * font file. You can use a built-in font as well as a font file that you have previously
     * uploaded to the device built-in memory. If you experience problems selecting a font
     * file, check the device logs for any error message such as missing font file or bad font
     * file format.
     *
     * @param string $fontname : the font file name, embedded fonts are 8x8.yfm, Small.yfm, Medium.yfm,
     * Large.yfm (not available on Yocto-MiniDisplay).
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function selectFont(string $fontname): int
    {
        return $this->command_push(sprintf('&%s%c',$fontname,27));
    }

    /**
     * Draws a text string at the specified position. The point of the text that is aligned
     * to the specified pixel position is called the anchor point, and can be chosen among
     * several options. Text is rendered from left to right, without implicit wrapping.
     *
     * @param int $x : the distance from left of layer to the text anchor point, in pixels
     * @param int $y : the distance from top of layer to the text anchor point, in pixels
     * @param int $anchor : the text anchor point, chosen among the YDisplayLayer::ALIGN enumeration:
     *         YDisplayLayer::ALIGN_TOP_LEFT,         YDisplayLayer::ALIGN_CENTER_LEFT,
     *         YDisplayLayer::ALIGN_BASELINE_LEFT,    YDisplayLayer::ALIGN_BOTTOM_LEFT,
     *         YDisplayLayer::ALIGN_TOP_CENTER,       YDisplayLayer::ALIGN_CENTER,
     *         YDisplayLayer::ALIGN_BASELINE_CENTER,  YDisplayLayer::ALIGN_BOTTOM_CENTER,
     *         YDisplayLayer::ALIGN_TOP_DECIMAL,      YDisplayLayer::ALIGN_CENTER_DECIMAL,
     *         YDisplayLayer::ALIGN_BASELINE_DECIMAL, YDisplayLayer::ALIGN_BOTTOM_DECIMAL,
     *         YDisplayLayer::ALIGN_TOP_RIGHT,        YDisplayLayer::ALIGN_CENTER_RIGHT,
     *         YDisplayLayer::ALIGN_BASELINE_RIGHT,   YDisplayLayer::ALIGN_BOTTOM_RIGHT.
     * @param string $text : the text string to draw
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function drawText(int $x, int $y, int $anchor, string $text): int
    {
        return $this->command_flush(sprintf('T%d,%d,%d,%s%c',$x,$y,$anchor,$text,27));
    }

    /**
     * Draws a GIF image at the specified position. The GIF image must have been previously
     * uploaded to the device built-in memory. If you experience problems using an image
     * file, check the device logs for any error message such as missing image file or bad
     * image file format.
     *
     * @param int $x : the distance from left of layer to the left of the image, in pixels
     * @param int $y : the distance from top of layer to the top of the image, in pixels
     * @param string $imagename : the GIF file name
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function drawImage(int $x, int $y, string $imagename): int
    {
        return $this->command_flush(sprintf('*%d,%d,%s%c',$x,$y,$imagename,27));
    }

    /**
     * Draws a bitmap at the specified position. The bitmap is provided as a binary object,
     * where each pixel maps to a bit, from left to right and from top to bottom.
     * The most significant bit of each byte maps to the leftmost pixel, and the least
     * significant bit maps to the rightmost pixel. Bits set to 1 are drawn using the
     * layer selected pen color. Bits set to 0 are drawn using the specified background
     * gray level, unless -1 is specified, in which case they are not drawn at all
     * (as if transparent).
     *
     * @param int $x : the distance from left of layer to the left of the bitmap, in pixels
     * @param int $y : the distance from top of layer to the top of the bitmap, in pixels
     * @param int $w : the width of the bitmap, in pixels
     * @param string $bitmap : a binary object
     * @param int $bgcol : the background gray level to use for zero bits (0 = black,
     *         255 = white), or -1 to leave the pixels unchanged
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function drawBitmap(int $x, int $y, int $w, string $bitmap, int $bgcol): int
    {
        // $destname               is a str;
        $destname = sprintf('layer%d:%d,%d@%d,%d',$this->_id,$w,$bgcol,$x,$y);
        return $this->_display->upload($destname,$bitmap);
    }

    /**
     * Moves the drawing pointer of this layer to the specified position.
     *
     * @param int $x : the distance from left of layer, in pixels
     * @param int $y : the distance from top of layer, in pixels
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function moveTo(int $x, int $y): int
    {
        return $this->command_push(sprintf('@%d,%d',$x,$y));
    }

    /**
     * Draws a line from current drawing pointer position to the specified position.
     * The specified destination pixel is included in the line. The pointer position
     * is then moved to the end point of the line.
     *
     * @param int $x : the distance from left of layer to the end point of the line, in pixels
     * @param int $y : the distance from top of layer to the end point of the line, in pixels
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function lineTo(int $x, int $y): int
    {
        return $this->command_flush(sprintf('-%d,%d',$x,$y));
    }

    /**
     * Outputs a message in the console area, and advances the console pointer accordingly.
     * The console pointer position is automatically moved to the beginning
     * of the next line when a newline character is met, or when the right margin
     * is hit. When the new text to display extends below the lower margin, the
     * console area is automatically scrolled up.
     *
     * @param string $text : the message to display
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function consoleOut(string $text): int
    {
        return $this->command_flush(sprintf('!%s%c',$text,27));
    }

    /**
     * Sets up display margins for the consoleOut function.
     *
     * @param int $x1 : the distance from left of layer to the left margin, in pixels
     * @param int $y1 : the distance from top of layer to the top margin, in pixels
     * @param int $x2 : the distance from left of layer to the right margin, in pixels
     * @param int $y2 : the distance from top of layer to the bottom margin, in pixels
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function setConsoleMargins(int $x1, int $y1, int $x2, int $y2): int
    {
        return $this->command_push(sprintf('m%d,%d,%d,%d',$x1,$y1,$x2,$y2));
    }

    /**
     * Sets up the background color used by the clearConsole function and by
     * the console scrolling feature.
     *
     * @param int $bgcol : the background gray level to use when scrolling (0 = black,
     *         255 = white), or -1 for transparent
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function setConsoleBackground(int $bgcol): int
    {
        return $this->command_push(sprintf('b%d',$bgcol));
    }

    /**
     * Sets up the wrapping behavior used by the consoleOut function.
     *
     * @param boolean $wordwrap : true to wrap only between words,
     *         false to wrap on the last column anyway.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function setConsoleWordWrap(bool $wordwrap): int
    {
        return $this->command_push(sprintf('w%d',$wordwrap));
    }

    /**
     * Blanks the console area within console margins, and resets the console pointer
     * to the upper left corner of the console.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function clearConsole(): int
    {
        return $this->command_flush('^');
    }

    /**
     * Sets the position of the layer relative to the display upper left corner.
     * When smooth scrolling is used, the display offset of the layer is
     * automatically updated during the next milliseconds to animate the move of the layer.
     *
     * @param int $x : the distance from left of display to the upper left corner of the layer
     * @param int $y : the distance from top of display to the upper left corner of the layer
     * @param int $scrollTime : number of milliseconds to use for smooth scrolling, or
     *         0 if the scrolling should be immediate.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function setLayerPosition(int $x, int $y, int $scrollTime): int
    {
        return $this->command_flush(sprintf('#%d,%d,%d',$x,$y,$scrollTime));
    }

    /**
     * Hides the layer. The state of the layer is preserved but the layer is not displayed
     * on the screen until the next call to unhide(). Hiding the layer can positively
     * affect the drawing speed, since it postpones the rendering until all operations are
     * completed (double-buffering).
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function hide(): int
    {
        $this->command_push('h');
        $this->_hidden = true;
        return $this->flush_now();
    }

    /**
     * Shows the layer. Shows the layer again after a hide command.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function unhide(): int
    {
        $this->_hidden = false;
        return $this->command_flush('s');
    }

    /**
     * Gets parent YDisplay. Returns the parent YDisplay object of the current YDisplayLayer::
     *
     * @return YDisplay  an YDisplay object
     */
    public function get_display(): ?YDisplay
    {
        return $this->_display;
    }

    /**
     * Returns the display width, in pixels.
     *
     * @return int  an integer corresponding to the display width, in pixels
     *
     * On failure, throws an exception or returns YDisplayLayer::DISPLAYWIDTH_INVALID.
     */
    public function get_displayWidth(): int
    {
        return $this->_display->get_displayWidth();
    }

    /**
     * Returns the display height, in pixels.
     *
     * @return int  an integer corresponding to the display height, in pixels
     *
     * On failure, throws an exception or returns YDisplayLayer::DISPLAYHEIGHT_INVALID.
     */
    public function get_displayHeight(): int
    {
        return $this->_display->get_displayHeight();
    }

    /**
     * Returns the width of the layers to draw on, in pixels.
     *
     * @return int  an integer corresponding to the width of the layers to draw on, in pixels
     *
     * On failure, throws an exception or returns YDisplayLayer::LAYERWIDTH_INVALID.
     */
    public function get_layerWidth(): int
    {
        return $this->_display->get_layerWidth();
    }

    /**
     * Returns the height of the layers to draw on, in pixels.
     *
     * @return int  an integer corresponding to the height of the layers to draw on, in pixels
     *
     * On failure, throws an exception or returns YDisplayLayer::LAYERHEIGHT_INVALID.
     */
    public function get_layerHeight(): int
    {
        return $this->_display->get_layerHeight();
    }

    public function resetHiddenFlag(): int
    {
        $this->_hidden = false;
        return YAPI::SUCCESS;
    }

    //--- (end of generated code: YDisplayLayer implementation)
};
