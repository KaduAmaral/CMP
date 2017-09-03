<?php
/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace CMP\ConsoleOutput;
use \InvalidArgumentException;
/**
 * @author Jean-François Simon <contact@jfsimon.fr>
 */
class FormatterStyleStack {
    /**
     * @var FormatterStyle[]
     */
    private $styles;
    /**
     * @var FormatterStyle
     */
    private $emptyStyle;
    /**
     * Constructor.
     *
     * @param FormatterStyle|null $emptyStyle
     */
    public function __construct(FormatterStyle $emptyStyle = null)
    {
        $this->emptyStyle = $emptyStyle ?: new FormatterStyle();
        $this->reset();
    }
    /**
     * Resets stack (ie. empty internal arrays).
     */
    public function reset()
    {
        $this->styles = array();
    }
    /**
     * Pushes a style in the stack.
     *
     * @param FormatterStyle $style
     */
    public function push(FormatterStyle $style)
    {
        $this->styles[] = $style;
    }
    /**
     * Pops a style from the stack.
     *
     * @param FormatterStyle|null $style
     *
     * @return FormatterStyle
     *
     * @throws InvalidArgumentException When style tags incorrectly nested
     */
    public function pop(FormatterStyle $style = null)
    {
        if (empty($this->styles)) {
            return $this->emptyStyle;
        }
        if (null === $style) {
            return array_pop($this->styles);
        }
        foreach (array_reverse($this->styles, true) as $index => $stackedStyle) {
            if ($style->apply('') === $stackedStyle->apply('')) {
                $this->styles = array_slice($this->styles, 0, $index);
                return $stackedStyle;
            }
        }
        throw new InvalidArgumentException('Incorrectly nested style tag found.');
    }
    /**
     * Computes current style with stacks top codes.
     *
     * @return OutputFormatterStyle
     */
    public function getCurrent() {
        if (empty($this->styles)) {
            return $this->emptyStyle;
        }
        return $this->styles[count($this->styles) - 1];
    }
    /**
     * @param FormatterStyle $emptyStyle
     *
     * @return $this
     */
    public function setEmptyStyle(FormatterStyle $emptyStyle)
    {
        $this->emptyStyle = $emptyStyle;
        return $this;
    }
    /**
     * @return FormatterStyle
     */
    public function getEmptyStyle()
    {
        return $this->emptyStyle;
    }
}