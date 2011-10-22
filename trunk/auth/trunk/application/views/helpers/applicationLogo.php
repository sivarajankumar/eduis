<?php
/**
 * Sets the application logo.
 *
 */
class Zend_View_Helper_ApplicationLogo extends Zend_View_Helper_Abstract
{
    /**
     * @param string $theme
     * @param string $img_alt
     * @param string $class
     * @param string $imgFormat
     * @return string
     */
    public function applicationLogo ($theme = NULL, $img_alt = 'The College Name', $class = null, 
    $imgFormat = 'png')
    {
        $classString = NULL;
        if (! empty($class)) {
            $classes = NULL;
            if (is_string($class)) {
                $class = $this->view->escape($class);
                $classes = array($class);
            } else {
                throw new Exception('The class should be string or array', 
                Zend_Log::ERR);
            }
            $classString = ' class = "' . $this->view->escape($class) . '" ';
        }
        $imgHtmlString = '<img src="http://' . CDN_SERVER .'/images/logos/mainLogo_' . $theme . '.' . $imgFormat . '"' .
         					'alt="' .$img_alt . '" ' . $classString . '/>';
        return $imgHtmlString;
    }
}